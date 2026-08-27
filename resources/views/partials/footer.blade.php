{{-- On the home page the footer is the last stop of the slide stack, so it
     follows the final panel directly instead of sitting after a margin. --}}
<footer class="snap-start border-t border-white/10 bg-deep-green/30 {{ request()->routeIs('home') ? '' : 'mt-24' }}">
    <div class="mx-auto grid max-w-7xl gap-10 px-4 py-14 md:grid-cols-3">
        <div>
            <h3 class="font-playfair text-2xl italic text-white">{{ config('greenexe.event.name') }}</h3>
            <p class="mt-3 text-sm text-light-gray/70">{{ config('greenexe.event.tagline') }}</p>
            <p class="mt-4 text-sm text-light-gray/70">
                Organised by {{ config('greenexe.event.organizer') }}
            </p>
        </div>

        <div>
            <h4 class="text-xs font-medium uppercase tracking-[0.3em] text-cyan-tech">Explore</h4>
            <ul class="mt-4 space-y-2 text-sm text-light-gray/70">
                <li><a class="hover:text-cyan-tech" href="{{ route('smart-city') }}">Smart Green City</a></li>
                <li><a class="hover:text-cyan-tech" href="{{ route('competition') }}">Competition</a></li>
                <li><a class="hover:text-cyan-tech" href="{{ route('rules') }}">Rules &amp; Eligibility</a></li>
                <li><a class="hover:text-cyan-tech" href="{{ route('faq') }}">FAQ</a></li>
                <li><a class="hover:text-cyan-tech" href="{{ route('register') }}">Register</a></li>
            </ul>
        </div>

        <div>
            <h4 class="text-xs font-medium uppercase tracking-[0.3em] text-cyan-tech">Contact</h4>
            <ul class="mt-4 space-y-2 text-sm text-light-gray/70">
                <li><a class="hover:text-cyan-tech" href="mailto:{{ config('greenexe.contact.email') }}">{{ config('greenexe.contact.email') }}</a></li>
                <li>{{ config('greenexe.contact.phone') }}</li>
                <li>{{ config('greenexe.contact.address') }}</li>
            </ul>
            <div class="mt-4 flex gap-4 text-sm text-light-gray/70">
                @foreach (config('greenexe.contact.socials') as $name => $url)
                    <a class="capitalize hover:text-cyan-tech" href="{{ $url }}">{{ $name }}</a>
                @endforeach
            </div>
        </div>
    </div>

    <div class="border-t border-white/10 px-4 py-5 text-center text-xs text-light-gray/50">
        &copy; {{ date('Y') }} {{ config('greenexe.event.organizer') }}. {{ config('greenexe.event.university') }}.
        <a href="{{ route('filament.admin.auth.login') }}" class="ml-2 hover:text-cyan-tech">Admin</a>
    </div>
</footer>
