@extends('layouts.app')

<link rel="stylesheet" href="{{ asset('css/index.css') }}">


@section('content')
<div class="container">
    <div class="links-container">
        <a href="{{ route('index') }}" class="link-item {{ request()->routeIs('index') ? 'active' : '' }}">おすすめ</a>
        <a href="{{ route('product.mylist', ['query' => request('query')]) }}" class="link-item">マイリスト</a>
    </div>

    @if($items->isEmpty())
        <p>検索結果が見つかりませんでした。</p>
    @else
        <div class="product-grid">
            @foreach($items as $item)
                <div class="product-card">
                    <a href="{{ url('item', $item->id) }}">
                        <img src="{{ Str::startsWith($item->image, 'http') ? $item->image : asset('storage/' . $item->image) }}" alt="{{ $item->name }}">
                    </a>
                    <a href="{{ url('item', $item->id) }}">
                        <p>{{ $item->name }}</p>
                    </a>
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
    @endif
</div>
@endsection