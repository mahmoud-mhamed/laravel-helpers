<?php

namespace App\Traits;

use App\Models\User;
use Illuminate\Database\Eloquent\Prunable;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

/**
 * @property-read User $createdBy
 * @property-read User $updatedBy
 * @property-read User $deletedBy
 * @property-read int $created_by_id
 * @property-read string $created_by_type
 * @property-read int $updated_by_id
 * @property-read string $updated_by_type
 * @property-read int $deleted_by_id
 * @property-read string $deleted_by_type
 */
trait MorphModelTriggerTrait
{
    use  Prunable, SoftDeletes;

    /**
     * @return BelongsTo
     */
    public function createdBy(): BelongsTo
    {
        return $this->morphTo();
    }

    /**
     * @return BelongsTo
     */
    public function updatedBy(): BelongsTo
    {
        return $this->morphTo();
    }

    /**
     * @return BelongsTo
     */
    public function deletedBy(): BelongsTo
    {
        return $this->morphTo();
    }

    protected static function booting(): void
    {
        self::morphModelTrigger();
    }

    protected static function morphModelTrigger(): void
    {
        static::creating(function ($row) {
            if (Auth::check()) {
                $row->created_by_id = Auth::check() ? Auth::id() : null;
                $row->created_by_type = Auth::check() ? Auth::user()::class : null;
            }
        });

        static::updating(function ($row) {
            $row->updated_by_id = Auth::check() ? Auth::id() : null;
            $row->updated_by_type = Auth::check() ? Auth::user()::class : null;
        });

        static::deleting(function ($row) {
            $row->update([
                'deleted_by_id' => Auth::check() ? Auth::id() : null,
                'deleted_by_type' => Auth::check() ? Auth::user()::class : null,
            ]);
        });
    }

    /**
     * Get the prunable model query.
     *
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function prunable(): \Illuminate\Database\Eloquent\Builder
    {
        return static::onlyTrashed()->where('deleted_at', '<', now()->subDays(30));
    }
}

