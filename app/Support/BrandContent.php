<?php

namespace App\Support;

use Illuminate\Support\Facades\Lang;

class BrandContent
{
    public static function supportedLocales(): array
    {
        return ['en', 'fr', 'ar', 'es', 'de'];
    }

    public static function localeName(string $locale): string
    {
        return [
            'en' => 'English',
            'fr' => 'Francais',
            'ar' => 'العربية',
            'es' => 'Espanol',
            'de' => 'Deutsch',
        ][$locale] ?? strtoupper($locale);
    }

    public static function site(string $locale): array
    {
        $site = self::get($locale, 'site');

        $site['logo'] = asset('images/brand-mark.png');
        $site['portrait'] = asset('images/youyou-portrait.png');
        $site['social_image'] = asset('images/youyou-portrait.png');
        $site['website_url'] = config('app.url');
        $site['whatsapp_url'] = 'https://wa.me/212610090070';
        $site['phone_link'] = 'tel:+212610090070';
        $site['email_link'] = 'mailto:contact@youssefyouyou.com';
        $site['github_url'] = 'https://github.com/youssefyouyoudev';
        $site['linkedin_url'] = 'https://linkedin.com/in/youssefyouyoudev';
        $site['socials'] = [
            ['label' => 'GitHub', 'url' => $site['github_url']],
            ['label' => 'LinkedIn', 'url' => $site['linkedin_url']],
        ];
        $site['cv_url'] = route('resume', ['locale' => $locale]);
        $site['default_seo'] = array_merge($site['default_seo'] ?? [], [
            'image' => $site['social_image'],
            'image_alt' => $site['name'].' portrait and personal brand image',
        ]);
        $site['nav'] = [
            ['label' => $site['navigation']['home'], 'url' => route('home', ['locale' => $locale])],
            ['label' => $site['navigation']['about'], 'url' => route('about', ['locale' => $locale])],
            ['label' => $site['navigation']['services'], 'url' => route('services.index', ['locale' => $locale])],
            ['label' => $site['navigation']['projects'], 'url' => route('projects.index', ['locale' => $locale])],
            ['label' => $site['navigation']['skills'], 'url' => route('skills', ['locale' => $locale])],
            ['label' => $site['navigation']['experience'], 'url' => route('experience', ['locale' => $locale])],
            ['label' => $site['navigation']['contact'], 'url' => route('contact.create', ['locale' => $locale])],
        ];
        $site['footer_links'] = [
            ['label' => self::location($locale, 'developer-nador')['title'], 'url' => route('pages.location', ['locale' => $locale, 'slug' => 'developer-nador'])],
            ['label' => self::location($locale, 'developer-oriental')['title'], 'url' => route('pages.location', ['locale' => $locale, 'slug' => 'developer-oriental'])],
            ['label' => self::location($locale, 'developer-morocco')['title'], 'url' => route('pages.location', ['locale' => $locale, 'slug' => 'developer-morocco'])],
            ['label' => $site['navigation']['blog'], 'url' => route('blog.index', ['locale' => $locale])],
        ];

        return $site;
    }

    public static function home(string $locale): array
    {
        return self::landing($locale);
    }

    public static function homeShowcase(string $locale): array
    {
        $projects = array_values(self::projectCatalog($locale));

        return [
            'hero' => [
                'eyebrow' => 'Premium full-stack delivery for serious businesses',
                'title' => 'Websites, SaaS platforms, dashboards, and custom business software built to win trust fast.',
                'copy' => 'I help B2B and B2C brands launch polished digital products that look credible, feel premium, and support real business workflows from the first release.',
                'pills' => [
                    'Morocco and international client work',
                    'Business websites, SaaS, CRM, ERP, dashboards',
                    'Design, development, and deployment in one flow',
                ],
                'trust' => [
                    'Available for founder-led products, agencies, and established SMEs',
                    'Arabic, French, and English client communication',
                    'Fast intake through email and WhatsApp',
                ],
                'actions' => [
                    'primary' => 'Start a Project',
                    'secondary' => 'View Case Studies',
                    'tertiary' => 'Chat on WhatsApp',
                ],
                'metrics' => [
                    ['value' => '5+', 'label' => 'Years building production-ready systems'],
                    ['value' => '25+', 'label' => 'Projects across web apps, dashboards, and product sites'],
                    ['value' => 'B2B / B2C', 'label' => 'Positioning built for both sales and operations'],
                ],
            ],
            'trust_strip' => [
                'Premium presentation that feels client-ready',
                'Real products instead of generic portfolio placeholders',
                'Strong fit for SaaS, internal tools, CRM, ERP, and conversion-led websites',
                'Built in Morocco, ready for international briefs',
            ],
            'services' => [
                [
                    'title' => 'Business websites',
                    'copy' => 'Conversion-focused sites that make the business look established, trustworthy, and worth contacting.',
                    'value' => 'Stronger first impression and cleaner lead generation.',
                ],
                [
                    'title' => 'Custom web apps',
                    'copy' => 'Purpose-built systems for workflows, client portals, dashboards, and operational visibility.',
                    'value' => 'Less manual work and a clearer internal process.',
                ],
                [
                    'title' => 'SaaS platforms',
                    'copy' => 'Premium product experiences with onboarding, admin systems, and scalable architecture.',
                    'value' => 'A product that feels ready to sell, demo, and grow.',
                ],
                [
                    'title' => 'CRM / ERP systems',
                    'copy' => 'Role-based tools for sales, inventory, teams, finance, and business operations.',
                    'value' => 'Better control, reporting, and day-to-day execution.',
                ],
                [
                    'title' => 'Dashboards and internal tools',
                    'copy' => 'Readable interfaces for analytics, team activity, approvals, and operational metrics.',
                    'value' => 'Decision-ready visibility without clutter.',
                ],
                [
                    'title' => 'API and automation layers',
                    'copy' => 'Backend workflows, integrations, and system glue that keep products moving cleanly.',
                    'value' => 'Stronger foundations for scale, sync, and future features.',
                ],
            ],
            'proof' => [
                [
                    'title' => 'I design for trust, not just aesthetics',
                    'copy' => 'The interface has to look premium enough for a buyer and stay practical enough for real usage after launch.',
                ],
                [
                    'title' => 'I build around business context',
                    'copy' => 'Pricing, onboarding, admin flows, proof, and contact friction are treated as part of the product, not afterthoughts.',
                ],
                [
                    'title' => 'I can own the full stack end to end',
                    'copy' => 'Strategy, UI, backend logic, responsive behavior, and launch readiness move together in one system.',
                ],
            ],
            'why' => [
                [
                    'title' => 'Product thinking with execution',
                    'copy' => 'Useful when you need someone who can translate a business goal into UX, architecture, and shipping decisions.',
                ],
                [
                    'title' => 'Premium UI without agency bloat',
                    'copy' => 'The end result should look deliberate, modern, and commercially credible without slowing delivery down.',
                ],
                [
                    'title' => 'Built for real operations',
                    'copy' => 'Strong fit for teams dealing with bookings, leads, inventory, approvals, invoicing, and admin-heavy workflows.',
                ],
                [
                    'title' => 'Clear communication and fast iteration',
                    'copy' => 'Clients should always understand what is being built, why it matters, and what the next decision is.',
                ],
            ],
            'stack' => [
                ['title' => 'Backend', 'items' => ['Laravel', 'PHP', 'REST APIs', 'Authentication', 'Queues', 'Business logic']],
                ['title' => 'Frontend', 'items' => ['Blade', 'Tailwind CSS', 'React', 'Responsive UI', 'Design systems', 'Motion polish']],
                ['title' => 'Data and ops', 'items' => ['MySQL', 'PostgreSQL', 'Deployment', 'VPS hosting', 'Performance', 'SEO']],
                ['title' => 'Business systems', 'items' => ['SaaS architecture', 'CRM flows', 'ERP modules', 'Dashboards', 'Automation', 'Admin UX']],
            ],
            'process' => [
                ['step' => '01', 'title' => 'Position the product', 'copy' => 'Clarify what the product sells, who it serves, and what trust signals it needs.'],
                ['step' => '02', 'title' => 'Design the experience', 'copy' => 'Map the key flows, visual hierarchy, and the screens that carry the business value.'],
                ['step' => '03', 'title' => 'Build the system', 'copy' => 'Ship clean frontend and backend layers that support the experience without feeling fragile.'],
                ['step' => '04', 'title' => 'Launch with confidence', 'copy' => 'Refine responsiveness, polish the details, and make the final result feel ready for clients.'],
            ],
            'cta' => [
                'eyebrow' => 'Need a stronger product presence?',
                'title' => 'Let us turn the next build into a serious business asset.',
                'copy' => 'Ideal for product launches, redesigns, SaaS platforms, dashboards, CRM systems, and premium websites that need to convert better.',
            ],
            'projects' => $projects,
        ];
    }

    public static function landing(string $locale): array
    {
        $base = [
            'seo' => [
                'title' => 'Youssef Youyou | Senior Full-Stack Developer in Morocco for Websites, Web Apps, Dashboards, APIs, and SaaS',
                'description' => 'Senior Full-Stack Developer in Morocco building business-ready websites, custom web apps, dashboards, APIs, and SaaS systems for serious companies and founders.',
                'keywords' => 'senior full-stack developer Morocco, Laravel developer Morocco, React developer Morocco, SaaS developer Morocco, API developer Morocco, web developer Nador',
                'type' => 'website',
            ],
            'nav' => [
                'services' => 'Services',
                'stack' => 'Stack',
                'projects' => 'Projects',
                'proof' => 'Proof',
                'process' => 'Process',
                'contact' => 'Contact',
                'about' => 'About',
                'expertise' => 'Expertise',
                'industries' => 'Industries',
                'insights' => 'Insights',
                'hire' => 'Hire Me',
                'faq' => 'FAQ',
                'privacy' => 'Privacy',
                'terms' => 'Terms',
                'trust' => 'Trust',
                'start_project' => 'Start a Project',
                'tech_stack' => 'Tech Stack',
                'navigate' => 'Navigate',
                'reach_out' => 'Reach Out',
                'footer_eyebrow' => 'Senior systems builder',
                'footer_title' => 'I build powerful, scalable systems that help businesses grow.',
                'footer_copy' => 'Web apps, SaaS platforms, mobile and desktop applications, APIs, backend systems, and AI-enabled workflows designed for serious business use.',
                'language' => 'Language',
                'language_short' => 'Lang',
            ],
            'hero' => [
                'eyebrow' => 'Senior Full-Stack Developer in Morocco',
                'title' => 'I build business-ready websites, web apps, dashboards, APIs, and SaaS systems.',
                'copy' => 'I help companies, founders, and Moroccan businesses launch faster, improve operations, and ship digital products that feel credible from the first click.',
                'pills' => ['5+ years experience', '20+ happy clients / 25+ completed projects', 'Laravel, React, APIs, SaaS'],
                'metrics' => [
                    ['title' => 'Business websites', 'copy' => 'Sites built to improve trust, clarity, and lead flow.'],
                    ['title' => 'Custom platforms', 'copy' => 'Dashboards, internal tools, APIs, and SaaS systems built around real workflows.'],
                    ['title' => 'Clean delivery', 'copy' => 'Architecture, UI, deployment, and support handled as one serious build process.'],
                ],
            ],
            'proof_strip' => ['5+ years experience', '20+ happy clients', '25+ completed projects', '10+ large systems', 'Available for Morocco and international work'],
            'services_intro' => [
                'eyebrow' => 'Services',
                'title' => 'Systems built for businesses that need more than a basic website.',
                'copy' => 'Each service is designed to solve a practical business problem, support growth, and give you a stronger technical foundation.',
            ],
            'services' => [
                ['icon' => 'WD', 'title' => 'Web Development', 'description' => 'Modern websites and platforms built for speed, clarity, and conversion.', 'value' => 'Turn your online presence into a stronger sales and trust channel.'],
                ['icon' => 'SA', 'title' => 'SaaS Development', 'description' => 'Scalable SaaS products with clean architecture, user flows, and admin logic.', 'value' => 'Launch software that is ready to sell, grow, and evolve.'],
                ['icon' => 'MB', 'title' => 'Mobile Apps', 'description' => 'Mobile experiences connected to real backend systems and business workflows.', 'value' => 'Reach users where they are with smoother product adoption.'],
                ['icon' => 'DT', 'title' => 'Desktop Apps', 'description' => 'Desktop tools for internal operations, specialized workflows, and data-heavy use cases.', 'value' => 'Improve team execution with software tailored to how the business works.'],
                ['icon' => 'API', 'title' => 'API Development', 'description' => 'Reliable backend services, integrations, and data flows for modern applications.', 'value' => 'Create cleaner systems that support scale, automation, and future features.'],
                ['icon' => 'AI', 'title' => 'AI / Machine Learning', 'description' => 'AI-powered workflows, prediction layers, and intelligent automation features.', 'value' => 'Use AI where it creates operational leverage instead of noise.'],
                ['icon' => 'OPS', 'title' => 'DevOps & Deployment', 'description' => 'Infrastructure, release flow, environments, and production-ready delivery.', 'value' => 'Ship with fewer surprises and a stronger path to stable growth.'],
            ],
            'stack_intro' => [
                'eyebrow' => 'Tech Stack',
                'title' => 'A stack built for modern products, clean systems, and serious delivery.',
                'copy' => 'The goal is not to list tools for decoration. The goal is to show the technical range needed to build, ship, and scale real platforms.',
            ],
            'stack_groups' => [
                ['title' => 'Backend', 'items' => ['Node.js', 'PHP', 'Python', 'Java', 'C#', 'Laravel', 'Django', 'Flask', 'Express.js']],
                ['title' => 'Frontend', 'items' => ['React', 'Vue', 'Angular']],
                ['title' => 'Database', 'items' => ['MySQL', 'PostgreSQL', 'MongoDB']],
                ['title' => 'Other', 'items' => ['DevOps', 'VPS / AWS / Hostinger', 'Deployment', 'AI / ML / Deep Learning']],
            ],
            'projects_intro' => [
                'eyebrow' => 'Selected Work',
                'title' => 'Featured builds with clear business context, technical ownership, and delivery focus.',
                'copy' => 'These case studies are framed to show what was being built, what problem had to be solved, what stack was used, and how the work moved the product forward.',
            ],
            'projects' => [
                ['title' => 'ERP Systems', 'description' => 'Large internal platforms for operations, inventory, finance, and role-based workflows.', 'stack' => ['Laravel', 'React', 'PostgreSQL'], 'preview' => 'preview-erp'],
                ['title' => 'School Management System', 'description' => 'Academic operations, reporting, user permissions, and streamlined admin processes.', 'stack' => ['PHP', 'MySQL', 'Bootstrap'], 'preview' => 'preview-school'],
                ['title' => 'SaaS Platforms', 'description' => 'Subscription-ready products with dashboards, API layers, and structured product architecture.', 'stack' => ['Laravel', 'Vue', 'Stripe-ready'], 'preview' => 'preview-saas'],
                ['title' => 'Mobile Apps', 'description' => 'Connected mobile experiences backed by secure APIs and business logic.', 'stack' => ['React', 'REST APIs', 'Node.js'], 'preview' => 'preview-mobile'],
                ['title' => 'Analytics Dashboards', 'description' => 'Clear data views, KPI tracking, and decision-ready interfaces for teams and management.', 'stack' => ['React', 'Charts', 'Express.js'], 'preview' => 'preview-dashboard'],
                ['title' => 'Backend Platforms', 'description' => 'High-performance API systems for integrations, automation, and multi-product delivery.', 'stack' => ['Python', 'Flask', 'MongoDB'], 'preview' => 'preview-api'],
            ],
            'authority_intro' => [
                'eyebrow' => 'Proof',
                'title' => 'Credibility should be easy to verify at a glance.',
                'copy' => 'One concise proof section is stronger than repeating the same claims. These numbers stay consistent, and the project work shows what they mean in practice.',
            ],
            'stats' => [
                ['value' => 5, 'suffix' => '+', 'label' => 'Years of experience'],
                ['value' => 20, 'suffix' => '+', 'label' => 'Happy clients'],
                ['value' => 25, 'suffix' => '+', 'label' => 'Completed projects'],
                ['value' => 10, 'suffix' => '+', 'label' => 'Large systems delivered'],
            ],
            'why_intro' => [
                'eyebrow' => 'Why Choose Me',
                'title' => 'Built for clients who want one technical partner who can own the system end to end.',
                'copy' => 'The work is not just code delivery. It is scope clarity, architecture, interface quality, dependable communication, and launch-ready execution.',
            ],
            'reasons' => [
                ['title' => 'Full-stack depth', 'copy' => 'Frontend, backend, database, infrastructure, and product thinking in one execution layer.'],
                ['title' => 'Business-ready systems', 'copy' => 'Built around growth, operations, and real usage instead of surface-level design.'],
                ['title' => 'Performance mindset', 'copy' => 'Fast loading, efficient flows, and clean implementation where quality is visible.'],
                ['title' => 'Scalable architecture', 'copy' => 'Strong system structure that supports future features, integrations, and larger teams.'],
                ['title' => 'Security awareness', 'copy' => 'Authentication, access control, API structure, and production decisions handled with care.'],
                ['title' => 'AI capability', 'copy' => 'Practical AI features and automation where they improve speed, insight, or output.'],
            ],
            'industries_intro' => [
                'eyebrow' => 'Industries and Use Cases',
                'title' => 'Built for products, internal systems, and businesses with real operational complexity.',
                'copy' => 'I work best where product thinking, system design, and business logic need to move together.',
            ],
            'industries' => [
                ['title' => 'Startups and SaaS founders', 'copy' => 'MVPs, platforms, dashboards, billing-ready systems, and product foundations built to evolve.'],
                ['title' => 'Education and school systems', 'copy' => 'Management platforms, workflows, reporting, roles, and admin operations that stay usable at scale.'],
                ['title' => 'SMEs and service businesses', 'copy' => 'Business systems, client portals, internal tools, automation, and processes that reduce manual work.'],
                ['title' => 'Operations and enterprise workflows', 'copy' => 'ERP-like platforms, dashboards, approval flows, and backend-heavy systems with structured roles and data.'],
            ],
            'trust_intro' => [
                'eyebrow' => 'Trust and Proof',
                'title' => 'Trust built with clear capability, not invented claims.',
                'copy' => 'Where proof is still private or unpublished, the layout makes space for real case studies, real testimonials, and real brand assets only.',
            ],
            'trust_placeholders' => [
                ['title' => 'Client testimonials placeholder', 'copy' => 'Replace with real founder, client, or recruiter feedback. No invented quotes.'],
                ['title' => 'Client logos placeholder', 'copy' => 'Replace with real company marks only after approval.'],
                ['title' => 'Capabilities deck placeholder', 'copy' => 'Add a polished PDF or one-pager for agencies, recruiters, and B2B leads.'],
            ],
            'process_intro' => [
                'eyebrow' => 'Process',
                'title' => 'A clear build process from first brief to launch.',
                'copy' => 'Simple steps keep scope clearer, decisions faster, and delivery more professional from day one.',
            ],
            'process' => [
                ['step' => '01', 'title' => 'Understand', 'copy' => 'Map the business goal, user flow, blockers, and technical constraints.'],
                ['step' => '02', 'title' => 'Build', 'copy' => 'Design the system, build the core, and keep the product focused.'],
                ['step' => '03', 'title' => 'Launch', 'copy' => 'Deploy cleanly, validate the experience, and ship with confidence.'],
                ['step' => '04', 'title' => 'Scale', 'copy' => 'Improve performance, extend features, and support business growth.'],
            ],
            'final_cta' => [
                'eyebrow' => 'Ready to build',
                'title' => 'Let\'s build your system.',
                'copy' => 'Web apps, SaaS, AI workflows, backend platforms, and polished product delivery for serious business goals.',
                'primary' => 'Start your project today',
                'secondary' => 'WhatsApp',
            ],
            'contact_intro' => [
                'eyebrow' => 'Contact',
                'title' => 'Start with a short brief and the next step gets easier.',
                'copy' => 'Tell me what you want to build, what is blocking growth, and what kind of system or delivery support you need next.',
            ],
            'contact_badges' => ['Fast response', 'Business-first thinking', 'Scalable execution'],
            'faq_intro' => [
                'eyebrow' => 'FAQ',
                'title' => 'The questions serious clients usually ask before a project starts.',
                'copy' => 'Clear answers reduce hesitation, align scope faster, and make the next step easier.',
            ],
            'faq' => [
                ['question' => 'What do you build?', 'answer' => 'Websites, web applications, SaaS platforms, mobile apps, desktop tools, APIs, dashboards, ERP-like systems, automation tools, and AI-enabled product features.'],
                ['question' => 'Do you work internationally?', 'answer' => 'Yes. I can work with clients in Morocco and internationally, especially where communication, product clarity, and reliable delivery matter.'],
                ['question' => 'Can you modernize or extend an existing app?', 'answer' => 'Yes. I can improve architecture, performance, UI, backend structure, deployment flow, and system maintainability without forcing a full rebuild when it is not necessary.'],
                ['question' => 'Do you handle deployment and infrastructure too?', 'answer' => 'Yes. Deployment, server setup, VPS environments, hosting, release readiness, and production hardening are part of the delivery when needed.'],
                ['question' => 'Can you build AI-enabled systems?', 'answer' => 'Yes. AI and automation are strongest when connected to useful workflows, internal tooling, better user experience, or smarter operations.'],
            ],
        ];

        $overrides = match ($locale) {
            'fr' => [
                'nav' => ['about' => 'A propos', 'projects' => 'Projets', 'proof' => 'Preuves', 'process' => 'Processus', 'expertise' => 'Expertise', 'industries' => 'Secteurs', 'insights' => 'Insights', 'hire' => 'Disponibilite', 'faq' => 'FAQ', 'privacy' => 'Confidentialite', 'terms' => 'Conditions', 'trust' => 'Confiance', 'start_project' => 'Demarrer un projet', 'tech_stack' => 'Stack technique', 'navigate' => 'Navigation', 'reach_out' => 'Contact direct', 'language' => 'Langue', 'language_short' => 'Lang'],
                'hero' => ['eyebrow' => 'Developpeur Full-Stack Senior | Web, SaaS, Mobile, IA', 'title' => 'Developpeur Full-Stack Senior pour applications web evolutives, SaaS et systemes bases sur l IA', 'copy' => 'J aide les entreprises a creer des applications performantes, automatiser leurs processus et passer a l echelle avec des technologies modernes.', 'pills' => ['5+ ans d experience', 'Web apps, SaaS, mobile, desktop, APIs', 'Partenaire technique oriente business'], 'metrics' => [['title' => 'Execution senior', 'copy' => 'Une livraison produit serieuse, du cadrage a la production.'], ['title' => 'De l IA au deployment', 'copy' => 'Architecture, interfaces, automatisation et infrastructure dans un meme flux.'], ['title' => 'Construit pour grandir', 'copy' => 'Des systemes penses pour soutenir utilisateurs, equipes et croissance business.']]],
                'proof_strip' => ['5+ ans d experience', '20+ clients satisfaits', '25+ projets livres', '10+ grands systemes', 'Web, SaaS, mobile, desktop, IA'],
                'services_intro' => ['title' => 'Des systemes pour les entreprises qui ont besoin de plus qu un simple site web.', 'copy' => 'Chaque service repond a un vrai besoin business, soutient la croissance et apporte une base technique solide.'],
                'stack_intro' => ['eyebrow' => 'Stack technique', 'title' => 'Une stack pensee pour des produits modernes, propres et serieux.', 'copy' => 'Le but n est pas d afficher des outils. Le but est de montrer la capacite technique necessaire pour construire, lancer et faire evoluer de vraies plateformes.'],
                'projects_intro' => ['eyebrow' => 'Travaux selectionnes', 'title' => 'Des types de projets qui montrent une vraie profondeur technique.', 'copy' => 'Presente comme du travail produit: objectif clair, logique systeme visible et presentation premium.'],
                'authority_intro' => ['eyebrow' => 'Credibilite', 'title' => 'Une impression business forte en quelques secondes.', 'copy' => 'Cette structure sert a installer rapidement la confiance: seniorite, volume et capacite produit sans transformer la page en CV.'],
                'stats' => [['value' => 5, 'suffix' => '+', 'label' => 'Annees d experience'], ['value' => 20, 'suffix' => '+', 'label' => 'Clients satisfaits'], ['value' => 25, 'suffix' => '+', 'label' => 'Projets realises'], ['value' => 10, 'suffix' => '+', 'label' => 'Grands systemes livres']],
                'why_intro' => ['eyebrow' => 'Pourquoi moi', 'title' => 'Pour les clients qui veulent un developpeur serieux capable de porter tout le systeme.', 'copy' => 'Ce positionnement est volontairement simple: execution moderne, systemes fiables et decisions produit alignees avec la valeur business.'],
                'reasons' => [
                    ['title' => 'Profondeur full-stack', 'copy' => 'Frontend, backend, base de donnees, infrastructure et logique produit dans une meme execution.'],
                    ['title' => 'Systemes prets pour le business', 'copy' => 'Concu pour la croissance, les operations et les usages reels plutot qu un simple effet visuel.'],
                    ['title' => 'Mentalite performance', 'copy' => 'Chargement rapide, parcours efficaces et implementation propre ou la qualite se voit.'],
                    ['title' => 'Architecture evolutive', 'copy' => 'Une structure technique solide pour les futures features, integrations et equipes plus larges.'],
                    ['title' => 'Conscience securite', 'copy' => 'Authentification, controle d acces, structure API et decisions production gerees avec serieux.'],
                    ['title' => 'Capacite IA', 'copy' => 'Des usages IA pratiques quand ils ameliorent vitesse, insight ou productivite.'],
                ],
                'process_intro' => ['eyebrow' => 'Processus', 'title' => 'Un flux de travail moderne de l idee jusqu a l echelle.', 'copy' => 'Des etapes claires reduisent la friction, accelerent le projet et rendent la collaboration plus professionnelle.'],
                'process' => [
                    ['step' => '01', 'title' => 'Comprendre', 'copy' => 'Clarifier le but business, les utilisateurs, les blocages et les contraintes techniques.'],
                    ['step' => '02', 'title' => 'Construire', 'copy' => 'Structurer le systeme, construire le coeur du produit et garder le scope focalise.'],
                    ['step' => '03', 'title' => 'Lancer', 'copy' => 'Deployer proprement, valider l experience et sortir avec confiance.'],
                    ['step' => '04', 'title' => 'Faire evoluer', 'copy' => 'Optimiser les performances, ajouter des fonctions et soutenir la croissance.'],
                ],
                'final_cta' => ['eyebrow' => 'Pret a construire', 'title' => 'Construisons votre systeme.', 'copy' => 'Applications web, SaaS, workflows IA, plateformes backend et livraison premium pour des objectifs business serieux.', 'primary' => 'Demarrer votre projet', 'secondary' => 'WhatsApp'],
                'contact_intro' => ['title' => 'Commencez la conversation avec un partenaire technique serieux.', 'copy' => 'Expliquez ce que vous voulez construire, ce qui ralentit votre activite et le type de systeme dont vous avez besoin.'],
                'contact_badges' => ['Reponse rapide', 'Vision business', 'Execution evolutive'],
                'faq_intro' => ['eyebrow' => 'FAQ', 'title' => 'Les questions que les clients serieux posent avant de demarrer.', 'copy' => 'Des reponses claires reduisent l hesitation, cadrent le scope plus vite et rendent la prochaine etape plus simple.'],
                'faq' => [
                    ['question' => 'Que construisez-vous ?', 'answer' => 'Sites web, web applications, plateformes SaaS, applications mobiles, outils desktop, APIs, dashboards, systemes type ERP, automatisations et fonctions produits basees sur l IA.'],
                    ['question' => 'Travaillez-vous a l international ?', 'answer' => 'Oui. Je peux collaborer avec des clients au Maroc et a l international quand la communication, la clarte produit et la fiabilite comptent.'],
                    ['question' => 'Pouvez-vous moderniser une application existante ?', 'answer' => 'Oui. Je peux ameliorer architecture, performance, UI, backend, deployment et maintenabilite sans imposer une reconstruction totale inutile.'],
                    ['question' => 'Gerez-vous aussi le deployment et l infrastructure ?', 'answer' => 'Oui. Deployment, configuration serveur, environnements VPS, hebergement et readiness production font partie de la mission quand il le faut.'],
                    ['question' => 'Pouvez-vous construire des systemes avec IA ?', 'answer' => 'Oui. L IA et l automatisation sont surtout utiles quand elles renforcent les workflows, les outils internes, l experience utilisateur ou l efficacite operationnelle.'],
                ],
            ],
            'ar' => [
                'nav' => ['about' => 'نبذة', 'services' => 'الخدمات', 'stack' => 'التقنيات', 'projects' => 'المشاريع', 'proof' => 'الثقة', 'process' => 'العملية', 'contact' => 'تواصل', 'expertise' => 'الخبرات', 'industries' => 'القطاعات', 'insights' => 'المقالات', 'hire' => 'التعاون', 'faq' => 'الاسئلة', 'privacy' => 'الخصوصية', 'terms' => 'الشروط', 'trust' => 'الثقة', 'start_project' => 'ابدأ مشروعك', 'tech_stack' => 'التقنيات', 'navigate' => 'التنقل', 'reach_out' => 'تواصل مباشر', 'language' => 'اللغة', 'language_short' => 'لغة'],
                'hero' => ['eyebrow' => 'مطور فل ستاك سينيور | ويب، SaaS، موبايل، ذكاء اصطناعي', 'title' => 'مطور فل ستاك سينيور يبني تطبيقات ويب قابلة للتوسع ومنصات SaaS وانظمة مدعومة بالذكاء الاصطناعي', 'copy' => 'اساعد الشركات على بناء تطبيقات عالية الاداء و اتمتة العمليات و التوسع باستخدام تقنيات حديثة.', 'pills' => ['5+ سنوات خبرة', 'ويب، SaaS، موبايل، سطح مكتب، APIs', 'شريك تقني يفهم الاعمال']],
                'proof_strip' => ['5+ سنوات خبرة', '20+ عميل سعيد', '25+ مشروع منجز', '10+ انظمة كبيرة', 'ويب، SaaS، موبايل، سطح مكتب، ذكاء اصطناعي'],
                'services_intro' => ['eyebrow' => 'الخدمات', 'title' => 'انظمة للشركات التي تحتاج اكثر من مجرد موقع عادي.', 'copy' => 'كل خدمة مصممة لحل مشكلة عملية و دعم النمو و منحك اساسا تقنيا اقوى.'],
                'stack_intro' => ['eyebrow' => 'التقنيات', 'title' => 'تقنيات مبنية لمنتجات حديثة و انظمة نظيفة و تنفيذ جاد.', 'copy' => 'الهدف ليس عرض الادوات فقط بل اظهار المدى التقني اللازم لبناء منصات حقيقية و اطلاقها و توسيعها.'],
                'projects_intro' => ['eyebrow' => 'اعمال مختارة', 'title' => 'انواع مشاريع تظهر قوة تقنية حقيقية.', 'copy' => 'معروضة كعمل منتج حقيقي: هدف واضح و تفكير معماري و تقديم احترافي.'],
                'authority_intro' => ['eyebrow' => 'الثقة', 'title' => 'انطباع قوي عن الاحتراف خلال ثوان.', 'copy' => 'هذا الهيكل يعطي ثقة مباشرة: خبرة و حجم اعمال و قدرة على بناء منتجات حقيقية بدون تحويل الصفحة الى سيرة ذاتية.'],
                'stats' => [['value' => 5, 'suffix' => '+', 'label' => 'سنوات الخبرة'], ['value' => 20, 'suffix' => '+', 'label' => 'عملاء سعداء'], ['value' => 25, 'suffix' => '+', 'label' => 'مشاريع مكتملة'], ['value' => 10, 'suffix' => '+', 'label' => 'انظمة كبيرة']],
                'why_intro' => ['eyebrow' => 'لماذا انا', 'title' => 'للعملاء الذين يريدون مطورا جادا يستطيع تحمل مسؤولية النظام بالكامل.', 'copy' => 'هذا التموضع بسيط عن قصد: تنفيذ حديث و انظمة موثوقة و قرارات تقنية مرتبطة بقيمة العمل.'],
                'process_intro' => ['eyebrow' => 'العملية', 'title' => 'مسار عمل حديث من الفكرة الى التوسع.', 'copy' => 'الخطوات الواضحة تقلل الاحتكاك و تسرع المشروع و تجعل التعاون اكثر احترافية.'],
                'final_cta' => ['eyebrow' => 'جاهز للبناء', 'title' => 'لنبدأ بناء نظامك.', 'copy' => 'تطبيقات ويب و SaaS و تدفقات ذكاء اصطناعي و منصات خلفية و تسليم احترافي يخدم اهدافا تجارية جادة.', 'primary' => 'ابدأ مشروعك اليوم', 'secondary' => 'واتساب'],
                'contact_intro' => ['eyebrow' => 'تواصل', 'title' => 'ابدأ المحادثة مع شريك تقني جاد.', 'copy' => 'اخبرني ماذا تريد ان تبني و ما الذي يبطئ عملك و نوع النظام الذي تحتاجه بعد ذلك.'],
                'contact_badges' => ['رد سريع', 'تفكير تجاري', 'تنفيذ قابل للتوسع'],
            ],
            'es' => [
                'nav' => ['about' => 'Sobre mi', 'services' => 'Servicios', 'projects' => 'Proyectos', 'proof' => 'Pruebas', 'process' => 'Proceso', 'contact' => 'Contacto', 'expertise' => 'Expertise', 'industries' => 'Industrias', 'insights' => 'Insights', 'hire' => 'Contratame', 'faq' => 'FAQ', 'privacy' => 'Privacidad', 'terms' => 'Terminos', 'trust' => 'Confianza', 'start_project' => 'Empezar proyecto', 'tech_stack' => 'Stack tecnico', 'navigate' => 'Navegar', 'reach_out' => 'Contacto directo', 'language' => 'Idioma', 'language_short' => 'Idioma'],
                'hero' => ['eyebrow' => 'Desarrollador Full-Stack Senior | Web, SaaS, Movil, IA', 'title' => 'Desarrollador Full-Stack Senior creando apps web escalables, SaaS y sistemas impulsados por IA', 'copy' => 'Ayudo a empresas a crear aplicaciones de alto rendimiento, automatizar procesos y escalar con tecnologias modernas.', 'pills' => ['5+ anos de experiencia', 'Web apps, SaaS, movil, escritorio, APIs', 'Socio tecnico orientado al negocio'], 'metrics' => [['title' => 'Ejecucion senior', 'copy' => 'Entrega de producto seria desde el concepto hasta produccion.'], ['title' => 'De IA a despliegue', 'copy' => 'Arquitectura, interfaces, automatizacion e infraestructura en un solo flujo.'], ['title' => 'Pensado para crecer', 'copy' => 'Sistemas disenados para usuarios, equipos y crecimiento del negocio.']]],
                'proof_strip' => ['5+ anos de experiencia', '20+ clientes satisfechos', '25+ proyectos completados', '10+ sistemas grandes', 'Web, SaaS, movil, escritorio, IA'],
                'services_intro' => ['eyebrow' => 'Servicios', 'title' => 'Sistemas para empresas que necesitan mas que un sitio web basico.', 'copy' => 'Cada servicio esta pensado para resolver un problema real, impulsar crecimiento y darte una base tecnica mas fuerte.'],
                'stack_intro' => ['eyebrow' => 'Stack tecnico', 'title' => 'Un stack pensado para productos modernos, sistemas limpios y entregas serias.', 'copy' => 'El objetivo no es mostrar herramientas por decoracion. El objetivo es demostrar el alcance tecnico necesario para construir, lanzar y escalar plataformas reales.'],
                'projects_intro' => ['eyebrow' => 'Trabajo seleccionado', 'title' => 'Tipos de proyectos que muestran alcance tecnico real.', 'copy' => 'Presentado como trabajo de producto: proposito claro, pensamiento de arquitectura y una presentacion premium.'],
                'authority_intro' => ['eyebrow' => 'Autoridad', 'title' => 'Una impresion de negocio mas fuerte en segundos.', 'copy' => 'Esta estructura genera confianza inmediata: seniority, volumen y capacidad de producto sin convertir la pagina en un CV.'],
                'stats' => [['value' => 5, 'suffix' => '+', 'label' => 'Anos de experiencia'], ['value' => 20, 'suffix' => '+', 'label' => 'Clientes satisfechos'], ['value' => 25, 'suffix' => '+', 'label' => 'Proyectos completados'], ['value' => 10, 'suffix' => '+', 'label' => 'Sistemas grandes entregados']],
                'why_intro' => ['eyebrow' => 'Por que yo', 'title' => 'Para clientes que quieren un desarrollador serio capaz de liderar todo el sistema.', 'copy' => 'Este posicionamiento es simple a proposito: ejecucion moderna, sistemas fiables y decisiones de producto conectadas al valor del negocio.'],
                'reasons' => [
                    ['title' => 'Profundidad full-stack', 'copy' => 'Frontend, backend, base de datos, infraestructura y pensamiento de producto en una sola capa de ejecucion.'],
                    ['title' => 'Sistemas listos para negocio', 'copy' => 'Construidos para crecimiento, operaciones y uso real, no solo para verse bien.'],
                    ['title' => 'Mentalidad de rendimiento', 'copy' => 'Carga rapida, flujos eficientes e implementacion limpia donde la calidad se nota.'],
                    ['title' => 'Arquitectura escalable', 'copy' => 'Estructura tecnica fuerte para futuras funciones, integraciones y equipos mas grandes.'],
                    ['title' => 'Criterio de seguridad', 'copy' => 'Autenticacion, control de acceso, estructura API y decisiones de produccion tratadas con cuidado.'],
                    ['title' => 'Capacidad con IA', 'copy' => 'Funciones practicas de IA y automatizacion cuando mejoran velocidad, claridad u operacion.'],
                ],
                'process_intro' => ['eyebrow' => 'Proceso', 'title' => 'Un flujo moderno desde la idea hasta la escala.', 'copy' => 'Pasos claros reducen friccion, mantienen el proyecto en movimiento y hacen que la colaboracion se sienta profesional desde el primer dia.'],
                'process' => [
                    ['step' => '01', 'title' => 'Entender', 'copy' => 'Definir objetivo de negocio, usuarios, bloqueos y limites tecnicos.'],
                    ['step' => '02', 'title' => 'Construir', 'copy' => 'Disenar el sistema, desarrollar el nucleo y mantener el producto enfocado.'],
                    ['step' => '03', 'title' => 'Lanzar', 'copy' => 'Desplegar con orden, validar la experiencia y salir con confianza.'],
                    ['step' => '04', 'title' => 'Escalar', 'copy' => 'Optimizar rendimiento, ampliar funciones y apoyar el crecimiento.'],
                ],
                'final_cta' => ['eyebrow' => 'Listo para construir', 'title' => 'Construyamos tu sistema.', 'copy' => 'Apps web, SaaS, flujos con IA, plataformas backend y una entrega pulida para objetivos de negocio serios.', 'primary' => 'Empieza tu proyecto hoy', 'secondary' => 'WhatsApp'],
                'contact_intro' => ['eyebrow' => 'Contacto', 'title' => 'Empieza la conversacion con un socio tecnico serio.', 'copy' => 'Cuentame que quieres construir, que esta frenando tu negocio y que tipo de sistema necesitas ahora.'],
                'contact_badges' => ['Respuesta rapida', 'Enfoque de negocio', 'Ejecucion escalable'],
                'faq_intro' => ['eyebrow' => 'FAQ', 'title' => 'Las preguntas que los clientes serios suelen hacer antes de empezar.', 'copy' => 'Respuestas claras reducen dudas, alinean el alcance mas rapido y facilitan el siguiente paso.'],
                'faq' => [
                    ['question' => 'Que construyes?', 'answer' => 'Sitios web, aplicaciones web, plataformas SaaS, apps moviles, herramientas de escritorio, APIs, dashboards, sistemas tipo ERP, automatizaciones y funciones con IA.'],
                    ['question' => 'Trabajas internacionalmente?', 'answer' => 'Si. Puedo trabajar con clientes en Marruecos e internacionalmente cuando importan la comunicacion, la claridad del producto y una entrega fiable.'],
                    ['question' => 'Puedes modernizar o ampliar una app existente?', 'answer' => 'Si. Puedo mejorar arquitectura, rendimiento, UI, backend, despliegue y mantenibilidad sin forzar una reconstruccion total cuando no hace falta.'],
                    ['question' => 'Tambien gestionas despliegue e infraestructura?', 'answer' => 'Si. Despliegue, configuracion de servidores, entornos VPS, hosting y preparacion para produccion forman parte del trabajo cuando se necesita.'],
                    ['question' => 'Puedes construir sistemas con IA?', 'answer' => 'Si. La IA y la automatizacion son mas utiles cuando mejoran flujos de trabajo, herramientas internas, experiencia de usuario u operaciones.'],
                ],
            ],
            'de' => [
                'nav' => ['about' => 'Uber mich', 'services' => 'Leistungen', 'projects' => 'Projekte', 'proof' => 'Vertrauen', 'process' => 'Prozess', 'contact' => 'Kontakt', 'expertise' => 'Expertise', 'industries' => 'Branchen', 'insights' => 'Insights', 'hire' => 'Verfugbarkeit', 'faq' => 'FAQ', 'privacy' => 'Datenschutz', 'terms' => 'Bedingungen', 'trust' => 'Vertrauen', 'start_project' => 'Projekt starten', 'tech_stack' => 'Tech-Stack', 'navigate' => 'Navigation', 'reach_out' => 'Direkter Kontakt', 'language' => 'Sprache', 'language_short' => 'Sprache'],
                'hero' => ['eyebrow' => 'Senior Full-Stack-Entwickler | Web, SaaS, Mobile, KI', 'title' => 'Senior Full-Stack-Entwickler fur skalierbare Web-Apps, SaaS und KI-gestutzte Systeme', 'copy' => 'Ich helfe Unternehmen dabei, leistungsstarke Anwendungen zu bauen, Prozesse zu automatisieren und mit modernen Technologien zu skalieren.', 'pills' => ['5+ Jahre Erfahrung', 'Web-Apps, SaaS, Mobile, Desktop, APIs', 'Technischer Partner mit Business-Fokus'], 'metrics' => [['title' => 'Senior-Umsetzung', 'copy' => 'Ernsthafte Produktlieferung von der Idee bis zur Produktion.'], ['title' => 'Von KI bis Deployment', 'copy' => 'Architektur, Interfaces, Automatisierung und Infrastruktur in einem durchgehenden Ablauf.'], ['title' => 'Fur Wachstum gebaut', 'copy' => 'Systeme, die Nutzer, Teams und Geschaftswachstum sauber unterstutzen.']]],
                'proof_strip' => ['5+ Jahre Erfahrung', '20+ zufriedene Kunden', '25+ abgeschlossene Projekte', '10+ grosse Systeme', 'Web, SaaS, Mobile, Desktop, KI'],
                'services_intro' => ['eyebrow' => 'Leistungen', 'title' => 'Systeme fur Unternehmen, die mehr als nur eine einfache Website brauchen.', 'copy' => 'Jede Leistung ist darauf ausgelegt, ein echtes Business-Problem zu losen, Wachstum zu unterstutzen und eine starkere technische Grundlage zu schaffen.'],
                'stack_intro' => ['eyebrow' => 'Tech-Stack', 'title' => 'Ein Stack fur moderne Produkte, saubere Systeme und professionelle Umsetzung.', 'copy' => 'Es geht nicht darum, Tools aufzulisten. Es geht darum, die technische Breite zu zeigen, die fur echte Plattformen notwendig ist.'],
                'projects_intro' => ['eyebrow' => 'Ausgewahlte Arbeit', 'title' => 'Projektarten, die echte technische Tiefe zeigen.', 'copy' => 'Dargestellt wie Produktarbeit: klarer Zweck, sichtbares Architekturdenken und eine moderne Premium-Prasentation.'],
                'authority_intro' => ['eyebrow' => 'Autoritat', 'title' => 'Ein starker Business-Eindruck in wenigen Sekunden.', 'copy' => 'Diese Struktur schafft direkt Vertrauen: Senioritat, Umfang und Produktfahigkeit ohne Lebenslauf-Charakter.'],
                'stats' => [['value' => 5, 'suffix' => '+', 'label' => 'Jahre Erfahrung'], ['value' => 20, 'suffix' => '+', 'label' => 'Zufriedene Kunden'], ['value' => 25, 'suffix' => '+', 'label' => 'Abgeschlossene Projekte'], ['value' => 10, 'suffix' => '+', 'label' => 'Grosse Systeme geliefert']],
                'why_intro' => ['eyebrow' => 'Warum ich', 'title' => 'Fur Kunden, die einen ernsthaften Entwickler wollen, der das gesamte System verantworten kann.', 'copy' => 'Die Positionierung ist bewusst klar: moderne Umsetzung, verlassliche Systeme und Produktentscheidungen mit Business-Wirkung.'],
                'reasons' => [
                    ['title' => 'Full-Stack-Tiefe', 'copy' => 'Frontend, Backend, Datenbank, Infrastruktur und Produktdenken in einer zusammenhangenden Umsetzung.'],
                    ['title' => 'Business-taugliche Systeme', 'copy' => 'Gebaut fur Wachstum, Ablaufe und echte Nutzung statt nur fur Oberflachenwirkung.'],
                    ['title' => 'Performance-Fokus', 'copy' => 'Schnelle Ladezeiten, effiziente Flows und saubere Umsetzung, bei der Qualitat sichtbar wird.'],
                    ['title' => 'Skalierbare Architektur', 'copy' => 'Eine starke technische Struktur fur spatere Features, Integrationen und grossere Teams.'],
                    ['title' => 'Sicherheitsbewusstsein', 'copy' => 'Authentifizierung, Zugriffskontrolle, API-Struktur und Produktionsentscheidungen werden sorgfaltig behandelt.'],
                    ['title' => 'KI-Fahigkeit', 'copy' => 'Praktische KI-Funktionen und Automatisierung dort, wo sie Tempo, Einblick oder Output verbessern.'],
                ],
                'process_intro' => ['eyebrow' => 'Prozess', 'title' => 'Ein moderner Ablauf von der Idee bis zur Skalierung.', 'copy' => 'Klare Schritte reduzieren Reibung, halten das Projekt in Bewegung und machen die Zusammenarbeit professionell.'],
                'process' => [
                    ['step' => '01', 'title' => 'Verstehen', 'copy' => 'Business-Ziel, Nutzer, Blocker und technische Grenzen klar erfassen.'],
                    ['step' => '02', 'title' => 'Bauen', 'copy' => 'System strukturieren, den Kern entwickeln und den Fokus halten.'],
                    ['step' => '03', 'title' => 'Starten', 'copy' => 'Sauber deployen, die Erfahrung validieren und sicher live gehen.'],
                    ['step' => '04', 'title' => 'Skalieren', 'copy' => 'Performance verbessern, Funktionen erweitern und Wachstum unterstutzen.'],
                ],
                'final_cta' => ['eyebrow' => 'Bereit zum Bauen', 'title' => 'Lassen Sie uns Ihr System bauen.', 'copy' => 'Web-Apps, SaaS, KI-Workflows, Backend-Plattformen und hochwertige Umsetzung fur ernsthafte Business-Ziele.', 'primary' => 'Projekt heute starten', 'secondary' => 'WhatsApp'],
                'contact_intro' => ['eyebrow' => 'Kontakt', 'title' => 'Starten Sie das Gesprach mit einem ernsthaften technischen Partner.', 'copy' => 'Beschreiben Sie kurz, was Sie bauen wollen, was Ihr Wachstum bremst und welches System Sie als Nachstes brauchen.'],
                'contact_badges' => ['Schnelle Antwort', 'Business-Fokus', 'Skalierbare Umsetzung'],
                'faq_intro' => ['eyebrow' => 'FAQ', 'title' => 'Die Fragen, die ernsthafte Kunden vor Projektstart meistens stellen.', 'copy' => 'Klare Antworten reduzieren Zogern, klaren den Umfang schneller und erleichtern den nachsten Schritt.'],
                'faq' => [
                    ['question' => 'Was bauen Sie?', 'answer' => 'Websites, Webanwendungen, SaaS-Plattformen, Mobile Apps, Desktop-Tools, APIs, Dashboards, ERP-ahnliche Systeme, Automatisierungen und KI-gestutzte Produktfunktionen.'],
                    ['question' => 'Arbeiten Sie international?', 'answer' => 'Ja. Ich arbeite mit Kunden in Marokko und international, wenn Kommunikation, Produktklarheit und zuverlassige Umsetzung wichtig sind.'],
                    ['question' => 'Konnen Sie eine bestehende Anwendung modernisieren?', 'answer' => 'Ja. Ich kann Architektur, Performance, UI, Backend-Struktur, Deployment und Wartbarkeit verbessern, ohne standardmassig einen kompletten Neubau zu erzwingen.'],
                    ['question' => 'Ubernehmen Sie auch Deployment und Infrastruktur?', 'answer' => 'Ja. Deployment, Server-Setup, VPS-Umgebungen, Hosting und Production Readiness gehoren bei Bedarf dazu.'],
                    ['question' => 'Konnen Sie KI-gestutzte Systeme bauen?', 'answer' => 'Ja. KI und Automatisierung sind besonders stark, wenn sie Workflows, interne Tools, Nutzererlebnis oder operative Ablaufe verbessern.'],
                ],
            ],
            default => [],
        };

        return array_replace_recursive($base, $overrides);
    }

    public static function about(string $locale): array
    {
        return self::get($locale, 'about');
    }

    public static function contact(string $locale): array
    {
        return self::get($locale, 'contact');
    }

    public static function servicesIndex(string $locale): array
    {
        $page = self::get($locale, 'services.index');
        $page['items'] = array_values(self::serviceCatalog($locale));

        return $page;
    }

    public static function serviceCatalog(string $locale): array
    {
        return self::addSlugs(self::get($locale, 'services.items'));
    }

    public static function service(string $locale, string $slug): ?array
    {
        return self::serviceCatalog($locale)[$slug] ?? null;
    }

    public static function projectsIndex(string $locale): array
    {
        return [
            'seo' => [
                'title' => 'Case Studies | Youssef Youyou',
                'description' => 'Premium case studies from SaaS, CRM, streaming, ERP, and billing projects by Youssef Youyou.',
                'keywords' => 'portfolio case studies Morocco, SaaS designer developer Morocco, CRM ERP developer Morocco',
                'type' => 'website',
            ],
            'eyebrow' => 'Selected work',
            'title' => 'Case studies framed like products, not random portfolio cards.',
            'copy' => 'Each project is presented with business context, problem framing, product direction, and a cleaner visual story so clients can see real capability fast.',
            'items' => array_values(self::projectCatalog($locale)),
        ];
    }

    public static function projectCatalog(string $locale): array
    {
        return self::addSlugs([
            'ecarsauto' => [
                'title' => 'eCarsAuto',
                'label' => 'Fleet SaaS / Car rental platform',
                'summary' => 'A premium SaaS experience built to help Moroccan car rental agencies replace booking chaos with a cleaner, more sellable operating system.',
                'client' => 'Car rental agencies, mobility founders, and operators selling to the Moroccan market.',
                'audience' => 'Agencies that need a stronger online offer, cleaner booking flow, and better internal control.',
                'challenge' => 'Make a local-market fleet product feel premium enough to trust while still solving day-to-day agency operations.',
                'solution' => 'I framed the product like a serious SaaS business: strong landing-page conversion, polished visuals, trial-led CTAs, and a system narrative around bookings, fleet, pricing, and customer management.',
                'role' => 'Brand direction, product positioning, UI/UX design, full-stack implementation, and conversion-focused page architecture.',
                'stack' => ['Laravel', 'Blade', 'Tailwind CSS', 'MySQL', 'Responsive SaaS UI'],
                'features' => [
                    'Fleet and booking management flows',
                    'Pricing and plan presentation for agencies',
                    'WhatsApp-friendly conversion path',
                    'Premium product framing for demos and sales',
                    'Mobile-friendly customer and operator experience',
                ],
                'outcome' => 'A portfolio piece that reads like a real vertical SaaS product and positions the concept as a business-ready platform instead of generic rental software.',
                'note' => 'Best used as a flagship example of SaaS positioning, sales-focused design, and full-stack product presentation.',
                'metrics' => [
                    ['label' => 'Positioning', 'value' => 'Morocco-first SaaS'],
                    ['label' => 'Primary goal', 'value' => 'Drive trials and demos'],
                    ['label' => 'System type', 'value' => 'Bookings + fleet + admin'],
                ],
                'media' => [
                    'theme' => 'ecarsauto',
                    'logo' => [
                        'src' => asset('images/projects/ecarsauto-logo.png'),
                        'alt' => 'eCarsAuto logo',
                    ],
                    'cover' => [
                        'src' => asset('images/projects/ecarsauto-case-study.png'),
                        'alt' => 'eCarsAuto SaaS landing page and product presentation',
                    ],
                    'gallery' => [
                        [
                            'src' => asset('images/projects/ecarsauto-case-study.png'),
                            'alt' => 'eCarsAuto case study visual showing landing page, pricing, and agency-facing product screens',
                        ],
                        [
                            'src' => asset('images/projects/ecarsauto-logo.png'),
                            'alt' => 'eCarsAuto brand logo',
                        ],
                    ],
                ],
            ],
            'waslacrm' => [
                'title' => 'WaslaCRM',
                'label' => 'CRM / Lead operations system',
                'summary' => 'A CRM concept focused on helping Moroccan sales and service teams centralize leads, follow-up, and performance in one cleaner interface.',
                'client' => 'Sales-led businesses and local teams managing leads across WhatsApp, calls, and manual follow-up.',
                'audience' => 'Companies that need a more disciplined sales process without losing the local-market feel.',
                'challenge' => 'Create a CRM brand and product direction that feels practical, local, and credible for business buyers.',
                'solution' => 'I shaped the project around visibility, sales momentum, and operational clarity so the brand communicates measurable growth instead of generic software language.',
                'role' => 'Brand identity, product messaging, workflow planning, dashboard structure, and full-stack-ready case-study presentation.',
                'stack' => ['Laravel', 'CRM workflows', 'Lead pipelines', 'Role permissions', 'Dashboard UX'],
                'features' => [
                    'Lead capture and sales pipeline structure',
                    'Follow-up visibility for local teams',
                    'Performance-ready dashboard direction',
                    'Branding built around growth and trust',
                    'Foundation for CRM, messaging, and reporting modules',
                ],
                'outcome' => 'A sharper CRM concept that shows how product branding and workflow clarity can make a sales system feel easier to trust.',
                'note' => 'Best presented as a positioning and product-thinking case for local business software.',
                'metrics' => [
                    ['label' => 'Use case', 'value' => 'Lead follow-up'],
                    ['label' => 'Buyer type', 'value' => 'SMEs and sales teams'],
                    ['label' => 'Core promise', 'value' => 'Better visibility'],
                ],
                'media' => [
                    'theme' => 'waslacrm',
                    'logo' => [
                        'src' => asset('images/projects/waslacrm-logo.png'),
                        'alt' => 'WaslaCRM logo',
                    ],
                    'gallery' => [
                        [
                            'src' => asset('images/projects/waslacrm-logo.png'),
                            'alt' => 'WaslaCRM brand mark',
                        ],
                    ],
                ],
            ],
            'rifimedia-tv' => [
                'title' => 'Rifi Media TV',
                'label' => 'Streaming platform / OTT experience',
                'summary' => 'A multi-device streaming brand and product concept combining campaign visuals, device mockups, and premium landing-page direction.',
                'client' => 'Media and streaming ventures that need a stronger public-facing presentation and a more productized offer.',
                'audience' => 'Subscribers comparing services quickly and expecting trust, speed, and polished visuals before buying.',
                'challenge' => 'Make the platform feel more like a real entertainment product than a generic IPTV landing page.',
                'solution' => 'I used stronger brand surfaces, multi-device mockups, and clearer product framing to show the service as a premium streaming experience across TV, tablet, and mobile.',
                'role' => 'Brand system, landing-page direction, device presentation, UI storytelling, and premium case-study framing.',
                'stack' => ['Laravel', 'Responsive product pages', 'Brand systems', 'Streaming UI concepts', 'Conversion UX'],
                'features' => [
                    'Multi-device product presentation',
                    'Campaign and landing visuals for paid acquisition',
                    'Premium device mockups for trust',
                    'Brand variants for Rifi Media and Rifi Media TV',
                    'Landing-page direction in dark and light surfaces',
                ],
                'outcome' => 'A more polished streaming brand presence that feels marketable, premium, and better suited to convert subscribers.',
                'note' => 'Strongest when shown as a combination of brand design, UI storytelling, and conversion-focused landing work.',
                'metrics' => [
                    ['label' => 'Channels promise', 'value' => '10,000+ global'],
                    ['label' => 'Surfaces', 'value' => 'TV, tablet, mobile'],
                    ['label' => 'Primary goal', 'value' => 'Subscriber conversion'],
                ],
                'media' => [
                    'theme' => 'rifimedia',
                    'logo' => [
                        'src' => asset('images/projects/rifimedia-tv-logo.png'),
                        'alt' => 'Rifi Media TV logo',
                    ],
                    'cover' => [
                        'src' => asset('images/projects/rifimedia-tv-ui.png'),
                        'alt' => 'Rifi Media TV UI mockup on television, tablet, and phone',
                    ],
                    'gallery' => [
                        [
                            'src' => asset('images/projects/rifimedia-tv-ui.png'),
                            'alt' => 'Rifi Media TV multi-device UI showcase',
                        ],
                        [
                            'src' => asset('images/projects/rifimedia-logo.png'),
                            'alt' => 'Rifi Media brand logo',
                        ],
                        [
                            'src' => asset('images/projects/rif-iptv-campaign.png'),
                            'alt' => 'RIF IPTV campaign artwork for sports and global channels',
                        ],
                        [
                            'src' => asset('images/projects/rif-iptv-site-dark.png'),
                            'alt' => 'RIF IPTV dark landing page screenshot',
                        ],
                        [
                            'src' => asset('images/projects/rif-iptv-site-fr.png'),
                            'alt' => 'RIF IPTV French landing page screenshot',
                        ],
                    ],
                ],
            ],
            'erp-plus' => [
                'title' => 'ERP Plus',
                'label' => 'ERP dashboard / Internal operations',
                'summary' => 'A modular ERP dashboard concept for HR, inventory, finance, and collaboration workflows inside one organized admin environment.',
                'client' => 'Operations-heavy businesses that need visibility across teams, inventory, finance, and project activity.',
                'audience' => 'Managers and operators replacing fragmented tools with a more unified internal system.',
                'challenge' => 'Present a complex internal product in a way that feels organized, readable, and enterprise-ready instead of overwhelming.',
                'solution' => 'I structured the case study around module clarity, KPI readability, and role-based operations so the dashboard story stays business-focused.',
                'role' => 'Dashboard planning, product framing, admin UX direction, and system-level case-study positioning.',
                'stack' => ['Laravel', 'Admin dashboards', 'Role-based modules', 'Reporting', 'Operational UX'],
                'features' => [
                    'HR, inventory, finance, and collaboration modules',
                    'KPI cards and activity monitoring',
                    'Role-based navigation for internal teams',
                    'Designed for admin-heavy workflows',
                    'Scalable structure for multi-module operations',
                ],
                'outcome' => 'A cleaner ERP case study that communicates control, visibility, and operational maturity without drowning the visitor in complexity.',
                'note' => 'Presented as an ERP-style system for organizations that need one operational source of truth.',
                'metrics' => [
                    ['label' => 'Modules', 'value' => 'HR, inventory, finance'],
                    ['label' => 'Primary goal', 'value' => 'Operational visibility'],
                    ['label' => 'Buyer type', 'value' => 'Internal teams'],
                ],
                'media' => [
                    'theme' => 'erpplus',
                    'logo' => [
                        'src' => asset('images/projects/erpplus-logo.png'),
                        'alt' => 'ERP Plus logo',
                    ],
                    'cover' => [
                        'src' => asset('images/projects/erpplus-dashboard.png'),
                        'alt' => 'ERP Plus dashboard overview',
                    ],
                    'gallery' => [
                        [
                            'src' => asset('images/projects/erpplus-dashboard.png'),
                            'alt' => 'ERP Plus dashboard showing modules, KPIs, and activity tracking',
                        ],
                        [
                            'src' => asset('images/projects/erpplus-logo.png'),
                            'alt' => 'ERP Plus brand logo',
                        ],
                    ],
                ],
            ],
            'invoix' => [
                'title' => 'Invoix',
                'label' => 'Billing / invoicing platform',
                'summary' => 'A billing-focused product concept aimed at turning invoicing into a clearer, more professional business workflow.',
                'client' => 'Small businesses and operators who need better structure around invoices, receipts, and day-to-day finance tasks.',
                'audience' => 'Teams that want invoicing software that feels simpler, faster, and more presentable to clients.',
                'challenge' => 'Make an invoicing product feel more modern and business-ready than a basic utility app.',
                'solution' => 'I framed the product around simplicity, speed, and a cleaner visual hierarchy so the brand reads like a practical business tool rather than a placeholder concept.',
                'role' => 'Landing-page direction, product messaging, interface hierarchy, and case-study presentation.',
                'stack' => ['Laravel', 'Billing flows', 'Landing pages', 'Responsive UI', 'Product UX'],
                'features' => [
                    'Invoice and receipt workflow direction',
                    'Cleaner business-facing landing presentation',
                    'Straightforward CTA and product explanation',
                    'A foundation for billing dashboards and admin tools',
                    'Positioned for B2B business utility',
                ],
                'outcome' => 'A billing product concept presented with more trust, cleaner hierarchy, and a stronger commercial feel.',
                'note' => 'Works well as a case study for B2B utility software, landing-page clarity, and interface simplification.',
                'metrics' => [
                    ['label' => 'Use case', 'value' => 'Invoices and receipts'],
                    ['label' => 'Primary goal', 'value' => 'Speed and clarity'],
                    ['label' => 'Market fit', 'value' => 'SMEs and service teams'],
                ],
                'media' => [
                    'theme' => 'invoix',
                    'logo' => [
                        'src' => asset('images/projects/invoix-logo.png'),
                        'alt' => 'Invoix logo',
                    ],
                    'cover' => [
                        'src' => asset('images/projects/invoix-landing.png'),
                        'alt' => 'Invoix landing page hero section',
                    ],
                    'gallery' => [
                        [
                            'src' => asset('images/projects/invoix-landing.png'),
                            'alt' => 'Invoix landing page showcasing invoicing product positioning',
                        ],
                        [
                            'src' => asset('images/projects/invoix-logo.png'),
                            'alt' => 'Invoix wordmark logo',
                        ],
                    ],
                ],
            ],
        ]);
    }

    public static function project(string $locale, string $slug): ?array
    {
        return self::projectCatalog($locale)[$slug] ?? null;
    }

    public static function skills(string $locale): array
    {
        return self::get($locale, 'skills');
    }

    public static function experience(string $locale): array
    {
        return self::get($locale, 'experience');
    }

    public static function resume(string $locale): array
    {
        $page = self::get($locale, 'resume');
        $page['experience'] = self::experience($locale);
        $page['skills'] = self::skills($locale);
        $page['education'] = self::about($locale)['education'];

        return $page;
    }

    public static function locationCatalog(string $locale): array
    {
        return self::addSlugs(self::get($locale, 'locations'));
    }

    public static function location(string $locale, string $slug): ?array
    {
        return self::locationCatalog($locale)[$slug] ?? null;
    }

    public static function blogCatalog(string $locale): array
    {
        return self::addSlugs(self::get($locale, 'blog.articles'));
    }

    public static function blogIndex(string $locale): array
    {
        $page = self::get($locale, 'blog.index');
        $page['items'] = array_values(self::blogCatalog($locale));

        return $page;
    }

    public static function article(string $locale, string $slug): ?array
    {
        return self::blogCatalog($locale)[$slug] ?? null;
    }

    public static function sitePageCatalog(string $locale): array
    {
        return self::addSlugs([
            'tech-stack' => [
                'eyebrow' => 'Tech Stack',
                'title' => 'Technical breadth with product-level depth.',
                'intro' => 'A practical stack for building modern products end to end: applications, APIs, dashboards, automation, infrastructure, and AI-enabled systems.',
                'cards' => [
                    ['title' => 'Backend Engineering', 'copy' => 'Node.js, PHP, Python, Java, C#, Laravel, Django, Flask, Express.js, modular architecture, APIs, webhooks, queues, caching, and scalable business logic.'],
                    ['title' => 'Frontend Systems', 'copy' => 'React, Vue, Angular, responsive UI, data-heavy dashboards, forms, tables, accessibility, component-based design, and conversion-focused interfaces.'],
                    ['title' => 'Data and Infrastructure', 'copy' => 'MySQL, PostgreSQL, MongoDB, Linux servers, VPS deployments, Hostinger, AWS, SSL, DNS, environments, and production readiness.'],
                    ['title' => 'AI and Automation', 'copy' => 'Python automation, AI integrations, prompt workflows, deep learning familiarity, backend-powered tools, and intelligent product workflows.'],
                ],
                'sections' => [
                    ['title' => 'How the stack is used', 'paragraphs' => ['The goal is not tool collection. The goal is choosing the right technologies for performance, maintainability, business logic, and long-term product health.']],
                    ['title' => 'Capability across the lifecycle', 'paragraphs' => ['Discovery, architecture, implementation, deployment, optimization, and iteration are all part of the work. That is where seniority becomes visible.']],
                ],
                'matrix' => [
                    'title' => 'What this stack supports',
                    'columns' => ['Primary use', 'Typical outcome'],
                    'rows' => [
                        ['label' => 'SaaS and product platforms', 'cells' => ['Laravel, React, APIs, PostgreSQL', 'Scalable product foundation']],
                        ['label' => 'Business systems and ERP-like tools', 'cells' => ['Backend modules, dashboards, roles, workflows', 'Operational clarity and control']],
                        ['label' => 'Mobile and multi-channel products', 'cells' => ['APIs, frontend systems, integrations', 'Consistent product delivery across surfaces']],
                        ['label' => 'AI and automation layers', 'cells' => ['Python workflows, integrations, data pipelines', 'Smarter operations and faster execution']],
                    ],
                ],
                'cta' => ['title' => 'Need a stack that matches the product, not just the trend?', 'copy' => 'I can help define the right architecture and deliver the system behind it.'],
                'seo' => [
                    'title' => 'Tech Stack | Youssef Youyou',
                    'description' => 'Technical stack, engineering capabilities, architecture strengths, deployment knowledge, and AI-ready development expertise.',
                    'keywords' => 'Tech stack developer Morocco, Laravel React Node Python developer, AI ready full-stack developer',
                    'type' => 'website',
                ],
            ],
            'industries' => [
                'eyebrow' => 'Industries',
                'title' => 'Useful where business logic, operations, and product quality need to meet.',
                'intro' => 'The best work happens where technical execution has to support real users, real workflows, and real business pressure.',
                'cards' => [
                    ['title' => 'Startups and SaaS founders', 'copy' => 'Product MVPs, admin systems, billing-ready logic, analytics, and scalable architecture.'],
                    ['title' => 'Education', 'copy' => 'School management systems, operational dashboards, reporting, permissions, and structured user workflows.'],
                    ['title' => 'Agencies and service businesses', 'copy' => 'Client-facing systems, portals, internal tools, automation, and operational visibility.'],
                    ['title' => 'SMEs and business operations', 'copy' => 'ERP-like systems, finance-aware tools, internal workflows, custom dashboards, and approvals.'],
                    ['title' => 'B2B tools and enterprise workflows', 'copy' => 'Structured roles, modular systems, backend-heavy logic, integrations, and multi-team usability.'],
                    ['title' => 'E-commerce and digital operations', 'copy' => 'Operational tools, automation, admin systems, product data flows, and customer-facing performance.'],
                ],
                'sections' => [
                    ['title' => 'Why industry fit matters', 'paragraphs' => ['A strong developer should understand the operational context behind the product, not just the interface. That is how systems become useful instead of merely functional.']],
                ],
                'cta' => ['title' => 'Building for a complex workflow or niche operation?', 'copy' => 'That is usually where the right architecture matters most.'],
                'seo' => [
                    'title' => 'Industries | Youssef Youyou',
                    'description' => 'Industries and business contexts supported by Youssef Youyou across SaaS, education, internal tools, ERP-like systems, and operations platforms.',
                    'keywords' => 'developer for SaaS Morocco, education software developer Morocco, ERP developer Morocco',
                    'type' => 'website',
                ],
            ],
            'process' => [
                'eyebrow' => 'Process',
                'title' => 'A clear build process for serious digital products.',
                'intro' => 'The process is designed to reduce uncertainty, improve decisions, and keep quality high from discovery to launch.',
                'cards' => [
                    ['title' => 'Discover', 'copy' => 'Clarify business context, product goals, users, blockers, and technical constraints.'],
                    ['title' => 'Architect', 'copy' => 'Define system structure, data flow, priorities, scope, and the best path to delivery.'],
                    ['title' => 'Build', 'copy' => 'Implement the product with clean code, clear UX, testing awareness, and production thinking.'],
                    ['title' => 'Launch', 'copy' => 'Deploy carefully, validate the experience, fix friction, and make the release feel professional.'],
                    ['title' => 'Improve', 'copy' => 'Iterate, optimize performance, add features, and support the next level of growth.'],
                ],
                'sections' => [
                    ['title' => 'What clients can expect', 'paragraphs' => ['Clarity, communication, structured implementation, and decisions grounded in business value rather than noise.']],
                ],
                'cta' => ['title' => 'Want a build process that feels more like product leadership than task execution?', 'copy' => 'That is exactly the point.'],
                'seo' => [
                    'title' => 'Process | Youssef Youyou',
                    'description' => 'A professional process for discovery, architecture, build, launch, and iterative improvement across modern digital products.',
                    'keywords' => 'developer process Morocco, product build process, full-stack delivery workflow',
                    'type' => 'website',
                ],
            ],
            'trust' => [
                'eyebrow' => 'Trust',
                'title' => 'Credibility designed honestly and ready for real proof.',
                'intro' => 'This page is built to support recruiters, founders, CTOs, and serious buyers with the kind of trust signals that matter.',
                'stats' => [
                    ['value' => '5+', 'label' => 'Years experience'],
                    ['value' => '20+', 'label' => 'Happy clients'],
                    ['value' => '25+', 'label' => 'Completed projects'],
                    ['value' => '10+', 'label' => 'Large projects'],
                ],
                'cards' => [
                    ['title' => 'Real-project positioning', 'copy' => 'The site emphasizes systems, architecture, and delivery instead of inflated claims.'],
                    ['title' => 'Private-case-study ready', 'copy' => 'Confidential or internal work can still be shown with the right structure and responsible framing.'],
                    ['title' => 'Recruiter-friendly proof', 'copy' => 'Strong stack coverage, product thinking, deployment readiness, and clean communication are visible quickly.'],
                ],
                'placeholders' => [
                    'Replace with real client testimonials only',
                    'Replace with real brand logos only',
                    'Replace with a real capabilities PDF or one-pager',
                ],
                'faq' => [
                    ['question' => 'Do you invent testimonials or client logos?', 'answer' => 'No. Trust should be earned and presented honestly.'],
                    ['question' => 'Can private work still be shown professionally?', 'answer' => 'Yes. It can be framed as a case study without exposing sensitive details.'],
                ],
                'cta' => ['title' => 'Need a developer brand that feels trustworthy before the first call?', 'copy' => 'That is what this system is built to signal.'],
                'seo' => [
                    'title' => 'Trust and Proof | Youssef Youyou',
                    'description' => 'Trust-focused page for recruiters and clients covering experience, project volume, proof structure, and honest credibility.',
                    'keywords' => 'developer trust page Morocco, recruiter-friendly portfolio, senior developer proof',
                    'type' => 'website',
                ],
            ],
            'faq' => [
                'eyebrow' => 'FAQ',
                'title' => 'Practical answers before a project begins.',
                'intro' => 'Questions around scope, stack, timeline, support, deployment, and modernization usually come up early. This page answers them clearly.',
                'faq' => [
                    ['question' => 'What do you build?', 'answer' => 'Websites, web applications, SaaS platforms, mobile apps, desktop tools, APIs, dashboards, ERP-like systems, automation workflows, and AI-enabled features.'],
                    ['question' => 'Do you work internationally?', 'answer' => 'Yes. I work with clients in Morocco and internationally where scope, communication, and execution quality matter.'],
                    ['question' => 'How do projects start?', 'answer' => 'Usually with a clear project brief, discovery conversation, goals, priorities, and technical constraints.'],
                    ['question' => 'Do you provide support after launch?', 'answer' => 'Yes, depending on the project and support expectations.'],
                    ['question' => 'Can you deploy and manage servers?', 'answer' => 'Yes. Deployment, hosting, VPS environments, and production readiness are part of the offer when needed.'],
                    ['question' => 'Can you build AI-enabled systems?', 'answer' => 'Yes, especially when AI improves workflows, automation, internal tooling, or product usefulness.'],
                    ['question' => 'Can you modernize an existing application?', 'answer' => 'Yes. I can improve design, performance, architecture, deployment flow, and maintainability without rebuilding everything by default.'],
                ],
                'cta' => ['title' => 'Still have a project-specific question?', 'copy' => 'The fastest path is to send the context directly.'],
                'seo' => [
                    'title' => 'FAQ | Youssef Youyou',
                    'description' => 'Frequently asked questions about services, technology stack, project timelines, support, deployment, and AI-enabled solutions.',
                    'keywords' => 'developer FAQ Morocco, SaaS developer questions, full-stack project FAQ',
                    'type' => 'website',
                ],
            ],
            'availability' => [
                'eyebrow' => 'Availability',
                'title' => 'Work with a senior full-stack developer who can own serious delivery.',
                'intro' => 'This page is for founders, recruiters, agencies, SMEs, and product teams who need strong execution, broad technical depth, and reliable communication.',
                'cards' => [
                    ['title' => 'Project builds', 'copy' => 'New product builds, system launches, MVPs, platforms, dashboards, internal tools, and modernization work.'],
                    ['title' => 'Technical partner work', 'copy' => 'Support for architecture, delivery planning, scoped execution, and product direction.'],
                    ['title' => 'Recruiter and hiring conversations', 'copy' => 'Senior full-stack roles, systems-focused engineering, product engineering, and architecture-leaning opportunities.'],
                    ['title' => 'Best-fit engagements', 'copy' => 'Products with real business logic, operational complexity, integrations, security, and scale requirements.'],
                ],
                'sections' => [
                    ['title' => 'Best fit', 'paragraphs' => ['Serious projects. Clear goals. Teams that value technical quality, communication, and product thinking.']],
                    ['title' => 'What to send', 'list' => ['Project or role summary', 'Scope or challenge', 'Timeline expectations', 'Any relevant links or existing system context']],
                ],
                'cta' => ['title' => 'Ready to talk about a role, project, or system build?', 'copy' => 'Send the essentials and I can respond with clarity.'],
                'seo' => [
                    'title' => 'Availability | Hire Youssef Youyou',
                    'description' => 'Availability page for client projects, full-stack roles, recruiter outreach, architecture-focused delivery, and serious product work.',
                    'keywords' => 'hire senior full-stack developer Morocco, developer availability Morocco, recruiter portfolio developer',
                    'type' => 'website',
                ],
            ],
            'privacy-policy' => [
                'eyebrow' => 'Privacy Policy',
                'title' => 'Privacy and contact-data handling.',
                'intro' => 'This site collects only the information needed to respond to inquiries and operate the website responsibly.',
                'sections' => [
                    ['title' => 'What may be collected', 'paragraphs' => ['Contact details and project information you submit through the contact form may be stored so I can respond and follow up.']],
                    ['title' => 'How information is used', 'paragraphs' => ['The information is used to understand your request, communicate about potential work, and improve the quality of responses.']],
                    ['title' => 'Third-party services', 'paragraphs' => ['Hosting, analytics, form delivery, and infrastructure tools may process basic technical data required to operate the website.']],
                    ['title' => 'Your control', 'paragraphs' => ['You can request updates or deletion of submitted contact information where applicable.']],
                ],
                'seo' => [
                    'title' => 'Privacy Policy | Youssef Youyou',
                    'description' => 'Privacy policy for the Youssef Youyou website covering contact data, form submissions, and website operation.',
                    'keywords' => 'privacy policy developer website',
                    'type' => 'website',
                ],
            ],
            'terms-of-service' => [
                'eyebrow' => 'Terms of Service',
                'title' => 'Website terms and general service framing.',
                'intro' => 'This page provides a simple, professional baseline for how the website and inquiries are intended to be used.',
                'sections' => [
                    ['title' => 'Website use', 'paragraphs' => ['The content is provided for informational, professional, and lead-generation purposes.']],
                    ['title' => 'Project discussions', 'paragraphs' => ['Any scope, pricing, timeline, or technical recommendations are finalized only after direct communication and agreement.']],
                    ['title' => 'Intellectual property', 'paragraphs' => ['Published branding, layout, and original written material remain protected unless otherwise agreed in writing.']],
                    ['title' => 'No guarantee from website content alone', 'paragraphs' => ['Final deliverables, performance expectations, and support arrangements depend on the actual project agreement.']],
                ],
                'seo' => [
                    'title' => 'Terms of Service | Youssef Youyou',
                    'description' => 'Terms of service page covering website usage, project discussions, intellectual property, and general service expectations.',
                    'keywords' => 'terms of service developer website',
                    'type' => 'website',
                ],
            ],
        ]);
    }

    public static function sitePage(string $locale, string $slug): ?array
    {
        return self::sitePageCatalog($locale)[$slug] ?? null;
    }

    public static function buildSeo(
        string $locale,
        array $seo = [],
        array $schema = [],
        ?string $image = null,
        array $breadcrumbs = []
    ): array {
        $site = self::site($locale);
        $resolved = array_merge($site['default_seo'], $seo);
        $resolved['image'] = $image ?? $seo['image'] ?? $site['social_image'];
        $resolved['image_alt'] = $seo['image_alt'] ?? $site['name'].' portfolio preview';

        $schemaGraph = [
            self::websiteSchema($locale),
            self::organizationSchema($locale),
            ...$schema,
        ];

        if ($breadcrumbs !== []) {
            $schemaGraph[] = self::breadcrumbSchema($breadcrumbs);
        }

        $resolved['schema'] = array_values(array_filter($schemaGraph));

        return $resolved;
    }

    public static function personSchema(string $locale = 'en'): array
    {
        $site = self::site($locale);

        return [
            '@context' => 'https://schema.org',
            '@type' => 'Person',
            'name' => $site['name'],
            'jobTitle' => $site['role'],
            'description' => $site['tagline'],
            'url' => config('app.url'),
            'email' => 'mailto:contact@youssefyouyou.com',
            'telephone' => '+212610090070',
            'address' => [
                '@type' => 'PostalAddress',
                'addressLocality' => 'Nador',
                'addressRegion' => 'Oriental',
                'addressCountry' => 'MA',
            ],
            'sameAs' => [
                $site['github_url'],
                $site['linkedin_url'],
            ],
            'knowsLanguage' => ['Arabic', 'French', 'English', 'German', 'Spanish'],
            'knowsAbout' => [
                'Full-Stack Development',
                'Web Applications',
                'SaaS Platforms',
                'Mobile Applications',
                'Desktop Applications',
                'API Development',
                'Laravel',
                'React',
                'Node.js',
                'AI Solutions',
                'Machine Learning',
                'DevOps',
                'Deployment',
            ],
        ];
    }

    public static function organizationSchema(string $locale = 'en'): array
    {
        $site = self::site($locale);

        return [
            '@context' => 'https://schema.org',
            '@type' => 'ProfessionalService',
            'name' => $site['name'],
            'url' => $site['website_url'],
            'image' => $site['social_image'],
            'logo' => $site['logo'],
            'description' => $site['tagline'],
            'email' => 'contact@youssefyouyou.com',
            'telephone' => '+212610090070',
            'areaServed' => ['Morocco', 'Europe', 'Remote'],
            'sameAs' => [
                $site['github_url'],
                $site['linkedin_url'],
            ],
        ];
    }

    public static function websiteSchema(string $locale = 'en'): array
    {
        $site = self::site($locale);

        return [
            '@context' => 'https://schema.org',
            '@type' => 'WebSite',
            'name' => $site['name'],
            'url' => $site['website_url'],
            'inLanguage' => $locale,
            'description' => $site['tagline'],
            'publisher' => [
                '@type' => 'Person',
                'name' => $site['name'],
            ],
        ];
    }

    public static function serviceSchema(array $service, string $url): array
    {
        return [
            '@context' => 'https://schema.org',
            '@type' => 'Service',
            'name' => $service['title'],
            'description' => $service['summary'],
            'serviceType' => $service['title'],
            'areaServed' => ['Morocco', 'Europe', 'Remote'],
            'provider' => [
                '@type' => 'Person',
                'name' => 'Youssef Youyou',
            ],
            'url' => $url,
        ];
    }

    public static function articleSchema(array $article, string $url): array
    {
        return [
            '@context' => 'https://schema.org',
            '@type' => 'BlogPosting',
            'headline' => $article['title'],
            'description' => $article['excerpt'],
            'datePublished' => $article['published_at'],
            'author' => [
                '@type' => 'Person',
                'name' => 'Youssef Youyou',
            ],
            'publisher' => [
                '@type' => 'Person',
                'name' => 'Youssef Youyou',
            ],
            'mainEntityOfPage' => $url,
        ];
    }

    public static function projectSchema(array $project, string $url): array
    {
        return [
            '@context' => 'https://schema.org',
            '@type' => 'SoftwareApplication',
            'name' => $project['title'],
            'applicationCategory' => $project['label'],
            'operatingSystem' => 'Web',
            'description' => $project['summary'],
            'url' => $url,
            'image' => $project['media']['cover']['src'] ?? $project['media']['logo']['src'] ?? null,
            'featureList' => $project['features'] ?? [],
            'creator' => [
                '@type' => 'Person',
                'name' => 'Youssef Youyou',
            ],
        ];
    }

    public static function faqSchema(array $items): array
    {
        return [
            '@context' => 'https://schema.org',
            '@type' => 'FAQPage',
            'mainEntity' => array_map(
                static fn (array $item): array => [
                    '@type' => 'Question',
                    'name' => $item['question'],
                    'acceptedAnswer' => [
                        '@type' => 'Answer',
                        'text' => $item['answer'],
                    ],
                ],
                $items
            ),
        ];
    }

    public static function breadcrumbSchema(array $items): array
    {
        return [
            '@context' => 'https://schema.org',
            '@type' => 'BreadcrumbList',
            'itemListElement' => array_map(
                static fn (array $item, int $index): array => [
                    '@type' => 'ListItem',
                    'position' => $index + 1,
                    'name' => $item['name'],
                    'item' => $item['url'],
                ],
                $items,
                array_keys($items)
            ),
        ];
    }

    private static function get(string $locale, string $key): array
    {
        return Lang::get('brand.'.$key, [], $locale);
    }

    private static function addSlugs(array $items): array
    {
        $resolved = [];

        foreach ($items as $slug => $item) {
            $resolved[$slug] = array_merge(['slug' => $slug], $item);
        }

        return $resolved;
    }
}

