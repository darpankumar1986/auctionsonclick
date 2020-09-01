<p style="font-family: sans-serif;color: #333333;font-size: 14px;font-weight: normal;margin-top: 0;margin-bottom: 0px !important;">Dear <strong><?php echo $first_name; ?>,</strong><br/></br/>
This is a reminder that you subscription at <a href="<?php echo base_url(); ?>" style="text-decoration: none;color: #0078db;margin-bottom:10px;">AuctionOnClick.com</a> is about to expire on <?php echo $this->home_model->standardDateFormat($package_end_date); ?>.<br/></br/>
To renew or upgrade your subscription, please login to <a href="<?php echo base_url();?>owner/manageSubscription">www.AuctionOnClick.com/premium-services</a><br/></br/>
Regards,<br/>
<a href="<?php echo base_url(); ?>" style="text-decoration: none;color: #0078db;margin-bottom:10px;"><strong>AuctionOnClick.com</strong></a></p><br/>
<img src="<?php echo $Logo_2; ?>">
