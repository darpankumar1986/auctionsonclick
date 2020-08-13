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
	
	$currentpackage = $this->home_model->getCurrentPackage($userid);

	$package_id = $currentpackage->package_id;
	$package_amount = $currentpackage->package_amount;
	$package_start_date = $currentpackage->package_start_date;
	$package_end_date = $currentpackage->package_end_date;

	$package = $this->home_model->getSubcriptionPlan($package_id);
	$packagelist = $this->home_model->getSubcriptionPlan();
	//print_r($package);die;

	$start_date_str = strtotime($package_start_date); 
	$tilldate = time(); 
	$diff = $tilldate - $start_date_str; 
	$consumed_day = ceil($diff/84600);
	$consumed_amount = ceil($package[0]->per_day_cost*$consumed_day);
	$remaining_amount = $package_amount - $consumed_amount;

	if($package_id == 1)
	{
		$package4 = "_disable";
		$package5 = "_disable";
		$package6 = "_disable";
		$currentplan1 = "current_plan";
	}

	if($package_id == 2)
	{
		$package1 = "_disable";
		$package4 = "_disable";
		$package5 = "_disable";
		$package6 = "_disable";
		$currentplan2 = "current_plan";
	}

	if($package_id == 3)
	{
		$package1 = "_disable";
		$package2 = "_disable";
		$package4 = "_disable";
		$package5 = "_disable";
		$package6 = "_disable";
		$currentplan3 = "current_plan";
	}

?>
<style>
.Subscription_plan{display: none;}
</style>
<script>
var remaining_amount = "<?php echo $remaining_amount; ?>";
$(document).ready(function(){
	$("#upgrade_subscription").click(function(){
		$(".Subscription_plan").toggle();
	});
	$(".packageplan").click(function(){
		if(!$(this).hasClass('current_plan'))
		{
			$(".packageplan").removeClass('active_plan');
			$(this).addClass('active_plan');
		

			if($(this).closest('.packageplan').parent().hasClass('subscription_disable'))
			{
				$(".subscription_disable_text").show();
				$(".subscription_text").hide();
			}
			else
			{
				var plan_amount = $(this).find('.plan_amount').val();
				var due_cost = plan_amount - remaining_amount;			
				
				
				$("#due_cost").html(due_cost);

				$(".subscription_disable_text").hide();
				$(".subscription_text").show();
			}
		}
	});

	$(".pay_now").click(function(){
			var plan_amount = $(".packageplan.active_plan").find('.plan_amount').val();
			var due_cost = plan_amount - remaining_amount;
			var package_id = $(".packageplan.active_plan").find('.package_id').val();

			window.location = '?package_id='+package_id+'&due_cost='+due_cost;
	});
});
</script>

<div class="container-fluid container_margin">
	   <div class="row ad_row_width">
		   <div class="col-sm-12">
			   <h3 class="premium_service user_profile">Manage Your Subscription</h3>
		   </div>
	   </div>
</div>
<?php if (isset($this->session->userdata['flash:old:message_new'])) { ?>
	<div class="fail_msg" style="width: 100%; text-align: center;"> <?php echo @$this->session->userdata['flash:old:message_new']; ?></div>
<?php } ?>
<div class="container">
   <div class="row">
	   <div class="col-sm-12">
		   <script src="<?php echo base_url(); ?>assets/auctiononclick/js/bootstrap.min.js?rand=<?php echo CACHE_RANDOM; ?>"></script>
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
							  
						   </tr>
					   </tbody>
				   </table>
			   </div>
		   </div>
	   </div>
   </div>
   <div class="row">
		<div class="col-sm-12">
			<div class="subscribe_notification manage_sub_downgrade">
				<?php if((strtotime($package_end_date)) - 259200 < time()) { ?>
					<div class="reming_subscribe">
						<p>Remind me about subscription renewal</p>
						<p>Receive an email or SMS reminder 3 days before your renewal date</p>
					</div>
				<?php }else{ ?>
					<div class="subscribe_notification_inner">
						 <p>A reminder email/SMS for your subscription renewal will be sent to you on <?php echo date('F dS, Y',strtotime($package_end_date) - 259200); ?>.</p>
						<p class="reminder_off"><a href="#">Turn off reminder email/SMS</a></p>
					</div>
				<?php } ?>
				


				<div class="cancel_subscription">
					<button type="button" class="btn search_btn_new" id="upgrade_subscription">Upgrade Subscription</button>
				</div>
			</div>
		</div>
	</div>

	<div class="row Subscription_plan">
		<div class="col-sm-12">
			<h3 class="premium_service subscription_plan">Change Subscription Plan</h3>
			<div class="pan_state_tab">
				<div class="login_page pan_subscription">
					<div class="login_inner_page">
						<ul class="nav nav-tabs">
							<li class="active"><a data-toggle="tab" href="#PAN_India">PAN India</a></li>
							<li><a data-toggle="tab" href="#State_Wise">State Wise</a></li>
						</ul>
					</div>
				</div>
				<div class="tab-content pan_subscription_tab">
					<div id="PAN_India" class="tab-pane fade in active">
						<div class="row">
							<div class="col-sm-4 subscription<?php echo $package1; ?>">
								<div class="<?php  echo $currentplan1; ?> packageplan">
									<div class="subscription_box">
										<div class="sub_price">
											<h4>3 Months</h4>
											<div><span><img src="images/rupees_medium.png">
												<img class="white_rupees" src="images/rupees_medium_white.png"></span><span class="rupees"><?php echo $packagelist[0]->package_amount; ?></span></div>
											<input type="hidden" class="plan_amount" name="text" value="<?php echo $packagelist[0]->package_amount; ?>" />
											<input type="hidden" class="package_id" name="text" value="<?php echo $packagelist[0]->package_id; ?>" />
										</div>
									</div><!--subscription_box-->
									<?php if($currentplan1 != ''){ ?>
										<p>Current Plan</p>
									<?php } ?>
								</div><!--active_plan-->
							</div>
							<div class="col-sm-4 subscription<?php echo $package2; ?>" >
								<div class="<?php  echo $currentplan2; ?> packageplan">
									<div class="subscription_box">
										<div class="sub_price">
											<h4>6 Months</h4>
											<div><span><img src="images/rupees_medium.png">
												<img class="white_rupees" src="images/rupees_medium_white.png">
												</span><span class="rupees"><?php echo $packagelist[1]->package_amount; ?></span></div>
											<input type="hidden" class="plan_amount" name="text" value="<?php echo $packagelist[1]->package_amount; ?>" />
											<input type="hidden" class="package_id" name="text" value="<?php echo $packagelist[1]->package_id; ?>" />
										</div>
									</div><!--subscription_box-->
									<?php if($currentplan2 != ''){ ?>
										<p>Current Plan</p>
									<?php } ?>
								</div><!--current_plan-->
							</div>
							<div class="col-sm-4 subscription<?php echo $package3; ?>">
								<div class="<?php  echo $currentplan3; ?> packageplan">
									<div class="subscription_box">
										<div class="sub_price">
											<h4>12 Months</h4>
											<div><span><img src="images/rupees_medium.png">
												<img class="white_rupees" src="images/rupees_medium_white.png">
												</span><span class="rupees"><?php echo $packagelist[2]->package_amount; ?></span></div>
												<input type="hidden" class="plan_amount" name="text" value="<?php echo $packagelist[2]->package_amount; ?>" />
												<input type="hidden" class="package_id" name="text" value="<?php echo $packagelist[2]->package_id; ?>" />
										</div>
									</div><!--subscription_box-->
									<?php if($currentplan3 != ''){ ?>
										<p>Current Plan</p>
									<?php } ?>
								</div>
								
							</div>
						</div>
						<div class="row subscription_disable_text" style="display: none;">
							<div class="col-sm-12">
								<div class="current_membership">
									<p>Your current membership will continue until <?php echo date('F dS, Y',strtotime($package_end_date) + 86400); ?> after which you can change your plan.</p>
								</div>
							</div>
						</div>
						<div class="row subscription_text" style="display: none;">
							<div class="col-sm-12">
								<div class="Active_membership">
									<p>Your current membership is for <?php echo $package[0]->sub_month;?> months, your consumed days and amount will be adjusted to this new subscription.</p>
									<p><span>Amount paid for 3 months: ₹<?php echo $package_amount; ?>.00</span> | <span>Days consumed: <?php echo $consumed_day; ?> days</span> | <span>New renewal date: <?php echo date('F dS, Y',strtotime($package_end_date) + 86400); ?></span></p>
									<p class="amount_due">Amount due : ₹<span id="due_cost">2500</span> </p>
									<button type="button" class="btn search_btn_new pay_now">Pay Now</button>
								</div>
							</div>
						</div>
					</div>
					<div id="State_Wise" class="tab-pane fade state_wise_tab">
						<div class="row">
							<div class="col-sm-4 subscription<?php echo $package4; ?>">
							   <div class="current_plan active_state_wise_plan">
								<div class="subscription_box">
									<div class="sub_price">
										<h4>3 Months</h4>
										<div><span><img src="images/rupees_medium.png"></span><span class="rupees">1500</span></div>
										<h4 class="states_desc">For any two states</h4>
										<p class="additional_desc">Get additional state for just</p>
										<div class="state_price"><span><img src="images/rupees_small_sm.png"></span><span class="rupees">100</span><span class="small_state">/state</span>
											<div class="plan_desc state_chosen">
												<h4 class="other_desc_subscribe">States Chosen</h4>
												<p class="subscribe_address">Haryana, West Bengal, Punjab </p>
											</div>
										</div>
									</div>
<!--
									<div class="checklist_state">
										<div class="dropdown">
											<button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">Select States
												<span class="caret"></span></button>
											<ul class="dropdown-menu">
												<li><label class="checkbox-inline"><input type="checkbox" value="">Andaman and Nicobar Islands</label></li>
												<li><label class="checkbox-inline"><input type="checkbox" value="">Andhra Pradesh</label></li>
												<li><label class="checkbox-inline"><input type="checkbox" value="">Arunachal Pradesh</label></li>
												<li><label class="checkbox-inline"><input type="checkbox" value="">Assam</label></li>
												<li><label class="checkbox-inline"><input type="checkbox" value="">Bihar</label></li>
												<li><label class="checkbox-inline"><input type="checkbox" value="">Chandigarh</label></li>
												<li><label class="checkbox-inline"><input type="checkbox" value="">Chhattisgarh</label></li>
											</ul>
										</div>
									</div>
-->
								</div><!--subscription_box-->
								   <p>current plan</p>
								</div>
							</div>
							<div class="col-sm-4 subscription<?php echo $package5; ?>">
								<div class="subscription_box">
									<div class="sub_price">
										<h4>6 Months</h4>
										<div><span><img src="images/rupees_medium.png"></span><span class="rupees">2500</span></div>
										<h4 class="states_desc">For any two states</h4>
										<p class="additional_desc">Get additional state for just</p>
										<div class="state_price"><span><img src="images/rupees_small_sm.png"></span><span class="rupees">200</span><span class="small_state">/state</span></div>
									</div>
									<div class="checklist_state">
										<div class="dropdown">
											<button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">Select States
												<span class="caret"></span></button>
											<ul class="dropdown-menu">
												<li><label class="checkbox-inline"><input type="checkbox" value="">Andaman and Nicobar Islands</label></li>
												<li><label class="checkbox-inline"><input type="checkbox" value="">Andhra Pradesh</label></li>
												<li><label class="checkbox-inline"><input type="checkbox" value="">Arunachal Pradesh</label></li>
												<li><label class="checkbox-inline"><input type="checkbox" value="">Assam</label></li>
												<li><label class="checkbox-inline"><input type="checkbox" value="">Bihar</label></li>
												<li><label class="checkbox-inline"><input type="checkbox" value="">Chandigarh</label></li>
												<li><label class="checkbox-inline"><input type="checkbox" value="">Chhattisgarh</label></li>
											</ul>
										</div>
									</div>
								</div><!--subscription_box-->
							</div>
							<div class="col-sm-4 subscription<?php echo $package6; ?>">
								<div class="subscription_box">
									<div class="sub_price">
										<h4>12 Months</h4>
										<div><span><img src="images/rupees.png"></span><span class="rupees">4000</span></div>
										<h4 class="states_desc">For any two states</h4>
										<p class="additional_desc">Get additional state for just</p>
										<div class="state_price"><span><img src="images/rupees_small_sm.png"></span><span class="rupees">400</span><span class="small_state">/state</span></div>
									</div>
									<div class="checklist_state">
										<div class="dropdown">
											<button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">Select States
												<span class="caret"></span></button>
											<ul class="dropdown-menu">
												<li><label class="checkbox-inline"><input type="checkbox" value="">Andaman and Nicobar Islands</label></li>
												<li><label class="checkbox-inline"><input type="checkbox" value="">Andhra Pradesh</label></li>
												<li><label class="checkbox-inline"><input type="checkbox" value="">Arunachal Pradesh</label></li>
												<li><label class="checkbox-inline"><input type="checkbox" value="">Assam</label></li>
												<li><label class="checkbox-inline"><input type="checkbox" value="">Bihar</label></li>
												<li><label class="checkbox-inline"><input type="checkbox" value="">Chandigarh</label></li>
												<li><label class="checkbox-inline"><input type="checkbox" value="">Chhattisgarh</label></li>
											</ul>
										</div>
									</div>
								</div><!--subscription_box-->
							</div>
						</div>
						<div class="row">
							<div class="col-sm-12">
								<div class="state_chosen_wrapper">
								   <div class="hide_list">
									   <p class="add_more_state">Add more states <span><i class="fa fa-angle-down"></i></span>
									   </p>
									   <div class="all_state_list">
										   <div class="all_state_list_inner">
											   <ul>
												   <li>
													  <div class="update_password updated_list">
													   <label class="container-checkbox">Andaman &amp; Nicobar
														   <input type="checkbox">
														   <span class="checkmark"></span>
													   </label>
													   </div>
													</li>
												   <li>
													   <div class="update_password updated_list">
														   <label class="container-checkbox">Bihar
															   <input type="checkbox">
															   <span class="checkmark"></span>
														   </label>
													   </div>
												   </li>
												   <li>
													   <div class="update_password updated_list">
														   <label class="container-checkbox">Delhi
															   <input type="checkbox">
															   <span class="checkmark"></span>
														   </label>
													   </div>
												   </li>
												   <li>
													   <div class="update_password updated_list">
														   <label class="container-checkbox">Himachal Pradesh
															   <input type="checkbox">
															   <span class="checkmark"></span>
														   </label>
													   </div>
												   </li>
												   <li>
													   <div class="update_password updated_list">
														   <label class="container-checkbox">Kerala
															   <input type="checkbox">
															   <span class="checkmark"></span>
														   </label>
													   </div>
												   </li>
												   <li>
													   <div class="update_password updated_list">
														   <label class="container-checkbox">Maharashtra
															   <input type="checkbox">
															   <span class="checkmark"></span>
														   </label>
													   </div>
												   </li>
												   <li>
													   <div class="update_password updated_list">
														   <label class="container-checkbox">Nagaland
															   <input type="checkbox">
															   <span class="checkmark"></span>
														   </label>
													   </div>
												   </li>
												   <li>
													   <div class="update_password updated_list">
														   <label class="container-checkbox">Rajasthan
															   <input type="checkbox">
															   <span class="checkmark"></span>
														   </label>
													   </div>
												   </li>
												   <li>
													   <div class="update_password updated_list">
														   <label class="container-checkbox">Tripura
															   <input type="checkbox">
															   <span class="checkmark"></span>
														   </label>
													   </div>
												   </li>
												   <li>
													   <div class="update_password updated_list">
														   <label class="container-checkbox">Andhra Pradesh
															   <input type="checkbox">
															   <span class="checkmark"></span>
														   </label>
													   </div>
												   </li>
												   <li>
													   <div class="update_password updated_list">
														   <label class="container-checkbox">Chandigarh
															   <input type="checkbox">
															   <span class="checkmark"></span>
														   </label>
													   </div>
												   </li>
												   <li>
													   <div class="update_password updated_list">
														   <label class="container-checkbox">Goa
															   <input type="checkbox">
															   <span class="checkmark"></span>
														   </label>
													   </div>
												   </li>
												   <li>
													   <div class="update_password updated_list">
														   <label class="container-checkbox">Jammu and Kashmir
															   <input type="checkbox">
															   <span class="checkmark"></span>
														   </label>
													   </div>
												   </li>
												   <li>
													   <div class="update_password updated_list">
														   <label class="container-checkbox">Ladakh
															   <input type="checkbox">
															   <span class="checkmark"></span>
														   </label>
													   </div>
												   </li>
												   <li>
													   <div class="update_password updated_list">
														   <label class="container-checkbox">Manipur
															   <input type="checkbox">
															   <span class="checkmark"></span>
														   </label>
													   </div>
												   </li>
												   <li>
													   <div class="update_password updated_list">
														   <label class="container-checkbox">Odisha
															   <input type="checkbox">
															   <span class="checkmark"></span>
														   </label>
													   </div>
												   </li>
												   <li>
													   <div class="update_password updated_list">
														   <label class="container-checkbox">Sikkim
															   <input type="checkbox">
															   <span class="checkmark"></span>
														   </label>
													   </div>
												   </li>
												   <li>
													   <div class="update_password updated_list">
														   <label class="container-checkbox">Uttar Pradesh
															   <input type="checkbox">
															   <span class="checkmark"></span>
														   </label>
													   </div>
												   </li>
												   <li>
													   <div class="update_password updated_list">
														   <label class="container-checkbox">Arunachal Pradesh
															   <input type="checkbox">
															   <span class="checkmark"></span>
														   </label>
													   </div>
												   </li>
												   <li>
													   <div class="update_password updated_list">
														   <label class="container-checkbox">Chhattisgarh
															   <input type="checkbox">
															   <span class="checkmark"></span>
														   </label>
													   </div>
												   </li>
												   <li>
													   <div class="update_password updated_list">
														   <label class="container-checkbox">Gujarat
															   <input type="checkbox">
															   <span class="checkmark"></span>
														   </label>
													   </div>
												   </li>
												   <li>
													   <div class="update_password updated_list">
														   <label class="container-checkbox">Jharkhand
															   <input type="checkbox">
															   <span class="checkmark"></span>
														   </label>
													   </div>
												   </li>
												   <li>
													   <div class="update_password updated_list">
														   <label class="container-checkbox">Lakshadweep
															   <input type="checkbox">
															   <span class="checkmark"></span>
														   </label>
													   </div>
												   </li>
												   <li>
													   <div class="update_password updated_list">
														   <label class="container-checkbox">Meghalaya
															   <input type="checkbox">
															   <span class="checkmark"></span>
														   </label>
													   </div>
												   </li>
												   <li>
													   <div class="update_password updated_list">
														   <label class="container-checkbox">Puducherry
															   <input type="checkbox">
															   <span class="checkmark"></span>
														   </label>
													   </div>
												   </li>
												   <li>
													   <div class="update_password updated_list">
														   <label class="container-checkbox">Tamil Nadu
															   <input type="checkbox">
															   <span class="checkmark"></span>
														   </label>
													   </div>
												   </li>
												   <li>
													   <div class="update_password updated_list">
														   <label class="container-checkbox">Uttarakhand
															   <input type="checkbox">
															   <span class="checkmark"></span>
														   </label>
													   </div>
												   </li>
												   <li>
													   <div class="update_password updated_list">
														   <label class="container-checkbox">Assam
															   <input type="checkbox">
															   <span class="checkmark"></span>
														   </label>
													   </div>
												   </li>
												   <li>
													   <div class="update_password updated_list">
														   <label class="container-checkbox">Dadra & Nagar Haveli and Daman & Diu
															   <input type="checkbox">
															   <span class="checkmark"></span>
														   </label>
													   </div>
												   </li>
												   <li>
													   <div class="update_password updated_list">
														   <label class="container-checkbox">Haryana
															   <input type="checkbox">
															   <span class="checkmark"></span>
														   </label>
													   </div>
												   </li>
												   <li>
													   <div class="update_password updated_list">
														   <label class="container-checkbox">Karnataka
															   <input type="checkbox">
															   <span class="checkmark"></span>
														   </label>
													   </div>
												   </li>
												   <li>
													   <div class="update_password updated_list">
														   <label class="container-checkbox">Madhya Pradesh
															   <input type="checkbox">
															   <span class="checkmark"></span>
														   </label>
													   </div>
												   </li>
												   <li>
													   <div class="update_password updated_list">
														   <label class="container-checkbox">Mizoram
															   <input type="checkbox">
															   <span class="checkmark"></span>
														   </label>
													   </div>
												   </li>
												   <li>
													   <div class="update_password updated_list">
														   <label class="container-checkbox">Punjab
															   <input type="checkbox">
															   <span class="checkmark"></span>
														   </label>
													   </div>
												   </li>
												   <li>
													   <div class="update_password updated_list">
														   <label class="container-checkbox">Telangana
															   <input type="checkbox">
															   <span class="checkmark"></span>
														   </label>
													   </div>
												   </li>
												   <li>
													   <div class="update_password updated_list">
														   <label class="container-checkbox">West Bengal
															   <input type="checkbox">
															   <span class="checkmark"></span>
														   </label>
													   </div>
												   </li>
											   </ul>
											   <div class="confirm_btn">
												   <button type="button" class="btn search_btn_new">Confirm</button>
											   </div>
										   </div><!--all_state_list_inner-->
									   </div><!--all_state_list-->
									</div><!--hide_list-->
									<p class="selected_states">Chosen States: <span>Gujarat, Kerala</span></p>
								</div>
							</div>
						</div>
						<div class="row">
							<div class="col-sm-12">
								<div class="Active_membership">
									<p>Your current membership is for 3 months, you have added 2 new states to your existing subscription.</p>
									<p><span>Amount paid for 3 months: ₹2000</span> | <span>Days consumed: 45 days</span> | <span>Days left: 45 days</span></p>
									<p class="amount_due">Amount due : ₹<span>100</span> </p>
									<button type="button" class="btn search_btn_new pay_now">Pay Now</button>
								</div>
							</div>
						</div>
					</div>
				</div>
			</div><!--pan_state_tab-->
		</div>
	</div>

</div><!--container-->