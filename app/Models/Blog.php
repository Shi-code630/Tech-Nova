<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Blog extends Model
{
    use HasFactory;

    protected $fillable = [
        'title',
        'slug',
        'excerpt',
        'content',
        'featured_image',
        'author',
        'category_id',
        'tags',
        'views',
        'is_published',
        'published_at',
        'is_featured',
        'meta_title',
        'meta_description',
        'meta_keywords',
    ];

    protected $casts = [
        'tags' => 'array',
        'is_published' => 'boolean',
        'is_featured' => 'boolean',
        'published_at' => 'datetime',
        'views' => 'integer',
    ];

   

    /**
     * Get the category that the blog belongs to
     */
    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }



    /**
     * Get formatted views (e.g., 1.2K for 1200)
     */
    public function getFormattedViewsAttribute(): string
    {
        if ($this->views >= 1000) {
            return number_format($this->views / 1000, 1) . 'K';
        }
        return number_format($this->views);
    }

    /**
     * Calculate reading time in minutes
     */
    public function getReadingTimeAttribute(): string
    {
        $wordCount = str_word_count(strip_tags($this->content));
        $minutes = ceil($wordCount / 200); // Average reading speed: 200 words/min
        return $minutes . ' min read';
    }

    /**
     * Get excerpt (use custom excerpt or auto-generate from content)
     */
    public function getExcerptAttribute($value)
    {
        if ($value) {
            return $value;
        }
        return Str::limit(strip_tags($this->content), 150);
    }

    /**
     * Get the blog URL
     */
    public function getUrlAttribute(): string
    {
        return '/blog/' . $this->slug;
    }

    /**
     * Get featured image URL
     */
    public function getFeaturedImageUrlAttribute(): ?string
    {
        if ($this->featured_image) {
            return asset('storage/' . $this->featured_image);
        }
        return null;
    }

    /**
     * Check if blog is published
     */
    public function getIsPublishedAttribute($value)
    {
        return $value && $this->published_at <= now();
    }

    // ============ SCOPES ============

    /**
     * Scope only published blogs
     */
    public function scopePublished($query)
    {
        return $query->where('is_published', true)
                     ->where('published_at', '<=', now());
    }

    /**
     * Scope only featured blogs
     */
    public function scopeFeatured($query)
    {
        return $query->where('is_featured', true);
    }

    /**
     * Scope recent blogs
     */
    public function scopeRecent($query, $limit = 5)
    {
        return $query->published()
                     ->orderBy('published_at', 'desc')
                     ->limit($limit);
    }

    /**
     * Scope popular blogs (by views)
     */
    public function scopePopular($query, $limit = 5)
    {
        return $query->published()
                     ->orderBy('views', 'desc')
                     ->limit($limit);
    }

    /**
     * Search blogs by title or content
     */
    public function scopeSearch($query, $search)
    {
        return $query->where('title', 'LIKE', "%{$search}%")
                     ->orWhere('content', 'LIKE', "%{$search}%")
                     ->orWhere('excerpt', 'LIKE', "%{$search}%");
    }

    /**
     * Filter by category slug
     */
    public function scopeByCategory($query, $slug)
    {
        return $query->whereHas('category', function ($q) use ($slug) {
            $q->where('slug', $slug);
        });
    }

    /**
     * Filter by tag
     */
    public function scopeByTag($query, $tag)
    {
        return $query->whereJsonContains('tags', $tag);
    }

    /**
     * Date range filter
     */
    public function scopeDateRange($query, $start, $end)
    {
        return $query->whereBetween('published_at', [$start, $end]);
    }

    // ============ BOOT METHOD ============

    protected static function boot()
    {
        parent::boot();

        // Auto-generate slug
        static::creating(function ($blog) {
            if (empty($blog->slug)) {
                $blog->slug = Str::slug($blog->title);
            }

            // Set published_at if publishing
            if (empty($blog->published_at) && $blog->is_published) {
                $blog->published_at = now();
            }
        });

        // Update published_at if status changes
        static::updating(function ($blog) {
            if ($blog->isDirty('is_published') && $blog->is_published && empty($blog->published_at)) {
                $blog->published_at = now();
            }
        });
    }

    // ============ HELPER METHODS ============

    /**
     * Increment view count
     */
    public function incrementViews()
    {
        $this->increment('views');
    }

    /**
     * Get related blogs (same category)
     */
    public function relatedBlogs($limit = 3)
    {
        return self::published()
            ->where('category_id', $this->category_id)
            ->where('id', '!=', $this->id)
            ->latest('published_at')
            ->limit($limit)
            ->get();
    }

    /**
     * Get next blog
     */
    public function getNextBlogAttribute()
    {
        return self::published()
            ->where('published_at', '>', $this->published_at)
            ->orderBy('published_at')
            ->first();
    }

    /**
     * Get previous blog
     */
    public function getPreviousBlogAttribute()
    {
        return self::published()
            ->where('published_at', '<', $this->published_at)
            ->orderBy('published_at', 'desc')
            ->first();
    }
}
