@extends('layouts.app')

@section('title', 'About '.config('greenexe.event.name').' — '.config('greenexe.event.concept'))

@section('content')
    <div class="relative w-full tracking-[-0.02em]">

        {{-- =========================================================================
             1. FR-8: GreenExE 4.0 Introduction & Hero
             ========================================================================= --}}
        <section class="relative mx-auto max-w-6xl px-6 pt-32 pb-16 sm:px-10 md:pt-40 md:pb-24">
            <div class="max-w-3xl">
                <p class="hero-anim hero-fade text-xs font-medium uppercase tracking-[0.3em] text-cyan-tech"
                   style="animation-delay: 0.1s">
                    {{ config('greenexe.event.name') }} &bull; Complete Competition Specification
                </p>

                <h1 class="mt-4 leading-[0.95] text-white">
                    <span class="hero-anim hero-reveal block font-playfair text-5xl font-normal italic sm:text-7xl md:text-8xl"
                          style="letter-spacing: -0.05em; animation-delay: 0.25s">About</span>
                    <span class="hero-anim hero-reveal -mt-1 block text-5xl font-normal sm:text-7xl md:text-8xl"
                          style="letter-spacing: -0.08em; animation-delay: 0.42s">{{ config('greenexe.event.name') }}</span>
                </h1>

                <p class="hero-anim hero-fade mt-6 text-base leading-relaxed text-white/80 sm:text-lg"
                   style="animation-delay: 0.6s">
                    {{ config('greenexe.event.tagline') }} Organized by the {{ config('greenexe.event.organizer') }}
                    under the {{ config('greenexe.event.brand') }} brand at {{ config('greenexe.event.university') }}.
                </p>
            </div>
        </section>

        {{-- =========================================================================
             2. FR-9: Competition Purpose and Objectives
             ========================================================================= --}}
        <section id="purpose" class="border-t border-white/10 bg-dark-navy/60 py-20 md:py-28">
            <div class="mx-auto max-w-6xl px-6 sm:px-10">
                <div class="grid gap-12 md:grid-cols-12 md:gap-16">
                    {{-- Left Narrative --}}
                    <div class="gx-reveal md:col-span-5" data-reveal>
                        <p class="text-xs font-medium uppercase tracking-[0.3em] text-fresh-green">
                            Purpose &amp; Objectives
                        </p>

                        <h2 class="mt-3 leading-[0.95] text-white">
                            <span class="block font-playfair text-3xl font-normal italic sm:text-4xl md:text-5xl"
                                  style="letter-spacing: -0.05em">Empowering student</span>
                            <span class="-mt-1 block text-3xl font-normal sm:text-4xl md:text-5xl"
                                  style="letter-spacing: -0.08em">sustainable innovation</span>
                        </h2>

                        <p class="mt-6 text-sm leading-relaxed text-white/70 sm:text-base">
                            GreenExE is designed to bridge the gap between classroom theory and real-world urban technology. Undergraduates collaborate in multidisciplinary teams to engineer scalable prototypes addressing real environmental and civic challenges.
                        </p>

                        <div class="mt-8">
                            <a href="{{ route('register') }}"
                               class="rounded-full bg-[#e8702a] px-7 py-3 text-sm font-medium text-white transition-all duration-300 hover:scale-[1.03] hover:bg-[#d2611f] hover:shadow-lg hover:shadow-[#e8702a]/30 active:scale-95">
                                Register Your Team
                            </a>
                        </div>
                    </div>

                    {{-- Right Compendium List --}}
                    <div class="md:col-span-7">
                        @php
                            $overview = $sections->get('overview')?->first()?->body ?? 'GreenExE 4.0 invites student teams to design technology solutions that turn a green environment into a connected, efficient, intelligent and sustainable city.';
                            $purpose = $sections->get('purpose')?->first()?->body ?? 'Encourage students to apply technology and innovation to real sustainability problems, and to present workable smart-city solutions to an industry audience.';

                            $purposeEntries = [
                                [
                                    'num' => '01',
                                    'label' => 'Overview',
                                    'title' => 'Competition Overview',
                                    'body' => $overview,
                                ],
                                [
                                    'num' => '02',
                                    'label' => 'Objective',
                                    'title' => 'Purpose & Strategic Goals',
                                    'body' => $purpose,
                                ],
                            ];
                        @endphp

                        <div class="space-y-0">
                            @foreach ($purposeEntries as $index => $item)
                                <article class="gx-reveal group relative border-t border-white/15 py-8 first:border-t-0 first:pt-0"
                                         data-reveal style="transition-delay: {{ 0.15 * ($index + 1) }}s">
                                    <span class="absolute left-0 top-0 h-px w-0 bg-gradient-to-r from-cyan-tech to-transparent transition-all duration-700 group-hover:w-full" aria-hidden="true"></span>

                                    <div class="flex items-baseline gap-4">
                                        <span class="font-playfair text-sm italic text-cyan-tech/80">{{ $item['num'] }}</span>
                                        <span class="text-[11px] font-medium uppercase tracking-[0.3em] text-white/45">{{ $item['label'] }}</span>
                                    </div>

                                    <h3 class="mt-2 text-xl font-medium text-white transition-colors duration-300 group-hover:text-cyan-tech md:text-2xl"
                                        style="letter-spacing: -0.04em">
                                        {{ $item['title'] }}
                                    </h3>

                                    <p class="mt-3 text-sm leading-relaxed text-white/70 sm:text-base">
                                        {{ $item['body'] }}
                                    </p>
                                </article>
                            @endforeach
                        </div>
                    </div>
                </div>
            </div>
        </section>

        {{-- =========================================================================
             3. FR-10: Explain the Smart Green City Concept & 9 Pillars
             ========================================================================= --}}
        <section id="smart-green-city" class="border-t border-white/10 py-20 md:py-28">
            <div class="mx-auto max-w-6xl px-6 sm:px-10">
                <div class="gx-reveal max-w-3xl" data-reveal>
                    <p class="text-xs font-medium uppercase tracking-[0.3em] text-cyan-tech">The Guiding Concept</p>
                    <h2 class="mt-3 leading-[0.95] text-white">
                        <span class="block font-playfair text-4xl font-normal italic sm:text-5xl md:text-6xl"
                              style="letter-spacing: -0.05em">Smart Green City</span>
                        <span class="-mt-1 block text-4xl font-normal sm:text-5xl md:text-6xl"
                              style="letter-spacing: -0.08em">Concept &amp; Pillars</span>
                    </h2>
                    <p class="mt-4 text-sm leading-relaxed text-white/75 sm:text-base">
                        Inspired by the <strong class="text-white">{{ config('greenexe.event.university') }}</strong> campus, GreenExE 4.0 explores how digital infrastructure, IoT automation, clean energy, and environmental sensing transform a green campus into an intelligent, connected city.
                    </p>
                </div>

                {{-- The 9 Smart City Pillars Gallery --}}
                @php
                    $tints = [
                        'from-forest-green via-deep-green to-dark-navy',
                        'from-smart-green/80 via-forest-green to-dark-navy',
                        'from-eco-lime/40 via-smart-green/60 to-dark-navy',
                        'from-cyan-tech/40 via-forest-green to-dark-navy',
                        'from-cyan-tech/30 via-deep-green to-dark-navy',
                        'from-fresh-green/40 via-forest-green to-dark-navy',
                        'from-cyan-tech/45 via-smart-green/50 to-dark-navy',
                        'from-deep-green via-forest-green/80 to-dark-navy',
                        'from-eco-lime/30 via-cyan-tech/30 to-dark-navy',
                    ];
                @endphp

                <div class="mt-14 grid gap-6 sm:grid-cols-2 lg:grid-cols-3">
                    @forelse ($smartCityPillars as $index => $pillar)
                        @php
                            $lines = preg_split('/\R+/', trim($pillar->description));
                            $lead = array_shift($lines);
                            $tint = $tints[$index % count($tints)];
                        @endphp

                        <article class="gx-reveal group relative flex min-h-[380px] flex-col justify-end overflow-hidden rounded-3xl border border-white/10 bg-white/5 transition-all duration-500 hover:-translate-y-1 hover:border-cyan-tech/50 hover:shadow-2xl hover:shadow-cyan-tech/10"
                                 data-reveal style="transition-delay: {{ 0.08 * ($index % 3 + 1) }}s">
                            @if (!empty($pillar->image))
                                <div class="absolute inset-0 bg-cover bg-center transition-transform duration-700 ease-out group-hover:scale-105"
                                     style="background-image: url('{{ $pillar->image }}')" aria-hidden="true"></div>
                                <div class="absolute inset-0 bg-gradient-to-t from-dark-navy via-dark-navy/85 to-dark-navy/35 transition-opacity duration-500 group-hover:opacity-90" aria-hidden="true"></div>
                            @else
                                <div class="absolute inset-0 bg-gradient-to-br {{ $tint }}" aria-hidden="true"></div>
                                <div class="gx-grid-bg absolute inset-0 opacity-30" aria-hidden="true"></div>
                                <span class="gx-watermark" aria-hidden="true">{{ $pillar->icon ?? '🌿' }}</span>
                                <div class="absolute inset-0 bg-gradient-to-t from-dark-navy via-dark-navy/40 to-transparent" aria-hidden="true"></div>
                            @endif

                            <span class="gx-rank" aria-hidden="true">{{ $index + 1 }}</span>

                            <div class="relative flex h-full flex-col p-6 sm:p-8">
                                <span class="text-2xl transition-transform duration-300 group-hover:scale-110">{{ $pillar->icon ?? '🌿' }}</span>

                                <h3 class="mt-auto text-xl font-medium leading-tight text-white transition-colors duration-300 group-hover:text-cyan-tech md:text-2xl"
                                    style="letter-spacing: -0.04em">
                                    {{ $pillar->title }}
                                </h3>

                                <p class="mt-3 text-sm leading-relaxed text-white/75">{{ $lead }}</p>

                                @if ($lines)
                                    <ul class="mt-4 space-y-2 border-t border-white/10 pt-4 text-xs leading-relaxed text-white/75 sm:text-sm">
                                        @foreach ($lines as $line)
                                            <li class="flex items-start gap-2.5">
                                                <span class="mt-1.5 h-1.5 w-1.5 shrink-0 rounded-full bg-fresh-green transition-transform duration-300 group-hover:scale-125"></span>
                                                <span>{{ $line }}</span>
                                            </li>
                                        @endforeach
                                    </ul>
                                @endif
                            </div>
                        </article>
                    @empty
                        <p class="col-span-full text-white/60">Smart city pillars will be published soon.</p>
                    @endforelse
                </div>
            </div>
        </section>

        {{-- =========================================================================
             4. FR-11 & FR-12: Participant Eligibility, Rules & Requirements
             ========================================================================= --}}
        <section id="rules-eligibility" class="border-t border-white/10 bg-dark-navy/60 py-20 md:py-28">
            <div class="mx-auto max-w-6xl px-6 sm:px-10">
                <div class="gx-reveal max-w-3xl" data-reveal>
                    <p class="text-xs font-medium uppercase tracking-[0.3em] text-eco-lime">Participation Guidelines</p>
                    <h2 class="mt-3 leading-[0.95] text-white">
                        <span class="block font-playfair text-4xl font-normal italic sm:text-5xl md:text-6xl"
                              style="letter-spacing: -0.05em">Eligibility &amp;</span>
                        <span class="-mt-1 block text-4xl font-normal sm:text-5xl md:text-6xl"
                              style="letter-spacing: -0.08em">Competition Rules</span>
                    </h2>
                    <p class="mt-4 text-sm leading-relaxed text-white/75 sm:text-base">
                        Ensure your team meets all eligibility criteria and strictly follows the participation rules.
                    </p>
                </div>

                <div class="mt-14 grid gap-8 md:grid-cols-2">
                    {{-- Eligibility --}}
                    <div class="gx-reveal border-t border-white/15 pt-8" data-reveal>
                        <div class="flex items-baseline gap-4">
                            <span class="font-playfair text-sm italic text-eco-lime">01</span>
                            <span class="text-[11px] font-medium uppercase tracking-[0.3em] text-white/45">Eligibility Criteria</span>
                        </div>
                        <h3 class="mt-2 text-2xl font-medium text-white" style="letter-spacing: -0.04em">
                            Participant Eligibility
                        </h3>
                        <ul class="mt-4 space-y-3 text-sm leading-relaxed text-white/75">
                            <li class="flex items-start gap-2.5">
                                <span class="mt-2 h-1.5 w-1.5 shrink-0 rounded-full bg-eco-lime"></span>
                                <span>Open to all registered undergraduate students from recognized universities and higher education institutes.</span>
                            </li>
                            <li class="flex items-start gap-2.5">
                                <span class="mt-2 h-1.5 w-1.5 shrink-0 rounded-full bg-eco-lime"></span>
                                <span>Teams must have between <strong>{{ config('greenexe.team.min_members') }}</strong> and <strong>{{ config('greenexe.team.max_members') }}</strong> members.</span>
                            </li>
                            <li class="flex items-start gap-2.5">
                                <span class="mt-2 h-1.5 w-1.5 shrink-0 rounded-full bg-eco-lime"></span>
                                <span>Multidisciplinary team composition (Software Engineering, Data Science, Electrical/IoT, Environmental Sciences) is encouraged.</span>
                            </li>
                        </ul>
                    </div>

                    {{-- Rules & Requirements --}}
                    <div class="gx-reveal border-t border-white/15 pt-8" data-reveal style="transition-delay: 0.15s">
                        <div class="flex items-baseline gap-4">
                            <span class="font-playfair text-sm italic text-cyan-tech">02</span>
                            <span class="text-[11px] font-medium uppercase tracking-[0.3em] text-white/45">Competition Rules</span>
                        </div>
                        <h3 class="mt-2 text-2xl font-medium text-white" style="letter-spacing: -0.04em">
                            Rules &amp; Requirements
                        </h3>
                        <ul class="mt-4 space-y-3 text-sm leading-relaxed text-white/75">
                            <li class="flex items-start gap-2.5">
                                <span class="mt-2 h-1.5 w-1.5 shrink-0 rounded-full bg-cyan-tech"></span>
                                <span><strong>Team Leader:</strong> The first member entered during registration is designated as the primary point of contact.</span>
                            </li>
                            <li class="flex items-start gap-2.5">
                                <span class="mt-2 h-1.5 w-1.5 shrink-0 rounded-full bg-cyan-tech"></span>
                                <span><strong>Originality:</strong> All submitted ideas and prototypes must be the original work of the team. Plagiarism results in immediate disqualification.</span>
                            </li>
                            <li class="flex items-start gap-2.5">
                                <span class="mt-2 h-1.5 w-1.5 shrink-0 rounded-full bg-cyan-tech"></span>
                                <span><strong>Submission Scope:</strong> Teams must submit a problem statement, technical stack, architecture blueprint, and expected sustainability impact.</span>
                            </li>
                            <li class="flex items-start gap-2.5">
                                <span class="mt-2 h-1.5 w-1.5 shrink-0 rounded-full bg-cyan-tech"></span>
                                <span><strong>Deadlines:</strong> Registrations and project deliverables must be submitted before published closing timestamps.</span>
                            </li>
                        </ul>
                    </div>
                </div>
            </div>
        </section>

        {{-- =========================================================================
             5. FR-13: Participant Benefits
             ========================================================================= --}}
        <section id="benefits" class="border-t border-white/10 py-20 md:py-28">
            <div class="mx-auto max-w-6xl px-6 sm:px-10">
                <div class="gx-reveal max-w-3xl" data-reveal>
                    <p class="text-xs font-medium uppercase tracking-[0.3em] text-fresh-green">Why Participate</p>
                    <h2 class="mt-3 leading-[0.95] text-white">
                        <span class="block font-playfair text-4xl font-normal italic sm:text-5xl md:text-6xl"
                              style="letter-spacing: -0.05em">Participant Benefits &amp;</span>
                        <span class="-mt-1 block text-4xl font-normal sm:text-5xl md:text-6xl"
                              style="letter-spacing: -0.08em">Opportunities</span>
                    </h2>
                    <p class="mt-4 text-sm leading-relaxed text-white/75 sm:text-base">
                        GreenExE 4.0 provides competitive exposure, direct industry engagement, and hands-on engineering experience.
                    </p>
                </div>

                @php
                    $benefitCards = [
                        [
                            'num' => '01',
                            'title' => 'Industry Mentorship',
                            'description' => 'Receive direct feedback, architectural guidance, and pitch mentoring from senior industry leaders and sustainability researchers.',
                        ],
                        [
                            'num' => '02',
                            'title' => 'Project Exposure',
                            'description' => 'Showcase your solution on stage to corporate sponsors, tech executives, potential investors, and academic panels.',
                        ],
                        [
                            'num' => '03',
                            'title' => 'Hands-on Engineering',
                            'description' => 'Apply theoretical computer science, IoT, and cloud technologies to solve tangible urban environmental problems.',
                        ],
                        [
                            'num' => '04',
                            'title' => 'ASE Community & Network',
                            'description' => 'Join the vibrant Association of Software Engineering network, build career connections, and earn recognized certificates.',
                        ],
                    ];
                @endphp

                <div class="mt-14 grid gap-6 sm:grid-cols-2 lg:grid-cols-4">
                    @foreach ($benefitCards as $index => $benefit)
                        <article class="gx-reveal group relative border-t border-white/15 pt-6 transition-colors"
                                 data-reveal style="transition-delay: {{ 0.1 * ($index + 1) }}s">
                            <span class="absolute left-0 top-0 h-px w-0 bg-gradient-to-r from-fresh-green to-transparent transition-all duration-500 group-hover:w-full" aria-hidden="true"></span>
                            <span class="font-playfair text-sm italic text-fresh-green">{{ $benefit['num'] }}</span>
                            <h3 class="mt-2 text-lg font-medium text-white transition-colors duration-300 group-hover:text-fresh-green" style="letter-spacing: -0.03em">
                                {{ $benefit['title'] }}
                            </h3>
                            <p class="mt-3 text-xs leading-relaxed text-white/70 sm:text-sm">
                                {{ $benefit['description'] }}
                            </p>
                        </article>
                    @endforeach
                </div>
            </div>
        </section>

        {{-- =========================================================================
             6. FR-14: Frequently Asked Questions (FAQ)
             ========================================================================= --}}
        <section id="faqs" class="border-t border-white/10 bg-dark-navy/60 py-20 md:py-28">
            <div class="mx-auto max-w-4xl px-6 sm:px-10">
                <div class="gx-reveal text-center" data-reveal>
                    <p class="text-xs font-medium uppercase tracking-[0.3em] text-cyan-tech">Direct Answers</p>
                    <h2 class="mt-3 leading-[0.95] text-white">
                        <span class="block font-playfair text-4xl font-normal italic sm:text-5xl md:text-6xl"
                              style="letter-spacing: -0.05em">Frequently Asked</span>
                        <span class="-mt-1 block text-4xl font-normal sm:text-5xl md:text-6xl"
                              style="letter-spacing: -0.08em">Questions</span>
                    </h2>
                    <p class="mt-4 text-sm text-white/70 sm:text-base">
                        Common questions from GreenExE 4.0 participants regarding registration, rules, and timelines.
                    </p>
                </div>

                @php
                    $displayFaqs = ($faqs && $faqs->isNotEmpty()) ? $faqs : collect([
                        (object)[
                            'id' => 'mock-1',
                            'question' => 'Who is eligible to participate in GreenExE 4.0?',
                            'answer' => 'Undergraduate students from any recognized university or faculty are eligible to participate. Multidisciplinary teams uniting software developers, designers, IoT builders, and environmental researchers are strongly welcomed.',
                        ],
                        (object)[
                            'id' => 'mock-2',
                            'question' => 'How many members can each team have?',
                            'answer' => 'Teams must consist of '.config('greenexe.team.min_members').' to '.config('greenexe.team.max_members').' members. The first registered student is automatically designated as the official team leader and primary contact.',
                        ],
                        (object)[
                            'id' => 'mock-3',
                            'question' => 'Does our project have to be completely built before registering?',
                            'answer' => 'No. Initial registration collects your concept proposal: the problem statement, proposed technical architecture, innovation highlights, and expected sustainability impact. Functional prototypes are presented during subsequent rounds.',
                        ],
                        (object)[
                            'id' => 'mock-4',
                            'question' => 'What happens after our team submits the registration?',
                            'answer' => 'You will receive a unique registration reference code on screen and in your confirmation. Organizers will communicate with team leaders using this reference for all subsequent evaluation rounds.',
                        ],
                        (object)[
                            'id' => 'mock-5',
                            'question' => 'What technologies or themes can our project focus on?',
                            'answer' => 'Projects should align with the Smart Green City theme, covering pillars such as smart buildings, smart energy, intelligent transportation, environmental monitoring, water/waste automation, or connected digital services.',
                        ],
                        (object)[
                            'id' => 'mock-6',
                            'question' => 'Is our team registration information publicly exposed?',
                            'answer' => 'No. Personal contact details and student identification are strictly protected and only accessible by authorized event administrators.',
                        ],
                    ]);
                @endphp

                <div class="mt-14 space-y-3" data-accordion>
                    @foreach ($displayFaqs as $faq)
                        @include('partials.faq-item', ['faq' => $faq])
                    @endforeach
                </div>
            </div>
        </section>

        {{-- =========================================================================
             7. Registration Call to Action
             ========================================================================= --}}
        <section class="border-t border-white/10 bg-dark-navy/90 py-20 md:py-24">
            <div class="gx-reveal mx-auto max-w-3xl px-6 text-center sm:px-10" data-reveal>
                <p class="text-xs font-medium uppercase tracking-[0.3em] text-eco-lime">Next Step</p>
                <h2 class="mt-3 leading-[0.95] text-white">
                    <span class="block font-playfair text-3xl font-normal italic sm:text-4xl md:text-5xl"
                          style="letter-spacing: -0.05em">Ready to submit</span>
                    <span class="-mt-1 block text-3xl font-normal sm:text-4xl md:text-5xl"
                          style="letter-spacing: -0.08em">your team's concept?</span>
                </h2>

                <p class="mx-auto mt-6 max-w-xl text-sm leading-relaxed text-white/80 sm:text-base">
                    Registration is open for teams of {{ config('greenexe.team.min_members') }}–{{ config('greenexe.team.max_members') }} undergraduates. Enter your team details and project proposal now.
                </p>

                <div class="mt-10">
                    <a href="{{ route('register') }}"
                       class="rounded-full bg-[#e8702a] px-9 py-4 text-sm font-medium text-white transition-all duration-300 hover:scale-[1.03] hover:bg-[#d2611f] hover:shadow-xl hover:shadow-[#e8702a]/30 active:scale-95">
                        Register Your Team Now
                    </a>
                </div>
            </div>
        </section>
    </div>
@endsection
