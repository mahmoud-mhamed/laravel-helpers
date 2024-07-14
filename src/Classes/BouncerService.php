<?php

namespace App\Services;

use App\Classes\Abilities;
use Illuminate\Support\Facades\Auth;
use Silber\Bouncer\BouncerFacade as Bouncer;
class BouncerService extends BaseService
{
    /**
     * @param Abilities|string $ability
     * @return bool
     */
    public static function checkAbility(Abilities|string $ability): bool
    {
        if (!Auth::user()) {
            return false;
        }

        return Auth::user()->can($ability->value ?? $ability);
    }

    public static function refresh(): void
    {
        Bouncer::refresh();
    }
}
