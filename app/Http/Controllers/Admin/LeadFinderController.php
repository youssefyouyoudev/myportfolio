<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreLeadFinderSearchRequest;
use App\Services\LeadFinder\LeadImportService;
use App\Services\LeadFinder\LeadSearchService;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\View\View;

class LeadFinderController extends Controller
{
    public function __construct(
        private readonly LeadSearchService $leadSearchService,
        private readonly LeadImportService $leadImportService,
    ) {
    }

    public function index(Request $request): View
    {
        $state = $request->session()->get('lead_finder.results');

        return view('admin.lead-finder.index', [
            'search' => $state['search'] ?? [
                'city' => '',
                'category' => '',
                'country' => 'Morocco',
                'max_results' => 10,
            ],
            'results' => $state['results'] ?? [],
            'searchedAt' => $state['searched_at'] ?? null,
        ]);
    }

    public function search(StoreLeadFinderSearchRequest $request): RedirectResponse
    {
        try {
            $search = $request->validated();
            $results = $this->leadSearchService->find($search);

            $request->session()->put('lead_finder.results', [
                'search' => $search,
                'results' => $results,
                'searched_at' => now()->toDateTimeString(),
            ]);

            return redirect()->route('admin.lead-finder.index', [$request->route('locale')])
                ->with('status', count($results).' leads found and scored for review.');
        } catch (\Throwable $exception) {
            report($exception);

            return back()
                ->withInput()
                ->withErrors(['lead_finder' => $exception->getMessage() ?: 'Lead finder search failed. Please try again.']);
        }
    }

    public function import(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'selected' => ['nullable', 'array'],
            'selected.*' => ['string'],
            'mark_hot' => ['nullable', 'boolean'],
            'scope' => ['nullable', 'in:selected,all'],
        ]);

        $state = $request->session()->get('lead_finder.results');
        if (! $state || empty($state['results'])) {
            return back()->withErrors(['lead_finder' => 'No lead finder results are available to import.']);
        }

        $selected = collect($validated['selected'] ?? []);
        $results = collect($state['results']);
        $scope = $validated['scope'] ?? 'selected';

        if ($scope === 'selected' && $selected->isEmpty()) {
            return back()->withErrors(['lead_finder' => 'Select at least one lead before importing selected results.']);
        }

        $candidates = $scope === 'all'
            ? $results
            : $results->filter(fn (array $candidate): bool => $selected->contains($candidate['fingerprint'] ?? ''));

        $summary = $this->leadImportService->import($candidates->values()->all(), $request->boolean('mark_hot'));
        $importedFingerprints = $candidates->map(fn (array $candidate) => $candidate['fingerprint'] ?? null)->filter()->all();

        $request->session()->put('lead_finder.results', [
            'search' => $state['search'],
            'searched_at' => $state['searched_at'],
            'results' => $results->map(function (array $candidate) use ($importedFingerprints): array {
                if (in_array($candidate['fingerprint'] ?? null, $importedFingerprints, true)) {
                    $candidate['imported'] = true;
                }

                return $candidate;
            })->all(),
        ]);

        return redirect()->route('admin.lead-finder.index', [$request->route('locale')])
            ->with('status', "{$summary['imported']} leads imported, {$summary['duplicates']} duplicates skipped.");
    }
}
