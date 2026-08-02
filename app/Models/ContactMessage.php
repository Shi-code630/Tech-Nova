<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class ContactMessage extends Model
{
    protected $fillable = [
        'name', 'email', 'phone', 'subject', 'message', 'status'
    ];


    public function scopeUnread($query)
    {
        return $query->where('status', false);
    }

    public function scopeRead($query)
    {
        return $query->where('status', true);
    }

    public function markAsRead()
    {
        $this->status = true;
        $this->save();
        return $this;
    }
}
