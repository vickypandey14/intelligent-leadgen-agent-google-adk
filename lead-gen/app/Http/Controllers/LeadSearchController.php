<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use App\Services\LeadAgentClient;
use Illuminate\Http\Request;

class LeadSearchController extends Controller
{
    public function index()
    {
        return view('lead.search');
    }

    public function search(Request $request, LeadAgentClient $agent)
    {
        $request->validate([
            'goal' => ['required', 'string', 'max:2000'],
        ]);

        $data = $agent->sendQuery($request->goal);

        foreach ($data['leads'] as $lead) {
            Lead::create([
                'query' => $data['query'],
                'company_name' => $lead['company_name'] ?? null,
                'website' => $lead['website'] ?? null,
                'location' => $lead['location'] ?? null,
                'industry' => $lead['industry'] ?? null,
                'score' => $lead['score'] ?? null,
            ]);
        }

        return redirect()->route('lead.list');
    }

    public function list()
    {
        $leads = Lead::latest()->get();
        return view('lead.list', compact('leads'));
    }
}
