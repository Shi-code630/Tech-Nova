<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    protected $fillable = [
        'name',
        'slug',
        'logo',
        'description',
        'image',
        'status',
        'meta_title',
        'meta_description',
        'meta_keywords'
    ];


    public function products()
    {
        return $this->hasMany(Product::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }
    public function index()
{
    $brands = Brand::all(); // ya Brand::where('status', true)->get();

    return view('frontend.home', compact('brands'));
}
}
