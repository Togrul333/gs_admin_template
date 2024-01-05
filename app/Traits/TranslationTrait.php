<?php

namespace App\Traits;

use App\Models\SliderTranslation;
use Illuminate\Support\Facades\Session;

trait TranslationTrait
{
    public function translate($code)
    {
        return $this->translations->where('locale',$code)->first();
    }
}
