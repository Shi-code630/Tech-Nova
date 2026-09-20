<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class Coupon extends Model
{
    use HasFactory;

    protected $fillable = [
        'code',
        'type',
        'amount',
        'minimum_amount',
        'maximum_discount',
        'usage_limit',
        'used',
        'start_date',
        'expire_date',
        'status'
    ];

    protected $casts = [
        'amount' => 'decimal:2',
        'minimum_amount' => 'decimal:2',
        'maximum_discount' => 'decimal:2',
        'usage_limit' => 'integer',
        'used' => 'integer',
        'start_date' => 'datetime',
        'expire_date' => 'datetime',
        'status' => 'boolean'
    ];

    protected $appends = [
        'is_valid',
        'discount_formatted',
        'remaining_usage',
        'usage_percentage'
    ];

    // ============ RELATIONSHIPS ============

    public function orders()
    {
        return $this->hasMany(Order::class);
    }

    // ============ ACCESSORS ============

    public function getIsValidAttribute()
    {
        if (!$this->status) return false;
        if ($this->expire_date && $this->expire_date->isPast()) return false;
        if ($this->start_date && $this->start_date->isFuture()) return false;
        if ($this->usage_limit && $this->used >= $this->usage_limit) return false;
        return true;
    }

    public function getDiscountFormattedAttribute()
    {
        if ($this->type === 'percentage') {
            return $this->amount . '%';
        }
        return 'Rs. ' . number_format($this->amount, 2);
    }

    public function getRemainingUsageAttribute()
    {
        if ($this->usage_limit === null) {
            return 'Unlimited';
        }
        return max(0, $this->usage_limit - $this->used);
    }

    public function getUsagePercentageAttribute()
    {
        if ($this->usage_limit === null || $this->usage_limit == 0) {
            return 0;
        }
        return round(($this->used / $this->usage_limit) * 100, 2);
    }

    public function getIsExpiredAttribute()
    {
        return $this->expire_date && $this->expire_date->isPast();
    }

    public function getIsUpcomingAttribute()
    {
        return $this->start_date && $this->start_date->isFuture();
    }

    public function getStatusBadgeAttribute()
    {
        if (!$this->status) return 'Inactive';
        if ($this->is_expired) return 'Expired';
        if ($this->is_upcoming) return 'Upcoming';
        if ($this->usage_limit && $this->used >= $this->usage_limit) return 'Used Up';
        return 'Active';
    }

    public function getStatusColorAttribute()
    {
        $colors = [
            'Active' => 'success',
            'Inactive' => 'danger',
            'Expired' => 'warning',
            'Upcoming' => 'info',
            'Used Up' => 'secondary'
        ];
        return $colors[$this->status_badge] ?? 'secondary';
    }

    // ============ MUTATORS ============

    public function setCodeAttribute($value)
    {
        $this->attributes['code'] = strtoupper(trim($value));
    }

    // ============ SCOPES ============

    public function scopeActive($query)
    {
        return $query->where('status', true)
            ->where(function ($q) {
                $q->whereNull('expire_date')
                    ->orWhere('expire_date', '>=', now());
            })
            ->where(function ($q) {
                $q->whereNull('start_date')
                    ->orWhere('start_date', '<=', now());
            });
    }

    public function scopeValid($query)
    {
        return $query->active()
            ->where(function ($q) {
                $q->whereNull('usage_limit')
                    ->orWhereRaw('used < usage_limit');
            });
    }

    public function scopeExpired($query)
    {
        return $query->where('status', true)
            ->whereNotNull('expire_date')
            ->where('expire_date', '<', now());
    }

    public function scopeUpcoming($query)
    {
        return $query->where('status', true)
            ->whereNotNull('start_date')
            ->where('start_date', '>', now());
    }

    public function scopeByCode($query, $code)
    {
        return $query->where('code', strtoupper($code));
    }

    public function scopeType($query, $type)
    {
        return $query->where('type', $type);
    }

    public function scopeMinAmount($query, $amount)
    {
        return $query->where(function ($q) use ($amount) {
            $q->whereNull('minimum_amount')
                ->orWhere('minimum_amount', '<=', $amount);
        });
    }

    // ============ HELPER METHODS ============

    public function isValid()
    {
        return $this->is_valid;
    }

    public function incrementUsage()
    {
        $this->used += 1;
        $this->save();
        return $this;
    }

    public function checkAndIncrementUsage()
    {
        if ($this->isValid()) {
            $this->incrementUsage();
            return true;
        }
        return false;
    }

    public function getDiscountAmount($subtotal)
    {
        $result = $this->apply($subtotal);
        return $result['valid'] ? $result['discount'] : 0;
    }

    public function isFullyUsed()
    {
        if ($this->usage_limit === null) {
            return false;
        }
        return $this->used >= $this->usage_limit;
    }

    // ============ STATIC METHODS ============

    public static function getValidCoupon($code, $subtotal = 0)
    {
        $coupon = self::byCode($code)->first();
        if (!$coupon) {
            return null;
        }
        $result = $coupon->apply($subtotal);
        return $result['valid'] ? $coupon : null;
    }

    public static function generateUniqueCode($length = 10)
    {
        do {
            $code = strtoupper(Str::random($length));
        } while (self::where('code', $code)->exists());

        return $code;
    }

    /**
     * ✅ FIXED: findByCode() — database columns अनुसार
     */
    public static function findByCode(string $code): ?self
    {
        return static::where('code', strtoupper(trim($code)))
            ->where('status', true)
            ->where(function ($q) {
                $q->whereNull('start_date')
                  ->orWhere('start_date', '<=', now());
            })
            ->where(function ($q) {
                $q->whereNull('expire_date')
                  ->orWhere('expire_date', '>=', now());
            })
            ->where(function ($q) {
                $q->whereNull('usage_limit')
                  ->orWhereRaw('used < usage_limit');
            })
            ->first();
    }

    /**
     * ✅ FIXED: apply() — database columns अनुसार
     */
    public function apply(float $subtotal): array
    {
        if (!$this->isValid()) {
            return [
                'valid' => false,
                'message' => 'Coupon is not valid or has expired.',
            ];
        }

        if ($this->minimum_amount && $subtotal < $this->minimum_amount) {
            return [
                'valid' => false,
                'message' => 'Minimum order amount is Rs. ' . number_format($this->minimum_amount, 2),
            ];
        }

        $discount = 0;

        if ($this->type === 'percentage') {
            $discount = ($subtotal * $this->amount) / 100;

            if ($this->maximum_discount && $discount > $this->maximum_discount) {
                $discount = $this->maximum_discount;
            }
        } else {
            $discount = $this->amount;
        }

        $discount = min($discount, $subtotal);

        return [
            'valid' => true,
            'discount' => round($discount, 2),
            'message' => 'Coupon applied successfully.',
        ];
    }
}
