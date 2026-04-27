<?php

namespace App\Services\LeadFinder;

use App\Models\CrmLead;
use Illuminate\Support\Arr;
use Illuminate\Support\Str;

class LeadImportService
{
    public function import(array $candidates, bool $markHot = false): array
    {
        $imported = 0;
        $duplicates = 0;

        foreach ($candidates as $candidate) {
            if ($this->findDuplicate($candidate)) {
                $duplicates++;
                continue;
            }

            CrmLead::create([
                'business_name' => $candidate['business_name'],
                'category' => $candidate['category'] ?? null,
                'city' => $candidate['city'] ?? null,
                'phone' => $candidate['phone'] ?? null,
                'email' => $candidate['email'] ?? null,
                'website' => $candidate['website'] ?? null,
                'source' => $candidate['source'] ?? 'OpenStreetMap',
                'source_type' => 'lead_finder',
                'external_id' => $candidate['external_id'] ?? null,
                'notes' => $candidate['notes'] ?? null,
                'status' => $markHot ? CrmLead::STATUS_HOT : ($candidate['status'] ?? CrmLead::STATUS_NEW),
                'review_status' => CrmLead::REVIEW_PENDING,
                'online_presence_score' => (int) ($candidate['online_presence_score'] ?? 0),
                'online_presence_issues' => $candidate['online_presence_issues'] ?? [],
                'social_links' => $candidate['social_links'] ?? [],
                'pitch_payload' => $candidate['pitch_payload'] ?? [],
                'source_data' => Arr::only($candidate, ['latitude', 'longitude', 'audit', 'country', 'source_label']),
                'reply_count' => 0,
                'estimated_revenue' => $candidate['estimated_revenue'] ?? null,
                'found_at' => now(),
            ]);

            $imported++;
        }

        return [
            'imported' => $imported,
            'duplicates' => $duplicates,
        ];
    }

    private function findDuplicate(array $candidate): ?CrmLead
    {
        $externalId = $candidate['external_id'] ?? null;

        if (filled($externalId)) {
            $duplicate = CrmLead::query()
                ->where('source_type', 'lead_finder')
                ->where('external_id', $externalId)
                ->first();

            if ($duplicate) {
                return $duplicate;
            }
        }

        $business = Str::lower(trim((string) ($candidate['business_name'] ?? '')));
        $city = Str::lower(trim((string) ($candidate['city'] ?? '')));
        $website = Str::lower(trim((string) ($candidate['website'] ?? '')));
        $phone = preg_replace('/\D+/', '', (string) ($candidate['phone'] ?? ''));

        return CrmLead::query()
            ->whereRaw('lower(business_name) = ?', [$business])
            ->when($city !== '', fn ($query) => $query->whereRaw('lower(city) = ?', [$city]))
            ->get()
            ->first(function (CrmLead $lead) use ($website, $phone): bool {
                $leadWebsite = Str::lower(trim((string) $lead->website));
                $leadPhone = preg_replace('/\D+/', '', (string) $lead->phone);

                if ($website !== '' && $leadWebsite === $website) {
                    return true;
                }

                if ($phone !== '' && $leadPhone === $phone) {
                    return true;
                }

                return $website === '' && $phone === '';
            });
    }
}
