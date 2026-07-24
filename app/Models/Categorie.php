<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Categorie extends Model
{
    use HasFactory;

    protected $table = 'categories';

    protected $fillable = [
        'parent_id',
        'name',
        'slug',
        'description',
        'status',
        'meta_title',
        'meta_description',
        'meta_keywords'
    ];

    protected $casts = [
        'status' => 'boolean',
    ];

    // Parent category relationship
    public function parent()
    {
        return $this->belongsTo(Categorie::class, 'parent_id');
    }

    // Children categories relationship - FIXED: renamed to children()
    public function children()
    {
        return $this->hasMany(Categorie::class, 'parent_id');
    }

    // Products relationship
    public function products()
    {
        return $this->hasMany(Product::class); // Make sure Product model exists
    }

    // Get all subcategories recursively
    public function allChildren()
    {
        return $this->children()->with('allChildren');
    }

    // Get all parent categories recursively
    public function allParents()
    {
        return $this->parent()->with('allParents');
    }

    // Helper method to get the full category path
    public function getPathAttribute()
    {
        $path = [$this->name];
        $parent = $this->parent;

        while ($parent) {
            array_unshift($path, $parent->name);
            $parent = $parent->parent;
        }

        return implode(' > ', $path);
    }

    // Scope for active categories
    public function scopeActive($query)
    {
        return $query->where('status', true);
    }

    // Scope for root categories (no parent)
    public function scopeRoot($query)
    {
        return $query->whereNull('parent_id');
    }
}
