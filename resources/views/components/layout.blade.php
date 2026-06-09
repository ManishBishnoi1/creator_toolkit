<!DOCTYPE html>
<html class="scroll-smooth" lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <!-- Google tag (gtag.js) -->
    <script async src="https://www.googletagmanager.com/gtag/js?id=G-1EF1YE1HFX"></script>
    <script>
      window.dataLayer = window.dataLayer || [];
      function gtag(){dataLayer.push(arguments);}
      gtag('js', new Date());

      gtag('config', 'G-1EF1YE1HFX');
    </script>

    <!-- Google AdSense -->
    <script async src="https://pagead2.googlesyndication.com/pagead/js/adsbygoogle.js?client=ca-pub-1613230266448965"
     crossorigin="anonymous"></script>

    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <!-- Dynamic SEO Head Tag Component -->
    <x-seo-meta :title="$title ?? null" :description="$description ?? null" :keywords="$keywords ?? null" />
    
    <!-- Tab Icon (Favicon) -->
    <link rel="icon" type="image/png" sizes="16x16" href="{{ asset('images/logo.png') }}"/>
    <link rel="icon" type="image/png" sizes="32x32" href="{{ asset('images/logo.png') }}"/>
    <link rel="icon" type="image/png" sizes="48x48" href="{{ asset('images/logo.png') }}"/>
    <link rel="apple-touch-icon" href="{{ asset('images/logo.png') }}"/>

    <!-- Google Fonts & Material Symbols -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&family=Plus+Jakarta+Sans:wght@600;700;800&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>

    <!-- Vite Styles & Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>

    <style>
        .reveal {
            opacity: 0;
            transform: translateY(30px);
            transition: opacity 0.6s ease-out, transform 0.6s ease-out;
        }
        .reveal.visible {
            opacity: 1;
            transform: translateY(0);
        }
    </style>
</head>
<body class="bg-white text-slate-800 antialiased selection:bg-blue-500/10 selection:text-blue-900">

<!-- Navigation Header Component -->
<x-navbar />

<!-- Main content slot -->
{{ $slot }}

<!-- Footer Component -->
<x-footer />

<script>
    // Smooth scroll reveal observer
    const revealObserver = new IntersectionObserver((entries) => {
        entries.forEach(entry => {
            if (entry.isIntersecting) {
                entry.target.classList.add('visible');
            }
        });
    }, {
        threshold: 0.1,
        rootMargin: '0px 0px -50px 0px'
    });

    document.querySelectorAll('.reveal').forEach(el => revealObserver.observe(el));

    // Sticky Navbar scroll trigger
    const nav = document.getElementById('main-nav');
    if (nav) {
        window.addEventListener('scroll', () => {
            if (window.scrollY > 40) {
                nav.classList.add('bg-black/60', 'backdrop-blur-lg', 'border-white/10', 'shadow-2xl', 'py-2');
                nav.classList.remove('bg-white/0', 'backdrop-blur-0', 'border-white/0', 'py-4');
            } else {
                nav.classList.remove('bg-black/60', 'backdrop-blur-lg', 'border-white/10', 'shadow-2xl', 'py-2');
                nav.classList.add('bg-white/0', 'backdrop-blur-0', 'border-white/0', 'py-4');
            }
        });

        // Initial check for nav state on load
        if (window.scrollY > 40) {
            nav.classList.add('bg-black/60', 'backdrop-blur-lg', 'border-white/10', 'shadow-2xl', 'py-2');
        }
    }
</script>
</body>
</html>
