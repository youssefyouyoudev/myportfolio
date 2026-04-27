<?php

namespace App\Http\Controllers;

use App\Models\Service;
use App\Support\BrandContent;
use App\Support\ContentMapper;
use Illuminate\View\View;

class ServiceController extends Controller
{
    public function index(): View
    {
        $locale = app()->getLocale();
        $page = BrandContent::servicesIndex($locale);
        $services = Service::published()
            ->orderByDesc('featured')
            ->orderBy('position')
            ->latest('published_at')
            ->get();

        if ($services->isNotEmpty()) {
            $page['items'] = $services->map(fn (Service $service): array => ContentMapper::serviceCard($service, $locale))->all();
        }

        return view('pages.services.index', [
            'page' => $page,
            'seo' => BrandContent::buildSeo(
                $locale,
                $page['seo'],
                [BrandContent::personSchema($locale)],
                $page['items'][0]['featured_image'] ?? asset('images/youyou-portrait.png'),
                [
                    ['name' => 'Home', 'url' => route('home', ['locale' => $locale])],
                    ['name' => 'Services', 'url' => route('services.index', ['locale' => $locale])],
                ]
            ),
        ]);
    }

    public function show(string $service): View
    {
        $locale = app()->getLocale();
        $record = Service::published()->where('slug', $service)->first();
        $page = $record ? ContentMapper::serviceCard($record, $locale) : BrandContent::service($locale, $service);
        abort_unless($page, 404);

        return view('pages.services.show', [
            'page' => $page,
            'seo' => BrandContent::buildSeo(
                $locale,
                $page['seo'],
                [
                    BrandContent::personSchema($locale),
                    BrandContent::serviceSchema($page, route('services.show', ['locale' => $locale, 'service' => $service])),
                ],
                $page['featured_image'] ?? asset('images/youyou-portrait.png'),
                [
                    ['name' => 'Home', 'url' => route('home', ['locale' => $locale])],
                    ['name' => 'Services', 'url' => route('services.index', ['locale' => $locale])],
                    ['name' => $page['title'], 'url' => route('services.show', ['locale' => $locale, 'service' => $service])],
                ]
            ),
        ]);
    }
}
