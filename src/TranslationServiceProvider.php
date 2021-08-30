<?php

namespace KLC;


use Illuminate\Support\Facades\App;
use Illuminate\Support\ServiceProvider;

class TranslationServiceProvider extends ServiceProvider
{
    public function register()
    {
        if(App::runningInConsole()) {
            $this->commands([
                TranslationCommand::class,
            ]);
        }
    }
}