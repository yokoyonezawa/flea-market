@extends('layouts.app')

<link rel="stylesheet" href="{{ asset('css/mypage.css') }}">

@section('content')
<div class="profile-container">
    <div class="profile-header">
        <div class="profile-info">
            <div class="profile-image">
                @if(Auth::user()->profile && Auth::user()->profile->image)
                    <img src="{{ asset('storage/' . Auth::user()->profile->image) }}" alt="プロフィール画像">
                @else
                    <img src="{{ asset('images/default-avatar.png') }}" alt="デフォルトプロフィール画像">
                @endif
            </div>
            <div class="rating">
                <label>評価:</label>
                @php
                    $rawRating = auth()->user()->averageRating();
                    $roundedRating = is_null($rawRating) ? null : round($rawRating); // 四捨五入
                @endphp

                @if ($roundedRating !== null)
                    @for ($i = 0; $i < $roundedRating; $i++)
                        <span style="color: gold;">★</span>
                    @endfor

                    @for ($i = $roundedRating; $i < 5; $i++)
                        <span style="color: #ccc;">☆</span>
                    @endfor

                @else
                    <p>評価はまだありません。</p>
                @endif
            </div>

            <h2 class="username">{{ Auth::user()->name }}</h2>
        </div>
        <a href="{{ route('mypage.profile') }}" class="edit-profile-button">プロフィールを編集</a>
    </div>

    <div class="tabs">
        <a href="{{ route('mypage', ['page' => 'sell']) }}" class="tab {{ $page === 'sell' ? 'active' : '' }}">出品した商品</a>
        <a href="{{ route('mypage', ['page' => 'buy']) }}" class="tab {{ $page === 'buy' ? 'active' : '' }}">購入した商品</a>
        <a href="{{ route('mypage', ['page' => 'trading']) }}" class="tab {{ $page === 'trading' ? 'active' : '' }}">
            取引中の商品
            @if ($messageCount > 0)
                <span class="message-badge1">{{ $messageCount }}</span>
            @endif
        </a>
    </div>

    @if ($page === 'sell')
        <div class="product-grid">
            @foreach ($sellingProducts as $product)
                <div class="product-card">
                    <a href="{{ route('product.show', ['id' => $product->id]) }}">
                        <img src="{{ Str::startsWith($product->image, 'http') ? $product->image : asset('storage/' . $product->image) }}" alt="商品画像">
                        <p class="product-name">{{ $product->name }}</p>
                    </a>
                </div>
            @endforeach
        </div>
    @elseif ($page === 'buy')
        <div class="product-grid">
            @foreach ($purchasedProducts as $purchase)
                @if ($purchase->product)
                    <div class="product-card">
                        <a href="{{ route('product.show', ['id' => $purchase->product->id]) }}">
                            <img src="{{ Str::startsWith($purchase->product->image, 'http') ? $purchase->product->image : asset('storage/' . $purchase->product->image) }}" alt="商品画像">
                            <p class="product-name">{{ $purchase->product->name }}</p>
                        </a>
                    </div>
                @endif
            @endforeach
        </div>
    @elseif ($page === 'trading')
        <div class="product-grid">
            @foreach ($tradingProducts as $purchase)
                @if ($purchase->product)
                    <div class="product-card">
                        <a href="{{ route('purchase.trading', ['id' => $purchase->id]) }}">
                            <img src="{{ Str::startsWith($purchase->product->image, 'http') ? $purchase->product->image : asset('storage/' . $purchase->product->image) }}" alt="商品画像">
                            @php
                                $messageCountForProduct = $purchase->messages()->where('user_id', '!=', auth()->id())->where('is_read', false)->count();
                            @endphp
                            @if ($messageCountForProduct > 0)
                                <div class="message-badge">{{ $messageCountForProduct }}</div>
                            @endif
                            <p class="product-name">{{ $purchase->product->name }}</p>
                        </a>
                    </div>
                @endif
            @endforeach
        </div>
    @endif
</div>
@endsection
