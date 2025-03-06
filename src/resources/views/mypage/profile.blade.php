@extends('layouts.app')

@section('content')
<div class="container">
    <h2>プロフィール設定</h2>

    @if (session('success'))
        <p style="color: green;">{{ session('success') }}</p>
    @endif

    <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
        @csrf
        @method('POST')

        <div class="form-group">
            <label>プロフィール画像</label><br>
            @if($profile->image)
                <img src="{{ asset('storage/' . $profile->image) }}" alt="プロフィール画像" width="150">
            @endif
            <input type="file" name="image">
        </div>

        <div class="form-group">
            <label>名前</label>
            <input type="text" value="{{ auth()->user()->name }}" readonly>
        </div>

        <div class="form-group">
            <label>郵便番号</label>
            <input type="text" name="post_code" value="{{ old('post_code', $profile->post_code) }}">
        </div>

        <div class="form-group">
            <label>住所</label>
            <input type="text" name="address" value="{{ old('address', $profile->address) }}">
        </div>

        <div class="form-group">
            <label>建物名</label>
            <input type="text" name="building_name" value="{{ old('building_name', $profile->building_name) }}">
        </div>

        <button type="submit">更新する</button>
    </form>
</div>
@endsection
