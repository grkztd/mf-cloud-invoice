<?php

namespace Grkztd\MfCloud\Misc;

use Illuminate\Support\ServiceProvider as BaseProvider;
use Laravel\Socialite\Facades\Socialite;
use Grkztd\MfCloud\Providers\MoneyForwardProvider;
use Grkztd\MfCloud\Client;

class ServiceProvider extends BaseProvider{
    /**
     * Bootstrap the application services.
     *
     * @return void
     */
    public function boot(){
        Socialite::extend(
            'mf-invoice',
            function ($app) {
                return Socialite::buildProvider(MoneyForwardProvider::class, config('services.mf-invoice'));
            }
        );
        //
    }

    /**
     * Register the application services.
     *
     * @return void
     */
    public function register(){
        $this->app->bind('grkztd.mfcloud.invoice', function () {
            $secret = $this->app->config->get('services.mf-invoice.secret');
            return new Client($secret);
        });
    }
}
