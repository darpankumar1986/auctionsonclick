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
                                                        <li>Pan India Premium Access</li>
														<li>View Complete Auction Details</li>
														<li>Download Auction Document/Notice</li>
														<li>Download Property Pictures</li>
														<li>Daily/Weekly Email Alert</li>
														<li>Multiple City Email Alert</li>
														<li>Advanced Search </li>
														<li>Email Support</li>
                                                    </ul>
                                                </div>
												<?php if($this->session->userdata('id') > 0){ ?>
													<?php $currentpackage = $this->home_model->getCurrentPackage($this->session->userdata('id')); ?>
													
													<input type="hidden" name="package_id" value="<?php echo $subcription_plan[0]->package_id; ?>" />
													
										<input type="hidden" class="city_per_cost" name="text" value="<?php echo $packagelist[0]->city_per_cost; ?>" />
										<input type="hidden" class="package_city" name="text" value="<?php echo $packagelist[0]->package_city; ?>" />
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
                                                        <li>Pan India Premium Access</li>
														<li>View Complete Auction Details</li>
														<li>Download Auction Document/Notice</li>
														<li>Download Property Pictures</li>
														<li>Daily/Weekly Email Alert</li>
														<li>Multiple City Email Alert</li>
														<li>Advanced Search </li>
														<li>Email Support</li>
                                                    </ul>
                                                </div>
                                                <?php if($this->session->userdata('id') > 0){ ?>	
													<?php $currentpackage = $this->home_model->getCurrentPackage($this->session->userdata('id')); ?>
											
														<input type="hidden" name="package_id" value="<?php echo $subcription_plan[1]->package_id; ?>" />
														
										<input type="hidden" class="city_per_cost" name="text" value="<?php echo $packagelist[1]->city_per_cost; ?>" />
										<input type="hidden" class="package_city" name="text" value="<?php echo $packagelist[1]->package_city; ?>" />
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
                                                        <li>Pan India Premium Access</li>
														<li>View Complete Auction Details</li>
														<li>Download Auction Document/Notice</li>
														<li>Download Property Pictures</li>
														<li>Daily/Weekly Email Alert</li>
														<li>Multiple City Email Alert</li>
														<li>Advanced Search </li>
														<li>Email Support</li>
                                                    </ul>
                                                </div>
                                                <?php if($this->session->userdata('id') > 0){ ?>	
													<?php $currentpackage = $this->home_model->getCurrentPackage($this->session->userdata('id')); ?>
									
													<input type="hidden" name="package_id" value="<?php echo $subcription_plan[2]->package_id; ?>" />
													
										<input type="hidden" class="city_per_cost" name="text" value="<?php echo $packagelist[2]->city_per_cost; ?>" />
										<input type="hidden" class="package_city" name="text" value="<?php echo $packagelist[2]->package_city; ?>" />
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
                                                        <li>Subscribed States Premium Access</li>
														<li>View Complete Auction Details</li>
														<li>Download Auction Document/Notice</li>
														<li>Download Property Pictures</li>
														<li>Daily/Weekly Email Alerts</li>
														<li>Multiple City Email Alerts</li>
														<li>Advanced Search </li>
														<li>Email Support</li>
                                                    </ul>
                                                </div>
												<?php if($this->session->userdata('id') > 0){ ?>
													<?php $currentpackage = $this->home_model->getCurrentPackage($this->session->userdata('id')); ?>
									
													<input type="hidden" name="package_id" value="<?php echo $subcription_plan[3]->package_id; ?>" />
													
										<input type="hidden" class="city_per_cost" name="text" value="<?php echo $packagelist[3]->city_per_cost; ?>" />
										<input type="hidden" class="package_city" name="text" value="<?php echo $packagelist[3]->package_city; ?>" />
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
                                                        <li>Subscribed States Premium Access</li>
														<li>View Complete Auction Details</li>
														<li>Download Auction Document/Notice</li>
														<li>Download Property Pictures</li>
														<li>Daily/Weekly Email Alerts</li>
														<li>Multiple City Email Alerts</li>
														<li>Advanced Search </li>
														<li>Email Support</li>
                                                    </ul>
                                                </div>
                                                <?php if($this->session->userdata('id') > 0){ ?>
													<?php $currentpackage = $this->home_model->getCurrentPackage($this->session->userdata('id')); ?>

														<input type="hidden" name="package_id" value="<?php echo $subcription_plan[4]->package_id; ?>" />						
										<input type="hidden" class="city_per_cost" name="text" value="<?php echo $packagelist[4]->city_per_cost; ?>" />
										<input type="hidden" class="package_city" name="text" value="<?php echo $packagelist[4]->package_city; ?>" />
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
                                                        <li>Subscribed States Premium Access</li>
														<li>View Complete Auction Details</li>
														<li>Download Auction Document/Notice</li>
														<li>Download Property Pictures</li>
														<li>Daily/Weekly Email Alerts</li>
														<li>Multiple City Email Alerts</li>
														<li>Advanced Search </li>
														<li>Email Support</li>
                                                    </ul>
                                                </div>
                                                <?php if($this->session->userdata('id') > 0){ ?>
													<?php $currentpackage = $this->home_model->getCurrentPackage($this->session->userdata('id')); ?>

														<input type="hidden" name="package_id" value="<?php echo $subcription_plan[5]->package_id; ?>" />
										<input type="hidden" class="city_per_cost" name="text" value="<?php echo $packagelist[5]->city_per_cost; ?>" />
										<input type="hidden" class="package_city" name="text" value="<?php echo $packagelist[5]->package_city; ?>" />
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
					if(checkbox_length > 2 && false)
					{
						alert('Please choose only 2 states!');
						$(this).prop('checked',false);
					}
					var obj = $(this);
					setTimeout(function(){
						setStateTitle(obj);
					},10);
				});

				$(".sec-package").click(function(event){
					var data_id = $(this).attr('data-id');
					if(data_id > 3)
					{
						var selected_checkbox = $(this).closest('.subscription_box').find('[type=checkbox]:checked').length;
						if(selected_checkbox == 2 || true)
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
							alert('Please select 2 states!');
						}
					}
					else
					{
						window.location='?package_id='+data_id;
					}
				});

				$('.dropdown ul').on('click', function (e) {
					 e.stopPropagation();
				});
			});
			function setStateTitle(obj)
			{
				var icon = '<span class="caret"></span>';
				var checkbox_length = obj.closest('.dropdown-menu').find('[type=checkbox]:checked').length;

				if(checkbox_length == 1)
				{
					obj.closest('.checklist_state').find('.dropdown .btn').html(checkbox_length + ' Selected'+icon);
				}
				else if(checkbox_length > 0)
				{
					obj.closest('.checklist_state').find('.dropdown .btn').html(checkbox_length + ' Selected'+icon);
				}
				else
				{
					obj.closest('.checklist_state').find('.dropdown .btn').html('Selecte States'+icon);
				}
			}
		</script>