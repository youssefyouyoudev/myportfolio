@extends('layouts.app')

@push('structured-data')
    @foreach($homeStructuredData ?? [] as $schema)
        <script type="application/ld+json">{!! json_encode($schema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) !!}</script>
    @endforeach
@endpush

@section('content')
@php
    $locale     = app()->getLocale();
    $site       = \App\Support\BrandContent::site($locale);
    $projects   = collect($showcase['projects']);
    $featuredProjects  = collect($showcase['featured_projects'] ?? $projects->take(3)->all())->filter()->values();
    $secondaryProjects = collect($showcase['secondary_projects'] ?? $projects->slice(3, 2)->all())->filter()->values();
    $servicesFull      = $showcase['services_full'] ?? $showcase['services'] ?? [];
    $whoIWorkWith      = $showcase['who_i_work_with'] ?? [];
    $processSteps      = $showcase['process'] ?? [];
    $statsNumbers      = $showcase['stats_numbers'] ?? [];
    $trustStrip        = $showcase['hero']['trust_strip'] ?? '';
@endphp

{{-- ═══════════════════════ HERO ═══════════════════════ --}}
<section class="hero portfolio-hero">
    <div class="container hero-split-grid">
        <div class="hero-portrait-panel panel" data-reveal>
            <img
                src="{{ asset('images/youssef-youyou.jpg') }}"
                alt="Youssef Youyou, senior full-stack developer based in Nador, Morocco — web, mobile, and desktop"
                class="hero-portrait"
                width="720"
                height="880"
                loading="eager"
                fetchpriority="high"
            >
        </div>

        <div class="portfolio-hero-copy" data-reveal>
            <div class="availability-pill availability-pill-{{ $site['availability_badge']['state'] }}">
                <span class="avail-dot" aria-hidden="true"></span>
                <span class="avail-label">{{ $site['availability_badge']['label'] }}</span>
            </div>

            <h1>I build the software. You grow the business.</h1>

            <p class="hero-subhead">I handle conception, architecture, full-stack development, AI integration, and project management &mdash; so you get a working product, not just code.</p>

            <div class="hero-actions">
                <a href="{{ route('contact.create', ['locale' => $locale]) }}" class="btn btn-primary" id="hero-cta-primary">Start a project &rarr;</a>
                <a href="#featured-work" class="btn btn-secondary" id="hero-cta-secondary">See the work &darr;</a>
            </div>

            <div class="hero-trust-strip">
                <span>{{ $trustStrip ?: '6+ years · 20+ products shipped · Web · Mobile · Desktop · AI · B2B & B2C · Morocco & International' }}</span>
            </div>

            <div class="portfolio-stat-grid">
                @foreach($showcase['hero']['metrics'] as $metric)
                    <article class="portfolio-stat-card panel">
                        <strong>{{ $metric['value'] }}</strong>
                        <span>{{ $metric['label'] }}</span>
                    </article>
                @endforeach
            </div>
        </div>
    </div>
</section>

{{-- ═══════════════════════ WHAT I DO — 6 SERVICE CARDS ═══════════════════════ --}}
<section class="section" id="services">
    <div class="container">
        <x-site.section-heading
            eyebrow="What I do"
            title="Full-stack delivery across every platform."
            copy="From conception to launch — web, mobile, desktop, and AI. I cover the entire product lifecycle so you have one reliable partner, not a chain of freelancers."
        />

        <div class="home-service-grid">
            @foreach($servicesFull as $service)
                <article class="panel home-service-card" data-reveal>
                    <div class="home-service-icon" aria-hidden="true">{{ $service['icon'] ?? '◆' }}</div>
                    <h3>{{ $service['title'] }}</h3>
                    <p class="home-service-outcome">{{ $service['outcome'] ?? $service['value'] ?? '' }}</p>
                    @if(!empty($service['bullets']))
                        <ul class="home-service-bullets">
                            @foreach($service['bullets'] as $bullet)
                                <li>{{ $bullet }}</li>
                            @endforeach
                        </ul>
                    @endif
                    <a href="{{ route('services.index', ['locale' => $locale]) }}" class="text-link">Learn more &rarr;</a>
                </article>
            @endforeach
        </div>

        <div class="section-inline-cta">
            <p>All six services. One partner. From day one to launch day.</p>
            <a href="{{ route('contact.create', ['locale' => $locale]) }}" class="btn btn-primary">Start a project &rarr;</a>
        </div>
    </div>
</section>

{{-- ═══════════════════════ WHO I WORK WITH — B2B / B2C ═══════════════════════ --}}
@if(!empty($whoIWorkWith))
<section class="section section-soft" id="who-i-work-with">
    <div class="container">
        <x-site.section-heading
            eyebrow="Who I work with"
            title="Built for both sides of the table."
            copy="Whether you're a business with a delivery gap or a founder with a fresh idea — the output is the same: a working product that ships."
        />

        <div class="who-grid">
            <article class="panel who-card who-card-b2b" data-reveal>
                <div class="who-badge">B2B</div>
                <h3>{{ $whoIWorkWith['b2b']['title'] }}</h3>
                <p>{{ $whoIWorkWith['b2b']['copy'] }}</p>
                @if(!empty($whoIWorkWith['b2b']['ideal_for']))
                    <div class="who-ideal">
                        <span class="who-ideal-label">Ideal for</span>
                        <ul>
                            @foreach($whoIWorkWith['b2b']['ideal_for'] as $item)
                                <li>{{ $item }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </article>

            <article class="panel who-card who-card-b2c" data-reveal>
                <div class="who-badge who-badge-b2c">B2C</div>
                <h3>{{ $whoIWorkWith['b2c']['title'] }}</h3>
                <p>{{ $whoIWorkWith['b2c']['copy'] }}</p>
                @if(!empty($whoIWorkWith['b2c']['ideal_for']))
                    <div class="who-ideal">
                        <span class="who-ideal-label">Ideal for</span>
                        <ul>
                            @foreach($whoIWorkWith['b2c']['ideal_for'] as $item)
                                <li>{{ $item }}</li>
                            @endforeach
                        </ul>
                    </div>
                @endif
            </article>
        </div>
    </div>
</section>
@endif

{{-- ═══════════════════════ HOW IT WORKS — 4 STEPS ═══════════════════════ --}}
@if(!empty($processSteps))
<section class="section" id="how-it-works">
    <div class="container">
        <x-site.section-heading
            eyebrow="How it works"
            title="From brief to launched product."
            copy="Four clear steps. No vague estimates, no silent weeks, no surprises at the end."
        />

        <div class="process-grid home-process-grid">
            @foreach($processSteps as $step)
                <article class="panel process-card" data-reveal>
                    <span class="process-step">{{ $step['step'] }}</span>
                    <h3>{{ $step['title'] }}</h3>
                    <p>{{ $step['copy'] }}</p>
                </article>
            @endforeach
        </div>

        <div class="section-inline-cta">
            <p>Ready to start? A short brief is enough.</p>
            <a href="{{ route('contact.create', ['locale' => $locale]) }}" class="btn btn-primary">Start a project &rarr;</a>
        </div>
    </div>
</section>
@endif

{{-- ═══════════════════════ SOCIAL PROOF / TESTIMONIALS ═══════════════════════ --}}
@if(collect($testimonials)->isNotEmpty())
    <section class="section section-soft" id="testimonials">
        <div class="container">
            <x-site.section-heading
                eyebrow="Client feedback"
                title="What clients say once the work is in use."
                copy="Only published testimonials with real approval appear here."
            />
            <x-testimonials :items="$testimonials" />
        </div>
    </section>
@else
    {{-- By-the-numbers fallback when no testimonials yet --}}
    @if(!empty($statsNumbers))
    <section class="section section-soft" id="by-the-numbers">
        <div class="container">
            <x-site.section-heading
                eyebrow="By the numbers"
                title="Six years of shipping across every platform."
                copy="Real delivery, measured output, and a track record that holds up across B2B and B2C."
            />
            <div class="home-stats-bar">
                @foreach($statsNumbers as $stat)
                    <div class="home-stat-item">
                        <strong>{{ $stat['value'] }}</strong>
                        <span>{{ $stat['label'] }}</span>
                    </div>
                @endforeach
            </div>
        </div>
    </section>
    @endif
@endif

{{-- ═══════════════════════ SELECTED WORK — 3 FEATURED PROJECTS ═══════════════════════ --}}
<section class="section" id="featured-work">
    <div class="container">
        <x-site.section-heading
            eyebrow="Selected work"
            title="Case studies with context, constraints, and outcomes."
            copy="The strongest portfolio pieces show what was built, why it mattered, and what changed after launch."
        />

        <div class="case-study-stack">
            @foreach($featuredProjects as $project)
                <article class="panel case-study-block case-theme-{{ $project['media']['theme'] ?? 'default' }}" data-reveal>
                    <div class="case-study-media">
                        <x-site.project-frame :project="$project" />
                    </div>

                    <div class="case-study-copy">
                        <div class="case-study-meta-line">
                            <span class="eyebrow">{{ $project['label'] }}</span>
                            @if($project['is_nda'] ?? false)
                                <span class="case-badge">Under NDA &mdash; details available on request</span>
                            @elseif($project['is_concept'] ?? false)
                                <span class="case-badge">Concept / Portfolio piece</span>
                            @endif
                        </div>

                        <h3>{{ $project['title'] }}</h3>
                        <p class="case-summary">{{ $project['summary'] }}</p>

                        <div class="case-meta-grid">
                            @if($project['is_nda'] ?? false)
                                <div>
                                    <span class="meta-label">Access</span>
                                    <p>Under NDA &mdash; details available on request.</p>
                                </div>
                            @else
                                <div>
                                    <span class="meta-label">Client</span>
                                    <p>{{ $project['client'] ?? 'Private client' }}</p>
                                </div>
                                <div>
                                    <span class="meta-label">Industry</span>
                                    <p>{{ $project['client_industry'] ?? 'Digital product' }}</p>
                                </div>
                            @endif
                        </div>

                        <div class="case-meta-grid">
                            <div>
                                <span class="meta-label">{{ __('brand.common.problem') }}</span>
                                <p>{{ $project['challenge'] }}</p>
                            </div>
                            <div>
                                <span class="meta-label">{{ __('brand.common.solution') }}</span>
                                <p>{{ $project['solution'] }}</p>
                            </div>
                        </div>

                        <p class="result-headline">{{ $project['result_headline'] ?? $project['outcome'] ?? 'A stronger build with clearer delivery outcomes.' }}</p>

                        <div class="stack-list">
                            @foreach($project['stack'] as $item)
                                <span>{{ $item }}</span>
                            @endforeach
                            @if(! empty($project['built_at']))
                                <span>{{ $project['built_at'] }}</span>
                            @endif
                        </div>

                        <div class="case-metric-row">
                            @foreach($project['metrics'] as $metric)
                                <div class="case-metric-card">
                                    <strong>{{ $metric['value'] }}</strong>
                                    <span>{{ $metric['label'] }}</span>
                                </div>
                            @endforeach
                        </div>

                        <div class="case-study-actions">
                            <a href="{{ route('projects.show', ['locale' => $locale, 'project' => $project['slug']]) }}" class="btn btn-primary">{{ $site['actions']['view_case_study'] }}</a>
                            @if(! empty($project['live_url']))
                                <a href="{{ $project['live_url'] }}" class="btn btn-secondary" target="_blank" rel="noopener noreferrer">View Live &rarr;</a>
                            @endif
                        </div>
                    </div>
                </article>
            @endforeach
        </div>

        @if($secondaryProjects->isNotEmpty())
        <div class="portfolio-secondary-grid" style="margin-top: 1.5rem;">
            @foreach($secondaryProjects as $project)
                <article class="panel secondary-case-card case-theme-{{ $project['media']['theme'] ?? 'default' }}" data-reveal>
                    <div class="secondary-case-visual">
                        <x-site.project-frame :project="$project" compact />
                    </div>
                    <div class="project-copy">
                        <div class="case-study-meta-line">
                            <span class="eyebrow">{{ $project['label'] }}</span>
                            @if($project['is_nda'] ?? false)
                                <span class="case-badge">Under NDA &mdash; details available on request</span>
                            @elseif($project['is_concept'] ?? false)
                                <span class="case-badge">Concept / Portfolio piece</span>
                            @endif
                        </div>
                        <h3>{{ $project['title'] }}</h3>
                        <p>{{ $project['summary'] }}</p>
                        <p><span class="meta-label">Result:</span> {{ $project['result_headline'] ?? $project['outcome'] ?? 'A clearer project story with stronger business context.' }}</p>
                        <div class="stack-list">
                            @foreach($project['stack'] as $item)
                                <span>{{ $item }}</span>
                            @endforeach
                            @if(! empty($project['built_at']))
                                <span>{{ $project['built_at'] }}</span>
                            @endif
                        </div>
                        <div class="case-inline-actions">
                            <a href="{{ route('projects.show', ['locale' => $locale, 'project' => $project['slug']]) }}" class="text-link">{{ $site['actions']['view_case_study'] }}</a>
                        </div>
                    </div>
                </article>
            @endforeach
        </div>
        @endif

        <div class="section-inline-cta">
            <p>All projects, filters, and full case studies on the work page.</p>
            <a href="{{ route('projects.index', ['locale' => $locale]) }}" class="btn btn-secondary">View all work &rarr;</a>
        </div>
    </div>
</section>

{{-- ═══════════════════════ CONTACT ═══════════════════════ --}}
<section class="section section-soft" id="contact">
    <div class="container contact-layout">
        <div class="contact-column">
            <x-site.section-heading
                eyebrow="Contact"
                title="Tell me what you're building."
                copy="Whether it's a rough idea or a detailed spec — I'll reply within 24 hours with a clear next step."
            />

            <article class="panel next-steps-panel">
                <span class="eyebrow">What happens next</span>
                <ol class="next-steps-list">
                    <li>I read your brief and assess fit.</li>
                    <li>I reply with questions or a proposed next step.</li>
                    <li>We align on scope before any commitment.</li>
                </ol>
                <p class="response-promise">Replies within 24 hours. No sales scripts. Just a practical next step.</p>
            </article>

            <div class="contact-direct-links">
                <a href="{{ $site['whatsapp_url'] }}" class="btn btn-secondary whatsapp-inline" target="_blank" rel="noopener" id="contact-whatsapp-link">
                    <svg viewBox="0 0 24 24" aria-hidden="true" width="20" height="20"><path d="M19.05 4.94A9.93 9.93 0 0 0 12 2a10 10 0 0 0-8.66 15l-1.3 4.74 4.87-1.28A10 10 0 1 0 19.05 4.94Zm-7.05 15.39a8.27 8.27 0 0 1-4.22-1.16l-.3-.18-2.89.76.77-2.82-.19-.3A8.34 8.34 0 1 1 12 20.33Zm4.58-6.26c-.25-.12-1.47-.73-1.7-.81-.23-.08-.39-.12-.56.12-.17.25-.64.81-.79.97-.14.17-.29.19-.54.06-.25-.12-1.04-.38-1.98-1.22-.73-.65-1.22-1.45-1.36-1.7-.14-.25-.02-.38.1-.5.11-.11.25-.29.37-.43.12-.14.17-.25.25-.41.08-.17.04-.31-.02-.43-.06-.12-.56-1.35-.76-1.85-.2-.48-.41-.42-.56-.43h-.48c-.17 0-.43.06-.66.31-.23.25-.87.85-.87 2.06s.89 2.39 1.02 2.56c.12.17 1.74 2.65 4.21 3.72.59.25 1.05.4 1.41.51.59.19 1.12.16 1.54.1.47-.07 1.47-.6 1.68-1.18.21-.58.21-1.08.14-1.18-.06-.11-.23-.17-.48-.29Z"/></svg>
                    WhatsApp
                </a>
                <a href="{{ $site['email_link'] }}" class="contact-email-link">{{ $site['email'] }}</a>
            </div>
        </div>

        <div>
            @if(session('status'))
                <div class="status-banner" role="status" aria-live="polite" data-toast-success="{{ session('status') }}">{{ session('status') }}</div>
            @endif
            @if($errors->any())
                <div class="status-banner status-banner-error" role="alert" data-toast-error="Please review the highlighted fields and try again.">
                    Please review the highlighted fields and try again.
                </div>
            @endif
            <x-site.contact-form />
        </div>
    </div>
</section>

{{-- ═══════════════════════ FAQ ═══════════════════════ --}}
<section class="section">
    <div class="container">
        <x-site.section-heading
            eyebrow="FAQ"
            title="A few answers before we talk."
            copy="This keeps the first conversation practical instead of circling around the same questions."
        />
        <div class="faq-list">
            @foreach($homeFaqItems as $item)
                <details class="panel faq-item" data-reveal>
                    <summary>{{ $item['question'] }}</summary>
                    <p>{{ $item['answer'] }}</p>
                </details>
            @endforeach
        </div>
    </div>
</section>

{{-- Back to top button --}}
<button class="back-to-top" id="back-to-top" aria-label="Back to top" data-back-top>
    <svg viewBox="0 0 24 24" aria-hidden="true"><path d="m18 15-6-6-6 6"/></svg>
</button>
@endsection
