<?php

namespace App\Models;

use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Notifications\Notifiable;
use Laravel\Sanctum\HasApiTokens;


class User extends Authenticatable implements MustVerifyEmail
{
    use HasApiTokens, HasFactory, Notifiable;

    protected $fillable = [
        'name',
        'email',
        'password',
    ];

    protected $hidden = [
        'password',
        'remember_token',
    ];

    protected $casts = [
        'email_verified_at' => 'datetime',
    ];


    public function profile()
    {
        return $this->hasOne(Profile::class);
    }

    public function favorites()
    {
        return $this->belongsToMany(Product::class, 'favorites', 'user_id', 'product_id');
    }

    public function favoriteProducts()
    {
        return $this->belongsToMany(Product::class, 'favorites', 'user_id', 'product_id');
    }

        // ユーザーが出品している商品
    public function listedProducts()
    {
        return $this->belongsToMany(Product::class);
    }

    // ユーザーが所有している商品
    public function ownedProducts()
    {
        return $this->hasMany(Product::class);
    }



    public function purchases()
    {
        return $this->hasMany(Purchase::class);
    }


    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function receivedRatings()
{
    return $this->hasManyThrough(
        \App\Models\Rating::class,
        \App\Models\Purchase::class,
        'seller_id',
        'purchase_id',
        'id',
        'id'
    )->whereColumn('ratings.user_id', '!=', 'purchases.seller_id');
}

    public function averageRating()
    {
        $average = $this->receivedRatings()->avg('rating');

        return $average ? round($average) : null;
    }

    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }
}
