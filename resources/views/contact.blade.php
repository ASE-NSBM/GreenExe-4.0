@extends('layouts.app')

@section('meta_description', 'Contact the GreenExE 4.0 organizing committee at the Association of Software Engineering, NSBM Green University.')

@section('title', 'Contact — '.config('greenexe.event.name'))

@php
    $org = config('greenexe.organizer');
    $contact = config('greenexe.contact');
    $telHref = 'tel:'.preg_replace('/\s+/', '', $contact['phone']);
@endphp

@section('content')
    @include('partials.page-hero', [
        'image' => 'assets/img/highlights/connected-digital-services.jpg',
        'eyebrow' => 'Contact',
        'titleItalic' => 'Get in touch',
        'title' => 'with '.$org['short_name'],
        'lead' => 'Questions about '.config('greenexe.event.name').'? Reach the '.$org['name'].' team through any of the channels below.',
        'center' => true,
    ])

    <section class="gx-section px-6 pb-24">

        <div class="mx-auto mt-12 max-w-4xl grid gap-4 sm:grid-cols-3">
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
                   data-reveal data-reveal-delay="{{ $i * 0.08 }}">
                    <span class="grid h-12 w-12 place-items-center rounded-xl bg-smart-green/15 text-cyan-tech transition group-hover:bg-cyan-tech/20">
                        <svg class="h-6 w-6" fill="currentColor" viewBox="0 0 24 24" aria-hidden="true"><path d="{{ $card['path'] }}"/></svg>
                    </span>
                    <span class="text-xs font-semibold uppercase tracking-wider text-light-gray/50">{{ $card['label'] }}</span>
                    <span class="break-words font-medium text-white group-hover:text-cyan-tech">{{ $card['value'] }}</span>
                </a>
            @endforeach
        </div>

        <div class="gx-reveal mx-auto mt-6 max-w-4xl gx-card text-center" data-reveal>
            <p class="text-light-gray/70">Full address</p>
            <p class="mt-1 text-white">{{ $contact['address'] }}</p>
        </div>

        {{-- Organizing Committee Section --}}
        <div class="gx-reveal mx-auto mt-16 max-w-5xl" data-reveal>
            <div class="text-center">
                <p class="text-xs font-semibold uppercase tracking-[0.25em] text-cyan-tech">Leadership</p>
                <h2 class="mt-4 font-display text-2xl font-bold text-white">Organizing Committee</h2>
            </div>
            <div class="mt-8 grid gap-4 sm:grid-cols-2 lg:grid-cols-4">
                @foreach ($committee as $member)
                    <div class="gx-card inner-liquid-card text-center">
                        <div class="mx-auto aspect-square w-40 overflow-hidden rounded-full border-2 border-cyan-tech/30 bg-dark-navy/50 sm:w-44 md:w-48">
                            @if ($member['image'])
                                <img src="{{ asset($member['image']) }}" alt="{{ $member['name'] }}" class="h-full w-full object-cover object-center">
                            @else
                                <div class="grid h-full w-full place-items-center bg-gradient-to-br from-cyan-tech/20 to-fresh-green/20">
                                    <span class="text-2xl text-cyan-tech">{{ substr($member['name'], 0, 1) }}</span>
                                </div>
                            @endif
                        </div>
                        <p class="mt-4 font-medium text-white">{{ $member['name'] }}</p>
                        <p class="mt-1 text-sm text-cyan-tech">{{ $member['role'] }}</p>
                        @if (isset($member['email']))
                            <a href="mailto:{{ $member['email'] }}" class="mt-3 inline-block text-xs text-light-gray/60 hover:text-light-gray transition">
                                {{ $member['email'] }}
                            </a>
                        @endif
                    </div>
                @endforeach
            </div>
        </div>

        {{-- Development Team Section --}}
        <div class="gx-reveal mx-auto mt-16 max-w-5xl" data-reveal>
            <div class="text-center">
                <p class="text-xs font-semibold uppercase tracking-[0.25em] text-fresh-green">Support</p>
                <h2 class="mt-4 font-display text-2xl font-bold text-white">Development Team</h2>
            </div>
            <div class="mt-8 grid justify-center gap-3 sm:grid-cols-2 md:grid-cols-3 lg:grid-cols-6">
                @foreach ($developmentTeam as $member)
                    <div class="gx-card inner-liquid-card p-3 text-center">
                        <div class="mx-auto aspect-square w-24 overflow-hidden rounded-full border-2 border-fresh-green/30 bg-dark-navy/50 sm:w-28 md:w-32 lg:w-28">
                            @if ($member['image'])
                                <img src="{{ asset($member['image']) }}" alt="{{ $member['name'] }}" class="h-full w-full object-cover object-center">
                            @else
                                <div class="grid h-full w-full place-items-center bg-gradient-to-br from-fresh-green/20 to-eco-lime/20">
                                    <span class="text-2xl text-fresh-green">{{ substr($member['name'], 0, 1) }}</span>
                                </div>
                            @endif
                        </div>
                        <p class="mt-3 text-sm font-medium text-white">{{ $member['name'] }}</p>
                        <p class="mt-1 text-[11px] leading-snug text-fresh-green">{{ $member['role'] }}</p>
                    </div>
                @endforeach
            </div>
        </div>

        <div class="gx-reveal mx-auto mt-10 max-w-4xl text-center" data-reveal>
            <h2 class="gx-card-title text-xl font-medium text-white">Follow {{ $org['short_name'] }}</h2>
            <p class="mt-2 text-sm text-light-gray/60">Events, workshops and announcements as they happen.</p>
            <div class="mt-5 flex justify-center">
                @include('partials.social-links')
            </div>
            <a href="{{ route('organizer') }}" class="gx-underline mt-8 inline-block text-sm text-cyan-tech">Learn more about the organizer →</a>
        </div>
    </section>
@endsection
