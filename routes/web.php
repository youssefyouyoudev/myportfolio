<?php

use App\Http\Controllers\Admin\CategoryController;
use App\Http\Controllers\Admin\DashboardController as AdminDashboardController;
use App\Http\Controllers\Admin\LeadController;
use App\Http\Controllers\Admin\PostController;
use App\Http\Controllers\Admin\ProjectController as AdminProjectController;
use App\Http\Controllers\Admin\SeoMetaController;
use App\Http\Controllers\Admin\ServiceController as AdminServiceController;
use App\Http\Controllers\Admin\TagController;
use App\Http\Controllers\Admin\TaskController;
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
        Route::get('/experience', [SiteController::class, 'experience'])->name('experience');
        Route::get('/resume', [SiteController::class, 'resume'])->name('resume');
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

                Route::resource('categories', CategoryController::class)->except(['show']);
                Route::resource('tags', TagController::class)->except(['show']);
                Route::resource('services', AdminServiceController::class)->except(['show']);
                Route::resource('projects', AdminProjectController::class)->except(['show']);
                Route::resource('posts', PostController::class)->except(['show']);
                Route::resource('leads', LeadController::class)->only(['index', 'show', 'destroy']);
                Route::resource('seo', SeoMetaController::class)->except(['show']);
                Route::resource('tasks', TaskController::class)->except(['show']);
                Route::get('tasks-kanban', [TaskController::class, 'kanban'])->name('tasks.kanban');
                Route::get('tasks-gantt', [TaskController::class, 'gantt'])->name('tasks.gantt');
                Route::patch('tasks/{task}/move', [TaskController::class, 'move'])->whereNumber('task')->name('tasks.move');
            });
    });

Route::get('/sitemap.xml', [SiteController::class, 'sitemap'])->name('sitemap');

require __DIR__.'/auth.php';
