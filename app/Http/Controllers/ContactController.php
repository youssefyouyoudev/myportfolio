<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreLeadRequest;
use App\Models\Lead;
use App\Support\BrandContent;
use Illuminate\Http\RedirectResponse;
use Illuminate\View\View;

class ContactController extends Controller
{
    public function create(): View
    {
        $locale = app()->getLocale();
        $page = BrandContent::contact($locale);

        return view('pages.contact', [
            'page' => $page,
            'seo' => BrandContent::buildSeo(
                $locale,
                $page['seo'],
                [BrandContent::personSchema($locale)],
                asset('images/youyou-portrait.png'),
                [
                    ['name' => 'Home', 'url' => route('home', ['locale' => $locale])],
                    ['name' => 'Contact', 'url' => route('contact.create', ['locale' => $locale])],
                ]
            ),
        ]);
    }

    public function store(StoreLeadRequest $request): RedirectResponse
    {
        if ($request->filled('website')) {
            return back()->with('status', __('messages.contact_thanks'));
        }

        $validated = $request->validated();

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
