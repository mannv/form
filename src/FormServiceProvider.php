<?php

namespace Plum\Form;

use Illuminate\Support\ServiceProvider;

class FormServiceProvider extends ServiceProvider
{
    /**
     * Perform post-registration booting of services.
     *
     * @return void
     */
    public function boot()
    {
        // $this->loadTranslationsFrom(__DIR__.'/../resources/lang', 'plum');
        // $this->loadViewsFrom(__DIR__.'/../resources/views', 'plum');
        // $this->loadMigrationsFrom(__DIR__.'/../database/migrations');
        // $this->loadRoutesFrom(__DIR__.'/routes.php');

        // Publishing is only necessary when using the CLI.
        if ($this->app->runningInConsole()) {
            $this->bootForConsole();
        }
        $this->loadViewsFrom(__DIR__ . '/views', 'pform');
    }

    /**
     * Register any package services.
     *
     * @return void
     */
    public function register()
    {
        $this->mergeConfigFrom(__DIR__.'/../config/form.php', 'pform');

        // Register the service the package provides.
        $this->app->singleton('mandatory', function ($app) {
            return new Mandatory();
        });
        $this->app->singleton('pform', function ($app) {
            $form = new Form($app['html'], $app['url'], $app['view'], $app['session.store']->token(),
                $app['request']);
            return $form->setSessionStore($app['session.store']);
        });
    }

    /**
     * Get the services provided by the provider.
     *
     * @return array
     */
    public function provides()
    {
        return ['pform', 'mandatory'];
    }
    
    /**
     * Console-specific booting.
     *
     * @return void
     */
    protected function bootForConsole()
    {
        // Publishing the configuration file.
        $this->publishes([
            __DIR__.'/../config/form.php' => config_path('form.php'),
        ], 'form.config');

        // Publishing the views.
        $this->publishes([
            __DIR__.'/../resources/views' => base_path('resources/views/vendor/plum'),
        ], 'pform');

        // Publishing assets.
        /*$this->publishes([
            __DIR__.'/../resources/assets' => public_path('vendor/plum'),
        ], 'form.views');*/

        // Publishing the translation files.
        /*$this->publishes([
            __DIR__.'/../resources/lang' => resource_path('lang/vendor/plum'),
        ], 'form.views');*/

        // Registering package commands.
        // $this->commands([]);
    }
}
