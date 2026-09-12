<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>New Job Application</title>
</head>
<body style="margin:0; padding:0; background-color:#f3f4f6; font-family: Arial, Helvetica, sans-serif;">

    <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="background-color:#f3f4f6; padding: 30px 0;">
        <tr>
            <td align="center">

                <table role="presentation" width="600" cellpadding="0" cellspacing="0" style="background-color:#ffffff; border-radius:16px; overflow:hidden; box-shadow: 0 1px 3px rgba(0,0,0,0.08);">

                    <tr>
                        <td style="background: linear-gradient(135deg, #2563EB, #1E40AF); padding: 28px 32px;">
                            <h1 style="margin:0; color:#ffffff; font-size:20px;">New Job Application</h1>
                        </td>
                    </tr>

                    <tr>
                        <td style="padding: 28px 32px;">
                            <p style="margin:0 0 20px 0; color:#374151; font-size:15px; line-height:1.6;">
                                A new application has been submitted through the careers page.
                            </p>

                            <table role="presentation" width="100%" cellpadding="0" cellspacing="0" style="margin-bottom: 24px;">
                                <tr>
                                    <td style="padding: 8px 0; color:#6b7280; font-size:14px; width:130px;">Position</td>
                                    <td style="padding: 8px 0; color:#111827; font-size:14px; font-weight:bold;">{{ $application->job_title }}</td>
                                </tr>
                                <tr>
                                    <td style="padding: 8px 0; color:#6b7280; font-size:14px;">Name</td>
                                    <td style="padding: 8px 0; color:#111827; font-size:14px;">{{ $application->name }}</td>
                                </tr>
                                <tr>
                                    <td style="padding: 8px 0; color:#6b7280; font-size:14px;">Email</td>
                                    <td style="padding: 8px 0; color:#111827; font-size:14px;">{{ $application->email }}</td>
                                </tr>
                                <tr>
                                    <td style="padding: 8px 0; color:#6b7280; font-size:14px;">Phone</td>
                                    <td style="padding: 8px 0; color:#111827; font-size:14px;">{{ $application->phone }}</td>
                                </tr>
                            </table>

                            @if($application->message)
                                <div style="background:#f9fafb; border:1px solid #e5e7eb; border-radius:12px; padding:16px; margin-bottom:24px;">
                                    <p style="margin:0 0 6px 0; color:#6b7280; font-size:13px; font-weight:bold;">Message</p>
                                    <p style="margin:0; color:#374151; font-size:14px; line-height:1.6;">{{ $application->message }}</p>
                                </div>
                            @endif

                            <p style="margin:0 0 20px 0; color:#374151; font-size:14px;">
                                The applicant's resume is attached to this email.
                            </p>

                            @if($application->resume_url)
                                <a href="{{ $application->resume_url }}"
                                   style="display:inline-block; background:#2563EB; color:#ffffff; text-decoration:none; padding:12px 24px; border-radius:10px; font-size:14px; font-weight:bold;">
                                    Download Resume
                                </a>
                            @endif
                        </td>
                    </tr>

                    <tr>
                        <td style="padding: 20px 32px; border-top:1px solid #f3f4f6;">
                            <p style="margin:0; color:#9ca3af; font-size:12px;">
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
