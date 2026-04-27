<?php

use App\Jobs\GenerateRecurringTasksJob;
use App\Models\Testimonial;
use App\Models\User;
use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

Artisan::command('tasks:generate-recurring', function () {
    GenerateRecurringTasksJob::dispatch();

    $this->info('Recurring tasks queued.');
})->purpose('Queue recurring task generation');

Artisan::command('admin:grant {email}', function (string $email) {
    $user = User::where('email', $email)->first();

    if (! $user) {
        $this->error('User not found.');

        return;
    }

    $user->update(['is_admin' => true]);
    $this->info("{$user->email} is now an admin.");
})->purpose('Grant admin access to an existing user');

Artisan::command('testimonial:publish {id}', function (int $id) {
    $testimonial = Testimonial::find($id);

    if (! $testimonial) {
        $this->error('Testimonial not found.');

        return;
    }

    $testimonial->forceFill([
        'published' => true,
        'status' => 'published',
        'published_at' => $testimonial->published_at ?? now(),
    ])->save();

    $this->info("Testimonial {$testimonial->id} is now published.");
})->purpose('Publish a testimonial once the client has approved it');

Schedule::command('tasks:generate-recurring')->dailyAt('00:05');
