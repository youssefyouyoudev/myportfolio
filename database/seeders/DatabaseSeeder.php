<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\Lead;
use App\Models\Post;
use App\Models\Project;
use App\Models\SeoMeta;
use App\Models\Service;
use App\Models\Tag;
use Illuminate\Support\Arr;
use Illuminate\Support\Carbon;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    use WithoutModelEvents;

    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        $this->seedAdmin();
        $this->seedTaxonomy();
        $this->seedServices();
        $this->seedProjects();
        $this->seedPosts();
        $this->seedLeads();
    }

    private function seedAdmin(): void
    {
        User::query()->firstOrCreate(
            ['email' => 'devonter@example.com'],
            [
                'name' => 'Youssef Devonter',
                'password' => bcrypt('password'),
            ]
        );
    }

    private function seedTaxonomy(): void
    {
        $categories = [
            ['name' => 'SaaS', 'slug' => 'saas', 'type' => 'project'],
            ['name' => 'E-commerce', 'slug' => 'ecommerce', 'type' => 'project'],
            ['name' => 'Consulting', 'slug' => 'consulting', 'type' => 'service'],
            ['name' => 'Strategy', 'slug' => 'strategy', 'type' => 'post'],
        ];

        foreach ($categories as $category) {
            Category::query()->firstOrCreate(['slug' => $category['slug']], $category);
        }

        $tags = [
            ['name' => 'Laravel', 'slug' => 'laravel', 'type' => 'project'],
            ['name' => 'React', 'slug' => 'react', 'type' => 'project'],
            ['name' => 'Next.js', 'slug' => 'nextjs', 'type' => 'project'],
            ['name' => 'Vue', 'slug' => 'vue', 'type' => 'project'],
            ['name' => 'TypeScript', 'slug' => 'typescript', 'type' => 'project'],
            ['name' => 'Kotlin', 'slug' => 'kotlin', 'type' => 'project'],
            ['name' => 'Android', 'slug' => 'android', 'type' => 'project'],
            ['name' => 'Python', 'slug' => 'python', 'type' => 'project'],
            ['name' => 'FastAPI', 'slug' => 'fastapi', 'type' => 'project'],
            ['name' => 'Django', 'slug' => 'django', 'type' => 'project'],
            ['name' => 'Flutter', 'slug' => 'flutter', 'type' => 'project'],
            ['name' => 'Electron', 'slug' => 'electron', 'type' => 'project'],
            ['name' => 'Go', 'slug' => 'go', 'type' => 'project'],
            ['name' => 'MySQL', 'slug' => 'mysql', 'type' => 'project'],
            ['name' => 'AWS', 'slug' => 'aws', 'type' => 'project'],
            ['name' => 'Azure', 'slug' => 'azure', 'type' => 'project'],
            ['name' => 'GCP', 'slug' => 'gcp', 'type' => 'project'],
            ['name' => 'PostgreSQL', 'slug' => 'postgresql', 'type' => 'project'],
            ['name' => 'MongoDB', 'slug' => 'mongodb', 'type' => 'project'],
            ['name' => 'Redis', 'slug' => 'redis', 'type' => 'project'],
            ['name' => 'RabbitMQ', 'slug' => 'rabbitmq', 'type' => 'project'],
            ['name' => 'Stripe', 'slug' => 'stripe', 'type' => 'service'],
            ['name' => 'Architecture', 'slug' => 'architecture', 'type' => 'post'],
        ];

        foreach ($tags as $tag) {
            Tag::query()->firstOrCreate(['slug' => $tag['slug']], $tag);
        }
    }

    private function seedServices(): void
    {
        $services = [
            [
                'title' => 'Custom SaaS Platforms',
                'slug' => 'custom-saas-platforms',
                'excerpt' => 'Design, build, and scale subscription products.',
                'body' => 'From product strategy to production-ready delivery, we build resilient SaaS systems on Laravel and Vue.',
                'status' => 'published',
                'price_from' => 8000,
                'position' => 1,
                'features' => ['Multi-tenant architecture', 'Usage billing', 'Observability & SRE'],
            ],
            [
                'title' => 'Enterprise Integrations',
                'slug' => 'enterprise-integrations',
                'excerpt' => 'Connect CRMs, ERPs, and billing providers.',
                'body' => 'API-first integrations with Stripe, HubSpot, Salesforce, and custom back-office systems.',
                'status' => 'published',
                'price_from' => 6000,
                'position' => 2,
                'features' => ['API orchestration', 'Data pipelines', 'Security & compliance'],
            ],
        ];

        foreach ($services as $service) {
            Service::query()->firstOrCreate(['slug' => $service['slug']], $service)->tags()->sync([3]);
        }
    }

    private function seedProjects(): void
    {
        $projects = [
            [
                'title' => 'MenaPay Billing Suite',
                'slug' => 'menapay-billing-suite',
                'excerpt' => 'Payments, subscriptions, and invoicing for regional SaaS.',
                'description' => 'A PCI-ready billing platform built with Laravel, Cashier, and Stripe Radar integrations.',
                'status' => 'published',
                'featured' => true,
                'live_url' => 'https://menapay.dev',
                'stack' => ['Laravel', 'MySQL', 'Redis', 'Vue', 'Stripe'],
                'tag_slugs' => ['laravel', 'vue', 'stripe', 'typescript'],
            ],
            [
                'title' => 'Atlas Logistics Portal',
                'slug' => 'atlas-logistics-portal',
                'excerpt' => 'Carrier and shipper portal with live tracking.',
                'description' => 'Multi-tenant portal with role-based access, analytics dashboards, and real-time ETA updates.',
                'status' => 'published',
                'featured' => false,
                'live_url' => 'https://atlas.dev',
                'stack' => ['Laravel', 'PostgreSQL', 'Livewire', 'Mapbox'],
                'tag_slugs' => ['laravel', 'postgresql', 'aws'],
            ],
            [
                'title' => 'OrbiPay FinOps Console',
                'slug' => 'orbipay-finops-console',
                'excerpt' => 'Usage-based billing, rev rec, and dunning automation.',
                'description' => 'FinOps cockpit with Stripe Billing, revenue recognition reports, and risk scoring.',
                'status' => 'published',
                'featured' => true,
                'live_url' => 'https://orbipay.dev',
                'stack' => ['Laravel', 'React', 'Stripe', 'PostgreSQL'],
                'tag_slugs' => ['laravel', 'react', 'stripe', 'postgresql'],
            ],
            [
                'title' => 'Relay IoT Fleet',
                'slug' => 'relay-iot-fleet',
                'excerpt' => 'Device telemetry, OTA updates, and alerts for industrial fleets.',
                'description' => 'Ingests MQTT streams, normalizes telemetry, and provides rules-based alerting.',
                'status' => 'published',
                'featured' => false,
                'stack' => ['Go', 'React', 'Timescale', 'MQTT', 'AWS'],
                'tag_slugs' => ['go', 'react', 'aws'],
            ],
            [
                'title' => 'Lumen Health Records',
                'slug' => 'lumen-health-records',
                'excerpt' => 'HIPAA-ready EHR with patient portal and e-prescriptions.',
                'description' => 'Audit trails, PHI encryption, and integrations with lab vendors and pharmacies.',
                'status' => 'published',
                'featured' => true,
                'stack' => ['Django', 'React', 'PostgreSQL', 'Redis'],
                'tag_slugs' => ['django', 'react', 'postgresql', 'redis'],
            ],
            [
                'title' => 'Quant Trading Desk',
                'slug' => 'quant-trading-desk',
                'excerpt' => 'Realtime risk dashboards and execution pipelines.',
                'description' => 'Low-latency feeds, order routing, and compliance reports for trading teams.',
                'status' => 'published',
                'featured' => false,
                'stack' => ['FastAPI', 'Next.js', 'WebSockets', 'Redis'],
                'tag_slugs' => ['fastapi', 'nextjs', 'typescript', 'redis'],
            ],
            [
                'title' => 'Nova Learning LMS',
                'slug' => 'nova-learning-lms',
                'excerpt' => 'Course authoring, SCORM, and cohort analytics.',
                'description' => 'Multi-tenant LMS with rich editor, assessments, and completion analytics.',
                'status' => 'published',
                'stack' => ['Laravel', 'Inertia', 'React', 'PostgreSQL'],
                'tag_slugs' => ['laravel', 'react', 'postgresql'],
            ],
            [
                'title' => 'Terra Delivery Tracker',
                'slug' => 'terra-delivery-tracker',
                'excerpt' => 'Last-mile logistics with live ETA and driver app.',
                'description' => 'Driver mobile app, dispatch console, and customer ETA tracking with push alerts.',
                'status' => 'published',
                'stack' => ['Kotlin', 'Android', 'Laravel', 'PostgreSQL'],
                'tag_slugs' => ['kotlin', 'android', 'laravel', 'postgresql'],
            ],
            [
                'title' => 'Harbor ERP Suite',
                'slug' => 'harbor-erp-suite',
                'excerpt' => 'Inventory, procurement, and finance for mid-market.',
                'description' => 'Modular ERP with approval workflows, BI exports, and audit-ready ledgers.',
                'status' => 'published',
                'featured' => true,
                'stack' => ['Laravel', 'Vue', 'MySQL', 'Redis'],
                'tag_slugs' => ['laravel', 'vue', 'mysql', 'redis'],
            ],
            [
                'title' => 'Alva Insights Dashboard',
                'slug' => 'alva-insights-dashboard',
                'excerpt' => 'Executive dashboards for revenue, churn, and NPS.',
                'description' => 'Data pipelines with dbt, warehouse modeling, and executive scorecards.',
                'status' => 'published',
                'stack' => ['Next.js', 'TypeScript', 'BigQuery', 'GCP'],
                'tag_slugs' => ['nextjs', 'typescript', 'gcp'],
            ],
            [
                'title' => 'Pulse Support Center',
                'slug' => 'pulse-support-center',
                'excerpt' => 'Omnichannel support with SLA tracking and AI assist.',
                'description' => 'Ticket routing, macros, and sentiment-driven prioritization.',
                'status' => 'published',
                'stack' => ['Laravel', 'React', 'PostgreSQL', 'RabbitMQ'],
                'tag_slugs' => ['laravel', 'react', 'rabbitmq', 'postgresql'],
            ],
            [
                'title' => 'Strata OKR',
                'slug' => 'strata-okr',
                'excerpt' => 'Objectives, key results, and reviews platform.',
                'description' => 'OKR cadences, confidence tracking, and cross-team alignment views.',
                'status' => 'published',
                'stack' => ['Laravel', 'Vue', 'MySQL'],
                'tag_slugs' => ['laravel', 'vue', 'mysql'],
            ],
            [
                'title' => 'Beacon Incident Response',
                'slug' => 'beacon-incident-response',
                'excerpt' => 'Runbooks, alerting, and post-mortems for SRE teams.',
                'description' => 'On-call rotations, incident rooms, and RCA timeline exports.',
                'status' => 'published',
                'featured' => true,
                'stack' => ['Go', 'Next.js', 'PostgreSQL', 'Redis'],
                'tag_slugs' => ['go', 'nextjs', 'postgresql', 'redis'],
            ],
            [
                'title' => 'Summit Booking Engine',
                'slug' => 'summit-booking-engine',
                'excerpt' => 'Ticketing, seating, and add-ons for events.',
                'description' => 'Seat maps, upsells, voucher campaigns, and payment orchestration.',
                'status' => 'published',
                'stack' => ['Laravel', 'React', 'Stripe', 'Redis'],
                'tag_slugs' => ['laravel', 'react', 'stripe', 'redis'],
            ],
            [
                'title' => 'Vector ML Workbench',
                'slug' => 'vector-ml-workbench',
                'excerpt' => 'Feature store, experiment tracking, and model registry.',
                'description' => 'Pipelines with MLFlow, feature catalogs, and model deployment hooks.',
                'status' => 'published',
                'stack' => ['FastAPI', 'React', 'PostgreSQL', 'Redis'],
                'tag_slugs' => ['fastapi', 'react', 'postgresql', 'redis'],
            ],
            [
                'title' => 'Cobalt Desktop POS',
                'slug' => 'cobalt-desktop-pos',
                'excerpt' => 'Offline-friendly POS for retail with rich peripherals.',
                'description' => 'Electron desktop app with local sync, printer/cash drawer integrations.',
                'status' => 'published',
                'stack' => ['Electron', 'TypeScript', 'SQLite', 'C# API'],
                'tag_slugs' => ['electron', 'typescript'],
            ],
            [
                'title' => 'Aurora Mobile Banking',
                'slug' => 'aurora-mobile-banking',
                'excerpt' => 'Digital wallet, KYC, and card management.',
                'description' => 'Kotlin app with biometric auth, card controls, and AML rule engine.',
                'status' => 'published',
                'featured' => true,
                'stack' => ['Kotlin', 'Android', 'Laravel', 'PostgreSQL'],
                'tag_slugs' => ['kotlin', 'android', 'laravel', 'postgresql'],
            ],
            [
                'title' => 'Neon Social Stream',
                'slug' => 'neon-social-stream',
                'excerpt' => 'High-scale feed with real-time reactions.',
                'description' => 'Fan-out service, rate limits, and moderation workflows.',
                'status' => 'published',
                'stack' => ['Go', 'Next.js', 'Redis', 'MongoDB'],
                'tag_slugs' => ['go', 'nextjs', 'redis', 'mongodb'],
            ],
            [
                'title' => 'Keystone Identity Hub',
                'slug' => 'keystone-identity-hub',
                'excerpt' => 'SSO, MFA, and provisioning for SaaS teams.',
                'description' => 'OIDC/SAML broker, SCIM provisioning, and adaptive MFA.',
                'status' => 'published',
                'stack' => ['Laravel', 'React', 'Redis', 'PostgreSQL'],
                'tag_slugs' => ['laravel', 'react', 'redis', 'postgresql'],
            ],
            [
                'title' => 'Alpine Field Service',
                'slug' => 'alpine-field-service',
                'excerpt' => 'Technician dispatch, work orders, and offline app.',
                'description' => 'Scheduling, route optimization, and offline-first mobile app.',
                'status' => 'published',
                'stack' => ['Flutter', 'Laravel', 'PostgreSQL'],
                'tag_slugs' => ['flutter', 'laravel', 'postgresql'],
            ],
            [
                'title' => 'Vertex Subscription Hub',
                'slug' => 'vertex-subscription-hub',
                'excerpt' => 'Catalog, pricing experiments, and entitlements.',
                'description' => 'Plan/catalog management, entitlement service, and customer-facing portal.',
                'status' => 'published',
                'stack' => ['Laravel', 'Next.js', 'Stripe', 'Redis'],
                'tag_slugs' => ['laravel', 'nextjs', 'stripe', 'redis'],
            ],
            [
                'title' => 'Prisma Research Portal',
                'slug' => 'prisma-research-portal',
                'excerpt' => 'Participant recruitment, screening, and scheduling.',
                'description' => 'Questionnaires, incentive payouts, and automated scheduling.',
                'status' => 'published',
                'stack' => ['Django', 'React', 'PostgreSQL'],
                'tag_slugs' => ['django', 'react', 'postgresql'],
            ],
            [
                'title' => 'Orbit Analytics SaaS',
                'slug' => 'orbit-analytics-saas',
                'excerpt' => 'Self-serve dashboards, embeddable widgets, and exports.',
                'description' => 'Multi-tenant analytics with row-level security and export pipelines.',
                'status' => 'published',
                'stack' => ['Laravel', 'Vue', 'ClickHouse', 'Redis'],
                'tag_slugs' => ['laravel', 'vue', 'redis'],
            ],
            [
                'title' => 'Forge DevPortal',
                'slug' => 'forge-devportal',
                'excerpt' => 'API docs, keys, and usage analytics.',
                'description' => 'Developer onboarding, API key issuance, and throttling controls.',
                'status' => 'published',
                'stack' => ['Next.js', 'TypeScript', 'Laravel API'],
                'tag_slugs' => ['nextjs', 'typescript', 'laravel'],
            ],
            [
                'title' => 'Helios Energy Monitor',
                'slug' => 'helios-energy-monitor',
                'excerpt' => 'Solar site monitoring with alerting and forecasting.',
                'description' => 'Inverter telemetry, outage alerts, and production forecasting models.',
                'status' => 'published',
                'stack' => ['FastAPI', 'React', 'Timescale', 'AWS'],
                'tag_slugs' => ['fastapi', 'react', 'aws'],
            ],
            [
                'title' => 'Monorail Supply Chain',
                'slug' => 'monorail-supply-chain',
                'excerpt' => 'Procurement, ASN, and warehouse workflows.',
                'description' => 'Supplier portal, ASN intake, inventory sync, and EDI adapters.',
                'status' => 'published',
                'stack' => ['Laravel', 'Vue', 'PostgreSQL', 'Redis'],
                'tag_slugs' => ['laravel', 'vue', 'postgresql', 'redis'],
            ],
            [
                'title' => 'Ripple Messaging Platform',
                'slug' => 'ripple-messaging-platform',
                'excerpt' => 'Secure messaging with E2E encryption and voice.',
                'description' => 'E2E encrypted chat, group calls, and compliance exports.',
                'status' => 'published',
                'stack' => ['Go', 'React Native', 'Redis', 'PostgreSQL'],
                'tag_slugs' => ['go', 'react', 'postgresql', 'redis'],
            ],
            [
                'title' => 'Falkor Inspections',
                'slug' => 'falkor-inspections',
                'excerpt' => 'Mobile inspections with photo annotations and reports.',
                'description' => 'Offline-first field app with report generation and client portal.',
                'status' => 'published',
                'stack' => ['Flutter', 'Laravel', 'PostgreSQL'],
                'tag_slugs' => ['flutter', 'laravel', 'postgresql'],
            ],
            [
                'title' => 'LumenPay Payroll',
                'slug' => 'lumenpay-payroll',
                'excerpt' => 'Multi-country payroll with tax rules and payouts.',
                'description' => 'Country-specific tax engines, contractor payouts, and approvals.',
                'status' => 'published',
                'stack' => ['Laravel', 'Vue', 'MySQL', 'Redis'],
                'tag_slugs' => ['laravel', 'vue', 'mysql', 'redis'],
            ],
            [
                'title' => 'Skyline Real Estate CRM',
                'slug' => 'skyline-realestate-crm',
                'excerpt' => 'Lead capture, listings, and deal pipelines.',
                'description' => 'Portal for agents with MLS sync, lead routing, and contract templates.',
                'status' => 'published',
                'stack' => ['Laravel', 'React', 'PostgreSQL'],
                'tag_slugs' => ['laravel', 'react', 'postgresql'],
            ],
            [
                'title' => 'Drift Video Collab',
                'slug' => 'drift-video-collab',
                'excerpt' => 'Async video reviews with annotations.',
                'description' => 'Video uploads, frame annotations, and shareable review links.',
                'status' => 'published',
                'stack' => ['Next.js', 'TypeScript', 'FFmpeg', 'Redis'],
                'tag_slugs' => ['nextjs', 'typescript', 'redis'],
            ],
        ];

        foreach ($projects as $project) {
            $model = Project::query()->firstOrCreate(['slug' => $project['slug']], Arr::except($project, ['tag_slugs']));

            $tagIds = Tag::query()
                ->whereIn('slug', $project['tag_slugs'] ?? [])
                ->pluck('id')
                ->all();

            if ($tagIds) {
                $model->tags()->sync($tagIds);
            }
        }
    }

    private function seedPosts(): void
    {
        $strategyCategoryId = Category::query()->where('slug', 'strategy')->value('id');
        $architectureTagId = Tag::query()->where('slug', 'architecture')->value('id');

        $posts = [
            [
                'title' => 'Scaling Laravel SaaS across regions',
                'slug' => 'scaling-laravel-saas-across-regions',
                'excerpt' => 'Caching, tenancy, and CI/CD lessons from production.',
                'body' => 'Pragmatic patterns for rolling out multi-region SaaS with queues, cache, and database topology choices.',
            ],
            [
                'title' => 'Designing pricing for B2B SaaS',
                'slug' => 'designing-pricing-for-b2b-saas',
                'excerpt' => 'Frameworks to align pricing with value.',
                'body' => 'How to map value metrics, billing cadence, and usage-based pricing to product outcomes.',
            ],
            [
                'title' => 'Shipping features without downtime',
                'slug' => 'shipping-features-without-downtime',
                'excerpt' => 'Release safely with feature flags and staged rollouts.',
                'body' => 'Use feature flags, dark launches, and canary deploys to ship continuously without disrupting customers.',
            ],
            [
                'title' => 'Building resilient queues with Redis',
                'slug' => 'building-resilient-queues-with-redis',
                'excerpt' => 'Prevent stuck jobs and retries gone wild.',
                'body' => 'Patterns for idempotent jobs, visibility timeouts, and backoff policies when using Redis queues.',
            ],
            [
                'title' => 'API design for multi-tenant apps',
                'slug' => 'api-design-for-multi-tenant-apps',
                'excerpt' => 'Keep tenants isolated while APIs stay ergonomic.',
                'body' => 'Namespace strategies, tenant context propagation, and auth design for multi-tenant APIs.',
            ],
            [
                'title' => 'Edge caching for global audiences',
                'slug' => 'edge-caching-for-global-audiences',
                'excerpt' => 'Cut TTFB with smart caching rules.',
                'body' => 'Leverage CDN rules, cache keys, and surrogate keys to serve fast across regions.',
            ],
            [
                'title' => 'Automating QA with Pest',
                'slug' => 'automating-qa-with-pest',
                'excerpt' => 'A lean testing stack for Laravel teams.',
                'body' => 'Set up fast unit, feature, and API tests with Pest and containers to keep regressions out.',
            ],
            [
                'title' => 'Observability checklist for Laravel',
                'slug' => 'observability-checklist-for-laravel',
                'excerpt' => 'Logs, traces, and metrics that matter.',
                'body' => 'What to instrument, how to sample, and alerting guardrails to keep Laravel apps healthy.',
            ],
            [
                'title' => 'Hardening auth and RBAC',
                'slug' => 'hardening-auth-and-rbac',
                'excerpt' => 'Stop privilege creep and session hijacks.',
                'body' => 'Session security, device binding, and role hygiene tips for production apps.',
            ],
            [
                'title' => 'Cost-optimizing AWS for Laravel',
                'slug' => 'cost-optimizing-aws-for-laravel',
                'excerpt' => 'Spend less while staying performant.',
                'body' => 'Use autoscaling, reserved capacity, and smarter cache/database sizing to trim bills.',
            ],
            [
                'title' => 'Zero-downtime database migrations',
                'slug' => 'zero-downtime-database-migrations',
                'excerpt' => 'Migrate safely under load.',
                'body' => 'Expand-contract patterns, background backfills, and lock-free schema changes that keep apps online.',
            ],
            [
                'title' => 'Email deliverability playbook',
                'slug' => 'email-deliverability-playbook',
                'excerpt' => 'Keep transactional mail out of spam.',
                'body' => 'SPF/DKIM/DMARC setup, warmup plans, and content rules for reliable deliverability.',
            ],
            [
                'title' => 'Content delivery with Vite and Laravel',
                'slug' => 'content-delivery-with-vite-and-laravel',
                'excerpt' => 'Ship fast frontends without bloat.',
                'body' => 'Bundle splitting, image optimization, and cache headers for Vite-powered Laravel apps.',
            ],
            [
                'title' => 'Localizing apps at scale',
                'slug' => 'localizing-apps-at-scale',
                'excerpt' => 'i18n without slowing delivery.',
                'body' => 'Locale detection, translation workflows, and content fallbacks for multilingual products.',
            ],
            [
                'title' => 'Docs-as-code for product teams',
                'slug' => 'docs-as-code-for-product-teams',
                'excerpt' => 'Keep docs in sync with releases.',
                'body' => 'Versioned docs, preview environments, and doc linting to keep knowledge current.',
            ],
            [
                'title' => 'Data modeling for event-driven apps',
                'slug' => 'data-modeling-for-event-driven-apps',
                'excerpt' => 'Design events your systems can grow with.',
                'body' => 'Event naming, schemas, and retention rules to keep downstream consumers stable.',
            ],
            [
                'title' => 'Contract testing microservices',
                'slug' => 'contract-testing-microservices',
                'excerpt' => 'Stop breaking your consumers.',
                'body' => 'Consumer-driven contracts, mocks, and CI gates to keep services interoperable.',
            ],
            [
                'title' => 'Performance budgets for frontends',
                'slug' => 'performance-budgets-for-frontends',
                'excerpt' => 'Guardrails to keep pages fast.',
                'body' => 'Define budgets for JS, images, and API calls with CI checks to prevent regressions.',
            ],
            [
                'title' => 'CI/CD pipeline blueprint',
                'slug' => 'cicd-pipeline-blueprint',
                'excerpt' => 'Ship daily with confidence.',
                'body' => 'Pipelines for linting, tests, security scans, and blue-green deploys that teams can trust.',
            ],
            [
                'title' => 'Incident response runbooks',
                'slug' => 'incident-response-runbooks',
                'excerpt' => 'Move from chaos to calm.',
                'body' => 'Templates for severity, comms, and remediation steps to shorten MTTR.',
            ],
        ];

        foreach ($posts as $index => $post) {
            $model = Post::query()->firstOrCreate(
                ['slug' => $post['slug']],
                array_merge([
                    'status' => 'published',
                    'category_id' => $strategyCategoryId,
                    'published_at' => Carbon::now()->subDays($index),
                ], $post)
            );

            if ($architectureTagId) {
                $model->tags()->sync([$architectureTagId]);
            }
        }
    }

    private function seedLeads(): void
    {
        Lead::query()->firstOrCreate([
            'email' => 'hello@client.com',
        ], [
            'name' => 'Sample Lead',
            'company' => 'Global Ventures',
            'budget' => '$15k - $30k',
            'message' => 'Looking for a Laravel partner to ship a SaaS MVP.',
            'locale' => 'en',
            'source' => 'seed',
        ]);
    }
}
