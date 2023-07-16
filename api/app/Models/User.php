<?php

namespace App\Models;

// use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasManyThrough;
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
     * 応募情報に関する中間テーブルの情報を取得
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
        return $this->belongsToMany(
            Company::class,
            'entries',
            'student_id',
            'company_id'
        );
    }

    /**
     * 生徒と所属しているクラスの中間テーブルの情報を取得
     *
     * @return HasMany
     */
    public function enrollmentClass(): HasMany
    {
        return $this->hasMany(EnrollmentClass::class, 'student_id');
    }

    /**
     * 過去、現在、未来の所属するクラス一覧を取得
     *
     * @return BelongsToMany
     */
    public function SchoolClass(): BelongsToMany
    {
        return $this->belongsToMany(
            SchoolClass::class,
            'enrollment_classes',
            'student_id',
            'school_class_id'
        );
    }

    /**
     * 生徒の就職活動一覧を取得
     *
     * @return HasManyThrough
     */
    public function activityStatuses(): HasManyThrough
    {
        return $this->hasManyThrough(
            ActivityStatus::class,
            Entry::class,
            'student_id',
            'entry_id'
        );
    }
}
