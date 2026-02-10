@props(['locale' => app()->getLocale(), 'isRtl' => $isRtl ?? false])

<section id="hero" class="relative isolate overflow-hidden section" aria-labelledby="hero-title">
    <div class="hero-grid" aria-hidden="true"></div>
    <div class="absolute inset-0" aria-hidden="true">
        <div class="absolute -left-32 top-10 h-72 w-72 rounded-full bg-[rgba(15,163,168,0.16)] blur-3xl"></div>
        <div class="absolute right-10 -bottom-24 h-96 w-96 rounded-full bg-[rgba(214,60,60,0.12)] blur-3xl"></div>
    </div>

    <div class="shell grid grid-cols-1 items-start gap-12 md:grid-cols-2 lg:gap-16">
        <div class="relative z-10 space-y-8" data-reveal>
            <div class="pill">{{ __('hero.badge') }}</div>

            <div class="space-y-4">
                <p class="text-sm uppercase tracking-[0.18em] text-[var(--muted)]">{{ __('hero.owner_line') }}</p>
                <h1 id="hero-title" class="text-4xl font-semibold leading-tight text-[var(--text-strong)] sm:text-5xl">
                    {{ __('hero.title') }}
                </h1>
                <p class="max-w-2xl text-lg text-[var(--muted)]">
                    {{ __('hero.subtitle') }}
                </p>
            </div>

            <div class="flex flex-wrap items-center gap-3">
                <a href="{{ route('contact.create') }}" class="btn-primary">
                    {{ __('hero.ctas.primary') }}
                    <span aria-hidden="true">→</span>
                </a>
                <a href="#projects" class="btn-ghost">{{ __('hero.ctas.secondary') }}</a>
                <a href="#services" class="btn-ghost">{{ __('hero.ctas.tertiary') }}</a>
            </div>

            <div class="flex flex-wrap items-center gap-2 text-xs uppercase tracking-wide text-[var(--muted)]">
                @foreach(__('hero.chips') as $chip)
                    <span class="chip">{{ $chip }}</span>
                @endforeach
            </div>

            @php($stats = __('hero.stats'))
            <div class="grid gap-4 sm:grid-cols-3">
                <div class="stat-tile">
                    <span>{{ $stats['outcome']['label'] }}</span>
                    <strong>{{ $stats['outcome']['value'] }}</strong>
                    <span>{{ $stats['outcome']['hint'] }}</span>
                </div>
                <div class="stat-tile">
                    <span>{{ $stats['shipped']['label'] }}</span>
                    <strong>{{ $stats['shipped']['value'] }}</strong>
                    <span>{{ $stats['shipped']['hint'] }}</span>
                </div>
                <div class="stat-tile">
                    <span>{{ $stats['availability']['label'] }}</span>
                    <strong>{{ $stats['availability']['value'] }}</strong>
                    <span>{{ $stats['availability']['hint'] }}</span>
                </div>
            </div>

            <div class="flex flex-wrap items-center gap-4">
                <div class="tagline">
                    <span class="h-2 w-2 rounded-full bg-[var(--accent)]"></span>
                    <span>{{ __('navigation.tagline') }}</span>
                </div>
                <div class="flex items-center gap-2 text-xs text-[var(--muted)]">
                    <span class="chip">EN</span>
                    <span class="chip">FR</span>
                    <span class="chip">AR</span>
                </div>
            </div>

            <div class="surface p-4 text-sm text-[var(--muted)]">
                <div class="flex items-center justify-between">
                    <div class="font-semibold text-[var(--text-strong)]">{{ __('hero.language.label') }}</div>
                    <div class="text-xs">{{ strtoupper($locale) }}</div>
                </div>
                <div class="divider my-4"></div>
                <div class="flex flex-wrap gap-2">
                    @foreach(__('hero.language.options') as $code => $label)
                        <a
                            href="{{ request()->fullUrlWithQuery(['lang' => $code]) }}"
                            data-lang-option="{{ $code }}"
                            class="chip {{ $locale === $code ? 'border-[var(--accent)] text-[var(--text-strong)]' : '' }}"
                        >
                            <span class="h-2 w-2 rounded-full {{ $locale === $code ? 'bg-[var(--accent)]' : 'bg-[var(--muted)]' }}"></span>
                            {{ $label }}
                        </a>
                    @endforeach
                </div>
            </div>

            <div class="grid gap-4 sm:grid-cols-2">
                <div class="surface p-4">
                    <div class="flex items-center justify-between text-sm text-[var(--muted)]">
                        <span>{{ __('hero.performance.title') }}</span>
                        <span>{{ __('hero.performance.value') }}</span>
                    </div>
                    <div class="mt-3 h-2 rounded-full bg-[var(--card-2)]">
                        <div class="h-2 w-5/6 rounded-full bg-[var(--accent)]"></div>
                    </div>
                    <p class="mt-3 text-xs">{{ __('hero.performance.copy') }}</p>
                </div>
                <div class="surface p-4">
                    <div class="flex items-center justify-between text-sm text-[var(--muted)]">
                        <span>{{ __('hero.accessibility.title') }}</span>
                        <span>{{ __('hero.accessibility.value') }}</span>
                    </div>
                    <div class="mt-3 h-2 rounded-full bg-[var(--card-2)]">
                        <div class="h-2 w-4/5 rounded-full bg-[var(--accent-2)]"></div>
                    </div>
                    <p class="mt-3 text-xs">{{ __('hero.accessibility.copy') }}</p>
                </div>
            </div>
        </div>

        <div class="relative z-10 md:pt-4" data-reveal>
            <div class="surface p-4 md:-mt-6">
                <div class="relative overflow-hidden rounded-2xl">
                    <img
                        src="{{ Vite::asset('resources/images/avatar.png') }}"
                        alt="{{ __('hero.avatar_alt') }}"
                        class="w-full rounded-2xl"
                        loading="lazy"
                    />
                    <div class="orbit-ring absolute inset-0 m-auto"></div>
                </div>
                <div class="mt-4 grid gap-3 sm:grid-cols-2">
                    <a
                        href="https://github.com/youssefyouyoudev"
                        target="_blank"
                        rel="noreferrer"
                        class="btn-ghost justify-center"
                    >
                        {{ __('hero.github_button') }}
                    </a>
                    <div class="chip justify-center">{{ __('hero.github_badge') }}</div>
                </div>
                <div class="mt-3 flex flex-wrap gap-2">
                    @foreach(__('hero.tech_chips') as $chip)
                        <span class="chip">{{ $chip }}</span>
                    @endforeach
                </div>
            </div>
        </div>
    </div>
</section>
