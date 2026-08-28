@extends('layouts.app')

@section('title', 'Organizer — ' . config('greenexe.event.name'))

@php
    $org = config('greenexe.organizer');
@endphp

@section('content')
    <section class="mx-auto max-w-5xl px-4 py-20 sm:px-6 lg:px-8">
        <div class="mx-auto max-w-3xl text-center">
            <div class="mx-auto grid h-28 w-28 place-items-center rounded-full border border-cyan-tech/35 bg-cyan-tech/10 p-5 shadow-[0_0_50px_rgba(53,208,200,0.12)]">
                <img src="{{ asset('assets/img/ase-logo.jpg') }}" alt="Association of Software Engineering logo" class="h-full w-full rounded-full object-contain">
            </div>

            <p class="mt-8 text-xs font-medium uppercase tracking-[0.3em] text-cyan-tech">Meet the team</p>
            <p class="mt-4 font-display text-sm font-semibold uppercase tracking-[0.16em] text-light-gray/70">
                Association of Software Engineering <span class="text-cyan-tech">&middot;</span> NSBM
            </p>
            <h1 class="mt-5 font-display text-4xl font-bold text-white sm:text-5xl md:text-6xl">
                Empowering <span class="text-fresh-green">Future Innovators</span>
            </h1>
            <p class="mx-auto mt-6 max-w-2xl text-base leading-relaxed text-light-gray/70">
                The official organizing body representing Software Engineering undergraduates at
                {{ config('greenexe.event.university') }}, architecting sustainable software solutions and smart urban innovation.
            </p>
        </div>

        <div class="mt-16 grid gap-6 md:grid-cols-2">
            <article class="gx-card inner-liquid-card border-l-4 border-l-cyan-tech">
                <p class="text-xs font-semibold uppercase tracking-[0.25em] text-cyan-tech">Our vision</p>
                <h2 class="mt-4 font-display text-2xl font-bold text-white">Shaping tomorrow's tech leaders</h2>
                <p class="mt-4 leading-relaxed text-light-gray/70">{{ $org['vision'] }}</p>
            </article>

            <article class="gx-card inner-liquid-card border-l-4 border-l-fresh-green">
                <p class="text-xs font-semibold uppercase tracking-[0.25em] text-fresh-green">Our mission</p>
                <h2 class="mt-4 font-display text-2xl font-bold text-white">Driving student tech excellence</h2>
                <p class="mt-4 leading-relaxed text-light-gray/70">{{ $org['mission'] }}</p>
            </article>
        </div>

        <article class="gx-card inner-liquid-card mx-auto mt-6 max-w-4xl text-center">
            <p class="text-xs font-semibold uppercase tracking-[0.25em] text-cyan-tech">About the event</p>
            <h2 class="mt-4 font-display text-2xl font-bold text-white">{{ config('greenexe.event.name') }}</h2>
            <p class="mx-auto mt-4 max-w-2xl leading-relaxed text-light-gray/70">
                {{ config('greenexe.event.name') }} is organized by {{ config('greenexe.event.organizer') }} at
                {{ config('greenexe.event.university') }} to turn student ideas into sustainable smart-city solutions.
            </p>
        </article>

        <div class="mt-16 text-center">
            <p class="text-xs font-semibold uppercase tracking-[0.25em] text-cyan-tech">Follow ASE</p>
            <h2 class="mt-3 font-display text-2xl font-bold text-white">Connect with the organizers</h2>
            <p class="mx-auto mt-3 max-w-xl text-sm leading-relaxed text-light-gray/70">
                Follow ASE for announcements, competition updates, and technical workshop news.
            </p>
            <div class="mt-6 flex justify-center">
                @include('partials.social-links', ['socials' => config('greenexe.contact.socials')])
            </div>
        </div>
    </section>
@endsection
