<style>
@media screen and (max-width: 530px) {
.body_main{width:97%; margin:0 auto !important; float:none;}
.login_btn1 {    width: 90% !important;}
.half-2{background:#fff;}
.box-content-details select, .box-content-details input{border-top:none;border-left:none;border-right:none;font-size:14px;border-radius:0px;}
.box-content-details select:focus, .box-content-details input:focus{border-top:none;border-left:none;border-right:none;border-bottom: 1px solid #1776ae;}
</style>

<link href="<?= base_url(); ?>assets/front_view/css/custom.css" rel="stylesheet" type="text/css">
<link href="<?= base_url(); ?>bankeauc/css/responsive.css" rel="stylesheet" type="text/css">
<script src="<?= base_url(); ?>js/validation.js" type="text/javascript"></script>
<!--<script src="<?= base_url(); ?>js/common.js" type="text/javascript"></script>-->
<script type="text/javascript">
	$(document).ready(function () {
		$("select").change(function () {
			$(this).find("option:selected").each(function () {
				if ($(this).attr("value") == "banker") {
					$(".box").not(".banker").hide();
					$(".banker").show();
				}
				else {
					$(".box").hide();
				}
			});
		}).change();
	});
</script>

        <!--============================header==================================-->
    <section id="body_wrapper" class="registration-page">
		<div class="body_main no_margn">
            <div class="box-heading">
               New User Registration 
               <div style="float:right; padding-right:10px;" class="reg_manadatory"><span style="color:red">*</span> Marked fields are Mandatory	</div>
            </div>
            <div class="success_msg" style="color: green !important;font-weight:bold;font-size: 16px;">
				<?php echo $this->session->flashdata('msg'); ?>
			</div>
            <div class="success_msg" style="color: #000 !important;background-color:#f78d8d;">
				<?php echo $this->session->flashdata('error'); ?>
			</div>
            <form method="post" action="/registration/save?bi=<?php echo $bankIdbyshortname; ?>" id="registration" enctype="multipart/form-data" autocomplete="off">
            <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash();?>" />
            <div class="box-content-details">
				
				<div class="full">
					<div class="half-2">
						<div class="row">
							<div class="lft_heading">Register As  <span class="red"> *</span></div>
							<div class="rgt_detail">
								<select name="register_as" id="usertype" title="Login As">																		
									<option value="owner" selected>Individual</option>
									<option value="builder" >Organization</option>
								</select>
								<div class="tooltips">
									<img class="tooltip_icon" src="/images/help.png">
									<span>Option to select user type. </span>
								</div>
								 <span class="field-signupform-usertype help-block-error error2"></span>
								 
							</div>
						</div>
                    </div>
                    
					<div class="half-2">
						<div class="row">
							<!--<div class="lft_heading">Email ID (Login ID)<span class="red"> *</span></div>-->
							<div class="rgt_detail">
								<input name="email" onblur="checkEmailExist(this.value)" maxlength="100" id="email"  type="email" class="input alphanumericemail" value="<?php echo $email ?>" Placeholder="Email ID*">
							   
								 <div class="tooltips">
								<img class="tooltip_icon" src="/images/help.png">
								<span>Valid Email ID is required for registration.Your email ID will be used for further communication. </span>
								</div>
								<span class="help-block-error" id="message" style="color:red"><?php echo $this->session->flashdata('msg1'); ?></span>
								 <span  class="field-signupform-email help-block-error error2" ></span>
							</div>
						</div>
					</div>
					<div class="half-2">
						<div class="row">
							<!--<div class="lft_heading">Confirm Email ID <span class="red"> *</span></div>-->
							<div class="rgt_detail">
								<input name="confirmemail" onblur="checkEmailExist(this.value)" maxlength="100" id="confirmemail" type="email" class="input alphanumericemail" value="<?php echo $email ?>" Placeholder="Confirm Email ID*">
							  <div class="tooltips">
								<img class="tooltip_icon" src="/images/help.png">
								<span>Enter same email ID for verification. </span>
								</div>
								<span class="help-block-error" id="message"><?php echo $this->session->flashdata('msg1'); ?></span>
								<span  class="field-signupform-confirmemail help-block-error error2"></span>
							</div>
						</div>
					</div>
					<div class="half-2">
						<div class="row">
							<!--<div class="lft_heading">Password <span class="red"> *</span></div>-->
							<div class="rgt_detail">
								<input name="password" maxlength="100" id="pass"  type="password" class="input" value="" Placeholder="Password*">
								<div class="tooltips">
								<img class="tooltip_icon" src="/images/help.png">
								<span>Password should contain minimum 8 digits/letters, 1 Uppercase Letter with Special character.(Do not use $,<,>,&,#) ). </span>
								</div>
								<span  class="field-signupform-password help-block-error error2"></span>

							</div>
						</div>
					</div>
					<div class="half-2">
						<div class="row">
							<!--<div class="lft_heading">Confirm Password <span class="red"> *</span></div>-->
							<div class="rgt_detail">
								<input name="cpassword" id="cpassword" maxlength="100" type="password"  value="" Placeholder="Confirm Password*">
							   
								 <div class="tooltips">
								  <img class="tooltip_icon" src="/images/help.png">
								  <span>Retype your password to Verify. </span>
								</div>
								<span  class="field-signupform-cpassword help-block-error error2"></span>
							</div>
						</div>
                    </div>
                    <hr>
                    <div id="individual">
						<div class="half-2">
							<div class="row individual">
								<!--<div class="lft_heading">First Name <span class="red"> *</span></div>-->
								<div class="rgt_detail">
									<input name="first_name" class="alphanumeric" maxlength="75" id="first_name" type="text"  value="<?php //echo $cpassword  ?>" Placeholder="First Name*">   
									
								 <div class="tooltips">
								  <img class="tooltip_icon" src="/images/help.png">
								  <span>First name of the individual person. </span>
								</div>
								<span  class="field-signupform-first_name help-block-error error2"></span>
								</div>
							</div>
						</div>
						<div class="half-2">
							<div class="row individual">
								<!--<div class="lft_heading">Last Name <span class="red"> *</span></div>-->
								<div class="rgt_detail">
									<input name="last_name"  class="alphanumeric" maxlength="75" id="last_name" type="text"  value="<?php //echo $cpassword  ?>" Placeholder="Last Name*">    
								   
								 <div class="tooltips">
									<img class="tooltip_icon" src="/images/help.png">
									 <span>Last name of the individual person. </span>
								</div>
								 <span  class="field-signupform-last_name help-block-error error2"></span>
								</div>
							</div>
						</div>
						<div class="half-2">
							<div class="row individual">
								<!--<div class="lft_heading">Father's/Husband's Name <span class="red"> *</span></div>-->
								<div class="rgt_detail">
									<input name="fathers_husband_name"  class="alphanumeric" maxlength="100" id="father_name" type="text"  value="<?php //echo $cpassword  ?>" Placeholder="Father's/Husband's Name*">   
								   
									<div class="tooltips">
									<img class="tooltip_icon" src="/images/help.png">
									<span>Father's name or husband's name of the registered individual person. </span>
									</div>
									 <span  class="field-signupform-father_name help-block-error error2"></span>
								</div>
							</div>
						</div>
                    </div>   
                    <div id="organistion" style="display: none;">
						<div class="half-2">
							<div class="row individual">
								<!--<div class="lft_heading">Organization Name <span class="red"> *</span></div>-->
								<div class="rgt_detail">
									<input name="organisation_name"  class="alphanumeric1" maxlength="50" id="organisation_name" type="text"  value="<?php //echo $cpassword  ?>" Placeholder="Organization Name*">   
									
									<div class="tooltips">
									<img class="tooltip_icon" src="/images/help.png">
									<span>Name of the organization on behalf of which bidder can participate in auction . </span>
									</div>
									<span  class="field-signupform-organisation_name help-block-error error2"></span>
								</div>
							</div>
						</div>
						<div class="half-2">
							<div class="row">
							<!--	<div class="lft_heading">Authorized Person <span class="red"> *</span></div>-->
								<div class="rgt_detail">
									<input name="authorised_person"  class="alphanumeric" maxlength="50" id="authorised_person" type="text"  value="<?php //echo $cpassword  ?>" Placeholder="Authorized Person*">   
								   
									<div class="tooltips">
									<img class="tooltip_icon" src="/images/help.png">
									<span>Name of the authorized person on behalf of organization. </span>
									</div>
									 <span  class="field-signupform-authorised_person help-block-error error2"></span>
								</div>
							</div>
						</div>
						<div class="half-2">
							<div class="row">
								<!--<div class="lft_heading">Designation <span class="red"> *</span></div>-->
								<div class="rgt_detail">
									<input name="designation"  class="alphanumeric" maxlength="50" id="designation" type="text"  value="<?php //echo $cpassword  ?>" Placeholder="Designation*">   
									 <div class="tooltips">
									<img class="tooltip_icon" src="/images/help.png">
									<span>Designation name of the authorized person mentioned above. </span>
									</div>
									<span  class="field-signupform-designation help-block-error error2"></span>
								</div>
							</div>
						</div>
                    </div>       
					<div class="half-2">
						<div class="row">
							<!--<div class="lft_heading">Address 1 <span class="red"> *</span></div>-->
							<div class="rgt_detail">
								<input name="address1" id="address1" maxlength="200" type="text"  value="<?php //echo $cpassword  ?>" Placeholder="Address 1*">   
								<div class="tooltips">
									<img class="tooltip_icon" src="/images/help.png">
									<span>Address  details can be used for communication in case of any emergency. </span>
								</div>
								 <span  class="field-signupform-address1 help-block-error error2"></span>
							</div>
						</div>
					</div>
					<div class="half-2">
						<div class="row">
							<!--<div class="lft_heading">Address 2</div>-->
							<div class="rgt_detail">
								<input name="address2" maxlength="100" id="address2" type="text"  value="<?php //echo $cpassword  ?>" Placeholder="Address 2">   
								<span  class="field-signupform-address2 help-block-error error2"></span>
								
							</div>
						</div>
					</div>
					<div class="half-2">
						<div class="row">
							<!--<div class="lft_heading">Country <span class="red"> *</span></div>-->
							<div class="rgt_detail">
								<select name="country" id="country" class="select">
									<option value="">Select Country</option>
									<?php foreach ($countries as $country_record) { ?>
										<option value="<?php echo $country_record->id; ?>" <?php echo ($country_record->id == $prows->country) ? 'selected' : ''; ?>><?php echo $country_record->country_name; ?></option>
									<?php } ?>
								</select>
								<div class="tooltips">
									<img class="tooltip_icon" src="/images/help.png">
									<span>To submit  country name of the bidder. </span>
								</div>
								 <span  class="field-signupform-country help-block-error error2"></span>
							</div>
						</div>
					</div>
					<div class="half-2">
						<div class="row">
							<!--<div class="lft_heading">State <span class="red"> *</span></div>-->
							<div class="rgt_detail">
								<select  name="state" id="state" class="select">
									<option value="">Select State</option>
									<?php foreach ($states as $state_record) { ?>
										<option value="<?php echo $state_record->id; ?>" <?php echo ($state_record->id == $prows->state) ? 'selected' : ''; ?>><?php echo $state_record->state_name; ?></option>
									<?php } ?>
								</select>
								 <div class="tooltips">
									<img class="tooltip_icon" src="/images/help.png">
									<span>To submit  state name of the bidder. </span>
								</div>
								<span  class="field-signupform-state help-block-error error2"></span>
							</div>
						</div>
					</div>
					<div class="half-2">
						<div class="row">
							<!--<div class="lft_heading">City <span class="red"> *</span></div>-->
							<div class="rgt_detail">
								<select name="city" id="city" class="select">
									<option value="" selected>Select City</option>
								<?php foreach ($cities as $city_record) { ?>
										<option value="<?php echo $city_record->id; ?>" <?php echo ($city_record->id == $prows->city) ? 'selected' : ''; ?>><?php echo $city_record->city_name; ?></option>
									<?php } ?>
								</select>
								 <div class="tooltips">
									<img class="tooltip_icon" src="/images/help.png">
									<span>To submit  city  name of the bidder. </span>
								</div>
								<span  class="field-signupform-city help-block-error error2"></span>
							</div>
						</div>
					</div>
					<div class="half-2">
						<div class="row">
							<!--<div class="lft_heading">Pin/Zip <span class="red"> *</span></div>-->
							<div class="rgt_detail">
								<input maxlength="6" name="zipcode"  id="zipcode" class="numericonly input" type="text" value="" Placeholder="Pincode*">
								 <div class="tooltips">
									<img class="tooltip_icon" src="/images/help.png">
									<span>Pin details must match  the  nearest  address  submitted earlier. </span>
								</div>
								<span  class="field-signupform-zipcode help-block-error error2"></span>
							</div>
						</div>
					</div>
					<div class="half-2">
						<div class="row">
							<div class="lft_heading">PAN/FORM-16 Details <span class="red"> *</span></div>
							<div class="rgt_detail">
								<table width="250" style="float:left;">
									<tr>
										<td><label>
												<input  style="width:30px; float:left;" class="showformpan regi_radio" id="pan_numberid" checked name="pan_form-16" type="radio"  value="pan_no">
												<span class="gegi_radio_txt" style="width:50px; float:left; margin-top:-0;">  Pan No.</span></label></td>

										<td><label>
												<input  style="width:30px; float:left;" class="showformpan regi_radio alphanumeric" id="form_16id" name="pan_form-16" type="radio"  value="form-16">
												<span style="width:80px; float:left; margin-top:-0;"> Form-16</span></label></td>
									</tr>
								</table>
								<span  class="help-block-error error2"></span>
								
							</div>
						</div>
					</div>
					<div class="half-2">
						<div class="row"  id="pan-no_data">
							<div class="lft_heading">PAN No. <span class="red"> *</span></div>
							<div class="rgt_detail">
								<input  maxlength="10" name="pan_number" class="input" id="pan_number" style="text-transform: uppercase;"  type="text" value="">
								 <div class="tooltips">
									<img class="tooltip_icon" src="/images/help.png">
									<span>PAN must contain only alphanumeric value.It cannot be greater than 10 digits. </span>
								</div>
								<span  class="field-signupform-pan_number help-block-error error2"></span>
							</div></div>
					</div>
					<div class="half-2">
						<div class="row"  id="form_16-data" style="display:none;">
							<div class="lft_heading">Form 16 <span class="red"> *</span></div>
							<div class="rgt_detail">
								<input type="file" name="form16" id="form16">
								 <div class="tooltips">
									<img class="tooltip_icon" src="/images/help.png">
									<span>Option to upload Form16 in docx,doc,jpg,png,jpeg format only. </span>
								</div>
								 <span  class="field-signupform-form16 help-block-error error2"></span>
						</div></div>
					</div>
					
					<div class="half-2">
					   <div class="row">
							<div class="lft_heading">GST No. <span class="red gst_mand" style="display: none;"> *</span></div>
							<div class="rgt_detail">
								<input  maxlength="15" name="gst_no"  class="input" id="gst_no"  style="text-transform: uppercase;" type="text"  value="">	
								 <div class="tooltips">
									<img class="tooltip_icon" src="/images/help.png">
									<span>GST number must contain only alphanumeric value.It cannot be greater than 15 digits. </span>
								</div>							
								<span  class="field-signupform-gst_no help-block-error error2"></span>
							</div>
						</div>
					</div>
				   <div class="half-2">
						<div class="row">
							<!--<div class="lft_heading">Bank Name <span class="red"> *</span></div>-->
							<div class="rgt_detail">
								<select name="bank_id" id="bank_id" class="select">
									<option value="" selected>Select Bank Name</option>
								<?php foreach ($bank as $bank_record) { ?>
										<option value="<?php echo $bank_record->bank_id; ?>" <?php echo ($bank_record->bank_id == $prows->city) ? 'selected' : ''; ?>><?php echo $bank_record->bank_name; ?></option>
									<?php } ?>
								</select>
								<div class="tooltips">
									<img class="tooltip_icon" src="/images/help.png">
									<span>To submit Bank Name of the bidder. </span>
								</div>
								<span  class="field-signupform-bank_name help-block-error error2"></span>
							</div>
						</div>
					</div>
					<div class="half-2">
						<div class="row">
							<!--<div class="lft_heading">Account Holder Name <span class="red"> *</span></div>-->
							<div class="rgt_detail">
								<input name="account_holder_name" id="account_holder_name" class="" type="text"value="" placeholder="Account Holder Name*">
								<div class="tooltips">
									<img class="tooltip_icon" src="/images/help.png">
									<span>Please Enter Account Holder Name. </span>
								</div>
								<span  class="field-signupform-account_holder_name help-block-error error2"></span>
							</div>
						</div>
					</div>
					<div class="half-2">
						<div class="row">
							<!--<div class="lft_heading">Type of Account <span class="red"> *</span></div>-->
							<div class="rgt_detail">
								<input name="account_type" id="account_type" class="" type="text"value="" placeholder="Type of Account*">
								<div class="tooltips">
									<img class="tooltip_icon" src="/images/help.png">
									<span>Please Enter Type of Account (like saving/current) </span>
								</div>
								<span  class="field-signupform-account_type help-block-error error2"></span>
							</div>
						</div>
					</div>
					<div class="half-2">
						<div class="row">
							<!--<div class="lft_heading">Account Number <span class="red"> *</span></div>-->
							<div class="rgt_detail">
								<input name="account_number" id="account_number" class="numericonly" type="text"value="" placeholder="Account Number*">
								<div class="tooltips">
									<img class="tooltip_icon" src="/images/help.png">
									<span>Please Enter Account Number. </span>
								</div>
								<span  class="field-signupform-account_number help-block-error error2"></span>
							</div>
						</div>
					</div>
					<div class="half-2">
						<div class="row">
							<!--<div class="lft_heading">IFSC Code <span class="red"> *</span></div>-->
							<div class="rgt_detail">
								<input name="ifsc_code" id="ifsc_code" class="" type="text"value="" placeholder="IFSC Code*">
								<div class="tooltips">
									<img class="tooltip_icon" src="/images/help.png">
									<span>Please Enter IFSC Code. </span>
								</div>
								<span  class="field-signupform-ifsc_code help-block-error error2"></span>
							</div>
						</div>
					</div>
					
                   <div class="half-2">
					   <div class="row">
							<!--<div class="lft_heading">Phone Number </div>-->
							<div class="rgt_detail">
								<input  maxlength="15" name="phone_number"  class="numericonly" id="phone_number"  type="text"  value="" Placeholder="Phone Number">
								<div class="tooltips">
									<img class="tooltip_icon" src="/images/help.png">
									<span>This phone number can be used for further communication.It. </span>
								</div>
								<span  class="field-signupform-phone_no help-block-error error2"></span>
							</div>
						</div>
					</div>
					<div class="half-2">
						<div class="row">
							<!--<div class="lft_heading">Mobile Number  <span class="red"> *</span></div>-->
							<div class="rgt_detail">

								<input  maxlength="10" name="mobile" id="mobile_number"  class="numericonly" type="text" value="" Placeholder="Mobile Number*">
								  <div class="tooltips">
									<img class="tooltip_icon" src="/images/help.png">
									<span>This mobile number can be used for further communication.It must contain exact 10 numeric value. </span>
								</div>
								<span  class="field-signupform-mobile_number help-block-error error2"></span>
							</div>
						</div>
					</div>
					<div class="half-2">
						<div class="row">
							<!--<div class="lft_heading">Fax Number </div>-->
							<div class="rgt_detail">
								<input  maxlength="15" name="fax_number" id="fax_number" class="numericonly" type="text"value="" Placeholder="Fax Number">
								<div class="tooltips">
									<img class="tooltip_icon" src="/images/help.png">
									<span>Please Enter Fax Number. </span>
								</div>
								<span  class="field-signupform-fax_number help-block-error error2"></span>
							</div>
						</div>
					</div>
					<?php /* ?>
					<div class="half-2">
						<div class="row">
							<div class="lft_heading">Place of Supply <span class="red"> *</span></div>
							<div class="rgt_detail">
								<select  name="supply_place" id="supply_place" class="select">
									<option value="">---Select---</option>
									<?php foreach ($states as $state_record) { ?>
										<option value="<?php echo $state_record->id; ?>" <?php echo ($state_record->id == $prows->supply_place) ? 'selected' : ''; ?>><?php echo $state_record->state_name; ?></option>
									<?php } ?>
								</select>
								 <div class="tooltips">
									<img class="tooltip_icon" src="/images/help.png">
									<span>To submit  place name of the supply. </span>
								</div>
								<span  class="field-signupform-supply-place help-block-error error2"></span>
							</div>
						</div>
					</div>
					<div class="half-2">
						<div class="row">
							<div class="lft_heading">Address of Delivery <span class="red"> *</span></div>
							<div class="rgt_detail">
								<input name="delivery_address" id="delivery_address" class="html_found" maxlength="200" type="text"  value="" style="width: 450px;">   
								<div class="tooltips">
									<img class="tooltip_icon" src="/images/help.png">
									<span>Delivery Address can be used for communication in case of any emergency. </span>
								</div>
								 <span  class="field-signupform-delivery_address help-block-error error2"></span>
							</div>
						</div>
					</div>
					<div class="half-2">
						<div class="row">
							<div class="lft_heading">GSTIN Available? <span class="red"> *</span></div>
							<div class="rgt_detail">
								<table width="250" style="float:left;">
									<tr>
										<td><label>
												<input  style="width:30px; float:left;" class="showformpan regi_radio html_found" id="gstin_yes" checked name="gstin" type="radio"  value="1">
												<span class="gegi_radio_txt" style="width:50px; float:left; margin-top:-0;">  Yes</span></label></td>

										<td><label>
												<input  style="width:30px; float:left;" class="showformpan regi_radio alphanumeric html_found" id="gstin_no" name="gstin" type="radio"  value="0">
												<span style="width:80px; float:left; margin-top:-0;"> No</span>
											</label>
										</td>
									</tr>
								</table>
								<span  class="help-block-error error2"></span>
								
							</div>
						</div>
					</div>
					<div class="half-2">
						<div class="row">
							<div class="lft_heading">GSTIN <span class="red"> *</span></div>
							<div class="rgt_detail" id="gst_no_cont">
								<input  maxlength="15" name="gst_no" class="input html_found" id="gst_no" type="text" value="">
								 <div class="tooltips">
									<img class="tooltip_icon" src="/images/help.png">
									<span>GSTIN must contain only alphanumeric value.It cannot be greater than 15 digits. </span>
								</div>
								<span  class="field-signupform-gst_no help-block-error error2"></span>
							</div>
							<div class="rgt_detail" id="b2c_cont" style="display:none;">Not Available</div>
						</div>
					</div>
					<div class="half-2">
						<div class="row">
							<div class="lft_heading">Registration Fee </div>
							<div class="rgt_detail"><?php echo REGISTRATION_FEE;?> (INR)
							</div>
						</div>
					</div>
					<div class="half-2">
						<div class="row">
							<div class="lft_heading">Rate of Tax</div>
							<div class="rgt_detail"><?php echo TAX_RATE;?> %
							</div>
						</div>
					</div>
					<div class="half-2">
						<div class="row">
							<div class="lft_heading">Amount of Tax Charged</div>
							<div class="rgt_detail"><?php echo TAX_AMOUNT;?> (INR)
							</div>
						</div>
					</div>
					<div class="half-2">
						<div class="row">
							<div class="lft_heading">Total Payment to be made</div>
							<div class="rgt_detail"><?php echo REGISTRATION_AMOUNT;?> (INR)
							</div>
						</div>
					</div>
					<?php */ ?>
					<div class="half-2">
						 <div class="row captcha">
							<!--<div class="lft_heading">Validation code </div>-->
							<div class="rgt_detail">
								<div id="captcha_cont">
									<?php echo $captcha['image']; ?>
								</div>
								<br/>
								<!--<strong>Enter the code above here </strong> <br/>-->
								<input  maxlength="6" name="captcha" id="captcha" type="text" value="" placeholder="Enter the code above here"> 
								<span  class="field-signupform-captcha help-block-error error2"></span>                             
							</div>
						</div>
					</div>
                    <div class="full">
                        <p class="tnc">
							<input name="" type="checkbox" id="signupform-confirmbidder" value="" class="checkbox no-flt"> I agree that: I have read and accepted the <a href="#" style="color:#00F; text-decoration:none;" target="_blank">User Agreement and Privacy Policy.</a><br>
                            I may receive communications from Development Authority.
                        </p> 
                        <span id="check_message" style="color:#f00;font-size: 13px; font-family:Arial; width:100%; text-align:center; float:left;"></span>
                    </div>
                    <?php /* ?>
                    <div class="row" style="text-align:center;">
                        <input type="button"  id="submitbutton" value="Register" name="register" onclick="send();" class="button_grey">
                    </div>
                    <?php */ ?>
                    <div class="full">
						  <div class="half-2 T_B_M_10">
							 <div class="row ">
								<div class="lft_heading">&nbsp;</div>
								<div class="rgt_detail"><input type="button" class="login_btn1" id="submitbutton" value="REGISTER" name="register" onclick="send();" class="button_grey"></div>
							 </div>
						  </div>
					   </div>
				</div>
                </div>
            </form>
        </div>
    </div>
    </section>
<style>
	.captcha img{width: 150px !important;}
	/*.login_btn1{background: #f24b1e !important;
    padding: 10px 15px !important;
    color: #ffffff !important; width:auto !important;}*/
    a, input, select, textarea {    vertical-align: baseline;}
    
</style>
        <script>
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
    $('#pan_number').bind('keypress', function (event) {
    
    var regex=new RegExp("^[A-Za-z0-9\b]+$");
    var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
    if (!regex.test(key)||key=='%'|| key=='&'){
      if(!((event.keyCode >= 37 && event.keyCode <= 40))){
          
        event.preventDefault();
        return false;
    }
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
           /* jQuery('#signupform-confirmbidder').click(function (event) {
                if ($("#signupform-confirmbidder").is(':checked')) {
                    // event.preventDefault();
                    //  $("#check_message").text("");
                    $('#submitbutton').removeAttr("disabled");

                } else {
                 
                    $('#submitbutton').removeAttr("disabled");
                   
                }
            });*/

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
                    jQuery('#state').load('/registration/getStateDropDown/' + country_id + '/' + state_id);
                }

            });

            jQuery('#state').change(function () {
                var state_id = jQuery(this).val();
                if (state_id)
                {
                    var city_id = jQuery('#city_id').val();
                    jQuery('#city').load('/registration/getCityDropDown/' + state_id + '/' + city_id);
                }

            });

            function checkEmailExist(email)
            {
                if (email)
                {
                    jQuery.ajax({
                        url: '/common/checkemailexist',
                        type: 'POST',
                        data: 'email=' + email,
                        success: function (data) {
                            //called when successful
                            if (data == '0')
                            {
                                //jQuery('#user_id').val(email);
                                //jQuery('#message').html('Ok');
                                jQuery('#message').html('');
                            }
                            else
                            {
                                jQuery('#email').val('');
                                jQuery('#message').html('Email ID already exist.');
                            }

                        }
                    });

                }
                else
                {
                    return false;
                }

            }
            jQuery(document).ready(function(){
				jQuery("#submitbutton").click(function(){
					jQuery(".success_msg").html('');
				});
			});
        </script>
