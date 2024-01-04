<?php

use App\Http\Controllers\AuthenticateController;
use App\Http\Controllers\CompanyController;
use App\Http\Controllers\EnrollmentClassController;
use App\Http\Controllers\EntryController;
use App\Http\Controllers\DepartmentHeadController;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\DepartmentController;
use App\Http\Controllers\SchoolController;
use App\Http\Controllers\SelectionScheduleController;
use App\Http\Controllers\StudentController;
use App\Http\Controllers\TeacherController;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Auth;
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

Route::get('/user', function () {
    if (App::environment('local')) {
        return response()->ApiSuccess(contents: Auth::user());
    }
    abort(404);
});

Route::post('/logout', [AuthenticateController::class, 'logout']);

Route::prefix('administrator')->group(function () {
    // ログイン
    Route::get('/login', [AuthenticateController::class, 'loginAdministrator']);
    Route::middleware(['auth:sanctum'])->group(function () {
        // ホーム
        Route::get('/home', [HomeController::class, 'administrator']);
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
    Route::post('/login', [AuthenticateController::class, 'loginManager']);
    Route::middleware(['auth:sanctum', 'manager'])->group(function () {
        // ホーム
        Route::get('/home', [HomeController::class, 'manager']);
        // 教師情報の管理
        Route::prefix('teacher')->group(function () {
            Route::get('/', [TeacherController::class, 'index']);
            Route::post('/', [TeacherController::class, 'confirm']);
            Route::post('/finalize', [TeacherController::class, 'finalize']);
            Route::put('/', [TeacherController::class, 'update']);
            Route::delete('/', [TeacherController::class, 'destroy']);
            Route::post('csv/upload', [TeacherController::class, 'csvUpload']);
            Route::post('create/accounts', [TeacherController::class, 'createAccounts']);
        });
        // クラス情報の管理
        Route::prefix('class')->group(function () {
            Route::get('/', [DepartmentController::class, 'index']);
            Route::post('/', [DepartmentController::class, 'store']);
            Route::post('/finalize', [DepartmentController::class, 'finalize']);
            Route::put('/{id}', [DepartmentController::class, 'update']);
            Route::delete('/{id}', [DepartmentController::class, 'destroy']);
            // クラス担任の管理
            Route::prefix('assign')->group(function () {
                Route::post('/', [DepartmentHeadController::class, 'store']);
                Route::post('/finalize', [DepartmentHeadController::class, 'finalize']);
                Route::put('/{id}', [DepartmentHeadController::class, 'update']);
                Route::delete('/{id}', [DepartmentHeadController::class, 'destroy']);
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
        Route::get('/home', [HomeController::class, 'teacher']);
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
            Route::get('/{id}', [DepartmentController::class, 'show']);
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
                Route::get('/', [SelectionScheduleController::class, 'index']);
                Route::post('/', [SelectionScheduleController::class, 'store']);
                Route::put('/{id}', [SelectionScheduleController::class, 'update']);
                Route::delete('/{id}', [SelectionScheduleController::class, 'destroy']);
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
        Route::get('/home', [HomeController::class, 'student']);
        // 企業情報管理
        Route::prefix('company')->group(function () {
            Route::get('/', [CompanyController::class, 'index']);
            Route::post('/', [CompanyController::class, 'store']);
            Route::get('/{id}', [CompanyController::class, 'show']);
            Route::put('/{id}', [CompanyController::class, 'update']);
            Route::delete('/{id}', [CompanyController::class, 'destroy']);
            // 選考スケジュール管理
            Route::prefix('schedule')->group(function () {
                Route::get('/', [SelectionScheduleController::class, 'index']);
                Route::post('/', [SelectionScheduleController::class, 'store']);
                Route::put('/{id}', [SelectionScheduleController::class, 'update']);
                Route::delete('/{id}', [SelectionScheduleController::class, 'destroy']);
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
