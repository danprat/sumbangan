<!DOCTYPE html>
<html lang="id" class="h-full bg-gray-50">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title>@yield('title', 'Sumbangan') — Admin</title>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="h-full">
<div class="flex min-h-full flex-col justify-center px-6 py-12 lg:px-8">
    <div class="sm:mx-auto sm:w-full sm:max-w-sm">
        <h2 class="text-center text-2xl font-bold tracking-tight text-gray-900">Admin Login</h2>
    </div>

    <div class="mt-10 sm:mx-auto sm:w-full sm:max-w-sm">
        @if ($errors->any())
            <x-admin.flash type="error" class="mb-4">
                {{ $errors->first() }}
            </x-admin.flash>
        @endif

        <x-admin.card class="p-6">
        <form action="{{ route('admin.login') }}" method="POST" class="space-y-6">
            @csrf

            <div>
                <label for="email" class="block text-sm font-medium text-gray-900">Email</label>
                <div class="mt-2">
                    <x-admin.input type="email" name="email" :value="old('email')" required autofocus />
                </div>
            </div>

            <div>
                <label for="password" class="block text-sm font-medium text-gray-900">Password</label>
                <div class="mt-2">
                    <x-admin.input type="password" name="password" required />
                </div>
            </div>

            <div>
                <x-admin.button variant="primary" type="submit" class="flex w-full justify-center">
                    Login
                </x-admin.button>
            </div>
        </form>
        </x-admin.card>
    </div>
</div>
</body>
</html>
