@extends('layouts.app')

@section('title', 'Smart Green City Concept — '.config('greenexe.event.name'))

@section('content')
    {{-- FR-15 --}}
    <section class="gx-section mx-auto max-w-6xl px-6 py-24 sm:px-10 md:px-14">
        @include('partials.page-header', [
            'eyebrow' => 'The concept',
            'titleItalic' => 'Smart Green',
            'title' => 'City',
            'lead' => 'An enhanced, futuristic version of the '.config('greenexe.event.university').' environment, where a green campus becomes a connected, efficient and intelligent city.',
        ])

        <div class="mt-12 grid gap-6 md:grid-cols-2">
            @forelse ($vision as $item)
                <article class="gx-card gx-reveal" data-reveal>
                    <h2 class="gx-card-title text-xl font-medium text-white">{{ $item->title }}</h2>
                    <p class="mt-3 text-light-gray/75">{{ $item->description }}</p>
                </article>
            @empty
                <article class="gx-card md:col-span-2">
                    <h2 class="gx-card-title text-xl font-medium text-white">The vision</h2>
                    <p class="mt-3 text-light-gray/75">
                        Technology transforms a green environment into a connected, efficient, intelligent and
                        sustainable city — the guiding idea behind every {{ config('greenexe.event.name') }} project.
                    </p>
                </article>
            @endforelse
        </div>

        {{-- FR-16 to FR-21 --}}
        <h2 class="gx-group-label gx-reveal mt-20 text-3xl font-normal text-white" data-reveal>City pillars</h2>
        <div class="mt-8 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
            @forelse ($pillars as $pillar)
                @php
                    $tints = [
                        'from-forest-green via-deep-green to-dark-navy',
                        'from-smart-green/80 via-forest-green to-dark-navy',
                        'from-eco-lime/40 via-smart-green/60 to-dark-navy',
                        'from-cyan-tech/40 via-forest-green to-dark-navy',
                        'from-cyan-tech/30 via-deep-green to-dark-navy',
                        'from-fresh-green/40 via-forest-green to-dark-navy',
                        'from-cyan-tech/45 via-smart-green/50 to-dark-navy',
                        'from-deep-green via-forest-green/80 to-dark-navy',
                        'from-eco-lime/30 via-cyan-tech/30 to-dark-navy',
                    ];
                @endphp

                <article class="gx-card gx-reveal transition hover:border-cyan-tech/40" data-reveal
                         style="transition-delay: {{ min($loop->index, 5) * 0.06 }}s">
                    <div class="text-2xl">{{ $pillar->icon ?? '⚡' }}</div>
                    <h3 class="gx-card-title mt-4 text-lg font-medium text-white">{{ $pillar->title }}</h3>
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
        <div class="gx-reveal mt-16 gx-card border-fresh-green/30 text-center" data-reveal>
            <h2 class="gx-card-title text-2xl font-medium text-white">Technology as a tool for sustainability</h2>
            <p class="mx-auto mt-3 max-w-3xl text-light-gray/75">
                Every project should show how innovation, automation and connectivity make urban living more
                sustainable — not technology for its own sake.
            </p>
            <a href="{{ route('register') }}" class="gx-btn-primary mt-6">Register your project</a>
        </div>
    </section>
@endsection
