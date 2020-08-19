<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title></title>
</head>
<body>

   <style>
    @font-face {
        font-family: 'Roboto-Bold';
        src: url('../fonts/Roboto-Bold.woff2') format('woff2'),
            url('../fonts/Roboto-Bold.woff') format('woff'),
            url('../fonts/Roboto-Bold.ttf') format('truetype'),
            url('../fonts/Roboto-Bold.svg#dosisregular') format('svg');
        font-weight: normal;
        font-style: normal;
    }
</style>
    <table width="860px" align="center" cellpadding="0" cellspacing="0" style="border: 1px solid #ccc;">
    <tbody>
    <tr>
    <td>
   <table bgcolor="#005ca8" align="center" width="860" border="0" cellpadding="0" cellspacing="0">
    <tbody>
        <tr>
            <td>
                <table width="780" align="center" cellpadding="0" cellspacing="0" style="padding: 13px 0px;">
                    <tbody>
                        <tr>
                            <td>
                                <table>
                                    <tbody>
                                        <tr>
                                            <td>
                                                <img alt="Logo" src="<?php echo $Logo; ?>" border="0" style="display:block; vertical-align:top;">
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
    </tbody>
</table>
<table width="860" height="3" align="center" cellpadding="0" cellspacing="0">
    <tbody><tr>
        <td style="border-top: 3px solid #fba510">
        </td>
        </tr>
    </tbody>
</table>
<table bgcolor="#ffffff" align="center" width="860" border="0" cellpadding="0" cellspacing="0">
    <tbody>
        <tr>
            <td>
                <table width="780" align="center" cellpadding="0" cellspacing="0" style="padding-top: 28px;padding-bottom: 18px;">
                    <tbody>
                        <tr>
                            <td>
                                <table width="80%" align="center" cellpadding="0" cellspacing="0">
                                    <tbody>
                                        <tr>
                                            <td width="30%">
                                                <img src="<?php echo $Logo_2; ?>">
                                            </td>
                                            <td width="5%" align="center" style="border-right: 2px solid #005ca8;"></td>
                                            <td width="5%"></td>
                                            <td width="80%">
                                                <table cellpadding="0" cellspacing="0">
                                                    <tbody>
                                                        <tr>
                                                            <td>
                                                                <p style="font-family: sans-serif;color: #333333;font-size: 14px;">Dear <strong><?php echo $first_name; ?>,</strong></p>
                                                                <p style="font-family: sans-serif;color: #333333;font-size: 14px;">We are verifying your identity with this email.</p>
                                                                <p style="font-family: sans-serif;color: #333333;font-size: 14px;line-height: 18px;">In order to continue with your registration, please enter the following code into the text field in your browser window.</p>
                                                                <p style="font-family: sans-serif;color: #333333;font-size: 14px;font-weight: bold;"><?php echo $code; ?></p>
                                                                <p style="font-family: sans-serif;color: #333333;font-size: 14px;margin-bottom: 5px;">Regards,</p>
                                                                <p style="font-family: sans-serif;color: #333333;font-size: 14px;font-weight: bold;margin-top: 0;">AuctionOnClick.com</p>
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
                    </tbody>
                </table>
            </td>
        </tr>
    </tbody>
</table>


    <table width="860" height="1" align="center" cellpadding="0" cellspacing="0">
        <tbody><tr>
            <td style="border-top: 1px solid #ccc;">
            </td>
            </tr>
        </tbody>
    </table>
    <table bgcolor="#ffffff" align="center" width="860" border="0" cellpadding="0" cellspacing="0">
        <tbody>
            <tr>
                <td>
                    <table width="780" align="center" cellpadding="0" cellspacing="0" style="padding-top: 12px;padding-bottom: 18px;">
                        <tbody>
                            <tr>
                                <td style="font-family: sans-serif;color: #666666;font-size: 11px;text-align: center;">
                                    <p style="margin:0;">All trademarks, logos and names are properties of their respective owners.</p>
                                    <p style="margin-top: 2px;">All Rights Reserved. © Copyright <?php echo date('Y');?> AuctionOnClick.</p>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
        </tbody>
    </table>
    <table bgcolor="#ffffff" align="center" width="860" border="0" cellpadding="0" cellspacing="0">
        <tbody>
            <tr>
                <td>
                    <table width="780" align="center" cellpadding="0" cellspacing="0" style="padding-bottom: 18px;">
                        <tbody>
                            <tr>
                                <td width="50%" style="font-family: sans-serif;color: #333333;font-size: 13px;text-align: right;">
                                    <p style="margin:0;padding-right: 5px;">Terms &amp; Conditions</p>
                                </td>
                                <td width="3%" style="color: #999999;text-align: center;">|</td>
                                <td width="50%" style="font-family: sans-serif;color: #333333;font-size: 13px;text-align: left;">
                                    <p style="margin:0;padding-left: 5px;">Privacy Policy</p>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
        </tbody>
    </table>
    <table bgcolor="#ffffff" align="center" width="860" border="0" cellpadding="0" cellspacing="0">
        <tbody>
            <tr>
                <td>
                    <table width="780" align="center" cellpadding="0" cellspacing="0" style="padding-bottom: 18px;">
                        <tbody>
                            <tr>
                                <td style="font-family: sans-serif;color: #333333;font-size: 13px;text-align: center;">
                                    <p style="margin:0;">If you do not wish to receive such emails, <a href="<?php echo base_url();?>" style="text-decoration: none;color: #0078db;">Unsubscribe here</a></p>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
        </tbody>
    </table>
      </td></tr></tbody></table>
    </body>
</html>