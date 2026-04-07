@php
    $site = \App\Support\BrandContent::site(app()->getLocale());
    $form = $site['form'];
@endphp

<form method="POST" action="{{ route('contact.store', ['locale' => app()->getLocale()]) }}" class="contact-form panel">
    @csrf

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
            <span>{{ $form['budget'] }}</span>
            <select name="budget">
                <option value="">{{ $form['budget_placeholder'] }}</option>
                @foreach($form['budgets'] as $budget)
                    <option value="{{ $budget }}" @selected(old('budget') === $budget)>{{ $budget }}</option>
                @endforeach
            </select>
            @error('budget')<small>{{ $message }}</small>@enderror
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
