@extends('layouts.app')

@section('title', 'Smart Green City — '.config('greenexe.event.name'))

@section('content')
    {{-- FR-15 --}}
    <section class="mx-auto max-w-6xl px-4 py-20">
        <x-page-header
            eyebrow="The vision"
            title="Smart Green City"
            :description="'An enhanced, futuristic version of the '.config('greenexe.event.university').' environment, where a green campus becomes a connected, efficient and intelligent city.'" />

        <div class="mt-12 grid gap-6 md:grid-cols-2">
            @forelse ($vision as $item)
                <article class="gx-card">
                    <h2 class="font-display text-xl font-semibold text-white">{{ $item->title }}</h2>
                    <p class="mt-3 text-light-gray/75">{{ $item->description }}</p>
                </article>
            @empty
                <article class="gx-card md:col-span-2">
                    <h2 class="font-display text-xl font-semibold text-white">The vision</h2>
                    <p class="mt-3 text-light-gray/75">
                        Technology transforms a green environment into a connected, efficient, intelligent and
                        sustainable city — the guiding idea behind every {{ config('greenexe.event.name') }} project.
                    </p>
                </article>
            @endforelse
        </div>

        {{-- FR-16 to FR-21 --}}
        <h2 class="mt-20 font-display text-3xl font-semibold text-white">City pillars</h2>
        <div class="mt-8 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
            @forelse ($pillars as $pillar)
                @php
                    // Stored as a lead sentence followed by one point per line.
                    $lines = preg_split('/\R+/', trim($pillar->description));
                    $lead = array_shift($lines);
                    $pillarIcons = [
                        '<path d="M12 3v18M4 7h16M6 7l-2 5h4L6 7Zm12 0-2 5h4l-2-5ZM8 21h8M8 17h8"/>',
                        '<path d="M4 6h16M4 12h16M4 18h16M7 3v18M17 3v18"/>',
                        '<path d="M3 20h18M5 20V9l7-5 7 5v11M9 20v-6h6v6M12 4v3"/>',
                        '<path d="M4 19V5M4 5c4-3 8 3 16 0v14c-8 3-12-3-16 0ZM8 9h8M8 13h5"/>',
                        '<path d="M12 3v18M5 7h14M7 7l-2 5h4L7 7Zm10 0-2 5h4l-2-5ZM8 17h8"/>',
                        '<path d="M4 18h16M6 18V9h12v9M4 9h16l-8-5-8 5ZM9 13h6"/>',
                    ];
                    $pillarIcon = $pillarIcons[$loop->index % count($pillarIcons)];
                @endphp

                <article class="gx-card inner-liquid-card transition hover:border-cyan-tech/40">
                    <div class="inner-card-icon" aria-hidden="true">
                        <svg viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.6" stroke-linecap="round" stroke-linejoin="round">
                            {!! $pillarIcon !!}
                        </svg>
                    </div>
                    <h3 class="mt-4 font-display text-lg font-semibold text-white">{{ $pillar->title }}</h3>
                    <p class="mt-2 text-sm text-light-gray/70">{{ $lead }}</p>

                    @if ($lines)
                        <ul class="mt-3 space-y-1.5 border-t border-white/10 pt-3 text-sm text-light-gray/70">
                            @foreach ($lines as $line)
                                <li class="flex gap-2">
                                    <span class="mt-2 h-1 w-1 shrink-0 rounded-full bg-fresh-green"></span>
                                    <span>{{ $line }}</span>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                </article>
            @empty
                <p class="col-span-full text-light-gray/60">Smart city pillars will be published soon.</p>
            @endforelse
        </div>

        {{-- FR-22 --}}
        <div class="mt-16 gx-card border-fresh-green/30 text-center">
            <h2 class="font-display text-2xl font-semibold text-white">Technology as a tool for sustainability</h2>
            <p class="mx-auto mt-3 max-w-3xl text-light-gray/75">
                Every project should show how innovation, automation and connectivity make urban living more
                sustainable — not technology for its own sake.
            </p>
            <a href="{{ route('register') }}" class="gx-btn-primary mt-6">Register your project</a>
        </div>
    </section>
@endsection
