{{--
    Shared shell for the HTTP error pages.

    Uses the same language as the rest of the site — campus photograph behind a
    scrim, cyan eyebrow, Playfair italic over Inter — so a wrong URL still looks
    like GreenExE rather than a framework default.

    @param string $code      HTTP status, shown as the ghost numeral.
    @param string $eyebrow
    @param string $titleItalic
    @param string $title
    @param string $lead
    @param list<array{label: string, url: string, primary?: bool}> $actions
--}}
@php
    $actions ??= [];
@endphp

<section class="gx-section relative isolate flex min-h-[80vh] w-full items-center overflow-hidden">
    <div class="absolute inset-0 bg-cover bg-center bg-no-repeat"
         data-background-image="{{ asset('assets/img/bg3.png') }}" aria-hidden="true"></div>

    <div class="absolute inset-0 bg-dark-navy/85" aria-hidden="true"></div>
    <div class="absolute inset-0 bg-linear-to-b from-dark-navy/70 via-transparent to-dark-navy" aria-hidden="true"></div>

    {{-- The status code sits behind the copy as a watermark rather than as a
         heading, so screen readers get the sentence and not a bare number. --}}
    <span class="gx-error-code" aria-hidden="true">{{ $code }}</span>

    <div class="relative mx-auto w-full max-w-3xl px-6 py-24 text-center sm:px-10">
        <p class="text-xs font-medium uppercase tracking-[0.3em] text-cyan-tech">{{ $eyebrow }}</p>

        <h1 class="mt-5 leading-[0.95] text-white">
            <span class="block font-playfair text-4xl font-normal italic sm:text-5xl md:text-6xl"
                  style="letter-spacing: -0.05em">{{ $titleItalic }}</span>
            <span class="-mt-1 block text-4xl font-normal sm:text-5xl md:text-6xl"
                  style="letter-spacing: -0.08em">{{ $title }}</span>
        </h1>

        <p class="mx-auto mt-6 max-w-lg text-sm leading-relaxed text-white/75 md:text-base">{{ $lead }}</p>

        @if ($actions)
            <div class="mt-10 flex flex-wrap items-center justify-center gap-4">
                @foreach ($actions as $action)
                    <a href="{{ $action['url'] }}"
                       @class([
                           'gx-btn-primary' => $action['primary'] ?? false,
                           'group inline-flex items-center gap-2 rounded-full border border-white/25 px-6 py-2.5 text-sm font-medium text-white transition-colors hover:border-cyan-tech hover:text-cyan-tech' => ! ($action['primary'] ?? false),
                       ])>
                        {{ $action['label'] }}
                        @unless ($action['primary'] ?? false)
                            <span class="transition-transform group-hover:translate-x-1">&rarr;</span>
                        @endunless
                    </a>
                @endforeach
            </div>
        @endif
    </div>
</section>
