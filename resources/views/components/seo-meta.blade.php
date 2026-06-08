@inject('seo', 'App\Core\Services\SEOService')

@php
    // Dynamically apply any values passed down from parent Blade components / views
    if (isset($title) && !empty($title)) {
        $seo->setTitle($title);
    }
    if (isset($description) && !empty($description)) {
        $seo->setDescription($description);
    }
    if (isset($keywords) && !empty($keywords)) {
        $seo->setKeywords(is_array($keywords) ? $keywords : array_map('trim', explode(',', $keywords)));
    }
@endphp

<!-- SEO Meta Tags -->
<title>{{ $seo->getTitle() }}</title>
<meta name="description" content="{{ $seo->getDescription() }}">
<meta name="keywords" content="{{ $seo->getKeywords() }}">
<link rel="canonical" href="{{ $seo->getCanonical() }}">
<meta name="robots" content="{{ $seo->getRobots() }}">

<!-- OpenGraph / Facebook -->
<meta property="og:type" content="website">
<meta property="og:url" content="{{ $seo->getCanonical() }}">
<meta property="og:title" content="{{ $seo->getTitle() }}">
<meta property="og:description" content="{{ $seo->getDescription() }}">
<meta property="og:image" content="{{ $seo->getOgImage() }}">

<!-- Twitter -->
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:url" content="{{ $seo->getCanonical() }}">
<meta name="twitter:title" content="{{ $seo->getTitle() }}">
<meta name="twitter:description" content="{{ $seo->getDescription() }}">
<meta name="twitter:image" content="{{ $seo->getOgImage() }}">

<!-- Structured Data JSON-LD Schemas -->
{!! $seo->renderSchemas() !!}
