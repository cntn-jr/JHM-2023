<?php

namespace App\Providers;

use App\Models\Teacher;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\ServiceProvider;

class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     */
    public function register(): void
    {
    }

    /**
     * Bootstrap any application services.
     */
    public function boot(): void
    {
        Validator::extend('hiragana', function ($attribute, $value, $parameter) {
            return preg_match('/^[あ-ん]+$/u', $value);
        });

        Validator::extend('password', function ($attribute, $value, $parameter) {

            // アルファベットの大文字、小文字、数字が必ず１つ含まれているかつ文字数は8~32
            return preg_match('/[a-z]/u', $value)
                && preg_match('/[A-Z]/u', $value)
                && preg_match('/[0-9]/u', $value)
                && preg_match('/^[a-zA-Z0-9]{8,32}$/u', $value);
        });

        // 教師IDの存在確認
        Validator::extend('is_teacher', function ($attribute, $value, $parameter) {
            return Teacher::query()->where('id', $value)->exists();
        });
    }
}
