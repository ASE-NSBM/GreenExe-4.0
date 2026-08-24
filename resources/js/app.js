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
});
