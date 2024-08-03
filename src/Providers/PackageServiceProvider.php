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
            __DIR__.'/../Classes/BaseBuilder.php' => app_path('Models/Builders/BaseBuilder.php'),
            __DIR__.'/../Commands/MakeBuilderCommand.php' => app_path('Console/Commands/MakeBuilderCommand.php'),
        ], 'command-create-builder');

        //publish create enum
        $this->publishes([
            __DIR__.'/../Traits/EnumOptionsTrait.php' => app_path('Traits/EnumOptionsTrait.php'),
            __DIR__.'/../Traits/EnumCastAppendAttributeTrait.php' => app_path('Traits/EnumCastAppendAttributeTrait.php'),
            __DIR__.'/../Commands/MakeEnumCommand.php' => app_path('Console/Commands/MakeEnumCommand.php'),
        ], 'command-create-enum');

        //publish PaginatableTrait
        $this->publishes([
            __DIR__.'/../Traits/PaginatableTrait.php' => app_path('Traits/PaginatableTrait.php'),
        ], 'paginatable-trait');

        $this->publishes([
            __DIR__.'/../Traits/UseTranslationsTrait.php' => app_path('Traits/UseTranslationsTrait.php'),
        ], 'model-column-translation-trait');

        //publish base model
        $this->publishes([
            __DIR__.'/../Classes/BaseModel.php' => app_path('Models/BaseModel.php'),
        ], 'base-model');

        //publish date text trait
        $this->publishes([
            __DIR__.'/../Traits/ModelDateTextTrait.php' => app_path('Traits/ModelDateTextTrait.php'),
        ], 'date-text-trait');

        //publish morph model trigger trait
        $this->publishes([
            __DIR__.'/../Traits/MorphModelTriggerTrait.php' => app_path('Traits/MorphModelTriggerTrait.php'),
        ], 'morph-model-trigger-trait');

        $this->publishes([
            __DIR__.'/../Classes/BaseService.php' => app_path('Services/BaseService.php'),
            __DIR__.'/../Commands/MakeServiceCommand.php' => app_path('Console/Commands/MakeServiceCommand.php'),
        ], 'command-make-service');

        $this->publishes([
            __DIR__.'/../Classes/BouncerService.php' => app_path('Services/BouncerService.php'),
        ], 'bouncer-service');


        $this->publishes([
            __DIR__.'/../Commands/TransLangFilesCommand.php' => app_path('Console/Commands/TransLangFilesCommand.php'),
        ], 'trans-lang-file-command');
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
