<?php

namespace App\Mail;

use App\Models\JobApplication;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use Illuminate\Mail\Mailables\Attachment;
use Illuminate\Mail\Mailables\Content;
use Illuminate\Mail\Mailables\Envelope;
use Illuminate\Queue\SerializesModels;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class NewJobApplicationMail extends Mailable
{
    use Queueable, SerializesModels;

    public function __construct(public JobApplication $application)
    {
    }

    public function envelope(): Envelope
    {
        return new Envelope(
            subject: 'New Application: ' . $this->application->job_title,
            replyTo: $this->application->email,
        );
    }

    public function content(): Content
    {
        return new Content(
            view: 'emails.new-job-application',
        );
    }

    public function attachments(): array
    {
        // 1. Resume path chhaina bhane skip
        if (empty($this->application->resume_path)) {
            Log::warning('Resume path empty for application ID: ' . $this->application->id);
            return [];
        }

        // 2. File exist chhaina bhane skip
        if (!Storage::disk('public')->exists($this->application->resume_path)) {
            Log::warning('Resume file NOT FOUND: ' . $this->application->resume_path);
            return [];
        }

        // 3. Extension ra filename
        $extension = pathinfo($this->application->resume_path, PATHINFO_EXTENSION);
        $filename  = 'Resume-' . Str::slug($this->application->name) . '.' . $extension;

        // 4. Full path
        $fullPath = Storage::disk('public')->path($this->application->resume_path);

        // 5. MIME type
        $mime = mime_content_type($fullPath) ?: 'application/octet-stream';

        Log::info('Attaching resume', [
            'path'     => $fullPath,
            'filename' => $filename,
            'mime'     => $mime,
            'size'     => Storage::disk('public')->size($this->application->resume_path),
        ]);

     
        return [
            Attachment::fromPath($fullPath)
                ->as($filename)
                ->withMime($mime),
        ];
    }
}
