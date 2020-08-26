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
    <table width="860px" align="center" cellpadding="0" cellspacing="0" style="border: 1px solid #ccc;"><tbody><tr><td>
   <table bgcolor="#005ca8" align="center" width="860" border="0" cellpadding="0" cellspacing="0">
    <tbody>
        <tr>
            <td>
                <table width="780" height="90" align="center" cellpadding="0" cellspacing="0" style="padding: 13px 0px;">
                    <tbody>
                        <tr>
                            <td>
                                <table>
                                    <tbody>
                                        <tr>
                                            <td width="5%">&nbsp;</td>
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
        <table bgcolor="#ffffff" align="center" width="860" height="30" border="0" cellpadding="0" cellspacing="0">
            <tbody>
                <tr>
                    <td>
                        &nbsp;
                    </td>
                </tr>
            </tbody>
        </table>
<table bgcolor="#ffffff" align="center" width="860" border="0" cellpadding="0" cellspacing="0">
    <tbody>
        <tr>
            <td>
                <table width="780" align="center" cellpadding="0" cellspacing="0">
                    <tbody>
                        <tr>
                            <td style="font-family: sans-serif;color: #333333;font-size: 22px;text-align: center;">
                                <?php echo (int)count($auctionList); ?> New Auction property in <?php echo $city_name; ?>
                            </td>
                        </tr>
                    </tbody>
                </table>
            </td>
        </tr>
    </tbody>
</table>
        <table bgcolor="#ffffff" align="center" width="860" height="30" border="0" cellpadding="0" cellspacing="0">
            <tbody>
                <tr>
                    <td>
                        &nbsp;
                    </td>
                </tr>
            </tbody>
        </table>
    <table bgcolor="#ffffff" align="center" width="860" border="0" cellpadding="0" cellspacing="0">
        <tbody>
            <tr>
                <td>
                    <table width="780" align="center" cellpadding="0" cellspacing="0" style="">
                        <tbody>
                            <tr>
                                <td width="2%">&nbsp;</td>
                                <td>
                                    <table class="auction_table_box" style="border-collapse: collapse;width: 100%;">
                                        <thead>
                                            <tr>
                                                <th width="18%" style="font-size: 13px;padding: 18px 22px;background-color: #333333;color: #ffffff;font-family: sans-serif;border: 1px solid #4f4e4e;text-align: left;vertical-align: top;">Bank Name</th>
                                                <th width="25%" style="font-size: 13px;padding: 18px 22px;background-color: #333333;color: #ffffff;font-family: sans-serif;border: 1px solid #4f4e4e;text-align: left;vertical-align: top;">Asset Details</th>
                                                <th width="20%" style="font-size: 13px;padding: 18px 22px;background-color: #333333;color: #ffffff;font-family: sans-serif;border: 1px solid #4f4e4e;text-align: left;vertical-align: top;">EMD Submission Last Date</th>
                                                <th width="20%" style="font-size: 13px;padding: 18px 22px;background-color: #333333;color: #ffffff;font-family: sans-serif;border: 1px solid #4f4e4e;text-align: right;vertical-align: top;">Reserve Price</th>
                                                <th width="17%" style="font-size: 13px;padding: 18px 22px;background-color: #333333;color: #ffffff;font-family: sans-serif;border: 1px solid #4f4e4e;text-align: left;vertical-align: top;">View Details</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach($auctionList as $auction){ ?>
                                            <tr>
                                                <td style="font-size: 13px;padding: 18px 22px;color: #333333;font-family: sans-serif;border: 1px solid #ccc;text-align: left;"><?php echo $auction->bank_name; ?></td>
                                                <td style="font-size: 13px;padding: 18px 22px;color: #333333;font-family: sans-serif;border: 1px solid #ccc;text-align: left;"><?php echo $auction->subCategory;?> <?php echo $auction->parentCategory;?> in <?php echo $auction->reference_no; ?></td>
                                                <td style="font-size: 13px;padding: 18px 22px;color: #333333;font-family: sans-serif;border: 1px solid #ccc;text-align: left;"><?php echo date('Y-m-d',strtotime($auction->bid_last_date)); ?></td>
                                                <td style="font-size: 13px;padding: 18px 22px;color: #333333;font-family: sans-serif;border: 1px solid #ccc;text-align: right;">&#8377;<?php echo $auction->reserve_price; ?></td>
                                                <td style="font-size: 13px;padding: 18px 22px;color: #333333;font-family: sans-serif;border: 1px solid #ccc;text-align: center;"><a href="<?php echo base_url(); ?>home/auctionDetail/<?php echo $auction->listID; ?>" target="_blank"><img src="<?php echo $view_button; ?>"></a></td>
                                            </tr>
                                            <?php } ?>
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
        <table bgcolor="#ffffff" align="center" width="860" height="30" border="0" cellpadding="0" cellspacing="0">
            <tbody>
                <tr>
                    <td>
                        &nbsp;
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
                                <td width="35%"></td>
                                <td>
                                    <table width="228" height="40" align="center" cellpadding="0" cellspacing="0">
                                        <tbody>
                                            <tr>
                                                <td width="8%">&nbsp;</td>
                                                <td align="center" bgcolor="#0078db" style="border:none;-webkit-border-radius: 5px; -moz-border-radius: 5px;border-radius:4px;cursor:auto;padding:11px 20px;background:#0078db;" valign="middle">
                                                    <a href="<?php echo base_url(); ?>propertylisting?search_city=<?php echo $city_name; ?>&parent_id=" style="color:#ffffff !important;font-family:sans-serif;font-size:13px;font-weight:600;line-height:120%;Margin:0;text-decoration:none;text-transform:none;" target="_blank">
                                                        View more Auction
                                                    </a>
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
        <table bgcolor="#ffffff" align="center" width="860" height="30" border="0" cellpadding="0" cellspacing="0">
            <tbody>
                <tr>
                    <td>
                        &nbsp;
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
                                <td style="font-family: sans-serif;color: #666666;font-size: 11px;text-align: center;padding-top:8px;">
                                    <p style="margin:0;">All trademarks, logos and names are properties of their respective owners.</p>
                                    <p style="margin-top: 2px;">All Rights Reserved. &#169; Copyright <?php echo date('Y');?> AuctionOnClick.</p>
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
                                    <p style="margin:0;padding-right: 5px;"><a href="<?php echo base_url(); ?>terms-conditions" style="text-decoration: none;color: #0078db;">Terms &amp; Conditions</a></p>
                                </td>
                                <td width="3%" style="color: #999999;text-align: center;vertical-align: top;">|</td>
                                <td width="50%" style="font-family: sans-serif;color: #333333;font-size: 13px;text-align: left;">
                                    <p style="margin:0;padding-left: 5px;"><a href="<?php echo base_url(); ?>privacy-policy" style="text-decoration: none;color: #0078db;">Privacy Policy</a></p>
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
                                    <p style="margin:0;">If you do not wish to receive such emails, <a target="_blank" href="%%Unsubscribe%%" style="text-decoration: none;color: #0078db;">Unsubscribe here</a></p>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </td>
            </tr>
        </tbody>
    </table>
      </td></tr></tbody></table>
