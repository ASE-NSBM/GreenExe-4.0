@extends('layouts.app')

@section('title', 'About '.config('greenexe.event.name'))

@section('content')
    <section class="gx-section mx-auto max-w-5xl px-6 py-24 sm:px-10 md:px-14">
        {{-- FR-8, FR-9 --}}
        @include('partials.page-header', [
            'eyebrow' => config('greenexe.event.name'),
            'titleItalic' => 'About the',
            'title' => 'competition',
            'lead' => config('greenexe.event.tagline'),
        ])

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
                <a href="{{ route('faq') }}" class="mt-6 inline-block text-sm text-cyan-tech hover:underline">See all FAQs →</a>
            </div>
        @endif
    </section>
@endsection
