<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    use HasFactory;

    protected $fillable = [
        'purchase_id',
        'user_id',
        'rating',
    ];

    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }
}
