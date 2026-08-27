{{--
    Page header in the home-page style: cyan eyebrow, then a two-line headline
    whose first line is Playfair italic and second line is Inter, both on the
    tight tracking the hero uses.

    @param string $eyebrow
    @param string $titleItalic  First line, set in Playfair italic.
    @param string $title        Second line, set in Inter.
    @param string|null $lead    Optional supporting sentence.
    @param bool $center         Centre the block instead of aligning left.
--}}
@php
    $center ??= false;
    $lead ??= null;
@endphp

<div class="gx-reveal {{ $center ? 'text-center' : '' }}" data-reveal>
    <p class="text-xs font-medium uppercase tracking-[0.3em] text-cyan-tech">{{ $eyebrow }}</p>

    <h1 class="mt-4 leading-[0.95] text-white">
        <span class="block font-playfair text-4xl font-normal italic sm:text-5xl md:text-6xl"
              style="letter-spacing: -0.05em">{{ $titleItalic }}</span>
        <span class="-mt-1 block text-4xl font-normal sm:text-5xl md:text-6xl"
              style="letter-spacing: -0.08em">{{ $title }}</span>
    </h1>

    @if ($lead)
        <p class="mt-6 max-w-xl text-sm leading-relaxed text-white/75 md:text-base {{ $center ? 'mx-auto' : '' }}">
            {{ $lead }}
        </p>
    @endif
</div>
