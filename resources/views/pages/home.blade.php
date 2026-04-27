@extends('layouts.app')

@push('structured-data')
    @foreach($homeStructuredData ?? [] as $schema)
        <script type="application/ld+json">{!! json_encode($schema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) !!}</script>
    @endforeach
@endpush

@section('content')
    @php
        $locale = app()->getLocale();
        $site = \App\Support\BrandContent::site($locale);
        $projects = collect($showcase['projects']);
        $featuredProjects = collect($showcase['featured_projects'] ?? $projects->take(3)->all())->filter()->values();
        $secondaryProjects = collect($showcase['secondary_projects'] ?? $projects->slice(3, 2)->all())->filter()->values();
    @endphp

    <section class="hero portfolio-hero">
        <div class="container hero-split-grid">
            <div class="hero-portrait-panel panel" data-reveal>
                <img
                    src="{{ asset('images/youssef-youyou.jpg') }}"
                    alt="Youssef Youyou, senior full-stack developer based in Nador, Morocco"
                    class="hero-portrait"
                    width="720"
                    height="880"
                    loading="eager"
                    fetchpriority="high"
                >
            </div>

            <div class="portfolio-hero-copy" data-reveal>
                <span class="eyebrow">Senior full-stack developer in Nador, Morocco</span>
                <h1>I turn business problems into software that ships.</h1>
                <p>I help Moroccan and international teams launch Laravel apps, conversion-focused websites, and internal systems that make sales, ops, and delivery move faster.</p>

                <p class="hero-intro-paragraph">I'm Youssef Youyou, a full-stack developer based in Nador who likes projects with real business constraints, messy workflows, and a clear before-and-after. I work best with founders, agencies, SMEs, and product teams that need one person to connect interface decisions to backend logic. The work I'm proudest of is shipping systems that remove manual steps, tighten the customer journey, and give a team something reliable to grow on. That could be a client-facing product, a booking flow, or the internal tool everyone depends on by Friday afternoon.</p>

                <div class="hero-actions">
                    <a href="{{ route('contact.create', ['locale' => $locale]) }}" class="btn btn-primary">Start a Project -&gt;</a>
                    <a href="{{ route('projects.index', ['locale' => $locale]) }}#featured-work" class="btn btn-secondary">See the Work &darr;</a>
                </div>

                <div class="availability-pill availability-pill-{{ $site['availability_badge']['state'] }}">
                    <strong>{{ $site['availability_badge']['label'] }}</strong>
                    <span>{{ $site['availability_badge']['detail'] }}</span>
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

    <section class="section trust-strip">
        <div class="container">
            @if($showClientLogos)
                <span class="eyebrow">Trusted by</span>
                <x-client-logos :items="$clientLogos" />
            @else
                <x-site.section-heading
                    eyebrow="Recent work includes"
                    title="The portfolio can stay credible even before every logo is publishable."
                    copy="Until there are at least three verified logos with permission to publish, this section stays focused on the types of products shipped."
                />
                <div class="stack-list">
                    @foreach($recentWorkTypes as $type)
                        <span>{{ $type }}</span>
                    @endforeach
                </div>
            @endif
        </div>
    </section>

    @if(collect($testimonials)->isNotEmpty())
        <section class="section section-soft">
            <div class="container">
                <x-site.section-heading
                    eyebrow="Client feedback"
                    title="What clients say once the work is in use."
                    copy="Only published testimonials with real approval appear here."
                />
                <x-testimonials :items="$testimonials" />
            </div>
        </section>
    @endif

    <section class="section" id="services">
        <div class="container">
            <x-site.section-heading
                eyebrow="What I build"
                title="Software shaped around sales friction, operations, and growth."
                copy="Each offer here is shorter on promises and clearer on outcomes, because the real signal is how the work changes the business after launch."
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
                eyebrow="Selected projects"
                title="Case studies with clients, context, and measurable outcomes."
                copy="The strongest portfolio pieces feel like work that had stakeholders, constraints, and something concrete to improve."
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
                                    <span class="case-badge">Under NDA - details available on request</span>
                                @elseif($project['is_concept'] ?? false)
                                    <span class="case-badge">Concept / Portfolio piece</span>
                                @endif
                            </div>

                            <h3>{{ $project['title'] }}</h3>
                            <p class="case-summary">{{ $project['summary'] }}</p>

                            <div class="case-meta-grid">
                                    @if($project['is_nda'] ?? false)
                                        <div>
                                            <strong>Access</strong>
                                            <p>Under NDA - details available on request.</p>
                                        </div>
                                    @else
                                        <div>
                                            <strong>Client</strong>
                                            <p>{{ $project['client'] ?? 'Private client' }}</p>
                                        </div>
                                        <div>
                                            <strong>Industry</strong>
                                            <p>{{ $project['client_industry'] ?? 'Digital product' }}</p>
                                        </div>
                                    @endif
                                </div>

                            <div class="case-meta-grid">
                                <div>
                                    <strong>{{ __('brand.common.problem') }}</strong>
                                    <p>{{ $project['challenge'] }}</p>
                                </div>
                                <div>
                                    <strong>{{ __('brand.common.solution') }}</strong>
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
                                    <a href="{{ $project['live_url'] }}" class="btn btn-secondary" target="_blank" rel="noopener noreferrer">View Live -&gt;</a>
                                @endif
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
                eyebrow="More work"
                title="Additional builds that show range without pretending every project is the same."
                copy="Some projects are quieter, more operational, or still under NDA. They still deserve honest framing."
            />

            <div class="portfolio-secondary-grid">
                @foreach($secondaryProjects as $project)
                    <article class="panel secondary-case-card case-theme-{{ $project['media']['theme'] ?? 'default' }}" data-reveal>
                        <div class="secondary-case-visual">
                            <x-site.project-frame :project="$project" compact />
                        </div>
                        <div class="project-copy">
                            <div class="case-study-meta-line">
                                <span class="eyebrow">{{ $project['label'] }}</span>
                                @if($project['is_nda'] ?? false)
                                    <span class="case-badge">Under NDA - details available on request</span>
                                @elseif($project['is_concept'] ?? false)
                                    <span class="case-badge">Concept / Portfolio piece</span>
                                @endif
                            </div>
                            <h3>{{ $project['title'] }}</h3>
                            <p>{{ $project['summary'] }}</p>
                            <p><strong>Result:</strong> {{ $project['result_headline'] ?? $project['outcome'] ?? 'A clearer project story with stronger business context.' }}</p>
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
                                @if(! empty($project['live_url']))
                                    <a href="{{ $project['live_url'] }}" class="text-link" target="_blank" rel="noopener noreferrer">View Live -&gt;</a>
                                @endif
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>
        </div>
    </section>

    <section class="section section-soft">
        <div class="container contact-layout">
            <div class="contact-column">
                <x-site.section-heading
                    eyebrow="Contact"
                    title="Tell me what needs fixing, shipping, or untangling."
                    copy="A short brief is enough to start. The fastest way to get a useful reply is to share the business goal, what is blocked today, and the timing that matters."
                />

                <article class="panel next-steps-panel">
                    <span class="eyebrow">What happens next</span>
                    <ol class="next-steps-list">
                        <li>I read your brief within 24h.</li>
                        <li>I reply with a clear next step.</li>
                        <li>We align on scope before any commitment.</li>
                    </ol>
                </article>
            </div>

            <x-site.contact-form />
        </div>
    </section>

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
@endsection

