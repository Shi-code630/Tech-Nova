<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Contact Message</title>
</head>

<body style="margin:0;padding:0;background-color:#eef4ff;font-family:Arial,Helvetica,sans-serif;color:#1f2937;">

    <div style="width:100%;padding:40px 15px;box-sizing:border-box;">

        <div style="max-width:650px;margin:0 auto;background:#ffffff;border-radius:16px;overflow:hidden;box-shadow:0 10px 30px rgba(0,0,0,0.08);">

            {{-- =====================================================
                HEADER
            ====================================================== --}}
            <div style="background:linear-gradient(135deg,#2563eb,#1d4ed8);padding:32px 20px;text-align:center;color:#ffffff;">

                <div style="width:58px;height:58px;line-height:58px;margin:0 auto 15px;background:rgba(255,255,255,0.15);border-radius:50%;font-size:26px;">
                    ✉
                </div>

                <h1 style="margin:0;font-size:22px;font-weight:700;line-height:1.3;">
                    New Contact Message
                </h1>

                <p style="margin:8px 0 0;font-size:13px;color:#dbeafe;line-height:1.5;">
                    You have received a new message from your website
                </p>

            </div>


            {{-- =====================================================
                CONTENT
            ====================================================== --}}
            <div style="padding:25px 18px;">

                <p style="margin:0 0 20px;font-size:14px;color:#6b7280;line-height:1.6;">
                    Someone has submitted a new message through your
                    website contact form. Here are the details:
                </p>


                {{-- =================================================
                    CONTACT DETAILS CARD
                ================================================== --}}
                <div style="border:1px solid #e5e7eb;border-radius:12px;overflow:hidden;margin-bottom:25px;">

                    {{-- Name --}}
                    <div style="padding:14px 16px;border-bottom:1px solid #e5e7eb;">
                        <div style="font-size:11px;color:#6b7280;margin-bottom:4px;text-transform:uppercase;letter-spacing:0.5px;">
                            Name
                        </div>
                        <div style="font-size:14px;font-weight:600;color:#111827;line-height:1.5;word-break:break-word;">
                            {{ $contactMessage->name }}
                        </div>
                    </div>


                    {{-- Email --}}
                    <div style="padding:14px 16px;border-bottom:1px solid #e5e7eb;">
                        <div style="font-size:11px;color:#6b7280;margin-bottom:4px;text-transform:uppercase;letter-spacing:0.5px;">
                            Email Address
                        </div>
                        <div style="font-size:14px;font-weight:600;color:#2563eb;line-height:1.5;word-break:break-all;">
                            {{ $contactMessage->email }}
                        </div>
                    </div>


                    {{-- Phone --}}
                    <div style="padding:14px 16px;border-bottom:1px solid #e5e7eb;">
                        <div style="font-size:11px;color:#6b7280;margin-bottom:4px;text-transform:uppercase;letter-spacing:0.5px;">
                            Phone
                        </div>
                        <div style="font-size:14px;font-weight:600;color:#111827;line-height:1.5;word-break:break-word;">
                            {{ $contactMessage->phone ?? 'Not provided' }}
                        </div>
                    </div>


                    {{-- Subject --}}
                    <div style="padding:14px 16px;border-bottom:1px solid #e5e7eb;">
                        <div style="font-size:11px;color:#6b7280;margin-bottom:4px;text-transform:uppercase;letter-spacing:0.5px;">
                            Subject
                        </div>
                        <div style="font-size:14px;font-weight:600;color:#111827;line-height:1.5;word-break:break-word;">
                            {{ $contactMessage->subject }}
                        </div>
                    </div>


                    {{-- Date --}}
                    <div style="padding:14px 16px;">
                        <div style="font-size:11px;color:#6b7280;margin-bottom:4px;text-transform:uppercase;letter-spacing:0.5px;">
                            Received On
                        </div>
                        <div style="font-size:14px;font-weight:600;color:#111827;line-height:1.5;word-break:break-word;">
                            {{ $contactMessage->created_at->format('F j, Y, g:i a') }}
                        </div>
                    </div>

                </div>


                {{-- =================================================
                    MESSAGE
                ================================================== --}}
                <div style="margin-top:25px;">

                    <h3 style="margin:0 0 10px;font-size:15px;color:#111827;">
                        Message
                    </h3>

                    <div style="background:#eff6ff;border-left:4px solid #2563eb;border-radius:8px;padding:16px;">
                        <p style="margin:0;font-size:14px;line-height:1.7;color:#374151;white-space:pre-line;word-break:break-word;">
                            {{ $contactMessage->message }}
                        </p>
                    </div>

                </div>


                {{-- =================================================
                    REPLY BUTTON
                ================================================== --}}
                <div style="text-align:center;margin-top:28px;">

                    <a href="mailto:{{ $contactMessage->email }}"
                        style="display:inline-block;background:#2563eb;color:#ffffff;text-decoration:none;padding:12px 22px;border-radius:8px;font-size:13px;font-weight:600;line-height:1.4;word-break:break-word;">
                        Reply to {{ $contactMessage->name }}
                    </a>

                </div>

            </div>


            {{-- =====================================================
                FOOTER
            ====================================================== --}}
            <div style="background:#f8fafc;border-top:1px solid #e5e7eb;padding:20px 18px;text-align:center;">

                <p style="margin:0 0 6px;font-size:12px;color:#6b7280;line-height:1.5;">
                    This message was sent from your website contact form.
                </p>

                <p style="margin:0;font-size:11px;color:#9ca3af;line-height:1.5;word-break:break-word;">
                    Please reply to:
                    <span style="color:#2563eb;">
                        {{ $contactMessage->email }}
                    </span>
                </p>

            </div>

        </div>

    </div>

</body>

</html>
