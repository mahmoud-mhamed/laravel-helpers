<?php

namespace Mahmoudmhamed\LaravelHelpers\Traits;

use Carbon\Carbon;

trait ModelDateTextTrait
{
    //for update date created_at and updated_at format
    public function getCreatedAtTextAttribute($date): ?string
    {
        return $this->getDate($date);
    }

    public function getUpdatedAtTextAttribute($date): ?string
    {
        return $this->getDate($date);
    }

    public function getDeletedAtTextAttribute($date): ?string
    {
        return $this->getDate($date);
    }

    private function getDate($date): ?string
    {
        if (! $date) {
            return config('helpers.model_date_trait.null_value');
        }
        $carbon = Carbon::parse($date);
        if (config('helpers.model_date_trait.format_diff_for_human_when_less_than_or_equal_hour') !== null &&
            $carbon->diffInHours() < config('helpers.model_date_trait.format_diff_for_human_when_less_than_or_equal_hour')) {
            return $carbon->diffForHumans();
        }

        if (config('helpers.model_date_trait.format_diff_in_day_grater_than.value') !== null &&
            $carbon->diffInDays() < config('helpers.model_date_trait.format_diff_in_day_grater_than.value')) {
            return $carbon->format(config('helpers.model_date_trait.format_diff_in_day_grater_than.format'));
        }

        return $carbon->format(config('helpers.model_date_trait.format'));
    }
}
