@extends('layouts.app')

<link rel="stylesheet" href="{{ asset('css/index_mylist.css') }}">

@section('content')
<div class="container">
    <div class="links-container">
        <a href="{{ route('index') }}" class="link-item {{ request()->routeIs('index') ? 'active' : '' }}">おすすめ</a>
        <a href="{{ route('product.mylist', ['query' => request('query')]) }}" class="link-item {{ request()->routeIs('product.mylist') ? 'active' : '' }}">マイリスト</a>
    </div>
    <hr class="divider">
    <div class="product-grid">
        @foreach($allProducts as $item)
            <div class="product-card">
                @if(filter_var($item->image, FILTER_VALIDATE_URL))
                    <img src="{{ $item->image }}" alt="{{ $item->name }}">
                @else
                    <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->name }}">
                @endif
                <p>{{ $item->name }}</p>
                @if($item->sold)
                    <span class="text-red-500 font-bold">SOLD</span>
                @else
                    <form action="{{ route('product.toggleFavorite', $item->id) }}" method="POST">
                        @csrf
                        <button type="submit" class="favorite-btn">
                            @if(auth()->user() && auth()->user()->favoriteProducts()->where('product_id', $item->id)->exists())
                                ❤️ いいね済み
                            @else
                                🤍 いいね
                            @endif
                        </button>
                    </form>
                @endif
            </div>
        @endforeach
    </div>
</div>

@endsection