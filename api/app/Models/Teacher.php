<?php

namespace App\Models;

use App\Const\Role;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Teacher extends User
{
    use HasFactory;

    protected $table = 'users';

    protected $attributes = [
        'role' => Role::TEACHER,
    ];

    public function school(): BelongsTo
    {
        return $this->belongsTo(Manager::class);
    }

    public function companies(): HasMany
    {
        return $this->hasMany(Company::class, 'user_id');
    }

    public function scopeRole(Builder $query): void
    {
        $query->where('role', Role::TEACHER);
    }
}
