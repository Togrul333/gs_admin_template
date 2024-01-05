<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Media extends Model
{
    use HasFactory;
    protected $guarded = [];
    protected $table = 'media';

    public function manipulationable()
    {
        return $this->morphTo();
    }


    protected function document(): Attribute
    {
        return new Attribute(
            get: fn($value) => Storage::disk('media')->url($value)
        );
    }
}
