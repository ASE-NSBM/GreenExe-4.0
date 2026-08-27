@extends('layouts.app')

@section('title', 'Register — '.config('greenexe.event.name'))

@section('content')
    <section class="gx-section mx-auto max-w-4xl px-6 py-24 sm:px-10 md:px-14">
        @include('partials.page-header', [
            'eyebrow' => config('greenexe.registration.open') ? 'Registration open' : 'Registration closed',
            'titleItalic' => 'Team &',
            'title' => 'project entry',
            'lead' => 'Every field marked with an asterisk is required. Your information is only visible to the '.config('greenexe.event.name').' organisers.',
            'center' => true,
        ])

        {{-- Progress indicator (SRS 9.5) --}}
        <ol class="gx-reveal mt-12 flex flex-wrap items-center justify-center gap-3 text-sm" aria-label="Registration steps" data-reveal>
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
