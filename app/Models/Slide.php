<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Spatie\Translatable\HasTranslations;

class Slide extends Model
{
    use HasTranslations;

    protected $guarded = [];
    public $translatable = ['title'];

    public function getTitleEnAttribute() { return $this->getTranslation('title', 'en', false); }
    public function setTitleEnAttribute($value) { $this->setTranslation('title', 'en', $value); }
    public function getTitleArAttribute() { return $this->getTranslation('title', 'ar', false); }
    public function setTitleArAttribute($value) { $this->setTranslation('title', 'ar', $value); }
}
