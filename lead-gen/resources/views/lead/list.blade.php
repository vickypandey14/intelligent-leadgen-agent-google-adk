<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Leads List</title>

    <!-- Font Awesome -->
    <link rel="stylesheet"
          href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css"
          integrity="sha512-iecdLmaskl7CVkqkXNQ/Z1srPv7lOy7C2vN+XSsCZc+FqH/s6cIFN9bGr1HmAg4fQkPCm2LBxH73VQKXhYwNkg=="
          crossorigin="anonymous" referrerpolicy="no-referrer" />

    <style>
        body {
            margin: 0;
            padding: 20px;
            font-family: "Segoe UI", Tahoma, Geneva, Verdana, sans-serif;
            background: #f5f6fa;
        }

        h2 {
            text-align: center;
            margin-bottom: 25px;
            color: #333;
        }

        .table-container {
            max-width: 95%;
            margin: auto;
            overflow-x: auto;
            background: white;
            padding: 15px;
            border-radius: 10px;
            box-shadow: 0 3px 10px rgba(0,0,0,0.1);
        }

        table {
            width: 100%;
            border-collapse: collapse;
            min-width: 1200px;
        }

        th {
            background: #2c3e50;
            color: white;
            padding: 12px;
            text-align: left;
            font-size: 15px;
            white-space: nowrap;
        }

        td {
            padding: 10px;
            background: #ffffff;
            border-bottom: 1px solid #ececec;
            font-size: 14px;
        }

        tr:hover td {
            background: #f1f8ff;
        }

        a {
            color: #2980b9;
            text-decoration: none;
        }
        a:hover {
            text-decoration: underline;
        }

        .score {
            font-weight: bold;
            color: #16a085;
        }
    </style>

</head>
<body>

<h2><i class="fa-solid fa-database"></i> Leads Extracted</h2>

<div class="table-container">
    <table>
        <thead>
            <tr>
                <th>Company Name</th>
                <th>Website</th>
                <th>Location</th>
                <th>Industry</th>
                <th>Contact Email</th>
                <th>LinkedIn</th>
                <th>Decision Makers</th>
                <th>Hiring Status</th>
                <th>Technology Stack</th>
                <th>Score</th>
                <th>Notes</th>
                <th>Query</th>
                <th>Created At</th>
            </tr>
        </thead>

        <tbody>
            @foreach($leads as $lead)
            <tr>
                <td>{{ $lead->company_name }}</td>

                <td>
                    @if($lead->website)
                        <a href="{{ $lead->website }}" target="_blank">
                            <i class="fa-solid fa-link"></i> Visit
                        </a>
                    @endif
                </td>

                <td>{{ $lead->location }}</td>
                <td>{{ $lead->industry }}</td>
                <td>{{ $lead->contact_email }}</td>

                <td>
                    @if($lead->linkedin)
                        <a href="{{ $lead->linkedin }}" target="_blank">
                            <i class="fa-brands fa-linkedin"></i> Profile
                        </a>
                    @endif
                </td>

                <td>
                    @if($lead->decision_makers)
                        @foreach(json_decode($lead->decision_makers, true) as $dm)
                            • {{ $dm }} <br>
                        @endforeach
                    @endif
                </td>

                <td>{{ $lead->hiring_status }}</td>

                <td>
                    @if($lead->technology_stack)
                        @foreach(json_decode($lead->technology_stack, true) as $tech)
                            <span style="background:#d5e8ff; padding:4px 8px; border-radius:5px; margin:2px; display:inline-block;">
                                {{ $tech }}
                            </span>
                        @endforeach
                    @endif
                </td>

                <td class="score">{{ $lead->score }}</td>

                <td>{{ $lead->notes }}</td>

                <td>{{ $lead->query }}</td>

                <td>{{ $lead->created_at->format('Y-m-d H:i') }}</td>
            </tr>
            @endforeach
        </tbody>
    </table>
</div>

</body>
</html>
