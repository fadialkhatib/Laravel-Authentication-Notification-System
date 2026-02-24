<!DOCTYPE html>
<html lang="en" style="margin:0; padding:0;">
<head>
    <meta charset="UTF-8">
    <title>Welcome Email</title>
</head>
<body style="margin:0; padding:0; background:#f4f4f4; font-family:Arial, sans-serif;">
    <table width="100%" cellpadding="0" cellspacing="0" style="background:#f4f4f4; padding:40px 0;">
        <tr>
            <td align="center">
                <table width="600" cellpadding="0" cellspacing="0" style="background:#ffffff; border-radius:10px; overflow:hidden;">
                    
                    <!-- Header -->
                    <tr>
                        <td style="background:#4f46e5; padding:20px; text-align:center; color:white;">
                            <h1 style="margin:0; font-size:24px;">Welcome to Our Platform</h1>
                        </td>
                    </tr>

                    <!-- Body -->
                    <tr>
                        <td style="padding:30px; color:#333;">
                            <h2 style="margin-top:0;">Hello {{ $email }} 👋</h2>
                            <p style="font-size:16px; line-height:1.6;">
                                We're excited to have you on board.  
                                Click the button below to continue:
                            </p>

                            <!-- CTA Button -->
                            <p style="text-align:center; margin:30px 0;">
                                <a href="{{ $actionUrl }}"
                                   style="background:#4f46e5; color:#ffffff; text-decoration:none; padding:14px 28px; border-radius:6px; font-size:16px; display:inline-block;">
                                    {{ $actionText }}
                                </a>
                            </p>

                            <p style="font-size:14px; line-height:1.6; color:#666;">
                                If the button doesn't work, copy this link:<br>
                                <span style="color:#4f46e5;">{{ $actionUrl }}</span>
                            </p>

                            <p style="font-size:16px; line-height:1.6;">
                                Best regards,<br>
                                <strong>Laravel Queue Team</strong>
                            </p>
                        </td>
                    </tr>

                    <!-- Footer -->
                    <tr>
                        <td style="background:#f0f0f0; padding:15px; text-align:center; font-size:14px; color:#777;">
                            © {{ date('Y') }} Laravel Queue. All rights reserved.
                        </td>
                    </tr>

                </table>
            </td>
        </tr>
    </table>
</body>
</html>