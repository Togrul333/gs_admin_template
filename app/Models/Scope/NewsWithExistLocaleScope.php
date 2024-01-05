<?php

namespace App\Models\Scope;

use App\Enums\LevelType;
use Illuminate\Database\Eloquent\Builder;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Scope;

class NewsWithExistLocaleScope implements Scope
{
    public function __construct()
    {
    }

    /**
     * Apply the scope to a given Eloquent query builder.
     *
     * @param Builder $builder
     * @param Model $model
     * @return void
     */
    public function apply(Builder $builder, Model $model)
    {
        if (request()->segment(1) !== 'admin') {
            $builder->whereHas('translations', function ($query) {
                $query->where('locale', locale())
                      ->whereNotNull('title')
                      ->whereNotNull('description');
            });
        }
    }
}
