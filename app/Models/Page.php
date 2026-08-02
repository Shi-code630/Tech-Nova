<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Page extends Model
{
    protected $fillable = [
        'title', 'slug', 'content', 'status',
        'meta_title', 'meta_description', 'meta_keywords'
    ];

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('status', true);
    }

    // Get page by slug
    public static function findBySlug($slug)
    {
        return static::where('slug', $slug)->where('status', true)->first();
    }
}
