<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;
use App\Models\Comment;

class ItemController extends Controller
{
    public function show($id)
    {
        $item = Product::with(['category', 'comments.user'])->findOrFail($id);
        $purchaseUrl = route('purchase', ['id' => $item->id]); // URLをコントローラーで作成

        return view('item', compact('item', 'purchaseUrl'));
    }

}
