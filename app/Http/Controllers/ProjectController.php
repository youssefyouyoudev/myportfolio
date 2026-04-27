<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Support\BrandContent;
use App\Support\ContentMapper;
use Illuminate\View\View;

class ProjectController extends Controller
{
    public function index(): View
    {
        $locale = app()->getLocale();
        $page = BrandContent::projectsIndex($locale);
        $projects = Project::published()
            ->with('screenshots')
            ->orderByDesc('featured')
            ->latest('published_at')
            ->latest('id')
            ->get();

        if ($projects->isNotEmpty()) {
            $page['items'] = $projects->map(fn (Project $project): array => ContentMapper::projectCard($project, $locale))->all();
        }

        return view('pages.projects.index', [
            'page' => $page,
            'seo' => BrandContent::buildSeo(
                $locale,
                $page['seo'],
                [BrandContent::personSchema($locale)],
                $page['items'][0]['media']['cover']['src'] ?? asset('images/projects/ecarsauto-case-study.png'),
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
        $databaseProjects = Project::published()
            ->with('screenshots')
            ->orderByDesc('featured')
            ->latest('published_at')
            ->latest('id')
            ->get();

        $databaseProject = $databaseProjects->firstWhere('slug', $project);
        if ($databaseProject) {
            $page = ContentMapper::projectCard($databaseProject, $locale);
            $catalog = $databaseProjects->map(fn (Project $item): array => ContentMapper::projectCard($item, $locale))->values()->all();
        } else {
            $page = BrandContent::project($locale, $project);
            abort_unless($page, 404);
            $catalog = array_values(BrandContent::projectCatalog($locale));
        }

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
