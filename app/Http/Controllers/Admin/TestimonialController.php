<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Testimonial;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class TestimonialController extends Controller
{
    public function index(): View
    {
        $testimonials = Testimonial::query()
            ->orderBy('position')
            ->orderByDesc('featured')
            ->paginate(20);

        return view('admin.testimonials.index', compact('testimonials'));
    }

    public function create(): View
    {
        return view('admin.testimonials.form', [
            'testimonial' => new Testimonial([
                'status' => 'draft',
                'featured' => false,
                'position' => 1,
            ]),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->prepareData($request, $this->validated($request));
        $data = $this->handleImage($request, $data);
        $testimonial = Testimonial::create($data);

        return redirect()->route('admin.testimonials.edit', [$request->route('locale'), $testimonial])
            ->with('status', 'Testimonial created');
    }

    public function edit(Testimonial $testimonial): View
    {
        return view('admin.testimonials.form', compact('testimonial'));
    }

    public function update(Request $request, Testimonial $testimonial): RedirectResponse
    {
        $data = $this->prepareData($request, $this->validated($request));
        $data = $this->handleImage($request, $data, $testimonial);
        $testimonial->update($data);

        return redirect()->route('admin.testimonials.edit', [$request->route('locale'), $testimonial])
            ->with('status', 'Testimonial updated');
    }

    public function destroy(Request $request, Testimonial $testimonial): RedirectResponse
    {
        $this->deleteMedia($testimonial->image);
        $testimonial->delete();

        return redirect()->route('admin.testimonials.index', [$request->route('locale')])
            ->with('status', 'Testimonial deleted');
    }

    private function validated(Request $request): array
    {
        return $request->validate([
            'client_name' => ['required', 'string', 'max:160'],
            'client_company' => ['nullable', 'string', 'max:160'],
            'client_title' => ['nullable', 'string', 'max:160'],
            'location' => ['nullable', 'string', 'max:160'],
            'quote' => ['required', 'string', 'max:2000'],
            'avatar_path' => ['nullable', 'string', 'max:255'],
            'image_file' => ['nullable', 'image', 'max:5120'],
            'status' => ['required', 'in:draft,published'],
            'is_featured' => ['boolean'],
            'published' => ['boolean'],
            'position' => ['nullable', 'integer', 'min:1'],
            'published_at' => ['nullable', 'date'],
            'meta' => ['nullable', 'array'],
        ]);
    }

    private function prepareData(Request $request, array $data): array
    {
        $data['name'] = $data['client_name'];
        $data['company'] = $data['client_company'] ?? null;
        $data['role'] = $data['client_title'] ?? null;
        $data['featured'] = $request->boolean('is_featured');
        $data['is_featured'] = $request->boolean('is_featured');
        $data['published'] = $request->boolean('published');

        if ($data['published'] && empty($data['published_at'])) {
            $data['published_at'] = now();
        }

        if (($data['status'] ?? 'draft') === 'published' && empty($data['published_at'])) {
            $data['published_at'] = now();
        }

        return $data;
    }

    private function handleImage(Request $request, array $data, ?Testimonial $testimonial = null): array
    {
        if ($request->hasFile('image_file')) {
            $this->deleteMedia($testimonial?->display_avatar);
            $storedPath = $request->file('image_file')->store('testimonials', 'public');
            $data['image'] = $storedPath;
            $data['avatar_path'] = $storedPath;
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
