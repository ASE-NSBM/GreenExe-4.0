@extends('layouts.app')

@section('title', 'Organizer — '.config('greenexe.event.name'))

@section('content')
    <section class="mx-auto max-w-5xl px-4 py-20">
        {{-- FR-49 to FR-52 --}}
        <h1 class="font-display text-4xl font-bold text-white">Organizer</h1>

        <div class="mt-10 grid gap-6 md:grid-cols-2">
            @forelse ($blocks as $block)
                <article class="gx-card @if ($loop->first) border-cyan-tech/30 @endif">
                    <h2 class="font-display text-xl font-semibold text-white">{{ $block->title }}</h2>
                    <p class="mt-3 whitespace-pre-line text-light-gray/75">{{ $block->body }}</p>
                </article>
            @empty
                <article class="gx-card md:col-span-2">
                    <h2 class="font-display text-xl font-semibold text-white">{{ config('greenexe.event.organizer') }}</h2>
                    <p class="mt-3 text-light-gray/75">
                        The Association of Software Engineering is the student community behind
                        {{ config('greenexe.event.name') }} at {{ config('greenexe.event.university') }}.
                    </p>
                </article>
            @endforelse
        </div>

        <div class="mt-6 gx-card">
            <h2 class="font-display text-xl font-semibold text-white">Contact &amp; social media</h2>
            <ul class="mt-4 space-y-2 text-light-gray/75">
                <li>Email: <a class="text-cyan-tech hover:underline" href="mailto:{{ config('greenexe.contact.email') }}">{{ config('greenexe.contact.email') }}</a></li>
                <li>Phone: {{ config('greenexe.contact.phone') }}</li>
                <li>Address: {{ config('greenexe.contact.address') }}</li>
            </ul>
            <div class="mt-4 flex gap-4">
                @foreach (config('greenexe.contact.socials') as $name => $url)
                    <a href="{{ $url }}" class="gx-btn-ghost capitalize">{{ $name }}</a>
                @endforeach
            </div>
        </div>
    </section>
@endsection
