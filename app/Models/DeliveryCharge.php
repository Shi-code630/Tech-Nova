<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class DeliveryCharge extends Model
{
    protected $table = 'delivery_charges';

    protected $fillable = ['district', 'charge', 'status'];

    protected $casts = [
        'charge' => 'decimal:2',
        'status' => 'boolean',
    ];

    // Scopes
    public function scopeActive($query)
    {
        return $query->where('status', true);
    }

    // Get charge by district
    public static function getCharge($district)
    {
        $delivery = static::where('district', $district)->where('status', true)->first();
        return $delivery ? $delivery->charge : 0;
    }
}
