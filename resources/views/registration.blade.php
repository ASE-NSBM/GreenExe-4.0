@extends('layouts.app')

@section('title', 'Register — '.config('greenexe.event.name'))

@section('content')
    <section class="mx-auto max-w-4xl px-4 py-16">
        <h1 class="font-display text-4xl font-bold text-white">Team &amp; Project Registration</h1>
        <p class="mt-3 text-light-gray/75">
            All fields marked <span class="text-red-300">*</span> are required. Your information is only visible to the
            {{ config('greenexe.event.name') }} organisers.
        </p>

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

        @if ($errors->any())
            <div class="mt-8 rounded-xl border border-red-400/40 bg-red-500/10 p-5" role="alert">
                <p class="font-semibold text-red-200">Please correct the following before submitting:</p>
                <ul class="mt-2 list-inside list-disc space-y-1 text-sm text-red-200/90">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form method="POST" action="{{ route('register.store') }}" class="mt-10 space-y-8" data-registration-form novalidate>
            @csrf

            {{-- Step 1 — Team (FR-23, FR-24) --}}
            <fieldset class="gx-card">
                <legend class="font-display text-xl font-semibold text-white">1. Team</legend>

                <div class="mt-6 grid gap-5 sm:grid-cols-2">
                    <div>
                        <label class="gx-label" for="team_name">Team name <span class="text-red-300">*</span></label>
                        <input id="team_name" name="team_name" type="text" class="gx-input"
                               value="{{ old('team_name') }}" required maxlength="120">
                        @error('team_name') <p class="gx-error">{{ $message }}</p> @enderror
                    </div>

                    <div>
                        <label class="gx-label" for="member_count">Number of team members <span class="text-red-300">*</span></label>
                        <select id="member_count" name="member_count" class="gx-input" data-member-count required>
                            @for ($i = $minMembers; $i <= $maxMembers; $i++)
                                <option value="{{ $i }}" @selected(old('member_count', $minMembers) == $i)>{{ $i }} members</option>
                            @endfor
                        </select>
                        @error('member_count') <p class="gx-error">{{ $message }}</p> @enderror
                    </div>
                </div>
            </fieldset>

            {{-- Step 2 — Members (FR-25, FR-26) --}}
            <fieldset class="gx-card">
                <legend class="font-display text-xl font-semibold text-white">2. Team members</legend>
                <p class="mt-2 text-sm text-light-gray/60">Member 1 is recorded as the team leader.</p>

                <div class="mt-6 space-y-6" data-member-list>
                    @for ($i = 0; $i < $maxMembers; $i++)
                        <div class="rounded-xl border border-white/10 bg-dark-navy/40 p-5" data-member-card data-member-index="{{ $i }}">
                            <h3 class="font-display text-base font-semibold text-cyan-tech">
                                Member {{ $i + 1 }}{{ $i === 0 ? ' — Team leader' : '' }}
                            </h3>

                            <div class="mt-4 grid gap-4 sm:grid-cols-2">
                                <div>
                                    <label class="gx-label" for="members_{{ $i }}_full_name">Full name <span class="text-red-300">*</span></label>
                                    <input id="members_{{ $i }}_full_name" name="members[{{ $i }}][full_name]" type="text"
                                           class="gx-input" value="{{ old("members.$i.full_name") }}" maxlength="120">
                                    @error("members.$i.full_name") <p class="gx-error">{{ $message }}</p> @enderror
                                </div>

                                <div>
                                    <label class="gx-label" for="members_{{ $i }}_student_id">Student ID <span class="text-red-300">*</span></label>
                                    <input id="members_{{ $i }}_student_id" name="members[{{ $i }}][student_id]" type="text"
                                           class="gx-input" value="{{ old("members.$i.student_id") }}" maxlength="40">
                                    @error("members.$i.student_id") <p class="gx-error">{{ $message }}</p> @enderror
                                </div>

                                <div>
                                    <label class="gx-label" for="members_{{ $i }}_email">Email <span class="text-red-300">*</span></label>
                                    <input id="members_{{ $i }}_email" name="members[{{ $i }}][email]" type="email"
                                           class="gx-input" value="{{ old("members.$i.email") }}" maxlength="150">
                                    @error("members.$i.email") <p class="gx-error">{{ $message }}</p> @enderror
                                </div>

                                <div>
                                    <label class="gx-label" for="members_{{ $i }}_institution">Institution <span class="text-red-300">*</span></label>
                                    <input id="members_{{ $i }}_institution" name="members[{{ $i }}][institution]" type="text"
                                           class="gx-input" value="{{ old("members.$i.institution", config('greenexe.event.university')) }}" maxlength="150">
                                    @error("members.$i.institution") <p class="gx-error">{{ $message }}</p> @enderror
                                </div>

                                <div>
                                    <label class="gx-label" for="members_{{ $i }}_contact_number">Contact number <span class="text-red-300">*</span></label>
                                    <input id="members_{{ $i }}_contact_number" name="members[{{ $i }}][contact_number]" type="tel"
                                           class="gx-input" value="{{ old("members.$i.contact_number") }}" placeholder="0771234567">
                                    @error("members.$i.contact_number") <p class="gx-error">{{ $message }}</p> @enderror
                                </div>

                                <div>
                                    <label class="gx-label" for="members_{{ $i }}_whatsapp_number">WhatsApp number <span class="text-red-300">*</span></label>
                                    <input id="members_{{ $i }}_whatsapp_number" name="members[{{ $i }}][whatsapp_number]" type="tel"
                                           class="gx-input" value="{{ old("members.$i.whatsapp_number") }}" placeholder="0771234567">
                                    @error("members.$i.whatsapp_number") <p class="gx-error">{{ $message }}</p> @enderror
                                </div>
                            </div>
                        </div>
                    @endfor
                </div>
            </fieldset>

            {{-- Step 3 — Project (FR-27 to FR-31) --}}
            <fieldset class="gx-card">
                <legend class="font-display text-xl font-semibold text-white">3. Project</legend>

                <div class="mt-6 space-y-5">
                    <div class="grid gap-5 sm:grid-cols-2">
                        <div>
                            <label class="gx-label" for="project_title">Project title <span class="text-red-300">*</span></label>
                            <input id="project_title" name="project_title" type="text" class="gx-input"
                                   value="{{ old('project_title') }}" maxlength="150">
                            @error('project_title') <p class="gx-error">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="gx-label" for="project_category">Project category</label>
                            <select id="project_category" name="project_category" class="gx-input">
                                <option value="">Select a category</option>
                                @foreach ($categories as $value => $label)
                                    <option value="{{ $value }}" @selected(old('project_category') === $value)>{{ $label }}</option>
                                @endforeach
                            </select>
                            @error('project_category') <p class="gx-error">{{ $message }}</p> @enderror
                        </div>
                    </div>

                    @php
                        $textareas = [
                            'project_description' => ['Project description', 'Give an overview of your Smart Green City project.'],
                            'problem_statement' => ['Problem statement', 'Which problem does your project address?'],
                            'proposed_solution' => ['Proposed solution', 'How does your project solve that problem?'],
                            'technology_used' => ['Technology used', 'Languages, frameworks, hardware, platforms.'],
                            'innovation_description' => ['Innovation', 'What makes your approach new or different?'],
                            'expected_impact' => ['Expected impact', 'What changes if your project is adopted?'],
                        ];
                    @endphp

                    @foreach ($textareas as $field => [$label, $hint])
                        <div>
                            <label class="gx-label" for="{{ $field }}">{{ $label }} <span class="text-red-300">*</span></label>
                            <textarea id="{{ $field }}" name="{{ $field }}" rows="4" class="gx-input"
                                      placeholder="{{ $hint }}">{{ old($field) }}</textarea>
                            @error($field) <p class="gx-error">{{ $message }}</p> @enderror
                        </div>
                    @endforeach
                </div>
            </fieldset>

            {{-- Step 4 — Declaration --}}
            <fieldset class="gx-card">
                <legend class="font-display text-xl font-semibold text-white">4. Declaration</legend>

                <label class="mt-6 flex items-start gap-3 text-sm text-light-gray/80" for="declaration">
                    <input id="declaration" name="declaration" type="checkbox" value="1"
                           class="mt-1 h-4 w-4 rounded border-white/20 bg-dark-navy text-smart-green"
                           @checked(old('declaration'))>
                    <span>
                        I confirm the information above is accurate, and our team accepts the
                        <a href="{{ route('rules') }}" class="text-cyan-tech hover:underline">competition rules and eligibility requirements</a>.
                    </span>
                </label>
                @error('declaration') <p class="gx-error">{{ $message }}</p> @enderror

                <div class="mt-8 flex flex-wrap items-center gap-4">
                    <button type="submit" class="gx-btn-primary" data-submit-button>
                        <span data-submit-label>Submit registration</span>
                    </button>
                    <p class="text-xs text-light-gray/50">
                        Your submission is validated on the server before it is stored.
                    </p>
                </div>
            </fieldset>
        </form>
    </section>
@endsection
