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
<?php
    $this->db->where('r.id', $userid);
    $this->db->join('tbl_state as s','s.id = r.state_id');
    $query = $this->db->get("tbl_user_registration as r");
    $user = $query->row();

    $full_name = ($user->first_name != '')?$user->first_name.' '.$user->last_name:$user->authorized_person;
?>
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
<table bgcolor="#ffffff" align="center" width="860" border="0" cellpadding="0" cellspacing="0">
    <tbody>
        <tr>
            <td>
                <table width="780" align="center" cellpadding="0" cellspacing="0">
                    <tbody>
                        <tr>
                            <td width="2%">&nbsp;</td>
                            <td>
                                <p style="font-family: sans-serif;color: #333333;font-size: 13px;margin-top: 40px;margin-bottom: 25px;">Dear <strong><?php echo $full_name; ?>,</strong></p>
                                <p style="font-family: sans-serif;color: #333333;font-size: 13px;margin-top: 0;margin-bottom: 25px;">Thank you for your order from <a href="#" style="color: #0078db; text-decoration: none;">www.Auctiononclick.com</a></p>
                                <p style="font-family: sans-serif;color: #333333;font-size: 13px;margin-top: 0;margin-bottom: 50px;">For your conveninence, we have included a copy of your order below.</p>
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
                    <table width="780" align="center" cellpadding="0" cellspacing="0" style="">
                        <tbody>
                            <tr>
                                <td width="2%">&nbsp;</td>
                                <td>
                                    <table class="auction_table_box" style="border-collapse: collapse;width: 100%;">
                                        <thead>
                                            <tr>
                                                <th width="33%" style="font-size: 13px;padding:12px;color: #0078db;font-family: sans-serif;border: 1px solid #ccc;text-align: left;font-weight: normal;">Order#</th>
                                                <th width="33%" style="font-size: 13px;padding: 12px;color: #0078db;font-family: sans-serif;border: 1px solid #ccc;text-align: left;font-weight: normal;">Order Date</th>
                                                <th width="33%" style="font-size: 13px;padding: 12px;color: #0078db;font-family: sans-serif;border: 1px solid #ccc;text-align: left;font-weight: normal;">Order Time</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <tr>
                                                <td style="font-size: 13px;padding: 13px;color: #333333;font-family: sans-serif;border: 1px solid #ccc;"><?php echo $order; ?></td>
                                                <td style="font-size: 13px;padding: 13px;color: #333333;font-family: sans-serif;border: 1px solid #ccc;"><?php echo date('F dS, Y',strtotime($order_date)); ?></td>
                                                <td style="font-size: 13px;padding: 13px;color: #333333;font-family: sans-serif;border: 1px solid #ccc;"><?php echo date('H:i:s',strtotime($order_date)); ?></td>
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
        <table bgcolor="#ffffff" align="center" width="860" height="50" border="0" cellpadding="0" cellspacing="0">
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
                                    <td width="2%">&nbsp;</td>
                                    <td>
                                        <p style="font-family: sans-serif;color: #0078db;font-size: 16px;margin-top: 40px;    margin-bottom: 10px;">Billing Details:</p>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    </td>
                </tr>
            </tbody>
        </table>
        <table width="860" height="3" align="center" cellpadding="0" cellspacing="0">
            <tbody>
               <tr>
                <td>
                    <table width="780" align="center" cellpadding="0" cellspacing="0">
                        <tbody>
                            <tr>
                                <td width="2%">&nbsp;</td>
                                <td style="border-top: 1px solid #ccc">
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </td>
                </tr>
            </tbody>
        </table>
        <table bgcolor="#ffffff" align="center" width="860" height="50" border="0" cellpadding="0" cellspacing="0">
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
                                    <td width="2%">&nbsp;</td>
                                    <td width="70%">
                                        <table cellpadding="0" cellspacing="0">
                                            <tbody>
                                                <tr>
                                                    <td width="120">
                                                        <table height="20" cellpadding="0" cellspacing="0">
                                                            <tbody>
                                                                <tr>
                                                                    <td style="font-family: sans-serif;font-weight: bold;color: #333333;font-size: 12px;">
                                                                        Customer
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                        <table height="20" cellpadding="0" cellspacing="0">
                                                            <tbody>
                                                                <tr>
                                                                    <td style="font-family: sans-serif;font-weight: bold;color: #333333;font-size: 12px;">
                                                                        Address
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                        <table height="20" cellpadding="0" cellspacing="0">
                                                            <tbody>
                                                                <tr>
                                                                    <td style="font-family: sans-serif;font-weight: bold;color: #333333;font-size: 12px;">
                                                                        Customer IP
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                        <table height="20" cellpadding="0" cellspacing="0">
                                                            <tbody>
                                                                <tr>
                                                                    <td style="font-family: sans-serif;font-weight: bold;color: #333333;font-size: 12px;">
                                                                        Pay Mode
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                        <table height="20" cellpadding="0" cellspacing="0">
                                                            <tbody>
                                                                <tr>
                                                                    <td style="font-family: sans-serif;font-weight: bold;color: #333333;font-size: 12px;">
                                                                        Bank Ref #
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </td>
                                                    <td width="400">
                                                        <table height="20" width="100%" cellpadding="0" cellspacing="0">
                                                            <tbody>
                                                                <tr>
                                                                    <td width="100" style="font-family: sans-serif;color: #333333;font-size: 12px;">: <?php echo $full_name; ?></td>
                                                                    <td>|</td>
                                                                    <td width="150" style="font-family: sans-serif;color: #333333;font-size: 12px;text-align: center;"><a href="mailto:deepa.malik@c1india.com" style="color: #333333;"><?php echo $user->email_id; ?></a></td>
                                                                    <td width="10">|</td>
                                                                    <td style="font-family: sans-serif;color: #333333;font-size: 12px;">+91 <?php echo $user->mobile_no; ?></td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                        <table height="20" width="100%" cellpadding="0" cellspacing="0">
                                                            <tbody>
                                                                <tr>
                                                                    <td width="90" style="font-family: sans-serif;color: #333333;font-size: 12px;">: <?php echo $user->city_id; ?>, <?php echo $user->state_name; ?>, <?php echo $user->city_id; ?> - <?php echo $user->zip; ?>. India</td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                        <table height="20" width="100%" cellpadding="0" cellspacing="0">
                                                            <tbody>
                                                                <tr>
                                                                    <td width="90" style="font-family: sans-serif;color: #333333;font-size: 12px;">: <?php echo $ip; ?></td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                        <table height="20" width="100%" cellpadding="0" cellspacing="0">
                                                            <tbody>
                                                                <tr>
                                                                    <td width="90" style="font-family: sans-serif;color: #333333;font-size: 12px;">: <?php
                                                                            if ($response != '' && $response->mode != 'null') {
                                                                                if($response->mode=='CC')
                                                                                {
                                                                                    echo 'Credit Card';
                                                                                }
                                                                                else if($response->mode=='DC')
                                                                                {
                                                                                    echo 'Debit Card';
                                                                                }
                                                                                else if($response->mode=='NB')
                                                                                {
                                                                                    echo 'Net Banking';
                                                                                }
                                                                                else
                                                                                {
                                                                                    echo $response->bankcode;
                                                                                }
                                                                            }
                                                                            else
                                                                            {
                                                                                echo '--' ;
                                                                            }
                                                                    ?></td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                        <table height="20" width="100%" cellpadding="0" cellspacing="0">
                                                            <tbody>
                                                                <tr>
                                                                    <td width="90" style="font-family: sans-serif;color: #333333;font-size: 12px;">: <?php echo $response->bank_ref_num; ?></td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </td>
                                                </tr>
                                            </tbody>
                                        </table>
                                    </td>
                                    <td width="30%">
                                        <table cellpadding="0" cellspacing="0">
                                            <tbody>
                                                <tr>
                                                  <td width="220">
                                                      <table width="100%" height="28" cellpadding="0" cellspacing="0">
                                                          <tbody>
                                                              <tr>
                                                                  <td style="font-family: sans-serif;color: #0078db;font-size: 13px;">
                                                                      Order Amount
                                                                  </td>
                                                              </tr>
                                                          </tbody>
                                                      </table>
                                                      <table width="100%" height="28" cellpadding="0" cellspacing="0">
                                                          <tbody>
                                                              <tr>
                                                                  <td style="font-family: sans-serif;color: #0078db;font-size: 13px;">
                                                                      Net Payable
                                                                  </td>
                                                              </tr>
                                                          </tbody>
                                                      </table>
                                                      <table width="100%" height="28" cellpadding="0" cellspacing="0">
                                                          <tbody>
                                                              <tr>
                                                                  <td>

                                                                  </td>
                                                              </tr>
                                                          </tbody>
                                                      </table>
                                                      <table width="100%" height="28" cellpadding="0" cellspacing="0">
                                                          <tbody>
                                                              <tr>
                                                                  <td>

                                                                  </td>
                                                              </tr>
                                                          </tbody>
                                                      </table>
                                                  </td>
                                                    <td width="180">
                                                        <table height="28" cellpadding="0" cellspacing="0">
                                                            <tbody>
                                                                <tr>
                                                                    <td style="font-family: sans-serif;font-weight: bold;color: #333333;font-size: 13px;">
                                                                        : &#8377;<?php echo $paid_amount;?>.00
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                        <table height="28" cellpadding="0" cellspacing="0">
                                                            <tbody>
                                                                <tr>
                                                                    <td style="font-family: sans-serif;font-weight: bold;color: #333333;font-size: 13px;">
                                                                        : &#8377;<?php echo $paid_amount;?>.00
                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                        <table height="28" cellpadding="0" cellspacing="0">
                                                            <tbody>
                                                                <tr>
                                                                    <td>

                                                                    </td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                        <table height="28" cellpadding="0" cellspacing="0">
                                                            <tbody>
                                                                <tr>
                                                                    <td>

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
                                <td style="font-family: sans-serif;color: #666666;font-size: 11px;text-align: center;">
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
                                    <p style="margin:0;padding-right: 5px;"><a href="#" style="text-decoration: none;color: #0078db;">Terms &amp; Conditions</a></p>
                                </td>
                                <td width="3%" style="color: #999999;text-align: center;vertical-align: top;">|</td>
                                <td width="50%" style="font-family: sans-serif;color: #333333;font-size: 13px;text-align: left;">
                                    <p style="margin:0;padding-left: 5px;"><a href="#" style="text-decoration: none;color: #0078db;">Privacy Policy</a></p>
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
                                    <p style="margin:0;">If you do not wish to receive such emails, <a href="#" style="text-decoration: none;color: #0078db;">Unsubscribe here</a></p>
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
