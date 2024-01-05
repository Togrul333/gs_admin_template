<?php

namespace App\Models\Concerns;

use Illuminate\Support\Str;

trait Sluggable
{
    /**
     * Set the name and slug for the model.
     *
     * @param string $value
     *
     * @return void
     */
    public function setSlugAttribute($value)
    {
        $this->setSlug('slug', $value ?: $this->slug ?: $this->name);
    }

    /**
     * Do set the title/name and slug for the post.
     *
     * @param string $key
     * @param string $value
     *
     * @return void
     */
    public function setSlug($key, $value)
    {

        if (! $value) {
            return;
        }

        $this->attributes[$key] = $value;

        $value = $slug = Str::slug($value);
        $i     = 0;

        while ($this->slugExists($value)) {
            $value = $slug.'-'.++$i;
        }

        $this->attributes['slug'] = $value;
    }

    /**
     * Determine if a record exists with the given slug.
     *
     * @param string $slug
     *
     * @return bool
     */
    private function slugExists($slug)
    {
        $query = static::withoutGlobalScopes()
                       ->where('id', '!=', $this->id)
                       ->where('slug', $slug);

        if ($this->getOriginal('locale')) {
            $query->where('locale', $this->locale);
        }

        return (bool) $query->count();
    }
}
