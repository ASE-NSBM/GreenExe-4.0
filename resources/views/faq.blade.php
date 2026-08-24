@extends('layouts.app')

@section('title', 'FAQ — '.config('greenexe.event.name'))

@section('content')
    <section class="mx-auto max-w-4xl px-4 py-20">
        {{-- FR-53, FR-54 --}}
        <h1 class="font-display text-4xl font-bold text-white">Frequently Asked Questions</h1>
        <p class="mt-4 text-lg text-light-gray/75">Common questions from {{ config('greenexe.event.name') }} participants.</p>

        <div class="mt-10 space-y-3" data-accordion>
            @forelse ($faqs as $faq)
                @include('partials.faq-item', ['faq' => $faq])
            @empty
                <p class="text-light-gray/60">No FAQs have been published yet.</p>
            @endforelse
        </div>

        <div class="mt-12 gx-card text-center">
            <p class="text-light-gray/75">Still have a question?</p>
            <a href="{{ route('contact') }}" class="gx-btn-ghost mt-4">Contact the organisers</a>
        </div>
    </section>
@endsection
