<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products'; // 明示的にテーブル名を指定
    protected $appends = ['favorites_count'];
    protected $fillable = [
        'name', 'image', 'detail', 'price', 'category_id', 'condition_id', 'sold', 'user_id'
    ];



    public function favorites()
    {
        return $this->belongsToMany(User::class, 'favorites', 'product_id', 'user_id');
    }


    public function favoritedByUsers()
    {
        return $this->belongsToMany(User::class, 'favorites');
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function categories()
    {
        return $this->belongsToMany(Category::class, 'product_category');
    }

    public function condition()
    {
        return $this->belongsTo(Condition::class);  // もし `Condition` モデルがある場合
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function getFavoritesCountAttribute()
    {
        return $this->favorites()->count();
    }

}
