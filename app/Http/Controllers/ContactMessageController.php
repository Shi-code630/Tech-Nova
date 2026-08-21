<?php

namespace App\Http\Controllers;

use App\Models\ContactMessage;
use App\Mail\ContactMessageMail;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Mail;
use Illuminate\Support\Facades\Log;

class ContactMessageController extends Controller
{
    /**
     * Show the contact form
     */
    public function create()
    {
        return view('frontend.contact-us');
    }

    /**
     * Store a new contact message
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255',
            'phone' => 'nullable|string|max:20',
            'subject' => 'required|string|max:255',
            'message' => 'required|string',
        ]);

        try {
            $contactMessage = ContactMessage::create($validated);

            // Send email to admin
            Mail::to('technova2083@gmail.com')->send(new ContactMessageMail($contactMessage));

            return redirect()->route('contact.create')
                ->with('success', 'Your message has been sent successfully!');

        } catch (\Exception $e) {
            Log::error('Contact message error: ' . $e->getMessage());

            return redirect()->route('contact.create')
                ->with('error', 'Failed to send message. Please try again later.');
        }
    }

    /**
     * Display a listing of all messages (Admin)
     */
    public function index()
    {
        $messages = ContactMessage::latest()->paginate(15);
        return view('admin.contact-messages.index', compact('messages'));
    }

    /**
     * Display a specific message (Admin)
     */
    public function show($id)
    {
        $message = ContactMessage::findOrFail($id);

        // Auto-mark as read when viewed
        if (!$message->status) {
            $message->markAsRead();
        }

        return view('admin.contact-messages.show', compact('message'));
    }

    /**
     * Mark a message as read (Admin)
     */
    public function markAsRead($id)
    {
        $message = ContactMessage::findOrFail($id);
        $message->markAsRead();

        return redirect()->route('admin.contact-messages.show', $id)
            ->with('success', 'Message marked as read!');
    }

    /**
     * Delete a message (Admin)
     */
    public function destroy($id)
    {
        $message = ContactMessage::findOrFail($id);
        $message->delete();

        return redirect()->route('admin.contact-messages.index')
            ->with('success', 'Message deleted successfully!');
    }
}
