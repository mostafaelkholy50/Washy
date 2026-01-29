<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Currency extends Model
{
    protected $fillable = [
        'name',
        'code',
        'symbol',
        'is_favorite',
        'is_active',
    ];

    protected $casts = [
        'is_favorite' => 'boolean',
        'is_active' => 'boolean',
    ];
}
