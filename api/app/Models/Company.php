<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Company extends Model
{
    use HasFactory;

    /**
     * 応募に関する中間テーブルの情報を取得
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
        return $this->belongsToMany(
            User::class,
            'entries',
            'company_id',
            'student_id'
        );
    }

    /**
     * 指定した学校で絞り込む
     *
     * @param Builder $query
     * @param integer $school_id
     * @return void
     */
    public function scopeSchool(Builder $query, int $school_id): void
    {
        $query->where('school_id', $school_id);
    }
}
