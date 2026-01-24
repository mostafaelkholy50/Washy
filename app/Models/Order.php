<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Order extends Model
{
    use HasFactory;

 protected $fillable = [
        'date',
        'customer_id',
        'type',
        'total',
        'note',
    ];

    protected $casts = [
        'date' => 'date',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    // إجمالي محسوب (اختياري - للعرض فقط)
    public function getTotalAttribute()
    {
        return $this->items->sum('subtotal');
    }
}
