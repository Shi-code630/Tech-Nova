<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Facades\Storage;

class JobApplication extends Model
{
    use HasFactory;

    protected $fillable = [
        'job_title',
        'name',
        'email',
        'phone',
        'resume_path',
        'message',
        'status',
    ];

    /**
     * Full public URL to the uploaded resume.
     */
    public function getResumeUrlAttribute(): ?string
    {
        return $this->resume_path
            ? Storage::url($this->resume_path)
            : null;
    }

    public function scopePending($query)
    {
        return $query->where('status', 'pending');
    }
}
