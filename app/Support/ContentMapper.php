<?php

namespace App\Support;

use App\Models\Post;
use App\Models\ClientLogo;
use App\Models\Project;
use App\Models\Service;
use App\Models\Testimonial;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class ContentMapper
{
    public static function serviceCard(Service $service, string $locale): array
    {
        $meta = $service->meta ?? [];

        return [
            'title' => $service->localized('title', $locale),
            'slug' => $service->slug,
            'summary' => $service->localized('excerpt', $locale) ?: Str::limit(strip_tags((string) $service->localized('body', $locale)), 180),
            'business_value' => (string) ($meta['business_value'] ?? ($service->localized('excerpt', $locale) ?: 'Built to support a clearer business outcome.')),
            'who' => (string) ($meta['who'] ?? 'Businesses that need a tailored digital solution.'),
            'stack' => self::stringList($meta['stack'] ?? []),
            'deliverables' => self::stringList($meta['deliverables'] ?? []),
            'process' => self::stringList($meta['process'] ?? []),
            'features' => self::stringList($service->features ?? []),
            'featured_image' => self::mediaUrl($service->featured_image),
            'cta_url' => $service->cta_url,
            'status' => $service->status,
            'featured' => (bool) $service->featured,
            'seo' => self::seoForModel(
                $service,
                $service->localized('title', $locale).' | Services | Youssef Youyou',
                $service->localized('excerpt', $locale) ?: 'Service page for '.$service->localized('title', $locale),
                'service'
            ),
        ];
    }

    public static function projectCard(Project $project, string $locale): array
    {
        $meta = $project->meta ?? [];
        $gallery = collect($project->screenshots)->map(function ($screenshot): array {
            $src = $screenshot->image_path ? self::mediaUrl($screenshot->image_path) : $screenshot->image_url;

            return [
                'src' => $src,
                'alt' => $screenshot->caption ?: 'Project screenshot',
            ];
        })->filter(fn (array $image): bool => filled($image['src']))->values()->all();

        $cover = self::mediaUrl($project->screenshot_path ?: $project->hero_image);
        $coverWebp = self::mediaUrl($project->screenshot_webp_path);

        if ($cover && ! $project->is_nda) {
            array_unshift($gallery, [
                'src' => $cover,
                'webp' => $coverWebp,
                'alt' => (string) ($meta['cover_alt'] ?? ($project->localized('title', $locale).' preview')),
            ]);
        }

        return [
            'title' => $project->localized('title', $locale),
            'slug' => $project->slug,
            'label' => (string) ($meta['label'] ?? 'Custom product build'),
            'summary' => $project->localized('excerpt', $locale) ?: Str::limit(strip_tags((string) $project->localized('description', $locale)), 220),
            'client' => (string) ($project->client_name ?? $meta['client'] ?? 'Private client'),
            'client_industry' => (string) ($project->client_industry ?? $meta['industry'] ?? 'Digital product'),
            'audience' => (string) ($meta['audience'] ?? 'Businesses looking for a stronger digital product.'),
            'challenge' => (string) ($meta['challenge'] ?? 'The project needed clearer product framing and execution.'),
            'solution' => (string) ($meta['solution'] ?? 'I designed and built a cleaner system with stronger business alignment.'),
            'context' => (string) ($project->context ?? $meta['context'] ?? $project->localized('description', $locale) ?? ''),
            'problem_long' => (string) ($project->problem_long ?? $meta['challenge'] ?? ''),
            'solution_long' => (string) ($project->solution_long ?? $meta['solution'] ?? ''),
            'outcome_long' => (string) ($project->outcome_long ?? $meta['outcome'] ?? ''),
            'role' => (string) ($meta['role'] ?? 'Full-stack strategy, interface design, and implementation.'),
            'stack' => self::stringList($project->stack ?? []),
            'features' => self::stringList($meta['features'] ?? []),
            'outcome' => (string) ($meta['outcome'] ?? 'A more credible product presentation and stronger system foundation.'),
            'note' => (string) ($meta['note'] ?? 'Presented with real delivery context, clear scope, and the constraints that shaped the build.'),
            'result_headline' => (string) ($project->result_headline ?? $meta['result_headline'] ?? 'Built to remove friction and make the next release easier to trust.'),
            'is_concept' => (bool) $project->is_concept,
            'is_nda' => (bool) $project->is_nda,
            'built_at' => optional($project->built_at)->format('Y'),
            'metrics' => self::projectMetrics($project, $meta),
            'live_url' => $project->live_url,
            'media' => [
                'theme' => (string) ($meta['theme'] ?? 'default'),
                'logo' => filled($meta['logo_image'] ?? null) ? [
                    'src' => self::mediaUrl((string) $meta['logo_image']),
                    'alt' => (string) ($meta['logo_alt'] ?? ($project->localized('title', $locale).' logo')),
                ] : null,
                'cover' => $cover && ! $project->is_nda ? [
                    'src' => $cover,
                    'webp' => $coverWebp,
                    'alt' => (string) ($meta['cover_alt'] ?? ($project->localized('title', $locale).' cover image')),
                ] : null,
                'gallery' => $gallery,
            ],
            'seo' => self::seoForModel(
                $project,
                $project->localized('title', $locale).' | Case Study | Youssef Youyou',
                $project->localized('excerpt', $locale) ?: 'Case study for '.$project->localized('title', $locale),
                'website'
            ),
        ];
    }

    public static function postCard(Post $post, string $locale): array
    {
        return [
            'title' => $post->localized('title', $locale),
            'slug' => $post->slug,
            'excerpt' => $post->localized('excerpt', $locale) ?: Str::limit(strip_tags((string) $post->localized('body', $locale)), 180),
            'published_at' => optional($post->published_at)->format('M d, Y') ?? optional($post->created_at)->format('M d, Y'),
            'reading_time' => $post->reading_time,
            'cover_image' => self::mediaUrl($post->cover_image),
            'seo' => self::seoForModel(
                $post,
                $post->localized('title', $locale).' | Insights | Youssef Youyou',
                $post->localized('excerpt', $locale) ?: 'Article by Youssef Youyou',
                'article'
            ),
        ];
    }

    public static function articlePage(Post $post, string $locale): array
    {
        $body = trim((string) $post->localized('body', $locale));
        $paragraphs = preg_split("/\R{2,}/", $body) ?: [];
        $sections = [[
            'title' => 'Article',
            'paragraphs' => collect($paragraphs)->map(fn (string $paragraph) => trim($paragraph))->filter()->values()->all(),
        ]];

        return array_merge(self::postCard($post, $locale), [
            'sections' => $sections[0]['paragraphs'] === [] ? [[
                'title' => 'Article',
                'paragraphs' => [$body],
            ]] : $sections,
        ]);
    }

    public static function testimonialCard(Testimonial $testimonial): array
    {
        return [
            'name' => $testimonial->display_name,
            'company' => $testimonial->display_company,
            'title' => $testimonial->display_title,
            'location' => $testimonial->location,
            'quote' => $testimonial->quote,
            'avatar' => self::mediaUrl($testimonial->display_avatar),
            'featured' => $testimonial->display_featured,
        ];
    }

    public static function clientLogo(ClientLogo $logo): array
    {
        return [
            'name' => $logo->name,
            'image_path' => self::mediaUrl($logo->image_path) ?? asset($logo->image_path),
            'website_url' => $logo->website_url,
            'alt_text' => $logo->alt_text ?: $logo->name.' logo',
            'verified' => (bool) $logo->verified,
            'permission_given' => (bool) $logo->permission_given,
        ];
    }

    public static function seoForModel(object $model, string $defaultTitle, string $defaultDescription, string $type = 'website'): array
    {
        $meta = $model->meta ?? [];

        return [
            'title' => (string) ($meta['seo_title'] ?? $defaultTitle),
            'description' => (string) ($meta['seo_description'] ?? $defaultDescription),
            'keywords' => (string) ($meta['seo_keywords'] ?? ''),
            'type' => $type,
            'image' => self::mediaUrl($meta['seo_image'] ?? ($model->cover_image ?? $model->hero_image ?? $model->featured_image ?? null)),
        ];
    }

    public static function mediaUrl(?string $path): ?string
    {
        if (! filled($path)) {
            return null;
        }

        if (Str::startsWith($path, ['http://', 'https://', '/storage/', 'storage/'])) {
            return Str::startsWith($path, 'storage/') ? asset($path) : $path;
        }

        if (file_exists(public_path(ltrim($path, '/')))) {
            return asset(ltrim($path, '/'));
        }

        return Storage::disk('public')->url($path);
    }

    public static function stringList(array|string|null $value): array
    {
        if (is_array($value)) {
            return collect($value)->map(fn ($item) => trim((string) $item))->filter()->values()->all();
        }

        return collect(preg_split('/\r\n|\r|\n|,/', (string) $value))
            ->map(fn ($item) => trim((string) $item))
            ->filter()
            ->values()
            ->all();
    }

    public static function metricList(array|string|null $value): array
    {
        if (is_array($value)) {
            return collect($value)
                ->map(fn ($item) => [
                    'label' => trim((string) ($item['label'] ?? 'Metric')),
                    'value' => trim((string) ($item['value'] ?? '')),
                ])
                ->filter(fn (array $item) => $item['value'] !== '')
                ->values()
                ->all();
        }

        return collect(preg_split('/\r\n|\r|\n/', (string) $value))
            ->map(function (string $line): ?array {
                $line = trim($line);
                if ($line === '') {
                    return null;
                }

                [$label, $value] = array_pad(explode('|', $line, 2), 2, '');

                return [
                    'label' => trim($label) ?: 'Metric',
                    'value' => trim($value) ?: trim($label),
                ];
            })
            ->filter()
            ->values()
            ->all();
    }

    private static function projectMetrics(Project $project, array $meta): array
    {
        $resultMetrics = collect([
            ['label' => $project->result_1_label, 'value' => $project->result_1_value],
            ['label' => $project->result_2_label, 'value' => $project->result_2_value],
            ['label' => $project->result_3_label, 'value' => $project->result_3_value],
        ])->filter(fn (array $metric): bool => filled($metric['label']) && filled($metric['value']))->values();

        if ($resultMetrics->isNotEmpty()) {
            return $resultMetrics->all();
        }

        $dbMetrics = collect([
            ['label' => $project->metric_one_label, 'value' => $project->metric_one_value],
            ['label' => $project->metric_two_label, 'value' => $project->metric_two_value],
            ['label' => $project->metric_three_label, 'value' => $project->metric_three_value],
        ])->filter(fn (array $metric): bool => filled($metric['label']) && filled($metric['value']))->values();

        if ($dbMetrics->isNotEmpty()) {
            return $dbMetrics->all();
        }

        return self::metricList($meta['metrics'] ?? []);
    }
}
