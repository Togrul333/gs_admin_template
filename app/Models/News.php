<?php

namespace App\Models;

use App\Models\Scope\NewsWithExistLocaleScope;
use App\Traits\DocumentTrait;
use App\Traits\TranslationTrait;
use App\Utils\Filters\FilterBuilder;
use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Session;

class News extends Model
{
    use HasFactory, TranslationTrait, DocumentTrait;

    protected $guarded = [];
    protected $appends = [
        'slug',
        'main_photo',
    ];
    public $with = ['translations','options','filesAll','categories'];
    protected static function boot()
    {
        parent::boot();
        static::addGlobalScope(new NewsWithExistLocaleScope());
    }
    public function translations()
    {
        return $this->hasMany(NewsTranslation::class);
    }

    public function translation()
    {
        return $this->hasOne(NewsTranslation::class)
            ->where('locale', locale());
    }


    public function categories()
    {
        return $this->belongsToMany(Category::class, 'category_news', 'news_id', 'category_id');
    }

    public function options()
    {
        return $this->belongsToMany(Option::class, 'option_news', 'news_id', 'option_id');
    }

    public function views()
    {
        return $this->morphMany(View::class, 'viewable');
    }

    public function scopeActive($query)
    {
        return $query->where('action_date', '<=', now())->where('status', 1);
    }
    public function scopePremium($query)
    {
        return $query->where('for_free', '0');
    }
//    public function getSlugAttribute()
//    {
//        $result = null;
//        foreach ($this->translations as $translation) {
//            if ($translation?->slug == $this->translations->where('locale',locale())->first()?->slug) {
//                $result = $this->translation?->slug;
//            }
//        }
//        if ($result == null){
//            $result =  $this->translations->first()->slug;
//        }
//        return $result;
//    }
    public function getSlugAttribute()
    {
        return $this->translations->where('locale', locale())->first()->slug;
    }

    public function scopeFilterBy($query, $filters)
    {
        $namespace = 'App\Utils\Filters\NewsFilter';
        $filter = new FilterBuilder($query, $filters, $namespace);
        return $filter->apply();
    }

    public function videos()
    {
        return $this->morphMany(Media::class, 'manipulationable');
    }

    protected function mainPhoto(): Attribute
    {
        return Attribute::make(
            get: fn($value) => $this->filesAll->where('status','main')->first()
                ? $this->filesAll->where('status','main')->first()->document
                :  (
                        $this->filesAll->first()
                            ? $this->filesAll->first()->document
                            : asset('frontend/assets/images/news_sss.jpg')
                    )
        );
    }
}
