<?php

namespace Mahmoudmhamed\LaravelHelpers;

use Mahmoudmhamed\LaravelHelpers\Commands\LaravelHelpersCommand;
use Mahmoudmhamed\LaravelHelpers\Commands\MakeBaseBuilderCommand;
use Mahmoudmhamed\LaravelHelpers\Commands\MakeBuilderCommand;
use Mahmoudmhamed\LaravelHelpers\Commands\MakeEnumCommand;
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
//            ->hasMigration('create_laravel-helpers_table')
            ->hasCommand(MakeBaseBuilderCommand::class)
            ->hasCommand(MakeEnumCommand::class)
            ->hasCommand(MakeBuilderCommand::class)
        ;
    }
}
