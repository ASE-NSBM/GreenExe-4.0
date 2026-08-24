{{-- Expandable / collapsible FAQ answer (FR-54) --}}
<div class="gx-card p-0">
    <button type="button"
            class="flex w-full items-center justify-between gap-4 px-6 py-4 text-left"
            data-accordion-trigger
            aria-expanded="false"
            aria-controls="faq-answer-{{ $faq->id }}">
        <span class="font-medium text-white">{{ $faq->question }}</span>
        <svg class="h-5 w-5 shrink-0 text-cyan-tech transition-transform duration-200" data-accordion-icon
             fill="none" stroke="currentColor" stroke-width="2" viewBox="0 0 24 24">
            <path stroke-linecap="round" d="M19 9l-7 7-7-7"></path>
        </svg>
    </button>
    <div id="faq-answer-{{ $faq->id }}" class="hidden px-6 pb-5 text-sm leading-relaxed text-light-gray/75" data-accordion-panel>
        {!! nl2br(e($faq->answer)) !!}
    </div>
</div>
