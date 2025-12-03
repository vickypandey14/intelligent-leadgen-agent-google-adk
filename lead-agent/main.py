from fastapi import FastAPI
from pydantic import BaseModel
from lead_schema import Lead, LeadResponse

app = FastAPI()

class QueryModel(BaseModel):
    goal: str

@app.post("/run")
def run_agent(query: QueryModel):
    # Return a dummy lead for now to test Laravel connectivity
    sample = Lead(
        company_name="Test Company",
        website="https://example.com",
        location="USA",
        industry="Software",
        score=90
    )

    return LeadResponse(
        query=query.goal,
        leads=[sample]
    )
