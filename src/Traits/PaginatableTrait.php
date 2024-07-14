<?php

namespace App\Traits;

trait PaginatableTrait
{
    public function getPerPage()
    {
        return request('per_page') ?? 10;
    }
}
