{{-- Expandable / collapsible FAQ answer (FR-54) --}}
<div class="group overflow-hidden rounded-2xl border border-white/10 bg-white/5 backdrop-blur-md transition-all duration-300 hover:border-cyan-tech/30 hover:bg-white/[0.07]">
    <button type="button"
            class="flex w-full items-center justify-between gap-4 px-6 py-5 text-left transition-colors"
            data-accordion-trigger
            aria-expanded="false"
            aria-controls="faq-answer-{{ $faq->id }}">
        <span class="text-base font-medium text-white transition-colors group-hover:text-cyan-tech sm:text-lg">{{ $faq->question }}</span>
        <span class="flex h-8 w-8 shrink-0 items-center justify-center rounded-full border border-white/10 bg-white/5 transition-all duration-300 group-hover:border-cyan-tech/40 group-hover:bg-cyan-tech/10">
            <svg class="h-4 w-4 text-cyan-tech transition-transform duration-300" data-accordion-icon
                 fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
                <path stroke-linecap="round" stroke-linejoin="round" d="M19 9l-7 7-7-7"></path>
            </svg>
        </span>
    </button>
    <div id="faq-answer-{{ $faq->id }}" class="hidden px-6 pb-6 text-sm leading-relaxed text-white/75 sm:text-base" data-accordion-panel>
        <div class="border-t border-white/10 pt-4">
            {!! nl2br(e($faq->answer)) !!}
        </div>
    </div>
</div>

