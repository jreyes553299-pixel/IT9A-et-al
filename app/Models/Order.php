<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    protected $guarded = [];

    protected $casts = [
        'created_at' => 'datetime',
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public static function generateOrderNumber()
    {
        $latest = static::latest('id')->first();
        $number = $latest ? intval(substr($latest->order_number, 4)) + 1 : 1001;
        return 'ORD-' . $number;
    }
}
