<?php

namespace App\Http\Controllers;

use App\Http\Requests\InputAuthenticateRequest;
use App\Services\AuthenticateService;
use Illuminate\Http\Request;
use Symfony\Component\HttpFoundation\Response;

class AuthenticateController extends Controller
{

    public function __construct(private readonly ?AuthenticateService $authenticateService = null)
    {}

    public function loginManager(InputAuthenticateRequest $request)
    {
        if ($this->authenticateService->loginFromInput($request)) {

            // ログイン成功
            return response()->ApiSuccess(message: 'logging in successful.');
        }

        // ログイン失敗
        return response()->ApiFailed(message: 'failed logging in.', statusCode: Response::HTTP_BAD_REQUEST);
    }

    public function logout(Request $request)
    {
        $this->authenticateService->logout($request);

        return response()->ApiSuccess(message: 'logged out successful.');
    }
}
