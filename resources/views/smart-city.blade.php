@extends('layouts.app')

@section('title', 'Smart Green City Concept — '.config('greenexe.event.name'))

@section('content')
    {{-- FR-15 --}}
    @include('partials.page-hero', [
        'image' => 'assets/img/Smartbuildings.jpg',
        'eyebrow' => 'The concept',
        'titleItalic' => 'Smart Green',
        'title' => 'City',
        'lead' => 'An enhanced, futuristic version of the '.config('greenexe.event.university').' environment, where a green campus becomes a connected, efficient and intelligent city.',
    ])

    <section class="gx-section mx-auto max-w-6xl px-6 pb-24">

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
                    // Stored as a lead sentence followed by one point per line.
                    $lines = preg_split('/\R+/', trim($pillar->description));
                    $lead = array_shift($lines);
                @endphp

                <article class="gx-reveal group relative flex flex-col overflow-hidden rounded-2xl border border-white/10 transition hover:border-cyan-tech/40"
                         data-reveal style="transition-delay: {{ min($loop->index, 5) * 0.06 }}s">
                    @if ($artwork = $pillar->artwork())
                        <div class="absolute inset-0 bg-cover bg-center transition-transform duration-700 group-hover:scale-105"
                             style="background-image: url('{{ $artwork }}')" aria-hidden="true"></div>
                        <div class="absolute inset-0 bg-gradient-to-t from-dark-navy via-dark-navy/90 to-dark-navy/60" aria-hidden="true"></div>
                    @else
                        <div class="absolute inset-0 bg-white/5 backdrop-blur-md" aria-hidden="true"></div>
                    @endif

                    <div class="relative p-6">
                    <div class="text-2xl">{{ $pillar->icon ?? '⚡' }}</div>
                    <h3 class="gx-card-title mt-4 text-lg font-medium text-white">{{ $pillar->title }}</h3>
                    <p class="mt-2 text-sm text-white/75">{{ $lead }}</p>

                    @if ($lines)
                        <ul class="mt-3 space-y-1.5 border-t border-white/15 pt-3 text-sm text-white/75">
                            @foreach ($lines as $line)
                                <li class="flex gap-2">
                                    <span class="mt-2 h-1 w-1 shrink-0 rounded-full bg-fresh-green"></span>
                                    <span>{{ $line }}</span>
                                </li>
                            @endforeach
                        </ul>
                    @endif
                    </div>
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
