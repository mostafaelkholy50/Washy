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
        'note',
    ];

    // لو هتستخدم decimal في price، ممكن تضيف cast
    protected $casts = [
        'price' => 'decimal:2',
    ];

    // علاقة: المنتج موجود في الكثير من الطلبات
    public function orders()
    {
        return $this->hasMany(Order::class);
    }
}
