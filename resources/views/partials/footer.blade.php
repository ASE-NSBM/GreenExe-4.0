{{-- On the home page the footer is the last stop of the slide stack, so it
     follows the final panel directly instead of sitting after a margin. --}}
<footer class="site-footer snap-start border-t border-white/10 {{ request()->routeIs('home') ? '' : 'mt-24' }}">
    <div class="mx-auto grid max-w-7xl gap-10 px-4 py-14 md:grid-cols-3">
        <div>
            <img src="{{ asset('assets/img/logo-bgremoved.png') }}" alt="{{ config('greenexe.event.name') }}" class="h-8 w-44 object-contain object-center">
            <p class="mt-3 text-sm text-light-gray/70">{{ config('greenexe.event.tagline') }}</p>
            <p class="mt-4 text-sm text-light-gray/70">
                Organised by {{ config('greenexe.event.organizer') }}
            </p>
        </div>

        <div>
            <h4 class="font-display text-sm font-semibold uppercase tracking-wider text-cyan-tech">Explore</h4>
            <ul class="mt-4 space-y-2 text-sm text-light-gray/70">
                <li><a class="hover:text-cyan-tech" href="{{ route('smart-city') }}">Smart Green City</a></li>
                <li><a class="hover:text-cyan-tech" href="{{ route('competition') }}">Competition</a></li>
                <li><a class="hover:text-cyan-tech" href="{{ route('rules') }}">Rules &amp; Eligibility</a></li>
                <li><a class="hover:text-cyan-tech" href="{{ route('faq') }}">FAQ</a></li>
                <li><a class="hover:text-cyan-tech" href="{{ route('register') }}">Register</a></li>
            </ul>
        </div>

        <div>
            <h4 class="font-display text-sm font-semibold uppercase tracking-wider text-cyan-tech">Contact</h4>
            <ul class="mt-4 space-y-2 text-sm text-light-gray/70">
                <li><a class="hover:text-cyan-tech" href="mailto:{{ config('greenexe.contact.email') }}">{{ config('greenexe.contact.email') }}</a></li>
                <li>{{ config('greenexe.contact.phone') }}</li>
                <li>{{ config('greenexe.contact.address') }}</li>
            </ul>
            <div class="mt-4 flex gap-3 text-light-gray/70" aria-label="Social media links">
                @foreach (config('greenexe.contact.socials') as $name => $url)
                    <a class="grid h-9 w-9 place-items-center rounded-full border border-white/15 bg-white/5 transition hover:border-fresh-green/60 hover:bg-fresh-green/15 hover:text-fresh-green"
                       href="{{ $url }}" target="_blank" rel="noopener noreferrer" aria-label="{{ ucfirst($name) }}">
                        @if ($name === 'facebook')
                            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                <path d="M14 8h3V4h-3c-3.31 0-5 1.69-5 5v3H6v4h3v8h4v-8h3l1-4h-4V9c0-.67.33-1 1-1Z"/>
                            </svg>
                        @elseif ($name === 'instagram')
                            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="1.8" aria-hidden="true">
                                <rect x="3" y="3" width="18" height="18" rx="5"/>
                                <circle cx="12" cy="12" r="4"/>
                                <circle cx="17.5" cy="6.5" r="1" fill="currentColor" stroke="none"/>
                            </svg>
                        @elseif ($name === 'linkedin')
                            <svg class="h-4 w-4" viewBox="0 0 24 24" fill="currentColor" aria-hidden="true">
                                <path d="M5 3.5A2.5 2.5 0 1 1 5 8.5 2.5 2.5 0 0 1 5 3.5ZM3 10h4v11H3V10Zm6 0h3.8v1.5h.05c.53-1 1.83-2 3.75-2 4 0 4.4 2.63 4.4 6.05V21h-4v-4.83c0-1.15-.02-2.63-1.6-2.63-1.6 0-1.85 1.25-1.85 2.55V21H9V10Z"/>
                            </svg>
                        @endif
                    </a>
                @endforeach
            </div>
        </div>
    </div>

    <div class="border-t border-white/10 px-4 py-5 text-center text-xs text-light-gray/50">
        &copy; 2026 {{ config('greenexe.event.name') }}. Innovate &bull; Build &bull; Sustain. Powered by ASE, NSBM Green University.
    </div>
</footer>
