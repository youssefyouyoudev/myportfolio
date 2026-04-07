@extends('layouts.app')

@section('content')
    @php
        $site = \App\Support\BrandContent::site(app()->getLocale());
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
                    <a href="#contact" class="btn btn-primary">{{ $page['nav']['start_project'] }}</a>
                    <a href="#projects" class="btn btn-secondary">{{ $site['actions']['view_projects'] }}</a>
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
                <div class="floating-card dashboard-card">
                    <div class="card-dots">
                        <span></span><span></span><span></span>
                    </div>
                    <div class="dashboard-head">
                        <strong>Growth Dashboard</strong>
                        <span>Live overview</span>
                    </div>
                    <div class="chart-bars">
                        <span style="height: 40%"></span>
                        <span style="height: 58%"></span>
                        <span style="height: 74%"></span>
                        <span style="height: 56%"></span>
                        <span style="height: 88%"></span>
                        <span style="height: 68%"></span>
                    </div>
                    <div class="dashboard-stats">
                        <div><small>MRR</small><strong>$18.4k</strong></div>
                        <div><small>Users</small><strong>1,284</strong></div>
                        <div><small>Growth</small><strong>+22%</strong></div>
                    </div>
                </div>

                <div class="floating-card code-card">
                    <div class="code-header">
                        <span class="code-chip">api</span>
                        <span class="code-chip">auth</span>
                    </div>
                    <pre><code>POST /v1/workflows
{
  "status": "ready",
  "scale": true,
  "secure": true
}</code></pre>
                </div>

                <div class="floating-card api-card">
                    <span class="api-label">Response</span>
                    <strong>200 OK</strong>
                    <p>Fast endpoints, clean structure, stable integrations.</p>
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

    <section class="section" id="services">
        <div class="container">
            <x-site.section-heading :eyebrow="$page['services_intro']['eyebrow']" :title="$page['services_intro']['title']" :copy="$page['services_intro']['copy']" />
            <div class="card-grid service-grid">
                @foreach($page['services'] as $service)
                    <article class="panel service-card" data-reveal>
                        <span class="service-icon">{{ $service['icon'] }}</span>
                        <h3>{{ $service['title'] }}</h3>
                        <p>{{ $service['description'] }}</p>
                        <strong>{{ $service['value'] }}</strong>
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

    <section class="section" id="projects">
        <div class="container">
            <x-site.section-heading :eyebrow="$page['projects_intro']['eyebrow']" :title="$page['projects_intro']['title']" :copy="$page['projects_intro']['copy']" />
            <div class="card-grid project-grid">
                @foreach($page['projects'] as $project)
                    <article class="panel project-card" data-reveal>
                        <div class="project-preview {{ $project['preview'] }}">
                            <div class="preview-surface">
                                <span></span>
                                <span></span>
                                <span></span>
                            </div>
                        </div>
                        <div class="project-copy">
                            <h3>{{ $project['title'] }}</h3>
                            <p>{{ $project['description'] }}</p>
                            <div class="stack-list">
                                @foreach($project['stack'] as $item)
                                    <span>{{ $item }}</span>
                                @endforeach
                            </div>
                        </div>
                    </article>
                @endforeach
            </div>
        </div>
    </section>

    <section class="section section-soft">
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
        </div>
    </section>

    <section class="section">
        <div class="container split-showcase">
            <div>
                <x-site.section-heading :eyebrow="$page['why_intro']['eyebrow']" :title="$page['why_intro']['title']" :copy="$page['why_intro']['copy']" />
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

    <section class="section final-cta">
        <div class="container">
            <div class="section-cta">
                <div>
                    <span class="eyebrow">{{ $page['final_cta']['eyebrow'] }}</span>
                    <h2>{{ $page['final_cta']['title'] }}</h2>
                    <p>{{ $page['final_cta']['copy'] }}</p>
                </div>
                <div class="cta-actions">
                    <a href="#contact" class="btn btn-primary">{{ $page['final_cta']['primary'] }}</a>
                    <a href="{{ $site['whatsapp_url'] }}" class="btn btn-secondary" target="_blank" rel="noopener">{{ $page['final_cta']['secondary'] }}</a>
                </div>
            </div>
        </div>
    </section>

    <section class="section" id="contact">
        <div class="container contact-layout">
            <div class="contact-column">
                <x-site.section-heading :eyebrow="$page['contact_intro']['eyebrow']" :title="$page['contact_intro']['title']" :copy="$page['contact_intro']['copy']" />
                <div class="panel contact-card">
                    <div class="contact-list">
                        <a href="{{ $site['email_link'] }}">{{ $site['email'] }}</a>
                        <a href="{{ $site['phone_link'] }}">{{ $site['phone'] }}</a>
                        <a href="{{ $site['whatsapp_url'] }}" target="_blank" rel="noopener">WhatsApp</a>
                        <a href="{{ $site['github_url'] }}" target="_blank" rel="noopener">GitHub</a>
                        <a href="{{ $site['linkedin_url'] }}" target="_blank" rel="noopener">LinkedIn</a>
                        <span>{{ $site['location'] }}</span>
                    </div>
                    <div class="contact-mini-proof">
                        @foreach($page['contact_badges'] as $badge)
                            <span>{{ $badge }}</span>
                        @endforeach
                    </div>
                </div>
            </div>
            <x-site.contact-form />
        </div>
    </section>
@endsection
