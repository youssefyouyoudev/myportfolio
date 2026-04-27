<?php

namespace App\Services\LeadFinder;

use Illuminate\Http\Client\Factory as HttpFactory;
use Illuminate\Support\Arr;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Str;
use RuntimeException;

class LeadSearchService
{
    public function __construct(
        private readonly HttpFactory $http,
        private readonly LeadScoringService $scoringService,
        private readonly LeadPitchGeneratorService $pitchGeneratorService,
    ) {
    }

    public function find(array $criteria): array
    {
        $location = $this->locateCity($criteria['city'], $criteria['country']);
        $candidates = $this->searchOverpass($criteria, $location);

        return $candidates
            ->take((int) $criteria['max_results'])
            ->map(function (array $candidate) use ($criteria): array {
                $audit = $this->auditWebsite($candidate['website'] ?? null);
                $score = $this->scoringService->score($candidate, $audit);

                $lead = array_merge($candidate, [
                    'category' => $criteria['category'],
                    'country' => $criteria['country'],
                    'website' => $audit['normalized_website'] ?? $candidate['website'],
                    'online_presence_score' => $score['score'],
                    'online_presence_issues' => $score['issues'],
                    'social_links' => $audit['social_links'] ?? [],
                    'audit' => $audit,
                    'estimated_revenue' => $this->estimateRevenue($criteria['category'], $score['score']),
                ]);

                $lead['pitch_payload'] = $this->pitchGeneratorService->generate($lead);
                $lead['notes'] = $this->buildNotes($lead);
                $lead['fingerprint'] = sha1(implode('|', [
                    $lead['external_id'] ?? '',
                    Str::lower($lead['business_name'] ?? ''),
                    Str::lower($lead['city'] ?? ''),
                    Str::lower($lead['website'] ?? ''),
                ]));

                return $lead;
            })
            ->sortByDesc('online_presence_score')
            ->values()
            ->all();
    }

    private function locateCity(string $city, string $country): array
    {
        $response = $this->http->acceptJson()
            ->withUserAgent($this->userAgent())
            ->timeout(20)
            ->get('https://nominatim.openstreetmap.org/search', [
                'q' => "{$city}, {$country}",
                'format' => 'jsonv2',
                'limit' => 1,
                'addressdetails' => 1,
                'email' => 'contact@youssefyouyou.com',
            ]);

        $location = $response->throw()->json()[0] ?? null;

        if (! $location || empty($location['boundingbox'])) {
            throw new RuntimeException('Location could not be resolved. Try a broader city or a clearer country name.');
        }

        return $location;
    }

    private function searchOverpass(array $criteria, array $location): Collection
    {
        $south = (float) $location['boundingbox'][0];
        $north = (float) $location['boundingbox'][1];
        $west = (float) $location['boundingbox'][2];
        $east = (float) $location['boundingbox'][3];

        $query = $this->buildOverpassQuery($criteria['category'], $south, $west, $north, $east, (int) $criteria['max_results'] * 3);

        $response = $this->http->acceptJson()
            ->withUserAgent($this->userAgent())
            ->timeout(30)
            ->asForm()
            ->post('https://overpass-api.de/api/interpreter', ['data' => $query]);

        $elements = $response->throw()->json('elements') ?? [];

        return collect($elements)
            ->map(fn (array $element) => $this->mapOverpassElement($element, $criteria, $location))
            ->filter()
            ->unique(fn (array $lead) => $lead['external_id'] ?? sha1($lead['business_name'].$lead['city'].$lead['website']))
            ->values();
    }

    private function buildOverpassQuery(string $category, float $south, float $west, float $north, float $east, int $limit): string
    {
        $selectors = $this->categorySelectors($category);

        $queryParts = collect($selectors)->map(function (array $selector) use ($south, $west, $north, $east): string {
            [$key, $value] = $selector;

            return sprintf('nwr["%s"~"%s",i](%s,%s,%s,%s);', $key, $value, $south, $west, $north, $east);
        })->implode("\n");

        return <<<OVERPASS
[out:json][timeout:25];
(
{$queryParts}
);
out center;
OVERPASS;
    }

    private function categorySelectors(string $category): array
    {
        $slug = Str::of($category)->lower()->trim()->replace(['&', '/', ','], ' ')->replaceMatches('/\s+/', '_')->value();

        $map = [
            'restaurant' => [['amenity', '^restaurant$'], ['amenity', '^cafe$'], ['name', 'restaurant|cafe']],
            'hotel' => [['tourism', '^hotel$'], ['tourism', '^guest_house$'], ['name', 'hotel|riad']],
            'salon' => [['shop', '^hairdresser$'], ['shop', '^beauty$'], ['name', 'salon|beauty']],
            'real_estate' => [['office', '^estate_agent$'], ['name', 'immobilier|real estate']],
            'gym' => [['leisure', '^fitness_centre$'], ['name', 'gym|fitness']],
            'clinic' => [['amenity', '^clinic$'], ['amenity', '^hospital$'], ['name', 'clinic|medical']],
            'dentist' => [['amenity', '^dentist$'], ['name', 'dentist|dental']],
            'pharmacy' => [['amenity', '^pharmacy$'], ['shop', '^chemist$'], ['name', 'pharmacy']],
            'school' => [['amenity', '^school$'], ['amenity', '^college$'], ['name', 'school|academy']],
            'bakery' => [['shop', '^bakery$'], ['name', 'bakery|patisserie']],
            'car_rental' => [['amenity', '^car_rental$'], ['shop', '^car$'], ['name', 'car rental|rent a car']],
            'auto_repair' => [['shop', '^car_repair$'], ['craft', '^mechanic$'], ['name', 'garage|repair']],
            'law_firm' => [['office', '^lawyer$'], ['name', 'law|avocat']],
            'accounting' => [['office', '^accountant$'], ['name', 'accounting|fiduciaire']],
            'agency' => [['office', '^company$'], ['office', '^advertising_agency$'], ['name', 'agency']],
        ];

        if (isset($map[$slug])) {
            return $map[$slug];
        }

        $regex = preg_quote(Str::replace('_', ' ', $slug), '/');

        return [
            ['amenity', $regex],
            ['shop', $regex],
            ['office', $regex],
            ['tourism', $regex],
            ['craft', $regex],
            ['leisure', $regex],
            ['name', $regex],
        ];
    }

    private function mapOverpassElement(array $element, array $criteria, array $location): ?array
    {
        $tags = $element['tags'] ?? [];
        $businessName = $tags['name'] ?? null;

        if (! filled($businessName)) {
            return null;
        }

        $website = $tags['website'] ?? $tags['contact:website'] ?? null;
        $phone = $tags['phone'] ?? $tags['contact:phone'] ?? null;
        $email = $tags['email'] ?? $tags['contact:email'] ?? null;
        $city = $tags['addr:city'] ?? Arr::get($location, 'address.city') ?? Arr::get($location, 'address.town') ?? $criteria['city'];
        $sourceLabel = 'OpenStreetMap / Overpass';
        $externalId = strtolower(($element['type'] ?? 'osm').':'.($element['id'] ?? sha1($businessName)));

        return [
            'business_name' => $businessName,
            'category' => $criteria['category'],
            'city' => $city,
            'phone' => $phone,
            'email' => $email,
            'website' => $website,
            'source' => 'OpenStreetMap',
            'source_label' => $sourceLabel,
            'external_id' => $externalId,
            'latitude' => $element['center']['lat'] ?? $element['lat'] ?? null,
            'longitude' => $element['center']['lon'] ?? $element['lon'] ?? null,
        ];
    }

    private function auditWebsite(?string $website): array
    {
        if (! filled($website)) {
            return [
                'website_checked' => false,
                'social_links' => [],
                'has_whatsapp_link' => false,
                'weak_seo' => false,
                'slow_or_broken' => false,
                'broken' => false,
                'contact_cta_detected' => false,
            ];
        }

        $normalizedWebsite = $this->normalizeWebsite($website);
        if (! $normalizedWebsite) {
            return [
                'website_checked' => false,
                'social_links' => [],
                'has_whatsapp_link' => false,
                'weak_seo' => true,
                'slow_or_broken' => true,
                'broken' => true,
                'contact_cta_detected' => false,
            ];
        }

        try {
            $startedAt = microtime(true);
            $response = $this->http->withUserAgent($this->userAgent())
                ->timeout(10)
                ->accept('text/html,application/xhtml+xml')
                ->get($normalizedWebsite);

            $responseMs = (int) round((microtime(true) - $startedAt) * 1000);
            $body = $response->successful() ? (string) $response->body() : '';
            $lowerBody = Str::lower($body);

            preg_match('/<title[^>]*>(.*?)<\/title>/is', $body, $titleMatch);
            preg_match('/<meta[^>]+name=["\']description["\'][^>]+content=["\'](.*?)["\']/is', $body, $descriptionMatch);
            preg_match_all('/href=["\']([^"\']+)["\']/is', $body, $hrefMatches);

            $links = collect($hrefMatches[1] ?? []);
            $socialLinks = $links->filter(fn (string $href): bool => Str::contains($href, ['facebook.com', 'instagram.com', 'linkedin.com', 'tiktok.com', 'youtube.com', 'x.com', 'twitter.com']))
                ->unique()
                ->values()
                ->all();
            $hasWhatsapp = $links->contains(fn (string $href): bool => Str::contains($href, ['wa.me', 'whatsapp.com']));
            $hasMetaDescription = filled($descriptionMatch[1] ?? null);
            $title = trim(strip_tags($titleMatch[1] ?? ''));
            $weakSeo = ! filled($title) || mb_strlen($title) < 20 || ! $hasMetaDescription;
            $broken = ! $response->successful();
            $slow = $responseMs > 3500;
            $contactCta = Str::contains($lowerBody, ['contact', 'whatsapp', 'quote', 'request a demo', 'book now', 'call now']);

            return [
                'website_checked' => true,
                'normalized_website' => $normalizedWebsite,
                'http_status' => $response->status(),
                'response_ms' => $responseMs,
                'seo_title' => $title,
                'meta_description' => trim(strip_tags($descriptionMatch[1] ?? '')),
                'social_links' => $socialLinks,
                'has_whatsapp_link' => $hasWhatsapp,
                'weak_seo' => $weakSeo,
                'slow_or_broken' => $slow || $broken,
                'broken' => $broken,
                'contact_cta_detected' => $contactCta,
            ];
        } catch (\Throwable $exception) {
            Log::warning('Lead finder website audit failed', [
                'website' => $website,
                'error' => $exception->getMessage(),
            ]);

            return [
                'website_checked' => true,
                'normalized_website' => $normalizedWebsite,
                'social_links' => [],
                'has_whatsapp_link' => false,
                'weak_seo' => true,
                'slow_or_broken' => true,
                'broken' => true,
                'contact_cta_detected' => false,
            ];
        }
    }

    private function normalizeWebsite(?string $website): ?string
    {
        if (! filled($website)) {
            return null;
        }

        $website = trim((string) $website);

        if (! Str::startsWith($website, ['http://', 'https://'])) {
            $website = 'https://'.$website;
        }

        return filter_var($website, FILTER_VALIDATE_URL) ? $website : null;
    }

    private function estimateRevenue(string $category, int $score): float
    {
        $base = match (Str::lower($category)) {
            'hotel', 'clinic', 'dentist', 'real estate' => 12000,
            'car rental', 'auto repair', 'agency' => 9000,
            default => 6000,
        };

        return $base + ($score * 40);
    }

    private function buildNotes(array $lead): string
    {
        $issues = collect($lead['online_presence_issues'] ?? [])->implode(', ');

        return trim(implode("\n", array_filter([
            'Found via AI Lead Finder using safe OSM sources.',
            filled($issues) ? 'Opportunity signals: '.$issues : null,
            filled($lead['website'] ?? null) ? 'Website checked for basic SEO, speed, and social visibility.' : 'No website found, strong outreach angle.',
        ])));
    }

    private function userAgent(): string
    {
        return config('app.name', 'Youssef Youyou').' Lead Finder/1.0 (contact@youssefyouyou.com)';
    }
}
