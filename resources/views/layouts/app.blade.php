<!DOCTYPE html>
<html lang="en" class="scroll-smooth @yield('html_class')">
<head>
    @php
        $siteName = config('greenexe.event.name');
        $description = trim($__env->yieldContent('meta_description', config('greenexe.event.tagline')));
        $canonicalUrl = url()->current();
        $socialImage = trim($__env->yieldContent('meta_image', asset('assets/img/logo-bgremoved.png')));

        if (! \Illuminate\Support\Str::startsWith($socialImage, ['http://', 'https://'])) {
            $socialImage = url($socialImage);
        }

        $organizationSchema = [
            '@context' => 'https://schema.org',
            '@type' => 'Organization',
            'name' => $siteName.' — '.config('greenexe.event.organizer'),
            'url' => url('/'),
            'email' => config('greenexe.contact.email'),
            'logo' => url(asset('assets/img/logo-bgremoved.png')),
            'address' => [
                '@type' => 'PostalAddress',
                'streetAddress' => config('greenexe.contact.address'),
                'addressCountry' => 'LK',
            ],
            'sameAs' => array_values(array_filter(config('greenexe.contact.socials'))),
        ];

        $websiteSchema = [
            '@context' => 'https://schema.org',
            '@type' => 'WebSite',
            'name' => $siteName,
            'url' => url('/'),
            'description' => config('greenexe.event.tagline'),
            'inLanguage' => 'en',
        ];
    @endphp
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <link rel="icon" type="image/png" href="{{ asset('assets/img/logo-bgremoved.png') }}">
    <title>@yield('title', config('greenexe.event.name').' — '.config('greenexe.event.concept'))</title>
    <meta name="description" content="@yield('meta_description', config('greenexe.event.tagline'))">
    <meta name="robots" content="@yield('robots', 'index,follow,max-image-preview:large,max-snippet:-1,max-video-preview:-1')">
    <link rel="canonical" href="{{ $canonicalUrl }}">

    <meta property="og:type" content="@yield('og_type', 'website')">
    <meta property="og:site_name" content="{{ $siteName }}">
    <meta property="og:title" content="@yield('title', $siteName)">
    <meta property="og:description" content="{{ $description }}">
    <meta property="og:url" content="{{ $canonicalUrl }}">
    <meta property="og:image" content="{{ $socialImage }}">
    <meta name="twitter:card" content="summary_large_image">
    <meta name="twitter:title" content="@yield('title', $siteName)">
    <meta name="twitter:description" content="{{ $description }}">
    <meta name="twitter:image" content="{{ $socialImage }}">

    <script type="application/ld+json">@json($organizationSchema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE)</script>
    <script type="application/ld+json">@json($websiteSchema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE)</script>
    @stack('structured_data')
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-dark-navy">
    <div class="gx-grid-bg fixed inset-0 -z-10"></div>
    <div class="pointer-events-none fixed inset-0 -z-10 bg-linear-to-b from-deep-green/60 via-dark-navy to-dark-navy"></div>

    @include('partials.nav')

    @if (session('status') || session('error'))
        <div class="mx-auto mt-6 max-w-3xl px-4">
            <div class="gx-card {{ session('error') ? 'border-red-400/40' : 'border-fresh-green/40' }}" role="status">
                {{ session('status') ?? session('error') }}
            </div>
        </div>
    @endif

    <main>
        @yield('content')
    </main>

    @include('partials.footer')
</body>
</html>
