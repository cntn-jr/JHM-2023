<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Lang;
use Symfony\Component\HttpFoundation\Response;
use Throwable;

class Handler extends ExceptionHandler
{
    /**
     * The list of the inputs that are never flashed to the session on validation exceptions.
     *
     * @var array<int, string>
     */
    protected $dontFlash = [
        'current_password',
        'password',
        'password_confirmation',
    ];

    /**
     * Register the exception handling callbacks for the application.
     */
    public function register(): void
    {
        $this->reportable(function (Throwable $e, Request $request) {

            // /api出ない場合、404を返す
            if (!$request->is('api/*')) {
                return response()->ApiError(
                    [],
                    Lang::get('exceptions.404'),
                    Response::HTTP_NOT_FOUND
                );
            }
            switch ($e->getCode()) {

                // 401, 403, 404の場合
                case Response::HTTP_UNAUTHORIZED :
                case Response::HTTP_FORBIDDEN:
                case Response::HTTP_NOT_FOUND:
                    return response()->ApiError(
                        [],
                        Lang::get('exceptions.'.$e->getCode()),
                        $e->getCode()
                    );
                default:

                    // ローカル環境以外は500を返す
                    if (!App::environment('local'))
                        return response()->ApiError(
                            [],
                            Lang::get('exceptions.500'),
                            $e->getCode()
                        );

                    // ローカルであれば発生したエラーコードをそのまま返す
                    return response()->ApiError(
                        [
                            'line'  => $e->getLine(),
                            'trace' => $e->getTrace(),
                        ],
                        $e->getMessage(),
                        $e->getCode()
                    );
            }
        });
    }
}
