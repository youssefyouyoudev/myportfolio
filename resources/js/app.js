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

document.querySelectorAll('[data-print-resume]').forEach((button) => {
    button.addEventListener('click', () => {
        window.print();
    });
});

const header = document.querySelector('.site-header');

const syncHeaderState = () => {
    if (!header) {
        return;
    }

    header.classList.toggle('is-scrolled', window.scrollY > 12);
};

syncHeaderState();
window.addEventListener('scroll', syncHeaderState, { passive: true });

const detailMenus = document.querySelectorAll('details.locale-menu, details.mobile-nav');

document.addEventListener('click', (event) => {
    detailMenus.forEach((menu) => {
        if (!menu.contains(event.target)) {
            menu.removeAttribute('open');
        }
    });
});

document.addEventListener('keydown', (event) => {
    if (event.key === 'Escape') {
        detailMenus.forEach((menu) => menu.removeAttribute('open'));
    }
});

document.querySelectorAll('.mobile-nav-panel a, .locale-list a').forEach((link) => {
    link.addEventListener('click', () => {
        detailMenus.forEach((menu) => menu.removeAttribute('open'));
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

document.querySelectorAll('[data-counter]').forEach((counter) => {
    counter.textContent = counter.dataset.counter ?? counter.textContent;
});

window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', (event) => {
    if (!localStorage.getItem(storageKey)) {
        applyTheme(event.matches ? 'dark' : 'light', false);
    }
});
