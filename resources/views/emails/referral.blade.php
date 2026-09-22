<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Invitation to Constant Emails</title>
</head>

<body style="font-family: Arial, sans-serif; background:#f5f5f5; padding:30px;">

<div style="
    max-width:600px;
    margin:auto;
    background:#ffffff;
    padding:30px;
">

    <h2 style="color:#ed2929;">
        You have been invited to Constant Emails
    </h2>

    <p>
        Hello {{ $friendName }},
    </p>

    <p>
        {{ $sender->name ?? 'A Constant Emails user' }}
        has invited you to try Constant Emails.
    </p>

    <p>
        Constant Emails helps businesses create, manage and send
        professional email marketing campaigns.
    </p>

    <p style="margin-top:30px;">

        <a
            href="{{ route('register') }}"
            style="
                display:inline-block;
                padding:12px 25px;
                background:#ed2929;
                color:#ffffff;
                text-decoration:none;
            "
        >
            Get Started
        </a>

    </p>

    <p style="margin-top:30px;">
        Regards,<br>
        <strong>Constant Emails Team</strong>
    </p>

</div>

</body>
</html>