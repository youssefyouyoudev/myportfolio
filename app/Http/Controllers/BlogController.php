<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Support\BrandContent;
use App\Support\ContentMapper;
use Illuminate\View\View;

class BlogController extends Controller
{
    public function index(): View
    {
        $locale = app()->getLocale();
        $page = BrandContent::blogIndex($locale);
        $posts = Post::published()
            ->orderByDesc('featured')
            ->latest('published_at')
            ->latest('id')
            ->get();

        if ($posts->isNotEmpty()) {
            $page['items'] = $posts->map(fn (Post $post): array => ContentMapper::postCard($post, $locale))->all();
        }

        return view('pages.blog.index', [
            'page' => $page,
            'seo' => BrandContent::buildSeo(
                $locale,
                $page['seo'],
                [BrandContent::personSchema($locale)],
                $page['items'][0]['cover_image'] ?? null,
                [
                    ['name' => 'Home', 'url' => route('home', ['locale' => $locale])],
                    ['name' => 'Blog', 'url' => route('blog.index', ['locale' => $locale])],
                ]
            ),
        ]);
    }

    public function show(string $slug): View
    {
        $locale = app()->getLocale();
        $post = Post::published()->where('slug', $slug)->first();
        $page = $post ? ContentMapper::articlePage($post, $locale) : BrandContent::article($locale, $slug);
        abort_unless($page, 404);

        return view('pages.blog.show', [
            'page' => $page,
            'seo' => BrandContent::buildSeo(
                $locale,
                $page['seo'],
                [
                    BrandContent::personSchema($locale),
                    BrandContent::articleSchema($page, route('blog.show', ['locale' => $locale, 'slug' => $slug])),
                ],
                $page['cover_image'] ?? null,
                [
                    ['name' => 'Home', 'url' => route('home', ['locale' => $locale])],
                    ['name' => 'Blog', 'url' => route('blog.index', ['locale' => $locale])],
                    ['name' => $page['title'], 'url' => route('blog.show', ['locale' => $locale, 'slug' => $slug])],
                ]
            ),
        ]);
    }
}
