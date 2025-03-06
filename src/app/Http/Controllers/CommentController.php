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
        // 商品を取得
        $product = Product::findOrFail($productId);

        // コメントを保存
        $comment = new Comment();
        $comment->content = $request->input('content');
        $comment->user_id = auth()->id(); // ログインユーザーのIDを設定
        $comment->product_id = $productId;
        $comment->save();

        // 商品詳細ページへリダイレクト
        return redirect()->route('product.show', $productId)->with('success', 'コメントが投稿されました。');
    }
}
