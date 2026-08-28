{{-- On the home page the footer is the last stop of the slide stack, so it
     follows the final panel directly instead of sitting after a margin. --}}
<footer class="site-footer snap-start border-t border-white/10 {{ request()->routeIs('home') ? '' : 'mt-24' }}">
    <div class="mx-auto grid max-w-7xl gap-10 px-4 py-14 md:grid-cols-3">
        <div>
            <img src="{{ asset('assets/img/logo-bgremoved.png') }}" alt="{{ config('greenexe.event.name') }}" class="h-8 w-44 object-contain object-left">
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
            <div class="mt-4" aria-label="Social media links">
                @include('partials.social-links', ['socials' => config('greenexe.contact.socials')])
            </div>
        </div>
    </div>

    <div class="border-t border-white/10 px-4 py-5 text-center text-xs text-light-gray/50">
        &copy; 2026 {{ config('greenexe.event.name') }}. Innovate &bull; Build &bull; Sustain. Powered by ASE, NSBM Green University.
    </div>
</footer>
