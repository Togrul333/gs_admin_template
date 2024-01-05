<?php

namespace App\Models\Concerns;

use App\Extensions\Date;
use Illuminate\Contracts\Translation\Translator;

trait HasTimeago
{
    /**
     * Show time ago.
     *
     * @return Translator|string
     */
    public function getTimeagoAttribute()
    {
        return timeago(Date::parse($this->created_at));
    }
}