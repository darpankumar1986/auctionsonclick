Dear <?php echo $first_name; ?>,<br/></br/>
This is a reminder that you subscription at AuctionOnClick.com is about to expire on <?php echo date('F dS, Y',strtotime($package_end_date)); ?>.<br/></br/>
To renew or upgrade your subscription, please login to <a href="<?php echo base_url();?>owner/manageSubscription">www.AuctionOnClick.com/premium-services</a><br/></br/>
Regards,<br/>
AuctionOnClick.com<br/>
<img src="<?php echo $Logo_2; ?>">