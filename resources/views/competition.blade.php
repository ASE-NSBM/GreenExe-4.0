@extends('layouts.app')

@section('title', 'Competition — '.config('greenexe.event.name'))

@section('content')
    <section class="mx-auto max-w-5xl px-4 py-20">
        <x-page-header
            eyebrow="The competition"
            title="Competition Information"
            description="Everything you need to know before registering your team and project." />

        <div class="mt-12 space-y-10">
            @forelse ($sections as $section => $items)
                <div>
                    <h2 class="font-display text-2xl font-semibold text-cyan-tech">
                        {{ Str::headline($section) }}
                    </h2>
                    <div class="mt-4 space-y-4">
                        @foreach ($items as $item)
                            <article class="gx-card">
                                <h3 class="font-display text-lg font-semibold text-white">{{ $item->title }}</h3>
                                <p class="mt-2 whitespace-pre-line text-light-gray/75">{{ $item->body }}</p>
                            </article>
                        @endforeach
                    </div>
                </div>
            @empty
                <p class="text-light-gray/60">Competition information will be published by the organisers shortly.</p>
            @endforelse
        </div>

        <div class="mt-12 grid gap-4 sm:grid-cols-2">
            <a href="{{ route('rules') }}" class="gx-card block transition hover:border-cyan-tech/40">
                <h3 class="font-display text-lg font-semibold text-white">Rules &amp; eligibility</h3>
                <p class="mt-2 text-sm text-light-gray/70">Who can enter, team requirements and disqualification conditions.</p>
            </a>
            <a href="{{ route('register') }}" class="gx-card block transition hover:border-fresh-green/40">
                <h3 class="font-display text-lg font-semibold text-white">Register your team</h3>
                <p class="mt-2 text-sm text-light-gray/70">Submit team and project information online.</p>
            </a>
        </div>
    </section>
@endsection
