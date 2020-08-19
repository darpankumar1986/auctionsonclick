<script src="<?php echo base_url(); ?>assets/auctiononclick/js/bootstrap.min.js?rand=<?php echo CACHE_RANDOM; ?>"></script>
<style>
.error2
{
	color: #e83c3c;
	font-size: 13px;
	margin-left: 14px;
	display: block;
}
.mobileVerficationCode,.emailVerficationCode,.mobile_resend,.mobile_verified,.email_resend,.email_verified
{
	display: none;
}
</style>
	<div class="container-fluid container_margin">
            <div class="row">
                <div class="col-sm-12">
                   <div class="login_page">
                      <div class="login_inner_page">
                       <ul class="nav nav-tabs">
                           <li><a href="<?php echo base_url(); ?>home/login">Login</a></li>
                           <li class="active"><a data-toggle="tab" href="#Register">Register</a></li>
                       </ul>
				
                       <div class="tab-content">
							
                           <div id="Login" class="tab-pane fade">
							   <form class="custom_form" action="<?php echo base_url(); ?>registration/checklogintype" method="post" id="login_submit_form" autocomplete="off">

										
                                   <div class="floating-form">
                                       <div class="floating-label">
											<input type="hidden" id="loginType" name="login_as" value="owner">
                             			   <input type="text" placeholder=" " class="keysubmit floating-input" name="user_name" id="username" value="<?php if($this->session->userdata('session_found_emailid')) { echo $this->session->userdata('session_found_emailid');} ?>">
                                           <label class="custom_label">Email ID/Mobile No./Username</label>
                                       </div>
                                       <div class="floating-label">
											<input type="hidden" name="track" value="<?php echo $track; ?>">
											<input type="hidden" name="auctionID" value="<?php echo $auctionID; ?>">
											<input type="password" class="keysubmit floating-input" name="password" id="password" placeholder=" ">
                                           <label class="custom_label">Password</label>
                                           <span class="eye_icon"><i class="fa fa-eye"></i></span>
                                       </div>
                                   </div>
                                   <div class="checkbox">
                                       <label><input type="checkbox" name="remember"> Remember me</label>
                                       <label class="forget"><a href="<?php echo base_url()?>registration/forgetpassword" class="forget">forget password</a></label>
                                   </div>
                                   <button type="submit" class="btn btn-default login_btn" name="submit1">Login</button>

								   <div class="success_msg error1" style="padding-left:15px;color: #000 !important;background-color:#f78d8d; clear:both;width: 100%;clear: both; margin-bottom: 20px;">
										<?php echo $this->session->flashdata('error_msg'); ?>
									</div>
							   </form>
                           </div>
                           <div id="Register" class="tab-pane fade in active">
							    <div class="success_msg" style="width: 100%;">
									<?php echo $this->session->flashdata('msg'); ?>
								</div>
								<div class="success_msg" style="color: #000 !important;background-color:#f78d8d;width: 100%">
									<?php echo $this->session->flashdata('error'); ?>
								</div>
								<br style="clear: both;margin-bottom: 10px;"/>
								<form class="custom_form register_form" method="post" action="<?php echo base_url(); ?>registration/save" id="registration" enctype="multipart/form-data" autocomplete="off">
								<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash();?>" />
                                   <div class="floating-form">
                                       <div class="floating-label">                                          
										   <select name="register_as" id="usertype" class="floating-select" onclick="this.setAttribute('value', this.value);" value="">
												<option value="" selected></option>
												<option value="owner">Individual</option>
												<option value="builder" >Organization</option>
											</select>
                                           <span class="highlight"></span>
                                           <label class="custom_label">Registered As</label>
                                           <span class="eye_icon down_icon"><i class="fa fa-chevron-down"></i></span>
										   <span class="field-signupform-usertype help-block-error error2"></span>
                                       </div>
									   <div id="organistion" style="display: none;">
										   <div class="floating-label">
											   <input class="floating-input" name="organisation_name"  class="alphanumeric1" maxlength="50" id="organisation_name" type="text"  value="<?php //echo $cpassword  ?>" placeholder=" "> 
											   <label class="custom_label">Company Name</label>
											   <span  class="field-signupform-organisation_name help-block-error error2"></span>
										   </div>
										   <div class="floating-label">
											   <input  class="floating-input" maxlength="15" name="gst_no"  class="input" id="gst_no"  style="text-transform: uppercase;" type="text"  value="" placeholder=" ">
											   <label class="custom_label">GST Number (Optional)</label>
												<span  class="field-signupform-gst_no help-block-error error2"></span>
										   </div>
										  
										   <div class="floating-label">
											   <input name="authorised_person"  class="floating-input alphanumeric" maxlength="50" id="authorised_person" type="text"  value="" placeholder=" "> 
											   <label class="custom_label">Person In Charge</label>
											   <span  class="field-signupform-authorised_person help-block-error error2"></span>
										   </div>
									   </div>

									   <div id="individual">
										   <div class="floating-label">
											   <input name="first_name" class="alphanumeric floating-input" maxlength="75" id="first_name" type="text"  value="" placeholder=" "> 
											   <label class="custom_label">First Name</label>
											   <span  class="field-signupform-first_name help-block-error error2"></span>
										   </div>

										   <div class="floating-label">
											   <input name="last_name"  class="alphanumeric floating-input" maxlength="75" id="last_name" type="text"  value="" placeholder=" "> 
											   <label class="custom_label">Last Name</label>
											   <span  class="field-signupform-last_name help-block-error error2"></span>
										   </div>
									   </div>

									   <div class="floating-label">
										   <input  class="floating-input floating-float" maxlength="10" name="mobile" id="mobile_number"  class="numericonly" type="text" value="" placeholder=" ">
                                           <label class="custom_label">Mobile Number</label>
                                           <button type="button" class="btn verify_btn mobile_send_code">Send OTP</button>
										   <button type="button" class="btn verify_btn verify_btn3 mobile_resend">Resend in 30</button>
										   <button type="button" class="btn verify_btn mobile_verified" style="background-color: green;">Verified</button>
										   <span  class="field-signupform-mobile_number help-block-error error2"></span>
                                           <p class="error_desc">OTP verification will be sent to this mobile number</p>
										   
                                       </div>
                                       <div class="floating-label mobileVerficationCode">
                                           <input class="floating-input floating-float" type="text" name="mobile_verification_code" id="mobile_verification_code" placeholder=" ">
                                           <label class="custom_label">XXXXXX</label>
                                           <button type="button" class="btn verify_btn verify_btn2 mobile_verification_button">Verify</button>
										   <span  class="field-signupform-mobile_verification_button help-block-error error2"></span>
                                           <p class="error_desc">Enter OTP sent to your mobile number</p>

                                       </div>
                                       <div class="floating-label">
										   <input class="floating-input floating-float" name="email" onblur="checkEmailExist(this.value)" maxlength="100" id="email"  type="email" class="input alphanumericemail" value="<?php echo $email ?>" placeholder=" ">
                                           <label class="custom_label">Email ID</label>
                                           <button type="button" class="btn verify_btn email_send_code">Send Code</button>
										   <button type="button" class="btn verify_btn verify_btn3 email_resend">Resend in 30</button>
										   <button type="button" class="btn verify_btn email_verified" style="background-color: green;">Verified</button>
										   <span  class="field-signupform-email help-block-error error2" ></span>
                                           <p class="error_desc">Your account verification code will be sent to this email ID</p>
										   
                                       </div>

                                       <div class="floating-label emailVerficationCode">
										   <input class="floating-input floating-float" type="text" name="email_verification_code" id="email_verification_code" placeholder=" ">
                                           <label class="custom_label">XXXXXX</label>
                                           <button type="button" class="btn verify_btn verify_btn2 email_verification_button">Verify</button>
										   <span  class="field-signupform-email_verification_button help-block-error error2"></span>
                                           <p class="error_desc">Enter verification code sent to your email ID</p>
                                       </div>
                                       <div class="floating-label">
										   <input class="floating-input input" name="password" maxlength="100" id="pass"  type="password" value="" placeholder=" ">
                                           <label class="custom_label">Password</label>
										   <span  class="field-signupform-password help-block-error error2"></span>
                                       </div>
                                       <div class="floating-label">
										   <input class="floating-input" name="cpassword" id="cpassword" maxlength="100" type="password"  value="" placeholder=" ">
                                           <label class="custom_label">Confirm Password</label>
										   <span  class="field-signupform-cpassword help-block-error error2"></span>
                                       </div>                                       
                                       <div class="floating-label">
										   <input class="floating-input" name="address1" id="address1" maxlength="200" type="text"  value="<?php //echo $cpassword  ?>" placeholder=" ">  
                                           <label class="custom_label">Address</label>
										   <span  class="field-signupform-address1 help-block-error error2"></span>
                                       </div>
                                       <div class="floating-label">
                                           <input class="floating-input" name="city" id="city" type="text" placeholder=" ">
                                           <label class="custom_label">City</label>
										   <span  class="field-signupform-city help-block-error error2"></span>
                                       </div>
                                       <div class="floating-label">
										   <input maxlength="6" name="zipcode"  id="zipcode" class="numericonly input floating-input" type="text" value="" placeholder=" ">
                                           <label class="custom_label">Pincode</label>
										   <span  class="field-signupform-zipcode help-block-error error2"></span>
                                       </div>
                                       <div class="floating-label">
                                           <select class="floating-select" name="country" id="country" onclick="this.setAttribute('value', this.value);" value="">
                                               <option value=""></option>
                                               <!--<option value="1">India</option>
                                               <option value="2">Usa</option>
                                               <option value="3">Uk</option>-->
											   <?php foreach ($countries as $country_record) { ?>
													<option value="<?php echo $country_record->id; ?>" <?php echo ($country_record->id == $prows->country) ? 'selected' : ''; ?>><?php echo $country_record->country_name; ?></option>
												<?php } ?>
                                           </select>
                                           <span class="highlight"></span>
                                           <label class="custom_label">Country</label>
                                           <span class="eye_icon down_icon"><i class="fa fa-chevron-down"></i></span>
										   <span  class="field-signupform-country help-block-error error2"></span>
                                       </div>
                                       <div class="floating-label">
                                           <select class="floating-select" name="state" id="state" onclick="this.setAttribute('value', this.value);" value="">
                                               <option value=""></option>
                                               <?php foreach ($states as $state_record) { ?>
													<option value="<?php echo $state_record->id; ?>" <?php echo ($state_record->id == $prows->state) ? 'selected' : ''; ?>><?php echo $state_record->state_name; ?></option>
												<?php } ?>
                                           </select>
                                           <span class="highlight"></span>
                                           <label class="custom_label">State</label>
                                           <span class="eye_icon down_icon"><i class="fa fa-chevron-down"></i></span>
										   <span  class="field-signupform-state help-block-error error2"></span>
                                       </div>
                                       <div class="floating-label">											 
										   <input class="floating-input floating-float" maxlength="6" name="captcha" id="captcha" type="text" value="" placeholder=" "> 
										  
                                           <label class="custom_label">Enter the code here</label>
										   <div id="captcha_cont" style="float:right;">
												<?php echo $captcha['image']; ?>
											</div>
                                 		   <span  class="field-signupform-captcha help-block-error error2"></span> 
                                       </div>
                                   </div>
                                   <button type="button" name="register" class="btn btn-default login_btn" onclick="send();">Register</button>
                               </form>
                           </div>
                       </div>
                       </div>
                    </div><!--login_page-->
                </div>
            </div><!--row-->

        </div><!--container-fluid-->
<script>
	
(function($) {
  $.fn.inputFilter = function(inputFilter) {
    return this.on("input keydown keyup mousedown mouseup select contextmenu drop", function() {
      if (inputFilter(this.value)) {
        this.oldValue = this.value;
        this.oldSelectionStart = this.selectionStart;
        this.oldSelectionEnd = this.selectionEnd;
      } else if (this.hasOwnProperty("oldValue")) {
        this.value = this.oldValue;
        this.setSelectionRange(this.oldSelectionStart, this.oldSelectionEnd);
      } else {
        this.value = "";
      }
    });
  };
}(jQuery));


$(".alphaNumericTextOnly").inputFilter(function(value) {
  return /^[0-9a-z]*$/i.test(value); });  
	
jQuery('#form16').change(function () {
			var getValue = this.value;
			var ext1 = getValue.split('.');
			var arr = ext1.length;
			var indexValuee = arr-1;
			if(typeof ext1[indexValuee] == "undefined")
			{
				alert('This is not an allowed file type.');
				this.value = '';
			}
			//var ext = this.value.match(/\.(.+)$/)[1];
			switch (ext1[indexValuee]) {
				case 'png':case 'jpg':case 'gif':case 'jpeg':case 'pdf':case 'xls':case 'doc':case 'docx':case 'zip':
				$('#form16').attr('disabled', false);
				break;
				default:
					alert('This is not an allowed file type.');
					this.value = '';
			}
		});
		
		
$('.alphanumeric').bind('keypress', function (event) {
    
    var regex=new RegExp("^[-_ a-zA-Z0-9\b]+$");
    var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
   
    if (!regex.test(key)) {
      //  
      if(!((event.keyCode >= 37 && event.keyCode <= 40))){
        event.preventDefault();
        return false;
    }
   }
    
});
$('.alphanumeric1').bind('keypress', function (event) {
    
    var regex=new RegExp("^[-_ .a-zA-Z0-9\b]+$");
    var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
   
    if (!regex.test(key)) {
      //  
      if(!((event.keyCode >= 37 && event.keyCode <= 40))){
        event.preventDefault();
        return false;
    }
   }
    
});


$('.alphanumericemail').bind('keypress', function (event) {
   
    var regex=new RegExp("^[@-_ .a-zA-Z0-9\b]+$");
    var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
    var ar = new Array(37, 38, 39, 40);
   if (!regex.test(key)||key=='^'||key=='|') {
      if(!((event.keyCode >= 37 && event.keyCode <= 40))){
        event.preventDefault();
        return false;
    }
     
    }
    });
    $('#pan_number, .ifsc_code').bind('keypress', function (event) {
    
    var regex=new RegExp("^[A-Za-z0-9\b]+$");
    var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
    if (!regex.test(key)){
      //if(!((event.keyCode >= 37 && event.keyCode <= 40))){
          
        event.preventDefault();
        return false;
    //}
   }
    
});



 $(".numericonly").keydown(function (e) {	
 		// Allow: backspace, delete, tab, escape, enter and .	
 		if ($.inArray(e.keyCode, [46, 8, 9, 27, 13]) !== -1 ||	
 		// Allow: Ctrl+A, Command+A	
 		(e.keyCode == 65 && ( e.ctrlKey === true || e.metaKey === true ) ) ||	
 		// Allow: home, end, left, right, down, up	
 		(e.keyCode >= 35 && e.keyCode <= 40)) {	
 		// let it happen, don't do anything	
 		return;	
 		}	
 		// Ensure that it is a number and stop the keypress	
 		if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {	
 		e.preventDefault();	
 		}	
});

            function isNumberKey(evt)
            {
                var charCode = (evt.which) ? evt.which : event.keyCode;
                console.log(charCode);
                if (charCode != 46 && charCode != 45 && charCode > 31
                        && (charCode < 48 || charCode > 57))
                    return false;

                return true;
            }
            jQuery('#usertype').change(function ($) {


                var user_id = jQuery(this).val();
                //alert(user_id);
                 if (user_id != '') {
                    if (user_id == 'builder') {
                        jQuery("#organistion").css('display', 'block');
                        jQuery(".gst_mand").css('display', 'inline-block');
                        jQuery("#individual").css('display', 'none');
                    } else {
                        jQuery("#organistion").css('display', 'none');
                        jQuery(".gst_mand").css('display', 'none');
                        jQuery("#individual").css('display', 'block');
                    }
                }

            });

            jQuery('#form_16id').click(function () {
                if (jQuery("#form_16id").is(':checked')) {
                    jQuery("#pan-no_data").hide();
                    jQuery("#form_16-data").show();
                }
            });

           jQuery('#gstin_yes').click(function () {
                if (jQuery(this).is(':checked')) {
                    jQuery("#gst_no_cont").show();
                    jQuery("#b2c_cont").hide();
                    
                }
            });
            
             jQuery('#gstin_no').click(function () {
                if ($(this).is(':checked')) {
                    $("#b2c_cont").show();
                    $("#gst_no_cont").hide();
                }
            });

            jQuery('#pan_numberid').click(function () {
                if ($("#pan_numberid").is(':checked')) {
                    $("#pan-no_data").show();
                    $("#form_16-data").hide();
                }
            });
            jQuery('#country').change(function () {
                var country_id = jQuery(this).val();
                if (country_id)
                {
                    var state_id = jQuery('#state_id').val();
                    jQuery('#state').load('<?php echo base_url(); ?>registration/getStateDropDown/' + country_id + '/' + state_id);
                }

            });

            /*jQuery('#state').change(function () {
                var state_id = jQuery(this).val();
                if (state_id)
                {
                    var city_id = jQuery('#city_id').val();
                    jQuery('#city').load('<?php echo base_url(); ?>registration/getCityDropDown/' + state_id + '/' + city_id);
                }

            });*/

            function checkEmailExist(email)
            {
                if (email)
                {
	               jQuery.ajax({
                        url: '<?php echo base_url(); ?>common/checkemailexist',
                        type: 'POST',
                        data: 'email=' + email,
                        success: function (data) {
                            //called when successful
                            if (data == '0')
                            {
                                 jQuery('.field-signupform-email').html('');
                            }
                            else
                            {
                                jQuery('#email').val('');
                                jQuery('.field-signupform-email').html('Email id already exist.');
                            }

                        }
                    });

                }
                else
                {
                    return false;
                }

            }
			var isMobileVerified = false;
			var myVar = null;
			var isEmailVerified = false;
			var myVarEmail = null;
            jQuery(document).ready(function(){
				jQuery("#submitbutton").click(function(){
					jQuery(".success_msg").html('');
				});
				jQuery(".mobile_send_code,.mobile_resend").click(function(){
					var mobile = $("#mobile_number").val();
					if(mobile == '')
					{
						$(".field-signupform-mobile_number").html('Please enter mobile no.');
					}
					else if(mobile.length != 10)
					{
						$(".field-signupform-mobile_number").html('Please enter valid mobile no.');
					}
					else
					{
						jQuery.ajax({
							url: '<?php echo base_url(); ?>registration/sendMobileCode',
							type: 'POST',
							data: 'mobile=' + mobile,
							success: function (data) {
							   

							}
						});
						
						$(".mobile_resend").attr('disabled','disabled');
						$(".mobile_send_code").hide();
						$(".mobile_resend").attr('data-second',30);
						$(".mobile_resend").show();
						$(".mobileVerficationCode").show();
						$(".mobile_resend").html('Resend in 30');
						$('#mobile_number').prop('readonly', true);
						myVar = setInterval(function()
							{ 
								if(isMobileVerified == false)
								{
									var dataSecond = $(".mobile_resend").attr('data-second'); 
									dataSecond -= 1; 
									$(".mobile_resend").html('Resend in '+dataSecond);
									$(".mobile_resend").attr('data-second',dataSecond);
									if(dataSecond == 0){ 
										$(".mobile_resend").html('Resend OTP');
										$(".mobile_resend").attr('disabled',false);
										clearInterval(myVar);
									} 
								}
							}, 1000);
					}
				});

				jQuery(".mobile_verification_button").click(function(){
					var mobile_verification_code = $("#mobile_verification_code").val();
					var mobile = $("#mobile_number").val();
					if(mobile_verification_code == '')
					{
						$(".field-signupform-mobile_verification_button").html('Please enter OTP');
					}
					else if(mobile_verification_code.length != 6)
					{
						$(".field-signupform-mobile_verification_button").html('Please enter valid OTP');
					}
					else
					{
						jQuery.ajax({
							url: '<?php echo base_url(); ?>registration/verMobileCode',
							type: 'POST',
							data: 'mobile_verification_code='+mobile_verification_code+'&mobile='+mobile,
							success: function (data) {
							   if(data=='success')
							   {
								   $(".field-signupform-mobile_number").html('');
									$(".mobileVerficationCode").hide();
									$(".mobile_send_code").hide();
									$(".mobile_resend").hide();
									$(".mobile_verified").show();
									
									isMobileVerified = true;
							   }
							   else
							   {
									$(".field-signupform-mobile_verification_button").html('Please enter valid OTP');
							   }

							}
						});
					}
					
				});

				jQuery(".email_send_code,.email_resend").click(function(){
					var email = $("#email").val();
					var first_name = $("#first_name").val();
					var authorised_person = $("#authorised_person").val();
					if(email == '')
					{
						$(".field-signupform-email").html('Please enter email id.');
					}
					else if(email.length < 7)
					{
						$(".field-signupform-email").html('Please enter valid email id.');
					}
					else
					{
						jQuery.ajax({
							url: '<?php echo base_url(); ?>registration/sendEmailCode',
							type: 'POST',
							data: 'email=' + email + '&first_name=' +first_name+ '&authorised_person=' +authorised_person,
							success: function (data) {
							   

							}
						});
						
						$(".email_resend").attr('disabled','disabled');
						$(".email_send_code").hide();
						$(".email_resend").attr('data-second',30);
						$(".email_resend").show();
						$(".emailVerficationCode").show();
						$(".email_resend").html('Resend in 30');
						$('#email').prop('readonly', true);
						myVarEmail = setInterval(function()
							{ 
								if(isEmailVerified == false)
								{
									var dataSecond = $(".email_resend").attr('data-second'); 
									dataSecond -= 1; 
									$(".email_resend").html('Resend in '+dataSecond);
									$(".email_resend").attr('data-second',dataSecond);
									if(dataSecond == 0){ 
										$(".email_resend").html('Resend Code');
										$(".email_resend").attr('disabled',false);
										clearInterval(myVarEmail);
									} 
								}
							}, 1000);
					}
				});

				jQuery(".email_verification_button").click(function(){
					var email_verification_code = $("#email_verification_code").val();
					var email = $("#email").val();
					if(email_verification_code == '')
					{
						$(".field-signupform-email_verification_button").html('Please enter OTP');
					}
					else if(email_verification_code.length != 6)
					{
						$(".field-signupform-email_verification_button").html('Please enter valid OTP');
					}
					else
					{
						jQuery.ajax({
							url: '<?php echo base_url(); ?>registration/verEmailCode',
							type: 'POST',
							data: 'email_verification_code='+email_verification_code+'&email='+email,
							success: function (data) {
							   if(data=='success')
							   {
								    $(".field-signupform-email").html('');
									$(".emailVerficationCode").hide();
									$(".email_send_code").hide();
									$(".email_resend").hide();
									$(".email_verified").show();
									
									isEmailVerified = true;
							   }
							   else
							   {
									$(".field-signupform-email_verification_button").html('Please enter valid OTP');
							   }

							}
						});
					}
					
				});

				
			});
        </script>
		<script src="<?php echo base_url(); ?>assets/auctiononclick/js/bootstrap.min.js?rand=<?php echo CACHE_RANDOM; ?>"></script>