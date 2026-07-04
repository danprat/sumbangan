<!DOCTYPE html>
<html lang="id" class="h-full bg-gray-50">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Dashboard') — Admin Sumbangan</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="h-full">
<div class="flex h-full">
    <!-- Sidebar -->
    <div class="flex w-64 flex-col bg-gray-900">
        <div class="flex h-16 shrink-0 items-center px-6">
            <span class="text-lg font-bold text-white">Admin Panel</span>
        </div>
        <nav class="flex flex-1 flex-col px-4 pb-4">
            <ul role="list" class="flex flex-1 flex-col gap-y-1">
                <li>
                    <a href="{{ route('admin.dashboard') }}"
                       class="group flex gap-x-3 rounded-md p-2 text-sm font-semibold {{ request()->routeIs('admin.dashboard') ? 'bg-gray-800 text-white' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
                        Dashboard
                    </a>
                </li>

                <li>
                    <a href="{{ route('admin.campaigns.index') }}"
                       class="group flex gap-x-3 rounded-md p-2 text-sm font-semibold {{ request()->routeIs('admin.campaigns.*') ? 'bg-gray-800 text-white' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
                        Campaign
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.donations.index') }}"
                       class="group flex gap-x-3 rounded-md p-2 text-sm font-semibold {{ request()->routeIs('admin.donations.*') ? 'bg-gray-800 text-white' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
                        Donasi
                    </a>
                </li>
                <li>
                    <a href="{{ route('admin.bank-accounts.index') }}"
                       class="group flex gap-x-3 rounded-md p-2 text-sm font-semibold {{ request()->routeIs('admin.bank-accounts.*') ? 'bg-gray-800 text-white' : 'text-gray-400 hover:bg-gray-800 hover:text-white' }}">
                        Rekening Bank
                    </a>
                </li>
                <li class="mt-auto">
                    <form action="{{ route('admin.logout') }}" method="POST">
                        @csrf
                        <x-admin.button variant="secondary" type="submit" class="w-full justify-start gap-x-3">
                            Logout
                        </x-admin.button>
                    </form>
                </li>
            </ul>
        </nav>
    </div>

    <!-- Main content -->
    <main class="flex-1 overflow-y-auto p-8">
        @if (session('success'))
            <x-admin.flash type="success" class="mb-6">
                {{ session('success') }}
            </x-admin.flash>
        @endif

        @if (session('error'))
            <x-admin.flash type="error" class="mb-6">
                {{ session('error') }}
            </x-admin.flash>
        @endif

        @yield('content')
    </main>
</div>
</body>
</html>
