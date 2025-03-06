@extends('layouts.app')

@section('content')
<div class="register-container">
    <h2>会員登録</h2>
    <form action="{{ route('register') }}" method="POST">
        @csrf
        <div class="form-group">
            <label for="username">ユーザー名</label>
            <div register_form>
                <input type="text" id="name" name="name" class="form-control" value="{{ old('name') }}" >
                @error('name')
                <p class="error">{{ $message }}</p>
                @enderror
            </div>
        </div>
        <div class="form-group">
            <label for="email">メールアドレス</label>
            <div register_form>
                <input type="email" id="email" name="email" class="form-control" value="{{ old('email') }}" >
                @error('email')
                <p class="error">{{ $message }}</p>
                @enderror
            </div>
        </div>
        <div class="form-group">
            <label for="password">パスワード</label>
            <div register_form>
                <input type="password" id="password" name="password" class="form-control" >
                @error('password')
                <p class="error">{{ $message }}</p>
                @enderror
            </div>
        </div>
        <div class="form-group">
            <label for="password_confirmation">パスワード確認用</label>
            <div register_form>
                <input type="password" id="password_confirmation" name="password_confirmation" class="form-control" >
                @error('passpassword-confirmationword')
                <p class="error">{{ $message }}</p>
                @enderror
            </div>
        </div>
        <div class="form-group">
            <button type="submit" class="btn btn-primary">登録する</button>
        </div>
    </form>
    <div class="login-link">
        <a href="{{ route('login') }}">ログインはこちら</a>
    </div>
</div>
@endsection
