<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\SeoMeta;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SeoMetaController extends Controller
{
    public function index(): View
    {
        $metas = SeoMeta::orderByDesc('created_at')->paginate(30);

        return view('admin.seo.index', compact('metas'));
    }

    public function create(): View
    {
        return view('admin.seo.form', ['meta' => new SeoMeta()]);
    }

    public function store(Request $request): RedirectResponse
    {
        $meta = SeoMeta::create($this->validated($request));

        return redirect()->route('admin.seo-meta.edit', [$request->route('locale'), $meta])->with('status', 'SEO meta created');
    }

    public function edit(SeoMeta $seo_metum): View
    {
        return view('admin.seo.form', ['meta' => $seo_metum]);
    }

    public function update(Request $request, SeoMeta $seo_metum): RedirectResponse
    {
        $seo_metum->update($this->validated($request));

        return redirect()->route('admin.seo-meta.edit', [$request->route('locale'), $seo_metum])->with('status', 'SEO meta updated');
    }

    public function destroy(Request $request, SeoMeta $seo_metum): RedirectResponse
    {
        $seo_metum->delete();

        return redirect()->route('admin.seo-meta.index', [$request->route('locale')])->with('status', 'SEO meta removed');
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'meta_title' => ['required', 'string', 'max:180'],
            'meta_description' => ['nullable', 'string', 'max:300'],
            'meta_image' => ['nullable', 'string', 'max:255'],
            'locale' => ['required', 'in:en,fr,ar'],
            'og_type' => ['nullable', 'string', 'max:60'],
            'schema' => ['nullable', 'array'],
            'meta' => ['nullable', 'array'],
        ]);
    }
}
