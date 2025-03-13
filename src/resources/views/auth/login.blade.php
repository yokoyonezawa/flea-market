@extends('layouts.app')

<link rel="stylesheet" href="{{ asset('css/login.css') }}">

@section('content')
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
@endsection