@extends('layouts.app')

@section('title', config('greenexe.event.name').' — '.config('greenexe.event.concept'))

@section('content')
    {{-- Hero (FR-1, FR-2, FR-3, FR-5) --}}
    <section class="relative mx-auto max-w-7xl px-4 py-24 text-center">
        <p class="gx-badge border border-cyan-tech/40 bg-cyan-tech/10 text-cyan-tech">
            {{ config('greenexe.event.concept') }}
        </p>

        <h1 class="mt-6 font-display text-4xl font-bold leading-tight text-white sm:text-6xl">
            {{ config('greenexe.event.name') }}
            <span class="block bg-gradient-to-r from-fresh-green via-eco-lime to-cyan-tech bg-clip-text text-transparent">
                Build the Smart Green City
            </span>
        </h1>

        <p class="mx-auto mt-6 max-w-2xl text-lg text-light-gray/75">
            A technology and innovation competition inspired by {{ config('greenexe.event.university') }} —
            where green spaces, intelligent infrastructure, connectivity and automation work together.
        </p>

        <div class="mt-10 flex flex-wrap items-center justify-center gap-4">
            <a href="{{ route('register') }}" class="gx-btn-primary">Register Now</a>
            <a href="{{ route('smart-city') }}" class="gx-btn-ghost">Explore the Concept</a>
        </div>
    </section>

    {{-- Competition overview (FR-4) --}}
    <section class="mx-auto max-w-5xl px-4">
        <div class="gx-card">
            <h2 class="font-display text-2xl font-semibold text-white">
                {{ $overview->title ?? 'Competition Overview' }}
            </h2>
            <p class="mt-4 leading-relaxed text-light-gray/75">
                {{ $overview->body ?? 'GreenExE 4.0 invites student teams to design technology solutions that turn a green environment into a connected, efficient, intelligent and sustainable city.' }}
            </p>
            <a href="{{ route('competition') }}" class="mt-6 inline-block text-sm text-cyan-tech hover:underline">
                View full competition information →
            </a>
        </div>
    </section>

    {{-- Smart Green City highlights (FR-6) --}}
    <section class="mx-auto max-w-7xl px-4 py-20">
        <h2 class="text-center font-display text-3xl font-semibold text-white">Smart Green City Highlights</h2>
        <p class="mx-auto mt-3 max-w-2xl text-center text-light-gray/70">
            Nine pillars of an enhanced smart-city environment.
        </p>

        <div class="mt-12 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
            @forelse ($highlights as $highlight)
                <article class="gx-card transition hover:border-cyan-tech/40 hover:bg-white/10">
                    <div class="text-2xl">{{ $highlight->icon ?? '🌿' }}</div>
                    <h3 class="mt-4 font-display text-lg font-semibold text-white">{{ $highlight->title }}</h3>
                    <p class="mt-2 text-sm text-light-gray/70">{{ $highlight->description }}</p>
                </article>
            @empty
                <p class="col-span-full text-center text-light-gray/60">
                    Smart Green City highlights will be published soon.
                </p>
            @endforelse
        </div>
    </section>

    <section class="mx-auto max-w-5xl px-4 pb-8">
        <div class="gx-card flex flex-col items-center gap-6 text-center sm:flex-row sm:justify-between sm:text-left">
            <div>
                <h2 class="font-display text-2xl font-semibold text-white">Ready to compete?</h2>
                <p class="mt-2 text-light-gray/70">
                    Teams of {{ config('greenexe.team.min_members') }}–{{ config('greenexe.team.max_members') }} members. Registration takes a few minutes.
                </p>
            </div>
            <a href="{{ route('register') }}" class="gx-btn-primary shrink-0">Register Now</a>
        </div>
    </section>
@endsection
