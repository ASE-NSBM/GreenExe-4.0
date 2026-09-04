@extends('layouts.app')

@section('meta_description', 'Learn about GreenExE 4.0, a Smart Green City innovation competition inspired by NSBM Green University.')

@section('title', 'About '.config('greenexe.event.name').' — '.config('greenexe.event.concept'))

@section('content')
    @include('partials.page-hero', [
        'image' => 'assets/img/highlights/smartcity-about.jpg',
        'eyebrow' => config('greenexe.event.name'),
        'titleItalic' => 'About the',
        'title' => 'competition',
        'lead' => config('greenexe.event.tagline'),
    ])

    <section class="gx-section mx-auto max-w-5xl px-6 pb-24">
        {{-- FR-8, FR-9 --}}

        <div class="mt-12 space-y-6">
            @forelse ($sections->flatten() as $section)
                <article class="gx-card gx-reveal" data-reveal>
                    <h2 class="gx-card-title text-xl font-medium text-white">{{ $section->title }}</h2>
                    <p class="mt-3 whitespace-pre-line text-sm leading-relaxed text-white/75 md:text-base">{{ $section->body }}</p>
                </article>
            @empty
                <article class="gx-card">
                    <h2 class="gx-card-title text-xl font-medium text-white">Competition purpose</h2>
                    <p class="mt-3 text-light-gray/75">
                        Competition content is managed from the administrator dashboard and will appear here once published.
                    </p>
                </article>
            @endforelse
        </div>

        {{-- FR-10 --}}
        <div class="gx-reveal mt-12 gx-card border-cyan-tech/30" data-reveal>
            <h2 class="gx-card-title text-xl font-medium text-white">The Smart Green City concept</h2>
            <p class="mt-3 text-light-gray/75">
                {{ config('greenexe.event.university') }} is the inspiration for an enhanced smart-city environment:
                smart buildings, green landscapes, clean energy, intelligent mobility, connected services and
                environmental monitoring working as one system.
            </p>
            <a href="{{ route('smart-city') }}" class="mt-4 inline-block text-sm text-cyan-tech hover:underline">Explore the concept →</a>
        </div>

        {{-- The pillars are already passed to this view; showing the first six as
             artwork tiles gives the page the same weight as the home carousel. --}}
        @if ($smartCityPillars->isNotEmpty())
            <div class="mt-6 grid gap-4 sm:grid-cols-2 lg:grid-cols-3">
                @foreach ($smartCityPillars->take(6) as $pillar)
                    <a href="{{ route('smart-city') }}"
                       class="gx-reveal group relative flex aspect-4/3 flex-col justify-end overflow-hidden rounded-2xl border border-white/10 transition hover:border-cyan-tech/40"
                       data-reveal data-reveal-delay="{{ min($loop->index, 5) * 0.06 }}">
                        @if ($artwork = $pillar->artwork())
                            <div class="absolute inset-0 bg-cover bg-center transition-transform duration-700 group-hover:scale-105"
                                 data-background-image="{{ $artwork }}" aria-hidden="true"></div>
                        @else
                            <div class="absolute inset-0 bg-gradient-to-br from-forest-green via-deep-green to-dark-navy" aria-hidden="true"></div>
                        @endif
                        <div class="absolute inset-0 bg-gradient-to-t from-dark-navy via-dark-navy/60 to-transparent" aria-hidden="true"></div>

                        <div class="relative p-5">
                            <span class="text-fresh-green">@include('partials.feature-icon', ['index' => $loop->index, 'class' => 'h-5 w-5'])</span>
                            <h3 class="gx-card-title mt-2 text-base font-medium text-white group-hover:text-cyan-tech">
                                {{ $pillar->title }}
                            </h3>
                        </div>
                    </a>
                @endforeach
            </div>
        @endif

        {{-- FR-11, FR-12 --}}
        <div class="gx-reveal mt-6 grid gap-6 md:grid-cols-2" data-reveal>
            <div class="gx-card">
                <h2 class="gx-card-title text-xl font-medium text-white">Eligibility &amp; rules</h2>
                <p class="mt-3 text-light-gray/75">
                    Eligibility, team requirements and participation rules are listed in full on the rules page.
                </p>
                <a href="{{ route('rules') }}" class="mt-4 inline-block text-sm text-cyan-tech hover:underline">Read rules &amp; eligibility →</a>
            </div>

            {{-- FR-13 --}}
            <div class="gx-card">
                <h2 class="gx-card-title text-xl font-medium text-white">Participant benefits</h2>
                <ul class="mt-3 space-y-2 text-light-gray/75">
                    <li>• Industry exposure and mentorship opportunities</li>
                    <li>• Recognition for sustainable innovation</li>
                    <li>• Hands-on experience building smart-city solutions</li>
                    <li>• Networking with the ASE community and partners</li>
                </ul>
            </div>
        </div>

        {{-- FR-14 --}}
        @if ($faqs->isNotEmpty())
            <div class="mt-12">
                <h2 class="gx-card-title text-2xl font-medium text-white">Frequently asked questions</h2>
                <div class="mt-6 space-y-3" data-accordion>
                    @foreach ($faqs as $faq)
                        @include('partials.faq-item', ['faq' => $faq])
                    @endforeach
                </div>
            </div>
        @endif
        </section>
    </div>
@endsection
