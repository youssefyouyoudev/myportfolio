<?php

namespace App\Http\Controllers;

use App\Support\BrandContent;
use Illuminate\View\View;

class ProjectController extends Controller
{
    public function index(): View
    {
        $locale = app()->getLocale();
        $page = BrandContent::projectsIndex($locale);

        return view('pages.projects.index', [
            'page' => $page,
            'seo' => BrandContent::buildSeo(
                $locale,
                $page['seo'],
                [BrandContent::personSchema($locale)],
                asset('images/projects/ecarsauto-case-study.png'),
                [
                    ['name' => 'Home', 'url' => route('home', ['locale' => $locale])],
                    ['name' => 'Projects', 'url' => route('projects.index', ['locale' => $locale])],
                ]
            ),
        ]);
    }

    public function show(string $project): View
    {
        $locale = app()->getLocale();
        $page = BrandContent::project($locale, $project);
        abort_unless($page, 404);
        $catalog = array_values(BrandContent::projectCatalog($locale));
        $index = collect($catalog)->search(static fn (array $item): bool => $item['slug'] === $project);
        $previous = $index !== false && $index > 0 ? $catalog[$index - 1] : null;
        $next = $index !== false && $index < count($catalog) - 1 ? $catalog[$index + 1] : null;

        return view('pages.projects.show', [
            'page' => $page,
            'previous' => $previous,
            'next' => $next,
            'seo' => BrandContent::buildSeo(
                $locale,
                $page['seo'],
                [
                    BrandContent::personSchema($locale),
                    BrandContent::projectSchema($page, route('projects.show', ['locale' => $locale, 'project' => $project])),
                ],
                $page['media']['cover']['src'] ?? $page['media']['logo']['src'] ?? null,
                [
                    ['name' => 'Home', 'url' => route('home', ['locale' => $locale])],
                    ['name' => 'Projects', 'url' => route('projects.index', ['locale' => $locale])],
                    ['name' => $page['title'], 'url' => route('projects.show', ['locale' => $locale, 'project' => $project])],
                ]
            ),
        ]);
    }
}
