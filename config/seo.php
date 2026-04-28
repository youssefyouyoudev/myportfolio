<?php

/**
 * Centralized SEO configuration.
 *
 * These values are the canonical source of truth for the site's default
 * meta tags. BrandContent::landing() references them directly.
 * Individual pages can override via the $seo variable passed to layouts/app.blade.php.
 */

return [

    /*
    |--------------------------------------------------------------------------
    | Site Identity
    |--------------------------------------------------------------------------
    */
    'site_name'   => 'Youssef Youyou',
    'author'      => 'Youssef Youyou',
    'locale'      => 'en',

    /*
    |--------------------------------------------------------------------------
    | Canonical URL
    |--------------------------------------------------------------------------
    | Always non-www. Used for hreflang x-default and og:url fallback.
    */
    'canonical_base' => 'https://youssefyouyou.com',

    /*
    |--------------------------------------------------------------------------
    | Default Page Title (≤ 580px / ~60 chars)
    |--------------------------------------------------------------------------
    */
    'title' => 'Youssef Youyou — Full-Stack Developer | Morocco',

    /*
    |--------------------------------------------------------------------------
    | Default Meta Description (≤ 1000px / ~155 chars)
    |--------------------------------------------------------------------------
    */
    'description' => 'Full-Stack Developer in Morocco. Web, mobile & desktop apps. 6+ years, 20+ products shipped. Available now.',

    /*
    |--------------------------------------------------------------------------
    | Default Keywords
    |--------------------------------------------------------------------------
    */
    'keywords' => 'full-stack developer Morocco, web mobile desktop developer Morocco, Laravel React Flutter developer, AI automation developer Morocco, developer Nador',

    /*
    |--------------------------------------------------------------------------
    | Supported Locales & hreflang
    |--------------------------------------------------------------------------
    | Each locale maps to its route prefix. x-default always points to the
    | bare canonical URL (no locale prefix).
    */
    'locales' => ['en', 'fr', 'ar', 'es', 'de'],

    'hreflang' => [
        'en'        => 'https://youssefyouyou.com/en',
        'fr'        => 'https://youssefyouyou.com/fr',
        'ar'        => 'https://youssefyouyou.com/ar',
        'es'        => 'https://youssefyouyou.com/es',
        'de'        => 'https://youssefyouyou.com/de',
        'x-default' => 'https://youssefyouyou.com',
    ],

    /*
    |--------------------------------------------------------------------------
    | Open Graph Defaults
    |--------------------------------------------------------------------------
    */
    'og' => [
        'type'  => 'website',
        'image' => '/images/youyou-portrait.png', // relative — asset() wraps it
    ],

    /*
    |--------------------------------------------------------------------------
    | Twitter Card Defaults
    |--------------------------------------------------------------------------
    */
    'twitter' => [
        'card' => 'summary_large_image',
    ],

    /*
    |--------------------------------------------------------------------------
    | Robots
    |--------------------------------------------------------------------------
    */
    'robots' => 'index,follow,max-snippet:-1,max-image-preview:large,max-video-preview:-1',

    /*
    |--------------------------------------------------------------------------
    | www Redirect
    |--------------------------------------------------------------------------
    | ForceNonWww middleware uses this as the redirect target base.
    | Keep in sync with canonical_base above.
    */
    'force_non_www' => true,

];
