@extends('layouts.app')

@section('title', 'Smart Green City Concept — '.config('greenexe.event.name'))

@section('content')
    <div class="relative w-full tracking-[-0.02em]">
        {{-- Hero Header (FR-15) --}}
        <section class="relative mx-auto max-w-6xl px-6 pt-28 pb-16 sm:px-10 md:pt-36 md:pb-24">
            <div class="max-w-3xl">
                <p class="text-xs font-medium uppercase tracking-[0.3em] text-cyan-tech">
                    {{ config('greenexe.event.name') }} &bull; Core Theme
                </p>

                <h1 class="mt-4 leading-[0.95] text-white">
                    <span class="block font-playfair text-5xl font-normal italic sm:text-7xl md:text-8xl"
                          style="letter-spacing: -0.05em">Smart Green</span>
                    <span class="-mt-1 block text-5xl font-normal sm:text-7xl md:text-8xl"
                          style="letter-spacing: -0.08em">City Concept</span>
                </h1>

                <p class="mt-6 text-base leading-relaxed text-white/75 sm:text-lg">
                    An enhanced, futuristic vision of {{ config('greenexe.event.university') }}, where a lush green campus environment seamlessly integrates with intelligent infrastructure, connected digital services, and clean energy systems.
                </p>
            </div>
        </section>

        {{-- The Vision: Split Narrative (FR-15) --}}
        <section class="border-t border-white/10 bg-dark-navy/60 py-20 md:py-28">
            <div class="mx-auto max-w-6xl px-6 sm:px-10">
                <div class="grid gap-12 md:grid-cols-12 md:gap-16">
                    {{-- Left Column --}}
                    <div class="md:col-span-5">
                        <p class="text-xs font-medium uppercase tracking-[0.3em] text-fresh-green">
                            The Vision
                        </p>

                        <h2 class="mt-3 leading-[0.95] text-white">
                            <span class="block font-playfair text-3xl font-normal italic sm:text-4xl md:text-5xl"
                                  style="letter-spacing: -0.05em">Transforming green</span>
                            <span class="-mt-1 block text-3xl font-normal sm:text-4xl md:text-5xl"
                                  style="letter-spacing: -0.08em">spaces into smart cities</span>
                        </h2>

                        <p class="mt-6 text-sm leading-relaxed text-white/70 sm:text-base">
                            The central philosophy of GreenExE 4.0 is not technology for its own sake, but technology deployed intentionally to make urban environments sustainable, efficient, and resilient.
                        </p>

                        <div class="mt-8">
                            <a href="{{ route('register') }}"
                               class="rounded-full bg-[#e8702a] px-7 py-3 text-sm font-medium text-white transition-all hover:scale-[1.03] hover:bg-[#d2611f] hover:shadow-lg hover:shadow-[#e8702a]/30 active:scale-95">
                                Register Your Project
                            </a>
                        </div>
                    </div>

                    {{-- Right Column: Vision Points --}}
                    <div class="md:col-span-7">
                        <div class="space-y-0">
                            @forelse ($vision as $index => $item)
                                <article class="group relative border-t border-white/15 py-8 first:border-t-0 first:pt-0">
                                    <span class="absolute left-0 top-0 h-px w-0 bg-gradient-to-r from-cyan-tech to-transparent transition-all duration-700 group-hover:w-full" aria-hidden="true"></span>

                                    <div class="flex items-baseline gap-4">
                                        <span class="font-playfair text-sm italic text-cyan-tech/80">0{{ $index + 1 }}</span>
                                        <span class="text-[11px] font-medium uppercase tracking-[0.3em] text-white/45">Vision Focus</span>
                                    </div>

                                    <h3 class="mt-2 text-xl font-medium text-white transition-colors group-hover:text-cyan-tech md:text-2xl"
                                        style="letter-spacing: -0.04em">
                                        {{ $item->title }}
                                    </h3>

                                    <p class="mt-3 text-sm leading-relaxed text-white/70 sm:text-base">
                                        {{ $item->description }}
                                    </p>
                                </article>
                            @empty
                                <article class="border-t border-white/15 py-8 first:border-t-0 first:pt-0">
                                    <h3 class="text-xl font-medium text-white">An Enhanced Smart-City Environment</h3>
                                    <p class="mt-3 text-sm text-white/70">
                                        Technology transforms a green environment into a connected, efficient, intelligent and sustainable city.
                                    </p>
                                </article>
                            @endforelse
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- 9 City Pillars (FR-16 to FR-21) --}}
        <section class="border-t border-white/10 py-20 md:py-28">
            <div class="mx-auto max-w-6xl px-6 sm:px-10">
                <div class="max-w-2xl">
                    <p class="text-xs font-medium uppercase tracking-[0.3em] text-cyan-tech">The Architecture</p>
                    <h2 class="mt-3 leading-[0.95] text-white">
                        <span class="block font-playfair text-4xl font-normal italic sm:text-5xl md:text-6xl"
                              style="letter-spacing: -0.05em">Nine Pillars of the</span>
                        <span class="-mt-1 block text-4xl font-normal sm:text-5xl md:text-6xl"
                              style="letter-spacing: -0.08em">Smart Green City</span>
                    </h2>
                    <p class="mt-4 text-sm leading-relaxed text-white/70 sm:text-base">
                        Every project submitted to GreenExE 4.0 should align with one or more of these foundational urban innovation pillars.
                    </p>
                </div>

                @php
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

                <div class="mt-14 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                    @forelse ($pillars as $index => $pillar)
                        @php
                            $lines = preg_split('/\R+/', trim($pillar->description));
                            $lead = array_shift($lines);
                            $tint = $tints[$index % count($tints)];
                        @endphp

                        <article class="group relative flex min-h-[380px] flex-col justify-end overflow-hidden rounded-3xl border border-white/10 bg-white/5 transition-all duration-300 hover:border-cyan-tech/40">
                            @if (!empty($pillar->image))
                                <div class="absolute inset-0 bg-cover bg-center transition-transform duration-700 group-hover:scale-105"
                                     style="background-image: url('{{ $pillar->image }}')" aria-hidden="true"></div>
                                <div class="absolute inset-0 bg-gradient-to-t from-dark-navy via-dark-navy/85 to-dark-navy/35" aria-hidden="true"></div>
                            @else
                                <div class="absolute inset-0 bg-gradient-to-br {{ $tint }}" aria-hidden="true"></div>
                                <div class="gx-grid-bg absolute inset-0 opacity-30" aria-hidden="true"></div>
                                <span class="gx-watermark" aria-hidden="true">{{ $pillar->icon ?? '🌿' }}</span>
                                <div class="absolute inset-0 bg-gradient-to-t from-dark-navy via-dark-navy/40 to-transparent" aria-hidden="true"></div>
                            @endif

                            {{-- Ghost Rank Numeral --}}
                            <span class="gx-rank" aria-hidden="true">{{ $index + 1 }}</span>

                            <div class="relative flex h-full flex-col p-6 sm:p-8">
                                <span class="text-2xl">{{ $pillar->icon ?? '🌿' }}</span>

                                <h3 class="mt-auto text-xl font-medium leading-tight text-white transition-colors group-hover:text-cyan-tech md:text-2xl"
                                    style="letter-spacing: -0.04em">
                                    {{ $pillar->title }}
                                </h3>

                                <p class="mt-3 text-sm leading-relaxed text-white/75">{{ $lead }}</p>

                                @if ($lines)
                                    <ul class="mt-4 space-y-2 border-t border-white/10 pt-4 text-xs leading-relaxed text-white/75 sm:text-sm">
                                        @foreach ($lines as $line)
                                            <li class="flex items-start gap-2.5">
                                                <span class="mt-1.5 h-1.5 w-1.5 shrink-0 rounded-full bg-fresh-green"></span>
                                                <span>{{ $line }}</span>
                                            </li>
                                        @endforeach
                                    </ul>
                                @endif
                            </div>
                        </article>
                    @empty
                        <p class="col-span-full text-white/60">Smart city pillars will be published soon.</p>
                    @endforelse
                </div>
            </div>
        </section>

        {{-- Technology for Sustainability Closing Banner (FR-22) --}}
        <section class="border-t border-white/10 bg-dark-navy/80 py-20 md:py-24">
            <div class="mx-auto max-w-4xl px-6 text-center sm:px-10">
                <p class="text-xs font-medium uppercase tracking-[0.3em] text-eco-lime">Core Criterion</p>
                <h2 class="mt-3 leading-[0.95] text-white">
                    <span class="block font-playfair text-3xl font-normal italic sm:text-4xl md:text-5xl"
                          style="letter-spacing: -0.05em">Technology as a tool</span>
                    <span class="-mt-1 block text-3xl font-normal sm:text-4xl md:text-5xl"
                          style="letter-spacing: -0.08em">for real sustainability</span>
                </h2>

                <p class="mx-auto mt-6 max-w-2xl text-sm leading-relaxed text-white/80 sm:text-base">
                    Every project must demonstrate how software, intelligent IoT systems, and automated infrastructure make urban living cleaner, more efficient, and accessible.
                </p>

                <div class="mt-10 flex flex-wrap items-center justify-center gap-4">
                    <a href="{{ route('register') }}"
                       class="rounded-full bg-[#e8702a] px-8 py-3.5 text-sm font-medium text-white transition-all hover:scale-[1.03] hover:bg-[#d2611f] hover:shadow-lg hover:shadow-[#e8702a]/30 active:scale-95">
                        Register Your Project
                    </a>
                    <a href="{{ route('about') }}"
                       class="rounded-full border border-white/20 bg-white/5 px-7 py-3.5 text-sm font-medium text-white transition-all hover:border-cyan-tech hover:text-cyan-tech">
                        About GreenExE 4.0
                    </a>
                </div>
            </div>
        </section>
    </div>
@endsection
