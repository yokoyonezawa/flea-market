<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Product;
use App\Models\Purchase;

class MypageController extends Controller
{
    // public function index()
    // {
    //     $user = Auth::user();

    //     // 出品した商品を取得
    //     $sellingProducts = Product::where('user_id', $user->id)->get();

    //     // 購入した商品を取得（購入履歴テーブルがある場合）
    //     $purchasedProducts = Purchase::where('user_id', $user->id)->with('product')->get();

    //     return view('mypage.mypage', compact('user', 'sellingProducts', 'purchasedProducts'));
    // }

    public function index(Request $request)
    {
        $user = Auth::user();
        $page = $request->query('page'); // URLパラメータを取得

        $sellingProducts = collect();  // デフォルトの空コレクション
        $purchasedProducts = collect(); // デフォルトの空コレクション

        if ($page === 'sell') {
            // 出品した商品のみ取得
            $sellingProducts = Product::where('user_id', $user->id)->get();
        } elseif ($page === 'buy') {
            // 購入した商品のみ取得
            $purchasedProducts = Purchase::where('user_id', $user->id)->with('product')->get();
        }

        return view('mypage.mypage', compact('user', 'sellingProducts', 'purchasedProducts', 'page'));
    }
}
