<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'type',
        'price',
        'currency',
        'currency_id',
        'note',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'currency' => 'string',
    ];

    public function currency_rel()
    {
        return $this->belongsTo(Currency::class, 'currency_id');
    }

    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
