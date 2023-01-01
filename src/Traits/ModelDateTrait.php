<?php

namespace Mahmoudmhamed\LaravelHelpers\Traits;

use Carbon\Carbon;

trait ModelDateTrait
{
    //for update date created_at and updated_at format
    public function getCreatedAtAttribute($date): string
    {
        if ($date != null) {
            return Carbon::parse($date)->format('Y-m-d');
        }

        return Carbon::now()->format('Y-m-d');
        if ($date !== null) {
            $carbon = Carbon::parse($date);
            if ($carbon->diffInHours() < 24) {
                return $carbon->diffForHumans();
            }
            if ($carbon->diffInDays() < 7) {
                return $carbon->format('Y-m-d h:i A');
            }

            return $carbon->format('Y-m-d');
        }

        return '- - - -';
    }

    public function getUpdatedAtAttribute($date)
    {
        if ($date != null) {
            return Carbon::parse($date)->format('Y-m-d h:i A');
        }

        return $date;
    }
}
