		<script src="<?php echo base_url(); ?>assets/auctiononclick/js/bootstrap.min.js?rand=<?php echo CACHE_RANDOM; ?>"></script>
		<div class="container-fluid container_margin">
            <div class="row row_bg">
               <div class="container">
                <div class="col-sm-12">
                    <div class="breadcrumb_main">
                        <ol class="breadcrumb">
                            <li><a href="<?php echo base_url(); ?>">Home</a></li>
                            <li class="active">Premium Services</li>
                        </ol>
<!--                        <h3>Bank Auctions in Amritsar</h3>-->
                    </div><!--breadcrumb_main-->
                </div>
            </div>
            </div><!--row-->
        </div><!--container-fluid-->
           <div class="container-fluid">
               <div class="row ad_row_width">
                   <div class="col-sm-12">
                        <h3 class="premium_service">Premium Services</h3>
                   </div>
               </div>
           </div>

		   <?php if (isset($this->session->userdata['flash:old:message_new'])) { ?>
			<div class="fail_msg" style="width: 100%; text-align: center;"> <?php echo @$this->session->userdata['flash:old:message_new']; ?></div>
			<?php } ?>

        <div class="container-fluid">
            <div class="row ad_row_width">
                <div class="col-sm-12">
                    <div class="login_page pan_subscription">
                        <div class="login_inner_page">
                            <ul class="nav nav-tabs">
                                <li class="active"><a data-toggle="tab" href="#Login">PAN India Subscription Plan</a></li>
                                <li><a data-toggle="tab" href="#Register">State Wise Subscription Plan</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div><!--row-->
            <div class="row">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="tab-content pan_subscription_tab">
                                <div id="Login" class="tab-pane fade in active">
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <div class="subscription_box">
                                                <div class="sub_price">
                                                    <h4>3 Months</h4>
                                                    <div><span><img src="<?php echo base_url(); ?>assets/auctiononclick/images/rupees.png"></span><span class="rupees">2000</span></div>
                                                </div>
                                                <div class="sub_list">
                                                    <ul>
                                                        <li>3 Months Premium Access</li>
                                                        <li>Auction Document/Notice</li>
                                                        <li>Auction History</li>
                                                        <li>Daily Mobile Notification</li>
                                                        <li>Daily Email Alert</li>
                                                        <li>Multiple City Email Alert</li>
                                                        <li>Email Support</li>
                                                    </ul>
                                                </div>
												<?php if($this->session->userdata('id') > 0){ ?>	
													<input type="hidden" name="package_id" value="<?php echo $subcription_plan[0]->package_id; ?>" />
													<button class="btn btn-default upgrade_btn sec-package" type="button" data-id="<?php echo $subcription_plan[0]->package_id; ?>">Upgrade Now</button>
												<?php }else{ ?>
													<a href="<?php echo base_url(); ?>home/login?action=premium"><button class="btn btn-default upgrade_btn" type="button">Login to Subscribe</button></a>
												<?php } ?>
                                            </div><!--subscription_box-->
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="subscription_box">
                                                <div class="sub_price">
                                                    <h4>6 Months</h4>
                                                    <div><span><img src="<?php echo base_url(); ?>assets/auctiononclick/images/rupees.png"></span><span class="rupees">3500</span></div>
                                                </div>
                                                <div class="sub_list">
                                                    <ul>
                                                        <li>6 Months Premium Access</li>
                                                        <li>Auction Document/Notice</li>
                                                        <li>Auction History</li>
                                                        <li>Daily Mobile Notification</li>
                                                        <li>Daily Email Alert</li>
                                                        <li>Multiple City Email Alert</li>
                                                        <li>Email Support</li>
                                                    </ul>
                                                </div>
                                                <?php if($this->session->userdata('id') > 0){ ?>	
													<input type="hidden" name="package_id" value="<?php echo $subcription_plan[1]->package_id; ?>" />
													<button class="btn btn-default upgrade_btn sec-package" type="button" data-id="<?php echo $subcription_plan[1]->package_id; ?>">Upgrade Now</button>
												<?php }else{ ?>
													<a href="<?php echo base_url(); ?>home/login?action=premium"><button class="btn btn-default upgrade_btn" type="button">Login to Subscribe</button></a>
												<?php } ?>
                                            </div><!--subscription_box-->
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="subscription_box">
                                                <div class="sub_price">
                                                    <h4>12 Months</h4>
                                                    <div><span><img src="<?php echo base_url(); ?>assets/auctiononclick/images/rupees.png"></span><span class="rupees">6500</span></div>
                                                </div>
                                                <div class="sub_list">
                                                    <ul>
                                                        <li>12 Months Premium Access</li>
                                                        <li>Auction Document/Notice</li>
                                                        <li>Auction History</li>
                                                        <li>Daily Mobile Notification</li>
                                                        <li>Daily Email Alert</li>
                                                        <li>Multiple City Email Alert</li>
                                                        <li>Email Support</li>
                                                    </ul>
                                                </div>
                                                <?php if($this->session->userdata('id') > 0){ ?>	
													<input type="hidden" name="package_id" value="<?php echo $subcription_plan[2]->package_id; ?>" />
													<button class="btn btn-default upgrade_btn sec-package" type="button" data-id="<?php echo $subcription_plan[2]->package_id; ?>">Upgrade Now</button>
												<?php }else{ ?>
													<a href="<?php echo base_url(); ?>home/login?action=premium"><button class="btn btn-default upgrade_btn" type="button">Login to Subscribe</button></a>
												<?php } ?>
                                            </div><!--subscription_box-->
                                        </div>
                                    </div>
                                </div>
                                <div id="Register" class="tab-pane fade">
                                    <div class="row">
                                        <div class="col-sm-4">
                                            <div class="subscription_box">
                                                <div class="sub_price">
                                                    <h4>3 Months</h4>
                                                    <div><span><img src="<?php echo base_url(); ?>assets/auctiononclick/images/rupees.png"></span><span class="rupees">1500</span></div>
                                                    <h4 class="states_desc">For any two states</h4>
                                                    <p class="additional_desc">Get additional state for just</p>
                                                    <div class="state_price"><span><img src="<?php echo base_url(); ?>assets/auctiononclick/images/rupees_small.png"></span><span class="rupees">100</span><span class="small_state">/state</span></div>
                                                </div>
                                                <div class="checklist_state">
                                                    <div class="dropdown">
                                                        <button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">Select States
                                                            <span class="caret"></span></button>
                                                        <ul class="dropdown-menu">
                                                            <?php $statelist = $this->home_model->getAllState(); ?>
															<?php foreach($statelist as $state){ ?>
	                                                            <li><label class="checkbox-inline"><input type="checkbox" class="checkbox-state" value="<?php echo $state->id; ?>"><?php echo $state->state_name; ?></label></li>
															<?php } ?>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="sub_list">
                                                    <ul>
                                                        <li>3 Months Premium Access</li>
                                                        <li>Auction Document/Notice</li>
                                                        <li>Auction History</li>
                                                        <li>Daily Mobile Notification</li>
                                                        <li>Daily Email Alert</li>
                                                        <li>Multiple City Email Alert</li>
                                                        <li>Email Support</li>
                                                    </ul>
                                                </div>
												<?php if($this->session->userdata('id') > 0){ ?>	
													<input type="hidden" name="package_id" value="<?php echo $subcription_plan[3]->package_id; ?>" />
													<button class="btn btn-default upgrade_btn sec-package" type="button" data-id="<?php echo $subcription_plan[3]->package_id; ?>">Upgrade Now</button>
												<?php }else{ ?>
													<a href="<?php echo base_url(); ?>home/login?action=premium"><button class="btn btn-default upgrade_btn" type="button">Login to Subscribe</button></a>
												<?php } ?>
                                            </div><!--subscription_box-->
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="subscription_box">
                                                <div class="sub_price">
                                                    <h4>6 Months</h4>
                                                    <div><span><img src="<?php echo base_url(); ?>assets/auctiononclick/images/rupees.png"></span><span class="rupees">2500</span></div>
                                                    <h4 class="states_desc">For any two states</h4>
                                                    <p class="additional_desc">Get additional state for just</p>
                                                    <div class="state_price"><span><img src="<?php echo base_url(); ?>assets/auctiononclick/images/rupees_small.png"></span><span class="rupees">200</span><span class="small_state">/state</span></div>
                                                </div>
                                                <div class="checklist_state">
                                                    <div class="dropdown">
                                                        <button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">Select States
                                                            <span class="caret"></span></button>
                                                        <ul class="dropdown-menu">
                                                            <?php $statelist = $this->home_model->getAllState(); ?>
															<?php foreach($statelist as $state){ ?>
	                                                            <li><label class="checkbox-inline"><input type="checkbox" class="checkbox-state" value="<?php echo $state->id; ?>"><?php echo $state->state_name; ?></label></li>
															<?php } ?>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="sub_list">
                                                    <ul>
                                                        <li>6 Months Premium Access</li>
                                                        <li>Auction Document/Notice</li>
                                                        <li>Auction History</li>
                                                        <li>Daily Mobile Notification</li>
                                                        <li>Daily Email Alert</li>
                                                        <li>Multiple City Email Alert</li>
                                                        <li>Email Support</li>
                                                    </ul>
                                                </div>
                                                <?php if($this->session->userdata('id') > 0){ ?>	
													<input type="hidden" name="package_id" value="<?php echo $subcription_plan[4]->package_id; ?>" />
													<button class="btn btn-default upgrade_btn sec-package" type="button" data-id="<?php echo $subcription_plan[4]->package_id; ?>">Upgrade Now</button>
												<?php }else{ ?>
													<a href="<?php echo base_url(); ?>home/login?action=premium"><button class="btn btn-default upgrade_btn" type="button">Login to Subscribe</button></a>
												<?php } ?>
                                            </div><!--subscription_box-->
                                        </div>
                                        <div class="col-sm-4">
                                            <div class="subscription_box">
                                                <div class="sub_price">
                                                    <h4>12 Months</h4>
                                                    <div><span><img src="<?php echo base_url(); ?>assets/auctiononclick/images/rupees.png"></span><span class="rupees">4000</span></div>
                                                    <h4 class="states_desc">For any two states</h4>
                                                    <p class="additional_desc">Get additional state for just</p>
                                                    <div class="state_price"><span><img src="<?php echo base_url(); ?>assets/auctiononclick/images/rupees_small.png"></span><span class="rupees">400</span><span class="small_state">/state</span></div>
                                                </div>
                                                <div class="checklist_state">
                                                    <div class="dropdown">
                                                        <button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown" aria-expanded="false">Select States
                                                            <span class="caret"></span></button>
                                                        <ul class="dropdown-menu">
															<?php $statelist = $this->home_model->getAllState(); ?>
															<?php foreach($statelist as $state){ ?>
	                                                            <li><label class="checkbox-inline"><input type="checkbox" class="checkbox-state" value="<?php echo $state->id; ?>"><?php echo $state->state_name; ?></label></li>
															<?php } ?>
                                                        </ul>
                                                    </div>
                                                </div>
                                                <div class="sub_list">
                                                    <ul>
                                                        <li>12 Months Premium Access</li>
                                                        <li>Auction Document/Notice</li>
                                                        <li>Auction History</li>
                                                        <li>Daily Mobile Notification</li>
                                                        <li>Daily Email Alert</li>
                                                        <li>Multiple City Email Alert</li>
                                                        <li>Email Support</li>
                                                    </ul>
                                                </div>
                                                <?php if($this->session->userdata('id') > 0){ ?>	
													<input type="hidden" name="package_id" value="<?php echo $subcription_plan[5]->package_id; ?>" />
													<button class="btn btn-default upgrade_btn sec-package" type="button" data-id="<?php echo $subcription_plan[5]->package_id; ?>">Upgrade Now</button>
												<?php }else{ ?>
													<a href="<?php echo base_url(); ?>home/login?action=premium"><button class="btn btn-default upgrade_btn" type="button">Login to Subscribe</button></a>
												<?php } ?>
                                            </div><!--subscription_box-->
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    </div>
            </div>
        </div><!--container-fluid-->
        </div>
		<script>
			$(document).ready(function(){
				$(".checkbox-state").change(function(){
					var checkbox_length = $(this).closest('.dropdown-menu').find('[type=checkbox]:checked').length;
					if(checkbox_length > 3)
					{
						alert('Please choose only 3 states!');
						$(this).prop('checked',false);
					}
				});

				$(".sec-package").click(function(event){
					var data_id = $(this).attr('data-id');
					if(data_id > 3)
					{
						var selected_checkbox = $(this).closest('.subscription_box').find('[type=checkbox]:checked').length;
						if(selected_checkbox == 3)
						{
							var state = '';
							$(this).closest('.subscription_box').find('[type=checkbox]:checked').each(function(){
								var val = $(this).val();
								state += '&state[]='+val;
							});
							window.location='?package_id='+data_id+state;
						}
						else
						{
							alert('Please select 3 states!');
						}
					}
					else
					{
						window.location='?package_id='+data_id;
					}
				});
			});
		</script>