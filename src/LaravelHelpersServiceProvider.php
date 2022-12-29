<?php

namespace Mahmoudmhamed\LaravelHelpers;

use Mahmoudmhamed\LaravelHelpers\Commands\LaravelHelpersCommand;
use Spatie\LaravelPackageTools\Package;
use Spatie\LaravelPackageTools\PackageServiceProvider;

class LaravelHelpersServiceProvider extends PackageServiceProvider
{
    public function configurePackage(Package $package): void
    {
        /*
         * This class is a Package Service Provider
         *
         * More info: https://github.com/spatie/laravel-package-tools
         */
        $package
            ->name('laravel-helpers')
            ->hasConfigFile()
            ->hasViews()
            ->hasMigration('create_laravel-helpers_table')
            ->hasCommand(LaravelHelpersCommand::class);
    }
}
