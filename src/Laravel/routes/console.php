<?php

declare(strict_types=1);

use Illuminate\Support\Facades\Artisan;

/*
|--------------------------------------------------------------------------
| Console Routes
|--------------------------------------------------------------------------
|
| This file is where you may define all of your Closure based console
| commands. Each Closure is bound to a command instance allowing a
| simple approach to interacting with each command's IO methods.
|
 */
// * * * * * php /path/to/artisan schedule:run >> /dev/null 2>&1
Schedule::command('mf-invoice:sync-database')->hourly();
