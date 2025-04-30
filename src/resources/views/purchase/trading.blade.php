@extends('layouts.app')

<link rel="stylesheet" href="{{ asset('css/trading.css') }}">

@section('content')
<div class="trade-page">
    <div class="sidebar">
        <h3>その他の取引</h3>
        <ul>
            @foreach($tradingProducts as $otherPurchase)
                @if ($otherPurchase->id !== $purchase->id)
                    <li>
                        <a href="{{ route('purchase.trading', ['id' => $otherPurchase->id]) }}" class="product-name">
                            {{ $otherPurchase->product->name }}
                        </a>
                    </li>
                @endif
            @endforeach
        </ul>
    </div>
    <div class="main-content">
        <div class="header">
            <h2>
            「{{ Auth::id() === $purchase->product->user_id ? optional($purchase->buyer)->name : optional($purchase->seller)->name }}」さんとの取引画面
            </h2>

            @if($canCompleteTransaction)
                <form id="complete-form" method="POST" action="{{ route('purchase.complete', $purchase->id) }}">
                @csrf
                    <button type="button" class="complete-btn" onclick="showRatingModal()">取引を完了する</button>
                </form>
            @endif
        </div>

        <div class="product-info">
            <img src="{{ Str::startsWith($product->image, 'http') ? $product->image : asset('storage/' . $product->image) }}" alt="商品画像" class="product-img">
            <div>
                <h3>{{ $product->name }}</h3>
                <p>{{ number_format($product->price) }}円</p>
            </div>
        </div>

        <div class="chat-area">
        @foreach($purchase->messages as $message)
            <div class="message @if($message->user_id === Auth::id()) sent @else received @endif">
                <div class="message-header">
                    @if($message->user_id === Auth::id())
                        <span class="user-name">{{ $message->user->name }}</span>
                        <img src="{{ asset('storage/' . ($message->user->profile->image ?? 'images/default-avatar.png')) }}" alt="User Icon" class="user-icon">
                    @else
                        <img src="{{ asset('storage/' . ($message->user->profile->image ?? 'images/default-avatar.png')) }}" alt="User Icon" class="user-icon">
                        <span class="user-name">{{ $message->user->name }}</span>
                    @endif
                </div>
                <div class="message-content-container @if($message->user_id === Auth::id()) sent @else received @endif">
                    @if ($message->content)
                        <p class="message-content">{{ $message->content }}</p>
                    @endif

                    @if ($message->image_path)
                        <div class="message-image">
                            <img src="{{ asset('storage/' . $message->image_path) }}" alt="送信された画像" style="max-width: 300px;">
                        </div>
                    @endif

                </div>
                @if($message->user_id === Auth::id())
                    <div class="message-actions">
                        <a href="{{ route('message.edit', $message->id) }}">編集</a>
                        <form method="POST" action="{{ route('message.destroy', $message->id) }}">
                        @csrf
                        @method('DELETE')
                        <button type="submit" class="delete-btn">削除</button>
                    </form>
                    </div>
                @endif
            </div>
        @endforeach
    </div>
        <form method="POST" action="{{ route('message.store', $purchase->id) }}" enctype="multipart/form-data" class="message-form">
            @csrf
            <div class="form-group">
                {{-- content フィールドのエラーメッセージ表示 --}}
                @error('content')
                    <div class="text-red-500">{{ $message }}</div>
                @enderror
                <input type="text" name="content" id="chat-input" placeholder="取引メッセージを記入してください" value="{{ old('content') }}">
            </div>
                <input type="file" name="image" id="image-upload" class="hidden-file">
                <label for="image-upload" class="add-image">画像を追加</label>

            {{-- image フィールドのエラーメッセージ表示 --}}
            @error('image')
            <div class="text-red-500">{{ $message }}</div>
            @enderror

            <button type="submit" class="send-btn">
                <img src="{{ asset('images/送信_飛行機.png') }}" alt="Airplane" class="airplane-icon">
            </button>
        </form>

        </div>
    </div>
</div>

<div id="rating-modal" class="rating-modal hidden">
    <div class="rating-box">
        <p class="rating-title">取引が完了しました。</p>
        <p class="rating-subtitle">今回の取引相手はどうでしたか？</p>
        <div class="rating-stars">
            @for ($i = 1; $i <= 5; $i++)
                <span class="star" data-value="{{ $i }}">&#9733;</span>
            @endfor
        </div>
        <div class="rating-submit-content">
            <form id="rating-form" method="POST" action="{{ route('rating.store', ['purchaseId' => $purchase->id]) }}">
                @csrf
                <input type="hidden" name="rating" id="rating-value">
                <button type="submit" class="rating-submit">送信する</button>
            </form>
        </div>
    </div>
</div>




@if(Auth::id() === $purchase->seller_id && $purchase->status === 'sold' && !$purchase->isRatedBy(Auth::id()))
    <button onclick="document.getElementById('rating-modal').classList.remove('hidden')">購入者を評価する</button>
@endif


<script>
    const stars = document.querySelectorAll('.star');
    const ratingValue = document.getElementById('rating-value');
    const modal = document.getElementById('rating-modal');

    let selected = 0;

    stars.forEach(star => {
        star.addEventListener('mouseover', () => {
            let value = star.getAttribute('data-value');
            highlightStars(value);
        });

        star.addEventListener('mouseout', () => {
            highlightStars(selected);
        });

        star.addEventListener('click', () => {
            selected = star.getAttribute('data-value');
            ratingValue.value = selected;
            highlightStars(selected);
        });
    });

    function highlightStars(value) {
        stars.forEach(star => {
            if (star.getAttribute('data-value') <= value) {
                star.classList.add('selected');
            } else {
                star.classList.remove('selected');
            }
        });
    }

    function showRatingModal() {
        modal.classList.remove('hidden');
    }


    document.addEventListener('click', function(event) {
        if (event.target.classList.contains('modal-close')) {
            document.getElementById('rating-modal').classList.add('hidden');
        }
    });

    @if($showAutoRatingModal)
    window.addEventListener('DOMContentLoaded', () => {
        showRatingModal();
    });
    @endif

</script>


@endsection


