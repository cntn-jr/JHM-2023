<?php

namespace App\Models;

use App\Const\Role;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Student extends User
{
    use HasFactory;

    protected $table = 'users';

    protected $attributes = [
        'role' => Role::STUDENT,
    ];

    /**
     * グローバルスコープの定義
     * 生徒ロールのみに絞る
     *
     * @return void
     */
    protected static function booted(): void
    {
        static::addGlobalScope(function(Builder $query) {
            $query->where('role', Role::STUDENT);
        });
    }

    public function school(): BelongsTo
    {
        return $this->belongsTo(Manager::class);
    }

    public function companies(): HasMany
    {
        return $this->hasMany(Company::class, 'user_id');
    }

    public function department(): BelongsTo
    {
        return $this->belongsTo(Student::class);
    }

    /**
     * 応募情報に関する中間テーブルの情報を取得
     *
     * @return HasMany
     */
    public function entries(): HasMany
    {
        return $this->hasMany(Entry::class);
    }

    /**
     * 学校で絞り込み
     *
     * @param Builder $query
     * @param integer $schoolId
     * @return void
     */
    public function scopeSchool(Builder $query, int $schoolId): void
    {
        $query->where('school_id', $schoolId);
    }
}
