<?php

use App\Http\Controllers\AuthenticateController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\EnrollmentClassController;
use App\Http\Controllers\EntryController;
use App\Http\Controllers\HavingClassController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\SchoolClassController;
use App\Http\Controllers\SchoolController;
use App\Http\Controllers\StudentController;
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

// 教師
Route::prefix('teacher')->group(function () {
    // ログイン
    Route::get('login/google', [AuthenticateController::class, 'getOAuthUrl']);
    Route::post('login/google/callback', [AuthenticateController::class, 'handleGoogleCallback']);
    Route::middleware(['auth:sanctum'])->group(function () {
        // ホーム
        Route::get('/', [HomeController::class, 'index']);
        // 生徒情報管理
        Route::prefix('student')->group(function () {
            Route::get('/', [StudentController::class, 'index']);
            Route::post('/', [StudentController::class, 'store']);
            Route::post('/finalize', [StudentController::class, 'finalize']);
            Route::get('/{id}', [StudentController::class, 'show']);
            Route::put('/{id}', [StudentController::class, 'update']);
            Route::delete('/{id}', [StudentController::class, 'destroy']);
        });
        // クラスや在籍生徒情報管理
        Route::prefix('class')->group(function () {
            Route::get('/{id}', [SchoolClassController::class, 'show']);
            Route::prefix('enroll')->group(function () {
                Route::post('/', [EnrollmentClassController::class, 'store']);
                Route::post('/finalize', [EnrollmentClassController::class, 'finalize']);
                Route::put('/', [EnrollmentClassController::class, 'update']);
            });
        });
        // 企業情報管理
        Route::prefix('company')->group(function () {
            Route::get('/', [CompanyController::class, 'index']);
            Route::post('/', [CompanyController::class, 'store']);
            Route::get('/{id}', [CompanyController::class, 'show']);
            Route::put('/{id}', [CompanyController::class, 'update']);
            Route::delete('/{id}', [CompanyController::class, 'destroy']);
            // 選考スケジュール管理
            Route::prefix('schedule')->group(function () {
                Route::get('/', [CompanyController::class, 'index']);
                Route::post('/', [CompanyController::class, 'store']);
                Route::put('/{id}', [CompanyController::class, 'update']);
                Route::delete('/{id}', [CompanyController::class, 'destroy']);
            });
        });
    });
});

Route::prefix('student')->group(function () {
    // ログイン
    Route::get('login/google', [AuthenticateController::class, 'getOAuthUrl']);
    Route::post('login/google/callback', [AuthenticateController::class, 'handleGoogleCallback']);
    Route::middleware(['auth:sanctum'])->group(function () {
        // ホーム
        Route::get('/', [HomeController::class, 'index']);
        // 企業情報管理
        Route::prefix('company')->group(function () {
            Route::get('/', [CompanyController::class, 'index']);
            Route::post('/', [CompanyController::class, 'store']);
            Route::get('/{id}', [CompanyController::class, 'show']);
            Route::put('/{id}', [CompanyController::class, 'update']);
            Route::delete('/{id}', [CompanyController::class, 'destroy']);
            // 選考スケジュール管理
            Route::prefix('schedule')->group(function () {
                Route::get('/', [CompanyController::class, 'index']);
                Route::post('/', [CompanyController::class, 'store']);
                Route::put('/{id}', [CompanyController::class, 'update']);
                Route::delete('/{id}', [CompanyController::class, 'destroy']);
            });
        });
        // 応募情報管理
        Route::prefix('entry')->group(function () {
            Route::post('/', [EntryController::class, 'store']);
            Route::post('/{id}', [EntryController::class, 'update']);
            Route::delete('/{id}', [EntryController::class, 'delete']);
        });
    });
});
