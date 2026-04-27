@php
    $site = \App\Support\BrandContent::site(app()->getLocale());
    $form = $site['form'];
    $projectTypes = $form['project_types'] ?? ['Business website', 'Web application', 'SaaS platform', 'Dashboard or internal tool', 'API or integration', 'Optimization or redesign'];
    $timelines = $form['timelines'] ?? ['As soon as possible', 'Within 2 to 4 weeks', 'Within 1 to 2 months', 'Still planning the scope'];
@endphp

<form method="POST" action="{{ route('contact.store', ['locale' => app()->getLocale()]) }}" class="contact-form panel" data-contact-form novalidate>
    @csrf

    <p class="contact-form-note">{{ __('brand.ui.contact.form_note') }}</p>

    <div class="form-honeypot" aria-hidden="true">
        <label>
            <span>Website</span>
            <input type="text" name="website" tabindex="-1" autocomplete="off">
        </label>
    </div>

    <div class="form-grid">
        <label class="field" for="contact-name">
            <span>{{ $form['name'] }}</span>
            <input id="contact-name" type="text" name="name" value="{{ old('name') }}" autocomplete="name" maxlength="120" required data-error-target="name">
            @error('name')<small>{{ $message }}</small>@enderror
            <small class="field-error" data-field-error="name"></small>
        </label>

        <label class="field" for="contact-email">
            <span>{{ $form['email'] }}</span>
            <input id="contact-email" type="email" name="email" value="{{ old('email') }}" autocomplete="email" inputmode="email" maxlength="150" required data-error-target="email">
            @error('email')<small>{{ $message }}</small>@enderror
            <small class="field-error" data-field-error="email"></small>
        </label>

        <label class="field" for="contact-company">
            <span>{{ $form['company'] }}</span>
            <input id="contact-company" type="text" name="company" value="{{ old('company') }}" autocomplete="organization" maxlength="120">
            @error('company')<small>{{ $message }}</small>@enderror
        </label>

        <label class="field" for="contact-project-type">
            <span>{{ $form['project_type'] }}</span>
            <select id="contact-project-type" name="project_type">
                <option value="">{{ $form['project_type_placeholder'] }}</option>
                @foreach($projectTypes as $projectType)
                    <option value="{{ $projectType }}" @selected(old('project_type') === $projectType)>{{ $projectType }}</option>
                @endforeach
            </select>
            @error('project_type')<small>{{ $message }}</small>@enderror
        </label>

        <label class="field" for="contact-budget">
            <span>{{ $form['budget'] }}</span>
            <select id="contact-budget" name="budget">
                <option value="">{{ $form['budget_placeholder'] }}</option>
                @foreach($form['budgets'] as $budget)
                    <option value="{{ $budget }}" @selected(old('budget') === $budget)>{{ $budget }}</option>
                @endforeach
            </select>
            @error('budget')<small>{{ $message }}</small>@enderror
        </label>

        <label class="field" for="contact-timeline">
            <span>{{ $form['timeline'] }}</span>
            <select id="contact-timeline" name="timeline">
                <option value="">{{ $form['timeline_placeholder'] }}</option>
                @foreach($timelines as $timeline)
                    <option value="{{ $timeline }}" @selected(old('timeline') === $timeline)>{{ $timeline }}</option>
                @endforeach
            </select>
            @error('timeline')<small>{{ $message }}</small>@enderror
        </label>
    </div>

    <label class="field" for="contact-message">
        <span>{{ $form['message'] }}</span>
        <textarea id="contact-message" name="message" rows="6" placeholder="{{ $form['message_placeholder'] }}" maxlength="2000" required data-error-target="message">{{ old('message') }}</textarea>
        @error('message')<small>{{ $message }}</small>@enderror
        <small class="field-error" data-field-error="message"></small>
    </label>

    <div class="form-actions">
        <button type="submit" class="btn btn-primary" data-submit-button>
            <span data-submit-label>{{ $site['actions']['send_message'] }}</span>
            <span class="button-spinner" data-submit-spinner aria-hidden="true"></span>
        </button>
        <a href="{{ $site['whatsapp_url'] }}" class="btn btn-secondary" target="_blank" rel="noopener">{{ $site['actions']['whatsapp'] }}</a>
    </div>
</form>
