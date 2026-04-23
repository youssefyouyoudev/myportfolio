@props([
    'project',
    'compact' => false,
    'loading' => 'lazy',
    'eager' => false,
])

<div class="case-study-frame">
    @if(isset($project['media']['logo']['src']))
        <div class="case-study-logo-surface">
            <img
                src="{{ $project['media']['logo']['src'] }}"
                alt="{{ $project['media']['logo']['alt'] }}"
                loading="{{ $eager ? 'eager' : 'lazy' }}"
                @if($eager) fetchpriority="high" @endif
            >
        </div>
    @endif

    @if(isset($project['media']['cover']['src']))
        <div @class(['case-study-image', 'compact' => $compact])>
            <img
                src="{{ $project['media']['cover']['src'] }}"
                alt="{{ $project['media']['cover']['alt'] }}"
                loading="{{ $loading }}"
                @if($eager) fetchpriority="high" @endif
            >
        </div>
    @else
        <div class="case-study-placeholder case-study-placeholder-{{ $project['media']['theme'] ?? 'default' }}">
            <div class="placeholder-window">
                <span></span>
                <span></span>
                <span></span>
            </div>
            @if($compact)
                <div class="placeholder-table">
                    <span></span>
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
            @else
                <div class="placeholder-chart">
                    <i></i><i></i><i></i><i></i>
                </div>
                <div class="placeholder-list">
                    <span></span>
                    <span></span>
                    <span></span>
                </div>
            @endif
        </div>
    @endif
</div>
