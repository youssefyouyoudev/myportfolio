@extends('layouts.admin')

@section('title', $testimonial->exists ? 'Edit Testimonial' : 'New Testimonial')
@section('admin_title', $testimonial->exists ? 'Edit Testimonial' : 'Create Testimonial')
@section('admin_copy', 'Store client proof with names, roles, quotes, media, and publishing controls so the strongest credibility assets stay organized.')

@section('content')
    <form
        method="post"
        enctype="multipart/form-data"
        action="{{ $testimonial->exists ? route('admin.testimonials.update', [app()->getLocale(), $testimonial]) : route('admin.testimonials.store', app()->getLocale()) }}"
        class="admin-form"
    >
        @csrf
        @if($testimonial->exists)
            @method('PUT')
        @endif

        <section class="panel admin-form-section">
            <div>
                <span class="eyebrow">Identity</span>
                <h2>Name, company, role, and location</h2>
            </div>

            <div class="admin-form-grid">
                <label class="admin-field">
                    <span>Client name</span>
                    <input class="input-ghost" type="text" name="client_name" value="{{ old('client_name', $testimonial->display_name) }}" required>
                    @error('client_name') <small class="admin-field-error">{{ $message }}</small> @enderror
                </label>

                <label class="admin-field">
                    <span>Company</span>
                    <input class="input-ghost" type="text" name="client_company" value="{{ old('client_company', $testimonial->display_company) }}">
                    @error('client_company') <small class="admin-field-error">{{ $message }}</small> @enderror
                </label>
            </div>

            <div class="admin-form-grid">
                <label class="admin-field">
                    <span>Title</span>
                    <input class="input-ghost" type="text" name="client_title" value="{{ old('client_title', $testimonial->display_title) }}">
                    @error('client_title') <small class="admin-field-error">{{ $message }}</small> @enderror
                </label>

                <label class="admin-field">
                    <span>Location</span>
                    <input class="input-ghost" type="text" name="location" value="{{ old('location', $testimonial->location) }}">
                    @error('location') <small class="admin-field-error">{{ $message }}</small> @enderror
                </label>
            </div>

            <label class="admin-field">
                <span>Quote</span>
                <textarea class="input-ghost" name="quote" rows="6" required>{{ old('quote', $testimonial->quote) }}</textarea>
                @error('quote') <small class="admin-field-error">{{ $message }}</small> @enderror
            </label>
        </section>

        <section class="panel admin-form-section">
            <div>
                <span class="eyebrow">Publishing</span>
                <h2>Status, feature flag, ordering, and publication date</h2>
            </div>

            <div class="admin-form-grid three">
                <label class="admin-field">
                    <span>Status</span>
                    <select class="input-ghost" name="status">
                        <option value="draft" @selected(old('status', $testimonial->status) === 'draft')>Draft</option>
                        <option value="published" @selected(old('status', $testimonial->status) === 'published')>Published</option>
                    </select>
                    @error('status') <small class="admin-field-error">{{ $message }}</small> @enderror
                </label>

                <label class="admin-field">
                    <span>Position</span>
                    <input class="input-ghost" type="number" min="1" name="position" value="{{ old('position', $testimonial->position ?: 1) }}">
                    @error('position') <small class="admin-field-error">{{ $message }}</small> @enderror
                </label>

                <label class="admin-field">
                    <span>Published at</span>
                    <input class="input-ghost" type="datetime-local" name="published_at" value="{{ old('published_at', optional($testimonial->published_at)->format('Y-m-d\TH:i')) }}">
                    @error('published_at') <small class="admin-field-error">{{ $message }}</small> @enderror
                </label>
            </div>

            <label class="admin-check">
                <input type="checkbox" name="is_featured" value="1" @checked(old('is_featured', $testimonial->display_featured))>
                <span>Feature this testimonial for priority trust placements.</span>
            </label>
            <label class="admin-check">
                <input type="checkbox" name="published" value="1" @checked(old('published', $testimonial->published))>
                <span>Allow this testimonial to appear on the public site.</span>
            </label>
        </section>

        <section class="panel admin-form-section">
            <div>
                <span class="eyebrow">Media</span>
                <h2>Portrait or brand image</h2>
            </div>

            <div class="admin-form-grid">
                <label class="admin-field">
                    <span>Avatar path or URL</span>
                    <input class="input-ghost" type="text" name="avatar_path" value="{{ old('avatar_path', $testimonial->display_avatar) }}">
                    @error('avatar_path') <small class="admin-field-error">{{ $message }}</small> @enderror
                </label>

                <label class="admin-field">
                    <span>Upload image</span>
                    <input class="input-ghost" type="file" name="image_file" accept="image/*">
                    @error('image_file') <small class="admin-field-error">{{ $message }}</small> @enderror
                </label>
            </div>

            @if(old('avatar_path', $testimonial->display_avatar))
                <div class="admin-media-preview">
                    <img src="{{ \App\Support\ContentMapper::mediaUrl(old('avatar_path', $testimonial->display_avatar)) }}" alt="{{ old('client_name', $testimonial->display_name) }}">
                </div>
            @endif
        </section>

        <div class="admin-toolbar-actions">
            <button class="btn btn-primary" type="submit">{{ $testimonial->exists ? 'Update testimonial' : 'Create testimonial' }}</button>
            <a class="btn btn-secondary" href="{{ route('admin.testimonials.index', app()->getLocale()) }}">Back to testimonials</a>
        </div>
    </form>
@endsection
