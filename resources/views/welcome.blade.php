<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>{{ config('app.name', 'Sumbangan') }}</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
    <meta http-equiv="refresh" content="0;url={{ url('/') }}">
</head>
<body class="bg-gray-50 flex items-center justify-center min-h-screen">
    <p class="text-gray-500">Mengalihkan ke <a href="{{ url('/') }}" class="text-indigo-600 underline">halaman utama</a>...</p>
</body>
</html>
