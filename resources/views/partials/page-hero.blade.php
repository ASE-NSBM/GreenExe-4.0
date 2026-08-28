{{--
    Full-bleed page hero: photograph, scrim, then the shared page header.

    Gives the inner pages the same weight as the home panels, which carry
    imagery. The scrim is deliberately heavy — these are bright daylight
    photographs under white type, and the copy has to stay readable.

    @param string $image        Path under public/, e.g. 'assets/img/bg1.jpeg'.
    @param string $eyebrow
    @param string $titleItalic
    @param string $title
    @param string|null $lead
    @param bool $center
--}}
@php
    $center ??= false;
    $lead ??= null;
@endphp

<section class="gx-section relative isolate overflow-hidden">
    <div class="absolute inset-0 bg-cover bg-center bg-no-repeat"
         style="background-image: url('{{ asset($image) }}')" aria-hidden="true"></div>

    {{-- Flat base keeps contrast even, the gradient blends the band into the
         page below so it does not end on a hard edge. --}}
    <div class="absolute inset-0 bg-dark-navy/80" aria-hidden="true"></div>
    <div class="absolute inset-0 bg-gradient-to-b from-dark-navy/60 via-transparent to-dark-navy" aria-hidden="true"></div>

    <div class="relative mx-auto w-full max-w-5xl px-6 pt-20 pb-16 sm:px-10 md:px-14 md:pt-28 md:pb-20">
        @include('partials.page-header', [
            'eyebrow' => $eyebrow,
            'titleItalic' => $titleItalic,
            'title' => $title,
            'lead' => $lead,
            'center' => $center,
        ])
    </div>
</section>
