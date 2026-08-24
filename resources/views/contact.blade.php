@extends('layouts.app')

@section('title', 'Contact — '.config('greenexe.event.name'))

@section('content')
    <section class="mx-auto max-w-3xl px-4 py-20">
        <h1 class="font-display text-4xl font-bold text-white">Contact</h1>
        <p class="mt-4 text-lg text-light-gray/75">
            Reach the {{ config('greenexe.event.organizer') }} team for anything about
            {{ config('greenexe.event.name') }}.
        </p>

        <div class="mt-10 gx-card space-y-4 text-light-gray/75">
            <p><span class="text-white">Email:</span>
                <a class="text-cyan-tech hover:underline" href="mailto:{{ config('greenexe.contact.email') }}">{{ config('greenexe.contact.email') }}</a>
            </p>
            <p><span class="text-white">Phone:</span> {{ config('greenexe.contact.phone') }}</p>
            <p><span class="text-white">Address:</span> {{ config('greenexe.contact.address') }}</p>
        </div>
    </section>
@endsection
