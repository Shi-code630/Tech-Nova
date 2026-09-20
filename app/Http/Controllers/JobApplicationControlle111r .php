<?php

namespace App\Http\Controllers;

use App\Mail\NewJobApplicationMail;
use App\Models\JobApplication;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;

class JobApplicationController extends Controller
{
    public function store(Request $request): RedirectResponse
    {
        $validated = $request->validate([
            'job_title' => ['required', 'string', 'max:255'],
            'name' => ['required', 'string', 'max:255'],
            'email' => ['required', 'email', 'max:255'],
            'phone' => ['required', 'string', 'max:30'],
            'resume' => ['required', 'file', 'mimes:pdf,doc,docx', 'max:5120'], // 5MB
            'message' => ['nullable', 'string', 'max:2000'],
        ]);

        // Store the resume in storage/app/public/resumes
        $resumePath = $request->file('resume')->store('resumes', 'public');

        $application = JobApplication::create([
            'job_title' => $validated['job_title'],
            'name' => $validated['name'],
            'email' => $validated['email'],
            'phone' => $validated['phone'],
            'resume_path' => $resumePath,
            'message' => $validated['message'] ?? null,
            'status' => 'pending',
        ]);

        // Notify HR - falls back to config('mail.from.address') if MAIL_HR_ADDRESS isn't set
        $hrEmail = config('mail.hr_address', config('mail.from.address'));

        if ($hrEmail) {
            Mail::to($hrEmail)->send(new NewJobApplicationMail($application));
        }

        return redirect()
            ->back()
            ->with('application_success', 'Thanks for applying! We\'ve received your application for ' . $application->job_title . ' and will be in touch soon.');
    }
}
