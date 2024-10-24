<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">

    <title inertia>{{ config('app.name', 'Laravel') }}</title>

    <!-- Fonts -->

    <!-- CSS -->
    <link rel="stylesheet" href="/css/zero.css">
    <link rel="stylesheet" href="/css/style.css">
    <link rel="stylesheet" href="/assets/css/all.css">

    <!-- JS -->
    @routes
</head>

<body class="font-sans antialiased app">
    @inertia

    @vite(['resources/js/app.js'])
</body>

</html>
