<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Verify Your Email</title>
</head>
<body>

    <h2>Welcome to Constant Emails</h2>

    <p>Hello {{ $user->name }},</p>

    <p>
        Thank you for registering with Constant Emails.
        Please verify your email address to activate your account.
    </p>

    <p>
        <a href="{{ route('email.verify', ['token' => $user->verification_token]) }}"
           style="
                display:inline-block;
                padding:12px 25px;
                background:#ed2828;
                color:#ffffff;
                text-decoration:none;
                border-radius:4px;
           ">
            Verify My Email
        </a>
    </p>

    <p>
        Your account will remain inactive until you verify your email address.
    </p>

    <p>
        Regards,<br>
        Constant Emails
    </p>

</body>
</html>