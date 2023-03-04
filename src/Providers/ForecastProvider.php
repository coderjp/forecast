<?php

namespace Coderjp\Forecast\Providers;

use Illuminate\Support\ServiceProvider;
use Coderjp\Forecast\Forecast;
use Coderjp\Forecast\Console\Commands\ForecastIp;

class ForecastProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        if ($this->app->runningInConsole()) {

            $this->commands([
                ForecastIp::class,
            ]);

            $this->publishes([
                __DIR__.'/../public' => public_path('vendor/forecast'),
                __DIR__.'/../config/forecast.php' => config_path('forecast.php'),
            ], 'public');
          
        }

        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');

        $this->loadViewsFrom(__DIR__.'/../resources/views', 'forecast');

        if (config('forecast.routes')) {
          
            $this->loadRoutesFrom(__DIR__.'/../routes/web.php');

        }
    }

    public function register()
    {
        $this->app->singleton('forecast', function ($app) {
            return new Forecast($app['config']);
        });
    }
}