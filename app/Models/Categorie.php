<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Categorie extends Model
{
    protected $fillable = [
        'parent_id', 'name', 'slug', 'description', 'status',
        'meta_title', 'meta_description', 'meta_keywords'
    ];


    public function parents()
    {
        return $this->belongsTo(Categorie::class, 'parent_id');
    }

    public function childrens()
    {
        return $this->hasMany(Categorie::class, 'parent_id');
    }

    public function products()
    {
        return $this->hasMany(ProductImage::class);
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
}
