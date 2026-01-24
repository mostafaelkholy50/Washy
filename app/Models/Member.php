<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

use Spatie\Translatable\HasTranslations;

class Member extends Model
{
    use HasTranslations;

    protected $guarded = [];
    public $translatable = ['name', 'job_title'];

    public function getNameEnAttribute() { return $this->getTranslation('name', 'en', false); }
    public function setNameEnAttribute($value) { $this->setTranslation('name', 'en', $value); }
    public function getNameArAttribute() { return $this->getTranslation('name', 'ar', false); }
    public function setNameArAttribute($value) { $this->setTranslation('name', 'ar', $value); }

    public function getJobTitleEnAttribute() { return $this->getTranslation('job_title', 'en', false); }
    public function setJobTitleEnAttribute($value) { $this->setTranslation('job_title', 'en', $value); }
    public function getJobTitleArAttribute() { return $this->getTranslation('job_title', 'ar', false); }
    public function setJobTitleArAttribute($value) { $this->setTranslation('job_title', 'ar', $value); }
}
