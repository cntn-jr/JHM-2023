<?php

namespace App\Exceptions;

use Illuminate\Foundation\Exceptions\Handler as ExceptionHandler;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\App;
use Illuminate\Support\Facades\Lang;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\HttpKernel\Exception\NotFoundHttpException;
use Symfony\Component\HttpKernel\Exception\UnauthorizedHttpException;
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
        $this->renderable(function (Throwable $e, Request $request) {

            // /api出ない場合、404を返す
            if (!$request->is('api/*')) {
                return response()->ApiError(
                    [],
                    Lang::get('messages.exceptions.404'),
                    Response::HTTP_NOT_FOUND
                );
            }

            // エラーの型で判定
            if ($e instanceof UnauthorizedHttpException) {
                return response()->ApiError(
                    [],
                    Lang::get('messages.exceptions.401'),
                    Response::HTTP_UNAUTHORIZED
                );
            } else if ($e instanceof NotFoundHttpException) {
                return response()->ApiError(
                    [],
                    Lang::get('messages.exceptions.404'),
                    Response::HTTP_NOT_FOUND
                );
            }

            // ステータスコードで判定
            switch ($e->getCode()) {

                // 401, 403, 404の場合
                case Response::HTTP_UNAUTHORIZED :
                case Response::HTTP_FORBIDDEN :
                case Response::HTTP_NOT_FOUND :
                    return response()->ApiError(
                        [],
                        Lang::get("messages.exceptions.{$e->getCode()}"),
                        $e->getCode()
                    );
            }

            // ローカル環境以外は500を返す
            if (!App::environment('local')) {
                return response()->ApiError(
                    [],
                    Lang::get('messages.exceptions.500'),
                    $e->getCode()
                );
            }

            // ローカルであれば発生したエラーコードをそのまま返す
            return response()->ApiError(
                [
                    'line'  => $e->getLine(),
                    'trace' => $e->getTrace(),
                ],
                $e->getMessage(),
                $e->getCode()
            );
        });
    }
}
