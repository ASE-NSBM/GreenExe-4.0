@extends('layouts.app')

@section('title', 'About '.config('greenexe.event.name'))

@section('content')
    <section class="mx-auto max-w-6xl px-4 py-16 md:py-24">
        {{-- FR-8: Introduction Header --}}
        <div class="text-center md:text-left">
            <span class="gx-badge border border-cyan-tech/30 bg-cyan-tech/10 text-cyan-tech">
                Competition Details &amp; Objectives
            </span>
            <h1 class="mt-4 font-display text-4xl font-bold tracking-tight text-white md:text-5xl">
                About <span class="text-transparent bg-clip-text bg-gradient-to-r from-fresh-green to-cyan-tech">{{ config('greenexe.event.name') }}</span>
            </h1>
            <p class="mt-4 max-w-3xl text-lg leading-relaxed text-light-gray/80">
                {{ config('greenexe.event.tagline') }} Organized by the {{ config('greenexe.event.organizer') }} under the {{ config('greenexe.event.brand') }} brand.
            </p>
        </div>

        {{-- FR-8, FR-9: Dynamic Competition Overview & Purpose --}}
        <div class="mt-12 grid gap-6 md:grid-cols-2">
            @php
                $overviewItems = $sections->get('overview') ?? collect();
                $purposeItems = $sections->get('purpose') ?? collect();
            @endphp

            <article class="gx-card relative overflow-hidden transition hover:border-fresh-green/40">
                <div class="flex items-center gap-3">
                    <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-fresh-green/10 text-xl text-fresh-green">🏆</span>
                    <h2 class="font-display text-xl font-semibold text-white">Event Overview</h2>
                </div>
                <div class="mt-4 space-y-3 text-light-gray/75 leading-relaxed">
                    @forelse ($overviewItems as $item)
                        <p class="whitespace-pre-line">{{ $item->body }}</p>
                    @empty
                        <p>GreenExE 4.0 is a premier technology and innovation competition challenging undergraduates to engineer scalable, real-world solutions for future sustainable urban environments.</p>
                    @endforelse
                </div>
            </article>

            <article class="gx-card relative overflow-hidden transition hover:border-cyan-tech/40">
                <div class="flex items-center gap-3">
                    <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-cyan-tech/10 text-xl text-cyan-tech">🎯</span>
                    <h2 class="font-display text-xl font-semibold text-white">Purpose &amp; Objectives</h2>
                </div>
                <div class="mt-4 space-y-3 text-light-gray/75 leading-relaxed">
                    @forelse ($purposeItems as $item)
                        <p class="whitespace-pre-line">{{ $item->body }}</p>
                    @empty
                        <p>To foster collaborative engineering, spark high-impact green innovations, and empower students to present workable smart-city technologies to an industry audience.</p>
                    @endforelse
                </div>
            </article>
        </div>

        {{-- FR-10: Smart Green City Concept Banner --}}
        <div class="mt-8 rounded-3xl border border-cyan-tech/30 bg-gradient-to-br from-deep-green/60 via-dark-navy to-white/5 p-8 backdrop-blur-md">
            <div class="flex flex-col gap-6 md:flex-row md:items-center md:justify-between">
                <div class="max-w-2xl">
                    <span class="gx-badge border border-eco-lime/30 bg-eco-lime/10 text-eco-lime">Core Theme</span>
                    <h2 class="mt-3 font-display text-2xl font-semibold text-white">The Smart Green City Concept</h2>
                    <p class="mt-2 text-light-gray/80 leading-relaxed">
                        Inspired by the <strong class="text-white">{{ config('greenexe.event.university') }}</strong> environment, GreenExE 4.0 explores how digital automation, IoT, clean energy, and smart mobility transform urban spaces into intelligent, sustainable ecosystems.
                    </p>
                </div>
                <div class="shrink-0">
                    <a href="{{ route('smart-city') }}" class="gx-btn-primary group inline-flex items-center gap-2">
                        <span>Explore 9 City Pillars</span>
                        <svg class="h-4 w-4 transition-transform group-hover:translate-x-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"/>
                        </svg>
                    </a>
                </div>
            </div>
        </div>

        {{-- FR-11, FR-12, FR-13: Eligibility & Participant Benefits --}}
        <div class="mt-8 grid gap-6 lg:grid-cols-3">
            {{-- FR-11, FR-12: Eligibility & Rules Summary --}}
            <div class="gx-card flex flex-col justify-between transition hover:border-white/30">
                <div>
                    <div class="flex items-center gap-3">
                        <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-white/10 text-xl text-white">📋</span>
                        <h2 class="font-display text-xl font-semibold text-white">Eligibility &amp; Rules</h2>
                    </div>
                    <ul class="mt-4 space-y-2.5 text-sm text-light-gray/75">
                        <li class="flex items-start gap-2">
                            <span class="mt-1 h-1.5 w-1.5 shrink-0 rounded-full bg-cyan-tech"></span>
                            <span>Open to university undergraduates.</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <span class="mt-1 h-1.5 w-1.5 shrink-0 rounded-full bg-cyan-tech"></span>
                            <span>Teams composed of {{ config('greenexe.team.min_members') }} to {{ config('greenexe.team.max_members') }} members.</span>
                        </li>
                        <li class="flex items-start gap-2">
                            <span class="mt-1 h-1.5 w-1.5 shrink-0 rounded-full bg-cyan-tech"></span>
                            <span>Projects must align with Smart Green City themes.</span>
                        </li>
                    </ul>
                </div>
                <a href="{{ route('rules') }}" class="mt-6 inline-flex items-center text-sm font-semibold text-cyan-tech hover:underline">
                    View Complete Rules &amp; Guidelines →
                </a>
            </div>

            {{-- FR-13: Participant Benefits (Span 2) --}}
            <div class="gx-card lg:col-span-2 transition hover:border-white/30">
                <div class="flex items-center gap-3">
                    <span class="flex h-10 w-10 items-center justify-center rounded-xl bg-fresh-green/10 text-xl text-fresh-green">✨</span>
                    <h2 class="font-display text-xl font-semibold text-white">Participant Benefits</h2>
                </div>
                <div class="mt-6 grid gap-4 sm:grid-cols-2">
                    <div class="rounded-xl border border-white/5 bg-white/5 p-4">
                        <div class="text-lg font-medium text-white">Mentorship &amp; Guidance</div>
                        <p class="mt-1 text-sm text-light-gray/70">Receive feedback and mentorship directly from industry tech leaders and domain experts.</p>
                    </div>
                    <div class="rounded-xl border border-white/5 bg-white/5 p-4">
                        <div class="text-lg font-medium text-white">Industry Exposure</div>
                        <p class="mt-1 text-sm text-light-gray/70">Pitch your solution on stage and gain recognition among leading tech organizations.</p>
                    </div>
                    <div class="rounded-xl border border-white/5 bg-white/5 p-4">
                        <div class="text-lg font-medium text-white">Hands-on Experience</div>
                        <p class="mt-1 text-sm text-light-gray/70">Collaborate with peers to build real-world software &amp; hardware prototypes.</p>
                    </div>
                    <div class="rounded-xl border border-white/5 bg-white/5 p-4">
                        <div class="text-lg font-medium text-white">Networking &amp; Community</div>
                        <p class="mt-1 text-sm text-light-gray/70">Connect with the ASE community, alumni mentors, and fellow student innovators.</p>
                    </div>
                </div>
            </div>
        </div>

        {{-- FR-14: FAQ Preview Accordion --}}
        @if ($faqs->isNotEmpty())
            <div class="mt-16">
                <div class="flex flex-col gap-2 sm:flex-row sm:items-center sm:justify-between">
                    <div>
                        <h2 class="font-display text-2xl font-bold text-white md:text-3xl">Frequently Asked Questions</h2>
                        <p class="mt-1 text-sm text-light-gray/70">Quick answers about registration, team requirements, and criteria.</p>
                    </div>
                    <a href="{{ route('faq') }}" class="inline-flex items-center text-sm font-semibold text-cyan-tech hover:underline">
                        View All FAQs →
                    </a>
                </div>
                <div class="mt-6 space-y-3" data-accordion>
                    @foreach ($faqs as $faq)
                        @include('partials.faq-item', ['faq' => $faq])
                    @endforeach
                </div>
            </div>
        @endif

        {{-- Action CTA --}}
        <div class="mt-16 text-center">
            <a href="{{ route('register') }}" class="gx-btn-primary text-base px-8 py-4 shadow-lg shadow-smart-green/20">
                Register Your Team Now
            </a>
        </div>
    </section>
@endsection
