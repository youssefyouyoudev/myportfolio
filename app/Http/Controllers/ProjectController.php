<?php

namespace App\Http\Controllers;

use App\Models\Project;
use Illuminate\View\View;

class ProjectController extends Controller
{
    public function index(): View
    {
        $projects = Project::published()->with(['tags', 'category'])->orderByDesc('published_at')->paginate(9);

        return view('pages.projects.index', compact('projects'));
    }

    public function show(Project $project): View
    {
        $project->load(['tags', 'category']);

        return view('pages.projects.show', compact('project'));
    }
}
