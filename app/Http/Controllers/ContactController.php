<?php

namespace App\Http\Controllers;

use App\Http\Requests\StoreLeadRequest;
use App\Models\ContactMessage;
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

        ContactMessage::create([
            'name' => $validated['name'],
            'email' => $validated['email'],
            'company' => $validated['company'] ?? null,
            'project_type' => $validated['project_type'] ?? null,
            'budget' => $validated['budget'] ?? null,
            'timeline' => $validated['timeline'] ?? null,
            'message' => $validated['message'],
            'locale' => app()->getLocale(),
            'source' => 'website',
            'ip_address' => $request->ip(),
            'user_agent' => $request->userAgent(),
            'path' => $request->path(),
        ]);

        return back()->with('status', __('messages.contact_thanks'));
    }
}
