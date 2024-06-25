<?php

namespace App\Traits;

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
        if (!$date) {
            return '---';
        }
        $carbon = Carbon::parse($date);
        if ($carbon->diffInHours() < 24) {
            return $carbon->diffForHumans();
        }

        if ($carbon->diffInDays() < 7) {
            return $carbon->format('Y-m-d h:i A');
        }

        return $carbon->format('Y-m-d');
    }
}
