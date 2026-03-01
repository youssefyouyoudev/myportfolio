<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Lead;
use App\Models\Post;
use App\Models\Project;
use App\Models\Service;
use App\Models\Task;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $now = now();
        $startOfMonth = $now->copy()->startOfMonth();
        $startOfLastMonth = $now->copy()->subMonthNoOverflow()->startOfMonth();
        $endOfLastMonth = $startOfLastMonth->copy()->endOfMonth();

        $totalTasks = Task::count();
        $doneTasks = Task::where('status', Task::STATUS_DONE)->count();
        $taskCompletionRate = $totalTasks > 0 ? round(($doneTasks / $totalTasks) * 100) : 0;

        $leadsThisMonth = Lead::where('created_at', '>=', $startOfMonth)->count();
        $leadsLastMonth = Lead::whereBetween('created_at', [$startOfLastMonth, $endOfLastMonth])->count();
        $leadGrowth = $leadsLastMonth > 0
            ? round((($leadsThisMonth - $leadsLastMonth) / $leadsLastMonth) * 100)
            : ($leadsThisMonth > 0 ? 100 : 0);

        $months = collect(range(5, 0))->map(fn (int $offset) => $now->copy()->subMonths($offset))->push($now->copy());

        $leadTrend = $months->map(function (Carbon $month): array {
            $start = $month->copy()->startOfMonth();
            $end = $month->copy()->endOfMonth();

            return [
                'label' => $month->translatedFormat('M'),
                'value' => Lead::whereBetween('created_at', [$start, $end])->count(),
            ];
        })->values();

        $taskTrend = $months->map(function (Carbon $month): array {
            $start = $month->copy()->startOfMonth();
            $end = $month->copy()->endOfMonth();

            return [
                'label' => $month->translatedFormat('M'),
                'value' => Task::whereBetween('created_at', [$start, $end])->count(),
            ];
        })->values();

        $taskStatus = collect([
            Task::STATUS_TODO,
            Task::STATUS_IN_PROGRESS,
            Task::STATUS_REVIEW,
            Task::STATUS_DONE,
        ])->mapWithKeys(function (string $status): array {
            return [$status => Task::where('status', $status)->count()];
        });

        $projectStatus = Project::query()
            ->select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->pluck('total', 'status');

        $postStatus = Post::query()
            ->select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->pluck('total', 'status');

        $overdueTasks = Task::whereNotNull('due_date')
            ->whereDate('due_date', '<', today())
            ->where('status', '!=', Task::STATUS_DONE)
            ->count();

        $dueSoonTasks = Task::whereNotNull('due_date')
            ->whereBetween('due_date', [today(), today()->copy()->addDays(7)])
            ->where('status', '!=', Task::STATUS_DONE)
            ->count();

        return view('admin.dashboard', [
            'stats' => [
                'projects' => Project::count(),
                'posts' => Post::count(),
                'services' => Service::count(),
                'leads' => Lead::count(),
                'tasks' => $totalTasks,
                'projects_published' => Project::published()->count(),
                'posts_published' => Post::published()->count(),
                'leads_this_month' => $leadsThisMonth,
                'lead_growth' => $leadGrowth,
                'task_completion_rate' => $taskCompletionRate,
                'overdue_tasks' => $overdueTasks,
                'due_soon_tasks' => $dueSoonTasks,
            ],
            'taskStatus' => $taskStatus,
            'projectStatus' => $projectStatus,
            'postStatus' => $postStatus,
            'leadTrend' => $leadTrend,
            'taskTrend' => $taskTrend,
            'recentLeads' => Lead::latest()->limit(5)->get(),
            'recentProjects' => Project::latest()->limit(5)->get(),
        ]);
    }
}
