import './bootstrap';

const THEME_KEY = 'yy-theme';
const LANG_KEY = 'app_lang';
const SUPPORTED_LANGS = ['en', 'fr', 'ar'];

const getPreferredTheme = () => {
	const stored = window.localStorage.getItem(THEME_KEY);
	if (stored === 'light' || stored === 'dark') return stored;
	return window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
};

const applyTheme = (theme) => {
	const root = document.documentElement;
	root.setAttribute('data-theme', theme);
	root.classList.toggle('dark', theme === 'dark');
	window.localStorage.setItem(THEME_KEY, theme);
};

const toggleTheme = () => {
	const next = document.documentElement.getAttribute('data-theme') === 'dark' ? 'light' : 'dark';
	applyTheme(next);
};

const initThemeToggle = () => {
	const control = document.querySelector('[data-theme-toggle]');
	if (!control) return;
	control.addEventListener('click', toggleTheme);
};

const initReveal = () => {
	const items = document.querySelectorAll('[data-reveal]');
	if (!items.length) return;
	const prefersReduced = window.matchMedia('(prefers-reduced-motion: reduce)').matches;
	if (prefersReduced) {
		items.forEach((el) => el.classList.add('is-visible'));
		return;
	}
	const observer = new IntersectionObserver(
		(entries) => {
			entries.forEach((entry) => {
				if (entry.isIntersecting) {
					entry.target.classList.add('is-visible');
					observer.unobserve(entry.target);
				}
			});
		},
		{ threshold: 0.22, rootMargin: '0px 0px -10% 0px' }
	);
	items.forEach((el) => observer.observe(el));
};

const initSmoothAnchors = () => {
	document.querySelectorAll('a[href^="#"]').forEach((anchor) => {
		anchor.addEventListener('click', (event) => {
			const targetId = anchor.getAttribute('href').substring(1);
			const target = document.getElementById(targetId);
			if (!target) return;
			event.preventDefault();
			target.scrollIntoView({ behavior: 'smooth', block: 'start' });
		});
	});
};

const getStoredLang = () => {
	const lang = window.localStorage.getItem(LANG_KEY);
	return SUPPORTED_LANGS.includes(lang) ? lang : null;
};

const syncLangFromUrlOrStorage = () => {
	const url = new URL(window.location.href);
	const urlLang = url.searchParams.get('lang');
	const current = document.documentElement.lang || 'en';

	if (urlLang && SUPPORTED_LANGS.includes(urlLang)) {
		if (urlLang !== current) {
			window.localStorage.setItem(LANG_KEY, urlLang);
		}
		return;
	}

	const stored = getStoredLang();
	if (stored && stored !== current) {
		url.searchParams.set('lang', stored);
		window.location.replace(url.toString());
	}
};

const initLangControls = () => {
	const select = document.querySelector('[data-lang-select]');
	if (select) {
		select.addEventListener('change', (event) => {
			const next = event.target.value;
			if (!SUPPORTED_LANGS.includes(next)) return;
			window.localStorage.setItem(LANG_KEY, next);
			const url = new URL(window.location.href);
			url.searchParams.set('lang', next);
			window.location.assign(url.toString());
		});
	}

	document.querySelectorAll('[data-lang-option]').forEach((el) => {
		el.addEventListener('click', (event) => {
			const next = el.getAttribute('data-lang-option');
			if (!SUPPORTED_LANGS.includes(next)) return;
			window.localStorage.setItem(LANG_KEY, next);
			const href = el.getAttribute('href');
			if (href) {
				event.preventDefault();
				window.location.assign(href);
			}
		});
	});
};

document.addEventListener('DOMContentLoaded', () => {
	applyTheme(getPreferredTheme());
	initThemeToggle();
	initReveal();
	initSmoothAnchors();
	syncLangFromUrlOrStorage();
	initLangControls();
});
