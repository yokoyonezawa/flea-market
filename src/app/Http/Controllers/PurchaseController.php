<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Profile;
use App\Models\Purchase;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\PurchaseRequest;


class PurchaseController extends Controller
{
    public function purchase($id)
    {
        $item = Product::findOrFail($id);
        $profile = Profile::where('user_id', Auth::id())->first();

        return view('purchase', compact('item', 'profile'));
    }

    public function process(PurchaseRequest $request, $id)
    {

        $product = Product::findOrFail($id);
        $user = Auth::user();

        $sellerId = $product->user_id;

        $existingPurchase = Purchase::where('user_id', $user->id)
        ->where('product_id', $product->id)
        ->first();

        if (!$existingPurchase) {
            Purchase::create([
                'user_id' => $user->id,
                'product_id' => $product->id,
                'profile_id' => $request->profile_id,
                'total_price' => $product->price,
                'payment_method' => $request->payment_method,
                'seller_id' => $sellerId,
                'buyer_id' => $user->id,
            ]);

            $product->transaction_status = Product::STATUS_TRADING;
            $product->save();

        }

        return redirect()->route('purchase.checkout', ['id' => $id]);
    }



}
