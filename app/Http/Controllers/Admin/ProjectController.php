<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Project;
use App\Models\Tag;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class ProjectController extends Controller
{
    public function index(): View
    {
        $projects = Project::with(['category', 'tags'])->orderByDesc('created_at')->paginate(20);

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

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validated($request);
        $project = Project::create($data);
        $project->tags()->sync($request->input('tag_ids', []));

        return redirect()->route('admin.projects.edit', [$request->route('locale'), $project])->with('status', 'Project created');
    }

    public function edit(Project $project): View
    {
        $project->load('tags');

        return view('admin.projects.form', [
            'project' => $project,
            'categories' => Category::where('type', 'project')->pluck('name', 'id'),
            'tags' => Tag::where('type', 'project')->pluck('name', 'id'),
        ]);
    }

    public function update(Request $request, Project $project): RedirectResponse
    {
        $data = $this->validated($request, $project->id);
        $project->update($data);
        $project->tags()->sync($request->input('tag_ids', []));

        return redirect()->route('admin.projects.edit', [$request->route('locale'), $project])->with('status', 'Project updated');
    }

    public function destroy(Request $request, Project $project): RedirectResponse
    {
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
            'category_id' => ['nullable', 'exists:categories,id'],
            'published_at' => ['nullable', 'date'],
            'stack' => ['nullable', 'array'],
            'stack.*' => ['string', 'max:60'],
            'translations' => ['nullable', 'array'],
            'translations.*.title' => ['nullable', 'string', 'max:180'],
            'translations.*.excerpt' => ['nullable', 'string', 'max:400'],
            'translations.*.description' => ['nullable', 'string'],
            'meta' => ['nullable', 'array'],
        ]);
    }
}
