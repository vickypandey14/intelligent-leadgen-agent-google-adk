<?php

namespace App\Services;

use GuzzleHttp\Client;

class LeadAgentClient
{
    public function sendQuery(string $goal)
    {
        if (!$goal || $goal === "") {
            throw new \Exception("Goal cannot be empty");
        }

        $client = new Client();

        $response = $client->post(env('LEAD_AGENT_URL'), [
            'json' => [
                'goal' => $goal
            ]
        ]);

        return json_decode($response->getBody(), true);
    }
}
