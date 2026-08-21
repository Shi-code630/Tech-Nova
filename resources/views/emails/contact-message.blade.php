<!DOCTYPE html>
<html>
<head>
    <title>New Contact Message</title>
    <style>
        body { font-family: Arial, sans-serif; line-height: 1.6; color: #333; }
        .container { max-width: 600px; margin: 0 auto; padding: 20px; }
        .header { background: #4a6cf7; color: white; padding: 20px; text-align: center; }
        .content { background: #f9f9f9; padding: 20px; border-radius: 5px; }
        .message-box { background: white; padding: 15px; border-left: 4px solid #4a6cf7; margin: 15px 0; }
        .detail { margin: 10px 0; }
        .label { font-weight: bold; color: #555; }
        .footer { text-align: center; padding: 20px; color: #777; font-size: 12px; }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h2>New Contact Message</h2>
        </div>

        <div class="content">
            <div class="detail">
                <span class="label">Name:</span> {{ $contactMessage->name }}
            </div>
            <div class="detail">
                <span class="label">Email:</span> {{ $contactMessage->email }}
            </div>
            <div class="detail">
                <span class="label">Phone:</span> {{ $contactMessage->phone ?? 'Not provided' }}
            </div>
            <div class="detail">
                <span class="label">Subject:</span> {{ $contactMessage->subject }}
            </div>
            <div class="detail">
                <span class="label">Date:</span> {{ $contactMessage->created_at->format('F j, Y, g:i a') }}
            </div>

            <div class="message-box">
                <p><strong>Message:</strong></p>
                <p>{{ $contactMessage->message }}</p>
            </div>
        </div>

        <div class="footer">
            <p>This message was sent from your website contact form.</p>
            <p>To reply, use: {{ $contactMessage->email }}</p>
        </div>
    </div>
</body>
</html>
