<?php

declare(strict_types=1);
namespace Grkztd\MfCloud\Misc;

use Illuminate\Foundation\Support\Providers\RouteServiceProvider as ServiceProvider;
use Illuminate\Support\Facades\Route;

class RouteServiceProvider extends ServiceProvider {
    protected $moduleNamespace = 'Grkztd\MfCloud\Laravel\Controllers';

    public function boot() {
        parent::boot();
    }

    public function map() {
        // $this->mapApiRoutes();

        $this->mapWebRoutes();
    }

    protected function mapWebRoutes() {
        Route::middleware('web')
            ->namespace($this->moduleNamespace)
            ->group(__DIR__ . '/../Laravel/routes/web.php');
    }

    // protected function mapApiRoutes() {
    //     Route::prefix('api')
    //         ->middleware('api')
    //         ->namespace($this->moduleNamespace)
    //         ->group(__DIR__ . '/../Laravel/routes/api.php');
    // }
}
