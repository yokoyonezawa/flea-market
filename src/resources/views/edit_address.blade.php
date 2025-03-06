@extends('layouts.app')

@section('content')
<div class="container">
    <h2>配送先住所の変更</h2>

    <form action="{{ route('profile.address.update') }}" method="POST">
        @csrf
        <input type="hidden" name="return_url" value="{{ url()->previous() }}">

        <div>
            <label for="post_code">郵便番号</label>
            <input type="text" name="post_code" id="post_code" value="{{ old('post_code', $profile->post_code) }}">
            @error('post_code') <p style="color: red;">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="address">住所</label>
            <input type="text" name="address" id="address" value="{{ old('address', $profile->address) }}">
            @error('address') <p style="color: red;">{{ $message }}</p> @enderror
        </div>

        <div>
            <label for="building_name">建物名（任意）</label>
            <input type="text" name="building_name" id="building_name" value="{{ old('building_name', $profile->building_name) }}">
            @error('building_name') <p style="color: red;">{{ $message }}</p> @enderror
        </div>

        <button type="submit">更新する</button>
    </form>
</div>
@endsection
