<!DOCTYPE html>
<html class="light" lang="en">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>@yield('title', 'Admin Dashboard') - Sumbangan</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com" rel="preconnect"/>
    <link crossorigin="" href="https://fonts.gstatic.com" rel="preconnect"/>
    <link href="https://fonts.googleapis.com/css2?family=Geist:wght@500;600&amp;family=Inter:wght@400;600;700&amp;display=swap" rel="stylesheet"/>

    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    "colors": {
                        "surface": "#f8f9ff",
                        "surface-container-high": "#dce9ff",
                        "on-tertiary-fixed-variant": "#444749",
                        "tertiary-fixed-dim": "#c4c7c9",
                        "tertiary": "#494c4e",
                        "on-secondary-container": "#006f66",
                        "on-secondary": "#ffffff",
                        "background": "#f8f9ff",
                        "surface-container-low": "#eff4ff",
                        "on-background": "#0d1c2e",
                        "secondary-container": "#86f2e4",
                        "tertiary-fixed": "#e0e3e5",
                        "inverse-surface": "#233144",
                        "on-primary-container": "#cbe4ff",
                        "on-secondary-fixed": "#00201d",
                        "primary-fixed": "#cde5ff",
                        "on-tertiary-container": "#dfe1e3",
                        "surface-container": "#e6eeff",
                        "surface-tint": "#006399",
                        "on-primary-fixed": "#001d32",
                        "on-secondary-fixed-variant": "#005049",
                        "primary": "#00507d",
                        "secondary": "#006a61",
                        "outline": "#707881",
                        "secondary-fixed": "#89f5e7",
                        "surface-variant": "#d5e3fc",
                        "surface-container-lowest": "#ffffff",
                        "on-tertiary-fixed": "#191c1e",
                        "error": "#ba1a1a",
                        "error-container": "#ffdad6",
                        "on-primary": "#ffffff",
                        "primary-container": "#0369a1",
                        "surface-dim": "#ccdbf3",
                        "outline-variant": "#c0c7d1",
                        "surface-container-highest": "#d5e3fc",
                        "on-primary-fixed-variant": "#004b74",
                        "on-error": "#ffffff",
                        "surface-bright": "#f8f9ff",
                        "on-surface": "#0d1c2e",
                        "secondary-fixed-dim": "#6bd8cb",
                        "inverse-primary": "#94ccff",
                        "tertiary-container": "#616466",
                        "on-error-container": "#93000a",
                        "on-surface-variant": "#40474f",
                        "on-tertiary": "#ffffff",
                        "inverse-on-surface": "#eaf1ff",
                        "primary-fixed-dim": "#94ccff"
                    },
                    "borderRadius": {
                        "DEFAULT": "0.25rem",
                        "lg": "0.5rem",
                        "xl": "0.75rem",
                        "full": "9999px"
                    },
                    "spacing": {
                        "xl": "64px",
                        "lg": "40px",
                        "sm": "16px",
                        "margin-desktop": "auto",
                        "base": "4px",
                        "xs": "8px",
                        "gutter": "24px",
                        "max-width": "1200px",
                        "margin-mobile": "16px",
                        "md": "24px"
                    },
                    "fontFamily": {
                        "label-md": ["Geist"],
                        "display-lg-mobile": ["Inter"],
                        "headline-md": ["Inter"],
                        "body-lg": ["Inter"],
                        "display-lg": ["Inter"],
                        "body-md": ["Inter"],
                        "label-sm": ["Geist"]
                    },
                    "fontSize": {
                        "label-md": ["14px", { "lineHeight": "20px", "letterSpacing": "0.02em", "fontWeight": "500" }],
                        "display-lg-mobile": ["32px", { "lineHeight": "40px", "letterSpacing": "-0.01em", "fontWeight": "700" }],
                        "headline-md": ["24px", { "lineHeight": "32px", "letterSpacing": "-0.01em", "fontWeight": "600" }],
                        "body-lg": ["18px", { "lineHeight": "28px", "fontWeight": "400" }],
                        "display-lg": ["48px", { "lineHeight": "56px", "letterSpacing": "-0.02em", "fontWeight": "700" }],
                        "body-md": ["16px", { "lineHeight": "24px", "fontWeight": "400" }],
                        "label-sm": ["12px", { "lineHeight": "16px", "letterSpacing": "0.05em", "fontWeight": "600" }]
                    }
                },
            },
        }
    </script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-background font-body-md text-on-background">
    <div class="min-h-screen lg:flex">
        <nav class="border-b border-outline-variant bg-surface-container-low/95 px-sm py-sm lg:fixed lg:inset-y-0 lg:left-0 lg:z-20 lg:w-72 lg:border-b-0 lg:border-r lg:px-md lg:py-md">
            <div class="flex items-center justify-between gap-3 lg:mb-lg lg:block">
                <div>
                    <p class="text-label-sm font-label-sm uppercase tracking-[0.18em] text-on-surface-variant">Admin panel</p>
                    <h1 class="mt-1 text-headline-md font-headline-md text-primary">Sumbangan</h1>
                    <p class="mt-2 hidden text-body-md text-on-surface-variant lg:block">Kelola campaign, donasi, dan rekening tujuan dari satu tempat.</p>
                </div>
                <a href="{{ route('admin.campaigns.create') }}" class="inline-flex items-center justify-center gap-2 rounded-lg bg-primary px-4 py-2.5 text-label-md font-label-md font-semibold text-on-primary transition-colors hover:bg-primary-container hover:text-on-primary-container lg:hidden">
                    <span class="material-symbols-outlined text-lg">add</span>
                    Campaign
                </a>
            </div>

            <ul class="mt-sm grid gap-2 lg:mt-0">
                <li>
                    <a class="{{ request()->routeIs('admin.dashboard') ? 'bg-surface-container-high text-primary shadow-sm' : 'text-on-surface-variant hover:bg-surface-container hover:text-on-background' }} flex items-center gap-3 rounded-xl px-4 py-3 transition-all" href="{{ route('admin.dashboard') }}">
                        <span class="material-symbols-outlined">dashboard</span>
                        <span class="text-label-md font-label-md">Dashboard</span>
                    </a>
                </li>
                <li>
                    <a class="{{ request()->routeIs('admin.campaigns.*') ? 'bg-surface-container-high text-primary shadow-sm' : 'text-on-surface-variant hover:bg-surface-container hover:text-on-background' }} flex items-center gap-3 rounded-xl px-4 py-3 transition-all" href="{{ route('admin.campaigns.index') }}">
                        <span class="material-symbols-outlined">volunteer_activism</span>
                        <span class="text-label-md font-label-md">Campaigns</span>
                    </a>
                </li>
                <li>
                    <a class="{{ request()->routeIs('admin.donations.*') ? 'bg-surface-container-high text-primary shadow-sm' : 'text-on-surface-variant hover:bg-surface-container hover:text-on-background' }} flex items-center gap-3 rounded-xl px-4 py-3 transition-all" href="{{ route('admin.donations.index') }}">
                        <span class="material-symbols-outlined">payments</span>
                        <span class="text-label-md font-label-md">Donations</span>
                    </a>
                </li>
                <li>
                    <a class="{{ request()->routeIs('admin.bank-accounts.*') ? 'bg-surface-container-high text-primary shadow-sm' : 'text-on-surface-variant hover:bg-surface-container hover:text-on-background' }} flex items-center gap-3 rounded-xl px-4 py-3 transition-all" href="{{ route('admin.bank-accounts.index') }}">
                        <span class="material-symbols-outlined">account_balance</span>
                        <span class="text-label-md font-label-md">Bank Accounts</span>
                    </a>
                </li>
            </ul>

            <div class="mt-md hidden lg:block">
                <a href="{{ route('admin.campaigns.create') }}" class="inline-flex w-full items-center justify-center gap-2 rounded-lg bg-primary px-4 py-3 text-label-md font-label-md font-semibold text-on-primary transition-colors hover:bg-primary-container hover:text-on-primary-container">
                    <span class="material-symbols-outlined">add</span>
                    New Campaign
                </a>
            </div>
        </nav>

        <div class="flex-1 lg:ml-72">
            <header class="sticky top-0 z-10 border-b border-outline-variant bg-surface-container-lowest/95 backdrop-blur">
                <div class="mx-auto flex h-16 max-w-max-width items-center justify-between gap-4 px-md">
                    <div>
                        <p class="text-label-sm font-label-sm uppercase tracking-[0.18em] text-on-surface-variant">Admin workspace</p>
                        <span class="text-label-md font-label-md text-on-background">@yield('title', 'Admin Dashboard')</span>
                    </div>
                    <div class="flex items-center gap-3">
                        <div class="hidden text-right sm:block">
                            <p class="text-label-md font-label-md text-on-background">{{ Auth::user()->name ?? 'Admin' }}</p>
                            <p class="text-label-sm font-label-sm text-on-surface-variant">Administrator</p>
                        </div>
                        <div class="flex h-10 w-10 items-center justify-center rounded-full border border-outline-variant bg-surface-container-high text-label-md font-label-md font-semibold text-primary">
                            {{ strtoupper(substr(Auth::user()->name ?? 'Admin', 0, 1)) }}
                        </div>
                        <form action="{{ route('admin.logout') }}" method="POST">
                            @csrf
                            <button type="submit" class="inline-flex items-center gap-2 rounded-lg border border-outline-variant bg-surface-container-lowest px-3 py-2 text-label-md font-label-md text-on-surface-variant transition-colors hover:bg-surface-container hover:text-primary">
                                <span class="material-symbols-outlined text-lg">logout</span>
                                <span class="hidden sm:inline">Logout</span>
                            </button>
                        </form>
                    </div>
                </div>
            </header>

            <main class="px-md py-md lg:px-lg lg:py-lg">
                <div class="mx-auto max-w-max-width space-y-4">
                    @if (session('success'))
                        <x-admin.flash type="success">
                            {{ session('success') }}
                        </x-admin.flash>
                    @endif

                    @if (session('error'))
                        <x-admin.flash type="error">
                            {{ session('error') }}
                        </x-admin.flash>
                    @endif

                    @yield('content')
                </div>
            </main>
        </div>
    </div>
</body>
</html>
