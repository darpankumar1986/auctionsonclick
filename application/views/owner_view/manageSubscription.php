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
        $full_name .= ' '.GetTitleByField('tbl_user_registration', "id='".$userid."'", "authorized_person");
    }

    $currentpackage = $this->home_model->getLastPackage($userid);


    $totalActivePackage = $this->home_model->getTotalActivePackage($userid);

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

    $package_start_date_str = strtotime($package_start_date);
    $package_end_date_str = strtotime($package_end_date);
    $pdiff = $package_end_date_str - $package_start_date_str;
    $total_package_day = floor($pdiff/86400);
    $per_day_cost = round($package_amount/$total_package_day,4);

    //$consumed_amount = ceil($package[0]->per_day_cost*$consumed_day);

    $consumed_amount = ceil($per_day_cost*$consumed_day);
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

    if($package_id == 4)
    {
        //$package4 = "_disable";
        //$package5 = "_disable";
        //$package6 = "_disable";
        $currentplan4 = "current_plan";
    }

    if($package_id == 5)
    {
        $package1 = "_disable";
        $package4 = "_disable";
        $currentplan5 = "current_plan";
    }

    if($package_id == 6)
    {
        $package1 = "_disable";
        $package2 = "_disable";
        $package4 = "_disable";
        $package5 = "_disable";
        $currentplan6 = "current_plan";
    }


?>
<style>
.Subscription_plan{display: none;}
</style>
<script>
var remaining_amount = "<?php echo $remaining_amount; ?>";
$(document).ready(function(){
	

    $(document).click(function(e){
        console.log(event.target);
        var flag = $(event.target).closest('.packageplan').length;
        var flag1 = $(event.target).closest('.Active_membership').length;
        var flag2 = $(event.target).closest('.current_membership').length;
        var flag3 = $(event.target).closest('.state_chosen_wrapper').length;

        if(!flag && !flag1 && !flag2 && !flag3)
        {
             $(".packageplan").removeClass('active_plan');
             $(".subscription_disable_text").hide();
             $(".subscription_text").hide();
             $(".statewise_text").hide();
             $(".selected_states").hide();
        }
    });
    $("#upgrade_subscription").click(function(){
        $(".Subscription_plan").slideToggle();
        var currHeight = $(".current_plan .subscription_box").outerHeight();
        $("#State_Wise .packageplan .subscription_box").css('height',currHeight+'px');
    });
    $(".packageplan").click(function(){
        if(!$(this).hasClass('current_plan'))
        {
            $(".packageplan").removeClass('active_plan');
            $(this).addClass('active_plan');


            if($(this).closest('.packageplan').parent().hasClass('subscription_disable') || $(this).closest('.packageplan').hasClass('subscription_disable'))
            {
                $(".subscription_disable_text").show();
                $(".subscription_text").hide();
                $(".statewise_text").hide();
                $(".selected_states").hide();
            }
            else
            {
                var plan_amount = $(this).find('.plan_amount').val();
                var plan_renewal_date = $(this).find('.package_renewal_date').val();
                var due_cost = plan_amount - remaining_amount;


                var checkbox_length = $(".packageplan.active_plan").find('[type=checkbox]:checked').length;
                if(checkbox_length > 2)
                {
                    var city_per_cost = $(".packageplan.active_plan").find('.city_per_cost').val();
                    var due_cost = due_cost + ((checkbox_length - 2)*city_per_cost);
                }

                if(due_cost > 0)
                {
                    $("#due_cost").html(due_cost);

                    $(".subscription_disable_text").hide();
                    $(".subscription_text").show();
                    $(".statewise_text").hide();
                    $(".selected_states").hide();
                    $("#renewal_date_msg").html('New renewal date: '+plan_renewal_date);
                }
                else
                {
                    $(".subscription_disable_text").show();
                    $(".subscription_text").hide();
                    $(".statewise_text").hide();
                    $(".selected_states").hide();
                }
            }
        }
    });

    $(".pay_now.upgrade_plan").click(function(){
            var plan_amount = $(".packageplan.active_plan").find('.plan_amount').val();
            var due_cost = plan_amount - remaining_amount;
            var package_id = $(".packageplan.active_plan").find('.package_id').val();
            var package_city = $(".packageplan.active_plan").find('.package_city').val();
            var city_per_cost = $(".packageplan.active_plan").find('.city_per_cost').val();

            if(package_id > 3)
            {
                var checkbox_length = $(".packageplan.active_plan").find('[type=checkbox]:checked').length;

                if(checkbox_length > 2)
                {
                    var due_cost = due_cost + ((checkbox_length - 2)*city_per_cost);
                }

                if(checkbox_length == package_city || true)
                {
                    var state = '';
                    $(".packageplan.active_plan").find('[type=checkbox]:checked').each(function(){
                        var val = $(this).val();
                        state += '&state[]='+val;
                    });
                    window.location = '?package_id='+package_id+'&due_cost='+due_cost+state;
                }
                else
                {
                    alert('Please select '+package_city+' states!');
                }
            }
            else
            {
                window.location = '?package_id='+package_id+'&due_cost='+due_cost;
            }


    });

    $(".login_inner_page .nav-tabs a").click(function(){
        $(".subscription_disable_text").hide();
        $(".subscription_text").hide();
        $(".packageplan").removeClass('active_plan');
        $(".statewise_text").hide();
        $(".selected_states").hide();
    });

    $(".checkbox-state").change(function(){
        var checkbox_length = $(this).closest('.dropdown-menu').find('[type=checkbox]:checked').length;
        if(checkbox_length > 2)
        {
            var plan_amount = $(".packageplan.active_plan").find('.plan_amount').val();
            var city_per_cost = $(".packageplan.active_plan").find('.city_per_cost').val();

            var due_cost = plan_amount - remaining_amount + ((checkbox_length - 2)*city_per_cost);
            $("#due_cost").html(due_cost);

        }
        else
        {
            var plan_amount = $(".packageplan.active_plan").find('.plan_amount').val();
            var city_per_cost = $(".packageplan.active_plan").find('.city_per_cost').val();
            var due_cost = plan_amount - remaining_amount;
            $("#due_cost").html(due_cost);
        }

        var obj = $(this);
        setTimeout(function(){
            setStateTitle(obj);
        },10);
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

$(document).ready(function(){


    $(".confirm_btn").click(function(){
        var selected_state = '';
        var add_state_count = 0;
        $(".all_state_list input[type=checkbox]:checked").each(function(){
            var state_name = $(this).attr('data-name');
            if(selected_state != '')
            {
                selected_state += ', ';
            }
            selected_state += state_name;

            add_state_count += 1;
        });
        if(add_state_count > 0)
        {
            $(".selected_states span").html(selected_state);
            $(".selected_states").show();
            $(".all_state_list").hide();

            $(".subscription_disable_text").hide();
            $(".subscription_text").hide();
            $(".packageplan").removeClass('active_plan');
            $(".statewise_text").show();
            $("#add_state_count").html(add_state_count);
            $("#due_cost_state").html(add_state_count*<?php echo $package[0]->city_per_cost; ?>);
            $("#statewise_text_data").html(selected_state);
            $("#statewise_city_per_day").html('<?php echo round($package[0]->city_per_cost,0); ?>');
        }
        else
        {
            $(".all_state_list").hide();
            $(".selected_states").hide();
            $(".statewise_text").hide();
            $(".packageplan").removeClass('active_plan');
        }
    });

    $(".pay_now.add_state").click(function(){
        var state = '';
        var add_state_count = 0;
        $(".all_state_list input[type=checkbox]:checked").each(function(){
            var state_id = $(this).val();
            state += '&state[]='+state_id;
            add_state_count += 1;
        });

        var due_cost = add_state_count*<?php echo $package[0]->city_per_cost; ?>;

        window.location = '?package_id=<?php echo $package[0]->package_id; ?>&package_type=3&due_cost='+due_cost+state;
    });

    $('.dropdown ul').on('click', function (e) {
         e.stopPropagation();
    });

	<?php if($_GET['l'] == 1){ ?>
		$("#upgrade_subscription").click();
	<?php } ?>
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
<?php if($currentpackage->package_id > 0){ ?>
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
                                       <h4><?php echo ($package_id > 3)?'State Wise (Any 2 States)':'PAN India'; ?></h4>
                                       <p class="common_date"><?php echo $package[0]->sub_month;?> Months Plan</p>
                                       <?php if($package_id > 3){ $state_bidder = $this->home_model->get_state_bidder($currentpackage->subscription_participate_id);?>
                                           <h4 class="other_desc_subscribe">States Chosen</h4>
                                           <p class="subscribe_address"><?php echo implode(", ",$state_bidder); ?></p>
                                       <?php } ?>
                                   </div>
                               </td>
                               <td>
                                   <div class="plan_desc">
                                       <h4 class="other_desc_subscribe">Subscribed on</h4>
                                       <p class="common_date"><?php echo $this->home_model->standardDateFormat($package_start_date); ?> at ₹<span><?php echo $package_amount; ?>.00</span></p>
                                       <?php if($package_id > 3 && count($state_bidder) > 2){ ?>
                                           <p class="subscribe_charges">Subscription charges ₹<?php echo $package[0]->package_amount; ?>.00 + <?php echo count($state_bidder)-2; ?> additional State charges ₹<?php echo $package_amount - $package[0]->package_amount; ?>.00</p>
                                       <?php } ?>
                                   </div>
                               </td>
                               <td>
                                   <div class="plan_desc">
                                        <?php if(strtotime($package_end_date) < time()) { ?>
                                            <h4 class="other_desc_subscribe red_color" id="expired_text">Subscription expired on</h4>
                                            <p class="common_date"><?php echo $this->home_model->standardDateFormat($package_end_date); ?> at ₹<span><?php echo $package_amount; ?>.00</span></p>
                                         <?php }else{ ?>
                                            <h4 class="other_desc_subscribe">Renewal</h4>
                                            <p class="common_date"><?php echo $this->home_model->standardDateFormat(date('Y-m-d H:i:s',strtotime($package_end_date) + 86400)); ?> at ₹<span><?php echo $package_amount; ?>.00</span></p>
                                        <?php } ?>

                                       <?php if(((strtotime($package_end_date)) - 259200) < time()) { ?>
                                           <?php if(strtotime($package_end_date) < time()) { ?>
                                                <button type="button" class="btn search_btn_new renew_btn" onclick="window.location = '<?php echo base_url(); ?>home/premiumServices'">Renew Now</button>
                                           <?php }else{ ?>
                                                <button type="button" class="btn search_btn_new renew_btn" onclick="window.location = '?package_id=<?php echo $package_id;?>&package_type=2'">Renew Now</button>
                                           <?php } ?>
                                       <?php } ?>
                                   </div>
                               </td>

                           </tr>
                       </tbody>
                   </table>
               </div>
           </div>
       </div>
   </div>
   <div class="row" >
        <div class="col-sm-12">
            <div class="subscribe_notification manage_sub_downgrade">
                 <?php /* if($totalActivePackage == 1 && ((strtotime($package_end_date)) - 259200) < time()) { ?>
                    <div class="reming_subscribe">
                        <p>Remind me about subscription renewal</p>
                        <p>Receive an email or SMS reminder 3 days before your renewal date</p>
                    </div>
                <?php }else{ ?>
                    <div class="subscribe_notification_inner">
                         <p>A reminder email/SMS for your subscription renewal will be sent to you on <?php echo date('F dS, Y',strtotime($package_end_date) - 259200); ?>.</p>
                        <p class="reminder_off"><a href="#">Turn off reminder email/SMS</a></p>
                    </div>
                <?php } */ ?>


                <?php if(strtotime($package_end_date) > time()) { ?>
                    <div class="cancel_subscription">
                        <button type="button" class="btn search_btn_new" id="upgrade_subscription">Upgrade Subscription</button>
                    </div>
                <?php } ?>
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
                            <li class="<?php echo ($package_id < 4 )?'active':''; ?>" ><a data-toggle="tab" href="#PAN_India">PAN India</a></li>
                            <li class="<?php echo ($package_id > 3 )?'active':''; ?>" ><a data-toggle="tab" href="#State_Wise">State Wise</a></li>
                        </ul>
                    </div>
                </div>
                <div class="tab-content pan_subscription_tab">
                    <div id="PAN_India" class="tab-pane fade <?php echo ($package_id < 4 )?'in active':''; ?>" >
                        <div class="row">
                            <div class="col-sm-4 subscription<?php echo $package1; ?>">
                                <div class="<?php  echo $currentplan1; ?> packageplan">
                                    <div class="subscription_box">
                                        <div class="sub_price">
                                            <h4>3 Months</h4>
                                            <div><span><img src="<?php echo base_url(); ?>assets/auctiononclick/images/rupees_medium.png">
                                                <img class="white_rupees" src="<?php echo base_url(); ?>assets/auctiononclick/images/rupees_medium_white.png"></span><span class="rupees"><?php echo $packagelist[0]->package_amount; ?></span></div>
                                            <input type="hidden" class="plan_amount" name="text" value="<?php echo $packagelist[0]->package_amount; ?>" />
                                            <input type="hidden" class="package_id" name="text" value="<?php echo $packagelist[0]->package_id; ?>" />
                                            <input type="hidden" class="package_renewal_date" name="text" value="<?php echo $this->home_model->standardDateFormat(date('Y-m-d 23:59:59',strtotime("+".$packagelist[0]->sub_month." months")-86400)); ?>" />
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
                                            <div><span><img src="<?php echo base_url(); ?>assets/auctiononclick/images/rupees_medium.png">
                                                <img class="white_rupees" src="<?php echo base_url(); ?>assets/auctiononclick/images/rupees_medium_white.png">
                                                </span><span class="rupees"><?php echo $packagelist[1]->package_amount; ?></span></div>
                                            <input type="hidden" class="plan_amount" name="text" value="<?php echo $packagelist[1]->package_amount; ?>" />
                                            <input type="hidden" class="package_id" name="text" value="<?php echo $packagelist[1]->package_id; ?>" />
                                            <input type="hidden" class="package_renewal_date" name="text" value="<?php echo $this->home_model->standardDateFormat(date('Y-m-d 23:59:59',strtotime("+".$packagelist[1]->sub_month." months")-86400)); ?>" />
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
                                            <div><span><img src="<?php echo base_url(); ?>assets/auctiononclick/images/rupees_medium.png">
                                                <img class="white_rupees" src="<?php echo base_url(); ?>assets/auctiononclick/images/rupees_medium_white.png">
                                                </span><span class="rupees"><?php echo $packagelist[2]->package_amount; ?></span></div>
                                                <input type="hidden" class="plan_amount" name="text" value="<?php echo $packagelist[2]->package_amount; ?>" />
                                                <input type="hidden" class="package_id" name="text" value="<?php echo $packagelist[2]->package_id; ?>" />
                                                <input type="hidden" class="package_renewal_date" name="text" value="<?php echo $this->home_model->standardDateFormat(date('Y-m-d 23:59:59',strtotime("+".$packagelist[2]->sub_month." months")-86400)); ?>" />
                                        </div>
                                    </div><!--subscription_box-->
                                    <?php if($currentplan3 != ''){ ?>
                                        <p>Current Plan</p>
                                    <?php } ?>
                                </div>

                            </div>
                        </div>

                    </div>
                    <div id="State_Wise" class="tab-pane fade state_wise_tab <?php echo ($package_id > 3 )?'in active':''; ?>">
                        <div class="row">
                            <div class="col-sm-4 subscription<?php echo $package4; ?>  <?php  echo $currentplan4; ?> packageplan">
                               <div class="">
                                <div class="subscription_box">
                                    <div class="sub_price">
                                        <h4>3 Months</h4>
                                        <div><span><img src="<?php echo base_url(); ?>assets/auctiononclick/images/rupees_medium.png"><img class="white_rupees" src="<?php echo base_url(); ?>assets/auctiononclick/images/rupees_medium_white.png"></span><span class="rupees"><?php echo $packagelist[3]->package_amount; ?></span></div>
                                        <h4 class="states_desc">For any two states</h4>
                                        <p class="additional_desc">Get additional state for just</p>
                                        <div class="state_price"><span><img src="<?php echo base_url(); ?>assets/auctiononclick/images/rupees_small_sm.png"><img class="white_rupees" src="<?php echo base_url(); ?>assets/auctiononclick/images/rupees_small_sm_white.png"></span><span class="rupees">100</span><span class="small_state">/state</span>


                                                <input type="hidden" class="plan_amount" name="text" value="<?php echo $packagelist[3]->package_amount; ?>" />
                                                <input type="hidden" class="package_id" name="text" value="<?php echo $packagelist[3]->package_id; ?>" />
                                                <input type="hidden" class="city_per_cost" name="text" value="<?php echo $packagelist[3]->city_per_cost; ?>" />
                                                <input type="hidden" class="package_city" name="text" value="<?php echo $packagelist[3]->package_city; ?>" />
                                                <input type="hidden" class="package_renewal_date" name="text" value="<?php echo $this->home_model->standardDateFormat(date('Y-m-d 23:59:59',strtotime("+".$packagelist[3]->sub_month." months")-86400)); ?>" />

                                            <?php  if($currentplan4 != ''){ ?>
                                                <div class="plan_desc state_chosen">
                                                    <?php $state_bidder = $this->home_model->get_state_bidder($currentpackage->subscription_participate_id);?>
                                                    <h4 class="other_desc_subscribe">States Chosen</h4>
                                                    <p class="subscribe_address"><?php echo implode(", ",$state_bidder); ?></p>
                                                </div>
                                            <?php } ?>
                                        </div>
                                    </div>
                                    <?php  if($currentplan4 == ''){ ?>
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
                                    <?php } ?>
                                </div><!--subscription_box-->
                                  <?php if($currentplan4 != ''){ ?>
                                        <p>Current Plan</p>
                                    <?php } ?>
                                </div>
                            </div>
                            <div class="col-sm-4 subscription<?php echo $package5; ?> <?php  echo $currentplan5; ?> packageplan">
                                <div class="subscription_box">
                                    <div class="sub_price">
                                        <h4>6 Months</h4>
                                        <div><span><img src="<?php echo base_url(); ?>assets/auctiononclick/images/rupees_medium.png"><img class="white_rupees" src="<?php echo base_url(); ?>assets/auctiononclick/images/rupees_medium_white.png"></span><span class="rupees">2500</span></div>
                                        <h4 class="states_desc">For any two states</h4>
                                        <p class="additional_desc">Get additional state for just</p>
                                        <div class="state_price"><span><img src="<?php echo base_url(); ?>assets/auctiononclick/images/rupees_small_sm.png"><img class="white_rupees" src="<?php echo base_url(); ?>assets/auctiononclick/images/rupees_small_sm_white.png"></span><span class="rupees">200</span><span class="small_state">/state</span></div>

                                        <input type="hidden" class="plan_amount" name="text" value="<?php echo $packagelist[4]->package_amount; ?>" />
                                        <input type="hidden" class="package_id" name="text" value="<?php echo $packagelist[4]->package_id; ?>" />
                                        <input type="hidden" class="city_per_cost" name="text" value="<?php echo $packagelist[4]->city_per_cost; ?>" />
                                        <input type="hidden" class="package_city" name="text" value="<?php echo $packagelist[4]->package_city; ?>" />
                                        <input type="hidden" class="package_renewal_date" name="text" value="<?php echo $this->home_model->standardDateFormat(date('Y-m-d 23:59:59',strtotime("+".$packagelist[4]->sub_month." months")-86400)); ?>" />

                                        <?php  if($currentplan5 != ''){ ?>
                                        <div class="plan_desc state_chosen">
                                            <?php $state_bidder = $this->home_model->get_state_bidder($currentpackage->subscription_participate_id);?>
                                            <h4 class="other_desc_subscribe">States Chosen</h4>
                                            <p class="subscribe_address"><?php echo implode(", ",$state_bidder); ?></p>
                                        </div>
                                        <?php } ?>
                                    </div>
                                    <?php  if($currentplan5 == ''){ ?>
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
                                    <?php } ?>
                                </div><!--subscription_box-->
                                <?php if($currentplan5 != ''){ ?>
                                        <p>Current Plan</p>
                                    <?php } ?>
                            </div>
                            <div class="col-sm-4 subscription<?php echo $package6; ?> <?php  echo $currentplan6; ?> packageplan">
                                <div class="subscription_box">
                                    <div class="sub_price">
                                        <h4>12 Months</h4>
                                        <div><span><img src="<?php echo base_url(); ?>assets/auctiononclick/images/rupees_medium.png"><img class="white_rupees" src="<?php echo base_url(); ?>assets/auctiononclick/images/rupees_medium_white.png"></span><span class="rupees">4000</span></div>
                                        <h4 class="states_desc">For any two states</h4>
                                        <p class="additional_desc">Get additional state for just</p>
                                        <div class="state_price"><span><img src="<?php echo base_url(); ?>assets/auctiononclick/images/rupees_small_sm.png"><img class="white_rupees" src="<?php echo base_url(); ?>assets/auctiononclick/images/rupees_small_sm_white.png"></span><span class="rupees">400</span><span class="small_state">/state</span></div>

                                        <input type="hidden" class="plan_amount" name="text" value="<?php echo $packagelist[5]->package_amount; ?>" />
                                        <input type="hidden" class="package_id" name="text" value="<?php echo $packagelist[5]->package_id; ?>" />
                                        <input type="hidden" class="city_per_cost" name="text" value="<?php echo $packagelist[5]->city_per_cost; ?>" />
                                        <input type="hidden" class="package_city" name="text" value="<?php echo $packagelist[5]->package_city; ?>" />
                                        <input type="hidden" class="package_renewal_date" name="text" value="<?php echo $this->home_model->standardDateFormat(date('Y-m-d 23:59:59',strtotime("+".$packagelist[5]->sub_month." months")-86400)); ?>" />

                                        <?php  if($currentplan6 != ''){ ?>
                                        <div class="plan_desc state_chosen">
                                            <?php $state_bidder = $this->home_model->get_state_bidder($currentpackage->subscription_participate_id);?>
                                            <h4 class="other_desc_subscribe">States Chosen</h4>
                                            <p class="subscribe_address"><?php echo implode(", ",$state_bidder); ?></p>
                                        </div>
                                        <?php } ?>
                                    </div>
                                    <?php  if($currentplan6 == ''){ ?>
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
                                    <?php } ?>
                                </div><!--subscription_box-->
                                <?php if($currentplan6 != ''){ ?>
                                        <p>Current Plan</p>
                                    <?php } ?>
                            </div>
                        </div>
                        <?php if($package_id > 3 ){ ?>
                        <div class="row">
                            <div class="col-sm-12 current_left" style="padding:0;"><!-- current_left,current_center,current_right -->
                                <div class="state_chosen_wrapper">
                                   <div class="hide_list clearfix">
                                       <p class="add_more_state <?php if($package_id == 5){echo 'more_state_center';} ?><?php if($package_id == 6){echo 'more_state_right';} ?>">Add more states <span><i class="fa fa-angle-down"></i></span>
                                       </p>
                                       <div class="all_state_list">
                                           <div class="all_state_list_inner">
                                              <div class="popup_close_btn">
                                               <button type="button" class="closebtn_popup">×</button>
                                               </div>
                                               <ul>
                                                   <?php $statelist = $this->home_model->getAllState(); ?>
                                                   <?php foreach($statelist as $state){ ?>
                                                        <?php if(!in_array($state->state_name,$state_bidder)){ ?>
                                                           <li>
                                                              <div class="update_password updated_list">
                                                               <label class="container-checkbox"><?php echo $state->state_name; ?>
                                                                   <input type="checkbox" class="checkbox-state" value="<?php echo $state->id; ?>" data-name="<?php echo $state->state_name; ?>">
                                                                   <span class="checkmark"></span>
                                                               </label>
                                                               </div>
                                                            </li>
                                                        <?php } ?>
                                                    <?php } ?>
                                               </ul>
                                               <div class="confirm_btn">
                                                   <button type="button" class="btn search_btn_new">Confirm</button>
                                               </div>
                                           </div><!--all_state_list_inner-->
                                       </div><!--all_state_list-->
                                    </div><!--hide_list-->
                                    <p class="selected_states" style="display: none;">Chosen States: <span></span></p>
                                </div>
                            </div>
                        </div>
                        <?php } ?>
                    </div>
                </div>
            </div><!--pan_state_tab-->

            <div class="pan_state_tab">
                <div class="row subscription_disable_text" style="display: none;">
                    <div class="col-sm-12">
                        <div class="current_membership">
                            <p>Your current membership will continue until <?php echo $this->home_model->standardDateFormat(date('Y-m-d H:i:s',strtotime($package_end_date) + 86400)); ?> after which you can change your plan.</p>
                        </div>
                    </div>
                </div>
                <div class="row subscription_text" style="display: none;">
                    <div class="col-sm-12">
                        <div class="Active_membership">
                            <p>Your current membership is for <?php echo $package[0]->sub_month;?> months, your consumed days and amount will be adjusted to this new subscription.</p>
                            <p><span>Amount paid for <?php echo $package[0]->sub_month;?> months: ₹<?php echo $package_amount; ?>.00</span> | <span>Days consumed: <?php echo $consumed_day; ?> days</span> | <span id="renewal_date_msg">New renewal date: <?php echo date('F dS, Y',strtotime($package_end_date) + 86400); ?></span></p>
                            <p class="amount_due">Amount due : ₹<span id="due_cost">2500</span> </p>
                            <button type="button" class="btn search_btn_new pay_now upgrade_plan">Pay Now</button>
                        </div>
                    </div>
                </div>
                <div class="row statewise_text" style="display: none;">
                    <div class="col-sm-12">
                        <div class="Active_membership">
                            <p>Your current membership is for <?php echo $package[0]->sub_month;?> months, you have added <span id="add_state_count" style="padding:0;">2</span> new states to your existing subscription.</p>
                            <p><!--<span>Chosen States: <span id="statewise_text_data" style="padding:0;">Tamilnadu,udisa</span></span>| --><span>Charges: ₹<span style="padding:0;" id="statewise_city_per_day">200</span>/State</span></p>
                            <p class="amount_due">Amount due : ₹<span id="due_cost_state">2500</span> </p>
                            <button type="button" class="btn search_btn_new pay_now add_state">Pay Now</button>
                        </div>
                    </div>
                </div>

            </div>

        </div>
    </div>
<div class="row">
    <div class="col-sm-12">
        <div class="manageSubmargin"></div>
    </div>
</div>
</div><!--container-->
<style>
    .pan_subscription_tab{margin-bottom: 0px;}

</style>
<?php }else{ ?>
    <div class="fail_msg" style="width: 100%; text-align: center;">No Subscription Plan</div><br/><br/><br/>
<?php } ?>
