<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

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

    public function companies(): BelongsTo
    {
        return $this->belongsTo(Company::class);
    }
}
