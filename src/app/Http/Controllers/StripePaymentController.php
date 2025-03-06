<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Stripe\Stripe;
use Stripe\Checkout\Session;
use App\Models\Product;

class StripePaymentController extends Controller
{
    public function __construct()
    {
        $this->middleware('auth')->except(['success', 'cancel']);
    }



    public function checkout(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        // すでに売れていたらリダイレクト
        if ($product->sold) {
            return redirect()->route('product.purchase', $id)->with('error', 'この商品は売り切れです。');
        }

        Stripe::setApiKey(env('STRIPE_SECRET'));

        // フォームから受け取るデータ（空ならデフォルト値）
        $itemName = $request->input('item_name', $product->name);
        $amount = intval($request->input('amount', $product->price));

        // Stripe 決済セッション作成
        $session = Session::create([
            'payment_method_types' => ['card'],
            'line_items' => [[
                'price_data' => [
                    'currency' => 'jpy',
                    'product_data' => [
                        'name' => $itemName,
                    ],
                    'unit_amount' => $amount,
                ],
                'quantity' => 1,
            ]],
            'mode' => 'payment',
            'success_url' => route('purchase.success', ['id' => $product->id]),
            'cancel_url' => route('purchase.cancel'),
        ]);

        return redirect($session->url);
    }


    public function success($id)
    {
        $product = Product::findOrFail($id);

        // 商品をSOLDにする
        $product->update(['sold' => true]);
        $product->sold = true;
        $product->save();

        return view('purchase.success', compact('product'));
    }

    public function cancel()
    {
        return view('purchase.cancel');
    }
}
