@php
    $site = \App\Support\BrandContent::site(app()->getLocale());
    $form = $site['form'];
    $projectTypes = $form['project_types'] ?? ['Business website', 'Web application', 'SaaS platform', 'Dashboard or internal tool', 'API or integration', 'Optimization or redesign'];
    $timelines = $form['timelines'] ?? ['As soon as possible', 'Within 2 to 4 weeks', 'Within 1 to 2 months', 'Still planning the scope'];
@endphp

<form method="POST" action="{{ route('contact.store', ['locale' => app()->getLocale()]) }}" class="contact-form panel">
    @csrf

    <p class="contact-form-note">{{ __('brand.ui.contact.form_note') }}</p>

    <div class="form-grid">
        <label class="field">
            <span>{{ $form['name'] }}</span>
            <input type="text" name="name" value="{{ old('name') }}" required>
            @error('name')<small>{{ $message }}</small>@enderror
        </label>

        <label class="field">
            <span>{{ $form['email'] }}</span>
            <input type="email" name="email" value="{{ old('email') }}" required>
            @error('email')<small>{{ $message }}</small>@enderror
        </label>

        <label class="field">
            <span>{{ $form['company'] }}</span>
            <input type="text" name="company" value="{{ old('company') }}">
            @error('company')<small>{{ $message }}</small>@enderror
        </label>

        <label class="field">
            <span>{{ $form['project_type'] }}</span>
            <select name="project_type">
                <option value="">{{ $form['project_type_placeholder'] }}</option>
                @foreach($projectTypes as $projectType)
                    <option value="{{ $projectType }}" @selected(old('project_type') === $projectType)>{{ $projectType }}</option>
                @endforeach
            </select>
            @error('project_type')<small>{{ $message }}</small>@enderror
        </label>

        <label class="field">
            <span>{{ $form['budget'] }}</span>
            <select name="budget">
                <option value="">{{ $form['budget_placeholder'] }}</option>
                @foreach($form['budgets'] as $budget)
                    <option value="{{ $budget }}" @selected(old('budget') === $budget)>{{ $budget }}</option>
                @endforeach
            </select>
            @error('budget')<small>{{ $message }}</small>@enderror
        </label>

        <label class="field">
            <span>{{ $form['timeline'] }}</span>
            <select name="timeline">
                <option value="">{{ $form['timeline_placeholder'] }}</option>
                @foreach($timelines as $timeline)
                    <option value="{{ $timeline }}" @selected(old('timeline') === $timeline)>{{ $timeline }}</option>
                @endforeach
            </select>
            @error('timeline')<small>{{ $message }}</small>@enderror
        </label>
    </div>

    <label class="field">
        <span>{{ $form['message'] }}</span>
        <textarea name="message" rows="6" placeholder="{{ $form['message_placeholder'] }}" required>{{ old('message') }}</textarea>
        @error('message')<small>{{ $message }}</small>@enderror
    </label>

    <div class="form-actions">
        <button type="submit" class="btn btn-primary">{{ $site['actions']['send_message'] }}</button>
        <a href="{{ $site['whatsapp_url'] }}" class="btn btn-secondary" target="_blank" rel="noopener">{{ $site['actions']['whatsapp'] }}</a>
    </div>
</form>
