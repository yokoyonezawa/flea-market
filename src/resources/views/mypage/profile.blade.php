@extends('layouts.app')

<link rel="stylesheet" href="{{ asset('css/profile.css') }}">

@section('content')
<div class="profile-page">
    <div class="container">
        <h2>プロフィール設定</h2>

        @if (session('success'))
            <p style="color: green;">{{ session('success') }}</p>
        @endif

        <form action="{{ route('profile.update') }}" method="POST" enctype="multipart/form-data">
            @csrf
            @method('POST')

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

            <span style="margin-left: 5px;">{{ number_format($rawRating, 1) }} / 5</span>
        @else
            <p>評価はまだありません。</p>
        @endif
    </div>



            <div class="form-group image-upload-container">
                <label>プロフィール画像</label><br>



                <div class="image-and-button">
                    @if($profile->image)
                        <img src="{{ asset('storage/' . $profile->image) }}" alt="プロフィール画像" width="150">
                    @endif
                    <label for="image-upload" class="custom-file-label">画像を選択する</label>
                    <input type="file" name="image" id="image-upload" class="custom-file-input">
                </div>
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
</div>
@endsection
