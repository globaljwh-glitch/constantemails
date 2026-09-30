<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Reset Your Password</title>
</head>
<body>

    <h2>Reset Your Password</h2>

    <p>Hello {{ $user->name }},</p>

    <p>
        We received a request to reset your Constant Emails password.
    </p>

    <p>
        Click the button below to create a new password.
    </p>

    <p>
        <a href="{{ route('password.reset', ['token' => $token]) }}"
           style="
                display:inline-block;
                padding:12px 25px;
                background:#ed2828;
                color:#fff;
                text-decoration:none;
                border-radius:4px;
           ">
            Reset Password
        </a>
    </p>

    <p>
        If you did not request a password reset, you can safely ignore this email.
    </p>

    <p>
        Regards,<br>
        Constant Emails
    </p>

</body>
</html>