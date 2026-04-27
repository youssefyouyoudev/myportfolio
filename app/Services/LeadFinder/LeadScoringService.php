<?php

namespace App\Services\LeadFinder;

class LeadScoringService
{
    public function score(array $lead, array $audit = []): array
    {
        $issues = [];
        $score = 0;

        if (! filled($lead['website'] ?? null)) {
            $score += 40;
            $issues[] = 'No website';
        }

        if (! filled($lead['phone'] ?? null)) {
            $score += 12;
            $issues[] = 'Missing phone';
        }

        if (! filled($lead['email'] ?? null)) {
            $score += 10;
            $issues[] = 'Missing email';
        }

        $socialLinks = collect($audit['social_links'] ?? [])->filter()->values()->all();
        if ($socialLinks === []) {
            $score += 10;
            $issues[] = 'No social links';
        }

        if (! ($audit['has_whatsapp_link'] ?? false)) {
            $score += 8;
            $issues[] = 'No WhatsApp link';
        }

        if (($audit['website_checked'] ?? false) && ($audit['weak_seo'] ?? false)) {
            $score += 8;
            $issues[] = 'Weak SEO title/meta';
        }

        if (($audit['website_checked'] ?? false) && ($audit['slow_or_broken'] ?? false)) {
            $score += 12;
            $issues[] = ($audit['broken'] ?? false) ? 'Broken website' : 'Slow website';
        }

        if (($audit['website_checked'] ?? false) && ! ($audit['contact_cta_detected'] ?? false)) {
            $score += 5;
            $issues[] = 'Weak contact CTA';
        }

        return [
            'score' => min(100, $score),
            'issues' => array_values(array_unique($issues)),
        ];
    }
}
