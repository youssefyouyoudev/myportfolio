<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Http\Requests\StoreCrmLeadRequest;
use App\Models\CrmLead;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class LeadController extends Controller
{
    public function index(Request $request): View
    {
        $filters = [
            'status' => (string) $request->query('status', ''),
            'review_status' => (string) $request->query('review_status', ''),
            'city' => (string) $request->query('city', ''),
            'category' => (string) $request->query('category', ''),
            'search' => trim((string) $request->query('search', '')),
        ];

        $leads = CrmLead::query()
            ->status($filters['status'])
            ->reviewStatus($filters['review_status'])
            ->when(filled($filters['city']), fn ($query) => $query->where('city', $filters['city']))
            ->when(filled($filters['category']), fn ($query) => $query->where('category', $filters['category']))
            ->search($filters['search'])
            ->latest('updated_at')
            ->paginate(20)
            ->withQueryString();

        return view('admin.leads.index', [
            'leads' => $leads,
            'filters' => $filters,
            'statuses' => CrmLead::statuses(),
            'reviewStatuses' => CrmLead::reviewStatuses(),
            'cities' => CrmLead::query()->whereNotNull('city')->where('city', '!=', '')->distinct()->orderBy('city')->pluck('city'),
            'categories' => CrmLead::query()->whereNotNull('category')->where('category', '!=', '')->distinct()->orderBy('category')->pluck('category'),
            'stats' => [
                'total' => CrmLead::count(),
                'found_today' => CrmLead::query()->whereDate('found_at', today())->count(),
                'hot' => CrmLead::where('status', CrmLead::STATUS_HOT)->count(),
                'contacted' => CrmLead::where('status', CrmLead::STATUS_CONTACTED)->count(),
                'closed' => CrmLead::where('status', CrmLead::STATUS_CLOSED)->count(),
                'replies' => (int) CrmLead::sum('reply_count'),
                'estimated_revenue' => (float) CrmLead::where('review_status', '!=', CrmLead::REVIEW_REJECTED)->sum('estimated_revenue'),
            ],
        ]);
    }

    public function create(): View
    {
        return view('admin.leads.form', [
            'lead' => new CrmLead([
                'status' => CrmLead::STATUS_NEW,
                'review_status' => CrmLead::REVIEW_APPROVED,
                'source_type' => 'manual',
            ]),
            'statuses' => CrmLead::statuses(),
        ]);
    }

    public function store(StoreCrmLeadRequest $request): RedirectResponse
    {
        $lead = CrmLead::create(array_merge($request->validated(), [
            'review_status' => CrmLead::REVIEW_APPROVED,
            'source_type' => 'manual',
        ]));

        return redirect()->route('admin.leads.show', [$request->route('locale'), $lead])
            ->with('status', 'Lead created');
    }

    public function show(CrmLead $lead): View
    {
        return view('admin.leads.show', [
            'lead' => $lead,
            'statuses' => CrmLead::statuses(),
            'reviewStatuses' => CrmLead::reviewStatuses(),
        ]);
    }

    public function edit(CrmLead $lead): View
    {
        return view('admin.leads.form', [
            'lead' => $lead,
            'statuses' => CrmLead::statuses(),
        ]);
    }

    public function update(StoreCrmLeadRequest $request, CrmLead $lead): RedirectResponse
    {
        $lead->update($request->validated());

        return redirect()->route('admin.leads.show', [$request->route('locale'), $lead])
            ->with('status', 'Lead updated');
    }

    public function destroy(Request $request, CrmLead $lead): RedirectResponse
    {
        $lead->delete();

        return redirect()->route('admin.leads.index', [$request->route('locale')])
            ->with('status', 'Lead deleted');
    }

    public function review(Request $request, CrmLead $lead): RedirectResponse
    {
        $validated = $request->validate([
            'review_status' => ['required', 'in:pending,approved,rejected'],
        ]);

        $lead->update(['review_status' => $validated['review_status']]);

        return back()->with('status', 'Lead review status updated');
    }

    public function markHot(CrmLead $lead): RedirectResponse
    {
        $lead->update([
            'status' => CrmLead::STATUS_HOT,
            'review_status' => CrmLead::REVIEW_APPROVED,
        ]);

        return back()->with('status', 'Lead marked as hot');
    }
}
