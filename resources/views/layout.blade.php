<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Quicksand:wght@500&display=swap" rel="stylesheet">

    <link href="{{ mix('css/app.css') }}" rel="stylesheet">

    <title>@yield('title', 'Time management')</title>

    <style>
        body {
            font-family: 'Quicksand', sans-serif;
        }

        .cursor-default {
            background-color: cornflowerblue !important;
            color: white !important;
        }
    </style>
    @yield('root-style')
</head>

<body class="text-lg">

@yield('root-content')

<script src="{{ mix('js/app.js') }}"></script>

</body>
</html>
