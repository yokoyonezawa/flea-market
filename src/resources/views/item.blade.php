@extends('layouts.app')

<link rel="stylesheet" href="{{ asset('css/item.css') }}">

@section('content')
<div class="item-detail-container">
    <div class="item-image">
        <img src="{{ Str::startsWith($item->image, 'http') ? $item->image : asset('storage/' . $item->image) }}" alt="{{ $item->name }}">
    </div>
    <div class="item-info">
        <h1>{{ $item->name }}</h1>
        <p class="price">¥{{ number_format($item->price) }} (税込)</p>
        <div class="icons">
            <span>⭐ {{ $item->favorites_count }}</span>
            <span>💬 {{ $item->comments->count() ?? 1 }}</span>
        </div>
        @if ($item->sold)
            <span class="text-red-500 font-bold">SOLD</span>
        @else
            <form action="{{ $purchaseUrl }}" method="GET">
                <button type="submit" class="buy-button">購入手続きへ</button>
            </form>
        @endif
        <div class="item-description">
            <h2>商品説明</h2>
            <p>{{ $item->detail }}</p>
        </div>
        <div class="item-details">
            <h2>商品の情報</h2>
            <p>カテゴリー：{{ $item->category->name }}</p>
            <p>商品の状態：{{ $item->condition->name }}</p>
        </div>
        <div class="comments">
            <h2>コメント ({{ $item->comments->count() }})</h2>
            @foreach ($item->comments as $comment)
                <div class="comment">
                    <strong>{{ $comment->user->name }}</strong>
                    <p>{{ $comment->content }}</p>
                </div>
            @endforeach
        </div>
        <div class="comment-form">
            <h2>商品へのコメント</h2>
            @auth
                <form action="{{ route('comments.store', $item->id) }}" method="POST">
                    @csrf
                    <textarea name="content" placeholder="コメントを入力してください"></textarea>
                    @error('content')
                        <p class="error-message" style="color: red;">{{ $message }}</p>
                    @enderror
                    <button type="submit" class="comment-button">コメントを送信する</button>
                </form>
            @else
                <p>コメントを投稿するには、<a href="{{ route('login') }}">ログイン</a>してください。</p>
            @endauth
        </div>
    </div>
</div>
@endsection
