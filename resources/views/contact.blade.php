@extends('layouts.app')

@section('title', 'Contact — '.config('greenexe.event.name'))

@php
    $org = config('greenexe.organizer');
    $contact = config('greenexe.contact');
    $telHref = 'tel:'.preg_replace('/\s+/', '', $contact['phone']);
@endphp

@section('content')
    <section class="gx-section mx-auto max-w-4xl px-6 py-24 sm:px-10 md:px-14">
        @include('partials.page-header', [
            'eyebrow' => 'Contact',
            'titleItalic' => 'Get in touch',
            'title' => 'with '.$org['short_name'],
            'lead' => 'Questions about '.config('greenexe.event.name').'? Reach the '.$org['name'].' team through any of the channels below.',
            'center' => true,
        ])

        <div class="mt-12 grid gap-4 sm:grid-cols-3">
            @php
                $cards = [
                    ['label' => 'Email us', 'value' => $contact['email'], 'href' => 'mailto:'.$contact['email'],
                     'path' => 'M3 5h18a1 1 0 0 1 1 1v12a1 1 0 0 1-1 1H3a1 1 0 0 1-1-1V6a1 1 0 0 1 1-1zm1.2 2 7.8 5.2L19.8 7z', 'ext' => false],
                    ['label' => 'Call us', 'value' => $contact['phone'], 'href' => $telHref,
                     'path' => 'M6.6 10.8a15 15 0 0 0 6.6 6.6l2.2-2.2a1 1 0 0 1 1-.24 11 11 0 0 0 3.5.56 1 1 0 0 1 1 1V20a1 1 0 0 1-1 1A17 17 0 0 1 3 4a1 1 0 0 1 1-1h3.3a1 1 0 0 1 1 1 11 11 0 0 0 .56 3.5 1 1 0 0 1-.24 1z', 'ext' => false],
                    ['label' => 'Visit us', 'value' => 'NSBM Green University', 'href' => $contact['map_url'],
                     'path' => 'M12 2a7 7 0 0 0-7 7c0 5 7 13 7 13s7-8 7-13a7 7 0 0 0-7-7zm0 9.5A2.5 2.5 0 1 1 12 6.5a2.5 2.5 0 0 1 0 5z', 'ext' => true],
                ];
            @endphp
            @foreach ($cards as $i => $card)
                <a href="{{ $card['href'] }}" @if ($card['ext']) target="_blank" rel="noopener noreferrer" @endif
                   class="gx-card gx-reveal group flex flex-col items-center gap-3 text-center transition duration-200 hover:-translate-y-1 hover:border-cyan-tech/40 focus-visible:outline-none focus-visible:ring-2 focus-visible:ring-cyan-tech"
                   data-reveal style="transition-delay: {{ $i * 0.08 }}s">
                    <span class="grid h-12 w-12 place-items-center rounded-xl bg-smart-green/15 text-cyan-tech transition group-hover:bg-cyan-tech/20">
                        <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path d="{{ $card['path'] }}"/></svg>
                    </span>
                    <span class="text-xs font-semibold uppercase tracking-wider text-light-gray/50">{{ $card['label'] }}</span>
                    <span class="break-words font-medium text-white group-hover:text-cyan-tech">{{ $card['value'] }}</span>
                </a>
            @endforeach
        </div>

        <div class="gx-reveal mt-6 gx-card text-center" data-reveal>
            <p class="text-light-gray/70">Full address</p>
            <p class="mt-1 text-white">{{ $contact['address'] }}</p>
        </div>

        <div class="gx-reveal mt-10 text-center" data-reveal>
            <h2 class="gx-card-title text-xl font-medium text-white">Follow {{ $org['short_name'] }}</h2>
            <p class="mt-2 text-sm text-light-gray/60">Events, workshops and announcements as they happen.</p>
            <div class="mt-5 flex justify-center">
                @include('partials.social-links')
            </div>
            <a href="{{ route('organizer') }}" class="gx-underline mt-8 inline-block text-sm text-cyan-tech">Learn more about the organizer →</a>
        </div>
    </section>
@endsection
