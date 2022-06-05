<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title>@yield('title', 'Time management')</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>

<body class="font-sans text-lg">
@yield('content')
</body>
</html>
