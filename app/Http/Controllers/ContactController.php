<?php

namespace App\Http\Controllers;

use App\Models\Lead;
use App\Support\BrandContent;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ContactController extends Controller
{
    public function create(): View
    {
        $locale = app()->getLocale();
        $page = BrandContent::contact($locale);

        return view('pages.contact', [
            'page' => $page,
            'seo' => array_merge($page['seo'], [
                'schema' => [BrandContent::personSchema($locale)],
            ]),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'email' => ['required', 'email', 'max:150'],
            'company' => ['nullable', 'string', 'max:120'],
            'project_type' => ['nullable', 'string', 'max:80'],
            'budget' => ['nullable', 'string', 'max:60'],
            'timeline' => ['nullable', 'string', 'max:80'],
            'message' => ['required', 'string', 'max:2000'],
        ]);

        Lead::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'company' => $validated['company'] ?? null,
            'budget' => $validated['budget'] ?? null,
            'message' => $validated['message'],
            'locale' => app()->getLocale(),
            'source' => 'website',
            'meta' => [
                'project_type' => $validated['project_type'] ?? null,
                'timeline' => $validated['timeline'] ?? null,
                'ip' => $request->ip(),
                'user_agent' => $request->userAgent(),
                'path' => $request->path(),
            ],
        ]);

        return back()->with('status', __('messages.contact_thanks'));
    }
}
