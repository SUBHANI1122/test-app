<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Tag extends Model
{
    protected $fillable = ['name'];

    public function translations(): BelongsToMany
    {
        return $this->belongsToMany(Transalation::class, 'tag_translation');
    }
}
