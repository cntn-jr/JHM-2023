<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasMany;

class Department extends Model
{
    use HasFactory;

    public function school() :BelongsTo
    {
        return $this->belongsTo(School::class);
    }

    public function departmentHeads() :HasMany
    {
        return $this->hasMany(DepartmentHead::class);
    }
}
