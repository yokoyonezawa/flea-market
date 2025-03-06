<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id', 'user_id', 'content'
    ];

    // User とのリレーション
    public function user()
    {
        return $this->belongsTo(User::class);
    }

    // Product とのリレーション（もし未設定なら追加）
    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
