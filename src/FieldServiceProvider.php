<?php

namespace Mohamed7sameer\TextAiField;

use Illuminate\Support\ServiceProvider;
use Laravel\Nova\Events\ServingNova;
use Laravel\Nova\Nova;

class FieldServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Nova::serving(function (ServingNova $event) {
            Nova::mix('text-ai-field', __DIR__.'/../dist/mix-manifest.json');
        });
    }

    /**
     * Register any application services.
     */
    public function register(): void
    {
        //
    }
}
