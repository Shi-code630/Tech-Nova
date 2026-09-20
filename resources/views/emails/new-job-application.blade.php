<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>New Job Application</title>
</head>

<body style="margin:0; padding:0; background-color:#f3f4f6; font-family: Arial, Helvetica, sans-serif; -webkit-text-size-adjust:100%; -ms-text-size-adjust:100%;">

    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0"
        style="background-color:#f3f4f6; padding: 30px 0;">

        <tr>
            <td align="center" class="email-wrapper" style="padding: 30px 15px;">

                {{-- ===== CARD ===== --}}
                <table role="presentation" width="600" cellpadding="0" cellspacing="0" border="0"
                    class="email-card"
                    style="width:100%; max-width:600px; background-color:#ffffff; border-radius:16px; overflow:hidden; box-shadow: 0 1px 3px rgba(0,0,0,0.08);">

                    {{-- ===== HEADER ===== --}}
                    <tr>
                        <td class="email-header"
                            style="background: linear-gradient(135deg, #2563EB, #1E40AF); padding: 28px 32px;">
                            <h1 style="margin:0; color:#ffffff; font-size:20px; line-height:1.4; font-weight:bold;">
                                New Job Application
                            </h1>
                        </td>
                    </tr>

                    {{-- ===== BODY ===== --}}
                    <tr>
                        <td class="email-body" style="padding: 28px 32px;">

                            <p style="margin:0 0 20px 0; color:#374151; font-size:15px; line-height:1.6;">
                                A new application has been submitted through the careers page.
                            </p>

                            {{-- ===== INFO TABLE ===== --}}
                            <table role="presentation" width="100%" cellpadding="0" cellspacing="0" border="0"
                                style="margin-bottom: 24px;">

                                <tr>
                                    <td class="info-label"
                                        style="padding: 8px 0; color:#6b7280; font-size:14px; width:130px; vertical-align:top;">
                                        Position
                                    </td>
                                    <td class="info-value"
                                        style="padding: 8px 0; color:#111827; font-size:14px; font-weight:bold; word-break:break-word;">
                                        {{ $application->job_title }}
                                    </td>
                                </tr>

                                <tr>
                                    <td class="info-label"
                                        style="padding: 8px 0; color:#6b7280; font-size:14px; vertical-align:top;">
                                        Name
                                    </td>
                                    <td class="info-value"
                                        style="padding: 8px 0; color:#111827; font-size:14px; word-break:break-word;">
                                        {{ $application->name }}
                                    </td>
                                </tr>

                                <tr>
                                    <td class="info-label"
                                        style="padding: 8px 0; color:#6b7280; font-size:14px; vertical-align:top;">
                                        Email
                                    </td>
                                    <td class="info-value"
                                        style="padding: 8px 0; color:#111827; font-size:14px; word-break:break-all;">
                                        {{ $application->email }}
                                    </td>
                                </tr>

                                <tr>
                                    <td class="info-label"
                                        style="padding: 8px 0; color:#6b7280; font-size:14px; vertical-align:top;">
                                        Phone
                                    </td>
                                    <td class="info-value"
                                        style="padding: 8px 0; color:#111827; font-size:14px; word-break:break-word;">
                                        {{ $application->phone }}
                                    </td>
                                </tr>

                            </table>

                            {{-- ===== MESSAGE ===== --}}
                            @if($application->message)
                                <div class="message-box"
                                    style="background:#f9fafb; border:1px solid #e5e7eb; border-radius:12px; padding:16px; margin-bottom:24px;">

                                    <p style="margin:0 0 6px 0; color:#6b7280; font-size:13px; font-weight:bold;">
                                        Message
                                    </p>

                                    <p style="margin:0; color:#374151; font-size:14px; line-height:1.6; word-break:break-word; white-space:pre-line;">
                                        {{ $application->message }}
                                    </p>

                                </div>
                            @endif

                            <p style="margin:0 0 20px 0; color:#374151; font-size:14px; line-height:1.6;">
                                The applicant's resume is attached to this email.
                            </p>

                            {{-- ===== BUTTON ===== --}}
                            @if($application->resume_url)
                                <a href="{{ $application->resume_url }}"
                                    class="resume-btn"
                                    style="display:inline-block; background:#2563EB; color:#ffffff; text-decoration:none; padding:12px 24px; border-radius:10px; font-size:14px; font-weight:bold; line-height:1.4;">
                                    Download Resume
                                </a>
                            @endif

                        </td>
                    </tr>

                    {{-- ===== FOOTER ===== --}}
                    <tr>
                        <td class="email-footer"
                            style="padding: 20px 32px; border-top:1px solid #f3f4f6;">
                            <p style="margin:0; color:#9ca3af; font-size:12px; line-height:1.5;">
                                {{ config('app.name') }}
                            </p>
                        </td>
                    </tr>

                </table>

            </td>
        </tr>
    </table>

</body>
</html>
