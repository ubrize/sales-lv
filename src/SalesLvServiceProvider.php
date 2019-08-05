<?php

namespace Ubrize\SalesLv;

use Illuminate\Support\ServiceProvider;

class SalesLvServiceProvider extends ServiceProvider
{
    public function register()
    {
        $this->app->singleton(SalesLvApi::class, function ($app) {
            return new SalesLvApi($app['config']['services.saleslv']);
        });
    }
}
