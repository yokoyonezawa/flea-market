<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Purchase;
use App\Models\Product;
use Illuminate\Support\Facades\Auth;
use App\Models\Message;
use App\Models\Rating;
use App\Notifications\TransactionCompleted;




class TradingController extends Controller
{


    public function trading($id)
    {
        $purchase = Purchase::with(['product.user', 'user'])->findOrFail($id);
        $product = $purchase->product;
        $buyer = $purchase->user;

        $tradingProducts = Purchase::where('user_id', Auth::id())
        ->whereHas('product', function ($query) {
            $query->where('transaction_status', Product::STATUS_TRADING);
        })
        ->orWhereHas('product', function ($query) {
            $query->where('user_id', Auth::id())
                ->where('transaction_status', Product::STATUS_TRADING);
        })
        ->with(['product', 'messages'])
        ->get()
        ->map(function ($purchase) {

            $latestMessage = $purchase->messages->isEmpty() ? null : $purchase->messages->sortByDesc('created_at')->first();
            $purchase->latest_message_created_at = $latestMessage ? $latestMessage->created_at : null;
            return $purchase;
        })
        ->sortByDesc('latest_message_created_at');



        $canCompleteTransaction = false;
        if ($purchase->user_id === Auth::id() || $product->user_id === Auth::id()) {
            if ($product->transaction_status === 'trading') {
                $canCompleteTransaction = true;
            }
        }


        Message::where('purchase_id', $purchase->id)
            ->where('user_id', '!=', Auth::id())
            ->where('is_read', false)
            ->update(['is_read' => true]);


        $unreadCount = Message::where('user_id', '!=', Auth::id())
            ->whereHas('purchase', function ($query) {
                $query->where(function ($subQuery) {
                    $subQuery->where('user_id', Auth::id())
                            ->orWhereHas('product', function ($query) {
                                $query->where('user_id', Auth::id());
                            });
                });
            })
            ->where('is_read', false)
            ->count();


        $showAutoRatingModal = false;
        if (Auth::id() === $purchase->seller_id) {
            $buyerRated = Rating::where('purchase_id', $purchase->id)
                ->where('user_id', $purchase->buyer_id)
                ->exists();
            $sellerRated = Rating::where('purchase_id', $purchase->id)
                ->where('user_id', $purchase->seller_id)
                ->exists();

            if ($buyerRated && !$sellerRated) {
                $showAutoRatingModal = true;
            }
        }


        return view('purchase.trading', compact('purchase', 'product', 'buyer', 'tradingProducts', 'canCompleteTransaction', 'unreadCount', 'showAutoRatingModal'));
    }



    public function completeTransaction($id)
    {
        $purchase = Purchase::findOrFail($id);
        $product = $purchase->product;

        $purchase->status = 'complete';
        $purchase->save();

        $product->transaction_status = 'sold';
        $product->sold = true;
        $product->save();

        $seller = $product->user;
        $seller->notify(new TransactionCompleted($purchase));

        return redirect()->route('purchase.trading', $purchase->id);
    }
}
