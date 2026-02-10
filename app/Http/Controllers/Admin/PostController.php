<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Post;
use App\Models\Tag;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class PostController extends Controller
{
    public function index(): View
    {
        $posts = Post::with(['category', 'tags'])->orderByDesc('created_at')->paginate(20);

        return view('admin.posts.index', compact('posts'));
    }

    public function create(): View
    {
        return view('admin.posts.form', [
            'post' => new Post(['status' => 'draft']),
            'categories' => Category::where('type', 'post')->pluck('name', 'id'),
            'tags' => Tag::where('type', 'post')->pluck('name', 'id'),
        ]);
    }

    public function store(Request $request): RedirectResponse
    {
        $data = $this->validated($request);
        $post = Post::create($data);
        $post->tags()->sync($request->input('tag_ids', []));

        return redirect()->route('admin.posts.edit', [$request->route('locale'), $post])->with('status', 'Post created');
    }

    public function edit(Post $post): View
    {
        $post->load('tags');

        return view('admin.posts.form', [
            'post' => $post,
            'categories' => Category::where('type', 'post')->pluck('name', 'id'),
            'tags' => Tag::where('type', 'post')->pluck('name', 'id'),
        ]);
    }

    public function update(Request $request, Post $post): RedirectResponse
    {
        $data = $this->validated($request, $post->id);
        $post->update($data);
        $post->tags()->sync($request->input('tag_ids', []));

        return redirect()->route('admin.posts.edit', [$request->route('locale'), $post])->with('status', 'Post updated');
    }

    public function destroy(Request $request, Post $post): RedirectResponse
    {
        $post->delete();

        return redirect()->route('admin.posts.index', [$request->route('locale')])->with('status', 'Post removed');
    }

    private function validated(Request $request, ?int $id = null): array
    {
        return $request->validate([
            'title' => ['required', 'string', 'max:180'],
            'slug' => ['required', 'string', 'max:180', 'unique:posts,slug,'.($id ?: 'NULL').',id'],
            'excerpt' => ['nullable', 'string', 'max:400'],
            'body' => ['required', 'string'],
            'status' => ['required', 'in:draft,published'],
            'cover_image' => ['nullable', 'string', 'max:255'],
            'category_id' => ['nullable', 'exists:categories,id'],
            'published_at' => ['nullable', 'date'],
            'translations' => ['nullable', 'array'],
            'translations.*.title' => ['nullable', 'string', 'max:180'],
            'translations.*.excerpt' => ['nullable', 'string', 'max:400'],
            'translations.*.body' => ['nullable', 'string'],
            'meta' => ['nullable', 'array'],
        ]);
    }
}
