@extends('layouts.app')

<link rel="stylesheet" href="{{ asset('css/edit_messages.css') }}">

@section('content')
<div class="container">
    <h2>メッセージを編集</h2>

    <form method="POST" action="{{ route('message.update', $message->id) }}" enctype="multipart/form-data">
        @csrf

        <div class="form-group">
            <label>内容</label>
            <input type="text" name="content" value="{{ old('content', $message->content) }}" class="form-control">
        </div>

        <div class="form-group">
            <label>画像（再アップロードする場合）</label><br>
            <input type="file" name="image">
        </div>

        <button type="submit" class="btn btn-primary">更新</button>
    </form>
</div>
@endsection
