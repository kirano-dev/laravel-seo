<?php

namespace KiranoDev\LaravelSeo\Providers;

use Illuminate\Support\Facades\Blade;
use Illuminate\Support\ServiceProvider;

class LaravelSeoServiceProvider extends ServiceProvider
{
    public function register()
    {

    }

    public function boot(): void
    {
        $this->loadRoutesFrom(__DIR__.'/../routes/seo.php');
        $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        $this->loadViewsFrom(__DIR__.'/../resources/views', 'seo');

        $this->publishes([
            __DIR__.'/../config/seo.php' => config_path('seo.php'),
        ]);

        $this->mergeConfigFrom(
            __DIR__.'/../config/seo.php', 'seo'
        );

        Blade::componentNamespace('KiranoDev\\LaravelSeo\\View\\Components', 'seo');
    }
}