@props([
    'title',
    'copy',
    'primaryLabel' => null,
    'primaryUrl' => null,
    'secondaryLabel' => null,
    'secondaryUrl' => null,
])

@php
    $site = \App\Support\BrandContent::site(app()->getLocale());
@endphp

<div class="section-cta">
    <div>
        <h3>{{ $title }}</h3>
        <p>{{ $copy }}</p>
    </div>
    <div class="cta-actions">
        <a href="{{ $primaryUrl ?? route('contact.create', ['locale' => app()->getLocale()]) }}" class="btn btn-primary">{{ $primaryLabel ?? $site['actions']['contact_me'] }}</a>
        <a href="{{ $secondaryUrl ?? $site['whatsapp_url'] }}" class="btn btn-secondary" target="_blank" rel="noopener">{{ $secondaryLabel ?? $site['actions']['whatsapp'] }}</a>
    </div>
</div>
