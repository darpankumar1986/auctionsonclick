<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery.dataTables.min.js?rand=<?php echo CACHE_RANDOM; ?>"></script>
<script src="<?php echo base_url();?>js/jquery-ui-1.12.1.js?rand=<?php echo CACHE_RANDOM; ?>" type="text/javascript"></script>
<script type="text/javascript" src="<?php echo base_url()?>js/calender/jquery-ui-timepicker-addon.min.js?rand=<?php echo CACHE_RANDOM; ?>"></script>
<link rel="stylesheet" href="<?php echo base_url()?>js/calender/jquery-ui-timepicker-addon.css?rand=<?php echo CACHE_RANDOM; ?>">
<script src="<?php echo base_url(); ?>assets/auctiononclick/js/bootstrap.min.js?rand=<?php echo CACHE_RANDOM; ?>"></script>
<script type="text/javascript" src="<?php echo base_url();?>application/views/admin/js/plugins/jquery.uniform.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>application/views/admin/js/plugins/jquery.validate.min.js"></script>
<style>
.success_msg{width: 96%;float: left;color: #157D0B !important;font-size: 13px; background:#ccebc9;  border-left: solid 1px #bbb; border-right: solid 1px #bbb; text-align:left;font-weight: bold;	padding: 0 1% 0 3%;background-position: 4px 6px; line-height:30px;}

.error2{color:#000; font-size:12px; font-weight:bold; width:96%; float:left; background:#f78d8d; padding:5px 2%; }
</style>

<?php

foreach($emailAlertData as $key => $selectedEmailAlert)
{
    $alert_type = $key;
    $emailAerts = $selectedEmailAlert;
}

//echo '<pre>', print_r($emailAerts), '</pre>';die;
if($row){
    foreach($row as $tmp_data){
        $id=$tmp_data->id;
        $user_id = $tmp_data->email_id;
        $first_name = $tmp_data->first_name;
        $last_name = $tmp_data->last_name;
        $father_name = $tmp_data->father_name;
        $designation = $tmp_data->designation;
        $mobile_no = $tmp_data->mobile_no;
        $mobile_no = $tmp_data->mobile_no;
        $password = $tmp_data->password;

        $address1 = $tmp_data->address1;
        $address2 = $tmp_data->address2;
        $country_id = $tmp_data->country_id;
        $state_id = $tmp_data->state_id;
        $city_id = $tmp_data->city_id;
        $zip = $tmp_data->zip;
        $user_type = $tmp_data->user_type;
        $document_type = $tmp_data->document_type;
        $document_no = $tmp_data->document_no;
        $organisation_name = $tmp_data->organisation_name;
        $authorized_person = $tmp_data->authorized_person;
        $gst_no = $tmp_data->gst_no;
        $fax = $tmp_data->fax;
        $phone_no = $tmp_data->phone_no;
        $broker_name = $tmp_data->broker_name;
        $broker_photo = $tmp_data->broker_photo;
        $website_URL = $tmp_data->website_URL;
        $company_logo = $tmp_data->company_logo;
        $operating_since = $tmp_data->operating_since;
        $transacation_type = $tmp_data->transacation_type;
        $company_name = $tmp_data->company_name;
        $user_source = $tmp_data->user_source;
        $service_title = $tmp_data->service_title;
        if($transacation_type)
        {
            $transacation_typeArr=explode(',',$transacation_type);
        }
    }
}
//echo '<pre>', print_r($row), '</pre>';

?>

<div class="container-fluid container_margin">
   <div class="row ad_row_width">
        <?php
        $userid=$this->session->userdata('id');
         $isPremiumMember = $this->home_model->getTotalActivePackage($userid);
        if(!$isPremiumMember) {?>
        <div class="container">
              <div class="row advanced_search_row row_padding">
                  <div class="col-sm-12">
                      <div class="become_premium_member">
                          <p>Become Premium member to view auction details and documents.</p>
                      </div>
                  </div>
              </div>
          </div>
         <?php } ?>
       <div class="col-sm-12">
           <h3 class="premium_service user_profile">Profile</h3>
       </div>
   </div>
</div>
 <form class="custom_form register_form custom_search_form" name="myform" id="myform" method="POST" action="/owner/myProfileEditSave" enctype="multipart/form-data" autocomplete="off">
    <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash();?>" />
    <input type="hidden" name="profile_type" id="profile_type" value="<?php echo $user_type;?>" />
        <div class="container">
            <div class="row advanced_search_row">

            <?php

            if($this->session->flashdata('message_validation_1')){?>

                <dl class="success_msg">
                    <?php echo $this->session->flashdata('message_validation_1'); ?>
                </dl>
                <?php
            }?>
            <?php
             if($this->session->flashdata('message_validation')){?>

                <dl class="error2">
                    <?php echo $this->session->flashdata('message_validation'); ?>
                </dl>
            <?php } ?>
               <div class="col-sm-12">

                    <div class="custom_form register_form custom_search_form">
                        <div class="floating-form">
                           <div class="floating-label email_bg">
                                <input class="floating-input html_found" placeholder=" " value=" <?php echo($user_type=='owner')?'Individual':'Organization'; ?>" disabled='disabled'>
                                <label class="custom_label">Registered As</label>
                            </div>
                       </div>
                   </div>
               </div>
           </div>
           <?php  if($user_type=='builder'){ ?>
           <div class="row advanced_search_row">
                <div class="col-sm-12">
                    <div class="custom_form register_form custom_search_form profile_form">
                        <div class="floating-form">
                            <div class="floating-label">
                                <input class="floating-input html_found" type="text" name="organisation_name" id="organisation_name" value="<?php echo trim($organisation_name) ?>"placeholder=" ">
                                <label class="custom_label">Company Name</label>
                            </div>
                        </div>
                    </div>
            </div>
            <?php } ?>
            <div class="row advanced_search_row">
                <div class="col-sm-6">
                    <div class="custom_form register_form custom_search_form profile_form">
                        <div class="floating-form">
                            <?php  if($user_type=='builder'){ ?>
                            <div class="floating-label">
                                <input class="floating-input html_found" type="text" name="authorized_person" id="authorized_person" value="<?php echo trim($authorized_person) ?>"placeholder=" ">
                                <label class="custom_label">Person In Charge</label>
                            </div>
                            <?php } else { ?>
                            <div class="floating-label">
                                <input class="floating-input html_found" type="text" name="first_name" id="first_name" value="<?php echo trim($first_name) ?>"placeholder=" ">
                                <label class="custom_label">First Name</label>
                            </div>
                            <?php } ?>
                            <div class="floating-label email_bg">
                                <input class="floating-input html_found" type="email" placeholder=" " value="<?php echo $user_id; ?>" disabled='disabled'>
                                <label class="custom_label">Email ID</label>
                            </div>
                            <div class="floating-label">
                                <input class="floating-input html_found" name="address1" id="address1" value="<?php echo trim($address1) ?>" type="text" placeholder=" ">
                                <label class="custom_label">Address</label>
                            </div>
                            <div class="floating-label">
                                <input class="floating-input html_found" onkeypress="return isNumberKey(event);" maxlength="6" name="zip" id="zip" value="<?php echo trim($zip) ?>" type="text" placeholder=" ">
                                <label class="custom_label">Pincode</label>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="custom_form register_form custom_search_form profile_form">
                        <div class="floating-form">
                            <?php  if($user_type=='builder'){ ?>
                            <div class="floating-label">
                                <input class="floating-input html_found" name="gst_no" id="gst_no" value="<?php echo trim($gst_no) ?>" type="text" placeholder=" ">
                                <label class="custom_label">GST Number (Optional)</label>
                            </div>
                            <?php } else{ ?>
                            <div class="floating-label">
                                <input class="floating-input html_found" name="last_name" id="last_name" value="<?php echo trim($last_name) ?>" type="text" placeholder=" ">
                                <label class="custom_label">Last Name</label>
                            </div>
                            <?php  } ?>
                            <div class="floating-label email_bg">
                                <input class="floating-input html_found" type="text" placeholder=" " value="<?php echo trim($mobile_no) ?>" disabled='disabled'>
                                <label class="custom_label">Mobile Number</label>
                            </div>
                            <div class="floating-label">
                                <input type="text" class="floating-input form-control item-suggest dropdown-toggle" placeholder=" " name="city" id="city" value="<?php echo trim($city_id) ?>" />
                                <label class="custom_label">City</label>
                            </div>
                            </div>
                            <div class="floating-label">
                                <select class="floating-select" name="state" id="state" onclick="this.setAttribute('value', this.value);" value="">
                                    <option value="">Select State</option>
                                    <?php
                                    foreach($states as $state_record){?>
                                    <option value="<?php echo $state_record->id; ?>" <?php echo ($state_record->id==$state_id)?'selected':''; ?>><?php echo $state_record->state_name; ?></option>
                                    <?php }?>
                                </select>
                                <span class="highlight"></span>
                                <label class="custom_label <?php echo ($state_id > 0)?'defalult_floating':''; ?>">State</label>
                                <span class="eye_icon down_icon"><i class="fa fa-chevron-down"></i></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row advanced_search_row">
                <div class="col-sm-12">
                    <div class="custom_form register_form custom_search_form country_profile_mg">
                        <div class="floating-form">
                            <div class="floating-label">
                                <select class="floating-select" name="country" id="country" onclick="this.setAttribute('value', this.value);" value="">
                                    <option value="">Select Country</option>
                                    <?php
                                    foreach($countries as $country_record){ ?>
                                    <option value="<?php echo $country_record->id; ?>" <?php echo ($country_record->id==$country_id)?'selected':''; ?>><?php echo $country_record->country_name; ?></option>
                                    <?php } ?>
                                </select>
                                <span class="highlight"></span>
                                <label class="custom_label <?php echo ($country_id > 0)?'defalult_floating':''; ?>">Country</label>
                                <span class="eye_icon down_icon"><i class="fa fa-chevron-down"></i></span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row advanced_search_row">
                <div class="col-sm-12">
                    <div class="update_password">
                        <label class="container-checkbox">Update Password
                            <input type="checkbox" name="pcb" id="pcb" value="1" onclick="editField();">
                            <span class="checkmark"></span>
                        </label>
                    </div>
                </div>
            </div>
            <div class="row advanced_search_row">
                <div class="col-sm-6">
                    <div class="custom_form register_form custom_search_form profile_form">
                        <div class="floating-form">
                            <div class="floating-label">
                                <input class="floating-input html_found pcb password" name="password" id="password" type="Password" placeholder=" " disabled>
                                <label class="custom_label">New Password</label>
                                <span toggle="#password" class="fa eye_icon toggle-password fa-eye"></span>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="custom_form register_form custom_search_form profile_form">
                        <div class="floating-form">
                            <div class="floating-label">
                                <input class="floating-input html_found pcb" name="confirm_password" id="confirm_password" type="Password" placeholder=" " disabled>
                                <label class="custom_label">Confirm New Password</label>
                                <span toggle="#confirm_password" class="fa eye_icon toggle-password fa-eye"></span>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
            <div class="row advanced_search_row">
                <div class="col-sm-12">
                    <div class="update_password">
                        <label class="container-checkbox container-checkbox-hide">
                           Email Alerts
                        </label>
                    </div>
                    <div class="email_alerts">
                        <?php if($isPremiumMember > 0) {?>
                        <label class="container-radio">Daily Email Alerts
                            <input type="radio" <?php echo ($alert_type==1)?'checked="checked"':''; ?> name="alert_type" value="1">
                            <span class="checkmark"></span>
                        </label>
                        <?php } ?>
                        <label class="container-radio">Weekly Email Alerts
                            <input type="radio" <?php echo ($alert_type==2)?'checked="checked"':''; ?> name="alert_type" value="2">
                            <span class="checkmark"></span>
                        </label>
                    </div>
                    <div class="received_email_alerts">
                        <select name="email_alerts[]" data-placeholder="Recieve Email Alerts for:" multiple class="chosen-select" tabindex="8">
                            <option value=""></option>
                            <?php
                                foreach($cities as $city_record){?>
                                <option value="<?php echo $city_record->id; ?>" <?php echo (in_array($city_record->id, $emailAerts))?'selected':''; ?>><?php echo $city_record->city_name; ?></option>
                            <?php }?>

                        </select>
                        <span class="eye_icon down_icon"><i class="fa fa-chevron-down"></i></span>
                    </div>
                </div>
            </div>
            <div class="row advanced_search_row">
                <div class="col-sm-12">
                   <div class="advanced_search_btn update_profile_btn">
                       <!--<button type="button" class="btn search_btn_new">Update Profile</button>-->
                       <input type="submit"  name="addedit" id="addedit" value="Update Profile" class="btn search_btn_new">
                    </div>
                </div>
            </div>

        </div><!--container-fluid-->
    </div>
</form>
<script>
function editField()
{
    if($('#pcb').prop('checked'))
    {
        $( ".pcb" ).prop( "disabled", false );
    }
    else
    {
        $( ".pcb" ).prop( "disabled", true );
    }


}
function isNumberKey(evt)
{
    var charCode = (evt.which) ? evt.which : event.keyCode;
    //console.log(charCode);
    if (charCode != 46 && charCode != 45 && charCode > 31
            && (charCode < 48 || charCode > 57))
        return false;

    return true;
}
jQuery(document).ready(function(){

    jQuery('#country').change(function(){
        var country_id = jQuery(this).val();
        if(country_id )
        {
            var state_id = jQuery('#state_id').val();
            jQuery('#state').load('/registration/getStateDropDown/'+country_id+'/'+state_id);
        }

    })

    /*
    jQuery('#state').change(function(){
        var state_id = jQuery(this).val();
        if(state_id )
        {
            var city_id = jQuery('#city_id').val();
            jQuery('#city').load('/registration/getCityDropDown/'+state_id+'/'+city_id);
        }

    })
    */
})

jQuery(document).ready(function(){

    jQuery('.html_found').change(function() {
       if (jQuery(this).val().match(/<(\w+)((?:\s+\w+(?:\s*=\s*(?:(?:"[^"]*")|(?:'[^']*')|[^>\s]+))?)*)\s*(\/?)>/)) {
          alert('Invalid html content found');
          jQuery(this).focus();
          jQuery(this).val('');
       }
    })

    jQuery.validator.addMethod("passwordCheck", function(value) {
        return /[A-Z]+/.test(value) && /[a-z]+/.test(value) &&
        /[\d\W]+/.test(value) && /\S{8,}/.test(value);
    });

    jQuery("#myform").validate({
        rules: {
            first_name:"required",
            last_name: "required",
            authorized_person:"required",
            organisation_name: "required",
            //mobile_no: "required",
            country: "required",
            state: "required",
            city: "required",
            address1: "required",
            zip: "required",
            //alert_type: "required",
            //phone: "required",
            password:{
                 required: true,
                 minlength: 8,
                 passwordCheck:true
            },
            confirm_password: {
                required: true,
                equalTo: ".password"
            }
        },
        messages: {
            first_name: "Please enter first name",
            last_name: "Please enter last name",
            organisation_name: "Please enter company name",
            authorized_person: "Please enter person in charge",
            //mobile_no: "Please enter mobile no",
            country: "Please select country",
            state:"Please select state",
            city: "Please enter city",
            address1: "Please enter address",
            zip: "Please enter zip code",
            //alert_type: "Please choose Email alerts",
            password: {
                required: "This field is mandatory",
                minlength: "Password must contain 8 characters with 1 Upper, 1 Lower and 1 Number",
                passwordCheck: "Password must contain 8 characters with 1 Upper, 1 Lower and 1 Number"
            },
            confirm_password: {
                required: "This field is mandatory",
                equalTo: "Password do not match"
            }
        },

    })

    jQuery.validator.addMethod("pwcheck", function(value) {
               return /^[A-Za-z0-9\d=!\-@._*]*$/.test(value) // consists of only these
                   && /[a-z]/.test(value) // has a lowercase letter
                   && /\d/.test(value) // has a digit
            })
})


</script>
