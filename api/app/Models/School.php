<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
use Illuminate\Database\Eloquent\Relations\HasOne;

class School extends Model
{
    use HasFactory;

    public function manager(): HasOne
    {
        return $this->hasOne(Manager::class);
    }

    public function teachers(): HasMany
    {
        return $this->hasMany(Teacher::class);
    }

    public function students(): HasMany
    {
        return $this->hasMany(Student::class);
    }

    public function companies(): HasManyThrough
    {
        return $this->hasManyThrough(
            Company::class,
            User::class,
            'school_id',
            'user_id',
        );
    }

    public function departments(): HasMany
    {
        return $this->hasMany(Department::class);
    }
}
