<?php

namespace App\Models\Concerns;

trait HasObserver
{
    /**
     * The "booting" method of the model.
     *
     * @return void
     */
    protected static function bootHasObserver()
    {
        $scope = substr_replace(static::class, 'App\Observers', 0, 10).'Observer';

        static::observe(new $scope);
    }
}
