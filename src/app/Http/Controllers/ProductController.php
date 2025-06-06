<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Favorite;
use App\Http\Requests\ExhibitionRequest;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
        public function index(Request $request)
        {
            $searchQuery = $request->input('query');
            $user = auth()->user();

            $items = Product::query();

            if ($searchQuery) {
                $items = $items->where('name', 'like', "%{$searchQuery}%");
            }

            $items = $items->where(function ($query) use ($user) {
                if ($user) {
                    $query->where('user_id', '!=', $user->id);
                }
                $query->orWhereNull('user_id');
            });


            $items = $items->get();

            return view('index', compact('items', 'searchQuery'));
        }

        public function mylist(Request $request)
        {
            $searchQuery = $request->input('query');

            if (auth()->check()) {
                $user = auth()->user();
                $favoriteProducts = $user->favoriteProducts()->get();

                $userProducts = $user->products;

                if ($searchQuery) {
                    $favoriteProducts = $favoriteProducts->where('name', 'like', "%{$searchQuery}%");
                    $userProducts = $userProducts->where('name', 'like', "%{$searchQuery}%");
                }

                $allProducts = $favoriteProducts->merge($userProducts);
            } else {
                $allProducts = collect();
            }

            return view('index_mylist', compact('allProducts', 'searchQuery'));
        }




        public function mypage()
        {
            $products = auth()->user()->products;

            return view('mypage.mypage', compact('products'));
        }

        public function profile()
        {
            return view('mypage.profile');
        }




        public function toggleFavorite(Product $product)
        {

            $user = auth()->user();

            if ($user->favoriteProducts()->where('product_id', $product->id)->exists()) {
                $user->favoriteProducts()->detach($product->id);
            } else {
                $user->favoriteProducts()->attach($product->id);
            }

            return redirect()->route('index');
        }

        public function show($id)
        {

            $item = Product::withCount('favorites')->with(['comments.user', 'categories', 'condition'])->findOrFail($id);

            $purchaseUrl = route('purchase', ['id' => $id]);

            return view('item', compact('item', 'purchaseUrl'));
        }



        public function create()
        {
            $categories = \App\Models\Category::all();
            $conditions = \App\Models\Condition::all();
            return view('sell', compact('categories', 'conditions'));
        }

        public function store(ExhibitionRequest $request)
        {
            $imagePath = $request->file('image')->store('products', 'public');


            Product::create([
                'user_id' => auth()->id(),
                'name' => $request->name,
                'detail' => $request->detail,
                'price' => $request->price,
                'category_id' => $request->category_id,
                'condition_id' => $request->condition_id,
                'image' => $imagePath,
                'transaction_status' => Product::STATUS_AVAILABLE,
            ]);

            return redirect()->route('index')->with('success', '商品を出品しました！');
        }
}
