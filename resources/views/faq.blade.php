@extends('layouts.app')

@section('meta_description', 'Find answers to common questions about GreenExE 4.0 registration, teams, Smart Green City projects, rules and eligibility.')

@php
    $faqSchema = [
        '@context' => 'https://schema.org',
        '@type' => 'FAQPage',
        'mainEntity' => $faqs->map(fn ($faq) => [
            '@type' => 'Question',
            'name' => $faq->question,
            'acceptedAnswer' => [
                '@type' => 'Answer',
                'text' => trim(strip_tags($faq->answer)),
            ],
        ])->values(),
    ];
@endphp

@push('structured_data')
    @if ($faqs->isNotEmpty())
        <script type="application/ld+json">@json($faqSchema, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE)</script>
    @endif
@endpush

@section('title', 'FAQ — '.config('greenexe.event.name'))

@section('content')
    @include('partials.page-hero', [
        'image' => 'assets/img/section2.jpg',
        'eyebrow' => 'Answers',
        'titleItalic' => 'Frequently',
        'title' => 'asked questions',
        'lead' => 'Common questions from '.config('greenexe.event.name').' participants.',
    ])

    <section class="gx-section mx-auto max-w-4xl px-6 pb-24">
        {{-- FR-53, FR-54 --}}

        <div class="gx-reveal mt-12 space-y-3" data-accordion data-reveal>
            @forelse ($faqs as $faq)
                @include('partials.faq-item', ['faq' => $faq])
            @empty
                <p class="text-light-gray/60">No FAQs have been published yet.</p>
            @endforelse
        </div>

        <div class="gx-reveal mt-12 gx-card text-center" data-reveal>
            <p class="text-white/75">Still have a question?</p>
            <a href="{{ route('contact') }}" class="gx-btn-ghost mt-4">Contact the organisers</a>
        </div>
    </section>
@endsection
