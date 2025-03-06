@extends('layouts.app')

@section('content')
<div class="container">
    <h2>商品の出品</h2>

    <form action="{{ route('products.store') }}" method="POST" enctype="multipart/form-data">
        @csrf

        {{-- 商品画像 --}}
        <div class="form-group">
            <label for="image">商品画像</label>
            <input type="file" name="image" id="image" class="form-control">
        </div>

        {{-- カテゴリー選択 --}}
        <div class="form-group">
            <label for="category_id">カテゴリー</label>
            <select name="category_id" id="category_id" class="form-control">
                <option value="">選択してください</option>
                @foreach ($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
        </div>

        {{-- 商品の状態 --}}
        <div class="form-group">
            <label for="condition_id">商品の状態</label>
            <select name="condition_id" id="condition_id" class="form-control">
                <option value="">選択してください</option>
                @foreach ($conditions as $condition)
                    <option value="{{ $condition->id }}">{{ $condition->name }}</option>
                @endforeach
            </select>
        </div>

        {{-- 商品名 --}}
        <div class="form-group">
            <label for="name">商品名</label>
            <input type="text" name="name" id="name" class="form-control" required>
        </div>

        {{-- 商品の説明 --}}
        <div class="form-group">
            <label for="detail">商品の説明</label>
            <textarea name="detail" id="detail" class="form-control" rows="4" required></textarea>
        </div>

        {{-- 価格 --}}
        <div class="form-group">
            <label for="price">販売価格（円）</label>
            <input type="number" name="price" id="price" class="form-control" required>
        </div>

        {{-- 出品ボタン --}}
        <button type="submit" class="btn btn-primary">出品する</button>
    </form>
</div>
@endsection
