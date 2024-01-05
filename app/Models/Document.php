<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Casts\Attribute;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class Document extends Model
{
    use HasFactory;

    protected $guarded = [];
    protected $table = 'documents';

    public function manipulationable()
    {
        return $this->morphTo();
    }

    public function documents()
    {
        return $this->hasMany(Document::class,'parent_id');
    }

    protected function document(): Attribute
    {
        return new Attribute(
            get: fn($value) => Storage::disk('documents')->url($value)
        );
    }
    public function scopeUnique($query)
    {
        return $query->where('first', 1);
    }
}
