<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Lead Search</title>
</head>
<body>
    <h1>Lead Search</h1>
    <form action="{{ route('lead.search.run') }}" method="POST">
    @csrf

        <label>What leads do you want?</label>
        <textarea name="goal" rows="4" required>{{ old('goal') }}</textarea>

        <button type="submit">Search</button>
    </form>
</body>
</html>