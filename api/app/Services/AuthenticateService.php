<?php

namespace App\Services;

use App\Http\Requests\InputAuthenticateRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthenticateService {

    /**
     * メールアドレスとパスワードを用いたログイン
     *
     * @param Request $request
     * @return bool
     */
    public function loginFromInput(InputAuthenticateRequest $request): bool
    {
        $credentials = $request->only(['email', 'password']);
        if (Auth::attempt($credentials)) {

            // セッションIDを再生成
            $request->session()->migrate();
            return true;
        }

        // ログイン失敗
        return false;
    }

    public function logout(Request $request): void
    {
        // ログアウト処理
        Auth::logout();

        // セッションを再生成
        $request->session()->invalidate();

        // CSRFトークンを再生成
        $request->session()->regenerateToken();
    }
}