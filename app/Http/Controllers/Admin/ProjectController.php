<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Project;
use App\Models\Tag;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use Illuminate\View\View;

class ProjectController extends Controller
{
    public function index(): View
    {
        $projects = Project::with(['category', 'tags', 'screenshots', 'files'])->orderByDesc('created_at')->paginate(20);

        return view('admin.projects.index', compact('projects'));
    }

    public function create(): View
    {
        return view('admin.projects.form', [
            'project' => new Project(['status' => 'draft', 'featured' => false]),
            'categories' => Category::where('type', 'project')->pluck('name', 'id'),
            'tags' => Tag::where('type', 'project')->pluck('name', 'id'),
        ]);
    }

    public function edit(Project $project): View
    {
        $project->load(['tags', 'screenshots', 'files', 'tasks']);

        return view('admin.projects.form', [
            'project' => $project,
            'categories' => Category::where('type', 'project')->pluck('name', 'id'),
            'tags' => Tag::where('type', 'project')->pluck('name', 'id'),
        ]);
    }

    public function update(Request $request, Project $project): RedirectResponse
    {
        $data = $this->validated($request, $project->id);
        $data = $this->handleHeroImage($request, $data, $project);
        $project->update($data);
        $project->tags()->sync($request->input('tag_ids', []));
        $this->syncScreenshots($request, $project);
        $this->storeProjectFiles($request, $project);

        return redirect()->route('admin.projects.edit', [$request->route('locale'), $project])->with('status', 'Project updated');
    }

    public function destroy(Request $request, Project $project): RedirectResponse
    {
        foreach ($project->screenshots as $screenshot) {
            if ($screenshot->image_path) {
                Storage::disk('public')->delete($screenshot->image_path);
            }
        }

        foreach ($project->files as $file) {
            Storage::disk('public')->delete($file->file_path);
        }

        $project->delete();

        return redirect()->route('admin.projects.index', [$request->route('locale')])->with('status', 'Project removed');
    }

    private function validated(Request $request, ?int $id = null): array
    {
        return $request->validate([
            'title' => ['required', 'string', 'max:180'],
            'slug' => ['required', 'string', 'max:180', 'unique:projects,slug,'.($id ?: 'NULL').',id'],
            'excerpt' => ['nullable', 'string', 'max:400'],
            'description' => ['nullable', 'string'],
            'status' => ['required', 'in:draft,published'],
            'featured' => ['boolean'],
            'live_url' => ['nullable', 'url'],
            'repo_url' => ['nullable', 'url'],
            'hero_image' => ['nullable', 'string', 'max:255'],
            'hero_image_file' => ['nullable', 'image', 'max:5120'],
            'category_id' => ['nullable', 'exists:categories,id'],
            'published_at' => ['nullable', 'date'],
            'stack' => ['nullable', 'array'],
            'stack.*' => ['string', 'max:60'],
            'screenshot_urls' => ['nullable', 'string'],
            'screenshot_files.*' => ['nullable', 'image', 'max:5120'],
            'project_files.*' => ['nullable', 'file', 'max:10240'],
            'translations' => ['nullable', 'array'],
            'translations.*.title' => ['nullable', 'string', 'max:180'],
            'translations.*.excerpt' => ['nullable', 'string', 'max:400'],
            'translations.*.description' => ['nullable', 'string'],
            'meta' => ['nullable', 'array'],
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validated($request);
        $data = $this->handleHeroImage($request, $data);
        $project = Project::create($data);
        $project->tags()->sync($request->input('tag_ids', []));
        $this->syncScreenshots($request, $project);
        $this->storeProjectFiles($request, $project);

        return redirect()->route('admin.projects.edit', [$request->route('locale'), $project])->with('status', 'Project created');
    }

    private function handleHeroImage(Request $request, array $data, ?Project $project = null): array
    {
        if ($request->hasFile('hero_image_file')) {
            if ($project?->hero_image) {
                Storage::disk('public')->delete($project->hero_image);
            }

            $data['hero_image'] = $request->file('hero_image_file')->store('projects/hero', 'public');
        }

        return $data;
    }

    private function syncScreenshots(Request $request, Project $project): void
    {
        foreach ($project->screenshots as $screenshot) {
            if ($screenshot->image_path) {
                Storage::disk('public')->delete($screenshot->image_path);
            }
        }
        $project->screenshots()->delete();

        $sortOrder = 0;
        foreach (preg_split('/\r\n|\r|\n/', (string) $request->input('screenshot_urls')) as $url) {
            $trimmed = trim($url);
            if ($trimmed === '') {
                continue;
            }

            $project->screenshots()->create([
                'image_url' => $trimmed,
                'caption' => null,
                'sort_order' => $sortOrder++,
            ]);
        }

        foreach ($request->file('screenshot_files', []) as $file) {
            $path = $file->store('projects/screenshots', 'public');

            $project->screenshots()->create([
                'image_path' => $path,
                'caption' => pathinfo($file->getClientOriginalName(), PATHINFO_FILENAME),
                'sort_order' => $sortOrder++,
            ]);
        }
    }

    private function storeProjectFiles(Request $request, Project $project): void
    {
        foreach ($request->file('project_files', []) as $file) {
            $path = $file->store('projects/files', 'public');

            $project->files()->create([
                'name' => Str::limit($file->getClientOriginalName(), 180, ''),
                'file_path' => $path,
                'mime_type' => $file->getMimeType(),
                'size' => $file->getSize(),
            ]);
        }
    }
}
