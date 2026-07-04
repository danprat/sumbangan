<!DOCTYPE html>
<html lang="id" class="h-full bg-gray-50">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Sumbangan')</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-full flex flex-col font-sans antialiased text-gray-900 bg-gray-50">
    <nav class="bg-white/80 backdrop-blur-md sticky top-0 z-50 shadow-sm border-b border-gray-100">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8">
            <div class="flex h-16 justify-between items-center w-full">
                <a href="/" class="flex items-center gap-2">
                    <svg class="w-8 h-8 text-indigo-600" fill="currentColor" viewBox="0 0 24 24">
                         <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                    </svg>
                    <span class="text-xl font-bold bg-gradient-to-r from-indigo-600 to-purple-600 bg-clip-text text-transparent">
                        Sumbangan
                    </span>
                </a>
                
                <div class="hidden sm:flex items-center gap-4">
                    <a href="{{ route('donation.track.index') }}" class="text-sm font-medium text-gray-500 hover:text-indigo-600 transition">
                        Lacak Donasi
                    </a>
                </div>
            </div>
        </div>
    </nav>

    <main class="flex-grow mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-8 w-full">
        @yield('content')
    </main>

    <footer class="bg-white border-t border-gray-100 mt-auto">
        <div class="mx-auto max-w-7xl px-4 sm:px-6 lg:px-8 py-12">
            <div class="grid grid-cols-1 md:grid-cols-3 gap-8">
                <div>
                    <div class="flex items-center gap-2 mb-4">
                        <svg class="w-6 h-6 text-indigo-600" fill="currentColor" viewBox="0 0 24 24">
                            <path d="M12 21.35l-1.45-1.32C5.4 15.36 2 12.28 2 8.5 2 5.42 4.42 3 7.5 3c1.74 0 3.41.81 4.5 2.09C13.09 3.81 14.76 3 16.5 3 19.58 3 22 5.42 22 8.5c0 3.78-3.4 6.86-8.55 11.54L12 21.35z"/>
                        </svg>
                        <span class="text-lg font-bold text-gray-900">Sumbangan</span>
                    </div>
                    <p class="text-sm text-gray-500">Platform donasi online terpercaya untuk membantu sesama yang membutuhkan.</p>
                </div>
                <div>
                    <h3 class="font-semibold text-gray-900 mb-4">Tautan Cepat</h3>
                    <ul class="space-y-2 text-sm text-gray-500">
                        <li><a href="/" class="hover:text-indigo-600 transition">Beranda</a></li>
                        <li><a href="{{ route('donation.track.index') }}" class="hover:text-indigo-600 transition">Lacak Donasi</a></li>
                    </ul>
                </div>
                <div>
                    <h3 class="font-semibold text-gray-900 mb-4">Hubungi Kami</h3>
                    <p class="text-sm text-gray-500">Email: support@sumbangan.id</p>
                </div>
            </div>
            <div class="border-t border-gray-100 mt-8 pt-8 text-center text-sm text-gray-500">
                &copy; {{ date('Y') }} Sumbangan. Semua donasi dikelola dengan amanah.
            </div>
        </div>
    </footer>
</body>
</html>
