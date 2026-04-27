@props([
    'project',
    'compact' => false,
    'loading' => 'lazy',
    'eager' => false,
])

<div class="case-study-frame">
    @if($project['is_nda'] ?? false)
        <div class="case-study-placeholder nda-preview case-study-placeholder-{{ $project['media']['theme'] ?? 'default' }}">
            <span class="case-badge">Under NDA - details available on request</span>
            <strong>{{ $project['title'] }}</strong>
            <p>Preview withheld to protect client confidentiality.</p>
        </div>
    @elseif(isset($project['media']['logo']['src']))
        <div class="case-study-logo-surface">
            <img
                src="{{ $project['media']['logo']['src'] }}"
                alt="{{ $project['media']['logo']['alt'] }}"
                loading="{{ $eager ? 'eager' : 'lazy' }}"
                width="320"
                height="120"
                @if($eager) fetchpriority="high" @endif
            >
        </div>
    @endif

    @if(! ($project['is_nda'] ?? false) && isset($project['media']['cover']['src']))
        <div @class(['case-study-image', 'compact' => $compact])>
            @php
                $coverSrc = $project['media']['cover']['src'];
                $webpSrc = $project['media']['cover']['webp'] ?? preg_replace('/\.(png|jpg|jpeg)$/i', '.webp', $coverSrc);
                $hasWebpVariant = ! empty($webpSrc) && is_string($coverSrc) && $webpSrc !== $coverSrc;
            @endphp
            <picture>
                @if($hasWebpVariant)
                    <source srcset="{{ $webpSrc }}" type="image/webp">
                @endif
                <img
                    src="{{ $coverSrc }}"
                    alt="{{ $project['media']['cover']['alt'] }}"
                    loading="{{ $loading }}"
                    width="1600"
                    height="900"
                    @if($eager) fetchpriority="high" @endif
                >
            </picture>
        </div>
    @elseif(! ($project['is_nda'] ?? false))
        <div class="case-study-placeholder case-study-placeholder-{{ $project['media']['theme'] ?? 'default' }}">
            <span class="case-badge">Preview coming soon</span>
            <strong>{{ $project['title'] }}</strong>
            <p>The final screenshot will be added once the production-ready capture is available.</p>
        </div>
    @endif
</div>
