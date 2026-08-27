@extends('layouts.app')

@section('title', 'Competition — '.config('greenexe.event.name'))

@section('content')
    @include('partials.page-hero', [
        'image' => 'assets/img/bg1.jpeg',
        'eyebrow' => 'Competition',
        'titleItalic' => 'Everything',
        'title' => 'you need to know',
        'lead' => 'Read this before registering your team and project.',
    ])

    <section class="gx-section mx-auto max-w-5xl px-6 pb-24">

        <div class="mt-12 space-y-10">
            @forelse ($sections as $section => $items)
                <div class="gx-reveal" data-reveal>
                    <h2 class="gx-group-label text-2xl font-normal text-white sm:text-3xl">
                        {{ Str::headline($section) }}
                    </h2>
                    <div class="mt-4 space-y-4">
                        @foreach ($items as $item)
                            <article class="gx-card gx-reveal" data-reveal>
                                <h3 class="gx-card-title text-lg font-medium text-white">{{ $item->title }}</h3>
                                <p class="mt-2 whitespace-pre-line text-sm leading-relaxed text-white/75 md:text-base">{{ $item->body }}</p>
                            </article>
                        @endforeach
                    </div>
                </div>
            @empty
                <p class="text-light-gray/60">Competition information will be published by the organisers shortly.</p>
            @endforelse
        </div>

        <div class="mt-12 grid gap-4 sm:grid-cols-2">
            <a href="{{ route('rules') }}" class="gx-card gx-reveal block transition hover:-translate-y-1 hover:border-cyan-tech/40" data-reveal>
                <h3 class="gx-card-title text-lg font-medium text-white">Rules &amp; eligibility</h3>
                <p class="mt-2 text-sm text-light-gray/70">Who can enter, team requirements and disqualification conditions.</p>
            </a>
            <a href="{{ route('register') }}" class="gx-card gx-reveal block transition hover:-translate-y-1 hover:border-fresh-green/40" data-reveal style="transition-delay: 0.08s">
                <h3 class="gx-card-title text-lg font-medium text-white">Register your team</h3>
                <p class="mt-2 text-sm text-light-gray/70">Submit team and project information online.</p>
            </a>
        </div>
    </section>
@endsection
