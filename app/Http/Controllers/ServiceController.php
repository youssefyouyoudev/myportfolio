<?php

namespace App\Http\Controllers;

use App\Support\BrandContent;
use Illuminate\View\View;

class ServiceController extends Controller
{
    public function index(): View
    {
        $locale = app()->getLocale();
        $page = BrandContent::servicesIndex($locale);

        return view('pages.services.index', [
            'page' => $page,
            'seo' => array_merge($page['seo'], [
                'schema' => [BrandContent::personSchema($locale)],
            ]),
        ]);
    }

    public function show(string $service): View
    {
        $locale = app()->getLocale();
        $page = BrandContent::service($locale, $service);
        abort_unless($page, 404);

        return view('pages.services.show', [
            'page' => $page,
            'seo' => array_merge($page['seo'], [
                'schema' => [
                    BrandContent::personSchema($locale),
                    BrandContent::serviceSchema($page, route('services.show', ['locale' => $locale, 'service' => $service])),
                ],
            ]),
        ]);
    }
}
