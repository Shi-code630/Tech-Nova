<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Categorie extends Model
{
    use HasFactory;

    protected $fillable = [
        'parent_id',
        'name',
        'slug',
        'description',
        'status',
        'meta_title',
        'meta_description',
        'meta_keywords',
    ];


    /**
     * Parent Category
     */
    public function parent()
    {
        return $this->belongsTo(Categorie::class, 'parent_id');
    }


    /**
     * Child Categories
     */
    public function children()
    {
        return $this->hasMany(Categorie::class, 'parent_id');
    }


    /**
     * Products under this category
     */
    public function products()
    {
        return $this->hasMany(Product::class, 'category_id');
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


    /**
     * Active Categories Scope
     */
    public function scopeActive($query)
    {
        return $query->where('status', true);
    }
}
