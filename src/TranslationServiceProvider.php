<?php

namespace KLC;

use Illuminate\Support\Facades\App;
use Illuminate\Support\ServiceProvider;

class TranslationServiceProvider extends ServiceProvider
{
    public function register()
    {
        if (App::runningInConsole()) {
            $this->loadMigrationsFrom(__DIR__ . '/../database/migrations');
            $this->publishes([
                __DIR__ . '/../database/migrations' => $this->app->databasePath('migrations'),
                __DIR__ . '/../app/Models' => $this->app->basePath('app/Models')
            ], 'klc-translation');
        }
    }
}