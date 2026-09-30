<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Verify Email</title>
</head>
<body>

    <h2>Welcome to Constant Emails</h2>

    <p>Hello {{ $user->name }},</p>

    <p>
        Thank you for registering. Please verify your email address
        by clicking the button below.
    </p>

    <p>
        <a href="{{ route('verify.email', $user->verification_token) }}"
           style="display:inline-block;
                  padding:12px 25px;
                  background:#ed2929;
                  color:#fff;
                  text-decoration:none;">
            Verify Email
        </a>
    </p>

    <p>
        If you did not create this account, you can ignore this email.
    </p>

</body>
</html>