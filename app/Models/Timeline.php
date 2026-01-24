<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Spatie\Translatable\HasTranslations;

class Timeline extends Model
{
    use HasTranslations;
    use HasFactory;

    protected $fillable = ['year', 'title', 'description', 'image'];
    public $translatable = ['title', 'description'];

    // Accessors and Mutators for Translatable fields

    public function getTitleEnAttribute() { return $this->getTranslation('title', 'en', false); }
    public function setTitleEnAttribute($value) { $this->setTranslation('title', 'en', $value); }
    
    public function getTitleArAttribute() { return $this->getTranslation('title', 'ar', false); }
    public function setTitleArAttribute($value) { $this->setTranslation('title', 'ar', $value); }

    public function getDescriptionEnAttribute() { return $this->getTranslation('description', 'en', false); }
    public function setDescriptionEnAttribute($value) { $this->setTranslation('description', 'en', $value); }
    
    public function getDescriptionArAttribute() { return $this->getTranslation('description', 'ar', false); }
    public function setDescriptionArAttribute($value) { $this->setTranslation('description', 'ar', $value); }
}
