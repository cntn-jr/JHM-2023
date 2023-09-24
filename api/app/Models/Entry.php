<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Entry extends Model
{
    use HasFactory;

    /**
     * 応募した生徒情報を取得
     *
     * @return BelongsTo
     */
    public function students(): BelongsTo
    {
        return $this->belongsTo(User::class, 'student_id');
    }

    /**
     * 応募されている企業情報を取得
     *
     * @return BelongsTo
     */
    public function companies(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }

    /**
     * 就活状況を取得
     *
     * @return HasMany
     */
    public function activityStatuses(): HasMany
    {
        return $this->hasMany(ActivityStatus::class);
    }
}
