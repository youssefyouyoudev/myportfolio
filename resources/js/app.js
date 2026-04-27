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

const toastHost = document.createElement('div');
toastHost.className = 'toast-stack';
document.body.appendChild(toastHost);

const showToast = (message, state = 'success') => {
    if (!message) {
        return;
    }

    const toast = document.createElement('div');
    toast.className = `toast toast-${state}`;
    const text = document.createElement('span');
    text.textContent = message;
    const close = document.createElement('button');
    close.type = 'button';
    close.className = 'toast-close';
    close.setAttribute('aria-label', 'Dismiss notification');
    close.textContent = 'Close';
    toast.append(text, close);
    toastHost.appendChild(toast);

    const dismiss = () => {
        toast.classList.remove('is-visible');
        window.setTimeout(() => toast.remove(), 180);
    };

    close.addEventListener('click', dismiss);

    window.setTimeout(() => {
        toast.classList.add('is-visible');
    }, 20);

    window.setTimeout(() => {
        dismiss();
    }, 4000);
};

const statusBanner = document.querySelector('[data-toast-success]');
const errorBanner = document.querySelector('[data-toast-error]');

if (statusBanner) {
    showToast(statusBanner.dataset.toastSuccess, 'success');
}

if (errorBanner) {
    showToast(errorBanner.dataset.toastError, 'error');
}

document.querySelectorAll('[data-contact-form]').forEach((form) => {
    const submitButton = form.querySelector('[data-submit-button]');
    const submitLabel = form.querySelector('[data-submit-label]');
    const validations = {
        name: {
            field: form.querySelector('[name="name"]'),
            test: (value) => value.trim().length > 0,
            message: 'Please enter your name.',
        },
        email: {
            field: form.querySelector('[name="email"]'),
            test: (value) => /^[^\s@]+@[^\s@]+\.[^\s@]+$/.test(value.trim()),
            message: 'Please enter a valid email address.',
        },
        message: {
            field: form.querySelector('[name="message"]'),
            test: (value) => value.trim().length >= 20,
            message: 'Please share at least 20 characters about the project.',
        },
    };

    const setFieldError = (key, message = '') => {
        const errorNode = form.querySelector(`[data-field-error="${key}"]`);
        const field = validations[key]?.field;

        if (errorNode) {
            errorNode.textContent = message;
        }

        if (field) {
            field.classList.toggle('has-error', Boolean(message));
            field.setAttribute('aria-invalid', message ? 'true' : 'false');
        }
    };

    Object.entries(validations).forEach(([key, config]) => {
        config.field?.addEventListener('input', () => {
            setFieldError(key, '');
        });
    });

    form.addEventListener('submit', (event) => {
        let hasErrors = false;

        Object.entries(validations).forEach(([key, config]) => {
            const value = config.field?.value ?? '';
            const isValid = config.test(value);
            setFieldError(key, isValid ? '' : config.message);
            hasErrors = hasErrors || !isValid;
        });

        if (hasErrors) {
            event.preventDefault();
            showToast('Please fix the highlighted fields before sending.', 'error');
            return;
        }

        if (submitButton && submitLabel) {
            submitButton.disabled = true;
            submitButton.classList.add('is-loading');
            submitLabel.textContent = 'Sending...';
        }
    });
});

const delayedWhatsapp = document.querySelector('[data-delayed-whatsapp]');

if (delayedWhatsapp) {
    let timerReady = false;
    let scrollReady = false;

    const maybeShowWhatsapp = () => {
        if (timerReady && scrollReady) {
            delayedWhatsapp.classList.add('is-visible');
        }
    };

    window.setTimeout(() => {
        timerReady = true;
        maybeShowWhatsapp();
    }, 5000);

    window.addEventListener('scroll', () => {
        if (window.scrollY > 320) {
            scrollReady = true;
            maybeShowWhatsapp();
        }
    }, { passive: true });
}

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

document.querySelectorAll('[data-copy-text]').forEach((button) => {
    button.addEventListener('click', async () => {
        const text = button.dataset.copyText ?? '';
        const original = button.dataset.copyOriginal ?? button.textContent;

        if (!text) {
            return;
        }

        try {
            await navigator.clipboard.writeText(text);
            button.dataset.copyOriginal = original;
            button.textContent = button.dataset.copySuccess ?? 'Copied';
            window.setTimeout(() => {
                button.textContent = original;
            }, 1800);
        } catch {
            button.textContent = 'Copy failed';
            window.setTimeout(() => {
                button.textContent = original;
            }, 1800);
        }
    });
});

window.matchMedia('(prefers-color-scheme: dark)').addEventListener('change', (event) => {
    if (!localStorage.getItem(storageKey)) {
        applyTheme(event.matches ? 'dark' : 'light', false);
    }
});
