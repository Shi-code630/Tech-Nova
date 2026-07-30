<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

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
        'meta_keywords'
    ];

    protected $casts = [
        'thumbnails' => 'array',
        'price' => 'decimal:2',
        'discount_price' => 'decimal:2',
        'featured' => 'boolean',
        'stock' => 'integer'
    ];

    // ============ RELATIONSHIPS ============

    /**
     * Get the category that owns the product
     */
    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get the brand that owns the product
     */
    public function brand()
    {
        return $this->belongsTo(Brand::class);
    }

    /**
     * Get all images for the product
     */
    public function images()
    {
        return $this->hasMany(ProductImage::class);
    }

    /**
     * Get all variants for the product
     */
    public function variants()
    {
        return $this->hasMany(ProductVariant::class);
    }

    /**
     * Get all cart items for the product
     */
    public function carts()
    {
        return $this->hasMany(Cart::class);
    }

    /**
     * Get all wishlist items for the product
     */
    public function wishlists()
    {
        return $this->hasMany(Wishlist::class);
    }

    /**
     * Get all order items for the product
     */
    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    /**
     * Get all reviews for the product
     */
    public function reviews()
    {
        return $this->hasMany(Review::class);
    }

    // ============ ACCESSORS ============

    /**
     * Get the final price (after discount)
     */
    public function getFinalPriceAttribute()
    {
        return $this->discount_price ?? $this->price;
    }

    /**
     * Get the average rating of the product
     */
    public function getAverageRatingAttribute()
    {
        return $this->reviews()->where('status', true)->avg('rating') ?? 0;
    }

    /**
     * Get the total number of reviews
     */
    public function getReviewCountAttribute()
    {
        return $this->reviews()->where('status', true)->count();
    }

    /**
     * Check if product is in stock
     */
    public function getIsInStockAttribute()
    {
        return $this->stock > 0;
    }

    /**
     * Get discount percentage
     */
    public function getDiscountPercentageAttribute()
    {
        if (isset($this->discount_price) && $this->discount_price > 0 && $this->price > 0) {
            return round((($this->price - $this->discount_price) / $this->price) * 100);
        }
        return 0;
    }

    /**
     * Get formatted price
     */
    public function getFormattedPriceAttribute()
    {
        return 'Rs. ' . number_format($this->price ?? 0, 2);
    }

    /**
     * Get formatted discount price
     */
    public function getFormattedDiscountPriceAttribute()
    {
        if (isset($this->discount_price) && $this->discount_price > 0) {
            return 'Rs. ' . number_format($this->discount_price, 2);
        }
        return null;
    }

    /**
     * Get the status badge color
     */
    public function getStatusBadgeAttribute()
    {
        $badges = [
            'active' => 'success',
            'inactive' => 'danger',
            'out_of_stock' => 'warning'
        ];
        return $badges[$this->status] ?? 'secondary';
    }

    /**
     * Get the status label
     */
    public function getStatusLabelAttribute()
    {
        $labels = [
            'active' => 'Active',
            'inactive' => 'Inactive',
            'out_of_stock' => 'Out of Stock'
        ];
        return $labels[$this->status] ?? ucfirst($this->status);
    }

    // ============ SCOPES ============

    /**
     * Scope a query to only include active products
     */
    public function scopeActive($query)
    {
        return $query->where('status', 'active');
    }

    /**
     * Scope a query to only include featured products
     */
    public function scopeFeatured($query)
    {
        return $query->where('featured', true);
    }

    /**
     * Scope a query to only include products in stock
     */
    public function scopeInStock($query)
    {
        return $query->where('stock', '>', 0);
    }

    /**
     * Scope a query to only include products on sale
     */
    public function scopeOnSale($query)
    {
        return $query->whereNotNull('discount_price')
            ->whereColumn('discount_price', '<', 'price');
    }

    /**
     * Scope a query to search products
     */
    public function scopeSearch($query, $search)
    {
        return $query->where('name', 'LIKE', "%{$search}%")
            ->orWhere('description', 'LIKE', "%{$search}%")
            ->orWhere('slug', 'LIKE', "%{$search}%");
    }

    /**
     * Scope a query to filter by price range
     */
    public function scopePriceRange($query, $min, $max)
    {
        return $query->where(function ($q) use ($min, $max) {
            $q->whereBetween('price', [$min, $max])
                ->orWhereBetween('discount_price', [$min, $max]);
        });
    }

    /**
     * Scope a query to filter by category
     */
    public function scopeByCategory($query, $categoryId)
    {
        return $query->where('category_id', $categoryId);
    }

    /**
     * Scope a query to filter by brand
     */
    public function scopeByBrand($query, $brandId)
    {
        return $query->where('brand_id', $brandId);
    }

    // ============ HELPER METHODS ============

    /**
     * Check if product has variants
     */
    public function hasVariants()
    {
        return $this->variants()->count() > 0;
    }

    /**
     * Get the minimum variant price
     */
    public function getMinVariantPriceAttribute()
    {
        return $this->variants()->min('price');
    }

    /**
     * Get the maximum variant price
     */
    public function getMaxVariantPriceAttribute()
    {
        return $this->variants()->max('price');
    }

    /**
     * Get total stock including variants
     */
    public function getTotalStockAttribute()
    {
        $variantStock = $this->variants()->sum('stock');
        return $this->stock + $variantStock;
    }

    /**
     * Get related products (same category)
     */
    public function relatedProducts($limit = 4)
    {
        return Product::where('category_id', $this->category_id)
            ->where('id', '!=', $this->id)
            ->active()
            ->inStock()
            ->limit($limit)
            ->get();
    }

    /**
     * Decrease stock when product is ordered
     */
    public function decreaseStock($quantity)
    {
        if ($this->stock < $quantity) {
            throw new \Exception('Insufficient stock. Available: ' . $this->stock);
        }

        $this->stock -= $quantity;
        $this->save();

        // Update status if out of stock
        if ($this->stock <= 0) {
            $this->status = 'out_of_stock';
            $this->save();
        }

        return $this;
    }

    /**
     * Increase stock when product is returned or restocked
     */
    public function increaseStock($quantity)
    {
        $this->stock += $quantity;
        $this->save();

        // Update status if stock is available
        if ($this->stock > 0 && $this->status === 'out_of_stock') {
            $this->status = 'active';
            $this->save();
        }

        return $this;
    }
}
