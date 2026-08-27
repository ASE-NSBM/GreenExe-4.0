@extends('layouts.app')

@section('title', 'About '.config('greenexe.event.name').' — '.config('greenexe.event.concept'))

@section('content')
    <div class="relative w-full tracking-[-0.02em]">
        {{-- =========================================================================
             1. FR-8: GreenExE 4.0 Introduction & Full-Height Animated Hero
             ========================================================================= --}}
        <section class="relative flex min-h-[100dvh] w-full items-center overflow-hidden bg-dark-navy pt-28 pb-16 md:pt-32 md:pb-20">
            {{-- Right-Side Kinetic Geometric Modular Wave Pattern (Pure SVG & CSS Code) --}}
            <div class="pointer-events-none absolute right-0 top-0 bottom-0 w-full md:w-3/5 overflow-hidden flex justify-end gap-3 sm:gap-4 md:gap-6 pr-0 sm:pr-4 md:pr-10 opacity-30 md:opacity-90" aria-hidden="true">
                @for ($col = 1; $col <= 4; $col++)
                    <div class="gx-wave-col-{{ $col }} flex flex-col gap-3 sm:gap-4 md:gap-5 shrink-0 -mt-28">
                        @for ($row = 0; $row < 8; $row++)
                            <svg class="h-28 w-28 sm:h-36 sm:w-36 md:h-44 md:w-44 drop-shadow-[0_10px_30px_rgba(196,249,52,0.15)]"
                                 viewBox="0 0 140 140" fill="none" xmlns="http://www.w3.org/2000/svg">
                                <path d="M 0,38 C 0,16 16,0 38,0 L 70,0 C 88,0 98,12 110,30 C 124,52 134,84 140,110 L 140,140 L 102,140 C 84,140 74,128 62,110 C 48,88 38,56 30,38 C 24,20 12,20 0,38 Z"
                                      fill="#c4f934" />
                            </svg>
                        @endfor
                    </div>
                @endfor
                {{-- Scrim gradients to guarantee absolute text contrast and soft blending --}}
                <div class="absolute inset-0 bg-gradient-to-r from-dark-navy via-dark-navy/60 to-transparent" aria-hidden="true"></div>
                <div class="absolute inset-0 bg-gradient-to-t from-dark-navy via-transparent to-dark-navy/70" aria-hidden="true"></div>
            </div>

            <div class="relative z-10 mx-auto w-full max-w-6xl px-6 sm:px-10 my-auto">
                <div class="max-w-2xl">
                    <div class="hero-anim hero-fade inline-flex items-center rounded-full border border-cyan-tech/30 bg-cyan-tech/10 px-4 py-1.5 backdrop-blur-md"
                         style="animation-delay: 0.1s">
                        <p class="text-xs font-medium uppercase tracking-[0.3em] text-cyan-tech">
                            {{ config('greenexe.event.name') }} &bull; Competition Brief
                        </p>
                    </div>

                    <h1 class="mt-6 leading-[0.92] text-white">
                        <span class="hero-anim hero-reveal block font-playfair text-5xl font-normal italic sm:text-7xl md:text-8xl"
                              style="letter-spacing: -0.05em; animation-delay: 0.25s">About</span>
                        <span class="hero-anim hero-reveal -mt-1 block text-5xl font-normal sm:text-7xl md:text-8xl"
                              style="letter-spacing: -0.08em; animation-delay: 0.42s">{{ config('greenexe.event.name') }}</span>
                    </h1>

                    <p class="hero-anim hero-fade mt-6 text-base leading-relaxed text-white/80 sm:text-lg md:text-xl"
                       style="animation-delay: 0.6s">
                        {{ config('greenexe.event.tagline') }} Organized by the {{ config('greenexe.event.organizer') }}
                        under the {{ config('greenexe.event.brand') }} brand at {{ config('greenexe.event.university') }}.
                    </p>

                    <div class="hero-anim hero-fade mt-8 flex flex-wrap items-center gap-4"
                         style="animation-delay: 0.75s">
                        <a href="{{ route('register') }}"
                           class="rounded-full bg-[#e8702a] px-8 py-3.5 text-sm font-medium text-white transition-all duration-300 hover:scale-[1.03] hover:bg-[#d2611f] hover:shadow-xl hover:shadow-[#e8702a]/30 active:scale-95">
                            Register Your Team
                        </a>
                        <a href="#purpose"
                           class="group inline-flex items-center gap-2 rounded-full border border-white/20 bg-white/5 px-6 py-3.5 text-sm font-medium text-white backdrop-blur-md transition-all duration-300 hover:border-cyan-tech hover:text-cyan-tech">
                            <span>Explore Details</span>
                            <span class="transition-transform duration-300 group-hover:translate-y-0.5">&darr;</span>
                        </a>
                    </div>
                </div>
            </div>
        </section>

        {{-- =========================================================================
             2. FR-9: Competition Purpose and Objectives (Normal Flow)
             ========================================================================= --}}
        <section id="purpose" class="relative border-t border-white/10 bg-dark-navy/95 py-20 md:py-28">
            <div class="mx-auto w-full max-w-6xl px-6 sm:px-10">
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
                                <article class="gx-reveal group relative {{ $index === 0 ? 'py-8 pt-0' : 'border-t border-white/15 py-8' }}"
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
             3. FR-10: Explain the Smart Green City Concept & 9 Pillars (Sticky Runway)
             ========================================================================= --}}
        <div class="relative h-[155vh]">
            <section id="smart-green-city" class="sticky top-0 z-10 flex h-screen min-h-[100dvh] w-full flex-col justify-center overflow-hidden border-t border-white/10 bg-dark-navy py-16 md:py-24 tracking-[-0.02em]">
                <div class="absolute inset-0 bg-cover bg-center bg-no-repeat opacity-75 md:opacity-85 scale-105 transition-transform duration-1000"
                     style="background-image: url('{{ asset('assets/img/highlights/smartcity-about.jpg') }}')"
                     aria-hidden="true"></div>

                {{-- Vignette gradients balanced to highlight the photograph while preserving text contrast --}}
                <div class="absolute inset-0 bg-gradient-to-r from-dark-navy/95 via-dark-navy/75 to-dark-navy/45" aria-hidden="true"></div>
                <div class="absolute inset-0 bg-gradient-to-t from-dark-navy via-dark-navy/30 to-dark-navy/70" aria-hidden="true"></div>

                <div class="relative z-10 flex w-full flex-1 flex-col justify-center">
                    <div class="gx-reveal mx-auto w-full max-w-6xl px-6 sm:px-10" data-reveal>
                        <div class="max-w-2xl">
                            <p class="text-xs font-medium uppercase tracking-[0.3em] text-cyan-tech">The Guiding Concept</p>
                            <h2 class="mt-3 leading-[0.95] text-white">
                                <span class="block font-playfair text-4xl font-normal italic sm:text-5xl md:text-6xl"
                                      style="letter-spacing: -0.05em">Smart Green City</span>
                                <span class="-mt-1 block text-4xl font-normal sm:text-5xl md:text-6xl"
                                      style="letter-spacing: -0.08em">Concept &amp; Pillars</span>
                            </h2>
                            <p class="mt-4 text-sm leading-relaxed text-white/75 sm:text-base">
                                Inspired by the <strong class="text-white">{{ config('greenexe.event.university') }}</strong> campus, GreenExE 4.0 explores how digital infrastructure, IoT automation, clean energy, and environmental sensing transform a green campus into an intelligent city.
                            </p>

                            {{-- Horizontal Track Controls placed directly after the description --}}
                            <div class="mt-6 flex items-center gap-3" data-carousel-controls>
                                <button type="button"
                                        class="grid h-10 w-10 place-items-center rounded-full border border-white/20 text-white transition hover:border-cyan-tech hover:text-cyan-tech disabled:opacity-30 disabled:hover:border-white/20 disabled:hover:text-white"
                                        data-carousel-prev aria-label="Previous pillar">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M15 19l-7-7 7-7"></path>
                                    </svg>
                                </button>
                                <button type="button"
                                        class="grid h-10 w-10 place-items-center rounded-full border border-white/20 text-white transition hover:border-cyan-tech hover:text-cyan-tech disabled:opacity-30 disabled:hover:border-white/20 disabled:hover:text-white"
                                        data-carousel-next aria-label="Next pillar">
                                    <svg class="h-4 w-4" fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" d="M9 5l7 7-7 7"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>

                    {{-- The 9 Smart City Pillars Horizontal Swipe Track --}}
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

                    <div class="mx-auto w-full max-w-6xl px-6 sm:px-10">
                        <div class="gx-track mt-8 flex gap-4 overflow-x-auto pb-4 md:mt-10 md:gap-6"
                             tabindex="0" role="group" aria-label="Smart Green City Pillars" data-carousel-track>
                            @foreach ($smartCityPillars as $index => $pillar)
                                @php
                                    $lines = preg_split('/\R+/', trim($pillar->description));
                                    $lead = array_shift($lines);
                                    $tint = $tints[$index % count($tints)];
                                @endphp

                                <article class="gx-slide group relative flex shrink-0 flex-col justify-end overflow-hidden rounded-3xl border border-white/10 bg-white/5"
                                         data-carousel-slide>
                                    @if (!empty($pillar->image))
                                        <div class="absolute inset-0 bg-cover bg-center transition-transform duration-700 group-hover:scale-105"
                                             style="background-image: url('{{ $pillar->image }}')" aria-hidden="true"></div>
                                        <div class="absolute inset-0 bg-gradient-to-t from-dark-navy via-dark-navy/85 to-dark-navy/35 transition-opacity duration-500 group-hover:opacity-90" aria-hidden="true"></div>
                                    @else
                                        <div class="absolute inset-0 bg-gradient-to-br {{ $tint }}" aria-hidden="true"></div>
                                        <div class="gx-grid-bg absolute inset-0 opacity-30" aria-hidden="true"></div>
                                        <span class="gx-watermark" aria-hidden="true">{{ $pillar->icon ?? '🌿' }}</span>
                                        <div class="absolute inset-0 bg-gradient-to-t from-dark-navy via-dark-navy/40 to-transparent" aria-hidden="true"></div>
                                    @endif

                                    <span class="gx-rank" aria-hidden="true">{{ $index + 1 }}</span>

                                    <div class="relative flex h-full flex-col p-6 md:p-8">
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
                            @endforeach
                        </div>
                    </div>
                </div>
            </section>
        </div>

        {{-- =========================================================================
             4, 5, 6, 7: The Flowing Closing Stack (Rules, Benefits, FAQs, CTA)
             ========================================================================= --}}
        <section class="relative z-20 flex w-full flex-col bg-dark-navy tracking-[-0.02em]">

            {{-- 4. FR-11 & FR-12: Participant Eligibility, Rules & Requirements --}}
            <div id="rules-eligibility" class="border-t border-white/10 bg-dark-navy/60 py-20 md:py-28">
                <div class="mx-auto w-full max-w-6xl px-6 sm:px-10">
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
                        <div class="gx-reveal group relative border-t border-white/15 pt-8" data-reveal>
                            <span class="absolute left-0 top-0 h-px w-0 bg-gradient-to-r from-eco-lime to-transparent transition-all duration-700 group-hover:w-full" aria-hidden="true"></span>
                            <div class="flex items-baseline gap-4">
                                <span class="font-playfair text-sm italic text-eco-lime">01</span>
                                <span class="text-[11px] font-medium uppercase tracking-[0.3em] text-white/45">Eligibility Criteria</span>
                            </div>
                            <h3 class="mt-2 text-2xl font-medium text-white transition-colors duration-300 group-hover:text-eco-lime" style="letter-spacing: -0.04em">
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
                        <div class="gx-reveal group relative border-t border-white/15 pt-8" data-reveal style="transition-delay: 0.15s">
                            <span class="absolute left-0 top-0 h-px w-0 bg-gradient-to-r from-cyan-tech to-transparent transition-all duration-700 group-hover:w-full" aria-hidden="true"></span>
                            <div class="flex items-baseline gap-4">
                                <span class="font-playfair text-sm italic text-cyan-tech">02</span>
                                <span class="text-[11px] font-medium uppercase tracking-[0.3em] text-white/45">Competition Rules</span>
                            </div>
                            <h3 class="mt-2 text-2xl font-medium text-white transition-colors duration-300 group-hover:text-cyan-tech" style="letter-spacing: -0.04em">
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
            </div>

            {{-- 5. FR-13: Participant Benefits --}}
            <div id="benefits" class="border-t border-white/10 py-20 md:py-28">
                <div class="mx-auto w-full max-w-6xl px-6 sm:px-10">
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
            </div>

            {{-- 6. FR-14: Frequently Asked Questions (FAQ) --}}
            <div id="faqs" class="border-t border-white/10 bg-dark-navy/60 py-20 md:py-28">
                <div class="mx-auto w-full max-w-6xl px-6 sm:px-10">
                    <div class="gx-reveal max-w-3xl text-left" data-reveal>
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
            </div>

            {{-- 7. Registration Call to Action --}}
            <div class="border-t border-white/10 bg-dark-navy/90 py-20 md:py-24">
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
            </div>
        </section>
    </div>
@endsection

