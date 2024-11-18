<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote')->hourly();

// Run the AutoToggleFeaturedProject job daily at 9 PM
// This will clear the featured project right after the meeting ends
Schedule::job(new \App\Jobs\AutoToggleFeaturedProject())
    ->weeklyOn(3, '21:00');
