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
            'ar' => 'Arabic',
            'es' => 'Espanol',
            'de' => 'Deutsch',
        ][$locale] ?? strtoupper($locale);
    }

    public static function site(string $locale): array
    {
        $site = self::get($locale, 'site');

        $site['logo'] = asset('images/brand-mark.png');
        $site['portrait'] = asset('images/youyou-portrait.png');
        $site['website_url'] = config('app.url');
        $site['whatsapp_url'] = 'https://wa.me/212610090070';
        $site['phone_link'] = 'tel:+212610090070';
        $site['email_link'] = 'mailto:contact@youssefyouyou.com';
        $site['github_url'] = 'https://github.com/youssefyouyoudev';
        $site['linkedin_url'] = 'https://linkedin.com/in/youssefyouyoudev';
        $site['cv_url'] = route('resume', ['locale' => $locale]);
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

    public static function landing(string $locale): array
    {
        $base = [
            'seo' => [
                'title' => 'Youssef Youyou | Senior Full-Stack Developer for SaaS, Web Apps, and AI Systems',
                'description' => 'Senior Full-Stack Developer building scalable web apps, SaaS platforms, APIs, mobile products, and AI-powered systems for modern businesses.',
                'keywords' => 'Senior Full-Stack Developer, SaaS Developer, Web App Developer, API Developer, AI Solutions Developer, Mobile App Developer, Desktop App Developer, Laravel Developer, React Developer',
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
                'eyebrow' => 'Senior Full-Stack Developer | Web, SaaS, Mobile, AI',
                'title' => 'Senior Full-Stack Developer building scalable web apps, SaaS, and AI-powered systems',
                'copy' => 'I help businesses build high-performance applications, automate processes, and scale with modern technologies.',
                'pills' => ['5+ years experience', 'Web apps, SaaS, mobile, desktop, APIs', 'Business-focused technical partner'],
                'metrics' => [
                    ['title' => 'Senior execution', 'copy' => 'Serious product delivery from concept to production.'],
                    ['title' => 'AI to deployment', 'copy' => 'Architecture, interfaces, automation, and infrastructure in one flow.'],
                    ['title' => 'Built for growth', 'copy' => 'Systems designed to support users, teams, and business expansion.'],
                ],
            ],
            'proof_strip' => ['5+ years experience', '20+ happy clients', '25+ completed projects', '10+ large systems', 'Web, SaaS, mobile, desktop, AI'],
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
                'title' => 'Project types that show real technical range.',
                'copy' => 'Presented like product work: clear purpose, visible system thinking, and modern visual structure instead of generic portfolio tiles.',
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
                'eyebrow' => 'Authority',
                'title' => 'A stronger business impression in seconds.',
                'copy' => 'The structure below is there to create immediate confidence: seniority, volume, and product-level capability without dragging the visitor through a resume.',
            ],
            'stats' => [
                ['value' => 5, 'suffix' => '+', 'label' => 'Years of experience'],
                ['value' => 20, 'suffix' => '+', 'label' => 'Happy clients'],
                ['value' => 25, 'suffix' => '+', 'label' => 'Completed projects'],
                ['value' => 10, 'suffix' => '+', 'label' => 'Large systems delivered'],
            ],
            'why_intro' => [
                'eyebrow' => 'Why Choose Me',
                'title' => 'Built for clients who want one serious developer who can own the system.',
                'copy' => 'This positioning is simple on purpose: modern execution, reliable systems, and product decisions made with business value in mind.',
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
                'title' => 'A modern build flow from idea to scale.',
                'copy' => 'Clear steps reduce friction, keep the project moving, and make the working relationship feel professional from day one.',
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
                'title' => 'Start the conversation with a serious technical partner.',
                'copy' => 'Tell me what you want to build, what is slowing your business down, and what kind of system you need next.',
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
                'hero' => ['eyebrow' => 'Developpeur Full-Stack Senior | Web, SaaS, Mobile, IA', 'title' => 'Developpeur Full-Stack Senior pour applications web evolutives, SaaS et systemes bases sur l IA', 'copy' => 'J aide les entreprises a creer des applications performantes, automatiser leurs processus et passer a l echelle avec des technologies modernes.', 'pills' => ['5+ ans d experience', 'Web apps, SaaS, mobile, desktop, APIs', 'Partenaire technique oriente business']],
                'proof_strip' => ['5+ ans d experience', '20+ clients satisfaits', '25+ projets livres', '10+ grands systemes', 'Web, SaaS, mobile, desktop, IA'],
                'services_intro' => ['title' => 'Des systemes pour les entreprises qui ont besoin de plus qu un simple site web.', 'copy' => 'Chaque service repond a un vrai besoin business, soutient la croissance et apporte une base technique solide.'],
                'stack_intro' => ['eyebrow' => 'Stack technique', 'title' => 'Une stack pensee pour des produits modernes, propres et serieux.', 'copy' => 'Le but n est pas d afficher des outils. Le but est de montrer la capacite technique necessaire pour construire, lancer et faire evoluer de vraies plateformes.'],
                'projects_intro' => ['eyebrow' => 'Travaux selectionnes', 'title' => 'Des types de projets qui montrent une vraie profondeur technique.', 'copy' => 'Presente comme du travail produit: objectif clair, logique systeme visible et presentation premium.'],
                'authority_intro' => ['eyebrow' => 'Credibilite', 'title' => 'Une impression business forte en quelques secondes.', 'copy' => 'Cette structure sert a installer rapidement la confiance: seniorite, volume et capacite produit sans transformer la page en CV.'],
                'stats' => [['value' => 5, 'suffix' => '+', 'label' => 'Annees d experience'], ['value' => 20, 'suffix' => '+', 'label' => 'Clients satisfaits'], ['value' => 25, 'suffix' => '+', 'label' => 'Projets realises'], ['value' => 10, 'suffix' => '+', 'label' => 'Grands systemes livres']],
                'why_intro' => ['eyebrow' => 'Pourquoi moi', 'title' => 'Pour les clients qui veulent un developpeur serieux capable de porter tout le systeme.', 'copy' => 'Ce positionnement est volontairement simple: execution moderne, systemes fiables et decisions produit alignees avec la valeur business.'],
                'process_intro' => ['eyebrow' => 'Processus', 'title' => 'Un flux de travail moderne de l idee jusqu a l echelle.', 'copy' => 'Des etapes claires reduisent la friction, accelerent le projet et rendent la collaboration plus professionnelle.'],
                'final_cta' => ['eyebrow' => 'Pret a construire', 'title' => 'Construisons votre systeme.', 'copy' => 'Applications web, SaaS, workflows IA, plateformes backend et livraison premium pour des objectifs business serieux.', 'primary' => 'Demarrer votre projet'],
                'contact_intro' => ['title' => 'Commencez la conversation avec un partenaire technique serieux.', 'copy' => 'Expliquez ce que vous voulez construire, ce qui ralentit votre activite et le type de systeme dont vous avez besoin.'],
                'contact_badges' => ['Reponse rapide', 'Vision business', 'Execution evolutive'],
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
                'hero' => ['eyebrow' => 'Desarrollador Full-Stack Senior | Web, SaaS, Movil, IA', 'title' => 'Desarrollador Full-Stack Senior creando apps web escalables, SaaS y sistemas impulsados por IA', 'copy' => 'Ayudo a empresas a crear aplicaciones de alto rendimiento, automatizar procesos y escalar con tecnologias modernas.', 'pills' => ['5+ anos de experiencia', 'Web apps, SaaS, movil, escritorio, APIs', 'Socio tecnico orientado al negocio']],
                'proof_strip' => ['5+ anos de experiencia', '20+ clientes satisfechos', '25+ proyectos completados', '10+ sistemas grandes', 'Web, SaaS, movil, escritorio, IA'],
                'services_intro' => ['eyebrow' => 'Servicios', 'title' => 'Sistemas para empresas que necesitan mas que un sitio web basico.', 'copy' => 'Cada servicio esta pensado para resolver un problema real, impulsar crecimiento y darte una base tecnica mas fuerte.'],
                'stack_intro' => ['eyebrow' => 'Stack tecnico', 'title' => 'Un stack pensado para productos modernos, sistemas limpios y entregas serias.', 'copy' => 'El objetivo no es mostrar herramientas por decoracion. El objetivo es demostrar el alcance tecnico necesario para construir, lanzar y escalar plataformas reales.'],
                'projects_intro' => ['eyebrow' => 'Trabajo seleccionado', 'title' => 'Tipos de proyectos que muestran alcance tecnico real.', 'copy' => 'Presentado como trabajo de producto: proposito claro, pensamiento de arquitectura y una presentacion premium.'],
                'authority_intro' => ['eyebrow' => 'Autoridad', 'title' => 'Una impresion de negocio mas fuerte en segundos.', 'copy' => 'Esta estructura genera confianza inmediata: seniority, volumen y capacidad de producto sin convertir la pagina en un CV.'],
                'stats' => [['value' => 5, 'suffix' => '+', 'label' => 'Anos de experiencia'], ['value' => 20, 'suffix' => '+', 'label' => 'Clientes satisfechos'], ['value' => 25, 'suffix' => '+', 'label' => 'Proyectos completados'], ['value' => 10, 'suffix' => '+', 'label' => 'Sistemas grandes entregados']],
                'why_intro' => ['eyebrow' => 'Por que yo', 'title' => 'Para clientes que quieren un desarrollador serio capaz de liderar todo el sistema.', 'copy' => 'Este posicionamiento es simple a proposito: ejecucion moderna, sistemas fiables y decisiones de producto conectadas al valor del negocio.'],
                'process_intro' => ['eyebrow' => 'Proceso', 'title' => 'Un flujo moderno desde la idea hasta la escala.', 'copy' => 'Pasos claros reducen friccion, mantienen el proyecto en movimiento y hacen que la colaboracion se sienta profesional desde el primer dia.'],
                'final_cta' => ['eyebrow' => 'Listo para construir', 'title' => 'Construyamos tu sistema.', 'copy' => 'Apps web, SaaS, flujos con IA, plataformas backend y una entrega pulida para objetivos de negocio serios.', 'primary' => 'Empieza tu proyecto hoy'],
                'contact_intro' => ['eyebrow' => 'Contacto', 'title' => 'Empieza la conversacion con un socio tecnico serio.', 'copy' => 'Cuentame que quieres construir, que esta frenando tu negocio y que tipo de sistema necesitas ahora.'],
                'contact_badges' => ['Respuesta rapida', 'Enfoque de negocio', 'Ejecucion escalable'],
            ],
            'de' => [
                'nav' => ['about' => 'Uber mich', 'services' => 'Leistungen', 'projects' => 'Projekte', 'proof' => 'Vertrauen', 'process' => 'Prozess', 'contact' => 'Kontakt', 'expertise' => 'Expertise', 'industries' => 'Branchen', 'insights' => 'Insights', 'hire' => 'Verfugbarkeit', 'faq' => 'FAQ', 'privacy' => 'Datenschutz', 'terms' => 'Bedingungen', 'trust' => 'Vertrauen', 'start_project' => 'Projekt starten', 'tech_stack' => 'Tech-Stack', 'navigate' => 'Navigation', 'reach_out' => 'Direkter Kontakt', 'language' => 'Sprache', 'language_short' => 'Sprache'],
                'hero' => ['eyebrow' => 'Senior Full-Stack-Entwickler | Web, SaaS, Mobile, KI', 'title' => 'Senior Full-Stack-Entwickler fur skalierbare Web-Apps, SaaS und KI-gestutzte Systeme', 'copy' => 'Ich helfe Unternehmen dabei, leistungsstarke Anwendungen zu bauen, Prozesse zu automatisieren und mit modernen Technologien zu skalieren.', 'pills' => ['5+ Jahre Erfahrung', 'Web-Apps, SaaS, Mobile, Desktop, APIs', 'Technischer Partner mit Business-Fokus']],
                'proof_strip' => ['5+ Jahre Erfahrung', '20+ zufriedene Kunden', '25+ abgeschlossene Projekte', '10+ grosse Systeme', 'Web, SaaS, Mobile, Desktop, KI'],
                'services_intro' => ['eyebrow' => 'Leistungen', 'title' => 'Systeme fur Unternehmen, die mehr als nur eine einfache Website brauchen.', 'copy' => 'Jede Leistung ist darauf ausgelegt, ein echtes Business-Problem zu losen, Wachstum zu unterstutzen und eine starkere technische Grundlage zu schaffen.'],
                'stack_intro' => ['eyebrow' => 'Tech-Stack', 'title' => 'Ein Stack fur moderne Produkte, saubere Systeme und professionelle Umsetzung.', 'copy' => 'Es geht nicht darum, Tools aufzulisten. Es geht darum, die technische Breite zu zeigen, die fur echte Plattformen notwendig ist.'],
                'projects_intro' => ['eyebrow' => 'Ausgewahlte Arbeit', 'title' => 'Projektarten, die echte technische Tiefe zeigen.', 'copy' => 'Dargestellt wie Produktarbeit: klarer Zweck, sichtbares Architekturdenken und eine moderne Premium-Prasentation.'],
                'authority_intro' => ['eyebrow' => 'Autoritat', 'title' => 'Ein starker Business-Eindruck in wenigen Sekunden.', 'copy' => 'Diese Struktur schafft direkt Vertrauen: Senioritat, Umfang und Produktfahigkeit ohne Lebenslauf-Charakter.'],
                'stats' => [['value' => 5, 'suffix' => '+', 'label' => 'Jahre Erfahrung'], ['value' => 20, 'suffix' => '+', 'label' => 'Zufriedene Kunden'], ['value' => 25, 'suffix' => '+', 'label' => 'Abgeschlossene Projekte'], ['value' => 10, 'suffix' => '+', 'label' => 'Grosse Systeme geliefert']],
                'why_intro' => ['eyebrow' => 'Warum ich', 'title' => 'Fur Kunden, die einen ernsthaften Entwickler wollen, der das gesamte System verantworten kann.', 'copy' => 'Die Positionierung ist bewusst klar: moderne Umsetzung, verlassliche Systeme und Produktentscheidungen mit Business-Wirkung.'],
                'process_intro' => ['eyebrow' => 'Prozess', 'title' => 'Ein moderner Ablauf von der Idee bis zur Skalierung.', 'copy' => 'Klare Schritte reduzieren Reibung, halten das Projekt in Bewegung und machen die Zusammenarbeit professionell.'],
                'final_cta' => ['eyebrow' => 'Bereit zum Bauen', 'title' => 'Lassen Sie uns Ihr System bauen.', 'copy' => 'Web-Apps, SaaS, KI-Workflows, Backend-Plattformen und hochwertige Umsetzung fur ernsthafte Business-Ziele.', 'primary' => 'Projekt heute starten'],
                'contact_intro' => ['eyebrow' => 'Kontakt', 'title' => 'Starten Sie das Gesprach mit einem ernsthaften technischen Partner.', 'copy' => 'Beschreiben Sie kurz, was Sie bauen wollen, was Ihr Wachstum bremst und welches System Sie als Nachstes brauchen.'],
                'contact_badges' => ['Schnelle Antwort', 'Business-Fokus', 'Skalierbare Umsetzung'],
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
        $page = self::get($locale, 'projects.index');
        $page['items'] = array_values(self::projectCatalog($locale));

        return $page;
    }

    public static function projectCatalog(string $locale): array
    {
        return self::addSlugs(self::get($locale, 'projects.items'));
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
            'knowsLanguage' => ['Arabic', 'French', 'English', 'German'],
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

