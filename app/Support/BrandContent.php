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
        ];

        $overrides = match ($locale) {
            'fr' => [
                'nav' => ['projects' => 'Projets', 'proof' => 'Preuves', 'process' => 'Processus', 'start_project' => 'Demarrer un projet', 'tech_stack' => 'Stack technique', 'navigate' => 'Navigation', 'reach_out' => 'Contact direct', 'language' => 'Langue', 'language_short' => 'Lang'],
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
                'nav' => ['services' => 'الخدمات', 'stack' => 'التقنيات', 'projects' => 'المشاريع', 'proof' => 'الثقة', 'process' => 'العملية', 'contact' => 'تواصل', 'start_project' => 'ابدأ مشروعك', 'tech_stack' => 'التقنيات', 'navigate' => 'التنقل', 'reach_out' => 'تواصل مباشر', 'language' => 'اللغة', 'language_short' => 'لغة'],
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
                'nav' => ['services' => 'Servicios', 'projects' => 'Proyectos', 'proof' => 'Pruebas', 'process' => 'Proceso', 'contact' => 'Contacto', 'start_project' => 'Empezar proyecto', 'tech_stack' => 'Stack tecnico', 'navigate' => 'Navegar', 'reach_out' => 'Contacto directo', 'language' => 'Idioma', 'language_short' => 'Idioma'],
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
                'nav' => ['services' => 'Leistungen', 'projects' => 'Projekte', 'proof' => 'Vertrauen', 'process' => 'Prozess', 'contact' => 'Kontakt', 'start_project' => 'Projekt starten', 'tech_stack' => 'Tech-Stack', 'navigate' => 'Navigation', 'reach_out' => 'Direkter Kontakt', 'language' => 'Sprache', 'language_short' => 'Sprache'],
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

