@php
    $resolvedMeta = array_merge($site['default_seo'], $meta ?? []);
    $image = $resolvedMeta['image'] ?? $site['social_image'];
    $imageAlt = $resolvedMeta['image_alt'] ?? $site['name'].' social preview';
@endphp

<title>{{ $resolvedMeta['title'] }}</title>
<meta name="description" content="{{ $resolvedMeta['description'] }}">
<meta name="keywords" content="{{ $resolvedMeta['keywords'] }}">
<meta name="author" content="{{ $site['name'] }}">
<meta name="robots" content="index,follow,max-snippet:-1,max-image-preview:large,max-video-preview:-1">
<meta name="theme-color" content="#050816">
<meta property="og:site_name" content="{{ $site['name'] }}">
<meta property="og:locale" content="{{ $ogLocales[$locale] ?? 'en_US' }}">
<meta property="og:title" content="{{ $resolvedMeta['title'] }}">
<meta property="og:description" content="{{ $resolvedMeta['description'] }}">
<meta property="og:type" content="{{ $resolvedMeta['type'] ?? 'website' }}">
<meta property="og:url" content="{{ url()->current() }}">
<meta property="og:image" content="{{ $image }}">
<meta property="og:image:alt" content="{{ $imageAlt }}">
@foreach($alternateLocales as $alternateLocale)
    <meta property="og:locale:alternate" content="{{ $ogLocales[$alternateLocale] ?? 'en_US' }}">
@endforeach
<meta name="twitter:card" content="summary_large_image">
<meta name="twitter:title" content="{{ $resolvedMeta['title'] }}">
<meta name="twitter:description" content="{{ $resolvedMeta['description'] }}">
<meta name="twitter:image" content="{{ $image }}">
<meta name="twitter:image:alt" content="{{ $imageAlt }}">
<link rel="canonical" href="{{ url()->current() }}">
@foreach($alternateLocales as $alternateLocale)
    <link rel="alternate" hreflang="{{ $alternateLocale }}" href="{{ route(\Illuminate\Support\Facades\Route::currentRouteName() ?? 'home', array_filter(array_merge(request()->route()?->parameters() ?? [], ['locale' => $alternateLocale]))) }}">
@endforeach
<link rel="alternate" hreflang="x-default" href="{{ route('home', ['locale' => 'en']) }}">
<link rel="icon" href="{{ asset('images/brand-mark.png') }}">
@foreach(($resolvedMeta['schema'] ?? []) as $schema)
    <script type="application/ld+json">{!! json_encode($schema, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES) !!}</script>
@endforeach
