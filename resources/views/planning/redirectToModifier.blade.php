<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Redirection...</title>
</head>
<body>
    <form id="redirectForm" action="{{ route('ModifierPlanning') }}" method="POST">
        @csrf
        <input type="hidden" name="session_id" value="{{ $session_id }}">
        <input type="hidden" name="type" value="{{ $type }}">
    </form>
    <script>
        document.getElementById('redirectForm').submit();
    </script>
</body>
</html>
