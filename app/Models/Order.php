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
        'currency',
        'currency_id',
        'note',
    ];

    protected $casts = [
        'date' => 'date',
        'total' => 'decimal:2',
        'currency' => 'string',
    ];

    public function currency_rel()
    {
        return $this->belongsTo(Currency::class, 'currency_id');
    }

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }

    public function items()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function getTotalAttribute()
    {
        return $this->items->sum('subtotal');
    }
}
