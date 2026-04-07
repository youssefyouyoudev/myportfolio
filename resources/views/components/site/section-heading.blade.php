@props([
    'eyebrow' => null,
    'title',
    'copy' => null,
    'align' => 'left',
])

<div @class([
    'section-heading',
    'text-center' => $align === 'center',
])>
    @if($eyebrow)
        <span class="eyebrow">{{ $eyebrow }}</span>
    @endif
    <h2 class="section-title">{{ $title }}</h2>
    @if($copy)
        <p class="section-copy">{{ $copy }}</p>
    @endif
</div>
