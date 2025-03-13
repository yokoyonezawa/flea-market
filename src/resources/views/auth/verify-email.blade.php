@extends('layouts.app')

@section('content')
<div class="container">
    <h1>メール認証が必要です</h1>
    <p>ご登録のメールアドレスに認証リンクを送信しました。メールを確認し、リンクをクリックしてください。</p>

    @if (session('message'))
        <p>{{ session('message') }}</p>
    @endif

    <form method="POST" action="{{ route('verification.send') }}">
        @csrf
        <button type="submit">認証メールを再送</button>
    </form>
</div>
@endsection
