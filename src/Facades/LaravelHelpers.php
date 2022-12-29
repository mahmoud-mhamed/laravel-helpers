<?php

namespace Mahmoudmhamed\LaravelHelpers\Facades;

use Illuminate\Support\Facades\Facade;

/**
 * @see \Mahmoudmhamed\LaravelHelpers\LaravelHelpers
 */
class LaravelHelpers extends Facade
{
    protected static function getFacadeAccessor()
    {
        return \Mahmoudmhamed\LaravelHelpers\LaravelHelpers::class;
    }
}
