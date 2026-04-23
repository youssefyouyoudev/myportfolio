@extends('layouts.app')

@section('content')
    @php
        $locale = app()->getLocale();
        $site = \App\Support\BrandContent::site($locale);
        $projects = collect($showcase['projects']);
        $featuredProjects = collect([
            $projects->firstWhere('slug', 'ecarsauto'),
            $projects->firstWhere('slug', 'rifimedia-tv'),
            $projects->firstWhere('slug', 'waslacrm'),
        ])->filter();
        $secondaryProjects = collect([
            $projects->firstWhere('slug', 'erp-plus'),
            $projects->firstWhere('slug', 'invoix'),
        ])->filter();
    @endphp

    <section class="hero portfolio-hero">
        <div class="container portfolio-hero-grid">
            <div class="portfolio-hero-copy" data-reveal>
                <span class="eyebrow">{{ $showcase['hero']['eyebrow'] }}</span>
                <h1>{{ $showcase['hero']['title'] }}</h1>
                <p>{{ $showcase['hero']['copy'] }}</p>

                <div class="hero-pills portfolio-pills">
                    @foreach($showcase['hero']['pills'] as $pill)
                        <span>{{ $pill }}</span>
                    @endforeach
                </div>

                <div class="hero-actions">
                    <a href="{{ route('contact.create', ['locale' => $locale]) }}" class="btn btn-primary">{{ $showcase['hero']['actions']['primary'] }}</a>
                    <a href="#featured-work" class="btn btn-secondary">{{ $showcase['hero']['actions']['secondary'] }}</a>
                    <a href="{{ $site['whatsapp_url'] }}" class="btn btn-secondary" target="_blank" rel="noopener">{{ $showcase['hero']['actions']['tertiary'] }}</a>
                </div>

                <div class="portfolio-trust-list">
                    @foreach($showcase['hero']['trust'] as $item)
                        <span>{{ $item }}</span>
                    @endforeach
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

            <div class="portfolio-hero-stage" data-reveal>
                <div class="hero-stage-panel hero-stage-primary">
                    <img
                        src="{{ asset('images/projects/ecarsauto-case-study.png') }}"
                        alt="eCarsAuto premium SaaS showcase"
                        loading="eager"
                        fetchpriority="high"
                    >
                </div>

                <div class="hero-stage-panel hero-stage-secondary">
                    <img
                        src="{{ asset('images/projects/rifimedia-tv-ui.png') }}"
                        alt="Rifi Media TV interface mockup"
                        loading="lazy"
                    >
                </div>

                <div class="hero-stage-note panel">
                    <span class="eyebrow">Real project proof</span>
                    <h2>From landing pages to internal systems.</h2>
                    <p>The portfolio now leads with actual products, brand systems, dashboards, and SaaS directions instead of generic placeholders.</p>
                </div>
            </div>
        </div>
    </section>

    <section class="section trust-strip">
        <div class="container portfolio-strip">
            @foreach($showcase['trust_strip'] as $item)
                <span>{{ $item }}</span>
            @endforeach
        </div>
    </section>

    <section class="section" id="services">
        <div class="container">
            <x-site.section-heading
                eyebrow="What I build"
                title="A stronger offer for businesses that need more than a simple portfolio site."
                copy="The value is not only clean code. It is clearer positioning, better user flow, and software that supports the business after the first launch."
            />

            <div class="portfolio-service-grid">
                @foreach($showcase['services'] as $service)
                    <article class="panel portfolio-service-card" data-reveal>
                        <span class="eyebrow">{{ $service['title'] }}</span>
                        <h3>{{ $service['value'] }}</h3>
                        <p>{{ $service['copy'] }}</p>
                    </article>
                @endforeach
            </div>
        </div>
    </section>

    <section class="section section-soft" id="featured-work">
        <div class="container">
            <x-site.section-heading
                eyebrow="Featured work"
                title="Case studies that present the work like real products."
                copy="Each flagship project now carries a sharper story: what it solves, who it serves, how it is positioned, and why the build feels commercially credible."
            />

            <div class="case-study-stack">
                @foreach($featuredProjects as $index => $project)
                    <article class="panel case-study-block case-theme-{{ $project['media']['theme'] ?? 'default' }}" data-reveal>
                        <div class="case-study-media @if($index % 2 === 1) is-reversed @endif">
                            <div class="case-study-frame">
                                @if(isset($project['media']['logo']['src']))
                                    <div class="case-study-logo-surface">
                                        <img src="{{ $project['media']['logo']['src'] }}" alt="{{ $project['media']['logo']['alt'] }}" loading="lazy">
                                    </div>
                                @endif

                                @if(isset($project['media']['cover']['src']))
                                    <div class="case-study-image">
                                        <img src="{{ $project['media']['cover']['src'] }}" alt="{{ $project['media']['cover']['alt'] }}" loading="lazy">
                                    </div>
                                @else
                                    <div class="case-study-placeholder case-study-placeholder-{{ $project['media']['theme'] ?? 'default' }}">
                                        <div class="placeholder-window">
                                            <span></span>
                                            <span></span>
                                            <span></span>
                                        </div>
                                        <div class="placeholder-chart">
                                            <i></i><i></i><i></i><i></i>
                                        </div>
                                        <div class="placeholder-list">
                                            <span></span>
                                            <span></span>
                                            <span></span>
                                        </div>
                                    </div>
                                @endif
                            </div>
                        </div>

                        <div class="case-study-copy">
                            <span class="eyebrow">{{ $project['label'] }}</span>
                            <h3>{{ $project['title'] }}</h3>
                            <p class="case-summary">{{ $project['summary'] }}</p>

                            <div class="case-meta-grid">
                                <div>
                                    <strong>{{ __('brand.common.problem') }}</strong>
                                    <p>{{ $project['challenge'] }}</p>
                                </div>
                                <div>
                                    <strong>{{ __('brand.common.built_for') }}</strong>
                                    <p>{{ $project['audience'] }}</p>
                                </div>
                            </div>

                            <div class="case-meta-grid">
                                <div>
                                    <strong>{{ __('brand.common.solution') }}</strong>
                                    <p>{{ $project['solution'] }}</p>
                                </div>
                                <div>
                                    <strong>{{ __('brand.common.role') }}</strong>
                                    <p>{{ $project['role'] }}</p>
                                </div>
                            </div>

                            <div class="stack-list">
                                @foreach($project['stack'] as $item)
                                    <span>{{ $item }}</span>
                                @endforeach
                            </div>

                            <div class="case-metric-row">
                                @foreach($project['metrics'] as $metric)
                                    <div class="case-metric-card">
                                        <strong>{{ $metric['value'] }}</strong>
                                        <span>{{ $metric['label'] }}</span>
                                    </div>
                                @endforeach
                            </div>

                            <ul class="simple-list case-feature-list">
                                @foreach($project['features'] as $feature)
                                    <li>{{ $feature }}</li>
                                @endforeach
                            </ul>

                            <div class="case-study-actions">
                                <a href="{{ route('projects.show', ['locale' => $locale, 'project' => $project['slug']]) }}" class="btn btn-primary">{{ $site['actions']['view_case_study'] }}</a>
                                <p>{{ $project['outcome'] }}</p>
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>
        </div>
    </section>

    <section class="section">
        <div class="container">
            <x-site.section-heading
                eyebrow="More systems"
                title="Additional product directions that show breadth beyond one niche."
                copy="These projects help position you clearly for CRM, ERP, invoicing, operations, and internal software work alongside the more visual flagship builds."
            />

            <div class="portfolio-secondary-grid">
                @foreach($secondaryProjects as $project)
                    <article class="panel secondary-case-card case-theme-{{ $project['media']['theme'] ?? 'default' }}" data-reveal>
                        <div class="secondary-case-visual">
                            @if(isset($project['media']['cover']['src']))
                                <div class="case-study-frame">
                                    @if(isset($project['media']['logo']['src']))
                                        <div class="case-study-logo-surface">
                                            <img src="{{ $project['media']['logo']['src'] }}" alt="{{ $project['media']['logo']['alt'] }}" loading="lazy">
                                        </div>
                                    @endif

                                    <div class="case-study-image compact">
                                        <img src="{{ $project['media']['cover']['src'] }}" alt="{{ $project['media']['cover']['alt'] }}" loading="lazy">
                                    </div>
                                </div>
                            @else
                                <div class="case-study-placeholder case-study-placeholder-{{ $project['media']['theme'] ?? 'default' }}">
                                    <div class="placeholder-window">
                                        <span></span>
                                        <span></span>
                                        <span></span>
                                    </div>
                                    <div class="placeholder-table">
                                        <span></span>
                                        <span></span>
                                        <span></span>
                                        <span></span>
                                    </div>
                                </div>
                            @endif
                        </div>
                        <div class="project-copy">
                            <span class="eyebrow">{{ $project['label'] }}</span>
                            <h3>{{ $project['title'] }}</h3>
                            <p>{{ $project['summary'] }}</p>
                            <div class="stack-list">
                                @foreach($project['stack'] as $item)
                                    <span>{{ $item }}</span>
                                @endforeach
                            </div>
                            <p><strong>{{ __('brand.common.problem') }}:</strong> {{ $project['challenge'] }}</p>
                            <p><strong>{{ __('brand.common.solution') }}:</strong> {{ $project['solution'] }}</p>
                            <a href="{{ route('projects.show', ['locale' => $locale, 'project' => $project['slug']]) }}" class="text-link">{{ $site['actions']['view_case_study'] }}</a>
                        </div>
                    </article>
                @endforeach
            </div>
        </div>
    </section>

    <section class="section section-soft">
        <div class="container">
            <x-site.section-heading
                eyebrow="Why clients hire me"
                title="The portfolio now positions you as a partner who can own both the polish and the system."
                copy="The strongest lead-generation portfolios remove doubt quickly: strong visuals, sharp business framing, and clear signals that the developer understands real operations."
            />

            <div class="portfolio-proof-grid">
                @foreach($showcase['proof'] as $card)
                    <article class="panel portfolio-proof-card" data-reveal>
                        <h3>{{ $card['title'] }}</h3>
                        <p>{{ $card['copy'] }}</p>
                    </article>
                @endforeach
            </div>

            <div class="portfolio-why-grid">
                @foreach($showcase['why'] as $item)
                    <article class="panel reason-card" data-reveal>
                        <h3>{{ $item['title'] }}</h3>
                        <p>{{ $item['copy'] }}</p>
                    </article>
                @endforeach
            </div>
        </div>
    </section>

    <section class="section" id="stack">
        <div class="container split-showcase portfolio-stack-layout">
            <div>
                <x-site.section-heading
                    eyebrow="Tech stack"
                    title="A practical stack for websites, dashboards, SaaS products, and internal tools."
                    copy="You are not being positioned as a generic coder. You are being positioned as someone who can ship business-ready systems across frontend, backend, database, and deployment layers."
                />
            </div>

            <div class="stack-grid">
                @foreach($showcase['stack'] as $group)
                    <article class="panel stack-card" data-reveal>
                        <h3>{{ $group['title'] }}</h3>
                        <div class="stack-list">
                            @foreach($group['items'] as $item)
                                <span>{{ $item }}</span>
                            @endforeach
                        </div>
                    </article>
                @endforeach
            </div>
        </div>
    </section>

    <section class="section section-soft" id="process">
        <div class="container">
            <x-site.section-heading
                eyebrow="Process"
                title="A straightforward build process that makes the work feel premium from the first conversation."
                copy="Good projects usually win before launch because the positioning, structure, and delivery quality are clear early."
            />

            <div class="process-grid">
                @foreach($showcase['process'] as $item)
                    <article class="panel process-card" data-reveal>
                        <span class="process-step">{{ $item['step'] }}</span>
                        <h3>{{ $item['title'] }}</h3>
                        <p>{{ $item['copy'] }}</p>
                    </article>
                @endforeach
            </div>
        </div>
    </section>

    <section class="section final-cta">
        <div class="container">
            <div class="section-cta portfolio-banner">
                <div>
                    <span class="eyebrow">{{ $showcase['cta']['eyebrow'] }}</span>
                    <h2>{{ $showcase['cta']['title'] }}</h2>
                    <p>{{ $showcase['cta']['copy'] }}</p>
                </div>
                <div class="cta-actions">
                    <a href="{{ route('contact.create', ['locale' => $locale]) }}" class="btn btn-primary">{{ $site['actions']['contact_me'] }}</a>
                    <a href="{{ $site['whatsapp_url'] }}" class="btn btn-secondary" target="_blank" rel="noopener">{{ $site['actions']['whatsapp'] }}</a>
                </div>
            </div>
        </div>
    </section>

    <section class="section" id="contact">
        <div class="container contact-layout">
            <div class="contact-column">
                <x-site.section-heading
                    eyebrow="Contact"
                    title="Tell me what you want to build and I will reply with a practical next step."
                    copy="Best fit for businesses that need a premium website, a custom web app, a dashboard, SaaS direction, or a stronger internal system."
                />

                <div class="contact-direct-grid portfolio-contact-grid">
                    <a href="{{ $site['email_link'] }}" class="panel direct-link-card" data-reveal>
                        <span>Email</span>
                        <strong>{{ $site['email'] }}</strong>
                        <p>Best for detailed briefs, scope, budget, and project context.</p>
                    </a>

                    <a href="{{ $site['whatsapp_url'] }}" class="panel direct-link-card" target="_blank" rel="noopener" data-reveal>
                        <span>WhatsApp</span>
                        <strong>{{ $site['phone'] }}</strong>
                        <p>Best for fast intake when you want to move quickly.</p>
                    </a>

                    <a href="{{ $site['linkedin_url'] }}" class="panel direct-link-card" target="_blank" rel="noopener" data-reveal>
                        <span>LinkedIn</span>
                        <strong>Professional profile</strong>
                        <p>Useful for agencies, hiring teams, and international opportunities.</p>
                    </a>

                    <article class="panel contact-expectation" data-reveal>
                        <span class="eyebrow">Best fit</span>
                        <h3>Businesses that need strong execution, not filler design.</h3>
                        <ul class="simple-list">
                            <li>Business websites and landing pages</li>
                            <li>Dashboards, CRM, ERP, and internal tools</li>
                            <li>SaaS concepts that need to feel product-ready fast</li>
                        </ul>
                    </article>
                </div>
            </div>

            <x-site.contact-form />
        </div>
    </section>
@endsection
