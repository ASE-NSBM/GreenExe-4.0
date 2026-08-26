@extends('layouts.app')

@section('title', config('greenexe.event.name').' — '.config('greenexe.event.concept'))

@section('html_class', 'gx-stack-root')

@section('content')
    {{-- Each panel is pinned to the top of the viewport, so the next one slides
         up and takes it over. Panels are opaque for that reason. --}}
    <div class="gx-stack">
        {{-- Snap stops, kept off the pinned panels themselves. --}}
        <div class="gx-snap-rail" aria-hidden="true">
            <div class="gx-snap-stop"></div>
            <div class="gx-snap-stop"></div>
            <div class="gx-snap-stop"></div>
            <div class="gx-snap-stop"></div>
        </div>

    {{-- Hero (FR-1, FR-2, FR-3, FR-5) --}}
    <section class="gx-panel relative w-full overflow-hidden bg-black tracking-[-0.02em]"
             data-hero>

        {{-- 1. Base plate --}}
        <div class="hero-zoom absolute inset-0 z-10 bg-cover bg-center bg-no-repeat"
             style="background-image: url('{{ asset('assets/img/bg1.jpeg') }}')"
             aria-hidden="true"></div>

        {{-- 2. Reveal plate, unmasked until the spotlight mask is attached in JS --}}
        <canvas class="pointer-events-none absolute inset-0" style="display: none" data-hero-canvas></canvas>
        <div class="pointer-events-none absolute inset-0 z-30 bg-cover bg-center bg-no-repeat opacity-0"
             style="background-image: url('{{ asset('assets/img/bg2.jpeg') }}')"
             aria-hidden="true"
             data-hero-reveal></div>

        {{-- 3. Headline --}}
        <div class="pointer-events-none absolute top-[14%] left-0 right-0 z-50 flex flex-col items-center px-5 text-center">
            <p class="hero-anim hero-fade mb-4 text-xs font-medium uppercase tracking-[0.35em] text-white/70 sm:text-sm"
               style="animation-delay: 0.1s">
                {{ config('greenexe.event.name') }}
            </p>

            <h1 class="leading-[0.95] text-white">
                <span class="hero-anim hero-reveal block font-playfair text-5xl font-normal italic sm:text-7xl md:text-8xl"
                      style="letter-spacing: -0.05em; animation-delay: 0.25s">Build the</span>
                <span class="hero-anim hero-reveal -mt-1 block text-5xl font-normal sm:text-7xl md:text-8xl"
                      style="letter-spacing: -0.08em; animation-delay: 0.42s">{{ config('greenexe.event.concept') }}</span>
            </h1>
        </div>

        {{-- 4. Bottom-left copy --}}
        <div class="hero-anim hero-fade absolute bottom-14 left-10 z-50 hidden max-w-[260px] sm:block md:left-14"
             style="animation-delay: 0.7s">
            <p class="text-sm leading-relaxed text-white/80">
                An enhanced smart-city experience inspired by {{ config('greenexe.event.university') }}, where green
                spaces, intelligent infrastructure, connectivity and automation work together.
            </p>
        </div>

        {{-- 5. Bottom-right copy and call to action --}}
        <div class="hero-anim hero-fade absolute bottom-10 left-5 right-5 z-50 flex max-w-full flex-col items-start gap-4 sm:bottom-24 sm:left-auto sm:right-10 sm:max-w-[260px] sm:gap-5 md:right-14"
             style="animation-delay: 0.85s">
            <p class="text-xs leading-relaxed text-white/80 sm:text-sm">
                Teams of {{ config('greenexe.team.min_members') }}–{{ config('greenexe.team.max_members') }} students
                design technology that turns a green environment into a connected, efficient and sustainable city.
                Organised by the {{ config('greenexe.event.organizer') }}.
            </p>
            <a href="{{ route('register') }}"
               class="rounded-full bg-[#e8702a] px-7 py-3 text-sm font-medium text-white transition-all hover:scale-[1.03] hover:bg-[#d2611f] hover:shadow-lg hover:shadow-[#e8702a]/30 active:scale-95">
                Register Now
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

    <section class="gx-panel relative flex w-full flex-col overflow-hidden bg-dark-navy tracking-[-0.02em]">
        <div class="absolute inset-0 bg-cover bg-center bg-no-repeat"
             style="background-image: url('{{ asset('assets/img/section2.jpg') }}')"
             aria-hidden="true"></div>

        {{-- Two crossed gradients read as a photographic vignette: the copy side
             stays dark enough for white text while the sculpture keeps its sky. --}}
        <div class="absolute inset-0 bg-gradient-to-r from-dark-navy via-dark-navy/85 to-dark-navy/45" aria-hidden="true"></div>
        <div class="absolute inset-0 bg-gradient-to-t from-dark-navy via-dark-navy/25 to-dark-navy/75" aria-hidden="true"></div>

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

                        <article class="gx-reveal group relative border-t border-white/15 py-5 first:border-t-0 first:pt-0 md:py-7 md:first:pt-0"
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
        <div class="absolute inset-0 bg-gradient-to-b from-deep-green/50 via-dark-navy to-dark-navy" aria-hidden="true"></div>

        <div class="relative flex w-full flex-1 flex-col pt-24 pb-10 md:pt-28 md:pb-14">
            <div class="gx-reveal flex flex-wrap items-end justify-between gap-4 px-6 sm:px-10 md:px-14" data-reveal>
                <div>
                    <p class="text-xs font-medium uppercase tracking-[0.3em] text-cyan-tech">Nine pillars</p>
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
                 tabindex="0" role="group" aria-label="Smart Green City pillars" data-carousel-track>
                @forelse ($highlights as $index => $highlight)
                    @php
                        $lines = preg_split('/\R+/', trim($highlight->description));
                        $lead = array_shift($lines);
                    @endphp

                    <article class="gx-slide group relative flex shrink-0 snap-start flex-col justify-end overflow-hidden rounded-3xl border border-white/10 bg-white/5"
                             data-carousel-slide>
                        @if ($highlight->image)
                            <div class="absolute inset-0 bg-cover bg-center transition-transform duration-700 group-hover:scale-105"
                                 style="background-image: url('{{ $highlight->image }}')" aria-hidden="true"></div>
                            <div class="absolute inset-0 bg-gradient-to-t from-dark-navy via-dark-navy/85 to-dark-navy/30" aria-hidden="true"></div>
                        @else
                            <div class="absolute inset-0 bg-gradient-to-br from-deep-green/70 via-dark-navy to-dark-navy" aria-hidden="true"></div>
                            <div class="absolute inset-0 opacity-40 gx-grid-bg" aria-hidden="true"></div>
                        @endif

                        <div class="relative flex h-full flex-col p-6 md:p-8">
                            <div class="flex items-baseline gap-3">
                                <span class="font-playfair text-sm italic text-cyan-tech/80">{{ str_pad($index + 1, 2, '0', STR_PAD_LEFT) }}</span>
                                <span class="text-2xl">{{ $highlight->icon ?? '🌿' }}</span>
                            </div>

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

    {{-- Closing call to action --}}
    <section class="gx-panel relative flex w-full items-center overflow-hidden bg-dark-navy">
        <div class="absolute inset-0 bg-gradient-to-b from-dark-navy via-deep-green/40 to-dark-navy" aria-hidden="true"></div>

        <div class="relative mx-auto w-full max-w-5xl px-4 pt-20">
            <div class="gx-card flex flex-col items-center gap-6 text-center sm:flex-row sm:justify-between sm:text-left">
                <div>
                    <h2 class="font-display text-2xl font-semibold text-white sm:text-3xl">Ready to compete?</h2>
                    <p class="mt-2 text-light-gray/70">
                        Teams of {{ config('greenexe.team.min_members') }}–{{ config('greenexe.team.max_members') }} members. Registration takes a few minutes.
                    </p>
                </div>
                <a href="{{ route('register') }}" class="gx-btn-primary shrink-0">Register Now</a>
            </div>
        </div>
    </section>
    </div>
@endsection
