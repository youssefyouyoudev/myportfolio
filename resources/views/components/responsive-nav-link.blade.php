@props(['active'])

@php
$classes = ($active ?? false)
            ? 'block w-full rounded-lg border px-3 py-2 text-start text-sm font-medium text-[var(--text-strong)] border-[var(--border)] bg-[rgba(36,50,76,0.55)] transition'
            : 'block w-full rounded-lg border border-transparent px-3 py-2 text-start text-sm font-medium text-[var(--muted)] hover:border-[var(--border)] hover:bg-[rgba(36,50,76,0.35)] hover:text-[var(--text-strong)] transition';
@endphp

<a {{ $attributes->merge(['class' => $classes]) }}>
    {{ $slot }}
</a>
