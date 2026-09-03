{{--
    Team and project registration form (FR-23 to FR-38).

    Shared by the dedicated /register page and the closing panel of the home
    page, so validation messages, member handling and the JS hooks only exist
    once. Callers may pass $categories, $minMembers and $maxMembers; otherwise
    the configured values are used.
--}}
@php
    $categories ??= config('greenexe.categories');
    $minMembers ??= config('greenexe.team.min_members');
    $maxMembers ??= config('greenexe.team.max_members');
@endphp

@if ($errors->any())
    <div class="mt-8 rounded-xl border border-red-400/40 bg-red-500/10 p-5" role="alert" tabindex="-1" data-error-summary>
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
        <legend class="gx-card-title text-xl font-medium text-white">1. Team</legend>

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
        <legend class="gx-card-title text-xl font-medium text-white">2. Team members</legend>
        <p class="mt-2 text-sm text-light-gray/60">
            Member 1 is the team leader and is the organisers' point of contact for the team.
        </p>

        {{-- Members are entered one at a time; the stepper below moves between
             them. Cards beyond the chosen team size are disabled so they never
             reach the server (SRS 12.1). --}}
        <div class="mt-5 flex items-center gap-3" data-member-progress>
            <div class="h-1 flex-1 overflow-hidden rounded-full bg-white/10">
                <div class="h-full rounded-full bg-gradient-to-r from-smart-green to-cyan-tech transition-all duration-500"
                     style="width: 0%" data-member-progress-bar></div>
            </div>
            <p class="shrink-0 text-xs tabular-nums text-light-gray/60">
                Member <span data-member-current>1</span> of <span data-member-total>{{ $minMembers }}</span>
            </p>
        </div>

        <div class="mt-5" data-member-list>
            @for ($i = 0; $i < $maxMembers; $i++)
                @php
                    $memberHasError = collect(['full_name', 'student_id', 'email', 'institution', 'contact_number', 'whatsapp_number'])
                        ->contains(fn ($field) => $errors->has("members.$i.$field"));
                @endphp

                <div class="rounded-xl border p-5 {{ $i === 0 ? 'border-cyan-tech/40 bg-cyan-tech/5' : 'border-white/10 bg-dark-navy/40' }}"
                     data-member-card data-member-index="{{ $i }}" @if ($memberHasError) data-member-error @endif>
                    <h3 class="gx-card-title flex flex-wrap items-center gap-3 text-base font-medium text-cyan-tech">
                        Member {{ $i + 1 }}

                        @if ($i === 0)
                            <span class="gx-badge border border-cyan-tech/40 bg-cyan-tech/10 text-[11px] uppercase tracking-[0.2em] text-cyan-tech">
                                Team leader
                            </span>
                        @endif
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
                                   class="gx-input" value="{{ old("members.$i.contact_number") }}" placeholder="0771234567"
                                   inputmode="numeric" autocomplete="tel" required minlength="10" maxlength="10"
                                   pattern="07[0-9]{8}">
                            @error("members.$i.contact_number") <p class="gx-error">{{ $message }}</p> @enderror
                        </div>

                        <div>
                            <label class="gx-label" for="members_{{ $i }}_whatsapp_number">WhatsApp number <span class="text-red-300">*</span></label>
                            <input id="members_{{ $i }}_whatsapp_number" name="members[{{ $i }}][whatsapp_number]" type="tel"
                                   class="gx-input" value="{{ old("members.$i.whatsapp_number") }}" placeholder="0771234567"
                                   inputmode="numeric" autocomplete="tel" required minlength="10" maxlength="10"
                                   pattern="07[0-9]{8}">
                            @error("members.$i.whatsapp_number") <p class="gx-error">{{ $message }}</p> @enderror
                        </div>
                    </div>
                </div>
            @endfor
        </div>

        {{-- Stepper controls. Hidden without JavaScript, where every member card
             is visible at once and the form still submits correctly. --}}
        <div class="mt-6 hidden flex-wrap items-center gap-3" data-member-nav>
            <button type="button"
                    class="rounded-full border border-white/20 px-5 py-2.5 text-sm font-medium text-light-gray/80 transition hover:border-cyan-tech hover:text-cyan-tech disabled:opacity-30 disabled:hover:border-white/20 disabled:hover:text-light-gray/80"
                    data-member-prev>
                Back
            </button>

            <button type="button"
                    class="group inline-flex items-center gap-2 rounded-full bg-smart-green px-6 py-2.5 text-sm font-medium text-white transition hover:bg-fresh-green hover:text-deep-green disabled:opacity-30"
                    data-member-next>
                <span data-member-next-label>Next member</span>
                <span class="transition-transform group-hover:translate-x-1" data-member-next-arrow>&rarr;</span>
            </button>

            <p class="text-xs text-light-gray/50" data-member-message role="status" aria-live="polite"></p>
        </div>
    </fieldset>

    {{-- Step 3 — Project (FR-27 to FR-31) --}}
    <fieldset class="gx-card">
        <legend class="gx-card-title text-xl font-medium text-white">3. Project</legend>

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

            <div class="grid gap-5 sm:grid-cols-2">
                <div>
                    <label class="gx-label" for="has_previous_hackathon_experience">
                        Has this project participated in another hackathon? <span class="text-red-300">*</span>
                    </label>
                    <select id="has_previous_hackathon_experience" name="has_previous_hackathon_experience"
                            class="gx-input" required>
                        <option value="">Select an answer</option>
                        <option value="0" @selected(old('has_previous_hackathon_experience') === '0')>No</option>
                        <option value="1" @selected(old('has_previous_hackathon_experience') === '1')>Yes</option>
                    </select>
                    @error('has_previous_hackathon_experience') <p class="gx-error">{{ $message }}</p> @enderror
                </div>

                <div>
                    <label class="gx-label" for="previous_hackathon_details">
                        Previous participation, placements, awards or wins
                    </label>
                    <textarea id="previous_hackathon_details" name="previous_hackathon_details" rows="4"
                              maxlength="1000" class="gx-input"
                              placeholder="If yes, list the hackathon name, year, placement, award, win, or other result.">{{ old('previous_hackathon_details') }}</textarea>
                    <p class="mt-2 text-xs text-light-gray/50">Required when you select Yes.</p>
                    @error('previous_hackathon_details') <p class="gx-error">{{ $message }}</p> @enderror
                </div>
            </div>
        </div>
    </fieldset>

    {{-- Step 4 — Declaration --}}
    <fieldset class="gx-card">
        <legend class="gx-card-title text-xl font-medium text-white">4. Declaration</legend>

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
