<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Customer extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'phone_whatsapp',
        'phone',
        'street',
        'area',
        'piece',
        'house_number',
        'notes',
        'preferred_currency',
    ];

    protected $casts = [
        'preferred_currency' => 'string', 
    ];
    protected static function booted()
    {
        static::created(function (Customer $customer) {
            $currency = $customer->preferred_currency ?? 'EGP';
            $customer->balance()->create([
                'amount' => 0.00,
                'currency' => $currency,
                'note' => 'رصيد افتتاحي',
            ]);
        });
    }
    // علاقة: عميل لديه الكثير من الطلبات
    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    // علاقة: عميل لديه الكثير من المدفوعات
    public function payments()
    {
        return $this->hasMany(Payment::class);
    }

    public function balance()
    {
        return $this->hasOne(Balance::class);
    }

}
