<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Thank You for Contacting Us</title>
</head>

<body style="font-family:Arial,sans-serif; background:#f5f5f5; padding:30px;">

<div style="
    max-width:650px;
    margin:0 auto;
    background:#ffffff;
    padding:30px;
    border:1px solid #e5e5e5;
">

    <h2 style="color:#ed2929;">
        Thank You for Contacting Us!
    </h2>

    <p>
        Dear {{ $contact->first_name }},
    </p>

    <p>
        Thank you for contacting Constant Emails.
        Your questions and concerns are our first priority.
    </p>

    <p>
        We have received your message and our support team will
        get back to you as soon as possible.
    </p>

    <p>
        We try our best to answer most messages within
        <strong>24 to 48 hours</strong>.
    </p>

    <hr style="margin:25px 0; border:0; border-top:1px solid #eee;">

    <p>
        Regards,<br>
        <strong>Constant Emails Support Team</strong>
    </p>

</div>

</body>
</html>