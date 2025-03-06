<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Profile;
use App\Models\Purchase;
use Illuminate\Support\Facades\Auth;


class PurchaseController extends Controller
{
    public function purchase($id)
    {
        $item = Product::findOrFail($id);
        $profile = Profile::where('user_id', Auth::id())->first();

        return view('purchase', compact('item', 'profile'));
    }

    public function process(Request $request, $id)
    {

        $product = Product::findOrFail($id);
        $user = Auth::user();

        Purchase::create([
            'user_id' => $user->id,
            'product_id' => $product->id,
            'profile_id' => $request->profile_id,
            'total_price' => $product->price,
            'payment_method' => $request->payment_method,
        ]);


        return redirect()->route('purchase.checkout', ['id' => $id]);
    }


}
