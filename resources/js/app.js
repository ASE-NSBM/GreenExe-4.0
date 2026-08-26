/**
 * GreenExE 4.0 — front-end behaviour.
 *
 * Kept dependency-free so the public pages stay fast (SRS 8.1).
 */

/* Mobile navigation ------------------------------------------------------ */
function initMobileNav() {
    const toggle = document.querySelector('[data-mobile-toggle]');
    const menu = document.querySelector('[data-mobile-menu]');

    if (!toggle || !menu) return;

    toggle.addEventListener('click', () => {
        const open = menu.classList.toggle('hidden') === false;
        toggle.setAttribute('aria-expanded', String(open));
    });
}

/* FAQ accordion (FR-54) -------------------------------------------------- */
function initAccordions() {
    document.querySelectorAll('[data-accordion-trigger]').forEach((trigger) => {
        trigger.addEventListener('click', () => {
            const panel = document.getElementById(trigger.getAttribute('aria-controls'));
            const icon = trigger.querySelector('[data-accordion-icon]');
            if (!panel) return;

            const open = panel.classList.toggle('hidden') === false;
            trigger.setAttribute('aria-expanded', String(open));
            if (icon) icon.classList.toggle('rotate-180', open);
        });
    });
}

/* Dynamic team-member sections (FR-25) ----------------------------------- */
function initMemberSections() {
    const select = document.querySelector('[data-member-count]');
    const cards = Array.from(document.querySelectorAll('[data-member-card]'));

    if (!select || cards.length === 0) return;

    const sync = () => {
        const count = parseInt(select.value, 10);

        cards.forEach((card, index) => {
            const visible = index < count;
            card.classList.toggle('hidden', !visible);

            // Hidden members must not reach the server (SRS 12.1).
            card.querySelectorAll('input, select, textarea').forEach((field) => {
                field.disabled = !visible;
                if (visible && field.dataset.required !== 'false') {
                    field.setAttribute('aria-required', 'true');
                }
            });
        });
    };

    select.addEventListener('change', sync);
    sync();
}

/* Cursor spotlight hero reveal ------------------------------------------- */
const SPOTLIGHT_R = 260;

function initHeroSpotlight() {
    const hero = document.querySelector('[data-hero]');
    if (!hero) return;

    const reveal = hero.querySelector('[data-hero-reveal]');
    const canvas = hero.querySelector('[data-hero-canvas]');
    const ctx = canvas?.getContext('2d');

    if (!reveal || !ctx) return;

    // The spotlight gradient never changes shape, only position, so it is
    // rasterised once into a 2R square and then moved with mask-position.
    // Re-encoding a viewport-sized canvas with toDataURL() on every frame
    // costs tens of milliseconds and would stall the animation loop.
    const size = SPOTLIGHT_R * 2;
    canvas.width = size;
    canvas.height = size;

    const gradient = ctx.createRadialGradient(
        SPOTLIGHT_R, SPOTLIGHT_R, 0,
        SPOTLIGHT_R, SPOTLIGHT_R, SPOTLIGHT_R,
    );
    gradient.addColorStop(0, 'rgba(255,255,255,1)');
    gradient.addColorStop(0.4, 'rgba(255,255,255,1)');
    gradient.addColorStop(0.6, 'rgba(255,255,255,0.75)');
    gradient.addColorStop(0.75, 'rgba(255,255,255,0.4)');
    gradient.addColorStop(0.88, 'rgba(255,255,255,0.12)');
    gradient.addColorStop(1, 'rgba(255,255,255,0)');

    ctx.clearRect(0, 0, size, size);
    ctx.fillStyle = gradient;
    ctx.beginPath();
    ctx.arc(SPOTLIGHT_R, SPOTLIGHT_R, SPOTLIGHT_R, 0, Math.PI * 2);
    ctx.fill();

    const mask = `url(${canvas.toDataURL()})`;
    const style = reveal.style;

    style.maskImage = mask;
    style.webkitMaskImage = mask;
    style.maskRepeat = 'no-repeat';
    style.webkitMaskRepeat = 'no-repeat';
    style.maskSize = `${size}px ${size}px`;
    style.webkitMaskSize = `${size}px ${size}px`;

    const mouse = { x: -999, y: -999 };
    const smooth = { x: -999, y: -999 };
    let rafId = null;

    const paint = () => {
        const position = `${smooth.x - SPOTLIGHT_R}px ${smooth.y - SPOTLIGHT_R}px`;
        style.maskPosition = position;
        style.webkitMaskPosition = position;
    };

    paint();
    reveal.classList.remove('opacity-0');

    const reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

    const loop = () => {
        smooth.x += (mouse.x - smooth.x) * 0.1;
        smooth.y += (mouse.y - smooth.y) * 0.1;
        paint();
        rafId = requestAnimationFrame(loop);
    };

    const start = () => {
        if (rafId === null) rafId = requestAnimationFrame(loop);
    };

    const stop = () => {
        if (rafId !== null) {
            cancelAnimationFrame(rafId);
            rafId = null;
        }
    };

    const onMove = (event) => {
        // Pointer coordinates are viewport-relative; the mask lives inside the
        // section, so translate them once the page has scrolled.
        const bounds = hero.getBoundingClientRect();
        mouse.x = event.clientX - bounds.left;
        mouse.y = event.clientY - bounds.top;

        if (reduceMotion) {
            smooth.x = mouse.x;
            smooth.y = mouse.y;
            paint();
        }
    };

    window.addEventListener('mousemove', onMove, { passive: true });

    if (!reduceMotion) {
        // The hero is pinned by the slide stack, so it never stops intersecting
        // the viewport — the panel above it simply covers it. Gate the loop on
        // scroll depth instead, or it keeps easing behind the other panels.
        const sync = () => (window.scrollY < hero.offsetHeight ? start() : stop());

        window.addEventListener('scroll', sync, { passive: true });
        sync();
    }
}

/* Scroll reveal ---------------------------------------------------------- */
function initScrollReveal() {
    const targets = document.querySelectorAll('[data-reveal]');
    if (targets.length === 0) return;

    if (!('IntersectionObserver' in window)) {
        targets.forEach((target) => target.classList.add('is-visible'));
        return;
    }

    const observer = new IntersectionObserver(
        (entries) => {
            entries.forEach((entry) => {
                if (!entry.isIntersecting) return;

                entry.target.classList.add('is-visible');
                observer.unobserve(entry.target);
            });
        },
        { threshold: 0.15 },
    );

    targets.forEach((target) => observer.observe(target));
}

/* Highlight carousel ----------------------------------------------------- */
function initHighlightCarousel() {
    const track = document.querySelector('[data-carousel-track]');
    if (!track) return;

    const slides = Array.from(track.querySelectorAll('[data-carousel-slide]'));
    const previous = document.querySelector('[data-carousel-prev]');
    const next = document.querySelector('[data-carousel-next]');
    const current = document.querySelector('[data-carousel-current]');

    if (slides.length === 0) return;

    const step = () => {
        const gap = parseFloat(getComputedStyle(track).columnGap) || 0;

        return slides[0].offsetWidth + gap;
    };

    const activeIndex = () => Math.round(track.scrollLeft / step());

    const sync = () => {
        const index = Math.min(Math.max(activeIndex(), 0), slides.length - 1);

        if (current) current.textContent = String(index + 1).padStart(2, '0');

        // scrollLeft is fractional, so allow a pixel of slack at both ends.
        if (previous) previous.disabled = track.scrollLeft <= 1;
        if (next) next.disabled = track.scrollLeft >= track.scrollWidth - track.clientWidth - 1;
    };

    const scrollBy = (direction) => track.scrollBy({ left: direction * step(), behavior: 'smooth' });

    previous?.addEventListener('click', () => scrollBy(-1));
    next?.addEventListener('click', () => scrollBy(1));

    track.addEventListener('scroll', sync, { passive: true });
    window.addEventListener('resize', sync, { passive: true });

    track.addEventListener('keydown', (event) => {
        if (event.key !== 'ArrowLeft' && event.key !== 'ArrowRight') return;

        event.preventDefault();
        scrollBy(event.key === 'ArrowRight' ? 1 : -1);
    });

    sync();
}

/* Submit-once guard ------------------------------------------------------ */
function initSubmitGuard() {
    const form = document.querySelector('[data-registration-form]');
    if (!form) return;

    form.addEventListener('submit', () => {
        const button = form.querySelector('[data-submit-button]');
        const label = form.querySelector('[data-submit-label]');
        if (!button) return;

        button.disabled = true;
        button.classList.add('opacity-60', 'cursor-not-allowed');
        if (label) label.textContent = 'Submitting…';
    });
}

document.addEventListener('DOMContentLoaded', () => {
    initMobileNav();
    initAccordions();
    initMemberSections();
    initSubmitGuard();
    initHeroSpotlight();
    initScrollReveal();
    initHighlightCarousel();
});
