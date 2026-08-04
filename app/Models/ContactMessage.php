<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class ContactMessage extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'email',
        'phone',
        'subject',
        'message',
        'status'
    ];

    protected $casts = [
        'status' => 'boolean',
        'created_at' => 'datetime',
        'updated_at' => 'datetime'
    ];

    //  ACCESSORS 

    public function getStatusBadgeAttribute()
    {
        return $this->status ? 'success' : 'warning';
    }

    public function getStatusLabelAttribute()
    {
        return $this->status ? 'Read' : 'Unread';
    }

    public function getStatusIconAttribute()
    {
        return $this->status ? '✅' : '📩';
    }

    public function getMessageExcerptAttribute()
    {
        return strlen($this->message) > 100
            ? substr($this->message, 0, 100) . '...'
            : $this->message;
    }

    public function getFormattedDateAttribute()
    {
        return $this->created_at?->diffForHumans() ?? 'N/A';
    }

    //  SCOPES 

    public function scopeUnread($query)
    {
        return $query->where('status', false);
    }

    public function scopeRead($query)
    {
        return $query->where('status', true);
    }

    public function scopeToday($query)
    {
        return $query->whereDate('created_at', today());
    }

    public function scopeThisWeek($query)
    {
        return $query->whereBetween('created_at', [now()->startOfWeek(), now()->endOfWeek()]);
    }

    public function scopeSearch($query, $search)
    {
        return $query->where('name', 'LIKE', "%{$search}%")
                     ->orWhere('email', 'LIKE', "%{$search}%")
                     ->orWhere('subject', 'LIKE', "%{$search}%")
                     ->orWhere('message', 'LIKE', "%{$search}%")
                     ->orWhere('phone', 'LIKE', "%{$search}%");
    }

    //  HELPER METHODS 

    public function markAsRead()
    {
        $this->status = true;
        $this->save();
        return $this;
    }

    public function markAsUnread()
    {
        $this->status = false;
        $this->save();
        return $this;
    }

    public static function getUnreadCount()
    {
        return self::where('status', false)->count();
    }

    public static function getTotalCount()
    {
        return self::count();
    }
}
