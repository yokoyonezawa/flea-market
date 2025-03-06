@extends('layouts.app')

@section('content')
<div class="purchase-container">
    <h1 class="page-title">商品購入画面</h1>

    <div class="purchase-content">
        <div class="product-info">
            <div class="product-image">
                <img src="{{ $item->image ?? asset('images/no-image.png') }}" alt="商品画像">
            </div>
            <div class="product-details">
                <h2>{{ $item->name }}</h2>
                <p class="price">¥ {{ number_format($item->price) }}</p>
            </div>
        </div>

        <div class="payment-shipping">
            <div class="payment-method">
                <h3>支払い方法</h3>
                <select name="payment_method" id="payment-method">
                    <option value="">選択してください</option>
                    <option value="クレジットカード">クレジットカード</option>
                    <option value="コンビニ払い">コンビニ払い</option>
                </select>
            </div>

            <div class="shipping-info">
                <div class="address">
                    <h3>配送先</h3>
                </div>
                <div class="address_change">
                    <a href="{{ route('profile.address.edit') }}" class="change-link">変更する</a>
                </div>
                <p>〒 {{ $profile->post_code ?? 'XXX-YYYY' }}</p>
                <p>{{ $profile->address ?? 'ここには住所が入ります' }}</p>
                <p>{{ $profile->building_name ?? 'ここには建物名が入ります' }}</p>

            </div>
        </div>

        <div class="order-summary">
            <table>
                <tr>
                    <th>商品代金</th>
                    <td>¥ {{ number_format($item->price) }}</td>
                </tr>
                <tr>
                    <th>支払い方法</th>
                    <td id="selected-payment">選択してください</td>
                </tr>
            </table>
            @if($item->sold)
                <span class="text-red-500 font-bold">SOLD</span>
            @else
                @if(isset($profile->id))
                <form action="{{ route('purchase.process', ['id' => $item->id]) }}" method="POST">
                    @csrf
                    <input type="hidden" name="profile_id" value="{{ $profile->id }}">
                    <input type="hidden" name="item_name" value="{{ $item->name }}">
                    <input type="hidden" name="amount" value="{{ $item->price }}">
                    <input type="hidden" name="payment_method" id="selected-payment-method" value="">

                    <button type="submit" class="purchase-button">購入する</button>
                </form>
                @else
                    <p class="text-red-500">プロフィール情報がありません。プロフィールを登録してください。</p>
                @endif
            @endif
        </div>
    </div>
</div>

<script>
    document.getElementById('payment-method').addEventListener('change', function () {
        document.getElementById('selected-payment').textContent = this.value || '選択してください';
        document.getElementById('selected-payment-method').value = this.value;
    });
</script>

@endsection
