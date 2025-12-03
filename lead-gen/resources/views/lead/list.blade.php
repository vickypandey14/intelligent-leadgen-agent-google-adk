<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Document</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css" integrity="sha512-iecdLmaskl7CVkqkXNQ/Z1srPv7lOy7C2vN+XSsCZc+FqH/s6cIFN9bGr1HmAg4fQkPCm2LBxH73VQKXhYwNkg==" crossorigin="anonymous" referrerpolicy="no-referrer" />
</head>
<body>
    
    <h2>Leads</h2>

    <table border="1" cellpadding="5">
        @foreach($leads as $lead)
        <tr>
            <td>{{ $lead->company_name }}</td>
            <td>{{ $lead->website }}</td>
            <td>{{ $lead->location }}</td>
            <td>{{ $lead->industry }}</td>
            <td>{{ $lead->score }}</td>
        </tr>
        @endforeach
    </table>


</body>
</html>