<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Page extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'content',
        'status',
        'meta_title',
        'meta_description',
        'meta_keywords'
    ];

    protected $casts = [
        'status' => 'boolean'
    ];

    //  ACCESSORS 

    public function getStatusBadgeAttribute()
    {
        return $this->status ? 'success' : 'danger';
    }

    public function getStatusLabelAttribute()
    {
        return $this->status ? 'Active' : 'Inactive';
    }

    public function getExcerptAttribute()
    {
        return strlen($this->content) > 100
            ? substr($this->content, 0, 100) . '...'
            : $this->content;
    }

    //  SCOPES 

    public function scopeActive($query)
    {
        return $query->where('status', true);
    }

    public function scopeInactive($query)
    {
        return $query->where('status', false);
    }

    //  HELPER METHODS 

    public static function findBySlug($slug)
    {
        return static::where('slug', $slug)->where('status', true)->first();
    }

    public static function getActivePages()
    {
        return static::where('status', true)->get();
    }
}
