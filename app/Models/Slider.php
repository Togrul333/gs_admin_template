<?php

namespace App\Models;

use App\Traits\DocumentTrait;
use App\Traits\TranslationTrait;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;

class Slider extends Model
{
    use HasFactory,TranslationTrait,DocumentTrait;

    protected $guarded = [];

    public $with = ['translation'];

    public function translations()
    {
        return $this->hasMany(SliderTranslation::class);
    }

    public function translation()
    {
        return $this->hasOne(SliderTranslation::class)
            ->where('locale',Session::get('locale'));
    }

    public function scopeActive($query)
    {
        return $query->where('status', 1);
    }
}
