<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;

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
     * @return HasManyThrough
     */
    public function entryStudents(): HasManyThrough
    {
        return $this->hasManyThrough(User::class, Entry::class, 'company_id', 'student_id');
    }
}
