<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OrderItem extends Model
{
    protected $fillable = [
        'order_id',
        'product_id',
        'quantity',
        'unit_price',
        'currency',
        'subtotal',
    ];
    protected $casts = [
        'unit_price' => 'decimal:2',
        'subtotal' => 'decimal:2',
        'currency' => 'string',
    ];
    protected static function booted()
    {
        static::saving(function ($item) {
            $item->subtotal = $item->quantity * $item->unit_price;

            // نسخ العملة من الطلب لو موجود
            if ($item->order && $item->order->currency) {
                $item->currency = $item->order->currency;
            }
        });
    }

    public function order()
    {
        return $this->belongsTo(Order::class);
    }

    public function product()
    {
        return $this->belongsTo(Product::class);
    }
}
