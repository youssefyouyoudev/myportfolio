<?php

namespace App\Services;

use DOMDocument;
use DOMElement;
use DOMXPath;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;

class ExternalBlogService
{
    public function latest(int $limit = 3): array
    {
        $fallback = collect(config('external-blog.posts', []))->take($limit)->values()->all();

        return Cache::remember('external_blog.latest_posts', now()->addHours(6), function () use ($fallback, $limit): array {
            $baseUrl = rtrim((string) config('external-blog.base_url'), '/');

            try {
                $response = Http::timeout(4)
                    ->accept('text/html')
                    ->get($baseUrl.'/posts');

                if (! $response->ok()) {
                    return $fallback;
                }

                $posts = $this->parsePosts($response->body(), $baseUrl, $limit, $fallback);

                return count($posts) >= $limit ? $posts : $fallback;
            } catch (\Throwable) {
                return $fallback;
            }
        });
    }

    private function parsePosts(string $html, string $baseUrl, int $limit, array $fallback): array
    {
        $document = new DOMDocument();
        libxml_use_internal_errors(true);
        $document->loadHTML($html, LIBXML_NOERROR | LIBXML_NOWARNING);
        libxml_clear_errors();

        $xpath = new DOMXPath($document);
        $articles = $xpath->query('//article[.//a[starts-with(@href, "'.$baseUrl.'/posts/")]]');
        $posts = [];

        foreach ($articles as $article) {
            if (! $article instanceof DOMElement) {
                continue;
            }

            $url = $this->firstAttribute($xpath, './/a[starts-with(@href, "'.$baseUrl.'/posts/")]', 'href', $article);
            $title = $this->firstText($xpath, './/a[starts-with(@href, "'.$baseUrl.'/posts/") and contains(@class, "text-xl")]', $article)
                ?: $this->firstText($xpath, './/a[starts-with(@href, "'.$baseUrl.'/posts/")][2]', $article);

            if (! $url || ! $title) {
                continue;
            }

            $posts[] = [
                'title' => $title,
                'url' => $url,
                'excerpt' => $this->firstText($xpath, './/p[contains(@class, "line-clamp-2")]', $article),
                'image' => html_entity_decode($this->firstAttribute($xpath, './/img', 'src', $article) ?: '', ENT_QUOTES),
                'category' => $this->firstText($xpath, './/span[contains(@class, "uppercase")]', $article),
                'published_at' => $this->firstText($xpath, './/p[contains(@class, "text-slate-400")]', $article),
            ];

            if (count($posts) >= $limit) {
                break;
            }
        }

        $fallbackByUrl = collect($fallback)->keyBy('url');

        return collect($posts)
            ->map(function (array $post) use ($fallbackByUrl): array {
                $fallbackPost = $fallbackByUrl->get($post['url'], []);

                return [
                    'title' => Str::squish($post['title']),
                    'url' => $post['url'],
                    'excerpt' => Str::squish($post['excerpt'] ?: 'A practical guide from Youssef Blog.'),
                    'image' => $post['image'] ?: asset('images/youyou-portrait.png'),
                    'category' => Str::squish($post['category'] ?: 'Article'),
                    'published_at' => Str::squish($post['published_at'] ?: ''),
                    ...$fallbackPost,
                ];
            })
            ->values()
            ->all();
    }

    private function firstText(DOMXPath $xpath, string $query, DOMElement $context): ?string
    {
        $node = $xpath->query($query, $context)?->item(0);

        return $node ? trim($node->textContent) : null;
    }

    private function firstAttribute(DOMXPath $xpath, string $query, string $attribute, DOMElement $context): ?string
    {
        $node = $xpath->query($query, $context)?->item(0);

        return $node instanceof DOMElement ? $node->getAttribute($attribute) : null;
    }
}
