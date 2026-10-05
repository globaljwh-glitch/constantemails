<!DOCTYPE html>
<html>
<head>
    <meta charset="UTF-8">
    <title>Password Changed</title>
</head>

<body style="font-family: Arial, sans-serif; background:#f5f5f5; padding:30px;">

<table width="600" align="center" cellpadding="0" cellspacing="0"
       style="background:#ffffff; padding:30px;">

    <tr>
        <td>

            <h2 style="color:#ed1c24;">
                Password Changed Successfully
            </h2>

            <p>
                Hello {{ $user->name }},
            </p>

            <p>
                Your Constant Emails account password was successfully changed.
            </p>

            <p>
                If you made this change, no further action is required.
            </p>

            <p>
                If you did <strong>not</strong> change your password,
                please contact our support team immediately.
            </p>

            <p style="margin-top:30px;">
                Regards,<br>
                <strong>Constant Emails</strong>
            </p>

        </td>
    </tr>

</table>

</body>
</html>