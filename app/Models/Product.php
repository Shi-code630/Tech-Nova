<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use App\Models\Category;
use App\Models\Brand;
use App\Models\ProductImage;
use App\Models\ProductVariant;
use App\Models\Cart;
use App\Models\Wishlist;
use App\Models\OrderItem;
use App\Models\Review;

class Product extends Model
{
    use HasFactory;

    protected $fillable = [
        'category_id',
        'brand_id',
        'name',
        'slug',
        'description',
        'price',
        'discount_price',
        'stock',
        'status',
        'thumbnails',
        'featured',
        'meta_title',
        'meta_description',
        'meta_keywords',
    ];

    protected $casts = [
        'thumbnails' => 'array',
        'price' => 'decimal:2',
        'discount_price' => 'decimal:2',
        'featured' => 'boolean',
        'stock' => 'integer',
    ];

    // =========================
    // RELATIONSHIPS
    // =========================

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

    public function variants()
    {
        return $this->hasMany(ProductVariant::class);
    }

    public function carts()
    {
        return $this->hasMany(Cart::class);
    }

    public function wishlists()
    {
        return $this->hasMany(Wishlist::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    // =========================
    // ACCESSORS
    // =========================

    public function getFinalPriceAttribute()
    {
        return $this->discount_price ?? $this->price;
    }

    public function getAverageRatingAttribute()
    {
        return $this->reviews()
            ->where('status', true)
            ->avg('rating') ?? 0;
    }

    public function getReviewCountAttribute()
    {
        return $this->reviews()
            ->where('status', true)
            ->count();
    }

    public function getIsInStockAttribute()
    {
        return $this->stock > 0;
    }

    public function getDiscountPercentageAttribute()
    {
        if (
            $this->discount_price !== null &&
            $this->discount_price > 0 &&
            $this->price > 0
        ) {
            return round(
                (($this->price - $this->discount_price) / $this->price) * 100
            );
        }

        return 0;
    }

    public function getFormattedPriceAttribute()
    {
        return 'Rs. ' . number_format($this->price ?? 0, 2);
    }

    public function getFormattedDiscountPriceAttribute()
    {
        if ($this->discount_price !== null && $this->discount_price > 0) {
            return 'Rs. ' . number_format($this->discount_price, 2);
        }

        return null;
    }

    public function getStatusBadgeAttribute()
    {
        return match ($this->status) {
            'active' => 'success',
            'inactive' => 'danger',
            'out_of_stock' => 'warning',
            default => 'secondary',
        };
    }

    public function getStatusLabelAttribute()
    {
        return match ($this->status) {
            'active' => 'Active',
            'inactive' => 'Inactive',
            'out_of_stock' => 'Out of Stock',
            default => ucfirst($this->status),
        };
    }

    // =========================
    // SCOPES
    // =========================

    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    public function scopeFeatured($query)
    {
        return $query->where('featured', true);
    }

    public function scopeInStock($query)
    {
        return $query->where('stock', '>', 0);
    }

    public function scopeOnSale($query)
    {
        return $query
            ->whereNotNull('discount_price')
            ->whereColumn('discount_price', '<', 'price');
    }

    public function scopeSearch($query, $search)
    {
        return $query->where(function ($q) use ($search) {
            $q->where('name', 'LIKE', "%{$search}%")
                ->orWhere('description', 'LIKE', "%{$search}%")
                ->orWhere('slug', 'LIKE', "%{$search}%");
        });
    }

    public function scopePriceRange($query, $min, $max)
    {
        return $query->where(function ($q) use ($min, $max) {
            $q->whereBetween('price', [$min, $max])
                ->orWhereBetween('discount_price', [$min, $max]);
        });
    }

    public function scopeByCategory($query, $categoryId)
    {
        return $query->where('category_id', $categoryId);
    }

    public function scopeByBrand($query, $brandId)
    {
        return $query->where('brand_id', $brandId);
    }

    // =========================
    // VARIANT HELPERS
    // =========================

    public function hasVariants(): bool
    {
        return $this->variants()->exists();
    }

    public function getMinVariantPriceAttribute()
    {
        return $this->variants()->min('price');
    }

    public function getMaxVariantPriceAttribute()
    {
        return $this->variants()->max('price');
    }

    public function getTotalVariantStockAttribute()
    {
        return $this->variants()->sum('stock');
    }

    public function getTotalStockAttribute()
    {
        if ($this->hasVariants()) {
            return $this->variants()->sum('stock');
        }

        return $this->stock;
    }

    // =========================
    // RELATED PRODUCTS
    // =========================

    public function relatedProducts($limit = 4)
    {
        return Product::where('category_id', $this->category_id)
            ->where('id', '!=', $this->id)
            ->active()
            ->inStock()
            ->limit($limit)
            ->get();
    }

    // =========================
    // STOCK
    // =========================

    public function decreaseStock($quantity)
    {
        if ($this->stock < $quantity) {
            throw new \Exception(
                'Insufficient stock. Available: ' . $this->stock
            );
        }

        $this->stock -= $quantity;

        if ($this->stock <= 0) {
            $this->status = 'out_of_stock';
        }

        $this->save();

        return $this;
    }

    public function increaseStock($quantity)
    {
        $this->stock += $quantity;

        if (
            $this->stock > 0 &&
            $this->status === 'out_of_stock'
        ) {
            $this->status = 'active';
        }

        $this->save();

        return $this;
    }
}
