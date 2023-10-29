<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Builder;
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
        return $this->belongsTo(Student::class, 'student_id');
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

    /**
     * 生徒で絞り込む
     *
     * @param Builder $query
     * @param integer $studentId
     * @return void
     */
    public function scopeStudent(Builder $query, int $studentId): void
    {
        $query->where('student_id', $studentId);
    }

    /**
     * 生徒で絞り込む
     *
     * @param Builder $query
     * @param integer $studentId
     * @return void
     */
    public function scopeResult(Builder $query, int $result): void
    {
        $query->where('result', $result);
    }
}
