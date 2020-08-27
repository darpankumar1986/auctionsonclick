Dear <?php echo $first_name; ?>,<br/></br/>
This is a reminder that you subscription at <a href="<?php echo base_url(); ?>" style="text-decoration: none;color: #0078db;margin-bottom:10px;">AuctionOnClick.com</a> is about to expire on <?php echo date('F dS, Y',strtotime($package_end_date)); ?>.<br/></br/>
To renew or upgrade your subscription, please login to <a href="<?php echo base_url();?>owner/manageSubscription">www.AuctionOnClick.com/premium-services</a><br/></br/>
Regards,<br/>
<a href="<?php echo base_url(); ?>" style="text-decoration: none;color: #0078db;margin-bottom:10px;">AuctionOnClick.com</a><br/>
<img src="<?php echo $Logo_2; ?>">
