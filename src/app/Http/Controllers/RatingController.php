<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Rating;
use Illuminate\Support\Facades\Auth;
use App\Notifications\TransactionCompleted;
use App\Models\Purchase;
use Illuminate\Notifications\Notification;
use Illuminate\Notifications\Messages\MailMessage;

class RatingController extends Controller
{

    public function showTradePage($id)
    {
        $purchase = Purchase::findOrFail($id);

        $showAutoRatingModal = false;
        if ($purchase->seller_id === Auth::id() && !$purchase->isRatedBy(Auth::id())) {
            $showAutoRatingModal = true;
        }

        return view('trade', compact('purchase', 'showAutoRatingModal'));
    }

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

        if ($purchase->buyer_id === Auth::id()) {
            $seller = $purchase->product->user;

            $seller->notify(new TransactionCompleted($purchase));
        }

        $ratedUserIds = Rating::where('purchase_id', $purchase->id)->pluck('user_id')->toArray();

        if (in_array($purchase->seller_id, $ratedUserIds) && in_array($purchase->buyer_id, $ratedUserIds)) {
            $purchase->status = 'sold';
            $purchase->save();

            $product = $purchase->product;
            $product->transaction_status = 'sold';
            $product->sold = true;
            $product->save();



            $product->user->notify(new TransactionCompleted($purchase));
        }


        return redirect()->route('index')->with('success', '評価を保存しました');

    }


}
