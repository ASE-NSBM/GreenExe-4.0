<!DOCTYPE html>
<html lang="en" class="scroll-smooth">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', config('greenexe.event.name').' — '.config('greenexe.event.concept'))</title>
    <meta name="description" content="@yield('meta_description', config('greenexe.event.tagline'))">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-dark-navy">
    <div class="gx-grid-bg fixed inset-0 -z-10"></div>
    <div class="pointer-events-none fixed inset-0 -z-10 bg-gradient-to-b from-deep-green/60 via-dark-navy to-dark-navy"></div>

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
