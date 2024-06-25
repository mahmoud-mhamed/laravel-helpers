<?php

namespace Mahmoudmhamed\LaravelHelpers\Providers;

use Illuminate\Support\ServiceProvider;
use Mahmoudmhamed\LaravelHelpers\Commands\MakeBuilderCommand;

class PackageServiceProvider extends ServiceProvider
{
    /**
     * Bootstrap services.
     *
     * @return void
     */
    public function boot()
    {
        //publish create builder for model command
        $this->publishes([
            __DIR__.'/../Commands/MakeBuilderCommand.php' => app_path('Console/Commands/MakeBuilderCommand.php'),
        ], 'command-create-builder');

        //publish create enum
        $this->publishes([
            __DIR__.'/../Traits/EnumOptionsTrait.php' => app_path('Traits/EnumOptionsTrait.php'),
            __DIR__.'/../Commands/MakeEnumCommand.php' => app_path('Console/Commands/MakeEnumCommand.php'),
        ], 'command-create-enum');
    }

    /**
     * Register any application services.
     *
     * @return void
     */
    public function register(): void
    {
        /*$this->mergeConfigFrom(
            __DIR__.'/../../config/helpers.php', 'helpers'
        );*/
    }
}
