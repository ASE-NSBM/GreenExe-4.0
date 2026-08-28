@extends('layouts.app')

@section('title', 'Register — '.config('greenexe.event.name'))

@section('content')
    <section class="mx-auto max-w-4xl px-4 py-16">
        <x-page-header
            eyebrow="Enter the challenge"
            title="Team &amp; Project Registration"
            :description="'All fields are required. Your information is only visible to the '.config('greenexe.event.name').' organisers.'" />

        {{-- Progress indicator (SRS 9.5) --}}
        <ol class="mt-10 flex flex-wrap items-center gap-3 text-sm" aria-label="Registration steps">
            @foreach (['Team', 'Members', 'Project', 'Submit'] as $index => $step)
                <li class="flex items-center gap-2">
                    <span class="grid h-7 w-7 place-items-center rounded-full bg-white/10 text-xs font-semibold text-cyan-tech">{{ $index + 1 }}</span>
                    <span class="text-light-gray/70">{{ $step }}</span>
                    @if (! $loop->last)
                        <span class="hidden h-px w-8 bg-white/20 sm:block"></span>
                    @endif
                </li>
            @endforeach
        </ol>

        @include('partials.registration-form')
    </section>
@endsection
