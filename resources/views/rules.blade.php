@extends('layouts.app')

@section('meta_description', 'Read the official GreenExE 4.0 competition rules, project requirements, team requirements and eligibility information.')

@section('title', 'Rules & Eligibility — '.config('greenexe.event.name'))

@section('content')
    @include('partials.page-hero', [
        'image' => 'assets/img/bg2.jpeg',
        'eyebrow' => 'Before you enter',
        'titleItalic' => 'Rules &',
        'title' => 'eligibility',
        'lead' => 'Final competition rules are confirmed by the organisers before registration opens.',
    ])

    <section class="gx-section mx-auto max-w-5xl px-6 pb-24">
        {{-- FR-44 to FR-48 --}}

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
                <div class="gx-reveal" data-reveal>
                    <h2 class="gx-group-label text-2xl font-normal text-white sm:text-3xl">{!! $label !!}</h2>
                    <div class="mt-4 space-y-4">
                        @forelse ($sections[$key] ?? [] as $item)
                            <article class="gx-card">
                                <h3 class="gx-card-title text-lg font-medium text-white">{{ $item->title }}</h3>
                                <p class="mt-2 whitespace-pre-line text-sm leading-relaxed text-white/75 md:text-base">{{ $item->body }}</p>
                            </article>
                        @empty
                            <p class="text-sm text-light-gray/60">To be published by the organisers.</p>
                        @endforelse
                    </div>
                </div>
            @endforeach
        </div>

        <div class="gx-reveal mt-12 gx-card border-eco-lime/30" data-reveal>
            <h2 class="gx-card-title text-lg font-medium text-white">Team size</h2>
            <p class="mt-2 text-light-gray/75">
                Teams must have between {{ config('greenexe.team.min_members') }} and
                {{ config('greenexe.team.max_members') }} members. The first member entered is treated as the team leader.
            </p>
        </div>
    </section>
@endsection
