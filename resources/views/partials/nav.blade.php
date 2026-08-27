@php
    $links = [
        ['route' => 'home', 'label' => 'Home'],
        ['route' => 'about', 'label' => 'About'],
        ['route' => 'smart-city', 'label' => 'Smart Green City'],
        ['route' => 'competition', 'label' => 'Competition'],
        ['route' => 'rules', 'label' => 'Rules'],
        ['route' => 'faq', 'label' => 'FAQ'],
        ['route' => 'organizer', 'label' => 'Organizer'],
    ];

    // The home and organizer pages use the floating glassmorphic bar.
    // Every other page keeps the solid sticky bar.
    $overlay = request()->routeIs('home', 'organizer');
@endphp

@if ($overlay)
    <header class="fixed top-0 left-0 right-0 z-[100]">
        <nav class="relative flex items-center justify-between p-4 sm:p-5" aria-label="Main navigation">
            <a href="{{ route('home') }}" class="flex items-center gap-3">
                <span class="grid h-[26px] w-[26px] place-items-center rounded-lg bg-gradient-to-br from-smart-green to-cyan-tech font-display text-sm font-bold text-dark-navy">G</span>
                <span class="font-playfair text-2xl italic text-white">{{ config('greenexe.event.name') }}</span>
            </a>

            <ul class="absolute left-1/2 hidden -translate-x-1/2 items-center gap-1 rounded-full border border-white/30 bg-white/20 px-2 py-2 backdrop-blur-md xl:flex">
                @foreach ($links as $link)
                    <li>
                        <a href="{{ route($link['route']) }}"
                           class="block rounded-full px-4 py-1.5 text-sm font-medium transition-colors hover:bg-white/20 hover:text-white {{ request()->routeIs($link['route']) ? 'text-white' : 'text-white/80' }}">
                            {{ $link['label'] }}
                        </a>
                    </li>
                @endforeach
            </ul>

            <div class="flex items-center gap-3">
                <a href="{{ route('register') }}"
                   class="gx-btn-primary hidden sm:inline-flex">
                    Register Now
                </a>
                <button type="button"
                        class="rounded-full border border-white/30 bg-white/20 p-2 text-white backdrop-blur-md xl:hidden"
                        data-mobile-toggle aria-expanded="false" aria-controls="mobile-menu" aria-label="Toggle navigation">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
            </div>
        </nav>

        <div id="mobile-menu" class="mx-4 hidden rounded-2xl border border-white/10 bg-dark-navy/95 px-4 py-3 backdrop-blur-lg xl:hidden" data-mobile-menu>
            <ul class="space-y-2">
                @foreach ($links as $link)
                    <li>
                        <a href="{{ route($link['route']) }}" class="block rounded-lg px-3 py-2 text-sm text-light-gray/80 hover:bg-white/5">
                            {{ $link['label'] }}
                        </a>
                    </li>
                @endforeach
                <li><a href="{{ route('register') }}" class="gx-btn-primary w-full">Register Now</a></li>
            </ul>
        </div>
    </header>
@else
    <header class="sticky top-0 z-40 border-b border-white/10 bg-dark-navy/80 backdrop-blur-lg">
        <nav class="mx-auto flex max-w-7xl items-center justify-between px-4 py-4" aria-label="Main navigation">
            <a href="{{ route('home') }}" class="flex items-center gap-3">
                <span class="grid h-10 w-10 place-items-center rounded-xl bg-gradient-to-br from-smart-green to-cyan-tech font-display text-lg font-bold text-dark-navy">G</span>
                <span class="font-playfair text-2xl italic text-white">
                    {{ config('greenexe.event.name') }}
                </span>
            </a>

            <ul class="hidden items-center gap-6 lg:flex">
                @foreach ($links as $link)
                    <li>
                        <a href="{{ route($link['route']) }}"
                           class="text-sm transition hover:text-cyan-tech {{ request()->routeIs($link['route']) ? 'text-cyan-tech' : 'text-light-gray/80' }}">
                            {{ $link['label'] }}
                        </a>
                    </li>
                @endforeach
            </ul>

            <div class="flex items-center gap-3">
                <a href="{{ route('register') }}" class="gx-btn-primary hidden sm:inline-flex">Register Now</a>
                <button type="button" class="lg:hidden rounded-lg border border-white/20 p-2" data-mobile-toggle aria-expanded="false" aria-controls="mobile-menu" aria-label="Toggle navigation">
                    <svg class="h-5 w-5" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                        <path stroke-linecap="round" d="M4 6h16M4 12h16M4 18h16"></path>
                    </svg>
                </button>
            </div>
        </nav>

        <div id="mobile-menu" class="hidden border-t border-white/10 px-4 py-3 lg:hidden" data-mobile-menu>
            <ul class="space-y-2">
                @foreach ($links as $link)
                    <li>
                        <a href="{{ route($link['route']) }}" class="block rounded-lg px-3 py-2 text-sm text-light-gray/80 hover:bg-white/5">
                            {{ $link['label'] }}
                        </a>
                    </li>
                @endforeach
                <li><a href="{{ route('register') }}" class="gx-btn-primary w-full">Register Now</a></li>
            </ul>
        </div>
    </header>
@endif
