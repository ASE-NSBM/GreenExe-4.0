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

    const nav = document.querySelector('[data-member-nav]');
    const previous = document.querySelector('[data-member-prev]');
    const next = document.querySelector('[data-member-next]');
    const message = document.querySelector('[data-member-message]');
    const currentLabel = document.querySelector('[data-member-current]');
    const totalLabel = document.querySelector('[data-member-total]');
    const progressBar = document.querySelector('[data-member-progress-bar]');

    const fieldsOf = (card) => Array.from(card.querySelectorAll('input, select, textarea'));

    // Members are entered one at a time, so the visitor is never faced with
    // every card at once. Without JS the stepper stays hidden and all the cards
    // remain visible, which still submits correctly.
    let index = 0;

    const teamSize = () => parseInt(select.value, 10) || cards.length;

    const render = () => {
        const count = teamSize();
        index = Math.min(index, count - 1);

        cards.forEach((card, cardIndex) => {
            const inTeam = cardIndex < count;

            // Only cards outside the team are disabled. Cards that belong to the
            // team but are not on screen stay enabled, or their data would be
            // dropped from the submission (SRS 12.1).
            fieldsOf(card).forEach((field) => {
                field.disabled = !inTeam;
                if (inTeam) field.setAttribute('aria-required', 'true');
            });

            card.classList.toggle('hidden', !inTeam || cardIndex !== index);
        });

        if (currentLabel) currentLabel.textContent = String(index + 1);
        if (totalLabel) totalLabel.textContent = String(count);
        if (progressBar) progressBar.style.width = `${((index + 1) / count) * 100}%`;

        const onLastMember = index >= count - 1;

        if (previous) previous.disabled = index === 0;
        if (next) {
            next.disabled = onLastMember;
            next.querySelector('[data-member-next-label]').textContent = onLastMember
                ? 'All members added'
                : 'Next member';
            next.querySelector('[data-member-next-arrow]').classList.toggle('hidden', onLastMember);
        }

        if (message) message.textContent = '';
    };

    /** Nudge the visitor to finish a member before moving on. Server-side rules stay authoritative. */
    const isComplete = (card) => {
        const empty = fieldsOf(card).filter((field) => !field.disabled && field.value.trim() === '');

        if (empty.length === 0) return true;

        empty[0].focus();
        if (message) message.textContent = 'Fill in every field for this member before continuing.';

        return false;
    };

    const go = (delta) => {
        if (delta > 0 && !isComplete(cards[index])) return;

        index = Math.min(Math.max(index + delta, 0), teamSize() - 1);
        render();
        cards[index].scrollIntoView({ behavior: 'smooth', block: 'nearest' });
    };

    previous?.addEventListener('click', () => go(-1));
    next?.addEventListener('click', () => go(1));

    select.addEventListener('change', render);

    // A rejected submission comes back with the offending member marked, so open
    // that card rather than starting again from the leader.
    const firstInvalid = cards.findIndex((card) => card.hasAttribute('data-member-error'));
    if (firstInvalid > -1) index = firstInvalid;

    nav?.classList.replace('hidden', 'flex');
    render();
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

/**
 * Keeps the row moving while the pointer rests over its leading or trailing
 * edge, the way a Netflix row behaves. Speed ramps with how deep into the edge
 * the pointer is, so resting mid-row does nothing.
 */
function initTrackEdgeScroll(track) {
    const EDGE = 140;
    const MAX_SPEED = 14;

    // Touch has no hover, and an auto-panning row is exactly what a reduced
    // motion preference is asking us not to do.
    if (!window.matchMedia('(hover: hover)').matches) return;
    if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) return;

    let pointerX = null;
    let rafId = null;

    const stop = () => {
        if (rafId !== null) {
            cancelAnimationFrame(rafId);
            rafId = null;
        }
    };

    const loop = () => {
        rafId = requestAnimationFrame(loop);

        if (pointerX === null) return stop();

        const bounds = track.getBoundingClientRect();
        const fromLeft = pointerX - bounds.left;
        const fromRight = bounds.right - pointerX;

        let speed = 0;
        if (fromLeft < EDGE) speed = -MAX_SPEED * (1 - fromLeft / EDGE);
        else if (fromRight < EDGE) speed = MAX_SPEED * (1 - fromRight / EDGE);

        if (speed !== 0) track.scrollLeft += speed;
    };

    track.addEventListener('pointermove', (event) => {
        if (event.pointerType !== 'mouse') return;

        pointerX = event.clientX;
        if (rafId === null) rafId = requestAnimationFrame(loop);
    });

    track.addEventListener('pointerleave', () => {
        pointerX = null;
        stop();
    });
}

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

    initTrackEdgeScroll(track);

    track.addEventListener('scroll', sync, { passive: true });
    window.addEventListener('resize', sync, { passive: true });

    track.addEventListener('keydown', (event) => {
        if (event.key !== 'ArrowLeft' && event.key !== 'ArrowRight') return;

        event.preventDefault();
        scrollBy(event.key === 'ArrowRight' ? 1 : -1);
    });

    sync();
}

/* Ambient background video ----------------------------------------------- */
function initAmbientVideo() {
    const videos = document.querySelectorAll('[data-ambient-video]');
    if (videos.length === 0) return;

    // An autoplaying loop is exactly what this preference rules out; the poster
    // frame stays on screen instead.
    if (window.matchMedia('(prefers-reduced-motion: reduce)').matches) {
        videos.forEach((video) => {
            video.removeAttribute('autoplay');
            video.pause();
        });

        return;
    }

    if (!('IntersectionObserver' in window)) return;

    // Panels are pinned in a stack, so leave each video paused until its own
    // panel is on screen rather than decoding several at once.
    const observer = new IntersectionObserver(
        (entries) => {
            entries.forEach((entry) => {
                if (entry.isIntersecting) {
                    // Autoplay can still be refused (low power mode, for one).
                    entry.target.play().catch(() => {});
                } else {
                    entry.target.pause();
                }
            });
        },
        { threshold: 0.1 },
    );

    videos.forEach((video) => observer.observe(video));
}

/* Organizer statistics count-up (Module 4) ------------------------------- */
function initStatCounters() {
    const counters = document.querySelectorAll('[data-count]');
    if (counters.length === 0) return;

    const reduceMotion = window.matchMedia('(prefers-reduced-motion: reduce)').matches;

    // Split "500+" into { number: 500, suffix: '+' } so prefixes/suffixes and
    // non-numeric values (e.g. "2015") survive the animation unchanged.
    const parse = (raw) => {
        const match = String(raw).match(/^(\D*)([\d.,]+)(.*)$/);
        if (!match) return null;

        return {
            prefix: match[1],
            target: parseFloat(match[2].replace(/,/g, '')),
            suffix: match[3],
        };
    };

    const run = (el) => {
        const parts = parse(el.dataset.count);
        if (!parts || Number.isNaN(parts.target)) return;

        if (reduceMotion) {
            el.textContent = `${parts.prefix}${parts.target}${parts.suffix}`;
            return;
        }

        const duration = 1200;
        let startTime = null;

        const tick = (now) => {
            if (startTime === null) startTime = now;
            const progress = Math.min((now - startTime) / duration, 1);
            const eased = 1 - Math.pow(1 - progress, 3); // easeOutCubic
            const value = Math.round(parts.target * eased);

            el.textContent = `${parts.prefix}${value}${parts.suffix}`;
            if (progress < 1) requestAnimationFrame(tick);
        };

        requestAnimationFrame(tick);
    };

    if (!('IntersectionObserver' in window)) {
        counters.forEach(run);
        return;
    }

    const observer = new IntersectionObserver(
        (entries) => {
            entries.forEach((entry) => {
                if (!entry.isIntersecting) return;
                run(entry.target);
                observer.unobserve(entry.target);
            });
        },
        { threshold: 0.5 },
    );

    counters.forEach((counter) => observer.observe(counter));
}

/* Validation error focus -------------------------------------------------- */
function initErrorSummary() {
    const summary = document.querySelector('[data-error-summary]');
    if (!summary) return;

    // A failed submission redirects back to whichever page carried the form —
    // on the home page that is the very bottom of a four-panel scroll, so bring
    // the messages into view instead of leaving the visitor at the hero.
    summary.scrollIntoView({ behavior: 'smooth', block: 'center' });
    summary.focus({ preventScroll: true });
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
    initAmbientVideo();
    initStatCounters();
    initErrorSummary();
});
