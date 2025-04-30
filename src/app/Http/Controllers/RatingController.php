<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Purchase;
use App\Models\Rating;
use Illuminate\Support\Facades\Auth;

class RatingController extends Controller
{
    public function store(Request $request, $id)
    {
        $purchase = Purchase::findOrFail($id);

        if ($purchase->seller_id !== Auth::id() && $purchase->buyer_id !== Auth::id()) {
            abort(403);
        }

        if (Rating::where('purchase_id', $purchase->id)->where('user_id', Auth::id())->exists()) {
            return back()->with('error', 'すでに評価済みです');
        }

        Rating::create([
            'purchase_id' => $purchase->id,
            'user_id' => Auth::id(),
            'rating' => $request->input('rating'),
        ]);

        $ratedUserIds = Rating::where('purchase_id', $purchase->id)->pluck('user_id')->toArray();

        if (in_array($purchase->seller_id, $ratedUserIds) && in_array($purchase->buyer_id, $ratedUserIds)) {
            $purchase->status = 'sold';
            $purchase->save();

            $product = $purchase->product;
            $product->transaction_status = 'sold';
            $product->sold = true;
            $product->save();
        }


        return redirect()->route('index')->with('success', '評価を保存しました');

    }


}
