@php
    $locale = app()->getLocale();
    $site   = \App\Support\BrandContent::site($locale);
    $form   = $site['form'];
    $projectTypes = [
        'Web app',
        'Mobile app',
        'Desktop app',
        'AI / automation',
        'Conception & architecture',
        'Full product build',
        'Team leadership',
        'Not sure yet',
    ];
    $budgets = [
        'Under 10K MAD',
        '10K–25K MAD',
        '25K MAD+',
        'International project (EUR/USD)',
        'Let\'s talk budget',
    ];
    $timelines = [
        'ASAP',
        '2–4 weeks',
        '1–2 months',
        'Still scoping',
    ];
@endphp

<form method="POST" action="{{ route('contact.store', ['locale' => $locale]) }}" class="contact-form panel" data-contact-form novalidate>
    @csrf

    <p class="contact-form-note">{{ __('brand.ui.contact.form_note') }}</p>

    {{-- Honeypot --}}
    <div class="form-honeypot" aria-hidden="true">
        <label>
            <span>Website</span>
            <input type="text" name="website" tabindex="-1" autocomplete="off">
        </label>
    </div>

    <div class="form-grid">
        <label class="field" for="contact-name">
            <span>Name <span class="field-required" aria-hidden="true">*</span></span>
            <input id="contact-name" type="text" name="name" value="{{ old('name') }}" autocomplete="name" maxlength="120" required data-error-target="name" placeholder="Your name">
            @error('name')<small class="field-error-static">{{ $message }}</small>@enderror
            <small class="field-error" data-field-error="name"></small>
        </label>

        <label class="field" for="contact-email">
            <span>Email <span class="field-required" aria-hidden="true">*</span></span>
            <input id="contact-email" type="email" name="email" value="{{ old('email') }}" autocomplete="email" inputmode="email" maxlength="150" required data-error-target="email" placeholder="you@company.com">
            @error('email')<small class="field-error-static">{{ $message }}</small>@enderror
            <small class="field-error" data-field-error="email"></small>
        </label>

        <label class="field field-full" for="contact-company">
            <span>Company / project name <span class="field-optional">(optional)</span></span>
            <input id="contact-company" type="text" name="company" value="{{ old('company') }}" autocomplete="organization" maxlength="120" placeholder="Your company or project name">
            @error('company')<small class="field-error-static">{{ $message }}</small>@enderror
        </label>

        <label class="field" for="contact-project-type">
            <span>What do you need?</span>
            <select id="contact-project-type" name="project_type">
                <option value="">Select service type…</option>
                @foreach($projectTypes as $projectType)
                    <option value="{{ $projectType }}" @selected(old('project_type') === $projectType)>{{ $projectType }}</option>
                @endforeach
            </select>
            @error('project_type')<small class="field-error-static">{{ $message }}</small>@enderror
        </label>

        <label class="field" for="contact-budget">
            <span>Budget range</span>
            <select id="contact-budget" name="budget">
                <option value="">Select budget range…</option>
                @foreach($budgets as $budget)
                    <option value="{{ $budget }}" @selected(old('budget') === $budget)>{{ $budget }}</option>
                @endforeach
            </select>
            @error('budget')<small class="field-error-static">{{ $message }}</small>@enderror
        </label>

        <label class="field" for="contact-timeline">
            <span>Timeline</span>
            <select id="contact-timeline" name="timeline">
                <option value="">Select timeline…</option>
                @foreach($timelines as $timeline)
                    <option value="{{ $timeline }}" @selected(old('timeline') === $timeline)>{{ $timeline }}</option>
                @endforeach
            </select>
            @error('timeline')<small class="field-error-static">{{ $message }}</small>@enderror
        </label>
    </div>

    <label class="field" for="contact-message">
        <span>Tell me about your project <span class="field-required" aria-hidden="true">*</span></span>
        <textarea id="contact-message" name="message" rows="6" placeholder="Describe your idea, the problem you're solving, and any relevant context…" maxlength="2000" required data-error-target="message">{{ old('message') }}</textarea>
        @error('message')<small class="field-error-static">{{ $message }}</small>@enderror
        <small class="field-error" data-field-error="message"></small>
    </label>

    <div class="form-actions">
        <button type="submit" class="btn btn-primary" data-submit-button id="contact-submit-btn">
            <span data-submit-label>Send brief &rarr;</span>
            <span class="button-spinner" data-submit-spinner aria-hidden="true"></span>
        </button>
        <a href="{{ $site['whatsapp_url'] }}" class="btn btn-secondary whatsapp-form-btn" target="_blank" rel="noopener" id="form-whatsapp-btn">
            <svg viewBox="0 0 24 24" aria-hidden="true" width="18" height="18"><path d="M19.05 4.94A9.93 9.93 0 0 0 12 2a10 10 0 0 0-8.66 15l-1.3 4.74 4.87-1.28A10 10 0 1 0 19.05 4.94Zm-7.05 15.39a8.27 8.27 0 0 1-4.22-1.16l-.3-.18-2.89.76.77-2.82-.19-.3A8.34 8.34 0 1 1 12 20.33Zm4.58-6.26c-.25-.12-1.47-.73-1.7-.81-.23-.08-.39-.12-.56.12-.17.25-.64.81-.79.97-.14.17-.29.19-.54.06-.25-.12-1.04-.38-1.98-1.22-.73-.65-1.22-1.45-1.36-1.7-.14-.25-.02-.38.1-.5.11-.11.25-.29.37-.43.12-.14.17-.25.25-.41.08-.17.04-.31-.02-.43-.06-.12-.56-1.35-.76-1.85-.2-.48-.41-.42-.56-.43h-.48c-.17 0-.43.06-.66.31-.23.25-.87.85-.87 2.06s.89 2.39 1.02 2.56c.12.17 1.74 2.65 4.21 3.72.59.25 1.05.4 1.41.51.59.19 1.12.16 1.54.1.47-.07 1.47-.6 1.68-1.18.21-.58.21-1.08.14-1.18-.06-.11-.23-.17-.48-.29Z"/></svg>
            WhatsApp
        </a>
    </div>

    <div class="form-success-state" data-form-success aria-live="polite" hidden>
        <svg viewBox="0 0 24 24" aria-hidden="true" width="32" height="32"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"/><path d="m22 4-10 10-3-3"/></svg>
        <p>Got it &mdash; I'll reply within 24 hours with a practical next step, not a sales email.</p>
    </div>
</form>
