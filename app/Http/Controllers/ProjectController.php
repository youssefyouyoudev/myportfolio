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

        return view('pages.projects.show', [
            'page' => $page,
            'seo' => array_merge($page['seo'], [
                'schema' => [BrandContent::personSchema($locale)],
            ]),
        ]);
    }
}
