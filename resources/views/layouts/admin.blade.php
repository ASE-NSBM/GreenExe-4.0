<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin') — {{ config('greenexe.event.name') }}</title>
    <meta name="robots" content="noindex, nofollow">
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="min-h-screen bg-dark-navy">
    <div class="flex min-h-screen flex-col lg:flex-row">
        <aside class="border-b border-white/10 bg-deep-green/30 lg:w-64 lg:border-b-0 lg:border-r">
            <div class="p-6">
                <a href="{{ route('admin.dashboard') }}" class="font-display text-lg font-semibold text-white">
                    {{ config('greenexe.event.name') }}
                    <span class="block text-xs font-normal text-cyan-tech">Administration</span>
                </a>
            </div>

            @php
                $adminLinks = [
                    'admin.dashboard' => 'Dashboard',
                    'admin.registrations.index' => 'Registrations',
                    'admin.faqs.index' => 'FAQs',
                    'admin.content.index' => 'Content',
                ];
            @endphp

            <nav class="px-3 pb-6" aria-label="Admin navigation">
                <ul class="space-y-1">
                    @foreach ($adminLinks as $route => $label)
                        <li>
                            <a href="{{ route($route) }}"
                               class="block rounded-lg px-3 py-2 text-sm transition {{ request()->routeIs($route) ? 'bg-smart-green/20 text-cyan-tech' : 'text-light-gray/75 hover:bg-white/5' }}">
                                {{ $label }}
                            </a>
                        </li>
                    @endforeach
                </ul>

                <form method="POST" action="{{ route('admin.logout') }}" class="mt-6 px-3">
                    @csrf
                    <button type="submit" class="text-sm text-light-gray/60 hover:text-red-300">Log out</button>
                </form>
            </nav>
        </aside>

        <main class="flex-1 p-6 lg:p-10">
            @if (session('status'))
                <div class="mb-6 rounded-xl border border-fresh-green/40 bg-fresh-green/10 px-5 py-3 text-sm" role="status">
                    {{ session('status') }}
                </div>
            @endif

            @yield('content')
        </main>
    </div>
</body>
</html>
