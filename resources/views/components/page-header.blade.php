@props(['eyebrow', 'title', 'description'])

<section class="mx-auto max-w-5xl px-4 py-20 text-center">
    <div class="mx-auto max-w-3xl">
        <p class="text-xs font-medium uppercase tracking-[0.3em] text-cyan-tech">{{ $eyebrow }}</p>
        <h1 class="mt-4 font-display text-4xl font-bold text-white sm:text-5xl md:text-6xl">{{ $title }}</h1>
        <p class="mx-auto mt-5 max-w-xl text-lg text-light-gray/70">{{ $description }}</p>
    </div>
</section>
