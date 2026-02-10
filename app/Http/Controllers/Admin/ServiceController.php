<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Service;
use App\Models\Tag;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ServiceController extends Controller
{
    public function index(): View
    {
        $services = Service::with(['category', 'tags'])->orderBy('position')->paginate(20);

        return view('admin.services.index', compact('services'));
    }

    public function create(): View
    {
        return view('admin.services.form', [
            'service' => new Service(['status' => 'draft', 'position' => 1]),
            'categories' => Category::where('type', 'service')->pluck('name', 'id'),
            'tags' => Tag::where('type', 'service')->pluck('name', 'id'),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validated($request);
        $service = Service::create($data);
        $service->tags()->sync($request->input('tag_ids', []));

        return redirect()->route('admin.services.edit', [$request->route('locale'), $service])->with('status', 'Service created');
    }

    public function edit(Service $service): View
    {
        $service->load('tags');

        return view('admin.services.form', [
            'service' => $service,
            'categories' => Category::where('type', 'service')->pluck('name', 'id'),
            'tags' => Tag::where('type', 'service')->pluck('name', 'id'),
        ]);
    }

    public function update(Request $request, Service $service): RedirectResponse
    {
        $data = $this->validated($request, $service->id);
        $service->update($data);
        $service->tags()->sync($request->input('tag_ids', []));

        return redirect()->route('admin.services.edit', [$request->route('locale'), $service])->with('status', 'Service updated');
    }

    public function destroy(Request $request, Service $service): RedirectResponse
    {
        $service->delete();

        return redirect()->route('admin.services.index', [$request->route('locale')])->with('status', 'Service removed');
    }

    private function validated(Request $request, ?int $id = null): array
    {
        return $request->validate([
            'title' => ['required', 'string', 'max:180'],
            'slug' => ['required', 'string', 'max:180', 'unique:services,slug,'.($id ?: 'NULL').',id'],
            'excerpt' => ['nullable', 'string', 'max:400'],
            'body' => ['required', 'string'],
            'status' => ['required', 'in:draft,published'],
            'featured_image' => ['nullable', 'string', 'max:255'],
            'cta_url' => ['nullable', 'url'],
            'price_from' => ['nullable', 'numeric', 'min:0'],
            'position' => ['nullable', 'integer', 'min:1'],
            'category_id' => ['nullable', 'exists:categories,id'],
            'published_at' => ['nullable', 'date'],
            'features' => ['nullable', 'array'],
            'features.*' => ['string', 'max:140'],
            'translations' => ['nullable', 'array'],
            'translations.*.title' => ['nullable', 'string', 'max:180'],
            'translations.*.excerpt' => ['nullable', 'string', 'max:400'],
            'translations.*.body' => ['nullable', 'string'],
            'meta' => ['nullable', 'array'],
        ]);
    }
}
