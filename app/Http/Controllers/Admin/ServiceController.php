<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Service;
use App\Models\Tag;
use App\Support\ContentMapper;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
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
        $data = $this->prepareData($request, $this->validated($request));
        $data = $this->handleFeaturedImage($request, $data);
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
        $data = $this->prepareData($request, $this->validated($request, $service->id));
        $data = $this->handleFeaturedImage($request, $data, $service);
        $service->update($data);
        $service->tags()->sync($request->input('tag_ids', []));

        return redirect()->route('admin.services.edit', [$request->route('locale'), $service])->with('status', 'Service updated');
    }

    public function destroy(Request $request, Service $service): RedirectResponse
    {
        $this->deleteMedia($service->featured_image);
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
            'featured' => ['boolean'],
            'featured_image' => ['nullable', 'string', 'max:255'],
            'featured_image_file' => ['nullable', 'image', 'max:5120'],
            'cta_url' => ['nullable', 'url'],
            'price_from' => ['nullable', 'numeric', 'min:0'],
            'position' => ['nullable', 'integer', 'min:1'],
            'category_id' => ['nullable', 'exists:categories,id'],
            'published_at' => ['nullable', 'date'],
            'features_text' => ['nullable', 'string'],
            'translations' => ['nullable', 'array'],
            'translations.*.title' => ['nullable', 'string', 'max:180'],
            'translations.*.excerpt' => ['nullable', 'string', 'max:400'],
            'translations.*.body' => ['nullable', 'string'],
            'meta' => ['nullable', 'array'],
            'meta.who' => ['nullable', 'string'],
            'meta.business_value' => ['nullable', 'string'],
            'meta.stack_text' => ['nullable', 'string'],
            'meta.deliverables_text' => ['nullable', 'string'],
            'meta.process_text' => ['nullable', 'string'],
        ]);
    }

    private function handleFeaturedImage(Request $request, array $data, ?Service $service = null): array
    {
        if ($request->hasFile('featured_image_file')) {
            $this->deleteMedia($service?->featured_image);
            $data['featured_image'] = $request->file('featured_image_file')->store('services/featured', 'public');
        }

        return $data;
    }

    private function prepareData(Request $request, array $data): array
    {
        $meta = $data['meta'] ?? [];
        $meta['stack'] = ContentMapper::stringList($meta['stack_text'] ?? []);
        $meta['deliverables'] = ContentMapper::stringList($meta['deliverables_text'] ?? []);
        $meta['process'] = ContentMapper::stringList($meta['process_text'] ?? []);
        unset($meta['stack_text'], $meta['deliverables_text'], $meta['process_text']);

        $data['meta'] = $meta;
        $data['features'] = ContentMapper::stringList($request->input('features_text'));
        $data['featured'] = $request->boolean('featured');

        if (($data['status'] ?? 'draft') === 'published' && empty($data['published_at'])) {
            $data['published_at'] = now();
        }

        return $data;
    }

    private function deleteMedia(?string $path): void
    {
        if (! $path || Str::startsWith($path, ['http://', 'https://', '/storage/', 'storage/'])) {
            return;
        }

        Storage::disk('public')->delete($path);
    }
}
