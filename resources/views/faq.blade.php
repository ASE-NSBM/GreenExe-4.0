@extends('layouts.app')

@section('title', 'FAQ — '.config('greenexe.event.name'))

@section('content')
    <section class="mx-auto max-w-4xl px-4 py-20">
        {{-- FR-53, FR-54 --}}
        <x-page-header
            eyebrow="Need help"
            title="Frequently Asked Questions"
            :description="'Common questions from '.config('greenexe.event.name').' participants.'" />

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
