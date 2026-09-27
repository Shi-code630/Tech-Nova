<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;

class UserReward extends Model
{
    protected $fillable = [
        'user_id',
        'spin_reward_id',
        'spin_attempt_id',
        'reward_name',
        'reward_type',
        'coupon_code',
        'coins',
        'status',
        'claimed_at',
    ];

    protected $casts = [
        'coins' => 'integer',
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

    public function spinAttempt(): BelongsTo
    {
        return $this->belongsTo(SpinAttempt::class);
    }
}
