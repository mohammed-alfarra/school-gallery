<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Image extends Model
{
    use HasFactory;

    protected $fillable = ['imageable_id', 'imageable_type', 'path', 'mime_type', 'size'];

    public function imageable(): MorphTo
    {
        return $this->morphTo();
    }

    public function thumbnails(): HasMany
    {
        return $this->hasMany(Thumbnail::class);
    }
}
