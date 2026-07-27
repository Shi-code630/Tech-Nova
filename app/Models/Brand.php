<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
     protected $fillable = [
        'name', 'slug', 'logo', 'description', 'image', 'status',
        'meta_title', 'meta_description', 'meta_keywords'
    ];


    public function products()
    {
        return $this->hasMany(Product::class);
    }
}
