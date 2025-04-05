<?php

declare(strict_types=1);
namespace Grkztd\MfCloud\Misc;

use Grkztd\MfCloud\Client;
use Grkztd\MfCloud\Laravel\Console\Commands\SyncDatabase;
use Grkztd\MfCloud\Laravel\Console\Commands\SyncToken;
use Illuminate\Support\Facades\View;
use Illuminate\Support\ServiceProvider as BaseProvider;

class ServiceProvider extends BaseProvider {
    /**
     * Bootstrap the application services.
     */
    public function boot() {
        $this->publishes([
            __DIR__ . '/../Laravel/config/mf.php' => config_path('mf.php'),
        ]);
        $this->publishes([
            __DIR__ . '/../Laravel/database/migrations/' => database_path('migrations/mf-invoice'),
        ], 'mf-invoice-database');
        if ($this->app->runningInConsole()) {
            $this->loadRoutesFrom(__DIR__ . '/../Laravel/routes/console.php');
            $this->commands([
                SyncToken::class,
                SyncDatabase::class,
            ]);
        }
        View::addNamespace('mf', base_path('vendor/grkztd/mf-cloud-invoice/src/Laravel/resources/views'));
    }

    /**
     * Register the application services.
     */
    public function register() {
        $this->app->register(RouteServiceProvider::class);
        $this->app->bind('grkztd.mfcloud.invoice', function() {
            $secret = $this->app->config->get('services.mf-invoice.secret');
            return new Client($secret);
        });
    }
}
