import json
import os
from typing import Optional

from fastapi import FastAPI, HTTPException
from pydantic import BaseModel
from dotenv import load_dotenv

from lead_schema import LeadResponse

# --- Load .env containing GOOGLE_API_KEY ---
load_dotenv()

# --- ADK / Gemini imports ---
from google.adk.agents import Agent
from google.adk.runners import Runner
from google.adk.sessions import InMemorySessionService
from google.adk.tools import google_search
from google.genai import types as genai_types


app = FastAPI()


# ---------- Request body from Laravel ----------
class QueryModel(BaseModel):
    goal: str


# ---------- ADK Agent setup ----------
APP_NAME = "lead_research_app"
USER_ID = "demo_user"
SESSION_ID = "demo_session"

root_agent = Agent(
    name="lead_research_agent",
    model="gemini-2.0-flash",  # you can use gemini-2.5-flash if available
    description=(
        "Agent that researches the web for B2B leads using Google Search "
        "and returns a structured JSON list of leads."
    ),
    instruction=(
        "You are a senior B2B lead research analyst.\n"
        "User will give a GOAL describing what kind of leads they want.\n\n"

        "Your job:\n"
        "1) Use the google_search tool to research the web.\n"
        "2) Identify the most relevant companies / leads for that goal.\n"
        "3) For each lead, infer as much as possible:\n"
        "   - company_name\n"
        "   - website\n"
        "   - location\n"
        "   - industry\n"
        "   - contact_email\n"
        "   - linkedin\n"
        "   - decision_makers\n"
        "   - hiring_status\n"
        "   - technology_stack\n"
        "   - notes\n"
        "   - score (0–100 relevance to the goal)\n\n"

        "RETURN FORMAT RULES (VERY IMPORTANT):\n"
        "- Your final response MUST be ONLY valid raw JSON.\n"
        "- DO NOT wrap JSON in ```json or ``` or any markdown fencing.\n"
        "- DO NOT add headings, explanations, or comments.\n"
        "- Output MUST be a single JSON object matching this schema:\n"
        "  {\n"
        "    \"query\": string,\n"
        "    \"leads\": [\n"
        "      {\n"
        "        \"company_name\": string | null,\n"
        "        \"website\": string | null,\n"
        "        \"location\": string | null,\n"
        "        \"industry\": string | null,\n"
        "        \"contact_email\": string | null,\n"
        "        \"linkedin\": string | null,\n"
        "        \"decision_makers\": [string] | null,\n"
        "        \"hiring_status\": string | null,\n"
        "        \"technology_stack\": [string] | null,\n"
        "        \"notes\": string | null,\n"
        "        \"score\": int | null\n"
        "      }\n"
        "    ]\n"
        "  }\n"
        "- If unsure about a field, set it to null.\n"
    ),
    tools=[google_search],
)

session_service = InMemorySessionService()
runner = Runner(agent=root_agent, app_name=APP_NAME, session_service=session_service)


# ---------- Agent runner function ----------
async def run_lead_agent(goal: str) -> LeadResponse:
    await session_service.create_session(
        app_name=APP_NAME,
        user_id=USER_ID,
        session_id=SESSION_ID,
    )

    prompt = f"GOAL: {goal}"

    message = genai_types.Content(
        role="user",
        parts=[genai_types.Part(text=prompt)],
    )

    events = runner.run_async(
        user_id=USER_ID,
        session_id=SESSION_ID,
        new_message=message,
    )

    final_text: Optional[str] = None

    async for event in events:
        if event.is_final_response() and event.content and event.content.parts:
            part = event.content.parts[0]
            if getattr(part, "text", None):
                final_text = part.text

    if not final_text:
        raise RuntimeError("Agent did not return a final response")

    # -------- JSON CLEANING (Fixes backticks / markdown) --------
    clean = final_text.strip()

    # Remove markdown fences like ```json ... ```
    if clean.startswith("```"):
        clean = clean.strip("`")
        clean = clean.replace("json", "", 1).strip()

    # Remove stray backticks
    clean = clean.replace("```", "").strip("`").strip()

    # Try parsing cleaned text
    try:
        parsed = json.loads(clean)
    except json.JSONDecodeError as e:
        raise RuntimeError(f"Agent returned non-JSON: {clean[:300]}") from e

    # Validate using Pydantic schema
    return LeadResponse(**parsed)


# ---------- FastAPI endpoint consumed by Laravel ----------
@app.post("/run", response_model=LeadResponse)
async def run_endpoint(query: QueryModel):
    if not query.goal:
        raise HTTPException(status_code=400, detail="goal is required")

    try:
        return await run_lead_agent(query.goal)
    except Exception as e:
        raise HTTPException(status_code=500, detail=str(e))
