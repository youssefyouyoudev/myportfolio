import './bootstrap';

const storageKey = 'yy-theme';
const root = document.documentElement;

const applyTheme = (theme, persist = true) => {
    root.dataset.theme = theme;
    root.style.colorScheme = theme;

    if (persist) {
        localStorage.setItem(storageKey, theme);
    }

    const metaTheme = document.querySelector('meta[name="theme-color"]');
    if (metaTheme) {
        metaTheme.setAttribute('content', theme === 'dark' ? '#071018' : '#f5f8fc');
    }
};

document.querySelectorAll('[data-theme-toggle]').forEach((button) => {
    button.addEventListener('click', () => {
        const nextTheme = root.dataset.theme === 'light' ? 'dark' : 'light';
        applyTheme(nextTheme);
    });
});

document.querySelectorAll('[data-lang-select]').forEach((select) => {
    select.addEventListener('change', () => {
        const form = select.closest('form');
        if (form) {
            form.submit();
        }
    });
});

document.querySelectorAll('[data-print-resume]').forEach((button) => {
    button.addEventListener('click', () => {
        window.print();
    });
});

const revealItems = document.querySelectorAll('[data-reveal]');

if ('IntersectionObserver' in window && revealItems.length) {
    const revealObserver = new IntersectionObserver((entries) => {
        entries.forEach((entry) => {
            if (entry.isIntersecting) {
                entry.target.classList.add('is-visible');
                revealObserver.unobserve(entry.target);
            }
        });
    }, { threshold: 0.18 });

    revealItems.forEach((item) => revealObserver.observe(item));
} else {
    revealItems.forEach((item) => item.classList.add('is-visible'));
}

const counters = document.querySelectorAll('[data-counter]');

if ('IntersectionObserver' in window && counters.length) {
    const counterObserver = new IntersectionObserver((entries) => {
        entries.forEach((entry) => {
            if (!entry.isIntersecting || entry.target.dataset.counted === 'true') {
                return;
            }

            entry.target.dataset.counted = 'true';
            const target = Number(entry.target.dataset.counter || 0);
            const duration = 1200;
            const start = performance.now();

            const tick = (timestamp) => {
                const progress = Math.min((timestamp - start) / duration, 1);
                const eased = 1 - Math.pow(1 - progress, 3);
                entry.target.textContent = Math.round(target * eased).toString();

                if (progress < 1) {
                    window.requestAnimationFrame(tick);
                }
            };

            window.requestAnimationFrame(tick);
            counterObserver.unobserve(entry.target);
        });
    }, { threshold: 0.35 });

    counters.forEach((counter) => counterObserver.observe(counter));
} else {
    counters.forEach((counter) => {
        counter.textContent = counter.dataset.counter ?? counter.textContent;
    });
}

window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', (event) => {
    if (!localStorage.getItem(storageKey)) {
        applyTheme(event.matches ? 'dark' : 'light', false);
    }
});
