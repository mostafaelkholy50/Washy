<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Spatie\Translatable\HasTranslations;

class Skill extends Model
{
    use HasTranslations;

    protected $guarded = [];
    public $translatable = ['name'];

    public function getNameEnAttribute() { return $this->getTranslation('name', 'en', false); }
    public function setNameEnAttribute($value) { $this->setTranslation('name', 'en', $value); }
    public function getNameArAttribute() { return $this->getTranslation('name', 'ar', false); }
    public function setNameArAttribute($value) { $this->setTranslation('name', 'ar', $value); }
}
