@extends('layouts.admin')

@section('title', $service->exists ? 'Edit Service' : 'New Service')
@section('admin_title', $service->exists ? 'Edit Service' : 'Create Service')
@section('admin_copy', 'Define the offer clearly: what it helps with, what is included, how it is delivered, and how it should appear on the public site.')

@section('content')
    @php
        $selectedTags = collect(old('tag_ids', $service->tags->pluck('id')->all()));
        $meta = old('meta', $service->meta ?? []);
    @endphp

    <form
        method="post"
        enctype="multipart/form-data"
        action="{{ $service->exists ? route('admin.services.update', [app()->getLocale(), $service]) : route('admin.services.store', app()->getLocale()) }}"
        class="admin-form"
    >
        @csrf
        @if($service->exists)
            @method('PUT')
        @endif

        <section class="panel admin-form-section">
            <div>
                <span class="eyebrow">Core details</span>
                <h2>Title, slug, summary, and service body</h2>
            </div>

            <div class="admin-form-grid">
                <label class="admin-field">
                    <span>Title</span>
                    <input class="input-ghost" type="text" name="title" value="{{ old('title', $service->title) }}" required>
                    @error('title') <small class="admin-field-error">{{ $message }}</small> @enderror
                </label>

                <label class="admin-field">
                    <span>Slug</span>
                    <input class="input-ghost" type="text" name="slug" value="{{ old('slug', $service->slug) }}" required>
                    @error('slug') <small class="admin-field-error">{{ $message }}</small> @enderror
                </label>
            </div>

            <label class="admin-field">
                <span>Excerpt</span>
                <textarea class="input-ghost" name="excerpt" rows="3">{{ old('excerpt', $service->excerpt) }}</textarea>
                <small class="admin-field-help">Used on listing pages and service cards.</small>
                @error('excerpt') <small class="admin-field-error">{{ $message }}</small> @enderror
            </label>

            <label class="admin-field">
                <span>Body</span>
                <textarea class="input-ghost" name="body" rows="10" required>{{ old('body', $service->body) }}</textarea>
                @error('body') <small class="admin-field-error">{{ $message }}</small> @enderror
            </label>
        </section>

        <section class="panel admin-form-section">
            <div>
                <span class="eyebrow">Publishing</span>
                <h2>Status, featuring, positioning, and pricing</h2>
            </div>

            <div class="admin-form-grid three">
                <label class="admin-field">
                    <span>Status</span>
                    <select class="input-ghost" name="status">
                        <option value="draft" @selected(old('status', $service->status) === 'draft')>Draft</option>
                        <option value="published" @selected(old('status', $service->status) === 'published')>Published</option>
                    </select>
                    @error('status') <small class="admin-field-error">{{ $message }}</small> @enderror
                </label>

                <label class="admin-field">
                    <span>Category</span>
                    <select class="input-ghost" name="category_id">
                        <option value="">No category</option>
                        @foreach($categories as $id => $name)
                            <option value="{{ $id }}" @selected(old('category_id', $service->category_id) == $id)>{{ $name }}</option>
                        @endforeach
                    </select>
                    @error('category_id') <small class="admin-field-error">{{ $message }}</small> @enderror
                </label>

                <label class="admin-field">
                    <span>Published at</span>
                    <input class="input-ghost" type="datetime-local" name="published_at" value="{{ old('published_at', optional($service->published_at)->format('Y-m-d\TH:i')) }}">
                    @error('published_at') <small class="admin-field-error">{{ $message }}</small> @enderror
                </label>
            </div>

            <div class="admin-form-grid three">
                <label class="admin-field">
                    <span>Price from</span>
                    <input class="input-ghost" type="number" step="0.01" min="0" name="price_from" value="{{ old('price_from', $service->price_from) }}">
                    @error('price_from') <small class="admin-field-error">{{ $message }}</small> @enderror
                </label>

                <label class="admin-field">
                    <span>Position</span>
                    <input class="input-ghost" type="number" min="1" name="position" value="{{ old('position', $service->position ?: 1) }}">
                    @error('position') <small class="admin-field-error">{{ $message }}</small> @enderror
                </label>

                <label class="admin-field">
                    <span>CTA URL</span>
                    <input class="input-ghost" type="url" name="cta_url" value="{{ old('cta_url', $service->cta_url) }}">
                    @error('cta_url') <small class="admin-field-error">{{ $message }}</small> @enderror
                </label>
            </div>

            <label class="admin-check">
                <input type="checkbox" name="featured" value="1" @checked(old('featured', $service->featured))>
                <span>Feature this service for homepage and priority service placements.</span>
            </label>

            <label class="admin-field">
                <span>Tags</span>
                <select class="input-ghost" name="tag_ids[]" multiple size="6">
                    @foreach($tags as $id => $name)
                        <option value="{{ $id }}" @selected($selectedTags->contains($id))>{{ $name }}</option>
                    @endforeach
                </select>
            </label>
        </section>

        <section class="panel admin-form-section">
            <div>
                <span class="eyebrow">Content framing</span>
                <h2>Who it helps, business value, features, and delivery flow</h2>
            </div>

            <div class="admin-form-grid">
                <label class="admin-field">
                    <span>Who it helps</span>
                    <textarea class="input-ghost" name="meta[who]" rows="3">{{ $meta['who'] ?? '' }}</textarea>
                    @error('meta.who') <small class="admin-field-error">{{ $message }}</small> @enderror
                </label>

                <label class="admin-field">
                    <span>Business value</span>
                    <textarea class="input-ghost" name="meta[business_value]" rows="3">{{ $meta['business_value'] ?? '' }}</textarea>
                    @error('meta.business_value') <small class="admin-field-error">{{ $message }}</small> @enderror
                </label>
            </div>

            <div class="admin-form-grid">
                <label class="admin-field">
                    <span>Features</span>
                    <textarea class="input-ghost" name="features_text" rows="6">{{ implode("\n", \App\Support\ContentMapper::stringList(old('features_text', $service->features ?? []))) }}</textarea>
                    <small class="admin-field-help">One feature per line.</small>
                    @error('features_text') <small class="admin-field-error">{{ $message }}</small> @enderror
                </label>

                <label class="admin-field">
                    <span>Tech stack</span>
                    <textarea class="input-ghost" name="meta[stack_text]" rows="6">{{ implode("\n", \App\Support\ContentMapper::stringList($meta['stack_text'] ?? ($meta['stack'] ?? []))) }}</textarea>
                    <small class="admin-field-help">One technology per line.</small>
                    @error('meta.stack_text') <small class="admin-field-error">{{ $message }}</small> @enderror
                </label>
            </div>

            <div class="admin-form-grid">
                <label class="admin-field">
                    <span>Deliverables</span>
                    <textarea class="input-ghost" name="meta[deliverables_text]" rows="6">{{ implode("\n", \App\Support\ContentMapper::stringList($meta['deliverables_text'] ?? ($meta['deliverables'] ?? []))) }}</textarea>
                    <small class="admin-field-help">What is included in the service.</small>
                    @error('meta.deliverables_text') <small class="admin-field-error">{{ $message }}</small> @enderror
                </label>

                <label class="admin-field">
                    <span>Process</span>
                    <textarea class="input-ghost" name="meta[process_text]" rows="6">{{ implode("\n", \App\Support\ContentMapper::stringList($meta['process_text'] ?? ($meta['process'] ?? []))) }}</textarea>
                    <small class="admin-field-help">One step per line.</small>
                    @error('meta.process_text') <small class="admin-field-error">{{ $message }}</small> @enderror
                </label>
            </div>
        </section>

        <section class="panel admin-form-section">
            <div>
                <span class="eyebrow">Media</span>
                <h2>Service image for listing cards and stronger presentation</h2>
            </div>

            <div class="admin-form-grid">
                <label class="admin-field">
                    <span>Featured image path or URL</span>
                    <input class="input-ghost" type="text" name="featured_image" value="{{ old('featured_image', $service->featured_image) }}">
                    @error('featured_image') <small class="admin-field-error">{{ $message }}</small> @enderror
                </label>

                <label class="admin-field">
                    <span>Upload featured image</span>
                    <input class="input-ghost" type="file" name="featured_image_file" accept="image/*">
                    @error('featured_image_file') <small class="admin-field-error">{{ $message }}</small> @enderror
                </label>
            </div>

            @if(old('featured_image', $service->featured_image))
                <div class="admin-media-preview">
                    <img src="{{ \App\Support\ContentMapper::mediaUrl(old('featured_image', $service->featured_image)) }}" alt="{{ old('title', $service->title) }}">
                </div>
            @endif
        </section>

        <div class="admin-toolbar-actions">
            <button class="btn btn-primary" type="submit">{{ $service->exists ? 'Update service' : 'Create service' }}</button>
            <a class="btn btn-secondary" href="{{ route('admin.services.index', app()->getLocale()) }}">Back to services</a>
        </div>
    </form>
@endsection
