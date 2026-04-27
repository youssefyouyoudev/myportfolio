@extends('layouts.admin')

@php
    $meta = old('meta', $project->meta ?? []);
@endphp

@section('title', $project->exists ? 'Edit Project' : 'New Project')
@section('admin_title', $project->exists ? 'Edit Project' : 'Create Project')
@section('admin_copy', 'Shape the case study, define the business framing, and control how the project appears on the public portfolio.')

@section('content')
    <form method="post" enctype="multipart/form-data" action="{{ $project->exists ? route('admin.projects.update', [app()->getLocale(), $project]) : route('admin.projects.store', app()->getLocale()) }}" class="surface admin-form p-6">
        @csrf
        @if($project->exists)
            @method('PUT')
        @endif

        <section class="admin-form-section">
            <h2>Core details</h2>
            <div class="admin-form-grid">
                <div class="admin-field">
                    <label for="title">Title</label>
                    <input id="title" name="title" value="{{ old('title', $project->title) }}" class="input-ghost" required>
                    @error('title')<div class="admin-field-error">{{ $message }}</div>@enderror
                </div>
                <div class="admin-field">
                    <label for="slug">Slug</label>
                    <input id="slug" name="slug" value="{{ old('slug', $project->slug) }}" class="input-ghost" required>
                    @error('slug')<div class="admin-field-error">{{ $message }}</div>@enderror
                </div>
            </div>

            <div class="admin-field">
                <label for="excerpt">Summary</label>
                <textarea id="excerpt" name="excerpt" rows="3" class="input-ghost">{{ old('excerpt', $project->excerpt) }}</textarea>
                @error('excerpt')<div class="admin-field-error">{{ $message }}</div>@enderror
            </div>

            <div class="admin-field">
                <label for="description">Description</label>
                <textarea id="description" name="description" rows="7" class="input-ghost">{{ old('description', $project->description) }}</textarea>
                @error('description')<div class="admin-field-error">{{ $message }}</div>@enderror
            </div>

            <div class="admin-form-grid three">
                <div class="admin-field">
                    <label for="status">Status</label>
                    <select id="status" name="status" class="input-ghost">
                        <option value="draft" @selected(old('status', $project->status) === 'draft')>Draft</option>
                        <option value="published" @selected(old('status', $project->status) === 'published')>Published</option>
                    </select>
                    @error('status')<div class="admin-field-error">{{ $message }}</div>@enderror
                </div>
                <div class="admin-field">
                    <label for="category_id">Category</label>
                    <select id="category_id" name="category_id" class="input-ghost">
                        <option value="">No category</option>
                        @foreach($categories as $id => $name)
                            <option value="{{ $id }}" @selected(old('category_id', $project->category_id) == $id)>{{ $name }}</option>
                        @endforeach
                    </select>
                    @error('category_id')<div class="admin-field-error">{{ $message }}</div>@enderror
                </div>
                <div class="admin-field">
                    <label for="published_at">Published at</label>
                    <input id="published_at" type="datetime-local" name="published_at" value="{{ old('published_at', optional($project->published_at)->format('Y-m-d\TH:i')) }}" class="input-ghost">
                    @error('published_at')<div class="admin-field-error">{{ $message }}</div>@enderror
                </div>
            </div>

            <div class="admin-check">
                <input id="featured" type="hidden" name="featured" value="0">
                <input id="featured_checkbox" type="checkbox" name="featured" value="1" @checked(old('featured', $project->featured))>
                <label for="featured_checkbox">Mark as featured project</label>
            </div>
        </section>

        <section class="admin-form-section">
            <h2>Links and media</h2>
            <div class="admin-form-grid">
                <div class="admin-field">
                    <label for="live_url">Live URL</label>
                    <input id="live_url" name="live_url" value="{{ old('live_url', $project->live_url) }}" class="input-ghost">
                    @error('live_url')<div class="admin-field-error">{{ $message }}</div>@enderror
                </div>
                <div class="admin-field">
                    <label for="client_name">Client name</label>
                    <input id="client_name" name="client_name" value="{{ old('client_name', $project->client_name) }}" class="input-ghost">
                    @error('client_name')<div class="admin-field-error">{{ $message }}</div>@enderror
                </div>
            </div>

            <div class="admin-form-grid">
                <div class="admin-field">
                    <label for="client_industry">Client industry</label>
                    <input id="client_industry" name="client_industry" value="{{ old('client_industry', $project->client_industry) }}" class="input-ghost">
                    @error('client_industry')<div class="admin-field-error">{{ $message }}</div>@enderror
                </div>
                <div class="admin-field">
                    <label for="result_headline">Result headline</label>
                    <input id="result_headline" name="result_headline" value="{{ old('result_headline', $project->result_headline) }}" class="input-ghost">
                    @error('result_headline')<div class="admin-field-error">{{ $message }}</div>@enderror
                </div>
            </div>

            <div class="admin-form-grid three">
                <div class="admin-field">
                    <label for="repo_url">Repository URL</label>
                    <input id="repo_url" name="repo_url" value="{{ old('repo_url', $project->repo_url) }}" class="input-ghost">
                    @error('repo_url')<div class="admin-field-error">{{ $message }}</div>@enderror
                </div>
                <div class="admin-field">
                    <label for="built_at">Built at</label>
                    <input id="built_at" type="date" name="built_at" value="{{ old('built_at', optional($project->built_at)->format('Y-m-d')) }}" class="input-ghost">
                    @error('built_at')<div class="admin-field-error">{{ $message }}</div>@enderror
                </div>
                <label class="admin-check">
                    <input id="is_concept" type="hidden" name="is_concept" value="0">
                    <input id="is_concept_checkbox" type="checkbox" name="is_concept" value="1" @checked(old('is_concept', $project->is_concept))>
                    <span>Concept / portfolio piece</span>
                </label>
                <label class="admin-check">
                    <input id="is_nda" type="hidden" name="is_nda" value="0">
                    <input id="is_nda_checkbox" type="checkbox" name="is_nda" value="1" @checked(old('is_nda', $project->is_nda))>
                    <span>Under NDA</span>
                </label>
            </div>

            <div class="admin-form-grid">
                <div class="admin-field">
                    <label for="hero_image">Hero image path or URL</label>
                    <input id="hero_image" name="hero_image" value="{{ old('hero_image', $project->hero_image) }}" class="input-ghost">
                    @error('hero_image')<div class="admin-field-error">{{ $message }}</div>@enderror
                </div>
                <div class="admin-field">
                    <label for="hero_image_file">Upload hero image</label>
                    <input id="hero_image_file" type="file" name="hero_image_file" accept="image/*" class="input-ghost">
                    @error('hero_image_file')<div class="admin-field-error">{{ $message }}</div>@enderror
                </div>
            </div>

            <div class="admin-form-grid">
                <div class="admin-field">
                    <label for="screenshot_path">Primary screenshot path or URL</label>
                    <input id="screenshot_path" name="screenshot_path" value="{{ old('screenshot_path', $project->screenshot_path) }}" class="input-ghost">
                    @error('screenshot_path')<div class="admin-field-error">{{ $message }}</div>@enderror
                </div>
                <div class="admin-field">
                    <label for="screenshot_webp_path">Primary screenshot WebP path or URL</label>
                    <input id="screenshot_webp_path" name="screenshot_webp_path" value="{{ old('screenshot_webp_path', $project->screenshot_webp_path) }}" class="input-ghost">
                    @error('screenshot_webp_path')<div class="admin-field-error">{{ $message }}</div>@enderror
                </div>
            </div>

            <div class="admin-field">
                <label for="stack_text">Tech stack</label>
                <textarea id="stack_text" name="stack_text" rows="3" class="input-ghost">{{ old('stack_text', implode("\n", $project->stack ?? [])) }}</textarea>
                <div class="admin-field-help">One item per line. Example: Laravel, React, PostgreSQL.</div>
                @error('stack_text')<div class="admin-field-error">{{ $message }}</div>@enderror
            </div>

            <div class="admin-field">
                <label for="screenshot_urls">Screenshot URLs</label>
                <textarea id="screenshot_urls" name="screenshot_urls" rows="4" class="input-ghost">{{ old('screenshot_urls', ($project->screenshots ?? collect())->pluck('image_url')->filter()->implode(PHP_EOL)) }}</textarea>
                <div class="admin-field-help">One public image URL per line.</div>
                @error('screenshot_urls')<div class="admin-field-error">{{ $message }}</div>@enderror
            </div>

            <div class="admin-form-grid">
                <div class="admin-field">
                    <label for="screenshot_files">Upload screenshots</label>
                    <input id="screenshot_files" type="file" name="screenshot_files[]" accept="image/*" multiple class="input-ghost">
                    @error('screenshot_files.*')<div class="admin-field-error">{{ $message }}</div>@enderror
                </div>
                <div class="admin-field">
                    <label for="project_files">Project files</label>
                    <input id="project_files" type="file" name="project_files[]" multiple class="input-ghost">
                    @error('project_files.*')<div class="admin-field-error">{{ $message }}</div>@enderror
                </div>
            </div>
        </section>

        <section class="admin-form-section">
            <h2>Case study framing</h2>
            <div class="admin-meta-grid">
                <div class="admin-field">
                    <label for="meta_label">Category label</label>
                    <input id="meta_label" name="meta[label]" value="{{ $meta['label'] ?? '' }}" class="input-ghost">
                </div>
                <div class="admin-field">
                    <label for="meta_theme">Theme key</label>
                    <input id="meta_theme" name="meta[theme]" value="{{ $meta['theme'] ?? '' }}" class="input-ghost" placeholder="ecarsauto / rifimedia / erpplus">
                </div>
                <div class="admin-field">
                    <label for="meta_client">Client / market</label>
                    <input id="meta_client" name="meta[client]" value="{{ $meta['client'] ?? '' }}" class="input-ghost">
                </div>
                <div class="admin-field">
                    <label for="meta_audience">Built for</label>
                    <input id="meta_audience" name="meta[audience]" value="{{ $meta['audience'] ?? '' }}" class="input-ghost">
                </div>
            </div>

            <div class="admin-field">
                <label for="meta_challenge">Problem / challenge</label>
                <textarea id="meta_challenge" name="meta[challenge]" rows="3" class="input-ghost">{{ $meta['challenge'] ?? '' }}</textarea>
            </div>
            <div class="admin-field">
                <label for="meta_solution">Solution</label>
                <textarea id="meta_solution" name="meta[solution]" rows="3" class="input-ghost">{{ $meta['solution'] ?? '' }}</textarea>
            </div>
            <div class="admin-field">
                <label for="meta_role">Role</label>
                <textarea id="meta_role" name="meta[role]" rows="2" class="input-ghost">{{ $meta['role'] ?? '' }}</textarea>
            </div>
            <div class="admin-field">
                <label for="meta_outcome">Outcome</label>
                <textarea id="meta_outcome" name="meta[outcome]" rows="2" class="input-ghost">{{ $meta['outcome'] ?? '' }}</textarea>
            </div>
            <div class="admin-field">
                <label for="meta_note">Context note</label>
                <textarea id="meta_note" name="meta[note]" rows="2" class="input-ghost">{{ $meta['note'] ?? '' }}</textarea>
            </div>

            <div class="admin-field">
                <label for="context">Editorial context</label>
                <textarea id="context" name="context" rows="3" class="input-ghost">{{ old('context', $project->context) }}</textarea>
                @error('context')<div class="admin-field-error">{{ $message }}</div>@enderror
            </div>
            <div class="admin-field">
                <label for="problem_long">Long-form problem</label>
                <textarea id="problem_long" name="problem_long" rows="4" class="input-ghost">{{ old('problem_long', $project->problem_long) }}</textarea>
                @error('problem_long')<div class="admin-field-error">{{ $message }}</div>@enderror
            </div>
            <div class="admin-field">
                <label for="solution_long">Long-form solution</label>
                <textarea id="solution_long" name="solution_long" rows="4" class="input-ghost">{{ old('solution_long', $project->solution_long) }}</textarea>
                @error('solution_long')<div class="admin-field-error">{{ $message }}</div>@enderror
            </div>
            <div class="admin-field">
                <label for="outcome_long">Long-form outcome</label>
                <textarea id="outcome_long" name="outcome_long" rows="4" class="input-ghost">{{ old('outcome_long', $project->outcome_long) }}</textarea>
                @error('outcome_long')<div class="admin-field-error">{{ $message }}</div>@enderror
            </div>

            <div class="admin-form-grid">
                <div class="admin-field">
                    <label for="meta_logo_image">Logo image path or URL</label>
                    <input id="meta_logo_image" name="meta[logo_image]" value="{{ $meta['logo_image'] ?? '' }}" class="input-ghost">
                </div>
                <div class="admin-field">
                    <label for="meta_logo_alt">Logo alt text</label>
                    <input id="meta_logo_alt" name="meta[logo_alt]" value="{{ $meta['logo_alt'] ?? '' }}" class="input-ghost">
                </div>
            </div>

            <div class="admin-field">
                <label for="meta_cover_alt">Cover alt text</label>
                <input id="meta_cover_alt" name="meta[cover_alt]" value="{{ $meta['cover_alt'] ?? '' }}" class="input-ghost">
            </div>

            <div class="admin-field">
                <label for="meta_features_text">Key features</label>
                <textarea id="meta_features_text" name="meta[features_text]" rows="4" class="input-ghost">{{ old('meta.features_text', implode("\n", $meta['features'] ?? [])) }}</textarea>
                <div class="admin-field-help">One feature per line.</div>
            </div>

            <div class="admin-field">
                <label for="meta_metrics_text">Metrics</label>
                <textarea id="meta_metrics_text" name="meta[metrics_text]" rows="4" class="input-ghost">{{ old('meta.metrics_text', collect($meta['metrics'] ?? [])->map(fn ($metric) => ($metric['label'] ?? 'Metric').'|'.($metric['value'] ?? ''))->implode("\n")) }}</textarea>
                <div class="admin-field-help">Use one line per metric in the format <code>Label|Value</code>.</div>
            </div>

            <div class="admin-form-grid three">
                <div class="admin-field">
                    <label for="result_1_label">Result card 1</label>
                    <input id="result_1_label" name="result_1_label" value="{{ old('result_1_label', $project->result_1_label) }}" class="input-ghost" placeholder="Launch time">
                    <input id="result_1_value" name="result_1_value" value="{{ old('result_1_value', $project->result_1_value) }}" class="input-ghost mt-2" placeholder="3 weeks">
                </div>
                <div class="admin-field">
                    <label for="result_2_label">Result card 2</label>
                    <input id="result_2_label" name="result_2_label" value="{{ old('result_2_label', $project->result_2_label) }}" class="input-ghost" placeholder="Performance score">
                    <input id="result_2_value" name="result_2_value" value="{{ old('result_2_value', $project->result_2_value) }}" class="input-ghost mt-2" placeholder="96/100">
                </div>
                <div class="admin-field">
                    <label for="result_3_label">Result card 3</label>
                    <input id="result_3_label" name="result_3_label" value="{{ old('result_3_label', $project->result_3_label) }}" class="input-ghost" placeholder="Client outcome">
                    <input id="result_3_value" name="result_3_value" value="{{ old('result_3_value', $project->result_3_value) }}" class="input-ghost mt-2" placeholder="Less manual work">
                </div>
            </div>

            <div class="admin-form-grid three">
                <div class="admin-field">
                    <label for="metric_one_label">Metric 1</label>
                    <input id="metric_one_label" name="metric_one_label" value="{{ old('metric_one_label', $project->metric_one_label) }}" class="input-ghost" placeholder="Launch time">
                    <input id="metric_one_value" name="metric_one_value" value="{{ old('metric_one_value', $project->metric_one_value) }}" class="input-ghost mt-2" placeholder="3 weeks">
                </div>
                <div class="admin-field">
                    <label for="metric_two_label">Metric 2</label>
                    <input id="metric_two_label" name="metric_two_label" value="{{ old('metric_two_label', $project->metric_two_label) }}" class="input-ghost" placeholder="Performance score">
                    <input id="metric_two_value" name="metric_two_value" value="{{ old('metric_two_value', $project->metric_two_value) }}" class="input-ghost mt-2" placeholder="96/100">
                </div>
                <div class="admin-field">
                    <label for="metric_three_label">Metric 3</label>
                    <input id="metric_three_label" name="metric_three_label" value="{{ old('metric_three_label', $project->metric_three_label) }}" class="input-ghost" placeholder="Client outcome">
                    <input id="metric_three_value" name="metric_three_value" value="{{ old('metric_three_value', $project->metric_three_value) }}" class="input-ghost mt-2" placeholder="Reduced booking time by 60%">
                </div>
            </div>
        </section>

        <section class="admin-form-section">
            <h2>SEO</h2>
            <div class="admin-meta-grid">
                <div class="admin-field">
                    <label for="meta_seo_title">SEO title</label>
                    <input id="meta_seo_title" name="meta[seo_title]" value="{{ $meta['seo_title'] ?? '' }}" class="input-ghost">
                </div>
                <div class="admin-field">
                    <label for="meta_seo_image">SEO image path or URL</label>
                    <input id="meta_seo_image" name="meta[seo_image]" value="{{ $meta['seo_image'] ?? '' }}" class="input-ghost">
                </div>
            </div>
            <div class="admin-field">
                <label for="meta_seo_description">SEO description</label>
                <textarea id="meta_seo_description" name="meta[seo_description]" rows="3" class="input-ghost">{{ $meta['seo_description'] ?? '' }}</textarea>
            </div>
            <div class="admin-field">
                <label for="meta_seo_keywords">SEO keywords</label>
                <input id="meta_seo_keywords" name="meta[seo_keywords]" value="{{ $meta['seo_keywords'] ?? '' }}" class="input-ghost">
            </div>
        </section>

        <section class="admin-form-section">
            <h2>Tags</h2>
            <div class="admin-field">
                <label for="tag_ids">Tags</label>
                <select id="tag_ids" name="tag_ids[]" multiple class="input-ghost">
                    @foreach($tags as $id => $name)
                        <option value="{{ $id }}" @selected(collect(old('tag_ids', $project->tags->pluck('id')->all()))->contains($id))>{{ $name }}</option>
                    @endforeach
                </select>
            </div>
        </section>

        <div class="admin-toolbar-actions">
            <button class="btn btn-primary" type="submit">Save project</button>
            <a class="btn btn-secondary" href="{{ route('admin.projects.index', app()->getLocale()) }}">Back to projects</a>
        </div>
    </form>
@endsection
