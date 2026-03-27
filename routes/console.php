<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');
// Schedule for checking expired memberships
Schedule::command('membership:check-expired')
    ->dailyAt('00:00')
    ->description('Check and update expired memberships and send reminders');