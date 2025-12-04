# lead_schema.py
from pydantic import BaseModel
from typing import List, Optional

class Lead(BaseModel):
    company_name: Optional[str] = None
    website: Optional[str] = None
    location: Optional[str] = None
    industry: Optional[str] = None
    contact_email: Optional[str] = None
    linkedin: Optional[str] = None
    decision_makers: Optional[List[str]] = None
    hiring_status: Optional[str] = None
    technology_stack: Optional[List[str]] = None
    notes: Optional[str] = None
    score: Optional[int] = None

class LeadResponse(BaseModel):
    query: str
    leads: List[Lead]
