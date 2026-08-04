<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Setting extends Model
{
    use HasFactory;

    protected $fillable = [
        // General
        'site_name', 'logo', 'phone', 'email', 'address',

        // Payment
        'currency', 'currency_symbol', 'payment_gateway',

        // Shipping
        'default_shipping_charge', 'free_shipping', 'free_shipping_threshold',

        // Email
        'smtp_host', 'smtp_port', 'smtp_username', 'smtp_password', 'smtp_encryption',

        // SEO
        'meta_title', 'meta_description', 'meta_keywords',

        // Social Media
        'facebook', 'instagram', 'twitter', 'linkedin', 'youtube',

        // Security
        'maintenance_mode', 'maintenance_message',

        // Timezone
        'timezone', 'date_format', 'time_format',

        // Other
        'copyright', 'footer_text', 'additional_settings'
    ];

    protected $casts = [
        'free_shipping' => 'boolean',
        'maintenance_mode' => 'boolean',
        'default_shipping_charge' => 'decimal:2',
        'free_shipping_threshold' => 'decimal:2',
        'additional_settings' => 'array'
    ];

    public static function getSettings()
    {
        return static::first() ?? new static();
    }

    public function getLogoUrlAttribute()
    {
        if ($this->logo) {
            return asset('storage/' . $this->logo);
        }
        return null;
    }

    public function getCurrencySymbolAttribute($value)
    {
        return $value ?? 'Rs.';
    }

    public function getCurrencyAttribute($value)
    {
        return $value ?? 'NPR';
    }
}
