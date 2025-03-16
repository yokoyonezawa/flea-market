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
        if ($page === 'sell') {
            $sellingProducts = Product::where('user_id', $user->id)->get();
        } elseif ($page === 'buy') {
            $purchasedProducts = Purchase::where('user_id', $user->id)->with('product')->get();
        }

        return view('mypage.mypage', compact('user', 'sellingProducts', 'purchasedProducts', 'page'));
    }
}
