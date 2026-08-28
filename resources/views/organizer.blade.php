@extends('layouts.app')

@section('title', 'Organizer — ' . config('greenexe.event.name'))

@php
    $org = config('greenexe.organizer');
    $contact = config('greenexe.contact');
    $telHref = 'tel:' . preg_replace('/\s+/', '', $contact['phone']);

    // Narrative blocks the admin can add (FR-70).
    $blocks = $blocks ?? collect();

    // Stats configuration with rich verified defaults for count-up animation
    $stats = !empty($org['stats']) ? $org['stats'] : [
        ['value' => '500+', 'label' => 'Active Developers', 'sys' => 'SYS.MEMBERS'],
        ['value' => '20+', 'label' => 'Hackathons & Symposia', 'sys' => 'SYS.EVENTS'],
        ['value' => '8+', 'label' => 'Industry Tech Partners', 'sys' => 'SYS.ALLIANCES'],
        ['value' => '2015', 'label' => 'Year Established', 'sys' => 'SYS.FOUNDED'],
    ];

    $highlights = [
        [
            'num' => '01',
            'tag' => 'COMMUNITY.NODE',
            'label' => 'Community Ecosystem',
            'note' => 'Connecting passionate student developers, UI/UX engineers, and enterprise mentors',
            'path' => 'M16 11a3 3 0 1 0 0-6 3 3 0 0 0 0 6zM8 11a3 3 0 1 0 0-6 3 3 0 0 0 0 6zm0 2c-2.7 0-6 1.34-6 4v2h9v-2c0-1 .4-1.9 1.1-2.6C10.9 13.4 9.3 13 8 13zm8 0c-.5 0-1 .05-1.5.13.9.8 1.5 1.83 1.5 2.87v2h6v-2c0-2.66-3.3-4-6-4z',
            'gradient' => 'from-smart-green/20 to-cyan-tech/10'
        ],
        [
            'num' => '02',
            'tag' => 'ENGINE.EXCELLENCE',
            'label' => 'Technical Excellence',
            'note' => 'Fostering high-performance software engineering, algorithmic rigor, and cloud architecture',
            'path' => 'M12 2a10 10 0 1 0 0 20 10 10 0 0 0 0-20zm0 4a6 6 0 1 0 0 12 6 6 0 0 0 0-12zm0 4a2 2 0 1 0 0 4 2 2 0 0 0 0-4z',
            'gradient' => 'from-cyan-tech/20 to-fresh-green/10'
        ],
        [
            'num' => '03',
            'tag' => 'PROTOCOL.INNOVATION',
            'label' => 'Smart Green Living',
            'note' => 'Building transformative sustainable technology for future eco-cities and IoT ecosystems',
            'path' => 'M13 2 4 14h6l-1 8 9-12h-6l1-8z',
            'gradient' => 'from-fresh-green/20 to-eco-lime/10'
        ],
    ];
@endphp

@section('content')
    <div class="relative overflow-hidden selection:bg-cyan-tech selection:text-dark-navy">
        {{-- Ambient Futuristic Laser & Grid Background --}}
        <div class="gx-grid-bg absolute inset-0 opacity-20 pointer-events-none" aria-hidden="true"></div>
        <div class="pointer-events-none absolute -top-40 left-1/2 -translate-x-1/2 h-[550px] w-[550px] rounded-full bg-gradient-to-br from-smart-green/25 via-cyan-tech/20 to-transparent blur-[150px]"
            aria-hidden="true"></div>
        <div class="pointer-events-none absolute top-1/3 -left-48 h-[450px] w-[450px] rounded-full bg-fresh-green/15 blur-[140px]"
            aria-hidden="true"></div>
        <div class="pointer-events-none absolute top-2/3 -right-48 h-[450px] w-[450px] rounded-full bg-cyan-tech/15 blur-[140px]"
            aria-hidden="true"></div>

        {{-- Floating Cyber Circuit Particle Nodes --}}
        <div class="pointer-events-none absolute top-44 left-10 h-2 w-2 rounded-full bg-cyan-tech shadow-[0_0_12px_#35d0c8] animate-ping" style="animation-duration: 3.5s;" aria-hidden="true"></div>
        <div class="pointer-events-none absolute top-64 right-16 h-2.5 w-2.5 rounded-full bg-fresh-green shadow-[0_0_15px_#6bcb77] animate-pulse" style="animation-duration: 2.8s;" aria-hidden="true"></div>
        <div class="pointer-events-none absolute top-1/2 left-20 h-1.5 w-1.5 rounded-full bg-eco-lime shadow-[0_0_10px_#b7e66a] animate-bounce" style="animation-duration: 4.2s;" aria-hidden="true"></div>

        <section class="relative mx-auto max-w-6xl px-4 pb-24 sm:pb-32 tracking-[-0.02em]" style="padding-top: clamp(140px, 18vh, 190px);">

            {{-- 1. Futuristic Hologram Command Hero --------------------------- --}}
            <div class="relative mx-auto flex max-w-4xl flex-col items-center text-center">
                {{-- Hologram Orb & Rotating Orbit Reticle --}}
                <div class="hero-anim hero-fade mb-6 relative flex flex-col items-center" style="animation-delay: 0.1s">
                    {{-- Outer Rotating Sci-Fi Dashed Orbit Ring --}}
                    <div class="pointer-events-none absolute -inset-10 sm:-inset-12 rounded-full border border-dashed border-cyan-tech/30 animate-[spin_20s_linear_infinite]" aria-hidden="true"></div>
                    
                    {{-- Inner Pulsing Energy Waves --}}
                    <div class="pointer-events-none absolute -inset-6 rounded-full border border-fresh-green/20 animate-ping opacity-30" style="animation-duration: 3s;" aria-hidden="true"></div>

                    {{-- Floating Glass Hologram Logo Container --}}
                    <div class="gx-float relative z-10">
                        <div class="absolute -inset-4 rounded-3xl bg-gradient-to-r from-smart-green/50 via-cyan-tech/50 to-fresh-green/40 blur-2xl opacity-90 animate-pulse" aria-hidden="true"></div>
                        <div class="gx-logo-glow relative rounded-3xl border border-cyan-tech/40 bg-dark-navy/60 p-2.5 backdrop-blur-md shadow-[0_0_35px_rgba(53,208,200,0.35)] transition-transform duration-500 hover:scale-110">
                            @include('partials.ase-logo', ['class' => 'h-24 w-24 sm:h-28 sm:w-28', 'label' => 'text-4xl sm:text-5xl'])
                        </div>
                    </div>

                    {{-- Organization Badge --}}
                    <div class="mt-7 inline-flex items-center gap-2 rounded-full border border-cyan-tech/40 bg-gradient-to-r from-cyan-tech/15 via-smart-green/15 to-transparent px-5 py-2 text-xs sm:text-sm font-display font-bold uppercase tracking-[0.2em] text-white shadow-[0_0_20px_rgba(53,208,200,0.25)] backdrop-blur-lg">
                        <span class="relative flex h-2 w-2">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-fresh-green opacity-75"></span>
                            <span class="relative inline-flex rounded-full h-2 w-2 bg-fresh-green"></span>
                        </span>
                        <span>{{ $org['name'] }}</span>
                        <span class="text-cyan-tech font-extrabold">· NSBM</span>
                    </div>
                </div>

                {{-- Cinematic Dual-Typography Headline --}}
                <h1 class="leading-[1.02] text-white text-center">
                    <span class="hero-anim hero-reveal block font-playfair text-5xl font-normal italic sm:text-6xl md:text-7xl lg:text-8xl"
                        style="letter-spacing: -0.04em; animation-delay: 0.25s">
                        Empowering
                    </span>
                    <span class="hero-anim hero-reveal mt-1 block text-4xl font-normal sm:text-6xl md:text-7xl lg:text-8xl tracking-tight text-white"
                        style="letter-spacing: -0.06em; animation-delay: 0.42s">
                        Future Innovators
                    </span>
                </h1>

                {{-- Statement --}}
                <p class="hero-anim hero-fade mx-auto mt-6 max-w-2xl text-center text-sm leading-relaxed text-light-gray/80 sm:text-base"
                    style="animation-delay: 0.6s">
                    The official organizing body representing Software Engineering undergraduates at
                    {{ config('greenexe.event.university') }}, architecting sustainable software solutions and smart urban innovation.
                </p>

                {{-- Interactive Cyber Action Buttons --}}
                <div class="hero-anim hero-fade mt-8 flex flex-wrap items-center justify-center gap-3 text-xs" style="animation-delay: 0.75s">
                    <a href="#contact"
                        class="gx-btn-primary px-7 py-3 text-xs tracking-wider uppercase font-bold hover:scale-105 active:scale-95 shadow-[0_0_25px_rgba(46,139,87,0.4)]">
                        Get in Touch with ASE &rarr;
                    </a>
                    <a href="#pillars"
                        class="gx-btn-ghost px-6 py-3 text-xs tracking-wider uppercase font-medium hover:scale-105 active:scale-95">
                        Our Core Values
                    </a>
                </div>
            </div>

            {{-- 2. System Pillars Grid --}}
            <div id="pillars" class="mt-24 scroll-mt-28">
                <div class="mb-8 flex items-center justify-between border-b border-white/10 pb-4">
                    <div class="flex items-center gap-3">
                        <span class="grid h-7 w-7 place-items-center rounded-lg bg-cyan-tech/10 text-xs font-bold text-cyan-tech border border-cyan-tech/30">01</span>
                        <h2 class="font-display text-xl sm:text-2xl font-bold tracking-tight text-white">Our Core Pillars &amp; Focus</h2>
                    </div>
                </div>

                <div class="grid gap-6 sm:grid-cols-3">
                    @foreach ($highlights as $i => $h)
                        <div class="gx-card gx-reveal group relative flex flex-col justify-between overflow-hidden border-cyan-tech/20 bg-gradient-to-b from-dark-navy/90 to-dark-navy/95 p-6 transition-all duration-500 hover:-translate-y-2 hover:border-cyan-tech/60 hover:shadow-[0_15px_35px_-10px_rgba(53,208,200,0.2)]"
                            data-reveal data-reveal-delay="{{ 0.12 + $i * 0.08 }}">
                            {{-- Sci-Fi Corner Brackets --}}
                            <div class="absolute top-0 left-0 h-3 w-3 border-t-2 border-l-2 border-cyan-tech/60 pointer-events-none"></div>
                            <div class="absolute bottom-0 right-0 h-3 w-3 border-b-2 border-r-2 border-cyan-tech/60 pointer-events-none"></div>

                            {{-- Animated Laser Sweep Hairline on Hover --}}
                            <span class="absolute left-0 top-0 h-px w-0 bg-gradient-to-r from-cyan-tech via-fresh-green to-transparent transition-all duration-700 group-hover:w-full" aria-hidden="true"></span>

                            {{-- Ghost Rank Numeral --}}
                            <span class="gx-rank pointer-events-none opacity-30 text-7xl group-hover:text-cyan-tech/30 group-hover:scale-105 transition-all duration-500"
                                aria-hidden="true">{{ $h['num'] }}</span>

                            <div>
                                <span
                                    class="grid h-12 w-12 place-items-center rounded-2xl bg-gradient-to-br from-smart-green/20 via-cyan-tech/15 to-transparent text-cyan-tech border border-cyan-tech/30 transition duration-300 group-hover:scale-110 group-hover:bg-cyan-tech/20 group-hover:border-cyan-tech">
                                    <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                        <path d="{{ $h['path'] }}" />
                                    </svg>
                                </span>
                                <h3 class="mt-5 font-display text-lg font-bold text-white group-hover:text-cyan-tech transition-colors">
                                    {{ $h['label'] }}
                                </h3>
                            </div>
                            <p class="mt-3 text-xs leading-relaxed text-light-gray/75 relative z-10">{{ $h['note'] }}</p>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- 3. Telemetry Statistics Grid ---------- --}}
            <div id="stats" class="mt-16 scroll-mt-28">
                <div class="gx-reveal grid gap-4 grid-cols-2 lg:grid-cols-4" data-reveal>
                    @foreach ($stats as $i => $stat)
                        <div class="gx-card group relative overflow-hidden border-white/10 bg-dark-navy/70 p-6 text-center transition-all duration-300 hover:border-cyan-tech/40 hover:-translate-y-1 hover:shadow-lg hover:shadow-cyan-tech/10"
                            data-reveal-delay="{{ $i * 0.08 }}">
                            <div class="gx-grid-bg absolute inset-0 opacity-10 pointer-events-none"></div>
                            <p class="font-display text-4xl sm:text-5xl font-extrabold text-transparent bg-clip-text bg-gradient-to-r from-fresh-green via-cyan-tech to-eco-lime drop-shadow-[0_0_15px_rgba(53,208,200,0.3)]"
                                data-count="{{ $stat['value'] }}">{{ $stat['value'] }}</p>
                            <p class="mt-2 text-xs sm:text-sm font-medium uppercase tracking-wider text-light-gray/80">
                                {{ $stat['label'] }}
                            </p>
                        </div>
                    @endforeach
                </div>
            </div>

            {{-- 4. Mission & Vision Dual Showcase ---------------------- --}}
            <div id="mission" class="mt-16 scroll-mt-28 grid gap-6 md:grid-cols-2">
                {{-- Mission Card --}}
                <div class="gx-card gx-reveal group relative flex flex-col justify-between overflow-hidden border-l-4 border-l-fresh-green bg-gradient-to-br from-dark-navy/90 to-deep-green/30 p-8 sm:p-10 transition-all duration-500 hover:-translate-y-2 hover:border-fresh-green/80 hover:shadow-xl hover:shadow-fresh-green/10"
                    data-reveal>
                    <span class="absolute left-0 top-0 h-px w-0 bg-gradient-to-r from-fresh-green to-transparent transition-all duration-700 group-hover:w-full" aria-hidden="true"></span>
                    <div class="pointer-events-none absolute -right-10 -top-10 h-36 w-36 rounded-full bg-fresh-green/15 blur-3xl"></div>

                    <div>
                        <div class="flex items-baseline gap-3">
                            <span class="font-playfair text-sm italic text-fresh-green">01</span>
                            <span class="text-[11px] font-semibold uppercase tracking-[0.25em] text-fresh-green">
                                Our Mission
                            </span>
                        </div>
                        <h3 class="mt-4 font-display text-2xl font-bold text-white">Driving Student Tech Excellence</h3>
                        <p class="mt-3 text-sm leading-relaxed text-light-gray/80">{{ $org['mission'] }}</p>
                    </div>
                </div>

                {{-- Vision Card --}}
                <div class="gx-card gx-reveal group relative flex flex-col justify-between overflow-hidden border-l-4 border-l-cyan-tech bg-gradient-to-br from-dark-navy/90 to-cyan-tech/10 p-8 sm:p-10 transition-all duration-500 hover:-translate-y-2 hover:border-cyan-tech/80 hover:shadow-xl hover:shadow-cyan-tech/10"
                    data-reveal style="transition-delay: .1s">
                    <span class="absolute left-0 top-0 h-px w-0 bg-gradient-to-r from-cyan-tech to-transparent transition-all duration-700 group-hover:w-full" aria-hidden="true"></span>
                    <div class="pointer-events-none absolute -right-10 -top-10 h-36 w-36 rounded-full bg-cyan-tech/15 blur-3xl"></div>

                    <div>
                        <div class="flex items-baseline gap-3">
                            <span class="font-playfair text-sm italic text-cyan-tech">02</span>
                            <span class="text-[11px] font-semibold uppercase tracking-[0.25em] text-cyan-tech">
                                Our Vision
                            </span>
                        </div>
                        <h3 class="mt-4 font-display text-2xl font-bold text-white">Shaping Tomorrow's Tech Leaders</h3>
                        <p class="mt-3 text-sm leading-relaxed text-light-gray/80">{{ $org['vision'] }}</p>
                    </div>
                </div>
            </div>

            {{-- 5. Purpose & Motivation Spotlight Card ------------------- --}}
            <div class="gx-reveal mt-16 scroll-mt-28" data-reveal>
                <div class="gx-card group relative mx-auto max-w-4xl overflow-hidden border-cyan-tech/30 bg-gradient-to-b from-deep-green/40 via-dark-navy to-dark-navy p-8 sm:p-12 text-center shadow-2xl shadow-cyan-tech/5 transition-all duration-500 hover:border-cyan-tech/50 hover:shadow-cyan-tech/15">
                    {{-- Corner Accents --}}
                    <div class="absolute top-0 left-0 h-4 w-4 border-t-2 border-l-2 border-cyan-tech pointer-events-none"></div>
                    <div class="absolute bottom-0 right-0 h-4 w-4 border-b-2 border-r-2 border-cyan-tech pointer-events-none"></div>
                    
                    <span class="absolute left-0 top-0 h-px w-0 bg-gradient-to-r from-cyan-tech via-fresh-green to-transparent transition-all duration-700 group-hover:w-full" aria-hidden="true"></span>

                    <div class="pointer-events-none absolute -top-24 left-1/2 -translate-x-1/2 h-64 w-64 rounded-full bg-cyan-tech/15 blur-3xl"></div>
                    <div class="gx-grid-bg absolute inset-0 opacity-15 pointer-events-none"></div>

                    <div class="relative z-10">
                        <div class="flex items-center justify-center gap-2.5">
                            <span class="font-playfair text-sm italic text-cyan-tech">03</span>
                            <span class="text-[11px] font-semibold uppercase tracking-[0.25em] text-cyan-tech">
                                Purpose &amp; Motivation
                            </span>
                        </div>

                        <h3 class="mt-3 font-display text-2xl sm:text-3xl font-bold text-white">
                            Why We Organize <span class="font-playfair italic font-normal text-cyan-tech">{{ config('greenexe.event.name') }}</span>
                        </h3>

                        {{-- Minimalist Philosophy Statement --}}
                        <p class="mx-auto mt-4 max-w-2xl text-base sm:text-lg leading-relaxed text-light-gray/90 italic">
                            “Turning green ideas into functional smart-city technology through collaborative engineering and real-world impact.”
                        </p>

                        {{-- Clean Action Buttons --}}
                        <div class="mt-8 flex flex-wrap items-center justify-center gap-3">
                            <a href="{{ route('competition') }}"
                                class="gx-btn-primary text-xs px-6 py-2.5 hover:scale-105 active:scale-95 shadow-lg shadow-smart-green/20">
                                Competition Track &rarr;
                            </a>
                            <a href="{{ route('register') }}"
                                class="gx-btn-ghost text-xs px-6 py-2.5 hover:scale-105 active:scale-95">
                                Register Your Team
                            </a>
                        </div>
                    </div>
                </div>
            </div>

            {{-- 6. Optional Admin Narrative Blocks (FR-70) ------------------- --}}
            @if ($blocks->isNotEmpty())
                <div class="mt-12 grid gap-6 md:grid-cols-2">
                    @foreach ($blocks as $block)
                        <article class="gx-card gx-reveal group relative overflow-hidden border-white/10 transition-all duration-300 hover:border-cyan-tech/40 hover:-translate-y-1" data-reveal
                            data-reveal-delay="{{ $loop->index * 0.08 }}">
                            <span class="absolute left-0 top-0 h-px w-0 bg-gradient-to-r from-cyan-tech to-transparent transition-all duration-700 group-hover:w-full" aria-hidden="true"></span>
                            <h3 class="font-display text-lg font-semibold text-white">{{ $block->title }}</h3>
                            <p class="mt-3 whitespace-pre-line text-sm leading-relaxed text-light-gray/75">{{ $block->body }}</p>
                        </article>
                    @endforeach
                </div>
            @endif

            {{-- 7. Contact Hub ---------------------------------------------- --}}
            <div id="contact" class="mt-24 scroll-mt-28">
                <div class="gx-reveal text-center" data-reveal>
                    <p class="text-xs font-semibold uppercase tracking-[0.3em] text-cyan-tech">Direct Channels</p>
                    <h2 class="mt-3 leading-[0.95] text-white">
                        <span class="font-playfair text-4xl sm:text-5xl font-normal italic">Connect with</span>
                        <span class="block text-4xl sm:text-5xl font-bold mt-1 text-white">{{ $org['short_name'] }}</span>
                    </h2>
                    <p class="mx-auto mt-4 max-w-xl text-sm text-light-gray/70">
                        Inquiries regarding {{ config('greenexe.event.name') }} tracks, technical guidelines, or sponsorships? Reach our executive desk.
                    </p>
                </div>

                {{-- Contact Action Modules --}}
                <div class="mt-12 grid gap-6 sm:grid-cols-3">
                    {{-- 1. Email Comm Channel --}}
                    <div class="gx-card gx-reveal group relative flex flex-col justify-between overflow-hidden border-white/10 transition-all duration-500 hover:-translate-y-2 hover:border-cyan-tech/50 hover:shadow-xl hover:shadow-cyan-tech/10"
                        data-reveal style="transition-delay: 0.08s">
                        <span class="absolute left-0 top-0 h-px w-0 bg-gradient-to-r from-cyan-tech to-transparent transition-all duration-700 group-hover:w-full" aria-hidden="true"></span>
                        <div>
                            <div class="flex items-center justify-between">
                                <span class="grid h-12 w-12 place-items-center rounded-2xl bg-smart-green/15 text-cyan-tech border border-cyan-tech/30 transition duration-300 group-hover:bg-cyan-tech/20 group-hover:scale-110">
                                    <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                        <path d="M3 5h18a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V6a1 1 0 0 1 1-1zm1.2 2 7.8 5.2L19.8 7z" />
                                    </svg>
                                </span>
                                <span class="rounded-full border border-cyan-tech/30 bg-cyan-tech/10 px-2.5 py-0.5 text-[10px] font-semibold text-cyan-tech">Email Channel</span>
                            </div>
                            <h3 class="mt-4 font-display text-sm font-semibold uppercase tracking-wider text-light-gray/60">Official Email</h3>
                            <a href="mailto:{{ $contact['email'] }}" class="mt-1 block font-display text-base font-semibold text-white hover:text-cyan-tech transition break-all">
                                {{ $contact['email'] }}
                            </a>
                            <p class="mt-2 text-xs text-light-gray/60">Average latency: &lt; 24 hours</p>
                        </div>

                        <div class="mt-6 flex items-center gap-2 border-t border-white/10 pt-4">
                            <a href="mailto:{{ $contact['email'] }}" class="gx-btn-primary flex-1 text-xs py-2 hover:scale-105 active:scale-95">
                                Send Email
                            </a>
                            <button type="button" data-copy-btn="{{ $contact['email'] }}"
                                class="gx-btn-ghost text-xs py-2 px-3 relative group/copy hover:border-cyan-tech hover:text-cyan-tech"
                                aria-label="Copy email to clipboard">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                </svg>
                                <span data-copy-feedback class="pointer-events-none absolute -top-8 left-1/2 -translate-x-1/2 rounded bg-dark-navy px-2 py-0.5 text-[10px] text-cyan-tech border border-cyan-tech/30 opacity-0 transition-opacity whitespace-nowrap shadow-lg">Copied!</span>
                            </button>
                        </div>
                    </div>

                    {{-- 2. Hotline Comm Channel --}}
                    <div class="gx-card gx-reveal group relative flex flex-col justify-between overflow-hidden border-white/10 transition-all duration-500 hover:-translate-y-2 hover:border-cyan-tech/50 hover:shadow-xl hover:shadow-cyan-tech/10"
                        data-reveal style="transition-delay: 0.16s">
                        <span class="absolute left-0 top-0 h-px w-0 bg-gradient-to-r from-cyan-tech to-transparent transition-all duration-700 group-hover:w-full" aria-hidden="true"></span>
                        <div>
                            <div class="flex items-center justify-between">
                                <span class="grid h-12 w-12 place-items-center rounded-2xl bg-smart-green/15 text-cyan-tech border border-cyan-tech/30 transition duration-300 group-hover:bg-cyan-tech/20 group-hover:scale-110">
                                    <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                        <path d="M6.6 10.8a15 15 0 0 0 6.6 6.6l2.2-2.2a1 1 0 0 1 1-.24 11 11 0 0 0 3.5.56 1 1 0 0 1 1 1V20a1 1 0 0 1-1 1A17 17 0 0 1 3 4a1 1 0 0 1 1-1h3.3a1 1 0 0 1 1 1 11 11 0 0 0 .56 3.5 1 1 0 0 1-.24 1z" />
                                    </svg>
                                </span>
                                <span class="rounded-full border border-cyan-tech/30 bg-cyan-tech/10 px-2.5 py-0.5 text-[10px] font-semibold text-cyan-tech">Hotline</span>
                            </div>
                            <h3 class="mt-4 font-display text-sm font-semibold uppercase tracking-wider text-light-gray/60">Phone Contact</h3>
                            <a href="{{ $telHref }}" class="mt-1 block font-display text-base font-semibold text-white hover:text-cyan-tech transition">
                                {{ $contact['phone'] }}
                            </a>
                            <p class="mt-2 text-xs text-light-gray/60">Active during university hours</p>
                        </div>

                        <div class="mt-6 flex items-center gap-2 border-t border-white/10 pt-4">
                            <a href="{{ $telHref }}" class="gx-btn-primary flex-1 text-xs py-2 hover:scale-105 active:scale-95">
                                Direct Call
                            </a>
                            <button type="button" data-copy-btn="{{ $contact['phone'] }}"
                                class="gx-btn-ghost text-xs py-2 px-3 relative group/copy hover:border-cyan-tech hover:text-cyan-tech"
                                aria-label="Copy phone number to clipboard">
                                <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" d="M8 16H6a2 2 0 01-2-2V6a2 2 0 012-2h8a2 2 0 012 2v2m-6 12h8a2 2 0 002-2v-8a2 2 0 00-2-2h-8a2 2 0 00-2 2v8a2 2 0 002 2z" />
                                </svg>
                                <span data-copy-feedback class="pointer-events-none absolute -top-8 left-1/2 -translate-x-1/2 rounded bg-dark-navy px-2 py-0.5 text-[10px] text-cyan-tech border border-cyan-tech/30 opacity-0 transition-opacity whitespace-nowrap shadow-lg">Copied!</span>
                            </button>
                        </div>
                    </div>

                    {{-- 3. Geo Coordinates Channel --}}
                    <div class="gx-card gx-reveal group relative flex flex-col justify-between overflow-hidden border-white/10 transition-all duration-500 hover:-translate-y-2 hover:border-cyan-tech/50 hover:shadow-xl hover:shadow-cyan-tech/10"
                        data-reveal style="transition-delay: 0.24s">
                        <span class="absolute left-0 top-0 h-px w-0 bg-gradient-to-r from-cyan-tech to-transparent transition-all duration-700 group-hover:w-full" aria-hidden="true"></span>
                        <div>
                            <div class="flex items-center justify-between">
                                <span class="grid h-12 w-12 place-items-center rounded-2xl bg-smart-green/15 text-cyan-tech border border-cyan-tech/30 transition duration-300 group-hover:bg-cyan-tech/20 group-hover:scale-110">
                                    <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true">
                                        <path d="M12 2a7 7 0 0 0-7 7c0 5 7 13 7 13s7-8 7-13a7 7 0 0 0-7-7zm0 9.5A2.5 2.5 0 1 1 12 6.5a2.5 2.5 0 0 1 0 5z" />
                                    </svg>
                                </span>
                                <span class="rounded-full border border-cyan-tech/30 bg-cyan-tech/10 px-2.5 py-0.5 text-[10px] font-semibold text-cyan-tech">Campus Base</span>
                            </div>
                            <h3 class="mt-4 font-display text-sm font-semibold uppercase tracking-wider text-light-gray/60">Campus Base Station</h3>
                            <p class="mt-1 font-display text-base font-semibold text-white">{{ $org['affiliation'] }}</p>
                            <p class="mt-2 text-xs leading-relaxed text-light-gray/60">{{ $contact['address'] }}</p>
                        </div>

                        <div class="mt-6 border-t border-white/10 pt-4">
                            <a href="{{ $contact['map_url'] }}" target="_blank" rel="noopener noreferrer"
                                class="gx-btn-primary w-full text-xs py-2 justify-center hover:scale-105 active:scale-95">
                                Open Map Location &rarr;
                            </a>
                        </div>
                    </div>
                </div>

                {{-- Social Connect Hub --}}
                <div id="follow-ase" class="gx-reveal mt-16 scroll-mt-28 text-center" data-reveal>
                    <span class="text-xs font-semibold uppercase tracking-[0.25em] text-cyan-tech">Social Channels</span>
                    <h3 class="mt-2 font-display text-2xl font-bold text-white">Connect with {{ $org['short_name'] }}</h3>
                    <p class="mt-2 text-sm text-light-gray/60">Real-time announcements, hackathon guidelines, and technical workshop notifications.</p>
                    <div class="mt-6 flex justify-center">
                        @include('partials.social-links')
                    </div>
                </div>
            </div>

            {{-- 8. Trust / Alliance Bar -------------------------------------- --}}
            <div class="gx-reveal mt-20 border-t border-white/10 pt-10 text-center" data-reveal>
                <p class="text-xs font-semibold uppercase tracking-[0.3em] text-light-gray/40">Official Affiliation</p>
                <div class="mt-4 flex flex-wrap items-center justify-center gap-x-6 gap-y-3 text-light-gray/80">
                    <span class="inline-flex items-center gap-2.5">
                        @include('partials.ase-logo', ['class' => 'h-8 w-8', 'label' => 'text-[10px]'])
                        <span class="font-display font-semibold text-white">{{ $org['name'] }}</span>
                    </span>
                    <span class="text-light-gray/30">·</span>
                    <span class="text-sm">In official charter with <span class="font-semibold text-white">{{ $org['affiliation'] }}</span></span>
                </div>
            </div>

            {{-- 9. Launchpad CTA Callout ------------------------------------ --}}
            <div class="gx-reveal mt-16" data-reveal>
                <div class="gx-card relative overflow-hidden border-cyan-tech/40 bg-gradient-to-br from-smart-green/25 via-dark-navy to-dark-navy p-8 text-center sm:p-12 shadow-[0_0_50px_rgba(53,208,200,0.15)]">
                    <div class="pointer-events-none absolute inset-0 bg-gradient-to-t from-dark-navy via-transparent to-transparent"></div>
                    <div class="relative z-10">
                        <span class="inline-flex items-center gap-2 rounded-full border border-cyan-tech/40 bg-cyan-tech/10 px-4 py-1.5 text-xs font-medium uppercase tracking-[0.3em] text-cyan-tech">
                            <span class="h-2 w-2 rounded-full bg-fresh-green animate-ping"></span>
                            Official Competition Track
                        </span>
                        <h2 class="mt-4 font-display text-3xl font-bold text-white sm:text-5xl">
                            Ready to Build the <span class="font-playfair italic font-normal text-transparent bg-clip-text bg-gradient-to-r from-fresh-green via-cyan-tech to-white">Smart Green City</span>?
                        </h2>
                        <p class="mx-auto mt-4 max-w-xl text-sm leading-relaxed text-light-gray/75 sm:text-base">
                            Assemble your squad of {{ config('greenexe.team.min_members') }}–{{ config('greenexe.team.max_members') }} engineers and compete for glory, awards, and industry mentorship.
                        </p>
                        <div class="mt-8 flex flex-wrap items-center justify-center gap-4">
                            <a href="{{ route('register') }}" class="gx-btn-primary text-sm px-8 py-3.5 shadow-[0_0_30px_rgba(46,139,87,0.5)] hover:scale-105 active:scale-95">
                                Register Your Team Now &rarr;
                            </a>
                            <a href="{{ route('rules') }}" class="gx-btn-ghost text-sm px-6 py-3.5 hover:scale-105 active:scale-95">
                                Read Rules &amp; Guidelines
                            </a>
                        </div>
                    </div>
                </div>
            </div>

        </section>
    </div>

    {{-- Interactive Copy-to-Clipboard Handler --}}
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            document.querySelectorAll('[data-copy-btn]').forEach(button => {
                button.addEventListener('click', (e) => {
                    e.preventDefault();
                    e.stopPropagation();
                    const text = button.getAttribute('data-copy-btn');
                    if (text && navigator.clipboard) {
                        navigator.clipboard.writeText(text).then(() => {
                            const feedback = button.querySelector('[data-copy-feedback]');
                            if (feedback) {
                                feedback.classList.remove('opacity-0');
                                feedback.classList.add('opacity-100');
                                setTimeout(() => {
                                    feedback.classList.remove('opacity-100');
                                    feedback.classList.add('opacity-0');
                                }, 2000);
                            }
                        });
                    }
                });
            });
        });
    </script>
@endsection