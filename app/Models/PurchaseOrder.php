<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class PurchaseOrder extends Model
{
    protected $fillable = [
        'po_number',
        'supplier_id',
        'order_date',
        'expected_delivery',
        'received_date',
        'status',
        'total_amount',
        'notes',
    ];

    protected $casts = [
        'order_date' => 'date',
        'expected_delivery' => 'date',
        'received_date' => 'date',
    ];

    public function supplier()
    {
        return $this->belongsTo(Supplier::class);
    }

    public function items()
    {
        return $this->hasMany(PurchaseOrderItem::class);
    }

    /**
     * Generate a unique PO number like PO-20260428-001
     */
    public static function generatePoNumber(): string
    {
        $date = now()->format('Ymd');
        $lastPo = static::where('po_number', 'like', "PO-{$date}-%")->orderBy('po_number', 'desc')->first();

        if ($lastPo) {
            $lastNum = (int) substr($lastPo->po_number, -3);
            $nextNum = str_pad($lastNum + 1, 3, '0', STR_PAD_LEFT);
        } else {
            $nextNum = '001';
        }

        return "PO-{$date}-{$nextNum}";
    }
}
