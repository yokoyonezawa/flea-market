<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use Illuminate\Auth\Events\Verified;
use Illuminate\Http\Request;
use App\Providers\RouteServiceProvider;

class EmailVerificationPromptController extends Controller
{
    public function __invoke()
    {
        return view('auth.verify-email');
    }
}
