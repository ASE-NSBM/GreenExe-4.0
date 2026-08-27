@extends('layouts.app')

@section('title', 'FAQ — '.config('greenexe.event.name'))

@section('content')
    <section class="gx-section mx-auto max-w-4xl px-6 py-24 sm:px-10 md:px-14">
        {{-- FR-53, FR-54 --}}
        @include('partials.page-header', [
            'eyebrow' => 'Answers',
            'titleItalic' => 'Frequently',
            'title' => 'asked questions',
            'lead' => 'Common questions from '.config('greenexe.event.name').' participants.',
        ])

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
