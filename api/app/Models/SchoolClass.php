<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

class SchoolClass extends Model
{
    use HasFactory;

    /**
     * 生徒と所属クラスの中間テーブルの情報を取得
     *
     * @return HasMany
     */
    public function enrollmentClass(): HasMany
    {
        return $this->hasMany(EnrollmentClass::class, 'school_class_id');
    }

    /**
     * 所属している生徒を取得
     *
     * @return BelongsToMany
     */
    public function students(): BelongsToMany
    {
        return $this->belongsToMany(
            User::class,
            'enrollment_classes',
            'school_class_id',
            'student_id'
        );
    }
}
