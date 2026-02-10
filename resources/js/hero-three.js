import {
	AmbientLight,
	AnimationMixer,
	Clock,
	Color,
	DirectionalLight,
	Fog,
	PerspectiveCamera,
	Scene,
	Vector2,
	WebGLRenderer,
} from 'three';
import { GLTFLoader } from 'three/examples/jsm/loaders/GLTFLoader.js';
import { OrbitControls } from 'three/examples/jsm/controls/OrbitControls.js';

const prefersReducedMotion = () => window.matchMedia('(prefers-reduced-motion: reduce)').matches;

const logPrefix = '[hero-three]';

const createRenderer = (container) => {
	const renderer = new WebGLRenderer({ antialias: true, alpha: true, preserveDrawingBuffer: true });
	renderer.setPixelRatio(Math.min(window.devicePixelRatio, 1.8));
	renderer.setSize(container.clientWidth, container.clientHeight);
	if ('outputEncoding' in renderer) {
		// 3000 is the numeric value for sRGBEncoding in Three.js; avoids missing named export issues on older builds
		renderer.outputEncoding = 3000;
	}
	return renderer;
};

const applyReveal = (root) => {
	const revealTargets = root.querySelectorAll('[data-reveal]');
	revealTargets.forEach((el, index) => {
		el.style.opacity = '0';
		el.style.transform = 'translateY(16px)';
		el.style.transition = 'opacity 700ms ease, transform 700ms ease';
		const observer = new IntersectionObserver((entries, obs) => {
			entries.forEach((entry) => {
				if (entry.isIntersecting) {
					const delay = 80 * index;
					requestAnimationFrame(() => {
						el.style.transitionDelay = `${delay}ms`;
						el.style.opacity = '1';
						el.style.transform = 'translateY(0)';
					});
					obs.disconnect();
				}
			});
		}, { threshold: 0.2 });
		observer.observe(el);
	});
};

const mountScene = (wrapper) => {
	const canvasHost = wrapper.querySelector('[data-hero-three-canvas]');
	const fallback = wrapper.querySelector('[data-hero-fallback]');
	const showFallback = (reason) => {
		console.error(logPrefix, reason);
		fallback?.classList.remove('hidden');
	};
	if (!canvasHost) return;

	const scene = new Scene();
	scene.background = new Color('#05080d');
	scene.fog = new Fog('#05080d', 10, 60);

	const camera = new PerspectiveCamera(35, canvasHost.clientWidth / canvasHost.clientHeight, 0.1, 100);
	camera.position.set(0.3, 1.55, 2.4);

	let renderer;
	try {
		renderer = createRenderer(canvasHost);
		canvasHost.appendChild(renderer.domElement);
	} catch (error) {
		showFallback(error);
		return;
	}

	fallback?.classList.add('hidden');

	const ambient = new AmbientLight('#cde7ff', 0.55);
	scene.add(ambient);
	const key = new DirectionalLight('#b4f0d3', 0.95);
	key.position.set(2.5, 3.5, 4);
	scene.add(key);
	const rim = new DirectionalLight('#78c4ff', 0.5);
	rim.position.set(-2.2, 2.6, -2.2);
	scene.add(rim);

	const loader = new GLTFLoader();
	const modelUrl = new URL('../models/youssef_avatar.glb', import.meta.url).href;
	let mixer;
	let avatar;

	loader.load(
		modelUrl,
		(gltf) => {
			avatar = gltf.scene;
			avatar.traverse((obj) => {
				if (obj.isMesh) {
					obj.castShadow = false;
					obj.receiveShadow = false;
				}
			});
			avatar.position.set(0, 0, 0);
			scene.add(avatar);

			if (gltf.animations && gltf.animations.length) {
				mixer = new AnimationMixer(avatar);
				const idle = mixer.clipAction(gltf.animations[0]);
				idle.play();
			}

			fallback?.classList.add('hidden');
		},
		undefined,
		(err) => showFallback(err || 'Model failed to load')
	);

	const controls = new OrbitControls(camera, renderer.domElement);
	controls.enableDamping = true;
	controls.enablePan = false;
	controls.target.set(0, 1.45, 0);
	controls.minDistance = 1.6;
	controls.maxDistance = 2.8;
	controls.minPolarAngle = Math.PI * 0.35;
	controls.maxPolarAngle = Math.PI * 0.62;

	const clock = new Clock();
	const cursor = new Vector2(0, 0);
	const parallax = new Vector2(0, 0);

	const onPointerMove = (event) => {
		const rect = canvasHost.getBoundingClientRect();
		cursor.x = ((event.clientX - rect.left) / rect.width - 0.5) * 2;
		cursor.y = ((event.clientY - rect.top) / rect.height - 0.5) * -2;
	};
	window.addEventListener('pointermove', onPointerMove);

	const onResize = () => {
		const { clientWidth, clientHeight } = canvasHost;
		camera.aspect = clientWidth / clientHeight;
		camera.updateProjectionMatrix();
		renderer.setSize(clientWidth, clientHeight);
	};
	window.addEventListener('resize', onResize);

	let running = true;
	const io = new IntersectionObserver((entries) => {
		running = entries.some((entry) => entry.isIntersecting);
	}, { threshold: 0.2 });
	io.observe(wrapper);

	const renderLoop = () => {
		requestAnimationFrame(renderLoop);
		if (!running) return;
		const delta = clock.getDelta();
		if (mixer) mixer.update(delta);

		parallax.x += (cursor.x * 0.8 - parallax.x) * 0.06;
		parallax.y += (cursor.y * 0.6 - parallax.y) * 0.06;

		camera.position.x += (parallax.x * 0.4 - camera.position.x + 0.3) * 0.04;
		camera.position.y += (1.55 + parallax.y * 0.25 - camera.position.y) * 0.04;
		controls.update();
		camera.lookAt(0, 1.45, 0);

		renderer.render(scene, camera);
	};

	renderLoop();
};

export const bootHeroThree = () => {
	const wrapper = document.querySelector('[data-hero-three]');
	if (!wrapper) return;
	if (prefersReducedMotion()) {
		const fallback = wrapper.querySelector('[data-hero-fallback]');
		fallback?.classList.remove('hidden');
		console.info(logPrefix, 'Reduced motion enabled, skipping WebGL');
		return;
	}

	applyReveal(wrapper.closest('section') ?? document);

	const start = () => {
		try {
			mountScene(wrapper);
		} catch (error) {
			console.error(logPrefix, 'Failed to start', error);
			const fallback = wrapper.querySelector('[data-hero-fallback]');
			if (fallback) fallback.classList.remove('hidden');
		}
	};

	const observer = new IntersectionObserver((entries, obs) => {
		entries.forEach((entry) => {
			if (entry.isIntersecting) {
				start();
				obs.disconnect();
			}
		});
	}, { threshold: 0.25 });

	observer.observe(wrapper);
};
