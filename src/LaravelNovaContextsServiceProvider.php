<?php

namespace Novius\LaravelNovaContexts;

use Illuminate\Support\Facades\Route;
use Illuminate\Support\ServiceProvider;
use Laravel\Nova\Events\ServingNova;
use Laravel\Nova\Nova;

class LaravelNovaContextsServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        $this->app->booted(function () {
            $this->routes();
        });

        $this->publishes([__DIR__.'/../config' => config_path()], 'config');
        $this->publishes([__DIR__.'/../resources/lang' => lang_path('vendor/laravel-nova-contexts')], 'lang');

        $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'laravel-nova-contexts');

        $this->mergeConfigFrom(__DIR__.'/../config/context.php', 'context');

        $this->app->singleton('context_manager', function ($app) {
            return new ContextManager($app['config']['context']);
        });

        Nova::serving(function (ServingNova $event) {
            Nova::script('laravel-nova-contexts', __DIR__.'/../dist/js/card.js');

            Nova::translations(__DIR__.'/../resources/lang/'.app()->getLocale().'.json');
        });
    }

    /**
     * Register the tool's routes.
     *
     * @return void
     */
    protected function routes()
    {
        if ($this->app->routesAreCached()) {
            return;
        }

        Route::middleware(['nova:api'])
                ->prefix('nova-vendor/laravel-nova-contexts')
                ->group(__DIR__.'/../routes/api.php');
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }
}
