<?php

namespace App\Http\Controllers;

use App\Support\BrandContent;
use Illuminate\Http\Response;
use Illuminate\View\View;

class SiteController extends Controller
{
    public function home(): View
    {
        $locale = app()->getLocale();
        $page = BrandContent::home($locale);
        $serviceSchemas = array_map(
            static fn (array $service): array => BrandContent::serviceSchema(
                $service,
                route('services.show', ['locale' => $locale, 'service' => $service['slug']])
            ),
            BrandContent::serviceCatalog($locale)
        );

        return view('pages.home', [
            'page' => $page,
            'showcase' => BrandContent::homeShowcase($locale),
            'seo' => BrandContent::buildSeo(
                $locale,
                $page['seo'],
                array_merge([BrandContent::personSchema($locale)], $serviceSchemas),
                asset('images/projects/ecarsauto-case-study.png')
            ),
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

            foreach (BrandContent::serviceCatalog($locale) as $service) {
                $urls[] = route('services.show', ['locale' => $locale, 'service' => $service['slug']]);
            }

            foreach (BrandContent::projectCatalog($locale) as $project) {
                $urls[] = route('projects.show', ['locale' => $locale, 'project' => $project['slug']]);
            }

            foreach (BrandContent::blogCatalog($locale) as $article) {
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
}
