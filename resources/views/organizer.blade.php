@extends('layouts.app')

@section('title', 'Organizer — '.config('greenexe.event.name'))

@section('content')
    <section class="mx-auto max-w-5xl px-4 py-20">
        {{-- FR-49 to FR-52 --}}
        <h1 class="font-display text-4xl font-bold text-white">Organizer</h1>

        <div class="mt-10 grid gap-6 md:grid-cols-2">
            <article class="gx-card">
                <h2 class="font-display text-xl font-semibold text-white">{{ config('greenexe.event.organizer') }}</h2>
                <p class="mt-3 text-light-gray/75">
                    The Association of Software Engineering is the student community behind
                    {{ config('greenexe.event.name') }} at {{ config('greenexe.event.university') }}.
                </p>
            </article>

            <article class="gx-card border-cyan-tech/30">
                <h2 class="font-display text-xl font-semibold text-white">{{ config('greenexe.event.brand') }}</h2>
                <p class="mt-3 text-light-gray/75">
                    {{ config('greenexe.event.brand') }} is the official brand identity for the
                    {{ config('greenexe.event.name') }} event series.
                </p>
            </article>
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
