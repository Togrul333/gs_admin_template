<?php

namespace App\Models\Concerns;

use Illuminate\Support\Str;

trait HasAction
{
    /**
     * Get the action route for the model.
     *
     * @param string $action
     *
     * @return string
     */
    public function action($action)
    {
        return route(($model = Str::snake(class_basename($this), '-')).'.'.$action, [$model => $this->{'id'}]);
    }
}
