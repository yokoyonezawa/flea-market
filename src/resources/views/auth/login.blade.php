<!DOCTYPE html>
<html lang="ja">

<head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Flea_Market</title>
    <link rel="stylesheet" href="{{ asset('css/reset.css') }}">
    <link rel="stylesheet" href="{{ asset('css/common.css') }}">
    <link rel="stylesheet" href="{{ asset('css/app.css') }}">
</head>

<body>
    <div class="header__logo">
        <a href="{{ url('/') }}">
            <img src="{{ asset('images/logo.svg') }}" alt="Logo">
        </a>
    </div>

    <div class="login-container">
        <h2>ログイン</h2>
        <form action="{{ route('login') }}" method="POST">
            @csrf
            <div class="form-group">
                <label for="email">ユーザー名/メールアドレス</label>
                <div class="login_form">
                    <input type="email" id="email" name="email" class="form-control" >
                    @error('email')
                    <p class="error">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            <div class="form-group">
                <label for="password">パスワード</label>
                <div class="login_form">
                    <input type="password" id="password" name="password" class="form-control" >
                    @error('password')
                    <p class="error">{{ $message }}</p>
                    @enderror
                </div>
            </div>
            <div class="form-group">
                <button type="submit" class="btn btn-primary">ログイン</button>
            </div>
        </form>
        <div class="register-link">
            <a href="{{ route('register') }}">会員登録はこちら</a>
        </div>
    </div>
</body>