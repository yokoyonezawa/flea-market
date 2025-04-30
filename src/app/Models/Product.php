<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $table = 'products';
    protected $appends = ['favorites_count'];
    protected $fillable = [
        'name', 'image', 'detail', 'price', 'category_id', 'condition_id', 'sold', 'user_id', 'transaction_status'
    ];


    public const STATUS_AVAILABLE = 'available';
    public const STATUS_TRADING   = 'trading';
    public const STATUS_COMPLETED = 'sold';

    public static function getStatuses()
    {
        return [
            self::STATUS_AVAILABLE => '出品中',
            self::STATUS_TRADING => '取引中',
            self::STATUS_COMPLETED => '取引完了',
        ];
    }


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
        return $this->belongsTo(Condition::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function getFavoritesCountAttribute()
    {
        return $this->favorites()->count();
    }

    public function purchase()
    {
        return $this->hasOne(Purchase::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

}
