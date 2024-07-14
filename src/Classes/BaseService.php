<?php

namespace App\Services;

class BaseService
{
    public static function make(): BaseService
    {
        return new self();
    }
}
