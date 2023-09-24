<?php

namespace App\Providers;

use Illuminate\Support\Facades\Response;
use Illuminate\Support\ServiceProvider;

class ApiResponseServiceProvider extends ServiceProvider
{
    /**
     * Register services.
     */
    public function register(): void
    {
        //
    }

    /**
     * Bootstrap services.
     */
    public function boot(): void
    {
        // 成功
        Response::macro('ApiSuccess', function ($contents, $message, $statusCode = 200) {
            return response()->json([
                'success'    => true,
                'contents'   => $contents,
                'message'    => $message,
                'statusCode' => $statusCode
            ]);
        });

        // 失敗
        Response::macro('ApiFailed', function ($contents, $message, $statusCode = 200) {
            return response()->json([
                'success'    => false,
                'contents'   => $contents,
                'message'    => $message,
                'statusCode' => $statusCode,
            ]);
        });

        // エラー
        Response::macro('ApiError', function ($contents, $message, $statusCode) {
            return response()->json([
                'success'    => false,
                'contents'   => $contents,
                'message'    => $message,
                'statusCode' => $statusCode,
            ]);
        });
    }
}
