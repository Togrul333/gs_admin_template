<?php

namespace App\Models\Concerns;

trait HasSlug
{
    /**
     * Get item by the slug.
     *
     * @param string $slug
     *
     * @return null|static
     */
    public static function getBySlug($slug)
    {
        return static::with('translations')->whereTranslation('slug', $slug, config('app.locale'))->firstOrFail();
    }
}
