@extends('layouts.app')

@section('title', 'Rules & Eligibility — '.config('greenexe.event.name'))

@section('content')
    <section class="mx-auto max-w-5xl px-4 py-20">
        {{-- FR-44 to FR-48 --}}
        <h1 class="font-display text-4xl font-bold text-white">Rules &amp; Eligibility</h1>
        <p class="mt-4 max-w-3xl text-lg text-light-gray/75">
            Final competition rules are confirmed by the organisers before registration opens.
        </p>

        @php
            $labels = [
                'eligibility' => 'Eligibility requirements',
                'team_requirements' => 'Team requirements',
                'project_requirements' => 'Project requirements',
                'submission' => 'Submission &amp; presentation',
                'rules' => 'Competition rules &amp; disqualification',
            ];
        @endphp

        <div class="mt-12 space-y-10">
            @foreach ($labels as $key => $label)
                <div>
                    <h2 class="font-display text-2xl font-semibold text-cyan-tech">{!! $label !!}</h2>
                    <div class="mt-4 space-y-4">
                        @forelse ($sections[$key] ?? [] as $item)
                            <article class="gx-card">
                                <h3 class="font-display text-lg font-semibold text-white">{{ $item->title }}</h3>
                                <p class="mt-2 whitespace-pre-line text-light-gray/75">{{ $item->body }}</p>
                            </article>
                        @empty
                            <p class="text-sm text-light-gray/60">To be published by the organisers.</p>
                        @endforelse
                    </div>
                </div>
            @endforeach
        </div>

        <div class="mt-12 gx-card border-eco-lime/30">
            <h2 class="font-display text-lg font-semibold text-white">Team size</h2>
            <p class="mt-2 text-light-gray/75">
                Teams must have between {{ config('greenexe.team.min_members') }} and
                {{ config('greenexe.team.max_members') }} members. The first member entered is treated as the team leader.
            </p>
        </div>
    </section>
@endsection
