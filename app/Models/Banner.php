<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Banner extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'subtitle',
        'button_text',
        'button_link',
        'image',
        'status',
        'sort_order',
        'type',
        'position',
        'alt_text'
    ];

    protected $casts = [
        'status' => 'boolean'
    ];
    public function scopeMain($query)
    {
        return $query->where('type', 'main');
    }

    public function scopeSmall($query)
    {
        return $query->where('type', 'small');
    }

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('status', true);
    }

    public function scopeOrdered($query)
    {
        return $query->orderBy('sort_order', 'asc');
    }

    // Accessors
    public function getStatusBadgeAttribute()
    {
        return $this->status ? 'success' : 'danger';
    }

    public function getStatusLabelAttribute()
    {
        return $this->status ? 'Active' : 'Inactive';
    }

    public function getImageUrlAttribute()
    {
        if ($this->image) {
            return asset('storage/' . $this->image);
        }
        return null;
    }
}
