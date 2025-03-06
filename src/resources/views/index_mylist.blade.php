@extends('layouts.app')

@section('content')
<div class="container">
    <h2>マイリスト</h2>
    <h3>いいねした商品 & 出品した商品</h3>

    <div class="product-grid">
        @foreach($allProducts as $item)
            <div class="product-card">
                @if(filter_var($item->image, FILTER_VALIDATE_URL))
                    <!-- 画像がURLの場合 -->
                    <img src="{{ $item->image }}" alt="{{ $item->name }}">
                @else
                    <!-- 画像がストレージに保存されている場合 -->
                    <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->name }}">
                @endif
                <p>{{ $item->name }}</p>
            </div>
        @endforeach
    </div>
</div>

@endsection
