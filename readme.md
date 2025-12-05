# Intelligent Lead Generation Agent (Laravel + Google ADK)

An AI-powered, research-driven lead generation system built with **Laravel** and a **Python microservice** using the **Google Agent Development Kit (ADK)**.

---

## Features

- Intelligent Google Search–powered research  
- Structured lead extraction (company, website, industry, hiring status, etc.)  
- Scoring model for relevance  
- Laravel UI + MySQL storage  
- Python ADK microservice acting as the AI engine  

---

## Project Structure

```
project-root/
│
├── laravel-app/
│   ├── app/
│   ├── routes/
│   ├── resources/
│   ├── database/
│   └── vendor/
│
└── lead-agent/
    ├── main.py
    ├── lead_schema.py
    ├── venv/
    └── .env
```

---

## Installation & Setup

### Clone the repo

```bash
git clone https://github.com/your-username/your-repo.git
cd intelligent-leadgen-agent-laravel
```

---

## Laravel Setup

```bash
composer install
cp .env.example .env
php artisan key:generate
php artisan migrate
php artisan serve
```

---

## Python ADK Agent Setup

```bash
cd lead-agent
python -m venv venv
```

Activate:

**Windows:**

```bash
venv\Scripts\activate
```

**Mac/Linux:**

```bash
source venv/bin/activate
```

Install dependencies:

```bash
pip install google-adk google-genai fastapi uvicorn python-dotenv
```

Create `.env`:

```
GOOGLE_API_KEY=YOUR_KEY
GOOGLE_GENAI_USE_VERTEXAI=FALSE
```

Run the agent:

```bash
uvicorn main:app --reload --port 8001
```

---

## Laravel → Python Connection

In Laravel `.env`:

```
LEAD_AGENT_URL=http://127.0.0.1:8001/run
```

Laravel sends:

```json
{ "goal": "Find SaaS companies hiring Laravel developers" }
```

Python returns structured leads.

---

## Usage

1. Start Laravel  
2. Start Python agent  
3. Open:

```
http://localhost:8000/lead/search
```

4. Enter a query such as:

```
Find SaaS companies in Europe hiring remote Laravel developers
```

Leads will be saved and listed.

---

## Roadmap

- Webpage browsing extraction  
- Lead enrichment (emails, LinkedIn, funding)  
- Export to CSV/Excel  
- Queued processing in Laravel  
- Dashboard with filters and charts  

---

## Credits

Built by **Vivek Chandra Pandey**
