<?php

namespace App\Models;

use App\Const\Role;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class Teacher extends User
{
    use HasFactory;

    protected $table = 'users';

    protected $fillable = [
        'first_name',
        'last_name',
        'first_name_kana',
        'last_name_kana',
        'email',
        'password',
        'school_id',
    ];

    protected $attributes = [
        'role' => Role::TEACHER,
    ];

    /**
     * グローバルスコープの定義
     * 教師ロールのみに絞る
     *
     * @return void
     */
    protected static function booted() :void
    {
        static::addGlobalScope('role', function(Builder $query) {
            $query->where('role', Role::TEACHER);
        });
    }

    // 教師が勤務する学校情報
    public function school(): BelongsTo
    {
        return $this->belongsTo(Manager::class);
    }

    // 教師が作成した企業情報
    public function companies(): HasMany
    {
        return $this->hasMany(Company::class, 'user_id');
    }

    // 教師に紐づく学科情報
    public function departments(): HasManyThrough
    {
        return $this->hasManyThrough(
            Department::class,
            DepartmentHead::class,
            'teacher_id',
            'id',
            'id',
            'department_id'
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
