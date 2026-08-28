@extends('layouts.app')

@section('title', 'Organizer — '.config('greenexe.event.name'))

@section('content')
    <x-page-header
        eyebrow="Meet the team"
        title="About the organizer"
        :description="config('greenexe.event.name').' is proudly organized by the Association of Software Engineering (ASE) Club under '.config('greenexe.event.brand').'.'" />

    <section class="mx-auto max-w-7xl px-4 py-16 sm:px-6 lg:px-8">
        <div class="grid items-center gap-12 lg:grid-cols-2 lg:gap-20">
            <div>
                <p class="text-sm font-medium uppercase tracking-[0.3em] text-cyan-tech">The club</p>
                <h2 class="mt-3 font-display text-3xl font-bold text-white">ASE</h2>
                <h3 class="mt-2 font-display text-xl font-semibold text-white">Association of Software Engineering</h3>
                <p class="mt-6 leading-relaxed text-light-gray/70">
                    The Association of Software Engineering (ASE) is the official student body representing Software
                    Engineering undergraduates at NSBM. We aim to empower students by creating opportunities to learn,
                    connect, and grow through technical and non-technical activities.
                </p>
                <a href="https://asensbm.live/" target="_blank" rel="noopener noreferrer"
                   class="gx-btn-ghost mt-7 inline-flex items-center gap-2">
                    Learn more about ASE
                    <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                        <path d="M14 5h5v5M19 5l-9 9"/><path d="M19 13v5a1 1 0 0 1-1 1H6a1 1 0 0 1-1-1V6a1 1 0 0 1 1-1h5"/>
                    </svg>
                </a>
            </div>

            <div class="mx-auto grid h-48 w-48 place-items-center rounded-full border border-cyan-tech/35 bg-cyan-tech/10 p-8 shadow-[0_0_60px_rgba(53,208,200,0.14)]">
                <img src="{{ asset('assets/img/ase-logo.jpg') }}" alt="Association of Software Engineering logo" class="h-full w-full rounded-full object-contain">
            </div>
        </div>

        <div class="mt-20 grid gap-6 md:grid-cols-2">
            <article class="gx-card inner-liquid-card border-l-4 border-l-cyan-tech">
                <h3 class="font-display text-xl font-bold text-cyan-tech">Vision</h3>
                <p class="mt-4 leading-relaxed text-light-gray/70">
                    To be the leading student organization that nurtures innovation and technical excellence among
                    Software Engineering undergraduates.
                </p>
            </article>
            <article class="gx-card inner-liquid-card border-l-4 border-l-cyan-tech">
                <h3 class="font-display text-xl font-bold text-cyan-tech">Mission</h3>
                <p class="mt-4 leading-relaxed text-light-gray/70">
                    To create an inclusive community that bridges academia and industry through meaningful events,
                    workshops, and competitions like {{ config('greenexe.event.name') }}.
                </p>
            </article>
        </div>

        @if ($blocks->isNotEmpty())
            <div class="mt-20">
                <p class="text-sm font-medium uppercase tracking-[0.3em] text-cyan-tech">From the organizers</p>
                <div class="mt-6 grid gap-6 md:grid-cols-2">
                    @foreach ($blocks as $block)
                        <article class="gx-card inner-liquid-card">
                            <h3 class="font-display text-xl font-semibold text-white">{{ $block->title }}</h3>
                            <p class="mt-3 whitespace-pre-line text-light-gray/70">{{ $block->body }}</p>
                        </article>
                    @endforeach
                </div>
            </div>
        @endif

        <div class="mt-20 text-center">
            <h2 class="font-display text-2xl font-semibold text-white">Follow ASE</h2>
            <div class="mt-7 flex justify-center gap-4">
                @foreach (config('greenexe.contact.socials') as $name => $url)
                    <a href="{{ $url }}" target="_blank" rel="noopener noreferrer"
                       class="grid h-12 w-12 place-items-center rounded-full border border-cyan-tech/30 bg-white/5 text-light-gray/60 transition hover:border-cyan-tech hover:bg-cyan-tech/15 hover:text-cyan-tech"
                       aria-label="{{ ucfirst($name) }}">
                        @if ($name === 'facebook')
                            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M14 8h3V4h-3c-3.31 0-5 1.69-5 5v3H6v4h3v8h4v-8h3l1-4h-4V9c0-.67.33-1 1-1Z"/></svg>
                        @elseif ($name === 'instagram')
                            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true"><rect x="3" y="3" width="18" height="18" rx="5"/><circle cx="12" cy="12" r="4"/><circle cx="17.5" cy="6.5" r="1" fill="currentColor" stroke="none"/></svg>
                        @elseif ($name === 'linkedin')
                            <svg class="h-5 w-5" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true"><path d="M5 3.5A2.5 2.5 0 1 1 5 8.5 2.5 2.5 0 0 1 5 3.5ZM3 10h4v11H3V10Zm6 0h3.8v1.5h.05c.53-1 1.83-2 3.75-2 4 0 4.4 2.63 4.4 6.05V21h-4v-4.83c0-1.15-.02-2.63-1.6-2.63-1.6 0-1.85 1.25-1.85 2.55V21H9V10Z"/></svg>
                        @endif
                    </a>
                @endforeach
            </div>
        </div>
    </section>
@endsection
