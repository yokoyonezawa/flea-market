<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Models\Purchase;

class MypageController extends Controller
{
    public function index(Request $request)
    {
        $user = Auth::user();
        $page = $request->query('page');

        $sellingProducts = collect();
        $purchasedProducts = collect();
        $tradingProducts = collect();


        $tradingProductsQuery = Purchase::where(function ($query) use ($user) {
            $query->where('user_id', $user->id)
                ->whereHas('product', function ($q) {
                    $q->where('transaction_status', Product::STATUS_TRADING);
                });
        })
        ->orWhereHas('product', function ($query) use ($user) {
            $query->where('user_id', $user->id)
                ->where('transaction_status', Product::STATUS_TRADING);
        })
        ->where('status', 'trading')
        ->with('product');

        $messageCount = $tradingProductsQuery->get()->map(function ($purchase) {
            return $purchase->messages()
                ->where('user_id', '!=', auth()->id())
                ->where('is_read', false)
                ->count();
        })->sum();


    if ($page === 'sell') {
        $sellingProducts = Product::where('user_id', $user->id)->get();

    } elseif ($page === 'buy') {
        $purchasedProducts = Purchase::where('user_id', $user->id)
            ->whereHas('product', function ($query) {
                $query->where('transaction_status', Product::STATUS_COMPLETED);
            })
            ->with('product')
            ->get();

    } elseif ($page === 'trading') {
        // $tradingProducts = $tradingProductsQuery->get();
        $tradingProducts = $tradingProductsQuery
        ->with(['messages' => function ($query) {
            $query->latest(); // 最新のメッセージ順で取得
        }])
        ->get()
        ->sortByDesc(function ($purchase) {
            return optional($purchase->messages->first())->created_at;
        })
        ->values();
    }

    return view('mypage.mypage', compact('user', 'sellingProducts', 'purchasedProducts', 'tradingProducts', 'messageCount', 'page'));
}

}