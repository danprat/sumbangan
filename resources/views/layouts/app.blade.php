<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <title>@yield('title', 'Sumbangan - Transparent Giving')</title>
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
<body class="bg-background text-on-surface antialiased">
    <!-- TopNavBar -->
    <header class="fixed top-0 w-full z-50 bg-surface/80 dark:bg-surface-dim/80 backdrop-blur-md shadow-sm dark:shadow-none transition-all duration-300 ease-in-out">
        <div class="flex justify-between items-center h-16 max-w-max-width mx-auto px-margin-mobile md:px-margin-desktop">
            <a href="{{ route('campaigns.index') }}" class="font-headline-md text-headline-md font-bold text-primary dark:text-inverse-primary">
                Sumbangan
            </a>
            <nav class="hidden md:flex gap-gutter items-center">
                <a class="text-on-surface-variant dark:text-on-surface-variant hover:text-primary dark:hover:text-primary-fixed-dim transition-all font-label-md text-label-md" href="{{ route('campaigns.index') }}">Campaigns</a>
                <a class="text-on-surface-variant dark:text-on-surface-variant hover:text-primary dark:hover:text-primary-fixed-dim transition-all font-label-md text-label-md" href="{{ route('donation.track.index') }}">Lacak Donasi</a>
            </nav>
            <a href="{{ route('campaigns.index') }}#campaigns" class="bg-primary text-on-primary font-label-md text-label-md px-md py-xs rounded-full hover:bg-primary-container hover:text-on-primary-container transition-all active:scale-95">
                Donate Now
            </a>
        </div>
    </header>

    <main class="pt-[100px] min-h-screen">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="w-full py-xl border-t border-outline-variant bg-surface-container-low dark:bg-surface-container-lowest transition-opacity duration-200 mt-auto">
        <div class="max-w-max-width mx-auto px-margin-mobile md:px-margin-desktop flex flex-col md:flex-row justify-between items-center gap-md">
            <div class="font-headline-md text-headline-md text-primary">
                Sumbangan
            </div>
            <p class="font-body-md text-body-md text-on-surface dark:text-on-surface-variant text-center md:text-left">
                &copy; {{ date('Y') }} Sumbangan. All rights reserved. Institutional Stability through Radical Transparency.
            </p>
            <nav class="flex gap-md font-body-md text-body-md">
                <a class="text-on-surface-variant hover:text-primary transition-colors" href="#">Privacy Policy</a>
                <a class="text-on-surface-variant hover:text-primary transition-colors" href="#">Terms of Service</a>
                <a class="text-on-surface-variant hover:text-primary transition-colors" href="#">Contact</a>
            </nav>
        </div>
    </footer>
</body>
</html>
