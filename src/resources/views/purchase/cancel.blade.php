@extends('layouts.app')

@section('content')
    <h1>決済がキャンセルされました。</h1>
    <p>再度購入する場合はもう一度お試しください。</p>
    <a href="{{ url('/purchase') }}">購入画面へ戻る</a>
@endsection
