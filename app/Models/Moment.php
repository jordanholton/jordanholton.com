<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Moment extends Model
{
    protected $fillable = ['title', 'date', 'body', 'category', 'published'];

    protected $casts = [
        'date'      => 'date',
        'published' => 'boolean',
    ];

    /** Scope: only published entries */
    public function scopePublished($query)
    {
        return $query->where('published', true);
    }

    /** Scope: ordered by date descending (most recent first) */
    public function scopeNewest($query)
    {
        return $query->orderByDesc('date');
    }
}
