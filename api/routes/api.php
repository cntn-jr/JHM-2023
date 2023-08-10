<?php

use App\Http\Controllers\AuthenticateController;
use App\Http\Controllers\HavingClassController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SchoolClassController;
use App\Http\Controllers\SchoolController;
use App\Http\Controllers\TeacherController;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider and all of them will
| be assigned to the "api" middleware group. Make something great!
|
*/

Route::prefix('administrator')->group(function () {
    // ログイン
    Route::get('/login', [AuthenticateController::class, 'loginAdministrator']);
    Route::middleware(['auth:sanctum'])->group(function () {
        // ホーム
        Route::get('/', [HomeController::class, 'index']);
        // 学校関連
        Route::prefix('school')->group(function () {
            Route::get('/', [SchoolController::class, 'index']);
            Route::post('/', [SchoolController::class, 'store']);
            Route::get('/{id}', [SchoolController::class, 'show']);
            Route::put('/{id}', [SchoolController::class, 'update']);
            Route::delete('/{id}', [SchoolController::class, 'destroy']);
        });
    });
});

// 学校における管理者
Route::prefix('manager')->group(function () {
    // ログイン
    Route::get('/login', [AuthenticateController::class, 'loginManager']);
    Route::middleware(['auth:sanctum'])->group(function () {
        // ホーム
        Route::get('index', [HomeController::class, 'index']);
        // 教師情報の管理
        Route::prefix('teacher')->group(function () {
            Route::get('/', [TeacherController::class, 'index']);
            Route::post('/', [TeacherController::class, 'store']);
            Route::post('/finalize', [TeacherController::class, 'finalize']);
            Route::put('/{id}', [TeacherController::class, 'update']);
            Route::delete('/{id}', [TeacherController::class, 'destroy']);
        });
        // クラス情報の管理
        Route::prefix('class')->group(function () {
            Route::get('/', [SchoolClassController::class, 'index']);
            Route::post('/', [SchoolClassController::class, 'store']);
            Route::post('/finalize', [SchoolClassController::class, 'finalize']);
            Route::put('/{id}', [SchoolClassController::class, 'update']);
            Route::delete('/{id}', [SchoolClassController::class, 'destroy']);
            // クラス担任の管理
            Route::prefix('assign')->group(function () {
                Route::post('/', [HavingClassController::class, 'store']);
                Route::post('/finalize', [HavingClassController::class, 'finalize']);
                Route::put('/{id}', [HavingClassController::class, 'update']);
                Route::delete('/{id}', [HavingClassController::class, 'destroy']);
            });
        });
    });
});
