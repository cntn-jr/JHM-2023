<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Student extends User
{
    use HasFactory;

    protected $table = 'users';

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
}
