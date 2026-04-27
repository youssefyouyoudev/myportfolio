<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\ClientLogo;
use App\Models\Project;
use App\Models\Service;
use App\Models\Testimonial;
use App\Support\BrandContent;
use App\Support\ContentMapper;
use Illuminate\Http\Response;
use Illuminate\Support\Collection;
use Illuminate\View\View;

class SiteController extends Controller
{
    public function home(): View
    {
        $locale = app()->getLocale();
        $page = BrandContent::home($locale);
        $showcase = BrandContent::homeShowcase($locale);
        $serviceItems = collect(BrandContent::serviceCatalog($locale));
        $projectItems = collect($showcase['projects']);
        $homeFaqItems = collect(BrandContent::sitePage($locale, 'faq')['faq'] ?? [])->take(5)->values()->all();
        $projectCount = Project::query()->count();
        $testimonials = Testimonial::published()
            ->where(function ($query): void {
                $query->where('is_featured', true)->orWhere('featured', true);
            })
            ->orderBy('position')
            ->limit(3)
            ->get()
            ->map(fn (Testimonial $testimonial): array => ContentMapper::testimonialCard($testimonial))
            ->all();
        $clientLogos = ClientLogo::query()
            ->where('is_featured', true)
            ->where('verified', true)
            ->where('permission_given', true)
            ->orderBy('sort_order')
            ->limit(5)
            ->get()
            ->map(fn (ClientLogo $logo): array => ContentMapper::clientLogo($logo))
            ->all();
        $showClientLogos = config('portfolio.show_client_logos', false) && count($clientLogos) >= 3;
        $recentWorkTypes = [
            'Fleet SaaS platforms',
            'EHR systems',
            'FinOps tools',
            'Operational dashboards',
            'Internal workflow apps',
        ];

        $databaseServices = Service::published()
            ->orderByDesc('featured')
            ->orderBy('position')
            ->latest('published_at')
            ->get();

        if ($databaseServices->isNotEmpty()) {
            $serviceItems = $databaseServices->map(fn (Service $service): array => ContentMapper::serviceCard($service, $locale));
            $showcase['services'] = $serviceItems
                ->take(6)
                ->map(fn (array $service): array => [
                    'title' => $service['title'],
                    'copy' => $service['summary'],
                    'value' => $service['business_value'],
                ])
                ->values()
                ->all();
        }

        $databaseProjects = Project::published()
            ->with('screenshots')
            ->orderByDesc('featured')
            ->latest('published_at')
            ->latest('id')
            ->get();

        if ($databaseProjects->isNotEmpty()) {
            $projectItems = $databaseProjects->map(fn (Project $project): array => ContentMapper::projectCard($project, $locale));
            $showcase['projects'] = $projectItems->values()->all();
            $showcase['featured_projects'] = $this->takeFeatured($projectItems, 3)->all();
            $showcase['secondary_projects'] = $this->takeSecondary($projectItems, collect($showcase['featured_projects']), 2)->all();
        }

        $showcase['hero']['metrics'] = [
            ['value' => $projectCount, 'label' => 'Projects shipped'],
            ['value' => 'Since 2019', 'label' => 'Shipping across Morocco and international teams'],
            ['value' => 'EN / FR / AR / ES / DE', 'label' => 'Multilingual communication across buyer and delivery teams'],
        ];

        $serviceSchemas = $serviceItems
            ->map(fn (array $service): array => BrandContent::serviceSchema(
                $service,
                route('services.show', ['locale' => $locale, 'service' => $service['slug']])
            ))
            ->values()
            ->all();

        return view('pages.home', [
            'page' => $page,
            'showcase' => $showcase,
            'seo' => BrandContent::buildSeo(
                $locale,
                $page['seo'],
                $serviceSchemas,
                data_get($showcase, 'featured_projects.0.media.cover.src')
                    ?? data_get($projectItems->first(), 'media.cover.src')
                    ?? asset('images/projects/ecarsauto-case-study.png')
            ),
            'testimonials' => $testimonials,
            'clientLogos' => $clientLogos,
            'showClientLogos' => $showClientLogos,
            'recentWorkTypes' => $recentWorkTypes,
            'homeFaqItems' => $homeFaqItems,
            'homeStructuredData' => [
                BrandContent::personSchema($locale),
                BrandContent::websiteSchema($locale),
                BrandContent::faqSchema($homeFaqItems),
            ],
        ]);
    }

    public function about(): View
    {
        $locale = app()->getLocale();
        $page = BrandContent::about($locale);

        return view('pages.about', [
            'page' => $page,
            'seo' => BrandContent::buildSeo(
                $locale,
                $page['seo'],
                [BrandContent::personSchema($locale)],
                null,
                [
                    ['name' => 'Home', 'url' => route('home', ['locale' => $locale])],
                    ['name' => 'About', 'url' => route('about', ['locale' => $locale])],
                ]
            ),
        ]);
    }

    public function skills(): View
    {
        $locale = app()->getLocale();
        $page = BrandContent::skills($locale);

        return view('pages.skills', [
            'page' => $page,
            'seo' => BrandContent::buildSeo(
                $locale,
                $page['seo'],
                [BrandContent::personSchema($locale)],
                null,
                [
                    ['name' => 'Home', 'url' => route('home', ['locale' => $locale])],
                    ['name' => 'Expertise', 'url' => route('skills', ['locale' => $locale])],
                ]
            ),
        ]);
    }

    public function experience(): View
    {
        $locale = app()->getLocale();
        $page = BrandContent::experience($locale);

        return view('pages.experience', [
            'page' => $page,
            'seo' => BrandContent::buildSeo(
                $locale,
                $page['seo'],
                [BrandContent::personSchema($locale)],
                null,
                [
                    ['name' => 'Home', 'url' => route('home', ['locale' => $locale])],
                    ['name' => 'Experience', 'url' => route('experience', ['locale' => $locale])],
                ]
            ),
        ]);
    }

    public function resume(): View
    {
        $locale = app()->getLocale();
        $page = BrandContent::resume($locale);

        return view('pages.resume', [
            'page' => $page,
            'seo' => BrandContent::buildSeo(
                $locale,
                $page['seo'],
                [BrandContent::personSchema($locale)],
                asset('images/youyou-portrait.png'),
                [
                    ['name' => 'Home', 'url' => route('home', ['locale' => $locale])],
                    ['name' => 'Resume', 'url' => route('resume', ['locale' => $locale])],
                ]
            ),
        ]);
    }

    public function sitePage(string $slug): View
    {
        $locale = app()->getLocale();
        $page = BrandContent::sitePage($locale, $slug);
        abort_unless($page, 404);

        $schema = [BrandContent::personSchema($locale)];

        if (! empty($page['faq'])) {
            $schema[] = BrandContent::faqSchema($page['faq']);
        }

        return view('pages.site.show', [
            'page' => $page,
            'seo' => BrandContent::buildSeo(
                $locale,
                $page['seo'],
                $schema,
                null,
                [
                    ['name' => 'Home', 'url' => route('home', ['locale' => $locale])],
                    ['name' => $page['title'], 'url' => url()->current()],
                ]
            ),
        ]);
    }

    public function location(string $slug): View
    {
        $locale = app()->getLocale();
        $page = BrandContent::location($locale, $slug);
        abort_unless($page, 404);

        return view('pages.seo.location', [
            'page' => $page,
            'seo' => BrandContent::buildSeo(
                $locale,
                $page['seo'],
                [BrandContent::personSchema($locale)],
                asset('images/youyou-portrait.png'),
                [
                    ['name' => 'Home', 'url' => route('home', ['locale' => $locale])],
                    ['name' => $page['title'], 'url' => url()->current()],
                ]
            ),
        ]);
    }

    public function sitemap(): Response
    {
        $urls = [];

        foreach (BrandContent::supportedLocales() as $locale) {
            $urls[] = route('home', ['locale' => $locale]);
            $urls[] = route('about', ['locale' => $locale]);
            $urls[] = route('skills', ['locale' => $locale]);
            $urls[] = route('tech-stack', ['locale' => $locale]);
            $urls[] = route('experience', ['locale' => $locale]);
            $urls[] = route('resume', ['locale' => $locale]);
            $urls[] = route('industries', ['locale' => $locale]);
            $urls[] = route('process.page', ['locale' => $locale]);
            $urls[] = route('trust', ['locale' => $locale]);
            $urls[] = route('faq', ['locale' => $locale]);
            $urls[] = route('availability', ['locale' => $locale]);
            $urls[] = route('privacy-policy', ['locale' => $locale]);
            $urls[] = route('terms-of-service', ['locale' => $locale]);
            $urls[] = route('services.index', ['locale' => $locale]);
            $urls[] = route('projects.index', ['locale' => $locale]);
            $urls[] = route('blog.index', ['locale' => $locale]);
            $urls[] = route('contact.create', ['locale' => $locale]);

            $services = Service::published()->exists()
                ? Service::published()->get(['slug'])->map(fn (Service $service): array => ['slug' => $service->slug])->all()
                : BrandContent::serviceCatalog($locale);

            foreach ($services as $service) {
                $urls[] = route('services.show', ['locale' => $locale, 'service' => $service['slug']]);
            }

            $projects = Project::published()->exists()
                ? Project::published()->get(['slug'])->map(fn (Project $project): array => ['slug' => $project->slug])->all()
                : BrandContent::projectCatalog($locale);

            foreach ($projects as $project) {
                $urls[] = route('projects.show', ['locale' => $locale, 'project' => $project['slug']]);
            }

            $articles = Post::published()->exists()
                ? Post::published()->get(['slug'])->map(fn (Post $post): array => ['slug' => $post->slug])->all()
                : BrandContent::blogCatalog($locale);

            foreach ($articles as $article) {
                $urls[] = route('blog.show', ['locale' => $locale, 'slug' => $article['slug']]);
            }

            foreach (BrandContent::locationCatalog($locale) as $page) {
                $urls[] = route('pages.location', ['locale' => $locale, 'slug' => $page['slug']]);
            }
        }

        return response()
            ->view('sitemap.xml', ['urls' => array_values(array_unique($urls))])
            ->header('Content-Type', 'application/xml');
    }

    private function takeFeatured(Collection $projects, int $limit): Collection
    {
        $featured = $projects->filter(fn (array $project): bool => (bool) ($project['featured'] ?? false))->values();

        return $featured->count() >= $limit ? $featured->take($limit)->values() : $projects->take($limit)->values();
    }

    private function takeSecondary(Collection $projects, Collection $featured, int $limit): Collection
    {
        $featuredSlugs = $featured->pluck('slug')->filter()->all();

        return $projects
            ->reject(fn (array $project): bool => in_array($project['slug'], $featuredSlugs, true))
            ->take($limit)
            ->values();
    }
}
