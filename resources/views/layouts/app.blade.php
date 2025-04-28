<!-- resources/views/layouts/app.blade.php -->
<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}" dir="rtl">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Laravel') }}</title>
    <script src="https://cdn.tailwindcss.com"></script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Cairo:wght@400;600;700&display=swap" rel="stylesheet">

    <style>
        body, h1, h2, h3, h4, h5, h6, p, span, a, button, input, textarea, select {
            font-family: 'Cairo', sans-serif !important;
        }
    </style>
</head>
<body class="bg-gray-100 font-sans">
    <div class="min-h-screen">
        @include('layouts.navigation')
        <main class="container mx-auto p-4">
            @yield('content')
        </main>
    </div>
</body>
</html>