@props(['items' => []])

@if(collect($items)->isNotEmpty())
    <div class="logo-placeholder-strip trusted-logo-strip" aria-label="Trusted by">
        @foreach($items as $logo)
            @php($logoLabel = $logo['name'] ?? 'Client logo')
            @if(! empty($logo['website_url']))
                <a href="{{ $logo['website_url'] }}" class="trusted-logo-item" target="_blank" rel="noopener" aria-label="{{ $logoLabel }}">
                    <img src="{{ $logo['image_path'] }}" alt="{{ $logo['alt_text'] ?? $logoLabel }}" loading="lazy" width="160" height="48">
                </a>
            @else
                <div class="trusted-logo-item">
                    <img src="{{ $logo['image_path'] }}" alt="{{ $logo['alt_text'] ?? $logoLabel }}" loading="lazy" width="160" height="48">
                </div>
            @endif
        @endforeach
    </div>
@endif
