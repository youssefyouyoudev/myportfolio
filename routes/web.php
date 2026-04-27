<?php

use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\ContactMessageController as AdminContactMessageController;
use App\Http\Controllers\Admin\LeadController as AdminLeadController;
use App\Http\Controllers\Admin\LeadFinderController as AdminLeadFinderController;
use App\Http\Controllers\Admin\PostController as AdminPostController;
use App\Http\Controllers\Admin\ProjectController as AdminProjectController;
use App\Http\Controllers\Admin\ServiceController as AdminServiceController;
use App\Http\Controllers\Admin\TestimonialController as AdminTestimonialController;
use App\Http\Controllers\BlogController;
use App\Http\Controllers\ContactController;
use App\Http\Controllers\ProjectController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ServiceController;
use App\Http\Controllers\SiteController;
use Illuminate\Support\Facades\Route;

Route::get('/admin', function () {
    return redirect()->route('admin.dashboard', ['locale' => app()->getLocale()]);
});

Route::get('/admin/dashboard', function () {
    return redirect()->route('admin.dashboard', ['locale' => app()->getLocale()]);
});

Route::middleware('setLocale')->prefix('{locale?}')
    ->where(['locale' => 'en|fr|ar|es|de'])
    ->group(function (): void {
        Route::get('/', [SiteController::class, 'home'])->name('home');
        Route::get('/about', [SiteController::class, 'about'])->name('about');
        Route::get('/skills', [SiteController::class, 'skills'])->name('skills');
        Route::get('/expertise', [SiteController::class, 'skills'])->name('expertise');
        Route::get('/tech-stack', [SiteController::class, 'sitePage'])->defaults('slug', 'tech-stack')->name('tech-stack');
        Route::get('/experience', [SiteController::class, 'experience'])->name('experience');
        Route::get('/resume', [SiteController::class, 'resume'])->name('resume');
        Route::get('/industries', [SiteController::class, 'sitePage'])->defaults('slug', 'industries')->name('industries');
        Route::get('/process', [SiteController::class, 'sitePage'])->defaults('slug', 'process')->name('process.page');
        Route::get('/trust', [SiteController::class, 'sitePage'])->defaults('slug', 'trust')->name('trust');
        Route::get('/faq', [SiteController::class, 'sitePage'])->defaults('slug', 'faq')->name('faq');
        Route::get('/availability', [SiteController::class, 'sitePage'])->defaults('slug', 'availability')->name('availability');
        Route::get('/hire-me', [SiteController::class, 'sitePage'])->defaults('slug', 'availability')->name('hire-me');
        Route::get('/privacy-policy', [SiteController::class, 'sitePage'])->defaults('slug', 'privacy-policy')->name('privacy-policy');
        Route::get('/terms-of-service', [SiteController::class, 'sitePage'])->defaults('slug', 'terms-of-service')->name('terms-of-service');
        Route::get('/developer-nador', [SiteController::class, 'location'])->defaults('slug', 'developer-nador')->name('pages.developer-nador');
        Route::get('/developer-oriental', [SiteController::class, 'location'])->defaults('slug', 'developer-oriental')->name('pages.developer-oriental');
        Route::get('/developer-morocco', [SiteController::class, 'location'])->defaults('slug', 'developer-morocco')->name('pages.developer-morocco');
        Route::get('/{slug}', [SiteController::class, 'location'])
            ->where('slug', 'developer-nador|developer-oriental|developer-morocco')
            ->name('pages.location');

        Route::get('/services', [ServiceController::class, 'index'])->name('services.index');
        Route::get('/services/{service}', [ServiceController::class, 'show'])->name('services.show');

        Route::get('/projects', [ProjectController::class, 'index'])->name('projects.index');
        Route::get('/projects/{project}', [ProjectController::class, 'show'])->name('projects.show');

        Route::get('/blog', [BlogController::class, 'index'])->name('blog.index');
        Route::get('/blog/{slug}', [BlogController::class, 'show'])->name('blog.show');

        Route::get('/contact', [ContactController::class, 'create'])->name('contact.create');
        Route::post('/contact', [ContactController::class, 'store'])->name('contact.store');

        Route::get('/dashboard', function () {
            return redirect()->route('admin.dashboard', ['locale' => app()->getLocale()]);
        })->middleware(['auth', 'verified'])->name('dashboard');

        Route::middleware('auth')->group(function () {
            Route::get('/profile', [ProfileController::class, 'edit'])->name('profile.edit');
            Route::patch('/profile', [ProfileController::class, 'update'])->name('profile.update');
            Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
        });

        Route::prefix('admin')
            ->middleware(['auth', 'verified', 'admin'])
            ->name('admin.')
            ->group(function (): void {
                Route::get('/', [AdminDashboardController::class, 'index'])->name('dashboard');
                Route::resource('messages', AdminContactMessageController::class)
                    ->parameters(['messages' => 'message'])
                    ->only(['index', 'show', 'destroy']);
                Route::patch('messages/{message}/toggle-read', [AdminContactMessageController::class, 'toggleRead'])
                    ->name('messages.toggle-read');
                Route::resource('leads', AdminLeadController::class)
                    ->parameters(['leads' => 'lead']);
                Route::patch('leads/{lead}/review', [AdminLeadController::class, 'review'])->name('leads.review');
                Route::patch('leads/{lead}/mark-hot', [AdminLeadController::class, 'markHot'])->name('leads.mark-hot');
                Route::get('lead-finder', [AdminLeadFinderController::class, 'index'])->name('lead-finder.index');
                Route::post('lead-finder/search', [AdminLeadFinderController::class, 'search'])->name('lead-finder.search');
                Route::post('lead-finder/import', [AdminLeadFinderController::class, 'import'])->name('lead-finder.import');
                Route::resource('projects', AdminProjectController::class)->except(['show']);
                Route::resource('posts', AdminPostController::class)->except(['show']);
                Route::resource('services', AdminServiceController::class)->except(['show']);
                Route::resource('testimonials', AdminTestimonialController::class)->except(['show']);
            });
    });

Route::get('/sitemap.xml', [SiteController::class, 'sitemap'])->name('sitemap');

require __DIR__.'/auth.php';
