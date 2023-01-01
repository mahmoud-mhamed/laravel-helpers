<?php

namespace Mahmoudmhamed\LaravelHelpers\Traits;

use Carbon\Carbon;

trait ModelDateTrait
{
    //for update date created_at and updated_at format
    public function getCreatedAtAttribute($date): ?string
    {
        return $this->getDate($date);
    }

    public function getUpdatedAtAttribute($date): ?string
    {
        return $this->getDate($date);
    }

    private function getDate($date): ?string
    {
        if (! $date) {
            return config('helpers.ModelTrait.nullValue');
        }
        $carbon = Carbon::parse($date);
        if (config('helpers.ModelTrait.viewInDiffForHumanIfLessThanOrEqual') !== null &&
            $carbon->diffInHours() < config('helpers.ModelTrait.viewInDiffForHumanIfLessThanOrEqual')) {
            return $carbon->diffForHumans();
        }

        if (config('helpers.ModelTrait.formatIfDiffInDayGreaterThan.value') !== null &&
            $carbon->diffInDays() < config('helpers.ModelTrait.formatIfDiffInDayGreaterThan.value')) {
            return $carbon->format(config('helpers.ModelTrait.formatIfDiffInDayGreaterThan.format'));
        }

        return $carbon->format(config('helpers.ModelTrait.format'));
    }
}
