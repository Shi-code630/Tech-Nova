<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Wishlist extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'product_id'
    ];

    protected $casts = [
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    //  RELATIONSHIPS

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    //  FIXED: Changed from ProductImage to Product
    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    //  ACCESSORS

    public function getCustomerNameAttribute()
    {
        return $this->user?->name ?? 'Guest';
    }

    public function getProductNameAttribute()
    {
        return $this->product?->name ?? 'Product Not Found';
    }

    public function getProductPriceAttribute()
    {
        return $this->product?->formatted_price ?? 'N/A';
    }

    public function getAddedAtAttribute()
    {
        return $this->created_at?->diffForHumans() ?? 'N/A';
    }
}
