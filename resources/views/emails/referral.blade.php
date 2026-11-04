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
                                            <!-- <tr>
                                                <td style="padding-bottom: 10px;">Your complimentary 90-day trial is now active, and it’s the perfect time to explore everything our platform has to offer. </td>
                                            </tr>
                                            <tr>
                                                <td style="padding-bottom: 10px;">During the next 90 days, you’ll enjoy access to all of our standard features. You can send up to 2,000 emails, organize and manage your contact lists, customize professional templates, track campaign reports, and much more—completely free. The trial includes the same powerful tools available in our paid plans; the only limitation is the email sending allowance.</td>
                                            </tr>
                                            <tr>
                                                <td style="padding-bottom: 10px;">When your free trial comes to an end, you’ll need to upgrade to a paid subscription to continue using our premium email marketing services. So, until that date arrives, have fun!</td>
                                            </tr>
                                            <tr>
                                                <td>
                                                <h2 style="color:#e62d29; padding-bottom: 15px; margin: 0px;">Account Information</h2>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td align="left">
                                                    <table cellspacing="0" cellpadding="0" width="100%" bgcolor="#e5e5e5" style="border: 1px solid #e5e5e5; margin-top: 0px;">
                                                    <tbody>
                                                        <tr>
                                                            <td colspan="2" valign="middle" bgcolor="#e62d29" style="font-size:15px; padding-left: 10px; padding-right: 10px; padding-top: 10px; padding-bottom:10px; color: #ffffff;">Here are your login credentials to begin using your account:</td>
                                                        </tr>
                                                        <tr>
                                                            <td width="120" valign="middle" bgcolor="#e5e5e5" style="font-size:15px; padding-left: 10px; padding-right: 10px; padding-top: 10px; padding-bottom:10px;"><strong>USER NAME:</strong></td>
                                                            <td width="296" valign="middle" bgcolor="#ffffff" style="font-size:15px; padding-left: 10px; padding-right: 10px; padding-top: 10px; padding-bottom:10px;">(suser)</td>
                                                        </tr>
                                                        <tr>
                                                            <td width="90" valign="middle" bgcolor="#e5e5e5" style="font-size:15px; padding-left: 10px; padding-right: 10px; padding-top: 10px; padding-bottom:10px;"><strong>PASSWORD:</strong></td>
                                                            <td valign="middle" bgcolor="#ffffff" style="font-size:15px; padding-left: 10px; padding-right: 10px; padding-top: 10px; padding-bottom:10px;">(spwd)</td>
                                                        </tr>
                                                    </tbody>
                                                </table> -->
                                                <!--br />
                                                <table cellspacing="0" cellpadding="5" border="0" width="100%" style="border: 2px dashed rgb(153, 153, 153);">
                                                    <tbody>
                                                        <tr>
                                                            <td bgcolor="#ffffe1" align="center" valign="middle">
                                                                <a href="{{ route('verify.email', ['token' => $user->verification_token]) }}">
                                                                    <strong>Click here to confirm your email address </strong>
                                                                </a>
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td height="25" align="left" valign="bottom" style="padding-top:20px;">
                                                <h2 style="color:#e62d29; padding-bottom: 15px; margin: 0px;">Creating a contact list</h2>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="padding-bottom:10px;">To create campaigns, manage contacts, or access any account features, simply sign in and click the <strong>“My Account”</strong> button located in the upper-right corner of your dashboard. </td>
                                            </tr>
                                            <tr>
                                                <td style="padding-bottom:10px;">Building a contact list is quick and simple. To create a new group, open the <strong>“Contacts/Groups”</strong> tab and select <strong>“Add Group.”</strong> After naming and organizing your group, you can begin adding contacts using any of the following methods:</td>
                                            </tr>
                                            <tr>
                                                <td style="padding-bottom:5px;"><strong>Option 1: Manually Enter Contacts</strong></td>
                                            </tr>
                                            <tr>
                                                <td style="padding-bottom:12px;">Enter email addresses individually, making it ideal for adding a small number of contacts quickly.</td>
                                            </tr>
                                            <tr>
                                                <td style="padding-bottom:5px;"><strong>Option 2: Upload an Existing Contact Database</strong></td>
                                            </tr>
                                            <tr>
                                                <td style="padding-bottom:12px;">Upload your existing contact database directly from your computer in just a few steps.</td>
                                            </tr>
                                            <tr>
                                                <td style="padding-bottom:5px;"><strong>Option 3: Use the List Builder</strong></td>
                                            </tr>
                                            <tr>
                                                <td style="padding-bottom:12px;">Embed our customizable signup form on your website so visitors can submit their details, which are then automatically added to your contact list.</td>
                                            </tr> 
                                            <tr>
                                                <td style="padding-bottom:12px;">Our dedicated support team is always available to help whenever you need assistance. You’ll also find detailed guides and feature walkthroughs in our <strong>FAQ (Frequently Asked Questions)</strong> section. If you have any questions, feel free to email or call us anytime. </td>
                                            </tr>-->
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