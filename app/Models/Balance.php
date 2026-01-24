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
        'note',
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'currency' => 'string',
    ];

    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
