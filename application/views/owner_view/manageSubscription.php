<?php
	$userid=$this->session->userdata('id');
	$user_type =	GetTitleByField('tbl_user_registration', "id='".$userid."'", "user_type");
	if($user_type == 'owner')
	{
		$full_name =	GetTitleByField('tbl_user_registration', "id='".$userid."'", "first_name");
		$full_name .= ' '.GetTitleByField('tbl_user_registration', "id='".$userid."'", "last_name");
	}
	else
	{
		$full_name .= ' '.GetTitleByField('tbl_user_registration', "id='".$userid."' and subscription_status = 1", "authorized_person");
	}
	
	$package_id = GetTitleByField('tbl_subscription_participate', "member_id='".$userid."'", "package_id");
	$package_amount = GetTitleByField('tbl_subscription_participate', "member_id='".$userid."'", "package_amount");
	$package_start_date = GetTitleByField('tbl_subscription_participate', "member_id='".$userid."'", "package_start_date");
	$package_end_date = GetTitleByField('tbl_subscription_participate', "member_id='".$userid."'", "package_end_date");

	$package = $this->home_model->getSubcriptionPlan($package_id);
	//print_r($package);die;

?>

<div class="container-fluid container_margin">
	   <div class="row ad_row_width">
		   <div class="col-sm-12">
			   <h3 class="premium_service user_profile">Manage Your Subscription</h3>
		   </div>
	   </div>
</div>
<div class="container">
   <div class="row">
	   <div class="col-sm-12">
		   <div class="subscription_manage">
			   <p class="subscribe_user">Hello <?php echo $full_name; ?>,</p>
			   <h4 class="subscribe_active_user">Your Active Subscripton</h4>
			   <div class="subscription_table">
				   <table class="table table-bordered">
					   <tbody>
						   <tr>
							   <td>
								   <div class="plan_desc">
									   <h4><?php echo ($package_id > 3)?'State Wise (Any 3 States)':'PAN India'; ?></h4>
									   <p class="common_date"><?php echo $package[0]->sub_month;?> Months Plan</p>
									   <?php if($package_id > 3){ $state_bidder = $this->home_model->get_state_bidder($userid);?>
										   <h4 class="other_desc_subscribe">States Chosen</h4>
										   <p class="subscribe_address"><?php echo implode(", ",$state_bidder); ?></p>
									   <?php } ?>
								   </div>
							   </td>
							   <td>
								   <div class="plan_desc">
									   <h4 class="other_desc_subscribe">Subscribed on</h4>
									   <p class="common_date"><?php echo date('F dS, Y',strtotime($package_start_date)); ?> at ₹<span><?php echo $package_amount; ?>.00</span></p>
									   <?php if($package_id > 3 && false){ ?>
										   <p class="subscribe_charges">Subscription charges ₹1500.00 + 1 additional State charges ₹100.00</p>
									   <?php } ?>
								   </div>
							   </td>
							   <td>
								   <div class="plan_desc">
									   <h4 class="other_desc_subscribe">Renewal</h4>
									   <p class="common_date"><?php echo date('F dS, Y',strtotime($package_end_date) + 86400); ?> at ₹<span><?php echo $package_amount; ?>.00</span></p>
								   </div>
							   </td>
							   <td class="auto_renew">
								   <div class="plan_desc">
									   <h4 class="other_desc_subscribe">Auto Renew</h4>
									   <input type="checkbox" id="toggle" class="checkbox" />
									   <label for="toggle" class="switch"></label>
								   </div>
							   </td>
						   </tr>
					   </tbody>
				   </table>
			   </div>
		   </div>
	   </div>
   </div>
	<div class="row">
		<div class="col-sm-12">
			<div class="subscribe_notification">
				<div class="subscribe_notification_inner">
					 <p>A reminder email/SMS for your subscription renewal will be sent to you on <?php echo date('F dS, Y',strtotime($package_end_date) - 259200); ?>.</p>
					<p class="reminder_off"><a href="#">Turn off reminder email/SMS</a></p>
				</div>
				<div class="cancel_subscription">
					<!--<button type="button" class="btn search_btn_new">Cancel Subscription</button>-->
				</div>
			</div>
		</div>
	</div>

</div><!--container-->