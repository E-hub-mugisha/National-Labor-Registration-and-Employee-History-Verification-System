<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Your Employer Account</title>
    <style>
        body {
            font-family: 'Segoe UI', Arial, sans-serif;
            background: #f4f6f9;
            margin: 0;
            padding: 0;
            color: #1a1a2e;
        }

        .wrapper {
            max-width: 580px;
            margin: 2rem auto;
            background: #fff;
            border-radius: 12px;
            overflow: hidden;
            box-shadow: 0 2px 12px rgba(0, 0, 0, .08);
        }

        .header {
            background: #0d6efd;
            padding: 2rem 2.5rem;
            text-align: center;
        }

        .header h1 {
            color: #fff;
            margin: 0;
            font-size: 1.4rem;
            font-weight: 700;
        }

        .header p {
            color: rgba(255, 255, 255, .8);
            margin: .4rem 0 0;
            font-size: .85rem;
        }

        .body {
            padding: 2rem 2.5rem;
        }

        .body p {
            line-height: 1.65;
            margin: 0 0 1rem;
            font-size: .9rem;
        }

        .creds {
            background: #f0f5ff;
            border: 1px solid #c7d9ff;
            border-radius: 8px;
            padding: 1.25rem 1.5rem;
            margin: 1.25rem 0;
        }

        .creds-row {
            display: flex;
            justify-content: space-between;
            align-items: center;
            padding: .4rem 0;
            border-bottom: 1px solid #dde8ff;
            font-size: .875rem;
        }

        .creds-row:last-child {
            border-bottom: none;
        }

        .creds-label {
            color: #6c757d;
            font-weight: 600;
        }

        .creds-val {
            font-weight: 700;
            color: #0d6efd;
            letter-spacing: .03em;
        }

        .btn {
            display: inline-block;
            background: #0d6efd;
            color: #fff !important;
            text-decoration: none;
            padding: .75rem 2rem;
            border-radius: 8px;
            font-weight: 700;
            font-size: .9rem;
            margin: .5rem 0 1.5rem;
        }

        .notice {
            background: #fff8e1;
            border-left: 3px solid #ffc107;
            border-radius: 4px;
            padding: .75rem 1rem;
            font-size: .82rem;
            color: #6d5500;
            margin: 1rem 0;
        }

        .footer {
            background: #f8f9fa;
            padding: 1.25rem 2.5rem;
            text-align: center;
            font-size: .75rem;
            color: #adb5bd;
            border-top: 1px solid #dee2e6;
        }

        .footer a {
            color: #0d6efd;
            text-decoration: none;
        }
    </style>
</head>

<body>
    <div class="wrapper">

        {{-- Header --}}
        <div class="header">
            <h1>🏢 Employer Account Created</h1>
            <p>{{ config('app.name') }} — Employment Records Platform</p>
        </div>

        {{-- Body --}}
        <div class="body">
            <p>Dear <strong>{{ $employer->name }}</strong>,</p>

            <p>
                Thank you for registering on <strong>{{ config('app.name') }}</strong>.
                Your employer account has been successfully created and is currently
                <strong>pending review</strong> by our team.
            </p>

            <p>Here are your login credentials:</p>

            <div class="creds">
                <div class="creds-row">
                    <span class="creds-label">Email</span>
                    <span class="creds-val">{{ $user->email }}</span>
                </div>
                <div class="creds-row">
                    <span class="creds-label">Temporary Password</span>
                    <span class="creds-val">{{ $plainPassword }}</span>
                </div>
                <div class="creds-row">
                    <span class="creds-label">Account Status</span>
                    <span class="creds-val" style="color:#ffc107">Pending Verification</span>
                </div>
            </div>

            <div class="notice">
                ⚠️ <strong>Please change your password</strong> immediately after your first login.
                Your account will become fully active once verified by our team.
            </div>

            <p style="text-align:center">
                <a href="{{ $loginUrl }}" class="btn">Sign In to Your Account</a>
            </p>

            <p>
                Once your account is verified, you will be able to:
            </p>
            <ul style="font-size:.88rem;line-height:1.7;padding-left:1.25rem">
                <li>Add and manage employment records for your employees</li>
                <li>Issue conduct ratings and exit reports</li>
                <li>Verify employee backgrounds</li>
                <li>Manage transfer requests</li>
            </ul>

            <p>
                If you have any questions or need support, please contact us at
                <a href="mailto:{{ config('mail.from.address') }}">{{ config('mail.from.address') }}</a>.
            </p>

            <p>Best regards,<br>
                <strong>{{ config('app.name') }} Team</strong>
            </p>
        </div>

        {{-- Footer --}}
        <div class="footer">
            &copy; {{ date('Y') }} {{ config('app.name') }}. All rights reserved.<br>
            If you did not register for this account, please ignore this email or
            <a href="mailto:{{ config('mail.from.address') }}">contact support</a>.
        </div>

    </div>
</body>

</html>