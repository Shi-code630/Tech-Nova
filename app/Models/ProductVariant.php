<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ProductVariant extends Model
{
    use HasFactory;

    protected $table = 'product_variants';

        protected $fillable = [
        'product_id',
        'color',
        'size',
        'price',
        'stock',
        'description',
        'image',
        'images',
        'status',
    ];

    protected $casts = [
        'price' => 'decimal:2',
        'stock' => 'integer',
        'status' => 'boolean',
        'images' => 'array',
    ];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }



    public function getFormattedPriceAttribute(): string
    {
        return 'Rs. ' . number_format($this->price ?? 0, 2);
    }


    public function getIsActiveAttribute(): bool
    {
        return $this->stock > 0 && $this->status;
    }


    public function getStockStatusAttribute()
    {
        if ($this->stock > 0 && $this->status) {
            return 'In Stock';
        } elseif ($this->stock <= 0 && $this->status) {
            return 'Out of Stock';
        } else {
            return 'Inactive';
        }
    }


    public function getStockStatusColorAttribute()
    {
        if ($this->stock > 0 && $this->status) {
            return 'success';
        } elseif ($this->stock <= 0 && $this->status) {
            return 'danger';
        } else {
            return 'secondary';
        }
    }
    public function scopeSearchFullName($query, $search)
    {
        return $query->where('color', 'LIKE', "%{$search}%")
            ->orWhere('size', 'LIKE', "%{$search}%");
    }

    public function getFullNameSortableAttribute()
    {
        return $this->color . ' ' . $this->size;
    }


    public function scopeActive($query)
    {
        return $query->where('status', true);
    }


    public function scopeInStock($query)
    {
        return $query->where('stock', '>', 0);
    }


       public function decreaseStock(int $quantity): bool
    {
        if ($this->stock < $quantity) {
            return false;
        }
        $this->stock -= $quantity;
        $this->save();
        return true;
    }


    public function increaseStock(int $quantity): void
    {
        $this->stock += $quantity;
        $this->save();
    }

        public function getGalleryAttribute(): array
    {
        if (is_array($this->images) && count($this->images)) {
            return array_values($this->images);
        }

        $legacy = $this->attributes['image'] ?? null;

        return $legacy ? [$legacy] : [];
    }

    protected static function booted(): void
    {
        static::saving(function (ProductVariant $variant) {
            if (is_array($variant->images) && count($variant->images)) {
                $variant->image = $variant->images[0];
            }
        });
    }
}
