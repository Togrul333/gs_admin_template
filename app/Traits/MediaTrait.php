<?php

namespace App\Traits;

use App\Models\Document;
use App\Models\Media;

trait MediaTrait
{
    public function getDocuments()
    {
        return $this->files;
    }
    public function getDocument()
    {
        return $this->files->first()?->document;
    }

    public function files()
    {
        return $this->morphMany(Media::class, 'manipulationable');
    }

}
