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
        <button class="tab active" data-tab="selling" onclick="showTab('selling')">出品した商品</button>
        <button class="tab" data-tab="purchased" onclick="showTab('purchased')">購入した商品</button>
    </div>

    <div id="selling" class="tab-content">
        <div class="product-grid">
            @foreach ($sellingProducts as $product)
                <div class="product-card">
                    <img src="{{ asset('storage/' . $product->image) }}" alt="商品画像">
                    <p class="product-name">{{ $product->name }}</p>
                </div>
            @endforeach
        </div>
    </div>

    <div id="purchased" class="tab-content hidden">
        <div class="product-grid">
            @foreach ($purchasedProducts as $purchase)
                @if ($purchase->product)
                    <div class="product-card">
                        <img src="{{ $purchase->product->image }}" alt="商品画像">
                        <p class="product-name">{{ $purchase->product->name }}</p>
                    </div>
                @endif
            @endforeach
        </div>
    </div>
</div>


<script>
function showTab(tabId) {

    document.querySelectorAll('.tab-content').forEach(tab => tab.classList.add('hidden'));

    let selectedTab = document.querySelector(`#${tabId}`);
    if (selectedTab) {
        selectedTab.classList.remove('hidden');
    }

    document.querySelectorAll('.tab').forEach(tab => tab.classList.remove('active'));

    document.querySelector(`.tab[data-tab="${tabId}"]`).classList.add('active');
}
</script>


@endsection