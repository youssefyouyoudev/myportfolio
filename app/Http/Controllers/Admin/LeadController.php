<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lead;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class LeadController extends Controller
{
    public function index(): View
    {
        $leads = Lead::orderByDesc('created_at')->paginate(30);

        return view('admin.leads.index', compact('leads'));
    }

    public function show(Lead $lead): View
    {
        return view('admin.leads.show', compact('lead'));
    }

    public function destroy(Request $request, Lead $lead): RedirectResponse
    {
        $lead->delete();

        return redirect()->route('admin.leads.index', [$request->route('locale')])->with('status', 'Lead deleted');
    }
}
