<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Spatie\Translatable\HasTranslations;

class Category extends Model
{
    use HasTranslations;

    protected $guarded = [];
    public $translatable = ['name', 'slug'];

    public function portfolios()
    {
        return $this->hasMany(Portfolio::class);
    }

    // Accessors and Mutators for Filament Forms
    public function getNameEnAttribute()
    {
        return $this->getTranslation('name', 'en', false);
    }

    public function setNameEnAttribute($value)
    {
        $this->setTranslation('name', 'en', $value);
    }

    public function getNameArAttribute()
    {
        return $this->getTranslation('name', 'ar', false);
    }

    public function setNameArAttribute($value)
    {
        $this->setTranslation('name', 'ar', $value);
    }

    public function getSlugEnAttribute()
    {
        return $this->getTranslation('slug', 'en', false);
    }

    public function setSlugEnAttribute($value)
    {
        $this->setTranslation('slug', 'en', $value);
    }

    public function getSlugArAttribute()
    {
        return $this->getTranslation('slug', 'ar', false);
    }

    public function setSlugArAttribute($value)
    {
        $this->setTranslation('slug', 'ar', $value);
    }
}
