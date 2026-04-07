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
            'seo' => array_merge($page['seo'], [
                'schema' => [BrandContent::personSchema($locale)],
            ]),
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
            'seo' => array_merge($page['seo'], [
                'schema' => [BrandContent::personSchema($locale)],
            ]),
        ]);
    }
}
