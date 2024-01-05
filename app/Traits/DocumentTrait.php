<?php

namespace App\Traits;

use App\Models\Document;

trait DocumentTrait
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
        return $this->morphMany(Document::class, 'manipulationable')->whereNull('parent_id');
    }
    public function filesAll()
    {
        return $this->morphMany(Document::class, 'manipulationable');
    }



}
