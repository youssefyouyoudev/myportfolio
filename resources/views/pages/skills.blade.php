@extends('layouts.app')

@section('content')
    @php
        $expertiseAreas = [
            ['title' => 'Software Engineering', 'items' => ['System design', 'Software architecture', 'Scalable backend design', 'Clean code practices', 'OOP', 'Design patterns', 'REST API design', 'Authentication and authorization', 'Debugging', 'Optimization']],
            ['title' => 'Frontend and UX', 'items' => ['Component-based UIs', 'Responsive design', 'Design systems', 'State management', 'Accessibility', 'Interactive dashboards', 'Forms', 'Data tables', 'Filtering and search UX', 'Motion and interface polish']],
            ['title' => 'Backend and Integrations', 'items' => ['Monolith and modular architectures', 'Queue systems', 'Background jobs', 'Caching', 'Rate limiting', 'API integrations', 'Payment integrations', 'Email workflows', 'Webhooks', 'Database modeling']],
            ['title' => 'DevOps and Infrastructure', 'items' => ['Linux servers', 'Nginx', 'VPS deployment', 'AWS and hosting environments', 'Domain and DNS', 'SSL', 'Backups', 'Environment management', 'Deployment pipelines', 'Server hardening basics']],
            ['title' => 'Data and AI', 'items' => ['Python automation', 'AI integrations', 'Prompt workflows', 'Deep learning familiarity', 'Data preprocessing', 'Experimentation mindset', 'Intelligent internal tools']],
            ['title' => 'Business and Product', 'items' => ['Discovery', 'Requirements gathering', 'Client communication', 'B2B and B2C thinking', 'Technical consulting', 'Solution selling', 'MVP planning', 'Product iteration']],
        ];
    @endphp

    <section class="inner-hero">
        <div class="container narrow">
            <span class="eyebrow">{{ $page['eyebrow'] }}</span>
            <h1 class="page-title">{{ $page['title'] }}</h1>
            <p class="page-copy">{{ $page['copy'] }}</p>
        </div>
    </section>

    <section class="section">
        <div class="container">
            <div class="card-grid three">
                @foreach($page['groups'] as $group)
                    <article class="panel feature-card">
                        <h2>{{ $group['title'] }}</h2>
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

    <section class="section section-soft">
        <div class="container">
            <x-site.section-heading eyebrow="Expertise Areas" title="Breadth is visible. Depth is in how the systems are built." copy="These are positioned as practical capabilities, strong working knowledge, and real delivery experience rather than inflated mastery claims." />
            <div class="card-grid three">
                @foreach($expertiseAreas as $area)
                    <article class="panel feature-card">
                        <h3>{{ $area['title'] }}</h3>
                        <ul class="simple-list">
                            @foreach($area['items'] as $item)
                                <li>{{ $item }}</li>
                            @endforeach
                        </ul>
                    </article>
                @endforeach
            </div>
        </div>
    </section>

    <section class="section">
        <div class="container">
            <x-site.section-heading eyebrow="Working Style" title="How the expertise shows up in real work." />
            <div class="card-grid four">
                @foreach($page['strengths'] as $strength)
                    <article class="panel feature-card">
                        <h3>{{ $strength['title'] }}</h3>
                        <p>{{ $strength['copy'] }}</p>
                    </article>
                @endforeach
            </div>
        </div>
    </section>
@endsection
