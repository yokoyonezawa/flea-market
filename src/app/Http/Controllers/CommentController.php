<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Comment;
use App\Models\Product;
use App\Http\Requests\CommentRequest;

class CommentController extends Controller
{
    public function store(CommentRequest $request, $productId)
    {
        $product = Product::findOrFail($productId);

        $comment = new Comment();
        $comment->content = $request->input('content');
        $comment->user_id = auth()->id();
        $comment->product_id = $productId;
        $comment->save();

        return redirect()->route('product.show', $productId)->with('success', 'コメントが投稿されました。');
    }
}
