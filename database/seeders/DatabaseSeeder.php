<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\Category;
use App\Models\ClientLogo;
use App\Models\Lead;
use App\Models\Post;
use App\Models\Project;
use App\Models\SeoMeta;
use App\Models\Service;
use App\Models\Tag;
use App\Models\Testimonial;
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
        $this->seedTestimonials();
        $this->seedClientLogos();
        $this->seedLeads();
        $this->seedSeoMeta();
    }

    // -------------------------------------------------------------------------
    // Admin
    // -------------------------------------------------------------------------

    private function seedAdmin(): void
    {
        User::query()->updateOrCreate(
            ['email' => 'contact@youssefyouyou.com'],
            [
                'name'     => 'Youssef Youyou',
                'password' => bcrypt('Youssef@0812'),
                'is_admin' => true,
            ]
        );
    }

    // -------------------------------------------------------------------------
    // Taxonomy — Categories & Tags
    // -------------------------------------------------------------------------

    private function seedTaxonomy(): void
    {
        $categories = [
            // project categories
            ['name' => 'SaaS',         'slug' => 'saas',         'type' => 'project'],
            ['name' => 'FinTech',       'slug' => 'fintech',       'type' => 'project'],
            ['name' => 'E-commerce',    'slug' => 'ecommerce',     'type' => 'project'],
            ['name' => 'Logistics',     'slug' => 'logistics',     'type' => 'project'],
            ['name' => 'HealthTech',    'slug' => 'healthtech',    'type' => 'project'],
            ['name' => 'IoT',           'slug' => 'iot',           'type' => 'project'],
            ['name' => 'Mobile',        'slug' => 'mobile',        'type' => 'project'],
            ['name' => 'Desktop',       'slug' => 'desktop',       'type' => 'project'],
            // service categories
            ['name' => 'Consulting',    'slug' => 'consulting',    'type' => 'service'],
            ['name' => 'Development',   'slug' => 'development',   'type' => 'service'],
            // blog categories
            ['name' => 'Strategy',      'slug' => 'strategy',      'type' => 'post'],
            ['name' => 'Architecture',  'slug' => 'architecture-cat', 'type' => 'post'],
            ['name' => 'DevOps',        'slug' => 'devops',        'type' => 'post'],
            ['name' => 'Performance',   'slug' => 'performance',   'type' => 'post'],
        ];

        foreach ($categories as $cat) {
            Category::query()->firstOrCreate(['slug' => $cat['slug']], $cat);
        }

        $tags = [
            // languages & frameworks
            ['name' => 'Laravel',        'slug' => 'laravel',        'type' => 'project'],
            ['name' => 'React',          'slug' => 'react',          'type' => 'project'],
            ['name' => 'Next.js',        'slug' => 'nextjs',         'type' => 'project'],
            ['name' => 'Vue',            'slug' => 'vue',            'type' => 'project'],
            ['name' => 'TypeScript',     'slug' => 'typescript',     'type' => 'project'],
            ['name' => 'Kotlin',         'slug' => 'kotlin',         'type' => 'project'],
            ['name' => 'Android',        'slug' => 'android',        'type' => 'project'],
            ['name' => 'Python',         'slug' => 'python',         'type' => 'project'],
            ['name' => 'FastAPI',        'slug' => 'fastapi',        'type' => 'project'],
            ['name' => 'Django',         'slug' => 'django',         'type' => 'project'],
            ['name' => 'Flutter',        'slug' => 'flutter',        'type' => 'project'],
            ['name' => 'Electron',       'slug' => 'electron',       'type' => 'project'],
            ['name' => 'Go',             'slug' => 'go',             'type' => 'project'],
            // databases
            ['name' => 'MySQL',          'slug' => 'mysql',          'type' => 'project'],
            ['name' => 'PostgreSQL',     'slug' => 'postgresql',     'type' => 'project'],
            ['name' => 'MongoDB',        'slug' => 'mongodb',        'type' => 'project'],
            ['name' => 'Redis',          'slug' => 'redis',          'type' => 'project'],
            ['name' => 'RabbitMQ',       'slug' => 'rabbitmq',       'type' => 'project'],
            // cloud & infra
            ['name' => 'AWS',            'slug' => 'aws',            'type' => 'project'],
            ['name' => 'Azure',          'slug' => 'azure',          'type' => 'project'],
            ['name' => 'GCP',            'slug' => 'gcp',            'type' => 'project'],
            // payments
            ['name' => 'Stripe',         'slug' => 'stripe',         'type' => 'service'],
            // blog tags
            ['name' => 'Architecture',   'slug' => 'architecture',   'type' => 'post'],
            ['name' => 'Performance',    'slug' => 'performance-tag','type' => 'post'],
            ['name' => 'Security',       'slug' => 'security',       'type' => 'post'],
            ['name' => 'Testing',        'slug' => 'testing',        'type' => 'post'],
        ];

        foreach ($tags as $tag) {
            Tag::query()->firstOrCreate(['slug' => $tag['slug']], $tag);
        }
    }

    // -------------------------------------------------------------------------
    // Services
    // -------------------------------------------------------------------------

    private function seedServices(): void
    {
        $services = [
            [
                'title'      => 'Custom SaaS Platforms',
                'slug'       => 'custom-saas-platforms',
                'excerpt'    => 'End-to-end SaaS product design, development, and launch for ambitious founders.',
                'body'       => <<<'MD'
Building a SaaS product from scratch requires more than writing code — it demands product thinking, resilient architecture, and a relentless focus on time-to-market. I design and deliver multi-tenant SaaS platforms on **Laravel + React** that are billing-ready, observable, and built to scale.

**What you get:**
- Full product discovery: user journeys, pricing architecture, and technical scoping
- Multi-tenant data isolation with row-level or schema-based strategies
- Subscription billing via Stripe Billing (trials, upgrades, dunning, metered usage)
- Role-based access control, audit logs, and activity feeds
- Observability stack: structured logs, APM traces, error tracking, uptime monitors
- CI/CD pipelines, staging environments, and blue-green deploy setup

**Typical timeline:** 6–12 weeks from kickoff to production.
MD,
                'status'     => 'published',
                'price_from' => 8000,
                'position'   => 1,
                'features'   => [
                    'Multi-tenant architecture',
                    'Stripe subscription billing',
                    'Observability & SRE-ready',
                    'Role-based access control',
                    'CI/CD & blue-green deploys',
                ],
            ],
            [
                'title'      => 'Enterprise Integrations',
                'slug'       => 'enterprise-integrations',
                'excerpt'    => 'API-first integrations connecting your CRMs, ERPs, billing systems, and data pipelines.',
                'body'       => <<<'MD'
Enterprise software stacks are complex. Whether you need to connect Salesforce, HubSpot, SAP, or a custom back-office system, I deliver reliable, maintainable API integrations with proper error handling, retries, and observability.

**What I connect:**
- CRMs: Salesforce, HubSpot, Pipedrive
- ERPs: SAP, Oracle, custom back-office
- Billing: Stripe, Chargebee, Zuora
- Communication: Twilio, SendGrid, Mailgun
- Data pipelines with webhook ingestion and event-driven transforms

**Guarantees:** Idempotent operations, dead-letter queues, and full audit trails.
MD,
                'status'     => 'published',
                'price_from' => 6000,
                'position'   => 2,
                'features'   => [
                    'API orchestration & webhook handling',
                    'Data pipelines & ETL',
                    'Security, compliance & audit trails',
                    'Idempotent & retry-safe operations',
                ],
            ],
            [
                'title'      => 'SaaS Architecture Audit',
                'slug'       => 'saas-architecture-audit',
                'excerpt'    => 'A deep technical review of your existing product — identify bottlenecks, risks, and quick wins.',
                'body'       => <<<'MD'
Got a product in production but something feels off? Slow queries, flaky deploys, mounting tech debt? I'll review your entire stack and deliver a prioritized action plan.

**Deliverables:**
- Architecture diagram of your current system
- Identified bottlenecks (DB queries, N+1s, queue congestion, memory leaks)
- Security surface review (auth flows, secrets handling, injection risks)
- Prioritized remediation roadmap (quick wins vs. strategic refactors)
- 60-min debrief call to walk through findings

**Turnaround:** 5–7 business days.
MD,
                'status'     => 'published',
                'price_from' => 1200,
                'position'   => 3,
                'features'   => [
                    'Full stack architecture review',
                    'Performance & DB query analysis',
                    'Security surface assessment',
                    'Prioritized remediation roadmap',
                    '60-min debrief call',
                ],
            ],
        ];

        $stripeTagId = Tag::query()->where('slug', 'stripe')->value('id');

        foreach ($services as $service) {
            $model = Service::query()->firstOrCreate(
                ['slug' => $service['slug']],
                $service
            );
            if ($stripeTagId) {
                $model->tags()->syncWithoutDetaching([$stripeTagId]);
            }
        }
    }

    // -------------------------------------------------------------------------
    // Projects
    // -------------------------------------------------------------------------

    private function seedProjects(): void
    {
        $projects = [
            [
                'title'       => 'MenaPay Billing Suite',
                'slug'        => 'menapay-billing-suite',
                'excerpt'     => 'PCI-ready subscription billing platform for MENA-based SaaS companies.',
                'description' => 'Designed and shipped a full billing platform for a regional SaaS operator handling payments, subscriptions, and invoicing across multiple Arab markets. The system integrates Stripe Radar for fraud detection, supports multi-currency invoicing (SAR, AED, MAD, USD), and processes over 1,000 active subscriptions with automated dunning and retry logic. Built on Laravel Cashier with custom multi-tenant billing isolation.',
                'status'      => 'published',
                'featured'    => true,
                'live_url'    => 'https://menapay.dev',
                'stack'       => ['Laravel', 'MySQL', 'Redis', 'Vue', 'Stripe'],
                'tag_slugs'   => ['laravel', 'vue', 'stripe', 'typescript', 'mysql', 'redis'],
                'seo_title'       => 'MenaPay Billing Suite — Laravel SaaS Billing Platform | Youssef Youyou',
                'seo_description' => 'PCI-ready multi-currency billing platform built with Laravel, Stripe, and Vue for MENA SaaS companies. Handles subscriptions, dunning, and invoicing at scale.',
            ],
            [
                'title'       => 'Atlas Logistics Portal',
                'slug'        => 'atlas-logistics-portal',
                'excerpt'     => 'Multi-tenant carrier and shipper portal with real-time shipment tracking.',
                'description' => 'Built a B2B logistics platform serving carriers and shippers with real-time ETA updates, route visualization via Mapbox, and role-based access for dispatchers, drivers, and clients. The platform handles 1,000+ concurrent shipments, uses Laravel Livewire for reactive dashboards without a full SPA overhead, and integrates with third-party carrier APIs for automatic status syncing.',
                'status'      => 'published',
                'featured'    => false,
                'live_url'    => 'https://atlas.dev',
                'stack'       => ['Laravel', 'PostgreSQL', 'Livewire', 'Mapbox'],
                'tag_slugs'   => ['laravel', 'postgresql', 'aws'],
                'seo_title'       => 'Atlas Logistics Portal — Real-Time Shipment Tracking Platform | Youssef Youyou',
                'seo_description' => 'Multi-tenant logistics portal built with Laravel Livewire and Mapbox. Real-time carrier tracking, role-based access, and third-party carrier API integrations.',
            ],
            [
                'title'       => 'OrbiPay FinOps Console',
                'slug'        => 'orbipay-finops-console',
                'excerpt'     => 'Usage-based billing, revenue recognition, and dunning automation for B2B SaaS.',
                'description' => 'Engineered a FinOps cockpit for a B2B SaaS company needing granular control over usage-based billing, revenue recognition, and churn risk scoring. The console connects to Stripe Billing for metered usage data, runs nightly revenue recognition jobs, and surfaces at-risk accounts through a scoring model. Designed for finance teams to export GAAP-compliant reports without engineering involvement.',
                'status'      => 'published',
                'featured'    => true,
                'live_url'    => 'https://orbipay.dev',
                'stack'       => ['Laravel', 'React', 'Stripe', 'PostgreSQL'],
                'tag_slugs'   => ['laravel', 'react', 'stripe', 'postgresql'],
                'seo_title'       => 'OrbiPay FinOps Console — Usage-Based Billing & Revenue Recognition | Youssef Youyou',
                'seo_description' => 'B2B SaaS FinOps platform built with Laravel and React. Automates usage-based billing, revenue recognition, and dunning via Stripe Billing integration.',
            ],
            [
                'title'       => 'Relay IoT Fleet',
                'slug'        => 'relay-iot-fleet',
                'excerpt'     => 'Industrial IoT fleet management with MQTT telemetry, OTA updates, and rules-based alerting.',
                'description' => 'Architected and delivered an IoT fleet management platform for an industrial client managing 500+ connected field devices. The system ingests MQTT streams at high throughput, normalizes telemetry into TimescaleDB for time-series queries, and triggers configurable alerts via email and SMS. OTA firmware updates are staged and rolled back automatically on failure, reducing field maintenance costs significantly.',
                'status'      => 'published',
                'featured'    => false,
                'stack'       => ['Go', 'React', 'Timescale', 'MQTT', 'AWS'],
                'tag_slugs'   => ['go', 'react', 'aws'],
                'seo_title'       => 'Relay IoT Fleet — Industrial IoT Fleet Management Platform | Youssef Youyou',
                'seo_description' => 'IoT fleet management system built with Go, MQTT, and TimescaleDB on AWS. High-throughput telemetry ingestion, OTA updates, and real-time rules-based alerting.',
            ],
            [
                'title'       => 'Lumen Health Records',
                'slug'        => 'lumen-health-records',
                'excerpt'     => 'HIPAA-compliant EHR system with patient portal, e-prescriptions, and lab integrations.',
                'description' => 'Designed and delivered a HIPAA-ready Electronic Health Records platform for a healthcare provider. The system enforces PHI encryption at rest and in transit, maintains immutable audit trails for every data access event, and integrates with lab vendors and e-pharmacy APIs for digital prescriptions. Patient portal supports appointment booking, document sharing, and secure messaging with care teams.',
                'status'      => 'published',
                'featured'    => true,
                'stack'       => ['Django', 'React', 'PostgreSQL', 'Redis'],
                'tag_slugs'   => ['django', 'react', 'postgresql', 'redis'],
                'seo_title'       => 'Lumen Health Records — HIPAA-Compliant EHR System | Youssef Youyou',
                'seo_description' => 'HIPAA-ready electronic health records platform built with Django and React. PHI encryption, audit trails, e-prescriptions, and patient portal.',
            ],
            [
                'title'       => 'Quant Trading Desk',
                'slug'        => 'quant-trading-desk',
                'excerpt'     => 'Low-latency risk dashboards, order routing, and compliance reporting for trading teams.',
                'description' => 'Built a real-time trading operations platform for a quantitative fund requiring sub-second risk visibility. The system ingests live market feeds via WebSockets, calculates position risk in real time, and routes orders to execution venues with latency monitoring. Compliance module generates audit-ready transaction reports for regulatory submissions. Stack prioritized low-latency Python with FastAPI and Next.js for the trading UI.',
                'status'      => 'published',
                'featured'    => false,
                'stack'       => ['FastAPI', 'Next.js', 'WebSockets', 'Redis'],
                'tag_slugs'   => ['fastapi', 'nextjs', 'typescript', 'redis'],
                'seo_title'       => 'Quant Trading Desk — Real-Time Risk & Order Routing Platform | Youssef Youyou',
                'seo_description' => 'Low-latency trading desk platform built with FastAPI and Next.js. Real-time risk dashboards, WebSocket market feeds, and compliance reporting for quant teams.',
            ],
            [
                'title'       => 'Nova Learning LMS',
                'slug'        => 'nova-learning-lms',
                'excerpt'     => 'Multi-tenant LMS with SCORM support, cohort analytics, and rich course authoring.',
                'description' => 'Delivered a white-label Learning Management System for a training company serving corporate clients. The platform supports SCORM-compliant course imports, a built-in rich-text course editor, cohort enrollment, and completion analytics. Multi-tenant architecture allows each client to have a branded subdomain with isolated learner data. Built with Laravel Inertia for a snappy SPA experience without a decoupled API.',
                'status'      => 'published',
                'featured'    => false,
                'stack'       => ['Laravel', 'Inertia', 'React', 'PostgreSQL'],
                'tag_slugs'   => ['laravel', 'react', 'postgresql'],
                'seo_title'       => 'Nova Learning LMS — Multi-Tenant E-Learning Platform | Youssef Youyou',
                'seo_description' => 'White-label LMS built with Laravel Inertia and React. SCORM support, cohort analytics, rich course authoring, and multi-tenant subdomain architecture.',
            ],
            [
                'title'       => 'Terra Delivery Tracker',
                'slug'        => 'terra-delivery-tracker',
                'excerpt'     => 'Last-mile logistics platform with Android driver app and live ETA for end customers.',
                'description' => 'Built an end-to-end last-mile delivery platform including a native Android driver app (Kotlin), a web-based dispatch console, and a customer-facing ETA tracking page with live map updates. Drivers receive push notifications for new assignments, update delivery status offline, and sync on reconnect. The Laravel API orchestrates dispatch logic, route assignment, and proof-of-delivery photo uploads.',
                'status'      => 'published',
                'featured'    => false,
                'stack'       => ['Kotlin', 'Android', 'Laravel', 'PostgreSQL'],
                'tag_slugs'   => ['kotlin', 'android', 'laravel', 'postgresql'],
                'seo_title'       => 'Terra Delivery Tracker — Last-Mile Logistics & Android Driver App | Youssef Youyou',
                'seo_description' => 'Last-mile delivery platform with native Kotlin Android app, Laravel dispatch API, and live ETA tracking for customers. Offline-sync and proof-of-delivery.',
            ],
            [
                'title'       => 'Harbor ERP Suite',
                'slug'        => 'harbor-erp-suite',
                'excerpt'     => 'Modular ERP for mid-market businesses covering inventory, procurement, and finance.',
                'description' => 'Designed and shipped a modular ERP system for a mid-market distribution company replacing a legacy spreadsheet workflow. Modules cover inventory management with low-stock alerts, multi-step procurement approvals, accounts payable/receivable, and BI data exports to Excel and Google Sheets. The approval workflow engine is configurable per organization without code changes. Runs on Laravel + Vue with MySQL behind a Redis cache layer.',
                'status'      => 'published',
                'featured'    => true,
                'stack'       => ['Laravel', 'Vue', 'MySQL', 'Redis'],
                'tag_slugs'   => ['laravel', 'vue', 'mysql', 'redis'],
                'seo_title'       => 'Harbor ERP Suite — Modular ERP for Mid-Market Businesses | Youssef Youyou',
                'seo_description' => 'Custom ERP system built with Laravel, Vue, and MySQL. Inventory management, procurement approvals, finance ledger, and BI exports for mid-market companies.',
            ],
            [
                'title'       => 'Aurora Mobile Banking',
                'slug'        => 'aurora-mobile-banking',
                'excerpt'     => 'Kotlin Android digital wallet with biometric auth, card controls, and AML risk engine.',
                'description' => 'Delivered the Android app and backend API for a digital banking startup. The Kotlin app features biometric authentication, real-time push notifications for transactions, card freeze/unfreeze, and spending analytics. The Laravel backend enforces AML rule scoring on every transaction, with automatic flag and review queues for compliance officers. KYC flow integrates with a third-party identity verification provider.',
                'status'      => 'published',
                'featured'    => true,
                'stack'       => ['Kotlin', 'Android', 'Laravel', 'PostgreSQL'],
                'tag_slugs'   => ['kotlin', 'android', 'laravel', 'postgresql'],
                'seo_title'       => 'Aurora Mobile Banking — Android Digital Wallet & AML Platform | Youssef Youyou',
                'seo_description' => 'Digital banking Android app built with Kotlin and Laravel. Biometric auth, card management, AML rule engine, KYC integration, and real-time transaction alerts.',
            ],
            [
                'title'       => 'Beacon Incident Response',
                'slug'        => 'beacon-incident-response',
                'excerpt'     => 'On-call management, runbooks, incident rooms, and RCA exports for SRE teams.',
                'description' => 'Built an incident response platform for a SRE team managing a high-availability platform. Features include on-call rotation scheduling, PagerDuty-style alerting, collaborative incident rooms with live timeline updates, and automated RCA document generation. Post-incident reports are exported as structured PDFs with a full event timeline, contributing factors, and action items. Built with Go for the alerting engine and Next.js for the ops UI.',
                'status'      => 'published',
                'featured'    => true,
                'stack'       => ['Go', 'Next.js', 'PostgreSQL', 'Redis'],
                'tag_slugs'   => ['go', 'nextjs', 'postgresql', 'redis'],
                'seo_title'       => 'Beacon Incident Response — SRE On-Call & Incident Management Platform | Youssef Youyou',
                'seo_description' => 'Incident response and on-call management platform built with Go and Next.js. Runbooks, incident rooms, RCA exports, and rotation scheduling for SRE teams.',
            ],
            [
                'title'       => 'Keystone Identity Hub',
                'slug'        => 'keystone-identity-hub',
                'excerpt'     => 'OIDC/SAML SSO broker, SCIM provisioning, and adaptive MFA for SaaS teams.',
                'description' => 'Architected an identity platform that acts as an OIDC/SAML 2.0 broker for enterprise customers of a SaaS product. The system allows enterprise admins to connect their own IdP (Okta, Azure AD, Google Workspace) via SAML, auto-provision users through SCIM, and enforce adaptive MFA policies based on IP, device, and risk signals. Built on Laravel with a React admin dashboard.',
                'status'      => 'published',
                'featured'    => false,
                'stack'       => ['Laravel', 'React', 'Redis', 'PostgreSQL'],
                'tag_slugs'   => ['laravel', 'react', 'redis', 'postgresql'],
                'seo_title'       => 'Keystone Identity Hub — SAML SSO & SCIM Provisioning Platform | Youssef Youyou',
                'seo_description' => 'Enterprise identity platform with OIDC/SAML SSO, SCIM provisioning, and adaptive MFA. Built with Laravel and React for SaaS companies serving enterprise customers.',
            ],
            [
                'title'       => 'Cobalt Desktop POS',
                'slug'        => 'cobalt-desktop-pos',
                'excerpt'     => 'Offline-first Electron POS for retail with printer, cash drawer, and barcode scanner support.',
                'description' => 'Shipped an Electron-based desktop Point of Sale application for a retail chain operating in areas with unreliable internet. The app works fully offline, syncing sales, inventory, and receipts when connectivity is restored. Integrates with thermal receipt printers, cash drawers, and barcode scanners via USB/serial. The TypeScript frontend connects to a local SQLite store with a cloud C# API for central reporting.',
                'status'      => 'published',
                'featured'    => false,
                'stack'       => ['Electron', 'TypeScript', 'SQLite', 'C# API'],
                'tag_slugs'   => ['electron', 'typescript'],
                'seo_title'       => 'Cobalt Desktop POS — Offline-First Electron Point of Sale | Youssef Youyou',
                'seo_description' => 'Offline-first desktop POS built with Electron and TypeScript. Receipt printer, cash drawer, and barcode scanner integrations with cloud sync for retail chains.',
            ],
            [
                'title'       => 'Alva Insights Dashboard',
                'slug'        => 'alva-insights-dashboard',
                'excerpt'     => 'Executive dashboards for revenue, churn, NPS, and product usage built on BigQuery.',
                'description' => 'Delivered a data analytics platform for a SaaS company\'s executive team, consolidating revenue, product usage, churn, and NPS data into a single dashboard. Data pipelines transform raw events from multiple sources using dbt models on BigQuery, and the Next.js frontend renders interactive scorecards with drill-down filters. Finance and product teams export custom reports without writing SQL.',
                'status'      => 'published',
                'featured'    => false,
                'stack'       => ['Next.js', 'TypeScript', 'BigQuery', 'GCP'],
                'tag_slugs'   => ['nextjs', 'typescript', 'gcp'],
                'seo_title'       => 'Alva Insights Dashboard — SaaS Analytics & Executive Reporting | Youssef Youyou',
                'seo_description' => 'Executive analytics dashboard built with Next.js and BigQuery on GCP. Revenue, churn, NPS, and product usage reporting with dbt data pipelines.',
            ],
            [
                'title'       => 'Alpine Field Service',
                'slug'        => 'alpine-field-service',
                'excerpt'     => 'Technician dispatch, work orders, and offline-first Flutter mobile app for field operations.',
                'description' => 'Built a field service management platform for a facility maintenance company deploying technicians across sites. Dispatchers assign and reschedule work orders from a web console, while technicians use an offline-first Flutter app to view jobs, log work, capture photos, and collect digital signatures. Jobs sync automatically on reconnect. Route optimization cuts average travel time between assignments.',
                'status'      => 'published',
                'featured'    => false,
                'stack'       => ['Flutter', 'Laravel', 'PostgreSQL'],
                'tag_slugs'   => ['flutter', 'laravel', 'postgresql'],
                'seo_title'       => 'Alpine Field Service — Technician Dispatch & Offline Flutter App | Youssef Youyou',
                'seo_description' => 'Field service management platform with offline Flutter mobile app and Laravel dispatch API. Work orders, digital signatures, and route optimization.',
            ],
            [
                'title'       => 'LumenPay Payroll',
                'slug'        => 'lumenpay-payroll',
                'excerpt'     => 'Multi-country payroll engine with tax rules, contractor payouts, and approval workflows.',
                'description' => 'Delivered a payroll platform for a remote-first company with employees across Morocco, France, UAE, and Canada. The system applies country-specific tax rules and deduction logic, handles both employee and contractor payouts, and routes each payroll run through a configurable multi-step approval flow before disbursement. Finance teams download GAAP-compliant payroll reports per country. Built with Laravel + Vue on MySQL.',
                'status'      => 'published',
                'featured'    => false,
                'stack'       => ['Laravel', 'Vue', 'MySQL', 'Redis'],
                'tag_slugs'   => ['laravel', 'vue', 'mysql', 'redis'],
                'seo_title'       => 'LumenPay Payroll — Multi-Country Payroll Platform | Youssef Youyou',
                'seo_description' => 'Multi-country payroll system built with Laravel and Vue. Country-specific tax rules, contractor payouts, approval workflows, and GAAP-compliant reporting.',
            ],
            [
                'title'       => 'Skyline Real Estate CRM',
                'slug'        => 'skyline-realestate-crm',
                'excerpt'     => 'Agent CRM with MLS sync, lead routing, property listings, and contract templates.',
                'description' => 'Built a real estate CRM for an agency managing residential and commercial listings. The platform syncs property data from MLS feeds, routes incoming leads to agents based on territory and availability, and generates contract PDFs from templates. Agents manage their pipeline through a Kanban-style deal board. Built on Laravel and React with PostgreSQL for property search with full-text and geospatial filtering.',
                'status'      => 'published',
                'featured'    => false,
                'stack'       => ['Laravel', 'React', 'PostgreSQL'],
                'tag_slugs'   => ['laravel', 'react', 'postgresql'],
                'seo_title'       => 'Skyline Real Estate CRM — Agent Portal & MLS Integration | Youssef Youyou',
                'seo_description' => 'Real estate CRM built with Laravel and React. MLS sync, lead routing, deal pipeline, contract PDF generation, and geospatial property search.',
            ],
            [
                'title'       => 'Vertex Subscription Hub',
                'slug'        => 'vertex-subscription-hub',
                'excerpt'     => 'Plan catalog, pricing experiments, entitlement engine, and customer self-serve portal.',
                'description' => 'Engineered a subscription management layer for a B2B SaaS product needing flexible plan management without re-deploying code. Product managers configure plans, features, and limits through an admin UI. Entitlement checks are served via a low-latency API to gate features in the main app. A customer-facing portal lets users upgrade, downgrade, add seats, and manage billing details. Integrates with Stripe and Next.js frontend.',
                'status'      => 'published',
                'featured'    => false,
                'stack'       => ['Laravel', 'Next.js', 'Stripe', 'Redis'],
                'tag_slugs'   => ['laravel', 'nextjs', 'stripe', 'redis'],
                'seo_title'       => 'Vertex Subscription Hub — Entitlement Engine & Plan Management | Youssef Youyou',
                'seo_description' => 'Subscription management and entitlement platform built with Laravel, Next.js, and Stripe. Plan catalog, pricing experiments, and customer self-serve billing portal.',
            ],
            [
                'title'       => 'Orbit Analytics SaaS',
                'slug'        => 'orbit-analytics-saas',
                'excerpt'     => 'Self-serve analytics SaaS with embeddable widgets, row-level security, and export pipelines.',
                'description' => 'Delivered a white-label analytics product that SaaS companies embed into their own dashboards for end-customers. Each tenant\'s data is isolated via row-level security in ClickHouse, and the embeddable widget renders in an iframe with a signed token. Export pipelines support CSV, XLSX, and scheduled email delivery. Built on Laravel + Vue with ClickHouse for analytical queries at scale.',
                'status'      => 'published',
                'featured'    => false,
                'stack'       => ['Laravel', 'Vue', 'ClickHouse', 'Redis'],
                'tag_slugs'   => ['laravel', 'vue', 'redis'],
                'seo_title'       => 'Orbit Analytics SaaS — Embeddable Analytics & Multi-Tenant Dashboards | Youssef Youyou',
                'seo_description' => 'White-label analytics SaaS built with Laravel, Vue, and ClickHouse. Embeddable widgets, row-level security, and scheduled export pipelines.',
            ],
            [
                'title'       => 'Monorail Supply Chain',
                'slug'        => 'monorail-supply-chain',
                'excerpt'     => 'Supplier portal, ASN intake, inventory sync, and EDI adapters for supply chain teams.',
                'description' => 'Built a supply chain management platform for a manufacturing company with a complex supplier network. Suppliers log in to a self-service portal to submit Advanced Ship Notices, upload compliance documents, and track PO status. EDI adapters transform incoming supplier data into the platform\'s internal format. Inventory sync runs on a configurable schedule and flags discrepancies for warehouse review.',
                'status'      => 'published',
                'featured'    => false,
                'stack'       => ['Laravel', 'Vue', 'PostgreSQL', 'Redis'],
                'tag_slugs'   => ['laravel', 'vue', 'postgresql', 'redis'],
                'seo_title'       => 'Monorail Supply Chain — Supplier Portal & EDI Integration | Youssef Youyou',
                'seo_description' => 'Supply chain management platform built with Laravel and Vue. Supplier self-service portal, ASN intake, inventory sync, and EDI adapters.',
            ],
        ];

        foreach ($projects as $project) {
            $seoData = Arr::only($project, ['seo_title', 'seo_description']);
            $projectData = array_merge(
                $this->projectProofDefaults($project['title'], $project['slug']),
                Arr::except($project, ['tag_slugs', 'seo_title', 'seo_description'])
            );

            $model = Project::query()->updateOrCreate(
                ['slug' => $project['slug']],
                $projectData
            );

            $tagIds = Tag::query()
                ->whereIn('slug', $project['tag_slugs'] ?? [])
                ->pluck('id')
                ->all();

            if ($tagIds) {
                $model->tags()->sync($tagIds);
            }

            // Seed SEO meta if the model exists and SeoMeta is available
            if (!empty($seoData) && class_exists(SeoMeta::class)) {
                SeoMeta::query()->updateOrCreate(
                    ['seoable_type' => Project::class, 'seoable_id' => $model->id],
                    [
                        'meta_title'       => $seoData['seo_title'],
                        'meta_description' => $seoData['seo_description'],
                        'og_title'         => $seoData['seo_title'],
                        'og_description'   => $seoData['seo_description'],
                        'canonical'        => 'https://www.youssefyouyou.com/en/projects/' . $model->slug,
                    ]
                );
            }
        }
    }

    private function seedTestimonials(): void
    {
        $testimonials = [
            [
                // TODO: replace with a real approved client testimonial.
                'client_name' => 'Salma El Idrissi',
                'client_title' => 'Operations Director',
                'client_company' => 'Atlas Booking Group',
                'quote' => 'Youssef turned a slow booking workflow into a cleaner system our team could actually rely on day to day.',
                'is_featured' => true,
                'status' => 'draft',
                'published' => false,
                'position' => 1,
            ],
            [
                // TODO: replace with a real approved client testimonial.
                'client_name' => 'Martin Vogel',
                'client_title' => 'Product Lead',
                'client_company' => 'Northline Metrics',
                'quote' => 'He connected product decisions to implementation details quickly, which helped us ship without losing clarity.',
                'is_featured' => true,
                'status' => 'draft',
                'published' => false,
                'position' => 2,
            ],
            [
                // TODO: replace with a real approved client testimonial.
                'client_name' => 'Imane Bennis',
                'client_title' => 'Founder',
                'client_company' => 'RiadFlow Studio',
                'quote' => 'The project felt structured from the first call, and the final product made the business easier to explain and easier to run.',
                'is_featured' => true,
                'status' => 'draft',
                'published' => false,
                'position' => 3,
            ],
        ];

        foreach ($testimonials as $testimonial) {
            Testimonial::query()->updateOrCreate(
                ['client_name' => $testimonial['client_name']],
                array_merge($testimonial, [
                    'name' => $testimonial['client_name'],
                    'role' => $testimonial['client_title'],
                    'company' => $testimonial['client_company'],
                    'featured' => $testimonial['is_featured'],
                    'published_at' => $testimonial['published'] ? now() : null,
                ])
            );
        }
    }

    private function seedClientLogos(): void
    {
        $logos = [
            // TODO: replace with real approved client logos only after verification and written permission.
            ['name' => 'Atlas Booking Group', 'slug' => 'atlas-booking-group', 'image_path' => 'images/logos/atlas-booking-group.svg', 'sort_order' => 1],
            ['name' => 'Northline Metrics', 'slug' => 'northline-metrics', 'image_path' => 'images/logos/northline-metrics.svg', 'sort_order' => 2],
            ['name' => 'RiadFlow Studio', 'slug' => 'riadflow-studio', 'image_path' => 'images/logos/riadflow-studio.svg', 'sort_order' => 3],
            ['name' => 'Sahara Health Labs', 'slug' => 'sahara-health-labs', 'image_path' => 'images/logos/sahara-health-labs.svg', 'sort_order' => 4],
            ['name' => 'BluePort Systems', 'slug' => 'blueport-systems', 'image_path' => 'images/logos/blueport-systems.svg', 'sort_order' => 5],
        ];

        foreach ($logos as $logo) {
            ClientLogo::query()->updateOrCreate(
                ['slug' => $logo['slug']],
                array_merge($logo, [
                    'alt_text' => $logo['name'].' logo',
                    'is_featured' => true,
                    'verified' => false,
                    'permission_given' => false,
                ])
            );
        }
    }

    private function projectProofDefaults(string $title, string $slug): array
    {
        return [
            // TODO: replace with a real client name or set is_nda to true before publishing publicly.
            'client_name' => match ($slug) {
                'menapay-billing-suite' => 'MenaPay',
                'atlas-logistics-portal' => 'Atlas Logistics',
                'orbipay-finops-console' => 'OrbiPay',
                default => $title.' Client',
            },
            // TODO: replace with the actual client industry wording used by the client.
            'client_industry' => match ($slug) {
                'menapay-billing-suite', 'orbipay-finops-console' => 'Fintech / SaaS',
                'atlas-logistics-portal' => 'Logistics',
                default => 'B2B software',
            },
            // TODO: replace with a verifiable result headline once the client approves the wording.
            'result_headline' => match ($slug) {
                'menapay-billing-suite' => 'Gave finance teams a cleaner billing system for multi-market growth.',
                'atlas-logistics-portal' => 'Reduced shipment follow-up friction with real-time visibility for carriers and shippers.',
                'orbipay-finops-console' => 'Turned usage billing and dunning into a workflow finance teams could manage without engineering.',
                default => 'Delivered a clearer workflow and a stronger operational baseline.',
            },
            'is_concept' => false,
            'is_nda' => false,
            // TODO: set screenshot paths once real project captures are available.
            'screenshot_path' => null,
            'screenshot_webp_path' => null,
            // TODO: replace with the actual build date or year.
            'built_at' => '2025-01-01',
            // TODO: replace with a real editorial setup for this case study.
            'context' => 'This project was shaped around delivery constraints, stakeholder priorities, and the need to improve a real operational workflow.',
            'problem_long' => 'The starting point was a workflow with too much manual follow-up, too little visibility, or too much friction for the team using it every day.',
            'solution_long' => 'The solution combined product framing, interface decisions, and backend implementation so the system could support the workflow with less manual effort.',
            'outcome_long' => 'The final outcome was a clearer internal process, a more reliable product surface, and a stronger base for future iteration.',
            // TODO: replace with real, client-approved result cards for this project.
            'result_1_label' => 'Launch time',
            'result_1_value' => 'Scoped launch plan',
            'result_2_label' => 'Performance score',
            'result_2_value' => 'Measured after launch',
            'result_3_label' => 'Client outcome',
            'result_3_value' => 'Operational clarity improved',
            'metric_one_label' => 'Launch time',
            'metric_one_value' => '6 weeks',
            'metric_two_label' => 'Performance score',
            'metric_two_value' => '94/100',
            'metric_three_label' => 'Client outcome',
            'metric_three_value' => 'Less manual work across core operations',
        ];
    }

    // -------------------------------------------------------------------------
    // Blog Posts  (SEO-targeted, keyword-rich titles & bodies)
    // -------------------------------------------------------------------------

    private function seedPosts(): void
    {
        $strategyCategoryId   = Category::query()->where('slug', 'strategy')->value('id');
        $architectureTagId    = Tag::query()->where('slug', 'architecture')->value('id');

        $posts = [
            // ---- Laravel / SaaS ----
            [
                'title'   => 'How to Scale a Laravel SaaS Across Multiple Regions',
                'slug'    => 'how-to-scale-laravel-saas-across-regions',
                'excerpt' => 'Caching strategies, multi-tenant tenancy, and CI/CD lessons from shipping Laravel SaaS to production in multiple regions.',
                'body'    => 'Scaling a Laravel SaaS beyond a single region forces you to think carefully about read replicas, cache topology, queue geography, and deployment pipelines. This post covers the concrete patterns I use: database read replicas with sticky sessions, Redis Cluster vs. Redis Sentinel trade-offs, tenant-scoped queue workers, and a GitHub Actions pipeline that deploys to multiple regions with automated smoke tests. These are lessons from production, not theory.',
                'seo_title' => 'How to Scale a Laravel SaaS Across Multiple Regions | Youssef Youyou',
                'seo_description' => 'Practical guide to scaling Laravel SaaS multi-region: read replicas, Redis topology, queue workers, and CI/CD pipelines. Real production lessons by Youssef Youyou.',
            ],
            [
                'title'   => 'Designing Pricing for B2B SaaS: A Framework That Works',
                'slug'    => 'designing-pricing-for-b2b-saas',
                'excerpt' => 'How to map value metrics, billing cadence, and usage-based pricing to product outcomes that actually grow revenue.',
                'body'    => 'B2B SaaS pricing is a product decision, not a finance decision. The pricing model you choose shapes how customers adopt your product, when they upgrade, and how often they churn. This post walks through the framework I use with founder clients: identify your value metric (the unit that expands with customer success), choose a billing model (seat, usage, or hybrid), design your plan tiers to guide natural upgrades, and instrument your billing stack to measure expansion MRR.',
                'seo_title' => 'B2B SaaS Pricing Strategy: Value Metrics, Tiers & Usage Billing | Youssef Youyou',
                'seo_description' => 'Framework for designing B2B SaaS pricing: value metrics, usage-based billing, plan tier design, and expansion MRR. By full-stack engineer Youssef Youyou.',
            ],
            [
                'title'   => 'Zero-Downtime Laravel Deployments with Blue-Green and Feature Flags',
                'slug'    => 'zero-downtime-laravel-deployments-blue-green-feature-flags',
                'excerpt' => 'How to ship Laravel features continuously without maintenance windows using blue-green deploys and feature flags.',
                'body'    => 'Most Laravel apps still deploy with a brief downtime window — a maintenance page, a migration lock, or a queue pause. This post explains how to eliminate that entirely using blue-green deployments on Laravel Forge or Envoyer, expand-contract database migrations that run safely under traffic, and feature flags with Laravel Pennant to decouple deploy from release. You can ship ten times a day without ever touching a maintenance banner.',
                'seo_title' => 'Zero-Downtime Laravel Deployments: Blue-Green & Feature Flags | Youssef Youyou',
                'seo_description' => 'Ship Laravel without downtime using blue-green deploys, expand-contract migrations, and Laravel Pennant feature flags. Step-by-step guide by Youssef Youyou.',
            ],
            [
                'title'   => 'Laravel Multi-Tenant Architecture: Row-Level vs. Schema-Based Isolation',
                'slug'    => 'laravel-multi-tenant-architecture-row-level-vs-schema-isolation',
                'excerpt' => 'A practical comparison of the two main multi-tenancy strategies for Laravel SaaS and when to use each.',
                'body'    => 'Choosing the wrong tenancy model early in a SaaS build is one of the most expensive architectural mistakes you can make. Row-level isolation is simpler to implement and cheaper to operate, but schema or database-per-tenant isolation gives stronger data guarantees and easier compliance. This post breaks down both approaches with real code examples using the Tenancy for Laravel package, and explains the trade-offs in terms of query complexity, migration management, and operational overhead.',
                'seo_title' => 'Laravel Multi-Tenant Architecture: Row vs. Schema Isolation | Youssef Youyou',
                'seo_description' => 'Compare row-level vs. schema-based multi-tenancy in Laravel SaaS. Code examples, migration strategies, and when to use each approach. By Youssef Youyou.',
            ],
            [
                'title'   => 'Building a Resilient Job Queue with Laravel Horizon and Redis',
                'slug'    => 'laravel-horizon-redis-resilient-job-queue',
                'excerpt' => 'Prevent stuck jobs, retry storms, and queue backlogs in production Laravel applications.',
                'body'    => 'A poorly configured Laravel queue can silently fail, retry the same job thousands of times, or build a backlog that never clears. This post covers the Horizon configuration patterns that matter in production: queue prioritization, worker concurrency per queue, job-level retry budgets with backoff multipliers, idempotent job design, and dead-letter patterns for jobs that exhaust retries. Includes a production-ready horizon.php config template.',
                'seo_title' => 'Laravel Horizon & Redis Queue Best Practices for Production | Youssef Youyou',
                'seo_description' => 'Production guide for Laravel Horizon and Redis queues: worker config, retry budgets, idempotent jobs, and dead-letter patterns. By Youssef Youyou.',
            ],
            // ---- Architecture / API ----
            [
                'title'   => 'API Design Principles for Multi-Tenant SaaS',
                'slug'    => 'api-design-principles-multi-tenant-saas',
                'excerpt' => 'How to design tenant-isolated, ergonomic APIs that scale without becoming a security liability.',
                'body'    => 'Designing an API for a multi-tenant SaaS requires solving tenant context propagation, authorization at every layer, and preventing cross-tenant data leaks — all while keeping the API ergonomic for developers. This post covers: tenant identification strategies (subdomain, JWT claim, API key prefix), middleware-based tenant context injection, policy-based authorization with Laravel Gates, and API versioning without painful breaking changes.',
                'seo_title' => 'API Design for Multi-Tenant SaaS: Isolation, Auth & Versioning | Youssef Youyou',
                'seo_description' => 'Best practices for multi-tenant SaaS API design: tenant context, JWT claims, Laravel Gates, and versioning strategies. By full-stack engineer Youssef Youyou.',
            ],
            [
                'title'   => 'Event-Driven Architecture with Laravel Events and Queued Listeners',
                'slug'    => 'event-driven-architecture-laravel-events-queued-listeners',
                'excerpt' => 'Decouple your Laravel application with events and listeners without introducing unnecessary complexity.',
                'body'    => 'Event-driven design is often oversold as the solution to every coupling problem, but used correctly in Laravel it lets you add side effects — notifications, analytics, audit logs, third-party syncs — without touching core business logic. This post shows how to structure Laravel Events and Listeners for clarity: when to queue vs. dispatch synchronously, how to version event payloads, and how to test event-driven flows reliably with Pest.',
                'seo_title' => 'Event-Driven Laravel: Events, Queued Listeners & Testing | Youssef Youyou',
                'seo_description' => 'Practical guide to event-driven architecture in Laravel: events, queued listeners, payload versioning, and testing with Pest. By Youssef Youyou.',
            ],
            // ---- Performance ----
            [
                'title'   => 'Eliminating N+1 Queries in Laravel: A Production Debugging Guide',
                'slug'    => 'eliminating-n-plus-1-queries-laravel-production',
                'excerpt' => 'Identify, debug, and permanently fix N+1 query problems before they degrade your Laravel app performance.',
                'body'    => 'N+1 queries are the most common performance killer in Laravel applications, and they\'re notoriously easy to introduce accidentally. This post walks through how to detect them with Laravel Debugbar and Telescope, use eager loading to fix the most common patterns, understand when to use `withCount` vs. raw subqueries, and set up a CI-level query count assertion with Pest to prevent regressions permanently.',
                'seo_title' => 'Fix N+1 Queries in Laravel: Debug, Eager Load & Prevent Regressions | Youssef Youyou',
                'seo_description' => 'Production guide to finding and fixing N+1 queries in Laravel using Debugbar, Telescope, eager loading, and Pest query assertions. By Youssef Youyou.',
            ],
            [
                'title'   => 'Laravel Response Caching: Edge, Full-Page, and Fragment Strategies',
                'slug'    => 'laravel-response-caching-edge-full-page-fragment',
                'excerpt' => 'Cut your Laravel app TTFB with the right caching strategy for your content type and traffic pattern.',
                'body'    => 'Caching in Laravel spans multiple layers — CDN edge caching, full-page HTTP caching, and fine-grained fragment caching with Redis. Choosing the wrong layer for the wrong content leads to stale data bugs or wasted infra spend. This post breaks down when to use each approach, how to set correct Cache-Control headers for Cloudflare/CloudFront, use Laravel\'s cache tags for targeted invalidation, and measure the real-world impact with before/after Lighthouse scores.',
                'seo_title' => 'Laravel Caching Guide: Edge, Full-Page & Fragment Caching | Youssef Youyou',
                'seo_description' => 'Complete Laravel caching guide covering CDN edge, full-page, and Redis fragment caching. Cache-Control headers, cache tags, and real-world performance impact.',
            ],
            // ---- DevOps / Security ----
            [
                'title'   => 'Laravel Observability Stack: Logs, Traces, and Metrics That Matter',
                'slug'    => 'laravel-observability-stack-logs-traces-metrics',
                'excerpt' => 'Instrument your Laravel application so you can detect problems before users report them.',
                'body'    => 'Most Laravel apps in production are flying blind — they have error tracking but no distributed tracing, structured logs but no alerting rules. This post covers the full observability stack I deploy for Laravel: structured JSON logging with context enrichment, OpenTelemetry tracing with a Tempo or Datadog backend, custom Prometheus metrics for business KPIs, and alerting rules that fire on SLO breaches rather than raw error counts.',
                'seo_title' => 'Laravel Observability: Structured Logs, OpenTelemetry Tracing & Metrics | Youssef Youyou',
                'seo_description' => 'Full observability stack for Laravel: structured logs, OpenTelemetry tracing, Prometheus metrics, and SLO-based alerting. Production guide by Youssef Youyou.',
            ],
            [
                'title'   => 'Hardening Laravel Authentication: Sessions, MFA, and Device Binding',
                'slug'    => 'hardening-laravel-authentication-mfa-device-binding',
                'excerpt' => 'Go beyond password hashing — build auth that survives credential stuffing, session hijacking, and MFA bypass.',
                'body'    => 'Most Laravel apps implement the Breeze or Jetstream authentication starter and consider auth "done." But production security requires more: TOTP/WebAuthn MFA, device fingerprinting to detect session theft, rate limiting on login and password reset endpoints, and secure session cookie configuration that survives a CDN. This post covers the practical hardening steps with concrete Laravel code examples.',
                'seo_title' => 'Hardening Laravel Auth: MFA, Device Binding & Session Security | Youssef Youyou',
                'seo_description' => 'Security guide for Laravel authentication: TOTP MFA, device binding, session hardening, and rate limiting against credential stuffing attacks.',
            ],
            [
                'title'   => 'Zero-Downtime Database Migrations in Laravel Under Production Load',
                'slug'    => 'zero-downtime-database-migrations-laravel-production',
                'excerpt' => 'Run schema changes on live databases without table locks, downtime, or errors for active users.',
                'body'    => 'Running `php artisan migrate` on a large production table is a recipe for locking your database and causing an outage. The expand-contract pattern solves this: add columns without dropping old ones, backfill data in background jobs, then remove old columns in a future deploy once all code references are gone. This post walks through the full pattern in Laravel with real examples for renaming columns, changing types, and adding non-nullable columns safely.',
                'seo_title' => 'Zero-Downtime Database Migrations in Laravel: Expand-Contract Pattern | Youssef Youyou',
                'seo_description' => 'Run Laravel migrations on production without table locks using the expand-contract pattern. Step-by-step guide with background backfills and safe column changes.',
            ],
            // ---- Stripe / Billing ----
            [
                'title'   => 'Implementing Stripe Webhooks in Laravel: Idempotency and Error Handling',
                'slug'    => 'stripe-webhooks-laravel-idempotency-error-handling',
                'excerpt' => 'Build a production-safe Stripe webhook handler in Laravel that handles retries, duplicates, and failures gracefully.',
                'body'    => 'Stripe will retry failed webhook deliveries up to 72 hours, which means your handler must be idempotent — processing the same event twice must produce the same result. This post covers building a webhook handler with Laravel Cashier, storing processed event IDs to prevent duplicates, queuing heavy processing off the HTTP response cycle, and writing integration tests that replay real Stripe event payloads.',
                'seo_title' => 'Stripe Webhooks in Laravel: Idempotent Handlers & Error Recovery | Youssef Youyou',
                'seo_description' => 'Production guide to Stripe webhooks in Laravel: idempotent handlers, duplicate prevention, queued processing, and integration testing with real event payloads.',
            ],
            // ---- Vite / Frontend ----
            [
                'title'   => 'Optimizing Laravel Vite Builds for Production: Bundle Size and Cache Headers',
                'slug'    => 'optimizing-laravel-vite-builds-production-bundle-size-cache',
                'excerpt' => 'Ship faster Laravel frontends by optimizing Vite bundles, code splitting, and long-term asset caching.',
                'body'    => 'Vite makes Laravel frontends fast by default, but a few configuration choices make a big difference in production: manual chunk splitting for vendor libraries, dynamic imports for route-level code splitting, image optimization via vite-imagetools, and setting correct cache-busting headers for Cloudflare. This post walks through the vite.config.js settings and Nginx/Apache headers that consistently hit 90+ Lighthouse performance scores.',
                'seo_title' => 'Laravel Vite Production Optimization: Bundles, Code Splitting & Caching | Youssef Youyou',
                'seo_description' => 'Optimize Laravel Vite for production: chunk splitting, dynamic imports, image optimization, and cache headers for 90+ Lighthouse scores. By Youssef Youyou.',
            ],
            // ---- Testing ----
            [
                'title'   => 'Testing Laravel SaaS Applications with Pest: A Practical Guide',
                'slug'    => 'testing-laravel-saas-applications-pest-practical-guide',
                'excerpt' => 'Build a fast, reliable test suite for your Laravel SaaS using Pest — from unit tests to full feature flows.',
                'body'    => 'A well-structured Pest test suite for a Laravel SaaS application tests business logic without hitting the database, feature flows with real HTTP requests, and integration points with external APIs using fakes. This post covers the folder structure and conventions I use, how to set up tenant context in tests, parallel test execution with `--parallel`, and a GitHub Actions workflow that runs the full suite in under 3 minutes.',
                'seo_title' => 'Testing Laravel SaaS with Pest: Unit, Feature & Integration Tests | Youssef Youyou',
                'seo_description' => 'Practical Pest testing guide for Laravel SaaS: test structure, tenant context, parallel execution, and CI setup under 3 minutes. By Youssef Youyou.',
            ],
            // ---- i18n / Localisation ----
            [
                'title'   => 'Building Multilingual Laravel Apps: Arabic, French, and English with RTL Support',
                'slug'    => 'multilingual-laravel-apps-arabic-french-english-rtl',
                'excerpt' => 'How to build a production-ready multilingual Laravel application supporting Arabic RTL, French, and English.',
                'body'    => 'Building a multilingual app for MENA and Francophone markets requires more than translating strings — it needs RTL layout handling, locale-aware date and number formatting, per-user locale persistence, and a translation workflow that doesn\'t slow your team down. This post covers the full setup: Laravel\'s translation files and Spatie Translatable for model content, Tailwind CSS RTL with the tailwindcss-rtl plugin, and a workflow for managing translation files in a team.',
                'seo_title' => 'Multilingual Laravel: Arabic RTL, French & English Support | Youssef Youyou',
                'seo_description' => 'Build multilingual Laravel apps with Arabic RTL, French, and English. Covers Spatie Translatable, Tailwind RTL, locale persistence, and translation workflows.',
            ],
            // ---- CI/CD ----
            [
                'title'   => 'GitHub Actions CI/CD Pipeline for Laravel: Lint, Test, and Deploy',
                'slug'    => 'github-actions-cicd-pipeline-laravel-lint-test-deploy',
                'excerpt' => 'A complete GitHub Actions pipeline that lints, tests, and deploys your Laravel application automatically.',
                'body'    => 'A good CI/CD pipeline for Laravel should run Pint for code style, Pest for tests, security scanning with Enlightn, and deploy to production only on green. This post provides a complete, production-ready GitHub Actions workflow YAML for a Laravel app: parallel job stages, MySQL service container for feature tests, artifact caching for vendor and node_modules, and a deploy step via Laravel Envoyer or SSH. Takes under 4 minutes end to end.',
                'seo_title' => 'GitHub Actions CI/CD for Laravel: Full Pipeline with Tests & Deploy | Youssef Youyou',
                'seo_description' => 'Complete GitHub Actions pipeline for Laravel: Pint, Pest, Enlightn security scan, and automated deploy. Full workflow YAML under 4 minutes. By Youssef Youyou.',
            ],
            // ---- SaaS product ----
            [
                'title'   => 'From Idea to Paying Customers: How I Scope a SaaS MVP in 2 Weeks',
                'slug'    => 'scope-saas-mvp-in-two-weeks',
                'excerpt' => 'The exact scoping process I use with SaaS founders to go from product idea to a shippable MVP scope in two weeks.',
                'body'    => 'Most SaaS projects fail before a line of code is written — not because the idea is bad, but because the scope is wrong. My two-week scoping process with founders covers: defining the single user problem and the one metric that proves the MVP worked, mapping the minimum feature set that delivers that outcome (usually 40% smaller than the founder\'s initial list), designing the data model and system boundaries, and producing a fixed-scope proposal with a realistic timeline. This process has saved multiple clients from 6-month builds that should have taken 6 weeks.',
                'seo_title' => 'How to Scope a SaaS MVP in 2 Weeks: A Founder\'s Process | Youssef Youyou',
                'seo_description' => 'Scoping process to go from SaaS idea to shippable MVP in 2 weeks. Problem definition, feature prioritization, data modeling, and fixed-scope proposals. By Youssef Youyou.',
            ],
            [
                'title'   => 'How to Choose a Tech Stack for Your SaaS in 2025',
                'slug'    => 'how-to-choose-tech-stack-saas-2025',
                'excerpt' => 'A practical framework for SaaS founders and CTOs to choose the right stack — not the trendiest one.',
                'body'    => 'The right tech stack for a SaaS company is the one your team can ship, debug, and scale with confidence — not the one that trends on Twitter. For most early-stage SaaS products, Laravel + React (or Vue) covers 90% of requirements with the best combination of velocity, talent availability, and long-term maintainability. This post breaks down the decision framework I use with clients: product complexity, team expertise, hiring market, and infrastructure requirements — with a comparison of the top stacks for SaaS in 2025.',
                'seo_title' => 'How to Choose a SaaS Tech Stack in 2025: Laravel, React & Alternatives | Youssef Youyou',
                'seo_description' => 'Framework for choosing a SaaS tech stack in 2025. Compares Laravel, React, Next.js, Django, and more. By full-stack engineer Youssef Youyou.',
            ],
            [
                'title'   => 'Freelance Full-Stack Developer in Morocco: How I Work With Remote Clients',
                'slug'    => 'freelance-full-stack-developer-morocco-remote-clients',
                'excerpt' => 'How I work with startup founders and SaaS companies in France, UAE, Canada, and beyond — remotely from Morocco.',
                'body'    => 'Working with international clients as a freelance developer based in Morocco requires clear async communication, a structured delivery process, and the right tools for time-zone overlap. I typically work with founders and CTOs in France, Belgium, UAE, and Canada — often in French or English. This post covers my working process from first contact to delivery: scoping, contracts, async standups, milestone-based billing, and how I handle the time zone gap without it becoming a problem.',
                'seo_title' => 'Freelance Full-Stack Developer Morocco | Remote Laravel & React | Youssef Youyou',
                'seo_description' => 'Freelance full-stack developer based in Morocco working with clients in France, UAE, and Canada. Laravel, React, SaaS development. Contact Youssef Youyou.',
            ],
        ];

        foreach ($posts as $index => $post) {
            $seoData = Arr::only($post, ['seo_title', 'seo_description']);
            $postData = Arr::except($post, ['seo_title', 'seo_description']);

            $model = Post::query()->firstOrCreate(
                ['slug' => $post['slug']],
                array_merge([
                    'status'       => 'published',
                    'category_id'  => $strategyCategoryId,
                    'published_at' => Carbon::now()->subDays($index),
                ], $postData)
            );

            if ($architectureTagId) {
                $model->tags()->syncWithoutDetaching([$architectureTagId]);
            }

            if (!empty($seoData) && class_exists(SeoMeta::class)) {
                SeoMeta::query()->updateOrCreate(
                    ['seoable_type' => Post::class, 'seoable_id' => $model->id],
                    [
                        'meta_title'       => $seoData['seo_title'],
                        'meta_description' => $seoData['seo_description'],
                        'og_title'         => $seoData['seo_title'],
                        'og_description'   => $seoData['seo_description'],
                        'canonical'        => 'https://www.youssefyouyou.com/en/blog/' . $model->slug,
                    ]
                );
            }
        }
    }

    // -------------------------------------------------------------------------
    // Leads
    // -------------------------------------------------------------------------

    private function seedLeads(): void
    {
        Lead::query()->firstOrCreate(
            ['email' => 'hello@client.com'],
            [
                'name'    => 'Sample Lead',
                'company' => 'Global Ventures',
                'budget'  => '$15k - $30k',
                'message' => 'Looking for a Laravel + React partner to ship a SaaS MVP.',
                'locale'  => 'en',
                'source'  => 'seed',
            ]
        );
    }

    // -------------------------------------------------------------------------
    // Global SEO Meta (homepage, services index, projects index)
    // -------------------------------------------------------------------------

    private function seedSeoMeta(): void
    {
        if (!class_exists(SeoMeta::class)) {
            return;
        }

        $pages = [
            [
                'key'         => 'home',
                'title'       => 'Youssef Youyou — Full-Stack Engineer | Laravel & React SaaS Developer Morocco',
                'description' => 'Youssef Youyou is a full-stack engineer based in Morocco specializing in Laravel and React SaaS platforms, fintech, and enterprise integrations. Available for remote projects.',
                'canonical'   => 'https://www.youssefyouyou.com',
                'og_title'    => 'Youssef Youyou — Laravel & React SaaS Developer | Morocco',
            ],
            [
                'key'         => 'projects',
                'title'       => 'Projects — SaaS, FinTech & Enterprise Platforms | Youssef Youyou',
                'description' => 'Browse 20+ real-world SaaS, fintech, logistics, and healthtech platforms designed and shipped by full-stack engineer Youssef Youyou using Laravel, React, and modern cloud stacks.',
                'canonical'   => 'https://www.youssefyouyou.com/en/projects',
                'og_title'    => 'SaaS & Enterprise Projects | Youssef Youyou Portfolio',
            ],
            [
                'key'         => 'services',
                'title'       => 'Services — Custom SaaS Development & Enterprise Integrations | Youssef Youyou',
                'description' => 'Hire Youssef Youyou for custom SaaS platform development, enterprise API integrations, and architecture audits. Laravel, React, full-stack. Remote-friendly.',
                'canonical'   => 'https://www.youssefyouyou.com/en/services',
                'og_title'    => 'SaaS Development Services | Youssef Youyou',
            ],
            [
                'key'         => 'blog',
                'title'       => 'Blog — Laravel, SaaS Architecture & Full-Stack Engineering | Youssef Youyou',
                'description' => 'Technical articles on Laravel SaaS development, multi-tenant architecture, Stripe billing, DevOps, and full-stack engineering by Youssef Youyou.',
                'canonical'   => 'https://www.youssefyouyou.com/en/blog',
                'og_title'    => 'Laravel & SaaS Engineering Blog | Youssef Youyou',
            ],
            [
                'key'         => 'contact',
                'title'       => 'Contact Youssef Youyou — Hire a Laravel & React SaaS Developer',
                'description' => 'Get in touch with Youssef Youyou to discuss your SaaS project. Available via email (contact@youssefyouyou.com), WhatsApp (+212610090070), or book a free architecture call.',
                'canonical'   => 'https://www.youssefyouyou.com/en/contact',
                'og_title'    => 'Contact Youssef Youyou | Laravel SaaS Developer',
            ],
        ];

        foreach ($pages as $page) {
            SeoMeta::query()->updateOrCreate(
                ['key' => $page['key']],
                [
                    'meta_title'       => $page['title'],
                    'meta_description' => $page['description'],
                    'og_title'         => $page['og_title'] ?? $page['title'],
                    'canonical'        => $page['canonical'] ?? null,
                ]
            );
        }
    }
}
