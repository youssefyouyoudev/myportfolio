import './bootstrap';

import Alpine from 'alpinejs';

window.Alpine = Alpine;

Alpine.start();

const root = document.documentElement;
const storageKey = 'portfolio-theme';

const getInitialTheme = () => {
	const saved = window.localStorage.getItem(storageKey);

	if (saved === 'dark' || saved === 'light') {
		return saved;
	}

	return window.matchMedia('(prefers-color-scheme: dark)').matches ? 'dark' : 'light';
};

const applyTheme = (theme) => {
	root.setAttribute('data-theme', theme);
	window.localStorage.setItem(storageKey, theme);

	const themeMeta = document.querySelector('meta[name="theme-color"]');
	if (themeMeta) {
		themeMeta.setAttribute('content', theme === 'dark' ? '#070b14' : '#f6f8fc');
	}
};

applyTheme(getInitialTheme());

document.querySelectorAll('[data-theme-toggle]').forEach((button) => {
	button.addEventListener('click', () => {
		const nextTheme = root.getAttribute('data-theme') === 'dark' ? 'light' : 'dark';
		applyTheme(nextTheme);
	});
});
