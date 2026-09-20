<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Job extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'department',
        'location',
        'type',
        'experience',
        'posted',
        'description',
        'is_published',
    ];

    protected $casts = [
        'is_published' => 'boolean',
    ];

    /**
     * Only published jobs.
     */
    public function scopePublished($query)
    {
        return $query->where('is_published', true);
    }
}
