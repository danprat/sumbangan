<!DOCTYPE html>
<html class="light" lang="id">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>@yield('title', 'Sumbangan') - Admin</title>
    <script src="https://cdn.tailwindcss.com?plugins=forms,container-queries"></script>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600;700&amp;family=Geist:wght@500;600&amp;display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&amp;display=swap" rel="stylesheet"/>
    <script id="tailwind-config">
        tailwind.config = {
            darkMode: "class",
            theme: {
                extend: {
                    "colors": {
                        "primary-fixed": "#cde5ff",
                        "outline-variant": "#c0c7d1",
                        "secondary-container": "#9defe3",
                        "progress-track": "#e0e3e5",
                        "tertiary-fixed": "#e1e3e5",
                        "surface-container-high": "#dce9ff",
                        "on-primary-fixed-variant": "#004a75",
                        "inverse-primary": "#95ccff",
                        "on-primary": "#ffffff",
                        "on-tertiary-fixed": "#191c1e",
                        "on-surface-variant": "#41474f",
                        "on-error-container": "#93000a",
                        "surface-container-lowest": "#ffffff",
                        "secondary-fixed": "#a0f1e6",
                        "on-tertiary": "#ffffff",
                        "surface-container-low": "#eff4ff",
                        "on-primary-fixed": "#001d32",
                        "background": "#f8f9ff",
                        "surface-bright": "#f8f9ff",
                        "inverse-on-surface": "#eaf1ff",
                        "surface-dim": "#ccdbf3",
                        "on-secondary-fixed-variant": "#005049",
                        "tertiary-container": "#494c4e",
                        "secondary-fixed-dim": "#84d5ca",
                        "on-secondary": "#ffffff",
                        "primary": "#00385a",
                        "error-container": "#ffdad6",
                        "primary-fixed-dim": "#95ccff",
                        "on-tertiary-fixed-variant": "#444749",
                        "on-secondary-fixed": "#00201d",
                        "on-surface": "#0d1c2e",
                        "inverse-surface": "#233144",
                        "on-tertiary-container": "#babcbe",
                        "surface": "#f8f9ff",
                        "secondary": "#016a61",
                        "tertiary": "#323537",
                        "on-secondary-container": "#0d6f66",
                        "surface-container-highest": "#d5e3fc",
                        "surface-container": "#e6eeff",
                        "on-background": "#0d1c2e",
                        "on-primary-container": "#8ac2f5",
                        "primary-container": "#00507d",
                        "error": "#ba1a1a",
                        "outline": "#717880",
                        "surface-tint": "#236391",
                        "on-error": "#ffffff",
                        "surface-variant": "#d5e3fc",
                        "tertiary-fixed-dim": "#c5c7c9"
                    },
                    "borderRadius": {
                        "DEFAULT": "0.125rem",
                        "lg": "0.25rem",
                        "xl": "0.5rem",
                        "full": "0.75rem"
                    },
                    "spacing": {
                        "lg": "40px",
                        "xs": "8px",
                        "max-width": "1200px",
                        "margin-mobile": "16px",
                        "xl": "64px",
                        "gutter": "24px",
                        "base": "4px",
                        "md": "24px",
                        "sm": "16px",
                        "margin-desktop": "auto"
                    },
                    "fontFamily": {
                        "display-lg-mobile": ["Inter"],
                        "body-md": ["Inter"],
                        "headline-md": ["Inter"],
                        "label-sm": ["Geist"],
                        "display-lg": ["Inter"],
                        "body-lg": ["Inter"],
                        "label-md": ["Geist"]
                    },
                    "fontSize": {
                        "display-lg-mobile": ["32px", { "lineHeight": "40px", "letterSpacing": "-0.01em", "fontWeight": "700" }],
                        "body-md": ["16px", { "lineHeight": "24px", "fontWeight": "400" }],
                        "headline-md": ["24px", { "lineHeight": "32px", "letterSpacing": "-0.01em", "fontWeight": "600" }],
                        "label-sm": ["12px", { "lineHeight": "16px", "letterSpacing": "0.05em", "fontWeight": "600" }],
                        "display-lg": ["48px", { "lineHeight": "56px", "letterSpacing": "-0.02em", "fontWeight": "700" }],
                        "body-lg": ["18px", { "lineHeight": "28px", "fontWeight": "400" }],
                        "label-md": ["14px", { "lineHeight": "20px", "letterSpacing": "0.02em", "fontWeight": "500" }]
                    }
                },
            },
        }
    </script>
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-background text-on-surface antialiased">
    <div class="relative isolate flex min-h-screen items-center justify-center overflow-hidden px-6 py-12">
        <div class="absolute inset-0 bg-[radial-gradient(circle_at_top,_rgba(148,204,255,0.2),_transparent_45%),radial-gradient(circle_at_bottom_right,_rgba(157,239,227,0.25),_transparent_35%)]"></div>

        <div class="relative w-full max-w-md space-y-6">
            <div class="text-center">
                <p class="text-label-sm font-label-sm uppercase tracking-[0.18em] text-primary">Admin panel</p>
                <h1 class="mt-3 text-display-lg-mobile font-display-lg text-on-background">Admin Login</h1>
                <p class="mt-3 text-body-md text-on-surface-variant">Masuk untuk mengelola campaign, verifikasi donasi, dan rekening tujuan transfer.</p>
            </div>

            @if ($errors->any())
                <x-admin.flash type="error" class="mb-4">
                    {{ $errors->first() }}
                </x-admin.flash>
            @endif

            <x-admin.card class="p-6 sm:p-8">
                <form action="{{ route('admin.login') }}" method="POST" class="space-y-6">
                    @csrf

                    <div>
                        <label for="email" class="block text-label-md font-label-md text-on-background">Email</label>
                        <div class="mt-2">
                            <x-admin.input type="email" name="email" :value="old('email')" required autofocus />
                        </div>
                    </div>

                    <div>
                        <label for="password" class="block text-label-md font-label-md text-on-background">Password</label>
                        <div class="mt-2">
                            <x-admin.input type="password" name="password" required />
                        </div>
                    </div>

                    <x-admin.button variant="primary" type="submit" class="flex w-full justify-center">
                        Login
                    </x-admin.button>
                </form>
            </x-admin.card>
        </div>
    </div>
</body>
</html>
