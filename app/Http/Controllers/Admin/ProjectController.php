<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Project;
use App\Models\Tag;
use App\Support\ContentMapper;
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
        $data = $this->prepareData($request, $this->validated($request, $project->id));
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
                $this->deleteMedia($screenshot->image_path);
            }
        }

        foreach ($project->files as $file) {
            $this->deleteMedia($file->file_path);
        }

        $this->deleteMedia($project->hero_image);

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
            'client_name' => ['nullable', 'string', 'max:180'],
            'client_industry' => ['nullable', 'string', 'max:180'],
            'result_headline' => ['nullable', 'string', 'max:255'],
            'is_concept' => ['boolean'],
            'is_nda' => ['boolean'],
            'built_at' => ['nullable', 'date'],
            'screenshot_path' => ['nullable', 'string', 'max:255'],
            'screenshot_webp_path' => ['nullable', 'string', 'max:255'],
            'context' => ['nullable', 'string'],
            'problem_long' => ['nullable', 'string'],
            'solution_long' => ['nullable', 'string'],
            'outcome_long' => ['nullable', 'string'],
            'result_1_label' => ['nullable', 'string', 'max:80'],
            'result_1_value' => ['nullable', 'string', 'max:120'],
            'result_2_label' => ['nullable', 'string', 'max:80'],
            'result_2_value' => ['nullable', 'string', 'max:120'],
            'result_3_label' => ['nullable', 'string', 'max:80'],
            'result_3_value' => ['nullable', 'string', 'max:120'],
            'metric_one_label' => ['nullable', 'string', 'max:80'],
            'metric_one_value' => ['nullable', 'string', 'max:120'],
            'metric_two_label' => ['nullable', 'string', 'max:80'],
            'metric_two_value' => ['nullable', 'string', 'max:120'],
            'metric_three_label' => ['nullable', 'string', 'max:80'],
            'metric_three_value' => ['nullable', 'string', 'max:120'],
            'repo_url' => ['nullable', 'url'],
            'hero_image' => ['nullable', 'string', 'max:255'],
            'hero_image_file' => ['nullable', 'image', 'max:5120'],
            'stack_text' => ['nullable', 'string'],
            'category_id' => ['nullable', 'exists:categories,id'],
            'published_at' => ['nullable', 'date'],
            'screenshot_urls' => ['nullable', 'string'],
            'screenshot_files.*' => ['nullable', 'image', 'max:5120'],
            'project_files.*' => ['nullable', 'file', 'max:10240'],
            'translations' => ['nullable', 'array'],
            'translations.*.title' => ['nullable', 'string', 'max:180'],
            'translations.*.excerpt' => ['nullable', 'string', 'max:400'],
            'translations.*.description' => ['nullable', 'string'],
            'meta' => ['nullable', 'array'],
            'meta.label' => ['nullable', 'string', 'max:120'],
            'meta.client' => ['nullable', 'string', 'max:180'],
            'meta.audience' => ['nullable', 'string', 'max:255'],
            'meta.challenge' => ['nullable', 'string'],
            'meta.solution' => ['nullable', 'string'],
            'meta.role' => ['nullable', 'string'],
            'meta.outcome' => ['nullable', 'string'],
            'meta.note' => ['nullable', 'string'],
            'meta.theme' => ['nullable', 'string', 'max:80'],
            'meta.logo_image' => ['nullable', 'string', 'max:255'],
            'meta.logo_alt' => ['nullable', 'string', 'max:180'],
            'meta.cover_alt' => ['nullable', 'string', 'max:180'],
            'meta.seo_title' => ['nullable', 'string', 'max:180'],
            'meta.seo_description' => ['nullable', 'string', 'max:320'],
            'meta.seo_keywords' => ['nullable', 'string', 'max:255'],
            'meta.seo_image' => ['nullable', 'string', 'max:255'],
            'meta.features_text' => ['nullable', 'string'],
            'meta.metrics_text' => ['nullable', 'string'],
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->prepareData($request, $this->validated($request));
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
            $this->deleteMedia($project?->hero_image);

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

    private function prepareData(Request $request, array $data): array
    {
        $meta = $data['meta'] ?? [];
        $meta['features'] = ContentMapper::stringList($meta['features_text'] ?? []);
        $meta['metrics'] = ContentMapper::metricList($meta['metrics_text'] ?? []);
        unset($meta['features_text'], $meta['metrics_text']);

        $data['stack'] = ContentMapper::stringList($request->input('stack_text'));
        $data['meta'] = $meta;
        $data['featured'] = $request->boolean('featured');
        $data['is_concept'] = $request->boolean('is_concept');
        $data['is_nda'] = $request->boolean('is_nda');

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
