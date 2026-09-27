<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class SpinAttempt extends Model
{
    protected $fillable = [
        'user_id',
        'spin_reward_id',
        'reward_name',
        'status',
        'claimed_at',
    ];

    protected $casts = [
        'claimed_at' => 'datetime',
    ];

    public function user(): BelongsTo
    {
        return $this->belongsTo(User::class);
    }

    public function spinReward(): BelongsTo
    {
        return $this->belongsTo(SpinReward::class);
    }
}
