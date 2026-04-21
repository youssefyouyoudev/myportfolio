@extends('layouts.app')

@section('content')
    @php
        $locale = app()->getLocale();
        $site = \App\Support\BrandContent::site($locale);
        $homeUi = trans('brand.ui.home');
        $services = collect(\App\Support\BrandContent::serviceCatalog($locale))->values()->take(6);
        $featuredProjectSlugs = ['syncflow-social', 'business-management-platform', 'automation-dashboard-suite'];
        $featuredProjects = collect(\App\Support\BrandContent::projectCatalog($locale))
            ->filter(fn (array $project): bool => in_array($project['slug'], $featuredProjectSlugs, true))
            ->values();
        $spotlightProject = $featuredProjects->first();
        $supportingProjects = $featuredProjects->slice(1);
        $articles = collect(\App\Support\BrandContent::blogCatalog($locale))->values()->take(3);
        $problemCards = $homeUi['problems'];
        $resultCards = $homeUi['results'];
        $heroTrust = [
            $site['availability'],
            ...($homeUi['hero_trust'] ?? []),
        ];
        $contactProof = $homeUi['contact_expectation']['items'];
        $projectPreviewClasses = [
            'syncflow-social' => 'preview-saas',
            'business-management-platform' => 'preview-dashboard',
            'automation-dashboard-suite' => 'preview-api',
            'secure-auth-suite' => 'preview-school',
            'react-frontend-performance' => 'preview-mobile',
        ];
    @endphp

    <section class="hero landing-hero">
        <div class="container hero-grid">
            <div class="hero-copy" data-reveal>
                <span class="eyebrow">{{ $page['hero']['eyebrow'] }}</span>
                <h1>{{ $page['hero']['title'] }}</h1>
                <p>{{ $page['hero']['copy'] }}</p>

                <div class="hero-pills">
                    @foreach($page['hero']['pills'] as $pill)
                        <span>{{ $pill }}</span>
                    @endforeach
                </div>

                <div class="hero-actions">
                    <a href="{{ route('contact.create', ['locale' => $locale]) }}" class="btn btn-primary">{{ $page['nav']['start_project'] }}</a>
                    <a href="{{ route('projects.index', ['locale' => $locale]) }}" class="btn btn-secondary">{{ $site['actions']['view_projects'] }}</a>
                    <a href="{{ $site['whatsapp_url'] }}" class="btn btn-secondary" target="_blank" rel="noopener">{{ $site['actions']['whatsapp'] }}</a>
                </div>

                <div class="hero-trustline">
                    @foreach($heroTrust as $item)
                        <span>{{ $item }}</span>
                    @endforeach
                </div>

                <div class="hero-meta-grid">
                    @foreach($page['hero']['metrics'] as $metric)
                        <article class="metric-card">
                            <strong>{{ $metric['title'] }}</strong>
                            <span>{{ $metric['copy'] }}</span>
                        </article>
                    @endforeach
                </div>
            </div>

            <div class="hero-stage" aria-hidden="true">
                <div class="hero-stage-base panel">
                    <div class="stage-base-head">
                        <div>
                            <span class="eyebrow">{{ $homeUi['hero_stage']['eyebrow'] }}</span>
                            <strong>{{ $homeUi['hero_stage']['title'] }}</strong>
                        </div>
                        <span class="signal-dot"></span>
                    </div>
                    <div class="stage-strip">
                        @foreach($homeUi['hero_stage']['labels'] as $label)
                            <span>{{ $label }}</span>
                        @endforeach
                    </div>
                    <ul class="stage-list">
                        @foreach($homeUi['hero_stage']['items'] as $item)
                            <li>{{ $item }}</li>
                        @endforeach
                    </ul>
                </div>

                <div class="floating-card dashboard-card">
                    <div class="card-dots">
                        <span></span><span></span><span></span>
                    </div>
                    <div class="dashboard-head">
                        <strong>{{ $homeUi['hero_stage']['dashboard_title'] }}</strong>
                        <span>{{ $homeUi['hero_stage']['dashboard_subtitle'] }}</span>
                    </div>
                    <div class="chart-bars workflow-bars">
                        <span style="height: 44%"></span>
                        <span style="height: 62%"></span>
                        <span style="height: 84%"></span>
                        <span style="height: 68%"></span>
                        <span style="height: 90%"></span>
                        <span style="height: 76%"></span>
                    </div>
                    <div class="dashboard-stats">
                        @foreach($homeUi['hero_stage']['dashboard_stats'] as $stat)
                            <div><small>{{ $stat['label'] }}</small><strong>{{ $stat['value'] }}</strong></div>
                        @endforeach
                    </div>
                </div>

                <div class="floating-card code-card">
                    <div class="code-header">
                        <span class="code-chip">Laravel</span>
                        <span class="code-chip">React</span>
                    </div>
                    <pre><code>system.build({
  product: "business-ready",
  api: "clean",
  ui: "premium",
  deployment: "production"
})</code></pre>
                </div>

                <div class="floating-card api-card">
                    <span class="api-label">{{ $homeUi['hero_stage']['api_label'] }}</span>
                    <strong>{{ $homeUi['hero_stage']['api_title'] }}</strong>
                    <p>{{ $homeUi['hero_stage']['api_copy'] }}</p>
                    <div class="api-lines">
                        <span></span>
                        <span></span>
                        <span></span>
                    </div>
                </div>

                <div class="floating-card mobile-card">
                    <div class="mobile-notch"></div>
                    <div class="mobile-screen">
                        <span class="signal-dot"></span>
                        <div class="mobile-chart"></div>
                        <div class="mobile-list">
                            <span></span>
                            <span></span>
                            <span></span>
                        </div>
                    </div>
                </div>

                <div class="hero-gridline"></div>
            </div>
        </div>
    </section>

    <section class="section trust-strip" id="proof">
        <div class="container proof-strip">
            @foreach($page['proof_strip'] as $proof)
                <span>{{ $proof }}</span>
            @endforeach
        </div>
    </section>

    <section class="section">
        <div class="container">
            <x-site.section-heading :eyebrow="$homeUi['problem_intro']['eyebrow']" :title="$homeUi['problem_intro']['title']" :copy="$homeUi['problem_intro']['copy']" />
            <div class="card-grid problem-grid">
                @foreach($problemCards as $problem)
                    <article class="panel problem-card" data-reveal>
                        <h3>{{ $problem['title'] }}</h3>
                        <p>{{ $problem['copy'] }}</p>
                    </article>
                @endforeach
            </div>
        </div>
    </section>

    <section class="section section-soft" id="services">
        <div class="container">
            <x-site.section-heading :eyebrow="$page['services_intro']['eyebrow']" :title="$page['services_intro']['title']" :copy="$page['services_intro']['copy']" />
            <div class="card-grid service-grid">
                @foreach($services as $service)
                    <article class="panel service-card" data-reveal>
                        <span class="service-icon">{{ strtoupper(substr($service['title'], 0, 2)) }}</span>
                        <h3>{{ $service['title'] }}</h3>
                        <p>{{ $service['summary'] }}</p>
                        <strong>{{ $service['business_value'] }}</strong>
                        <a href="{{ route('services.show', ['locale' => $locale, 'service' => $service['slug']]) }}" class="text-link">Explore service</a>
                    </article>
                @endforeach
            </div>
            <div class="section-inline-cta">
                <p>{{ $homeUi['services_cta']['copy'] }}</p>
                <a href="{{ route('services.index', ['locale' => $locale]) }}" class="btn btn-secondary">{{ $site['actions']['view_services'] }}</a>
            </div>
        </div>
    </section>

    <section class="section" id="projects">
        <div class="container">
            <x-site.section-heading :eyebrow="$page['projects_intro']['eyebrow']" :title="$page['projects_intro']['title']" :copy="$page['projects_intro']['copy']" />

            @if($spotlightProject)
                <article class="panel project-spotlight" data-reveal>
                    <div class="spotlight-visual {{ $projectPreviewClasses[$spotlightProject['slug']] ?? 'preview-dashboard' }}">
                        <div class="preview-surface">
                            <span></span>
                            <span></span>
                            <span></span>
                        </div>
                    </div>
                    <div class="spotlight-copy">
                        <span class="eyebrow">{{ $spotlightProject['label'] }}</span>
                        <h3>{{ $spotlightProject['title'] }}</h3>
                        <p>{{ $spotlightProject['summary'] }}</p>
                        <div class="stack-list">
                            @foreach($spotlightProject['stack'] as $item)
                                <span>{{ $item }}</span>
                            @endforeach
                        </div>
                        <div class="spotlight-details">
                            <div>
                                <strong>{{ __('brand.common.challenge') }}</strong>
                                <p>{{ $spotlightProject['challenge'] }}</p>
                            </div>
                            <div>
                                <strong>{{ __('brand.common.solution') }}</strong>
                                <p>{{ $spotlightProject['solution'] }}</p>
                            </div>
                        </div>
                        <div class="project-footer">
                            <p>{{ $spotlightProject['note'] }}</p>
                            <a href="{{ route('projects.show', ['locale' => $locale, 'project' => $spotlightProject['slug']]) }}" class="btn btn-primary">{{ $site['actions']['view_case_study'] }}</a>
                        </div>
                    </div>
                </article>
            @endif

            <div class="card-grid project-grid compact-project-grid">
                @foreach($supportingProjects as $project)
                    <article class="panel project-card" data-reveal>
                        <div class="project-preview {{ $projectPreviewClasses[$project['slug']] ?? 'preview-dashboard' }}">
                            <div class="preview-surface">
                                <span></span>
                                <span></span>
                                <span></span>
                            </div>
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
                            <p><strong>{{ __('brand.common.outcome') }}:</strong> {{ $project['outcome'] }}</p>
                            <a href="{{ route('projects.show', ['locale' => $locale, 'project' => $project['slug']]) }}" class="text-link">{{ $site['actions']['view_case_study'] }}</a>
                        </div>
                    </article>
                @endforeach
            </div>
        </div>
    </section>

    <section class="section section-soft">
        <div class="container">
            <x-site.section-heading :eyebrow="$homeUi['results_intro']['eyebrow']" :title="$homeUi['results_intro']['title']" :copy="$homeUi['results_intro']['copy']" />
            <div class="card-grid result-grid">
                @foreach($resultCards as $result)
                    <article class="panel result-card" data-reveal>
                        <h3>{{ $result['title'] }}</h3>
                        <p>{{ $result['copy'] }}</p>
                    </article>
                @endforeach
            </div>
        </div>
    </section>

    <section class="section">
        <div class="container split-showcase">
            <div class="content-stack">
                <x-site.section-heading :eyebrow="$page['why_intro']['eyebrow']" :title="$page['why_intro']['title']" :copy="$page['why_intro']['copy']" />
                <article class="panel about-value-card" data-reveal>
                    <h3>{{ $homeUi['about_value']['title'] }}</h3>
                    <p>{{ $homeUi['about_value']['copy'] }}</p>
                    <div class="stack-list">
                        @foreach($homeUi['about_value']['pills'] as $pill)
                            <span>{{ $pill }}</span>
                        @endforeach
                    </div>
                </article>
            </div>
            <div class="reason-grid">
                @foreach($page['reasons'] as $reason)
                    <article class="panel reason-card" data-reveal>
                        <h3>{{ $reason['title'] }}</h3>
                        <p>{{ $reason['copy'] }}</p>
                    </article>
                @endforeach
            </div>
        </div>
    </section>

    <section class="section section-soft" id="stack">
        <div class="container">
            <x-site.section-heading :eyebrow="$page['stack_intro']['eyebrow']" :title="$page['stack_intro']['title']" :copy="$page['stack_intro']['copy']" />
            <div class="stack-grid">
                @foreach($page['stack_groups'] as $group)
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

    <section class="section">
        <div class="container">
            <x-site.section-heading :eyebrow="$page['authority_intro']['eyebrow']" :title="$page['authority_intro']['title']" :copy="$page['authority_intro']['copy']" />
            <div class="proof-grid">
                @foreach($page['stats'] as $stat)
                    <article class="panel stat-card" data-reveal>
                        <strong><span data-counter="{{ $stat['value'] }}">0</span>{{ $stat['suffix'] }}</strong>
                        <span>{{ $stat['label'] }}</span>
                    </article>
                @endforeach
            </div>

            <div class="trust-summary-grid">
                @foreach($homeUi['trust_cards'] as $card)
                    <article class="panel trust-summary-card" data-reveal>
                        <span class="eyebrow">{{ $card['eyebrow'] }}</span>
                        <h3>{{ $card['title'] }}</h3>
                        <p>{{ $card['copy'] }}</p>
                    </article>
                @endforeach
            </div>
        </div>
    </section>

    <section class="section section-soft" id="process">
        <div class="container">
            <x-site.section-heading :eyebrow="$page['process_intro']['eyebrow']" :title="$page['process_intro']['title']" :copy="$page['process_intro']['copy']" />
            <div class="process-grid">
                @foreach($page['process'] as $item)
                    <article class="panel process-card" data-reveal>
                        <span class="process-step">{{ $item['step'] }}</span>
                        <h3>{{ $item['title'] }}</h3>
                        <p>{{ $item['copy'] }}</p>
                    </article>
                @endforeach
            </div>
        </div>
    </section>

    <section class="section">
        <div class="container">
            <x-site.section-heading :eyebrow="$homeUi['insights_intro']['eyebrow']" :title="$homeUi['insights_intro']['title']" :copy="$homeUi['insights_intro']['copy']" />
            <div class="card-grid insight-grid">
                @foreach($articles as $article)
                    <article class="panel insight-card" data-reveal>
                        <span class="insight-meta">{{ $article['published_at'] }}</span>
                        <h3>{{ $article['title'] }}</h3>
                        <p>{{ $article['excerpt'] }}</p>
                        <a href="{{ route('blog.show', ['locale' => $locale, 'slug' => $article['slug']]) }}" class="text-link">{{ $site['actions']['read_article'] }}</a>
                    </article>
                @endforeach
            </div>
        </div>
    </section>

    <section class="section section-soft">
        <div class="container">
            <x-site.section-heading :eyebrow="$page['faq_intro']['eyebrow']" :title="$page['faq_intro']['title']" :copy="$page['faq_intro']['copy']" />
            <div class="faq-list">
                @foreach($page['faq'] as $item)
                    <details class="panel faq-item" data-reveal>
                        <summary>{{ $item['question'] }}</summary>
                        <p>{{ $item['answer'] }}</p>
                    </details>
                @endforeach
            </div>
        </div>
    </section>

    <section class="section final-cta">
        <div class="container">
            <div class="section-cta">
                <div>
                    <span class="eyebrow">{{ $page['final_cta']['eyebrow'] }}</span>
                    <h2>{{ $page['final_cta']['title'] }}</h2>
                    <p>{{ $page['final_cta']['copy'] }}</p>
                </div>
                <div class="cta-actions">
                    <a href="{{ route('contact.create', ['locale' => $locale]) }}" class="btn btn-primary">{{ $page['final_cta']['primary'] }}</a>
                    <a href="{{ $site['whatsapp_url'] }}" class="btn btn-secondary" target="_blank" rel="noopener">{{ $page['final_cta']['secondary'] }}</a>
                </div>
            </div>
        </div>
    </section>

    <section class="section" id="contact">
        <div class="container contact-layout">
            <div class="contact-column">
                <x-site.section-heading :eyebrow="$page['contact_intro']['eyebrow']" :title="$page['contact_intro']['title']" :copy="$page['contact_intro']['copy']" />
                <div class="contact-direct-grid">
                    @foreach($homeUi['contact_cards'] as $index => $card)
                        @php
                            $cardValue = match ($card['value']) {
                                'email' => $site['email'],
                                'phone' => $site['phone'],
                                default => $card['value'],
                            };
                            $cardHref = match ($index) {
                                0 => $site['email_link'],
                                1 => $site['whatsapp_url'],
                                2 => $site['linkedin_url'],
                                default => '#',
                            };
                        @endphp
                        <a href="{{ $cardHref }}" class="panel direct-link-card" @if(str_starts_with($cardHref, 'http')) target="_blank" rel="noopener" @endif data-reveal>
                            <span>{{ $card['label'] }}</span>
                            <strong>{{ $cardValue }}</strong>
                            <p>{{ $card['copy'] }}</p>
                        </a>
                    @endforeach
                    <article class="panel contact-expectation" data-reveal>
                        <span class="eyebrow">{{ $homeUi['contact_expectation']['eyebrow'] }}</span>
                        <h3>{{ $homeUi['contact_expectation']['title'] }}</h3>
                        <ul class="simple-list">
                            @foreach($contactProof as $item)
                                <li>{{ $item }}</li>
                            @endforeach
                        </ul>
                    </article>
                </div>
            </div>
            <x-site.contact-form />
        </div>
    </section>
@endsection
