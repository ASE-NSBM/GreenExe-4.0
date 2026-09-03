@extends('layouts.app')

@section('title', 'Registration Confirmed — '.config('greenexe.event.name'))

@section('content')
    <section class="gx-section mx-auto max-w-4xl px-6 py-24 sm:px-10 md:px-14">
        <div class="gx-card gx-reveal border-fresh-green/40 text-center print:border-none" data-reveal>
            <div class="mx-auto grid h-14 w-14 place-items-center rounded-full bg-fresh-green/20 text-2xl">✅</div>
            <h1 class="mt-6 leading-[0.95] text-white">
                <span class="block font-playfair text-4xl font-normal italic sm:text-5xl"
                      style="letter-spacing: -0.05em">Registration</span>
                <span class="-mt-1 block text-4xl font-normal sm:text-5xl"
                      style="letter-spacing: -0.08em">confirmed</span>
            </h1>
            <p class="mx-auto mt-6 max-w-lg text-sm leading-relaxed text-white/75 md:text-base">
                Your team is registered for {{ config('greenexe.event.name') }}. Keep the reference below — it identifies
                your submission in all organiser communication.
            </p>

            {{-- FR-39 --}}
            <p class="mt-10 text-xs font-medium uppercase tracking-[0.3em] text-cyan-tech">Registration reference</p>
            <p class="mt-3 font-playfair text-4xl font-normal italic tracking-tight text-eco-lime">
                {{ $registration->registration_code }}
            </p>

            {{-- FR-41 --}}
            <div class="mt-6 flex flex-wrap items-center justify-center gap-3 text-sm text-light-gray/70">
                <span class="gx-badge bg-white/10">Submitted {{ $registration->created_at->format('d M Y, H:i') }}</span>
                <span class="gx-badge bg-cyan-tech/15 text-cyan-tech">Status: {{ Str::headline($registration->status) }}</span>
            </div>
        </div>

        {{-- FR-40 --}}
        <div class="mt-8 grid gap-6 md:grid-cols-2">
            <article class="gx-card">
                <h2 class="gx-card-title text-lg font-medium text-white">Team</h2>
                <dl class="mt-4 space-y-2 text-sm">
                    <div class="flex justify-between gap-4">
                        <dt class="text-light-gray/60">Team name</dt>
                        <dd class="text-right text-light-gray">{{ $registration->team_name }}</dd>
                    </div>
                    <div class="flex justify-between gap-4">
                        <dt class="text-light-gray/60">Members</dt>
                        <dd class="text-right text-light-gray">{{ $registration->member_count }}</dd>
                    </div>
                </dl>

                <ul class="mt-5 space-y-3">
                    @foreach ($registration->members as $member)
                        <li class="rounded-lg border border-white/10 bg-dark-navy/40 p-3 text-sm">
                            <p class="font-medium text-white">
                                {{ $member->full_name }}
                                @if ($member->is_leader)
                                    <span class="gx-badge ml-2 bg-eco-lime/20 text-eco-lime">Leader</span>
                                @endif
                            </p>
                            <p class="mt-1 text-light-gray/60">{{ $member->student_id }} · {{ $member->institution }}</p>
                        </li>
                    @endforeach
                </ul>
            </article>

            <article class="gx-card">
                <h2 class="gx-card-title text-lg font-medium text-white">Project</h2>
                <dl class="mt-4 space-y-3 text-sm">
                    <div>
                        <dt class="text-light-gray/60">Title</dt>
                        <dd class="text-light-gray">{{ $registration->project_title }}</dd>
                    </div>
                    <div>
                        <dt class="text-light-gray/60">Category</dt>
                        <dd class="text-light-gray">
                            {{ config('greenexe.categories')[$registration->project_category] ?? 'Not specified' }}
                        </dd>
                    </div>
                    <div>
                        <dt class="text-light-gray/60">Description</dt>
                        <dd class="text-light-gray/80">{{ Str::limit($registration->project_description, 400) }}</dd>
                    </div>
                    <div>
                        <dt class="text-light-gray/60">Previous hackathon participation</dt>
                        <dd class="text-light-gray">{{ $registration->has_previous_hackathon_experience ? 'Yes' : 'No' }}</dd>
                    </div>
                    @if ($registration->previous_hackathon_details)
                        <div>
                            <dt class="text-light-gray/60">Placements, awards, wins or other results</dt>
                            <dd class="text-light-gray/80">{{ $registration->previous_hackathon_details }}</dd>
                        </div>
                    @endif
                </dl>
            </article>
        </div>

        {{-- FR-42 --}}
        <div class="mt-8 flex flex-wrap justify-center gap-4 print:hidden">
            <button type="button" onclick="window.print()" class="gx-btn-ghost">Print / save confirmation</button>
            <a href="{{ route('home') }}" class="gx-btn-primary">Back to home</a>
        </div>
    </section>
@endsection
