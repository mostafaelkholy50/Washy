<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Payment extends Model
{
    use HasFactory;

    protected $fillable = [
        'customer_id',
        'date',
        'amount',
        'payment_method',
        'note',
    ];

    protected $casts = [
        'date'   => 'date',
        'amount' => 'decimal:2',
    ];

    // علاقة: الدفعة تنتمي إلى عميل واحد
    public function customer()
    {
        return $this->belongsTo(Customer::class);
    }
}
