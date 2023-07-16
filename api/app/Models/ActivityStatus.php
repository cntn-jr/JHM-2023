<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;

class ActivityStatus extends Model
{
    use HasFactory;

    /**
     * 対応する応募情報を取得
     *
     * @return BelongsTo
     */
    public function entry(): BelongsTo
    {
        return $this->belongsTo(Entry::class);
    }

    /**
     * このアクティビティを持つ生徒を取得
     *
     * @return HasOneThrough
     */
    public function student(): HasOneThrough
    {
        return $this->hasOneThrough(
            User::class,
            Entry::class,
            'id',
            'id',
            'entry_id',
            'student_id'
        );
    }

    /**
     * このアクティビティの対象となっている企業を取得
     *
     * @return HasOneThrough
     */
    public function company(): HasOneThrough
    {
        return $this->hasOneThrough(
            Company::class,
            Entry::class,
            'id',
            'id',
            'entry_id',
            'company_id'
        );
    }
}
