<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class Ingredient extends Model
{
    protected $fillable = [
        'post_id',
        'name',
        'amount',
        'unit',
        'notes',
        'order'
    ];

    public function post(): BelongsTo
    {
        return $this->belongsTo(Post::class);
    }
}
