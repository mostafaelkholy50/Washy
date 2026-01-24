<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Spatie\Translatable\HasTranslations;

class Post extends Model
{
    use HasTranslations;

    protected $guarded = [];
    public $translatable = ['title', 'content'];

    protected $casts = [
        'published_at' => 'date',
    ];

    public function getTitleEnAttribute() { return $this->getTranslation('title', 'en', false); }
    public function setTitleEnAttribute($value) { $this->setTranslation('title', 'en', $value); }
    public function getTitleArAttribute() { return $this->getTranslation('title', 'ar', false); }
    public function setTitleArAttribute($value) { $this->setTranslation('title', 'ar', $value); }

    public function getContentEnAttribute() { return $this->getTranslation('content', 'en', false); }
    public function setContentEnAttribute($value) { $this->setTranslation('content', 'en', $value); }
    public function getContentArAttribute() { return $this->getTranslation('content', 'ar', false); }
    public function setContentArAttribute($value) { $this->setTranslation('content', 'ar', $value); }
}
