<!DOCTYPE html>
<html lang="en">

<head>
    <title>Constant Emails - Invitation to Constant Emails</title>
</head>

<body>
<table cellspacing="0" cellpadding="0" border="0" align="center" width="650" bgcolor="#ffffff">
    <tbody>
        <tr>
            <td align="left" valign="top" style="border: 1px solid #E5E5E5;">
            <table cellspacing="0" cellpadding="0" border="0" width="100%">
                <tbody>
                    <tr>
                        <td height="60" align="left" width="350" valign="middle" style="padding-left:10px;padding-right:10px;padding-top:10px;padding-bottom:10px;">
                            <a href="https://constantemails.com/">
                                <img src="https://constantemails.com/assets/frontend/images/logo.jpg" height="54" border="0" width="" alt="" />
                            </a>
                        </td>
                        <!-- <td align="right" width="" valign="middle" style="padding-left:10px;padding-right:10px;padding-top:10px;padding-bottom:10px;"><a href="https://constantemails.com/login"><img height="" border="0" width="" src="https://constantemails.com/assets/frontend/images/btn-login-green.png" alt="" /></a></td> -->
                    </tr>
                </tbody>
            </table>
            </td>
        </tr>
        <tr>
            <td align="left" valign="top" colspan="2" bgcolor="#e62d29">
            <table cellspacing="0" cellpadding="0" border="0" width="100%">
                <tbody>
                    <tr>
                        <td height="" align="left" valign="middle" style="padding-left:15px;padding-right:15px;padding-top:12px;padding-bottom:12px; color: #ffffff; font-size: 17px;">You have been invited to Constant Emails</td>
                    </tr>
                </tbody>
            </table>
            </td>
        </tr>
        <tr>
            <td align="left" valign="top" style="border: 1px solid #E5E5E5; ">
            <table cellspacing="0" cellpadding="0" border="0" width="100%">
                <tbody>
                    <tr>
                        <td align="left" valign="top">
                        <table cellspacing="0" cellpadding="0" border="0" width="100%">
                            <tbody>
                                <tr>
                                    <td align="center" width="450" valign="top" style="padding-top:20px; padding-left:20px; padding-right: 20px;">
                                    <table cellspacing="0" cellpadding="0" border="0" align="center" width="100%">
                                        <tbody>
                                            <tr>
                                                <td align="left" valign="top" style="font-size:17px; padding-bottom: 10px;"><strong>Dear {{ $friendName }},</strong></td>
                                            </tr>
                                            <tr>
                                                <td style="padding-bottom: 10px;">

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

                                                </td>
                                            </tr>
                                            
                                            <tr>
                                                <td height="20" align="left" valign="bottom">&nbsp;</td>
                                            </tr>
                                            <tr>
                                                <td height="20" align="left" valign="bottom"><strong style="color:#e62d29;">Best regards,</strong>                                                                     <br />
                                                Constant Emails Support Team                                                                     <br />
                                                <strong>Email: </strong><a href="http://constantemails.com/contact.php">support@constantemails.com</a>                                                                     <br />
                                                <strong>Website: </strong><a href="http://constantemails.com">www.constantemails.com</a>                                                                     <br />
                                                <strong>Phone</strong>: USA (732)-238-9980</td>
                                            </tr>
                                            <tr>
                                                <td height="25" align="left" valign="bottom">&nbsp;</td>
                                            </tr>
                                        </tbody>
                                    </table>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                        </td>
                    </tr>
                </tbody>
            </table>
            </td>
        </tr>
        <tr>
            <td height="" align="left" valign="middle">
            <table cellspacing="0" cellpadding="0" border="0" width="100%">
                <tbody>
                    <tr>
                        <td height="30" align="center" width="600" valign="bottom" class="arial_12_000" style="padding-top: 15px;"><a href="https://constantemails.com/privacy-policy" class="arial_12_000">Privacy Policy</a> | <a href="https://constantemails.com/terms" class="arial_12_000">Terms and Conditions</a> | <a href="https://constantemails.com/antispam" class="arial_12_000">Anti-Spam Policy</a> | <a href="https://constantemails.com/contact" class="arial_12_000">Contact Us</a></td>
                    </tr>
                    <tr>
                        <td height="37" align="center" valign="top" class="arial_12_818181" style="padding-top: 5px;">&copy; Copyright 2026 Constant Emails. All Rights Reserved.</td>
                    </tr>
                </tbody>
            </table>
            </td>
        </tr>
    </tbody>
</table>
</body>

</html>