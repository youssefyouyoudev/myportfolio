<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tag;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class TagController extends Controller
{
    public function index(): View
    {
        $tags = Tag::orderBy('type')->orderBy('name')->paginate(30);

        return view('admin.tags.index', compact('tags'));
    }

    public function create(): View
    {
        return view('admin.tags.form', ['tag' => new Tag()]);
    }

    public function store(Request $request): RedirectResponse
    {
        $tag = Tag::create($this->validated($request));

        return redirect()->route('admin.tags.edit', [$request->route('locale'), $tag])->with('status', 'Tag created');
    }

    public function edit(Tag $tag): View
    {
        return view('admin.tags.form', compact('tag'));
    }

    public function update(Request $request, Tag $tag): RedirectResponse
    {
        $tag->update($this->validated($request, $tag->id));

        return redirect()->route('admin.tags.edit', [$request->route('locale'), $tag])->with('status', 'Tag updated');
    }

    public function destroy(Request $request, Tag $tag): RedirectResponse
    {
        $tag->delete();

        return redirect()->route('admin.tags.index', [$request->route('locale')])->with('status', 'Tag removed');
    }

    private function validated(Request $request, ?int $id = null): array
    {
        return $request->validate([
            'name' => ['required', 'string', 'max:120'],
            'slug' => ['required', 'string', 'max:140', 'unique:tags,slug,'.($id ?: 'NULL').',id'],
            'type' => ['required', 'in:project,post,service'],
            'translations' => ['nullable', 'array'],
            'translations.*.name' => ['nullable', 'string', 'max:120'],
        ]);
    }
}
