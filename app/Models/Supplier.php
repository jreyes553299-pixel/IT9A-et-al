<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Supplier extends Model
{
    protected $fillable = [
        'name',
        'contact_person',
        'email',
        'phone',
        'address',
        'website',
        'rating',
        'payment_terms',
        'lead_time',
        'notes',
        'country',
        'is_active',
        'categories',
        'total_spent',
        'brands',
    ];

    protected $casts = [
        'categories' => 'array',
        'is_active' => 'boolean',
        'brands' => 'array',
    ];

    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function purchaseOrders()
    {
        return $this->hasMany(PurchaseOrder::class);
    }
}
