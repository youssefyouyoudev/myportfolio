@props(['items' => []])

@if(collect($items)->isNotEmpty())
    <div class="card-grid three testimonials-grid">
        @foreach($items as $testimonial)
            @php
                $initials = collect(explode(' ', $testimonial['name']))
                    ->filter()
                    ->take(2)
                    ->map(fn ($part) => strtoupper(substr($part, 0, 1)))
                    ->implode('');
            @endphp
            <article class="panel testimonial-card" data-reveal>
                <div class="testimonial-head">
                    @if(! empty($testimonial['avatar']))
                        <img
                            src="{{ $testimonial['avatar'] }}"
                            alt="{{ $testimonial['name'] }}"
                            class="testimonial-avatar"
                            loading="lazy"
                            width="56"
                            height="56"
                        >
                    @else
                        <span class="testimonial-avatar testimonial-avatar-fallback" aria-hidden="true">{{ $initials }}</span>
                    @endif
                    <div>
                        <strong>{{ $testimonial['name'] }}</strong>
                        <span>{{ $testimonial['title'] }}</span>
                        <span>{{ $testimonial['company'] }}</span>
                    </div>
                </div>
                <p>"{{ $testimonial['quote'] }}"</p>
            </article>
        @endforeach
    </div>
@endif
