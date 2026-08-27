@extends('layouts.app')

@section('title', 'About '.config('greenexe.event.name'))

@section('content')
    <div class="relative w-full tracking-[-0.02em]">
        {{-- Hero Header (FR-8) --}}
        <section class="relative mx-auto max-w-6xl px-6 pt-28 pb-16 sm:px-10 md:pt-36 md:pb-24">
            <div class="max-w-3xl">
                <p class="text-xs font-medium uppercase tracking-[0.3em] text-cyan-tech">
                    {{ config('greenexe.event.name') }} &bull; Competition Brief
                </p>

                <h1 class="mt-4 leading-[0.95] text-white">
                    <span class="block font-playfair text-5xl font-normal italic sm:text-7xl md:text-8xl"
                          style="letter-spacing: -0.05em">About</span>
                    <span class="-mt-1 block text-5xl font-normal sm:text-7xl md:text-8xl"
                          style="letter-spacing: -0.08em">{{ config('greenexe.event.name') }}</span>
                </h1>

                <p class="mt-6 text-base leading-relaxed text-white/75 sm:text-lg">
                    {{ config('greenexe.event.tagline') }} Presented by the {{ config('greenexe.event.organizer') }}
                    under the {{ config('greenexe.event.brand') }} brand at {{ config('greenexe.event.university') }}.
                </p>
            </div>
        </section>

        {{-- Editorial Compendium Section (FR-8, FR-9, FR-13) --}}
        <section class="border-t border-white/10 bg-dark-navy/60 py-20 md:py-28">
            <div class="mx-auto max-w-6xl px-6 sm:px-10">
                <div class="grid gap-12 md:grid-cols-12 md:gap-16">
                    {{-- Left Column: Purpose Narrative --}}
                    <div class="md:col-span-5">
                        <p class="text-xs font-medium uppercase tracking-[0.3em] text-fresh-green">
                            The Mission
                        </p>

                        <h2 class="mt-3 leading-[0.95] text-white">
                            <span class="block font-playfair text-3xl font-normal italic sm:text-4xl md:text-5xl"
                                  style="letter-spacing: -0.05em">Why we built</span>
                            <span class="-mt-1 block text-3xl font-normal sm:text-4xl md:text-5xl"
                                  style="letter-spacing: -0.08em">this platform</span>
                        </h2>

                        <p class="mt-6 text-sm leading-relaxed text-white/70 sm:text-base">
                            GreenExE is designed to bridge the gap between classroom theory and real-world urban technology. Undergraduates collaborate in multidisciplinary teams to engineer scalable prototypes addressing real environmental and civic challenges.
                        </p>

                        <div class="mt-8 flex flex-col items-start gap-4">
                            <a href="{{ route('register') }}"
                               class="rounded-full bg-[#e8702a] px-7 py-3 text-sm font-medium text-white transition-all hover:scale-[1.03] hover:bg-[#d2611f] hover:shadow-lg hover:shadow-[#e8702a]/30 active:scale-95">
                                Register Your Team
                            </a>
                            <a href="{{ route('rules') }}"
                               class="group inline-flex items-center gap-2 text-sm font-medium text-white/80 transition-colors hover:text-cyan-tech">
                                <span class="border-b border-white/20 pb-0.5 group-hover:border-cyan-tech">Read full rules &amp; criteria</span>
                                <span class="transition-transform group-hover:translate-x-1">&rarr;</span>
                            </a>
                        </div>
                    </div>

                    {{-- Right Column: Structured Compendium Index --}}
                    <div class="md:col-span-7">
                        @php
                            $overview = $sections->get('overview')?->first()?->body ?? 'GreenExE 4.0 invites student teams to design technology solutions that turn a green environment into a connected, efficient, intelligent and sustainable city.';
                            $purpose = $sections->get('purpose')?->first()?->body ?? 'Encourage students to apply technology and innovation to real sustainability problems, and to present workable smart-city solutions to an industry audience.';
                            $benefits = $sections->get('benefits')?->first()?->body ?? "Industry exposure and mentorship\nRecognition for sustainable innovation\nHands-on experience building smart-city solutions\nNetworking with the ASE community and partners";

                            $cards = [
                                [
                                    'num' => '01',
                                    'label' => 'Overview',
                                    'title' => 'Competition Structure',
                                    'content' => $overview,
                                    'is_list' => false,
                                ],
                                [
                                    'num' => '02',
                                    'label' => 'Purpose & Objectives',
                                    'title' => 'Sustainable Tech Innovation',
                                    'content' => $purpose,
                                    'is_list' => false,
                                ],
                                [
                                    'num' => '03',
                                    'label' => 'Participant Benefits',
                                    'title' => 'What Teams Gain',
                                    'content' => $benefits,
                                    'is_list' => true,
                                ],
                            ];
                        @endphp

                        <div class="space-y-0">
                            @foreach ($cards as $item)
                                <article class="group relative border-t border-white/15 py-8 first:border-t-0 first:pt-0">
                                    <span class="absolute left-0 top-0 h-px w-0 bg-gradient-to-r from-cyan-tech to-transparent transition-all duration-700 group-hover:w-full" aria-hidden="true"></span>

                                    <div class="flex items-baseline gap-4">
                                        <span class="font-playfair text-sm italic text-cyan-tech/80">{{ $item['num'] }}</span>
                                        <span class="text-[11px] font-medium uppercase tracking-[0.3em] text-white/45">{{ $item['label'] }}</span>
                                    </div>

                                    <h3 class="mt-2 text-xl font-medium text-white transition-colors group-hover:text-cyan-tech md:text-2xl"
                                        style="letter-spacing: -0.04em">
                                        {{ $item['title'] }}
                                    </h3>

                                    @if ($item['is_list'])
                                        <ul class="mt-4 grid gap-x-6 gap-y-2 text-sm leading-relaxed text-white/70 sm:grid-cols-2">
                                            @foreach (preg_split('/\R+/', trim($item['content'])) as $line)
                                                <li class="flex items-start gap-2.5">
                                                    <span class="mt-2 h-1 w-1 shrink-0 rounded-full bg-fresh-green"></span>
                                                    <span>{{ $line }}</span>
                                                </li>
                                            @endforeach
                                        </ul>
                                    @else
                                        <p class="mt-3 text-sm leading-relaxed text-white/70 sm:text-base">
                                            {{ $item['content'] }}
                                        </p>
                                    @endif
                                </article>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- The Smart Green City Photographic Plate (FR-10) --}}
        <section class="mx-auto max-w-6xl px-6 py-16 sm:px-10 md:py-24">
            <div class="relative overflow-hidden rounded-3xl border border-white/10 bg-dark-navy">
                <div class="absolute inset-0 bg-cover bg-center"
                     style="background-image: url('{{ asset('assets/img/section2.jpg') }}')"
                     aria-hidden="true"></div>
                <div class="absolute inset-0 bg-gradient-to-r from-dark-navy via-dark-navy/90 to-dark-navy/50" aria-hidden="true"></div>
                <div class="absolute inset-0 bg-gradient-to-t from-dark-navy via-transparent to-dark-navy/60" aria-hidden="true"></div>

                <div class="relative grid gap-8 p-8 sm:p-12 md:grid-cols-12 md:gap-12 md:p-16">
                    <div class="md:col-span-8">
                        <p class="text-xs font-medium uppercase tracking-[0.3em] text-cyan-tech">The Guiding Concept</p>
                        <h2 class="mt-3 leading-[0.95] text-white">
                            <span class="block font-playfair text-3xl font-normal italic sm:text-4xl md:text-5xl"
                                  style="letter-spacing: -0.05em">NSBM Green University</span>
                            <span class="-mt-1 block text-3xl font-normal sm:text-4xl md:text-5xl"
                                  style="letter-spacing: -0.08em">as a Smart City Blueprint</span>
                        </h2>
                        <p class="mt-6 max-w-2xl text-sm leading-relaxed text-white/80 sm:text-base">
                            GreenExE projects are inspired by an enhanced smart-city environment: smart buildings, energy intelligence, connected mobility, water and waste automation, and continuous environmental monitoring working seamlessly together.
                        </p>
                    </div>

                    <div class="flex flex-col justify-end md:col-span-4 md:items-end">
                        <a href="{{ route('smart-city') }}"
                           class="group inline-flex items-center gap-3 rounded-full border border-white/20 bg-white/10 px-6 py-3 text-sm font-medium text-white backdrop-blur-md transition-all hover:border-cyan-tech hover:bg-cyan-tech/20 hover:text-cyan-tech">
                            <span>Explore 9 City Pillars</span>
                            <span class="transition-transform group-hover:translate-x-1">&rarr;</span>
                        </a>
                    </div>
                </div>
            </div>
        </section>

        {{-- Eligibility & Rule Highlights (FR-11, FR-12) --}}
        <section class="border-t border-white/10 bg-dark-navy/40 py-20 md:py-24">
            <div class="mx-auto max-w-6xl px-6 sm:px-10">
                <div class="flex flex-col gap-4 sm:flex-row sm:items-end sm:justify-between">
                    <div>
                        <p class="text-xs font-medium uppercase tracking-[0.3em] text-eco-lime">Participation</p>
                        <h2 class="mt-2 leading-[0.95] text-white">
                            <span class="block font-playfair text-3xl font-normal italic sm:text-4xl"
                                  style="letter-spacing: -0.05em">Eligibility &amp;</span>
                            <span class="-mt-1 block text-3xl font-normal sm:text-4xl"
                                  style="letter-spacing: -0.08em">Team Guidelines</span>
                        </h2>
                    </div>
                    <a href="{{ route('rules') }}" class="group inline-flex items-center gap-2 text-sm font-medium text-white/80 transition-colors hover:text-cyan-tech">
                        <span class="border-b border-cyan-tech/40 pb-0.5 group-hover:border-cyan-tech">Detailed requirements</span>
                        <span class="transition-transform group-hover:translate-x-1">&rarr;</span>
                    </a>
                </div>

                <div class="mt-12 grid gap-6 sm:grid-cols-3">
                    <div class="border-l border-white/20 pl-6 py-2">
                        <p class="text-xs uppercase tracking-[0.25em] text-white/40">Team Composition</p>
                        <h3 class="mt-2 text-lg font-medium text-white">
                            {{ config('greenexe.team.min_members') }}–{{ config('greenexe.team.max_members') }} Undergraduates
                        </h3>
                        <p class="mt-2 text-xs leading-relaxed text-white/65">
                            Teams must consist of current undergraduates. The first registered student is designated as the official team leader.
                        </p>
                    </div>

                    <div class="border-l border-white/20 pl-6 py-2">
                        <p class="text-xs uppercase tracking-[0.25em] text-white/40">Project Scope</p>
                        <h3 class="mt-2 text-lg font-medium text-white">Smart Green City Theme</h3>
                        <p class="mt-2 text-xs leading-relaxed text-white/65">
                            Concepts must directly address sustainability, automation, energy efficiency, mobility, or environmental monitoring.
                        </p>
                    </div>

                    <div class="border-l border-white/20 pl-6 py-2">
                        <p class="text-xs uppercase tracking-[0.25em] text-white/40">Submission Format</p>
                        <h3 class="mt-2 text-lg font-medium text-white">Concept &amp; Tech Stack</h3>
                        <p class="mt-2 text-xs leading-relaxed text-white/65">
                            Initial registration requires a problem statement, proposed technical architecture, innovation summary, and impact forecast.
                        </p>
                    </div>
                </div>
            </div>
        </section>

        {{-- Curated FAQ Index (FR-14) --}}
        @if ($faqs->isNotEmpty())
            <section class="border-t border-white/10 py-20 md:py-24">
                <div class="mx-auto max-w-4xl px-6 sm:px-10">
                    <div class="text-center">
                        <p class="text-xs font-medium uppercase tracking-[0.3em] text-cyan-tech">Quick Assistance</p>
                        <h2 class="mt-3 leading-[0.95] text-white">
                            <span class="block font-playfair text-3xl font-normal italic sm:text-4xl md:text-5xl"
                                  style="letter-spacing: -0.05em">Frequently Asked</span>
                            <span class="-mt-1 block text-3xl font-normal sm:text-4xl md:text-5xl"
                                  style="letter-spacing: -0.08em">Questions</span>
                        </h2>
                        <p class="mt-4 text-sm text-white/70">
                            Key questions on eligibility, team formation, and competition submissions.
                        </p>
                    </div>

                    <div class="mt-12 space-y-3" data-accordion>
                        @foreach ($faqs as $faq)
                            @include('partials.faq-item', ['faq' => $faq])
                        @endforeach
                    </div>

                    <div class="mt-10 text-center">
                        <a href="{{ route('faq') }}"
                           class="group inline-flex items-center gap-2 text-sm font-medium text-white/80 transition-colors hover:text-cyan-tech">
                            <span class="border-b border-cyan-tech/40 pb-0.5 group-hover:border-cyan-tech">View all frequently asked questions</span>
                            <span class="transition-transform group-hover:translate-x-1">&rarr;</span>
                        </a>
                    </div>
                </div>
            </section>
        @endif
    </div>
@endsection
