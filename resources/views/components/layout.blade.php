<!DOCTYPE html>
<html class="dark scroll-smooth" lang="{{ str_replace('_', '-', app()->getLocale()) }}">
<head>
    <meta charset="utf-8"/>
    <meta content="width=device-width, initial-scale=1.0" name="viewport"/>
    <meta name="csrf-token" content="{{ csrf_token() }}">

    <title>{{ $title ?? \App\Core\Helpers\SEOHelper::title() }}</title>
    <meta name="description" content="{{ $description ?? \App\Core\Helpers\SEOHelper::description() }}">
    <meta name="keywords" content="{{ $keywords ?? \App\Core\Helpers\SEOHelper::keywords() }}">

    <!-- Google Fonts & Material Symbols -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;600&family=Plus+Jakarta+Sans:wght@600;700;800&display=swap" rel="stylesheet"/>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet"/>

    <!-- Vite Styles & Scripts -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])

    <!-- Alpine.js -->
    <script defer src="https://cdn.jsdelivr.net/npm/alpinejs@3.x.x/dist/cdn.min.js"></script>
</head>
<body class="bg-background text-on-surface selection:bg-secondary/30 selection:text-white antialiased">

<!-- Persistent Glow Background -->
<div class="bg-glow-container">
    <div class="bg-glow bg-glow-purple"></div>
    <div class="bg-glow bg-glow-blue"></div>
</div>

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
</script>
</body>
</html>
