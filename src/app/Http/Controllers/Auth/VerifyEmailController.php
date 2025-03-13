<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Verified;
use Illuminate\Http\Request;
use App\Providers\RouteServiceProvider;
use Illuminate\Support\Facades\Auth;
use App\Models\User;

class VerifyEmailController extends Controller
{
    public function __invoke(Request $request, $id, $hash)


    {
        $user = User::find($id);

        if (!$user) {
            abort(404, 'ユーザーが見つかりません');
        }

        if ($user->hasVerifiedEmail()) {
            return redirect()->route('login')->with('message', 'すでに認証済みです');
        }

        if (!hash_equals($hash, sha1($user->getEmailForVerification()))) {
            abort(403, '認証リンクが無効です');
        }

        $user->markEmailAsVerified();
        event(new Verified($user)); 
        $user->save();

        return redirect()->route('login')->with('verified', true);
    }
}
