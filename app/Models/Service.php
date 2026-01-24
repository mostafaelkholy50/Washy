<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Spatie\Translatable\HasTranslations;

class Service extends Model
{
    use HasTranslations;

    protected $guarded = [];
    public $translatable = ['title', 'description'];

    public function getTitleEnAttribute() { return $this->getTranslation('title', 'en', false); }
    public function setTitleEnAttribute($value) { $this->setTranslation('title', 'en', $value); }
    public function getTitleArAttribute() { return $this->getTranslation('title', 'ar', false); }
    public function setTitleArAttribute($value) { $this->setTranslation('title', 'ar', $value); }

    public function getDescriptionEnAttribute() { return $this->getTranslation('description', 'en', false); }
    public function setDescriptionEnAttribute($value) { $this->setTranslation('description', 'en', $value); }
    public function getDescriptionArAttribute() { return $this->getTranslation('description', 'ar', false); }
    public function setDescriptionArAttribute($value) { $this->setTranslation('description', 'ar', $value); }
}
