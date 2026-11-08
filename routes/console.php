<?php

use Illuminate\Foundation\Inspiring;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Support\Facades\Schedule;

Artisan::command('inspire', function () {
    $this->comment(Inspiring::quote());
})->purpose('Display an inspiring quote');

// Recordatorio de citas: todos los días a las 6:00 pm avisa las citas de mañana.
Schedule::command('citas:recordatorios')->dailyAt('18:00');
