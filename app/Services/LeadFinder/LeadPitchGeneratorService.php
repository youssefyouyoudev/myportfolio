<?php

namespace App\Services\LeadFinder;

class LeadPitchGeneratorService
{
    public function generate(array $lead): array
    {
        $business = $lead['business_name'] ?? 'your business';
        $city = $lead['city'] ?? 'your city';
        $category = $lead['category'] ?? 'your business category';
        $issues = collect($lead['online_presence_issues'] ?? [])->take(3)->implode(', ');
        $pain = $issues !== '' ? "I noticed {$issues}." : 'I noticed a few easy opportunities to improve visibility and conversion.';

        return [
            'whatsapp_pitch' => "Hello {$business}, I work with businesses in {$city} to improve websites, SEO, and lead generation. {$pain} If you want, I can share a quick audit with a few practical fixes.",
            'email_pitch' => "Hi {$business},\n\nI help {$category} businesses turn weak online presence into stronger trust and more enquiries. {$pain}\n\nIf useful, I can send a short audit with specific ideas for your website, visibility, and conversion flow.\n\nBest,\nYoussef Youyou",
            'follow_up_message' => "Hello {$business}, just following up in case improving your online presence is still a priority. I can send a short audit with concrete recommendations whenever you want.",
            'free_audit_message' => "I put together a free mini audit for {$business} showing the highest-impact ways to improve trust, visibility, and lead capture. If you want it, I can send it over.",
        ];
    }
}
