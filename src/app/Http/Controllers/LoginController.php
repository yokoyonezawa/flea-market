<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Http\Requests\LoginRequest;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class LoginController extends Controller
{
    public function showLoginForm()
    {
        return view('auth.login');
    }

    public function login(LoginRequest $request)
    {
        // 入力値の取得
        $credentials = $request->only('email', 'password');

        // 認証処理
        if (Auth::attempt($credentials)) {
            $user = Auth::user();

            // プロフィールが登録されていなければプロフィール設定へ
            if (!$user->profile) {
                return redirect()->route('mypage.profile');
            }

            // プロフィールが登録済みなら「/」へ
            return redirect()->route('index');
        }

        // 認証失敗 -> エラーメッセージを表示してログイン画面に戻す
        return back()->withErrors(['email' => ' ログイン情報が登録されていません'])->withInput();
    }
}
