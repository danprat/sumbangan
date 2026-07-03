<!DOCTYPE html>
<html lang="id" class="h-full bg-gray-50">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Sumbangan')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-full">
    <nav class="bg-white shadow-sm border-b border-gray-200">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="flex h-16 justify-between items-center">
                <a href="/" class="text-xl font-bold text-indigo-600">
                    Sumbangan
                </a>
            </div>
        </div>
    </nav>

    <main class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-8">
        @yield('content')
    </main>

    <footer class="border-t border-gray-200 bg-white mt-12">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-6">
            <p class="text-center text-sm text-gray-500">&copy; {{ date('Y') }} Sumbangan. Semua donasi dikelola dengan amanah.</p>
        </div>
    </footer>
</body>
</html>
