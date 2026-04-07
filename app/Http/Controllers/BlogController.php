<?php

namespace App\Http\Controllers;

use App\Support\BrandContent;
use Illuminate\View\View;

class BlogController extends Controller
{
    public function index(): View
    {
        $locale = app()->getLocale();
        $page = BrandContent::blogIndex($locale);

        return view('pages.blog.index', [
            'page' => $page,
            'seo' => array_merge($page['seo'], [
                'schema' => [BrandContent::personSchema($locale)],
            ]),
        ]);
    }

    public function show(string $slug): View
    {
        $locale = app()->getLocale();
        $page = BrandContent::article($locale, $slug);
        abort_unless($page, 404);

        return view('pages.blog.show', [
            'page' => $page,
            'seo' => array_merge($page['seo'], [
                'schema' => [
                    BrandContent::personSchema($locale),
                    BrandContent::articleSchema($page, route('blog.show', ['locale' => $locale, 'slug' => $slug])),
                ],
            ]),
        ]);
    }
}
