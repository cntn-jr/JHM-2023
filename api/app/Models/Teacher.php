<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Teacher extends User
{
    use HasFactory;

    protected $table = 'users';

    public function school(): BelongsTo
    {
        return $this->belongsTo(Manager::class);
    }
}
