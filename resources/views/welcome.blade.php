<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ env('APP_NAME') }}</title>
</head>
<body class="antialiased">
<h1>Techdiary API V3</h1>
<a href="{{ env('CLIENT_URL') }}">{{ env('CLIENT_URL') }}</a>
</body>
</html>
