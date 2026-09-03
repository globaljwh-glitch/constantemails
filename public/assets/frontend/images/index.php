<?php
include("conection.php");
/*$loadClass = SB_Modules::loadClass('Modules_Login');
$loginObject = new Modules_Login('5luqnsk0n4p');
$loginObject->init();
$loginObject->processAction();
*/?>
<!DOCTYPE html PUBLIC "-//W3C//DTD HTML 4.01 Transitional//EN">
<html>
<head>
<link rel="SHORTCUT ICON" href="http://www.constantemails.com/favicon.ico">

<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
<title>Constant Emails - Home</title>
<meta name="DESCRIPTION" content="Constant Email ">
<meta name="KEYWORDS" content="Constant Email ">
<meta name="GENERATOR" content="Parallels Plesk Sitebuilder 4.5.0">
<link href="css/styles.css" rel="stylesheet" type="text/css">
</head>
<body>
<table width="100%" border="0" cellspacing="0" cellpadding="0">
  
  <tr>
    <td align="center" valign="top" class="main_bg"><table width="780" border="0" cellspacing="0" cellpadding="0">
     <?php include('header.php');?>
      <tr>
        <td height="18" align="left" valign="top">&nbsp;</td>
      </tr>
      <tr>
        <td align="center" valign="top"><table style="margin-bottom:40px;" width="774" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td width="521" align="left" valign="top"><table width="519" border="0" cellspacing="0" cellpadding="0"><tr><td align="justify" class="arial_11_000" valign="top"> Your mailing lists uploaded to send bulk emails using our email engine are safe and secure (our website has a built-in 256-bit data encryption) and only you have access to your mailing list (not even our admin). Your credit card information submitted for payment is processed by Authorize.net through Secure Sockets Layer (SSL) which is designed to ensure safety and security of sensitive information. Your credit card information IS NOT STORED on our website or server.<br /></td></tr>
              <tr>
                <td width="513" height="42" align="left" valign="top" class="thoma_30_000">Welcome to Constant Emails</br></br></td>
              </tr>
              <tr>
                <td height="0" align="left" valign="top" class="arial_13_000"><p>Constant Emails is the new way to send customized and attractive-looking emails! We are an email engine that gives you the tools and capability to send out nice, eye-catching emails to a multiple number of contacts.<br/>
                </p>
                  <ul>
                    <li>Have you ever wanted to send emails with a custom layout that includes images and even a background?
<li>Have you ever wanted to say "Thank you" in a more expressive and colorful way to all of your contacts at once?
<li>As a business, have you ever needed to creatively present all of your customers a promotion or notify them of events being held by your company?
</ul> <br />


If so, Constant Emails is the right place to do just that! <br />
We provide you with effective tools to create, send, and track email messages that help to communicate your ideas in a more visual way!<br/>
<br />
<?php if(!isset($_SESSION['id'])) { ?>
<a href="registration.php" class="arial_13_c43e00">Register today</a> and start taking adavntage of all of our features for<b> FREE</b>!
<?php } ?>
              </tr>
              <tr>
                <td height="65" align="left" valign="top" class="line_hori">&nbsp;</td>
              </tr>
              <tr>
                <td class="thoma_23_0c5aaa" height="42" align="left" valign="top">Constant Emails Services</td>
              </tr>
              <tr>
                <td height="0" align="left" valign="top"><?php include('services.php');?></td>
              </tr>
              <tr>
                <td height="14" align="left" valign="top"></td>
              </tr>
              </table></td>
            <td width="38" align="left" valign="top" class="line_ver">&nbsp; </td>
            <td width="224" align="left" valign="top"><?php 
					
							 include('sidebar_default.php');	
							
					?></td>
          </tr>
        </table></td>
      </tr>
    </table></td>
  </tr>
  <tr>
    <td height="67" align="center" valign="top" class="arial_12_000"><?php include('footer.php');?></td>
  </tr>
</table>
</body>
</html>
