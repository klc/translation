<?php

namespace KLC;


use Illuminate\Support\ServiceProvider;

class TranslationServiceProvider extends ServiceProvider
{
    public function register()
    {
        if($this->app->runningConsole()) {
            $this->commands([
                TranslationCommand::class,
            ]);
        }
    }
}