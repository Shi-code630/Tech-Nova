<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;

class SpinReward extends Model
{
    protected $fillable = [
        'name',
        'type',
        'discount_percent',
        'coins',
        'description',
        'stock',
        'probability',
        'status',
    ];

    protected $casts = [
        'discount_percent' => 'integer',
        'coins' => 'integer',
        'stock' => 'integer',
        'probability' => 'decimal:4',
        'status' => 'boolean',
    ];

    public function spinAttempts(): HasMany
    {
        return $this->hasMany(SpinAttempt::class);
    }

    public function userRewards(): HasMany
    {
        return $this->hasMany(UserReward::class);
    }
}
