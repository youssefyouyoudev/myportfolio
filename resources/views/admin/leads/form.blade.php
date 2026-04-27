@extends('layouts.admin')

@section('title', $lead->exists ? 'Edit Lead' : 'New Lead')
@section('admin_title', $lead->exists ? 'Edit Lead' : 'Create Lead')
@section('admin_copy', 'Add or update a business lead with clear contact details, pipeline status, revenue estimate, and follow-up notes.')

@section('content')
    <form
        method="post"
        action="{{ $lead->exists ? route('admin.leads.update', [app()->getLocale(), $lead]) : route('admin.leads.store', app()->getLocale()) }}"
        class="admin-form"
    >
        @csrf
        @if($lead->exists)
            @method('PUT')
        @endif

        <section class="panel admin-form-section">
            <div>
                <span class="eyebrow">Business</span>
                <h2>Core company details</h2>
            </div>

            <div class="admin-form-grid">
                <label class="admin-field">
                    <span>Business name</span>
                    <input class="input-ghost" type="text" name="business_name" value="{{ old('business_name', $lead->business_name) }}" required>
                    @error('business_name') <small class="admin-field-error">{{ $message }}</small> @enderror
                </label>

                <label class="admin-field">
                    <span>Status</span>
                    <select class="input-ghost" name="status">
                        @foreach($statuses as $value => $label)
                            <option value="{{ $value }}" @selected(old('status', $lead->status) === $value)>{{ $label }}</option>
                        @endforeach
                    </select>
                    @error('status') <small class="admin-field-error">{{ $message }}</small> @enderror
                </label>
            </div>

            <div class="admin-form-grid three">
                <label class="admin-field">
                    <span>Category</span>
                    <input class="input-ghost" type="text" name="category" value="{{ old('category', $lead->category) }}">
                    @error('category') <small class="admin-field-error">{{ $message }}</small> @enderror
                </label>

                <label class="admin-field">
                    <span>City</span>
                    <input class="input-ghost" type="text" name="city" value="{{ old('city', $lead->city) }}">
                    @error('city') <small class="admin-field-error">{{ $message }}</small> @enderror
                </label>

                <label class="admin-field">
                    <span>Source</span>
                    <input class="input-ghost" type="text" name="source" value="{{ old('source', $lead->source) }}" placeholder="Referral, lead finder, LinkedIn, cold outreach...">
                    @error('source') <small class="admin-field-error">{{ $message }}</small> @enderror
                </label>
            </div>
        </section>

        <section class="panel admin-form-section">
            <div>
                <span class="eyebrow">Contact</span>
                <h2>Channels for outreach and research</h2>
            </div>

            <div class="admin-form-grid">
                <label class="admin-field">
                    <span>Phone</span>
                    <input class="input-ghost" type="text" name="phone" value="{{ old('phone', $lead->phone) }}">
                    @error('phone') <small class="admin-field-error">{{ $message }}</small> @enderror
                </label>

                <label class="admin-field">
                    <span>Email</span>
                    <input class="input-ghost" type="email" name="email" value="{{ old('email', $lead->email) }}">
                    @error('email') <small class="admin-field-error">{{ $message }}</small> @enderror
                </label>
            </div>

            <label class="admin-field">
                <span>Website</span>
                <input class="input-ghost" type="url" name="website" value="{{ old('website', $lead->website) }}">
                @error('website') <small class="admin-field-error">{{ $message }}</small> @enderror
            </label>
        </section>

        <section class="panel admin-form-section">
            <div>
                <span class="eyebrow">Pipeline</span>
                <h2>Replies and revenue estimate</h2>
            </div>

            <div class="admin-form-grid">
                <label class="admin-field">
                    <span>Reply count</span>
                    <input class="input-ghost" type="number" min="0" name="reply_count" value="{{ old('reply_count', $lead->reply_count ?? 0) }}">
                    @error('reply_count') <small class="admin-field-error">{{ $message }}</small> @enderror
                </label>

                <label class="admin-field">
                    <span>Estimated revenue (MAD)</span>
                    <input class="input-ghost" type="number" step="0.01" min="0" name="estimated_revenue" value="{{ old('estimated_revenue', $lead->estimated_revenue) }}">
                    @error('estimated_revenue') <small class="admin-field-error">{{ $message }}</small> @enderror
                </label>
            </div>
        </section>

        <section class="panel admin-form-section">
            <div>
                <span class="eyebrow">Notes</span>
                <h2>Context for follow-up</h2>
            </div>

            <label class="admin-field">
                <span>Notes</span>
                <textarea class="input-ghost" name="notes" rows="10">{{ old('notes', $lead->notes) }}</textarea>
                <small class="admin-field-help">Store business context, pain points, next steps, or outreach history here.</small>
                @error('notes') <small class="admin-field-error">{{ $message }}</small> @enderror
            </label>
        </section>

        <div class="admin-toolbar-actions">
            <button class="btn btn-primary" type="submit">{{ $lead->exists ? 'Update lead' : 'Create lead' }}</button>
            <a class="btn btn-secondary" href="{{ route('admin.leads.index', app()->getLocale()) }}">Back to leads</a>
        </div>
    </form>
@endsection
