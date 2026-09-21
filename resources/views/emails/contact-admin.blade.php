<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>New Contact Us Message</title>
</head>

<body style="font-family: Arial, sans-serif; background:#f5f5f5; padding:30px;">

<div style="
    max-width:650px;
    margin:0 auto;
    background:#ffffff;
    padding:30px;
    border:1px solid #e5e5e5;
">

    <h2 style="color:#ed2929; margin-top:0;">
        New Contact Us Message
    </h2>

    <p>
        You have received a new message from the Constant Emails website.
    </p>

    <table width="100%" cellpadding="8" cellspacing="0">

        <tr>
            <td width="30%">
                <strong>Name:</strong>
            </td>
            <td>
                {{ $contact->first_name }}
                {{ $contact->last_name }}
            </td>
        </tr>

        <tr>
            <td>
                <strong>Email:</strong>
            </td>
            <td>
                {{ $contact->email }}
            </td>
        </tr>

        <tr>
            <td>
                <strong>Organization:</strong>
            </td>
            <td>
                {{ $contact->organization ?: '-' }}
            </td>
        </tr>

        <tr>
            <td>
                <strong>Phone:</strong>
            </td>
            <td>
                {{ $contact->phone ?: '-' }}
            </td>
        </tr>

        <tr>
            <td>
                <strong>Date:</strong>
            </td>
            <td>
                {{ $contact->created_at->format('M d, Y h:i A') }}
            </td>
        </tr>

    </table>

    <hr style="margin:25px 0; border:0; border-top:1px solid #eee;">

    <h3>Message</h3>

    <div style="
        background:#f8f8f8;
        padding:15px;
        line-height:1.6;
    ">
        {!! nl2br(e($contact->comments)) !!}
    </div>

</div>

</body>
</html>