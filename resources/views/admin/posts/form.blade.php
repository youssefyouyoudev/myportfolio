@extends('layouts.admin')

@section('title', $post->exists ? 'Edit Blog Post' : 'New Blog Post')
@section('admin_title', $post->exists ? 'Edit Blog Post' : 'Create Blog Post')
@section('admin_copy', 'Manage editorial content, featured insights, publishing status, cover media, and SEO fields from one place.')

@section('content')
    @php
        $selectedTags = collect(old('tag_ids', $post->tags->pluck('id')->all()));
        $meta = old('meta', $post->meta ?? []);
    @endphp

    <form
        method="post"
        enctype="multipart/form-data"
        action="{{ $post->exists ? route('admin.posts.update', [app()->getLocale(), $post]) : route('admin.posts.store', app()->getLocale()) }}"
        class="admin-form"
    >
        @csrf
        @if($post->exists)
            @method('PUT')
        @endif

        <section class="panel admin-form-section">
            <div>
                <span class="eyebrow">Core details</span>
                <h2>Headline, slug, excerpt, and editorial body</h2>
            </div>

            <div class="admin-form-grid">
                <label class="admin-field">
                    <span>Title</span>
                    <input class="input-ghost" type="text" name="title" value="{{ old('title', $post->title) }}" required>
                    @error('title') <small class="admin-field-error">{{ $message }}</small> @enderror
                </label>

                <label class="admin-field">
                    <span>Slug</span>
                    <input class="input-ghost" type="text" name="slug" value="{{ old('slug', $post->slug) }}" required>
                    <small class="admin-field-help">Used for the public article URL.</small>
                    @error('slug') <small class="admin-field-error">{{ $message }}</small> @enderror
                </label>
            </div>

            <label class="admin-field">
                <span>Excerpt</span>
                <textarea class="input-ghost" name="excerpt" rows="3">{{ old('excerpt', $post->excerpt) }}</textarea>
                <small class="admin-field-help">Short summary used on the blog listing and SEO snippets.</small>
                @error('excerpt') <small class="admin-field-error">{{ $message }}</small> @enderror
            </label>

            <label class="admin-field">
                <span>Body</span>
                <textarea class="input-ghost" name="body" rows="14" required>{{ old('body', $post->body) }}</textarea>
                <small class="admin-field-help">Use blank lines to separate sections naturally on the public article page.</small>
                @error('body') <small class="admin-field-error">{{ $message }}</small> @enderror
            </label>
        </section>

        <section class="panel admin-form-section">
            <div>
                <span class="eyebrow">Publishing</span>
                <h2>Status, featuring, taxonomy, and publication date</h2>
            </div>

            <div class="admin-form-grid three">
                <label class="admin-field">
                    <span>Status</span>
                    <select class="input-ghost" name="status">
                        <option value="draft" @selected(old('status', $post->status) === 'draft')>Draft</option>
                        <option value="published" @selected(old('status', $post->status) === 'published')>Published</option>
                    </select>
                    @error('status') <small class="admin-field-error">{{ $message }}</small> @enderror
                </label>

                <label class="admin-field">
                    <span>Category</span>
                    <select class="input-ghost" name="category_id">
                        <option value="">No category</option>
                        @foreach($categories as $id => $name)
                            <option value="{{ $id }}" @selected(old('category_id', $post->category_id) == $id)>{{ $name }}</option>
                        @endforeach
                    </select>
                    @error('category_id') <small class="admin-field-error">{{ $message }}</small> @enderror
                </label>

                <label class="admin-field">
                    <span>Published at</span>
                    <input class="input-ghost" type="datetime-local" name="published_at" value="{{ old('published_at', optional($post->published_at)->format('Y-m-d\TH:i')) }}">
                    @error('published_at') <small class="admin-field-error">{{ $message }}</small> @enderror
                </label>
            </div>

            <label class="admin-check">
                <input type="checkbox" name="featured" value="1" @checked(old('featured', $post->featured))>
                <span>Feature this post in priority placements where the public site supports featured content.</span>
            </label>

            <label class="admin-field">
                <span>Tags</span>
                <select class="input-ghost" name="tag_ids[]" multiple size="6">
                    @foreach($tags as $id => $name)
                        <option value="{{ $id }}" @selected($selectedTags->contains($id))>{{ $name }}</option>
                    @endforeach
                </select>
                <small class="admin-field-help">Use tags to organize topic clusters and future filtering.</small>
            </label>
        </section>

        <section class="panel admin-form-section">
            <div>
                <span class="eyebrow">Media</span>
                <h2>Cover image for article previews and social sharing</h2>
            </div>

            <div class="admin-form-grid">
                <label class="admin-field">
                    <span>Cover image path or URL</span>
                    <input class="input-ghost" type="text" name="cover_image" value="{{ old('cover_image', $post->cover_image) }}">
                    <small class="admin-field-help">Accepts a public URL or a stored path.</small>
                    @error('cover_image') <small class="admin-field-error">{{ $message }}</small> @enderror
                </label>

                <label class="admin-field">
                    <span>Upload cover image</span>
                    <input class="input-ghost" type="file" name="cover_image_file" accept="image/*">
                    <small class="admin-field-help">Recommended for listing cards and social previews.</small>
                    @error('cover_image_file') <small class="admin-field-error">{{ $message }}</small> @enderror
                </label>
            </div>

            @if(old('cover_image', $post->cover_image))
                <div class="admin-media-preview">
                    <img src="{{ \App\Support\ContentMapper::mediaUrl(old('cover_image', $post->cover_image)) }}" alt="{{ old('title', $post->title) }}">
                </div>
            @endif
        </section>

        <section class="panel admin-form-section">
            <div>
                <span class="eyebrow">SEO</span>
                <h2>Search title, description, keywords, and social image</h2>
            </div>

            <div class="admin-form-grid">
                <label class="admin-field">
                    <span>SEO title</span>
                    <input class="input-ghost" type="text" name="meta[seo_title]" value="{{ $meta['seo_title'] ?? '' }}">
                    @error('meta.seo_title') <small class="admin-field-error">{{ $message }}</small> @enderror
                </label>

                <label class="admin-field">
                    <span>SEO keywords</span>
                    <input class="input-ghost" type="text" name="meta[seo_keywords]" value="{{ $meta['seo_keywords'] ?? '' }}">
                    @error('meta.seo_keywords') <small class="admin-field-error">{{ $message }}</small> @enderror
                </label>
            </div>

            <label class="admin-field">
                <span>SEO description</span>
                <textarea class="input-ghost" name="meta[seo_description]" rows="3">{{ $meta['seo_description'] ?? '' }}</textarea>
                @error('meta.seo_description') <small class="admin-field-error">{{ $message }}</small> @enderror
            </label>

            <label class="admin-field">
                <span>SEO image</span>
                <input class="input-ghost" type="text" name="meta[seo_image]" value="{{ $meta['seo_image'] ?? '' }}">
                <small class="admin-field-help">Optional override for Open Graph and Twitter cards.</small>
                @error('meta.seo_image') <small class="admin-field-error">{{ $message }}</small> @enderror
            </label>
        </section>

        <div class="admin-toolbar-actions">
            <button class="btn btn-primary" type="submit">{{ $post->exists ? 'Update post' : 'Create post' }}</button>
            <a class="btn btn-secondary" href="{{ route('admin.posts.index', app()->getLocale()) }}">Back to posts</a>
        </div>
    </form>
@endsection
