<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Company extends Model
{
    use HasFactory;

    /**
     * 企業の応募されている情報を取得
     *
     * @return HasMany
     */
    public function entries(): HasMany
    {
        return $this->hasMany(Entry::class);
    }

    /**
     * 応募している生徒情報を取得
     *
     * @return BelongsToMany
     */
    public function entryStudents(): BelongsToMany
    {
        return $this->belongsToMany(User::class, 'entries', 'company_id', 'user_id');
    }
}
