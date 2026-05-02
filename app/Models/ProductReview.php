<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ProductReview extends Model
{
    protected $guarded = [];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    protected static function booted()
    {
        static::created(function ($review) {
            $review->product->increment('reviews_count');
        });

        static::deleted(function ($review) {
            $review->product->decrement('reviews_count');
        });
    }
}
