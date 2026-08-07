<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Review extends Model
{
    use HasFactory;

    protected $fillable = [
        'product_id',
        'user_id',
        'rating',
        'review',
        'status'
    ];

    protected $casts = [
        'rating' => 'integer',
        'status' => 'boolean'
    ];

    // RELATIONSHIPS 

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    //  ACCESSORS

    public function getRatingStarsAttribute()
    {
        $stars = '';
        for ($i = 0; $i < $this->rating; $i++) {
            $stars .= '⭐';
        }
        return $stars;
    }

    public function getRatingStarsHtmlAttribute()
    {
        $html = '';
        for ($i = 0; $i < $this->rating; $i++) {
            $html .= '<span style="color: #f59e0b;">★</span>';
        }
        for ($i = $this->rating; $i < 5; $i++) {
            $html .= '<span style="color: #d1d5db;">★</span>';
        }
        return $html;
    }

    public function getStatusBadgeAttribute()
    {
        return $this->status ? 'success' : 'danger';
    }

    public function getStatusLabelAttribute()
    {
        return $this->status ? 'Published' : 'Pending';
    }

    public function getCustomerNameAttribute()
    {
        return $this->user?->name ?? 'Anonymous';
    }

    // SCOPES

    public function scopeApproved($query)
    {
        return $query->where('status', true);
    }

    public function scopePending($query)
    {
        return $query->where('status', false);
    }

    public function scopeHighRating($query, $min = 4)
    {
        return $query->where('rating', '>=', $min);
    }

    public function scopeLowRating($query, $max = 3)
    {
        return $query->where('rating', '<=', $max);
    }
}
