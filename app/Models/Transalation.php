<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Transalation extends Model
{
    protected $fillable = [
        'key',
        'locale',
        'content',
        'context',
    ];

    public function tags(): BelongsToMany
    {
        return $this->belongsToMany(Tag::class, 'tag_translation');
    }
}
