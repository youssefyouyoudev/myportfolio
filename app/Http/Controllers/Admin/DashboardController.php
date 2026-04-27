<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\ContactMessage;
use App\Models\CrmLead;
use App\Models\Post;
use App\Models\Project;
use App\Models\Service;
use App\Models\Testimonial;
use Illuminate\Support\Collection;
use Illuminate\View\View;

class DashboardController extends Controller
{
    public function index(): View
    {
        $messages = ContactMessage::query()
            ->orderByRaw('case when read_at is null then 0 else 1 end')
            ->latest()
            ->get();

        $leads = CrmLead::query()->latest('updated_at')->get();
        $projects = Project::query()->latest('published_at')->latest()->take(4)->get();
        $posts = Post::query()->latest('published_at')->latest()->take(4)->get();
        $services = Service::query()->orderByDesc('featured')->orderBy('position')->take(4)->get();
        $testimonials = Testimonial::query()->orderByDesc('featured')->orderBy('position')->latest()->take(4)->get();

        return view('admin.dashboard', [
            'crmCards' => [
                [
                    'label' => 'Contact Messages',
                    'value' => $messages->count(),
                    'copy' => 'Inbound website enquiries captured through the public contact form.',
                    'note' => ContactMessage::unread()->count().' unread / '.ContactMessage::read()->count().' read',
                    'href' => route('admin.messages.index', ['locale' => app()->getLocale()]),
                ],
                [
                    'label' => 'Leads Found Today',
                    'value' => CrmLead::query()->whereDate('found_at', today())->count(),
                    'copy' => 'Fresh businesses discovered by the lead finder and moved into the private CRM.',
                    'note' => 'Review pending leads before outreach',
                    'href' => route('admin.leads.index', ['locale' => app()->getLocale(), 'review_status' => CrmLead::REVIEW_PENDING]),
                ],
                [
                    'label' => 'Total Leads',
                    'value' => $leads->count(),
                    'copy' => 'Manual CRM records and finder results tracked in one private pipeline.',
                    'note' => CrmLead::query()->where('status', CrmLead::STATUS_NEW)->count().' new leads',
                    'href' => route('admin.leads.index', ['locale' => app()->getLocale()]),
                ],
                [
                    'label' => 'Hot Leads',
                    'value' => CrmLead::query()->where('status', CrmLead::STATUS_HOT)->count(),
                    'copy' => 'Priority opportunities that deserve faster follow-up and personal attention.',
                    'note' => 'Best fit for immediate outreach',
                    'href' => route('admin.leads.index', ['locale' => app()->getLocale(), 'status' => CrmLead::STATUS_HOT]),
                ],
                [
                    'label' => 'Contacted',
                    'value' => CrmLead::query()->where('status', CrmLead::STATUS_CONTACTED)->count(),
                    'copy' => 'Leads already contacted and waiting on the next meaningful step.',
                    'note' => 'Use notes to track momentum',
                    'href' => route('admin.leads.index', ['locale' => app()->getLocale(), 'status' => CrmLead::STATUS_CONTACTED]),
                ],
                [
                    'label' => 'Replies',
                    'value' => (int) CrmLead::sum('reply_count'),
                    'copy' => 'Replies and return engagement tracked inside the CRM.',
                    'note' => 'Update reply counts inside each lead record',
                    'href' => route('admin.leads.index', ['locale' => app()->getLocale()]),
                ],
                [
                    'label' => 'Closed',
                    'value' => CrmLead::query()->where('status', CrmLead::STATUS_CLOSED)->count(),
                    'copy' => 'Won or completed opportunities that can later become case studies or testimonials.',
                    'note' => 'Useful for proof and retention',
                    'href' => route('admin.leads.index', ['locale' => app()->getLocale(), 'status' => CrmLead::STATUS_CLOSED]),
                ],
                [
                    'label' => 'Estimated Revenue',
                    'value' => number_format((float) CrmLead::query()->where('review_status', '!=', CrmLead::REVIEW_REJECTED)->sum('estimated_revenue'), 0).' MAD',
                    'copy' => 'Visible pipeline value across pending and approved leads.',
                    'note' => 'Uses lead-level revenue estimates',
                    'href' => route('admin.leads.index', ['locale' => app()->getLocale()]),
                ],
            ],
            'agentCards' => [
                [
                    'label' => 'Lead Finder',
                    'value' => 'OSM',
                    'copy' => 'Safe-source lead discovery powered by city, category, country, and online presence scoring.',
                    'note' => 'OpenStreetMap / Overpass + website checks',
                    'href' => route('admin.lead-finder.index', ['locale' => app()->getLocale()]),
                ],
            ],
            'contentCards' => [
                [
                    'label' => 'Projects',
                    'value' => Project::count(),
                    'copy' => 'Case studies, product showcases, and flagship portfolio work.',
                    'note' => Project::published()->count().' published / '.Project::query()->where('featured', true)->count().' featured',
                    'href' => route('admin.projects.index', ['locale' => app()->getLocale()]),
                ],
                [
                    'label' => 'Blog Posts',
                    'value' => Post::count(),
                    'copy' => 'Insights, SEO articles, and authority-building editorial content.',
                    'note' => Post::published()->count().' published / '.Post::query()->where('featured', true)->count().' featured',
                    'href' => route('admin.posts.index', ['locale' => app()->getLocale()]),
                ],
                [
                    'label' => 'Services',
                    'value' => Service::count(),
                    'copy' => 'Offer pages and solution-led positioning for premium service packages.',
                    'note' => Service::published()->count().' published / '.Service::query()->where('featured', true)->count().' featured',
                    'href' => route('admin.services.index', ['locale' => app()->getLocale()]),
                ],
                [
                    'label' => 'Testimonials',
                    'value' => Testimonial::count(),
                    'copy' => 'Proof assets from clients, operators, or project stakeholders.',
                    'note' => Testimonial::published()->count().' published / '.Testimonial::query()->where('featured', true)->count().' featured',
                    'href' => route('admin.testimonials.index', ['locale' => app()->getLocale()]),
                ],
            ],
            'recentMessages' => $messages->take(5),
            'recentLeads' => $leads->take(5),
            'latestContent' => [
                [
                    'label' => 'Recent projects',
                    'items' => $this->mapCollection($projects, fn (Project $project): array => [
                        'title' => $project->title,
                        'meta' => ucfirst($project->status).' / '.$project->slug,
                        'href' => route('admin.projects.edit', ['locale' => app()->getLocale(), 'project' => $project]),
                    ]),
                    'empty' => 'No projects yet.',
                ],
                [
                    'label' => 'Recent posts',
                    'items' => $this->mapCollection($posts, fn (Post $post): array => [
                        'title' => $post->title,
                        'meta' => ucfirst($post->status).' / '.$post->slug,
                        'href' => route('admin.posts.edit', ['locale' => app()->getLocale(), 'post' => $post]),
                    ]),
                    'empty' => 'No blog posts yet.',
                ],
                [
                    'label' => 'Recent services',
                    'items' => $this->mapCollection($services, fn (Service $service): array => [
                        'title' => $service->title,
                        'meta' => ucfirst($service->status).' / Position '.($service->position ?: 1),
                        'href' => route('admin.services.edit', ['locale' => app()->getLocale(), 'service' => $service]),
                    ]),
                    'empty' => 'No services yet.',
                ],
                [
                    'label' => 'Recent testimonials',
                    'items' => $this->mapCollection($testimonials, fn (Testimonial $testimonial): array => [
                        'title' => $testimonial->name,
                        'meta' => ($testimonial->company ?: 'Independent').' / '.ucfirst($testimonial->status),
                        'href' => route('admin.testimonials.edit', ['locale' => app()->getLocale(), 'testimonial' => $testimonial]),
                    ]),
                    'empty' => 'No testimonials yet.',
                ],
            ],
            'foundation' => [
                'Admin CRUD is now active for projects, blog posts, services, testimonials, messages, and CRM leads.',
                'Website submissions are separated into a private contact messages inbox.',
                'The lead finder can search safe OSM sources, score prospects, and save pending-review leads into CRM.',
            ],
        ]);
    }

    private function mapCollection(Collection $items, callable $mapper): array
    {
        return $items->map($mapper)->values()->all();
    }
}
