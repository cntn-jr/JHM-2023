<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;
use Illuminate\Database\Eloquent\Relations\HasOneThrough;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;

class User extends Authenticatable
{
    use HasApiTokens;
    use HasFactory;
    use Notifiable;

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    /**
     * The attributes that should be hidden for serialization.
     *
     * @var array<int, string>
     */
    protected $hidden = [
        'password',
        'remember_token',
    ];

    /**
     * The attributes that should be cast.
     *
     * @var array<string, string>
     */
    protected $casts = [
        'email_verified_at' => 'datetime',
        'password' => 'hashed',
    ];

    /**
     * ユーザーが作成した企業情報の取得
     *
     * @return HasMany
     */
    public function companies(): HasMany
    {
        return $this->hasMany(Company::class);
    }

    /**
     * 生徒の応募情報を取得
     *
     * @return HasMany
     */
    public function entries(): HasMany
    {
        return $this->hasMany(Entry::class, 'student_id');
    }

    /**
     * 生徒が応募した企業情報を取得
     *
     * @return BelongsToMany
     */
    public function entryCompanies(): BelongsToMany
    {
        return $this->belongsToMany(Company::class, 'entries', 'user_id', 'company_id');
    }

    /**
     * 生徒と所属しているクラスの中間テーブルの情報を取得
     *
     * @return HasOne
     */
    public function enrollmentClass(): HasOne
    {
        return $this->hasOne(EnrollmentClass::class, 'student_id');
    }

    /**
     * 所属しているクラスを取得
     *
     * @return HasOneThrough
     */
    public function SchoolClass(): HasOneThrough
    {
        return $this->hasOneThrough(
            SchoolClass::class,
            EnrollmentClass::class,
            'student_id',
            'school_class_id'
        );
    }
}
