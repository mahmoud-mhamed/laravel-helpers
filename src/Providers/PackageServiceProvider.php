<?php

namespace Mahmoudmhamed\LaravelHelpers\Providers;

use Illuminate\Support\ServiceProvider;
use Mahmoudmhamed\LaravelHelpers\Commands\MakeBaseModelCommand;
use Mahmoudmhamed\LaravelHelpers\Commands\MakeBuilderCommand;
use Mahmoudmhamed\LaravelHelpers\Commands\MakeEnumCommand;

class PackageServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        $this->loadRoutesFrom(__DIR__.'/../routes/web.php');
        $this->publishes([
            __DIR__.'/config/helpers.php' => config_path('helpers.php'),
        ]);

        // Register the command if we are using the application via the CLI
        if ($this->app->runningInConsole()) {
            $this->commands([
                MakeEnumCommand::class,
                MakeBaseModelCommand::class,
            ]);
        }

        //load translation files
        $this->loadTranslationsFrom(__DIR__.'/../Lang', 'helpers');
        $this->publishes([
            __DIR__.'/../lang' => $this->app->langPath('vendor/Lang'),
        ]);

        //publish create builder for model command
        $this->publishes([
            __DIR__.'/../Commands/MakeBuilderCommand.php' => app_path('Console/Commands/MakeBuilderCommand.php'),
        ], 'command-create-builder');
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register(): void
    {
        $this->mergeConfigFrom(
            __DIR__.'/../../config/helpers.php', 'helpers'
        );
    }
}
