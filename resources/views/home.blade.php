@extends('layouts.app')

@section('title', config('greenexe.event.name').' — '.config('greenexe.event.concept'))

@section('html_class', 'gx-stack-root')

@section('content')
    {{-- Each panel is pinned to the top of the viewport, so the next one slides
         up and takes it over. Panels are opaque for that reason. --}}
    <div class="gx-stack home-shell">
        {{-- Snap stops, kept off the pinned panels themselves. --}}
        {{-- One stop per pinned panel. The closing panel is taller than the
             viewport and carries its own snap alignment. --}}
        <div class="gx-snap-rail" aria-hidden="true">
            <div class="gx-snap-stop"></div>
            <div class="gx-snap-stop"></div>
            <div class="gx-snap-stop"></div>
        </div>

    {{-- Hero (FR-1, FR-2, FR-3, FR-5) --}}
    <section class="gx-panel home-hero relative w-full overflow-hidden bg-black tracking-[-0.02em]"
             data-hero>

        {{-- 1. Base plate --}}
        <div class="hero-zoom absolute inset-0 z-10 bg-cover bg-center bg-no-repeat opacity-55"
             style="background-image: url('{{ asset('assets/img/bg1.jpeg') }}')"
             aria-hidden="true"></div>

        {{-- 2. Reveal plate, unmasked until the spotlight mask is attached in JS --}}
        <canvas class="pointer-events-none absolute inset-0" style="display: none" data-hero-canvas></canvas>
        <div class="pointer-events-none absolute inset-0 z-30 bg-cover bg-center bg-no-repeat opacity-0"
             style="background-image: url('{{ asset('assets/img/bg2.jpeg') }}')"
             aria-hidden="true"
             data-hero-reveal></div>
            <div class="home-hero-shade absolute inset-0 z-20" aria-hidden="true"></div>

        {{-- 3. Headline --}}
        <div class="pointer-events-none absolute top-[14%] left-0 right-0 z-50 flex flex-col items-center px-5 text-center">
            <p class="hero-anim hero-fade mb-4 text-xs font-medium uppercase tracking-[0.35em] text-fresh-green sm:text-sm"
               style="animation-delay: 0.1s">
                {{ config('greenexe.event.name') }}
            </p>

            <h1 class="leading-[0.95] text-white">
                <span class="hero-anim hero-reveal block font-playfair text-5xl font-normal italic text-white sm:text-7xl md:text-8xl"
                      style="letter-spacing: -0.05em; animation-delay: 0.25s">Build the</span>
                <span class="hero-anim hero-reveal -mt-1 block text-5xl font-normal text-fresh-green sm:text-7xl md:text-8xl"
                      style="letter-spacing: -0.08em; animation-delay: 0.42s">{{ config('greenexe.event.concept') }}</span>
            </h1>
        </div>

        {{-- 4. Bottom-left copy --}}
        <div class="hero-anim hero-fade home-glass-note absolute bottom-14 left-10 z-50 hidden max-w-[260px] sm:block md:left-14"
             style="animation-delay: 0.7s">
            <p class="text-sm leading-relaxed text-white/80">
                An enhanced smart-city experience inspired by {{ config('greenexe.event.university') }}, where green
                spaces, intelligent infrastructure, connectivity and automation work together.
            </p>
        </div>

        {{-- 5. Bottom-right copy and call to action --}}
        <div class="hero-anim hero-fade home-glass-note absolute bottom-10 left-5 right-5 z-50 flex max-w-full flex-col items-start gap-4 sm:bottom-24 sm:left-auto sm:right-10 sm:max-w-[260px] sm:gap-5 md:right-14"
             style="animation-delay: 0.85s">
            <p class="text-xs leading-relaxed text-white/80 sm:text-sm">
                Teams of {{ config('greenexe.team.min_members') }}–{{ config('greenexe.team.max_members') }} students
                design technology that turns a green environment into a connected, efficient and sustainable city.
                Organised by the {{ config('greenexe.event.organizer') }}.
            </p>
            <a href="{{ route('register') }}"
                   class="home-liquid-btn group">
                Register Now
                <span class="home-liquid-btn-arrow" aria-hidden="true">
                    <span class="transition-transform duration-300 group-hover:translate-x-0.5">&rarr;</span>
                </span>
            </a>
        </div>
    </section>

    {{-- Competition overview, purpose and benefits (FR-4, FR-12, FR-13) --}}
    @php
        // Copy is dashboard-managed; the fallbacks keep the panel intact before
        // the seeders run or if a section is unpublished.
        $panelCards = [
            [
                'label' => 'Overview',
                'entry' => $sections['overview'] ?? null,
                'title' => 'Competition overview',
                'body' => 'GreenExE 4.0 invites student teams to design technology solutions that turn a green environment into a connected, efficient, intelligent and sustainable city.',
            ],
            [
                'label' => 'Purpose',
                'entry' => $sections['purpose'] ?? null,
                'title' => 'Purpose and objectives',
                'body' => 'Encourage students to apply technology and innovation to real sustainability problems, and to present workable smart-city solutions to an industry audience.',
            ],
            [
                'label' => 'Benefits',
                'entry' => $sections['benefits'] ?? null,
                'title' => 'Participant benefits',
                'body' => implode("\n", [
                    'Industry exposure and mentorship',
                    'Recognition for sustainable innovation',
                    'Hands-on experience building smart-city solutions',
                    'Networking with the ASE community and partners',
                ]),
            ],
        ];
    @endphp

    <section class="gx-panel home-section relative flex w-full flex-col overflow-hidden bg-dark-navy tracking-[-0.02em]">
        <div class="absolute inset-0 bg-cover bg-center bg-no-repeat"
             style="background-image: url('{{ asset('assets/img/section2.jpg') }}')"
             aria-hidden="true"></div>

        {{-- Two crossed gradients read as a photographic vignette: the copy side
             stays dark enough for white text while the sculpture keeps its sky. --}}
        <div class="absolute inset-0 bg-gradient-to-r from-dark-navy/95 via-dark-navy/90 to-dark-navy/70" aria-hidden="true"></div>
        <div class="absolute inset-0 home-section-glow" aria-hidden="true"></div>

        <div class="relative flex w-full flex-1 items-center px-6 pt-24 pb-12 sm:px-10 md:px-14 md:pt-28">
            <div class="grid w-full gap-10 md:grid-cols-12 md:gap-14">

                {{-- Left: the statement --}}
                <div class="gx-reveal md:col-span-5" data-reveal>
                    <p class="text-xs font-medium uppercase tracking-[0.3em] text-cyan-tech">
                        {{ config('greenexe.event.name') }}
                    </p>

                    <h2 class="mt-4 leading-[0.95] text-white">
                        <span class="block font-playfair text-4xl font-normal italic sm:text-5xl md:text-6xl"
                              style="letter-spacing: -0.05em">What the</span>
                        <span class="-mt-1 block text-4xl font-normal sm:text-5xl md:text-6xl"
                              style="letter-spacing: -0.08em">competition is about</span>
                    </h2>

                    <p class="mt-6 max-w-sm text-sm leading-relaxed text-white/70 md:text-base">
                        {{ config('greenexe.event.tagline') }}
                    </p>

                    <a href="{{ route('competition') }}"
                       class="group mt-8 inline-flex items-center gap-2 text-sm font-medium text-white">
                        <span class="border-b border-cyan-tech/50 pb-1 transition-colors group-hover:border-cyan-tech group-hover:text-cyan-tech">
                            View full competition information
                        </span>
                        <span class="transition-transform group-hover:translate-x-1">&rarr;</span>
                    </a>
                </div>

                {{-- Right: the three sections as an index, not as boxes --}}
                <div class="md:col-span-6 md:col-start-7">
                    @foreach ($panelCards as $index => $card)
                        @php
                            $title = $card['entry']->title ?? $card['title'];
                            $body = $card['entry']->body ?? $card['body'];
                            $lines = preg_split('/\R+/', trim($body));
                        @endphp

                        <article class="gx-reveal home-index-card group relative border-t border-white/15 py-5 first:border-t-0 first:pt-0 md:py-7 md:first:pt-0"
                                 data-reveal style="transition-delay: {{ 0.1 * ($index + 1) }}s">
                            {{-- Hairline that draws itself in on hover. --}}
                            <span class="absolute left-0 top-0 h-px w-0 bg-gradient-to-r from-cyan-tech to-transparent transition-all duration-700 group-hover:w-full"
                                  aria-hidden="true"></span>

                            <div class="flex items-baseline gap-4">
                                <span class="font-playfair text-sm italic text-cyan-tech/80">0{{ $index + 1 }}</span>
                                <span class="text-[11px] font-medium uppercase tracking-[0.3em] text-white/45">
                                    {{ $card['label'] }}
                                </span>
                            </div>

                            <h3 class="mt-2 text-xl font-medium text-white transition-colors group-hover:text-cyan-tech md:text-2xl"
                                style="letter-spacing: -0.04em">
                                {{ $title }}
                            </h3>

                            @if (count($lines) > 1)
                                <ul class="mt-3 grid gap-x-6 gap-y-1.5 text-sm leading-relaxed text-white/70 sm:grid-cols-2">
                                    @foreach ($lines as $line)
                                        <li class="flex gap-2.5">
                                            <span class="mt-2 h-1 w-1 shrink-0 rounded-full bg-fresh-green"></span>
                                            <span>{{ $line }}</span>
                                        </li>
                                    @endforeach
                                </ul>
                            @else
                                <p class="mt-3 max-w-xl text-sm leading-relaxed text-white/70">{{ $lines[0] }}</p>
                            @endif
                        </article>
                    @endforeach
                </div>
            </div>
        </div>
    </section>

    {{-- Smart Green City highlights (FR-6) --}}
    <section class="gx-panel relative flex w-full flex-col overflow-hidden bg-dark-navy tracking-[-0.02em]">
        {{-- Ambient background loop. The panel is exactly one viewport tall and
             clips its overflow, so the video simply fills it; the scrim keeps the
             headline, controls and cards readable over the moving footage. --}}
        <video class="absolute inset-0 h-full w-full object-cover"
               autoplay muted loop playsinline preload="metadata"
               poster="{{ asset('assets/video/smart-city-highlights-poster.jpg') }}"
               aria-hidden="true" tabindex="-1" data-ambient-video>
            <source src="{{ asset('assets/video/smart-city-highlights.webm') }}" type="video/webm">
            <source src="{{ asset('assets/video/smart-city-highlights.mp4') }}" type="video/mp4">
        </video>
        <div class="absolute inset-0 bg-gradient-to-b from-dark-navy/70 via-dark-navy/85 to-dark-navy/95" aria-hidden="true"></div>

        <div class="relative flex w-full flex-1 flex-col pt-24 pb-10 md:pt-28 md:pb-14">
            <div class="gx-reveal flex flex-wrap items-end justify-between gap-4 px-6 sm:px-10 md:px-14" data-reveal>
                <div>
                    <p class="text-xs font-medium uppercase tracking-[0.3em] text-cyan-tech">Nine pillars</p>
                    <p id="carousel-hint" class="sr-only">
                        Use the arrow keys, or the previous and next buttons, to move through the pillars.
                    </p>
                    <h2 class="mt-3 leading-[0.95] text-white">
                        <span class="block font-playfair text-4xl font-normal italic sm:text-5xl md:text-6xl"
                              style="letter-spacing: -0.05em">Smart Green</span>
                        <span class="-mt-1 block text-4xl font-normal sm:text-5xl md:text-6xl"
                              style="letter-spacing: -0.08em">City highlights</span>
                    </h2>
                </div>

                {{-- Track controls; hidden from assistive tech since the track
                     itself is keyboard scrollable. --}}
                <div class="flex items-center gap-3" data-carousel-controls>
                    <span class="text-xs tabular-nums text-white/50">
                        <span data-carousel-current>01</span> / {{ str_pad($highlights->count() ?: 9, 2, '0', STR_PAD_LEFT) }}
                    </span>
                    <button type="button"
                            class="grid h-10 w-10 place-items-center rounded-full border border-white/20 text-white transition hover:border-cyan-tech hover:text-cyan-tech disabled:opacity-30 disabled:hover:border-white/20 disabled:hover:text-white"
                            data-carousel-prev aria-label="Previous highlight">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"></path>
                        </svg>
                    </button>
                    <button type="button"
                            class="grid h-10 w-10 place-items-center rounded-full border border-white/20 text-white transition hover:border-cyan-tech hover:text-cyan-tech disabled:opacity-30 disabled:hover:border-white/20 disabled:hover:text-white"
                            data-carousel-next aria-label="Next highlight">
                        <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"></path>
                        </svg>
                    </button>
                </div>
            </div>

            {{-- Horizontal track: native scrolling, so wheel, trackpad, touch and
                 keyboard all work; the buttons only nudge scrollLeft. --}}
            <div class="gx-track mt-8 flex flex-1 gap-4 overflow-x-auto px-6 pb-4 sm:px-10 md:mt-10 md:gap-6 md:px-14"
                 tabindex="0" role="group"
                 aria-label="Smart Green City pillars, scrollable"
                 aria-describedby="carousel-hint"
                 data-carousel-track>
                @php
                    // Until every pillar has a photograph, each slide gets its own
                    // duotone so the row does not read as nine identical cards.
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

                @forelse ($highlights as $index => $highlight)
                    @php
                        $lines = preg_split('/\R+/', trim($highlight->description));
                        $lead = array_shift($lines);
                        $tint = $tints[$index % count($tints)];
                    @endphp

                    <article class="gx-slide group relative flex shrink-0 flex-col justify-end overflow-hidden rounded-3xl border border-white/10 bg-white/5"
                             data-carousel-slide>
                        @if ($highlight->image)
                            <div class="absolute inset-0 bg-cover bg-center transition-transform duration-700 group-hover:scale-105"
                                 style="background-image: url('{{ $highlight->image }}')" aria-hidden="true"></div>
                            <div class="absolute inset-0 bg-gradient-to-t from-dark-navy via-dark-navy/85 to-dark-navy/30" aria-hidden="true"></div>
                        @else
                            <div class="absolute inset-0 bg-gradient-to-br {{ $tint }}" aria-hidden="true"></div>
                            <div class="gx-grid-bg absolute inset-0 opacity-30" aria-hidden="true"></div>
                            <span class="gx-watermark" aria-hidden="true">{{ $highlight->icon ?? '🌿' }}</span>
                            <div class="absolute inset-0 bg-gradient-to-t from-dark-navy via-dark-navy/40 to-transparent" aria-hidden="true"></div>
                        @endif

                        <span class="gx-rank" aria-hidden="true">{{ $index + 1 }}</span>

                        <div class="relative flex h-full flex-col p-6 md:p-8">
                            <span class="text-2xl">{{ $highlight->icon ?? '🌿' }}</span>

                            <h3 class="mt-auto text-xl font-medium leading-tight text-white md:text-2xl"
                                style="letter-spacing: -0.04em">
                                {{ $highlight->title }}
                            </h3>

                            <p class="mt-3 text-sm leading-relaxed text-white/70">{{ $lead }}</p>

                            @if ($lines)
                                <ul class="mt-4 space-y-2 border-t border-white/10 pt-4 text-sm text-white/75">
                                    @foreach ($lines as $line)
                                        <li class="flex gap-2.5">
                                            <span class="mt-2 h-1 w-1 shrink-0 rounded-full bg-fresh-green"></span>
                                            <span>{{ $line }}</span>
                                        </li>
                                    @endforeach
                                </ul>
                            @endif
                        </div>
                    </article>
                @empty
                    <p class="text-light-gray/60">Smart Green City highlights will be published soon.</p>
                @endforelse
            </div>
        </div>
    </section>

    {{-- Closing call to action and registration (FR-23 to FR-38) --}}
    <section id="register"
             class="gx-panel gx-panel-flow relative flex w-full flex-col bg-dark-navy tracking-[-0.02em]">
        {{-- The panel is taller than the viewport once the form is in it, so the
             video is pinned inside it rather than stretched over its full height. --}}
        <div class="absolute inset-0" aria-hidden="true">
            <div class="sticky top-0 h-[100dvh] w-full overflow-hidden">
                <video class="h-full w-full object-cover"
                       autoplay muted loop playsinline preload="metadata"
                       poster="{{ asset('assets/video/ready-to-compete-poster.jpg') }}"
                       tabindex="-1" data-ambient-video>
                    <source src="{{ asset('assets/video/ready-to-compete.webm') }}" type="video/webm">
                    <source src="{{ asset('assets/video/ready-to-compete.mp4') }}" type="video/mp4">
                </video>
                {{-- The form scrolls the full height of this panel, so the scrim
                     stays heavy throughout rather than fading in one direction. --}}
                <div class="absolute inset-0 bg-dark-navy/85"></div>
                <div class="absolute inset-0 bg-gradient-to-b from-dark-navy/60 via-transparent to-dark-navy/70"></div>
            </div>
        </div>

        <div class="relative mx-auto w-full max-w-4xl px-6 pt-24 pb-16 sm:px-8 md:pt-28">

            {{-- Intro, centred above the form --}}
            <div class="gx-reveal text-center" data-reveal>
                <p class="inline-flex items-center gap-2 rounded-full border border-cyan-tech/40 bg-cyan-tech/10 px-4 py-1.5 text-xs font-medium uppercase tracking-[0.3em] text-cyan-tech">
                    @if (config('greenexe.registration.open'))
                        <span class="h-1.5 w-1.5 rounded-full bg-fresh-green"></span>
                        Registration open
                    @else
                        <span class="h-1.5 w-1.5 rounded-full bg-red-400"></span>
                        Registration closed
                    @endif
                </p>

                <h2 class="mt-6 leading-[0.95] text-white">
                    <span class="block font-playfair text-5xl font-normal italic sm:text-6xl"
                          style="letter-spacing: -0.05em">Ready to</span>
                    <span class="-mt-1 block text-5xl font-normal sm:text-6xl"
                          style="letter-spacing: -0.08em">compete?</span>
                </h2>

                <p class="mx-auto mt-6 max-w-lg text-sm leading-relaxed text-white/80 md:text-base">
                    Teams of {{ config('greenexe.team.min_members') }}–{{ config('greenexe.team.max_members') }} members.
                    Member 1 is the team leader.
                    @if ($closesAt = config('greenexe.registration.closes_at'))
                        Entries close on {{ \Illuminate\Support\Carbon::parse($closesAt)->format('j F Y') }}.
                    @endif
                </p>

                <a href="{{ route('rules') }}"
                   class="group mt-6 inline-flex items-center gap-2 text-sm font-medium text-white/80 transition-colors hover:text-cyan-tech">
                    Rules &amp; eligibility
                    <span class="transition-transform group-hover:translate-x-1">&rarr;</span>
                </a>
            </div>

            {{-- Form, in the same centred column --}}
            <div class="mt-12">
                @if (config('greenexe.registration.open'))
                    @include('partials.registration-form')
                @else
                    <div class="gx-card bg-white/10 text-center">
                        <h3 class="text-xl font-medium text-white" style="letter-spacing: -0.04em">
                            Registration is closed
                        </h3>
                        <p class="mx-auto mt-3 max-w-md text-sm leading-relaxed text-white/75">
                            Entries are not being accepted at the moment. Check the
                            <a href="{{ route('faq') }}" class="text-cyan-tech hover:underline">FAQ</a>
                            or <a href="{{ route('contact') }}" class="text-cyan-tech hover:underline">contact the organisers</a>
                            for the next round.
                        </p>
                    </div>
                @endif
            </div>
        </div>
    </section>
    </div>
@endsection
