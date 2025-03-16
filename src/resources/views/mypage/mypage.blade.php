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
            <h2 class="username">{{ Auth::user()->name }}</h2>
        </div>
        <a href="{{ route('mypage.profile') }}" class="edit-profile-button">プロフィールを編集</a>
    </div>

    <div class="tabs">
        <a href="{{ route('mypage', ['page' => 'sell']) }}" class="tab {{ $page === 'sell' ? 'active' : '' }}">出品した商品</a>
        <a href="{{ route('mypage', ['page' => 'buy']) }}" class="tab {{ $page === 'buy' ? 'active' : '' }}">購入した商品</a>
    </div>

    @if ($page === 'sell')
        <div class="product-grid">
            @foreach ($sellingProducts as $product)
                <div class="product-card">
                    <img src="{{ Str::startsWith($product->image, 'http') ? $product->image : asset('storage/' . $product->image) }}" alt="商品画像">
                    <p class="product-name">{{ $product->name }}</p>
                </div>
            @endforeach
        </div>
    @elseif ($page === 'buy')
        <div class="product-grid">
            @foreach ($purchasedProducts as $purchase)
                @if ($purchase->product)
                    <div class="product-card">
                        <img src="{{ Str::startsWith($purchase->product->image, 'http') ? $purchase->product->image : asset('storage/' . $purchase->product->image) }}" alt="商品画像">
                        <p class="product-name">{{ $purchase->product->name }}</p>
                    </div>
                @endif
            @endforeach
        </div>
    @endif
</div>
@endsection
