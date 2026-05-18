<!DOCTYPE html>
<html lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>{{ config('app.name', 'RateIt') }}</title>
    <link rel="preconnect" href="https://fonts.bunny.net">
    <link href="https://fonts.bunny.net/css?family=inter:400,500,600,700,800&display=swap" rel="stylesheet" />
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="font-sans antialiased bg-slate-50">

    <div class="min-h-screen flex flex-col sm:justify-center items-center pt-8 pb-12 px-4">

        <!-- Logo -->
        <a href="{{ route('home') }}" class="flex items-center gap-2 mb-8">
            <span class="text-3xl">⭐</span>
            <span class="text-2xl font-extrabold text-indigo-700 tracking-tight">RateIt</span>
        </a>

        <!-- Card -->
        <div class="w-full max-w-md bg-white rounded-2xl border border-slate-200 shadow-sm overflow-hidden">
            {{ $slot }}
        </div>

        <p class="mt-6 text-sm text-slate-400">
            <a href="{{ route('home') }}" class="hover:text-indigo-600 transition-colors">← Back to home</a>
        </p>
    </div>

</body>
</html>
