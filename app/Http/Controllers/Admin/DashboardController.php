<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lead;
use App\Models\Post;
use App\Models\Project;
use App\Models\Service;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        return view('admin.dashboard', [
            'stats' => [
                'projects' => Project::count(),
                'posts' => Post::count(),
                'services' => Service::count(),
                'leads' => Lead::count(),
            ],
            'recentLeads' => Lead::latest()->limit(5)->get(),
            'recentProjects' => Project::latest()->limit(5)->get(),
        ]);
    }
}
