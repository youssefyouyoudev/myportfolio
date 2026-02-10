<?php

namespace App\Http\Controllers;

use App\Models\Post;
use App\Models\Project;
use App\Models\Service;
use Illuminate\View\View;

class SiteController extends Controller
{
    public function home(): View
    {
        $locale = app()->getLocale();

        return view('pages.home', [
            'services' => Service::published()->limit(3)->get(),
            'projects' => Project::published()->orderByDesc('published_at')->limit(9)->get(),
            'posts' => Post::published()->orderByDesc('published_at')->limit(3)->get(),
            'locale' => $locale,
            'skills' => __('home.skills.groups'),
        ]);
    }

    public function about(): View
    {
        return view('pages.about');
    }
}
