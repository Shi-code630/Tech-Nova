<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Categorie extends Model
{
    use HasFactory;

<<<<<<< HEAD
=======
    protected $table = 'categories';

>>>>>>> 20cda3c69db6227f5f7c3a80902938fab95abb35
    protected $fillable = [
        'parent_id',
        'name',
        'slug',
        'description',
        'status',
        'meta_title',
        'meta_description',
<<<<<<< HEAD
        'meta_keywords',
=======
        'meta_keywords'
>>>>>>> 20cda3c69db6227f5f7c3a80902938fab95abb35
    ];

    protected $casts = [
        'status' => 'boolean',
    ];

<<<<<<< HEAD
    /**
     * Parent Category
     */
=======
    // Parent category relationship
>>>>>>> 20cda3c69db6227f5f7c3a80902938fab95abb35
    public function parent()
    {
        return $this->belongsTo(Categorie::class, 'parent_id');
    }

<<<<<<< HEAD

    /**
     * Child Categories
     */
=======
    // Children categories relationship - FIXED: renamed to children()
>>>>>>> 20cda3c69db6227f5f7c3a80902938fab95abb35
    public function children()
    {
        return $this->hasMany(Categorie::class, 'parent_id');
    }

<<<<<<< HEAD

    /**
     * Products under this category
     */
    public function products()
    {
        return $this->hasMany(Product::class, 'category_id');
=======
    // Products relationship
    public function products()
    {
        return $this->hasMany(Product::class); // Make sure Product model exists
>>>>>>> 20cda3c69db6227f5f7c3a80902938fab95abb35
    }


    /**
     * Recursive Child Categories
     */
    public function allChildren()
    {
        return $this->children()->with('allChildren');
    }


    /**
     * Recursive Parent Categories
     */
    public function allParents()
    {
        return $this->parent()->with('allParents');
    }

<<<<<<< HEAD

    /**
     * Active Categories Scope
     */
=======
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
>>>>>>> 20cda3c69db6227f5f7c3a80902938fab95abb35
    public function scopeActive($query)
    {
        return $query->where('status', true);
    }
<<<<<<< HEAD
=======

    // Scope for root categories (no parent)
    public function scopeRoot($query)
    {
        return $query->whereNull('parent_id');
    }
>>>>>>> 20cda3c69db6227f5f7c3a80902938fab95abb35
}
