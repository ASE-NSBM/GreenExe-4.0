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
@endphp

<header class="sticky top-0 z-40 border-b border-white/10 bg-dark-navy/80 backdrop-blur-lg">
    <nav class="mx-auto flex max-w-7xl items-center justify-between px-4 py-4" aria-label="Main navigation">
        <a href="{{ route('home') }}" class="flex items-center gap-3">
            <span class="grid h-10 w-10 place-items-center rounded-xl bg-gradient-to-br from-smart-green to-cyan-tech font-display text-lg font-bold text-dark-navy">G</span>
            <span class="font-display text-lg font-semibold tracking-wide text-white">
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
