@extends('layouts.app')

@section('title', 'Smart Green City — '.config('greenexe.event.name'))

@section('content')
    {{-- FR-15 --}}
    <section class="mx-auto max-w-6xl px-4 py-20">
        <h1 class="font-display text-4xl font-bold text-white">Smart Green City</h1>
        <p class="mt-4 max-w-3xl text-lg text-light-gray/75">
            An enhanced, futuristic version of the {{ config('greenexe.event.university') }} environment, where a green
            campus becomes a connected, efficient and intelligent city.
        </p>

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
                <article class="gx-card transition hover:border-cyan-tech/40">
                    <div class="text-2xl">{{ $pillar->icon ?? '⚡' }}</div>
                    <h3 class="mt-4 font-display text-lg font-semibold text-white">{{ $pillar->title }}</h3>
                    <p class="mt-2 text-sm text-light-gray/70">{{ $pillar->description }}</p>
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
