<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Balance extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'amount',
        'currency',
        'currency_id',
        'note',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
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
}
