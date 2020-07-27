<script type="text/javascript" src="<?php echo base_url();?>application/views/admin/js/plugins/jquery.uniform.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>application/views/admin/js/plugins/jquery.validate.min.js"></script>
<?php 
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

<section class="body_main1">
  <div class="row">
	<div class="box-head"><?php echo $heading; ?></div>
		<div class="wrapper-full">
		<div class="dashboard-wrapper">
			<div id="tab-pannel6" class="btmrgn">
			<div class="tab_container6"> 
            <!---- buy tab container start ---->
            <div id="tab1" class="tab_content6" style="display:block">
              <div id="tab-pannel3" class="btmrgn">
                <div class="tab_container3 whitebg"> 
                  <!-- Buy > My Message start -->
                  <div id="tab7" class="tab_content3 box-content2">
                    <div class="container">
                        <div class="secttion-right">
                            <div class="profile-wrapper">
                                  <div class="">
                                      
                                    <form name="myform" id="myform" method="POST" action="myProfileEditSave" enctype="multipart/form-data" autocomplete="off">
										<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash();?>" />
										
										<input type="hidden" name="profile_type" id="profile_type" value="<?php echo $user_type;?>" />
                                        <div class="profile-data">
											<?php
                            
                                            if($this->session->flashdata('message_validation')){?>

                                                <dl class="error2">
                                                    <?php echo $this->session->flashdata('message_validation'); ?>
                                                </dl>
                                                <?php
                                            }?>
												<div class="row">
													<div class="lft_heading">Email ID</div>
													<div class="rgt_detail">
																<strong><?php echo $user_id; ?></strong>
													</div>
													 <hr style="width:100%; margin:15px 0 0 0; float:left;">
												</div>
												
												<?php  if($user_type=='builder'){ ?>
													<div class="row">
														<div class="lft_heading">Organization Name<span class="red"> *</span></div>
														<div class="rgt_detail">
																<input type="text" name="company_name" id="company_name" value="<?php echo $organisation_name ?>" />
														</div>
													</div>
													<div class="row">
														<div class="lft_heading">Authorized Person <span class="red"> *</span></div>
														<div class="rgt_detail">
															<input type="text" class="html_found" name="authorized_person" id="authorized_person" value="<?php echo trim($authorized_person) ?>" />
														</div>
													</div>
													<div class="row">
														<div class="lft_heading">Designation <span class="red"> *</span></div>
														<div class="rgt_detail">
															<input type="text" class="html_found" name="designation" id="designation" value="<?php echo trim($designation) ?>" />
														</div>
													</div>
													<?php }else{ ?>
													
												<div class="row">
													<div class="lft_heading">First Name <span class="red"> *</span></div>
													<div class="rgt_detail">
														<input type="text" class="html_found" name="first_name" id="first_name" value="<?php echo trim($first_name) ?>" />
													</div>
												</div>
												
												<div class="row">
													<div class="lft_heading">Last Name <span class="red"> *</span></div>
													<div class="rgt_detail">
															<input type="text" class="html_found" name="last_name" id="last_name" value="<?php echo trim($last_name) ?>" />
													</div>
												</div>
												
												<div class="row">
													<div class="lft_heading">Father's/Husband's Name <span class="red"> *</span></div>
													<div class="rgt_detail">
														<input type="text" class="html_found" name="father_name" id="father_name" value="<?php echo trim($father_name) ?>" />
													</div>
												</div>
												<?php } ?>
		
												<div class="row">
													<div class="lft_heading">Mobile No <span class="red"> *</span></div>
													<div class="rgt_detail">
														<input type="text" class="html_found" onkeypress="return isNumberKey(event);" name="mobile_no" id="mobile_no" value="<?php echo trim($mobile_no) ?>" />
													</div>
												</div>
												<div class="row">
													<div class="lft_heading">Country<span class="red"> *</span></div>
													<div class="rgt_detail">
														<select name="country" id="country" class="select">
														<option value="">Select Country</option>
														<?php
														foreach($countries as $country_record){ ?>
														<option value="<?php echo $country_record->id; ?>" <?php echo ($country_record->id==$country_id)?'selected':''; ?>><?php echo $country_record->country_name; ?></option>
														<?php } ?>
														</select>
													</div>
												</div>
												
												<div class="row">
													<div class="lft_heading">State<span class="red"> *</span></div>
													<div class="rgt_detail">
														<select  name="state" id="state" class="select">
														<option value="">Select State</option>
														<?php
														foreach($states as $state_record){?>
														<option value="<?php echo $state_record->id; ?>" <?php echo ($state_record->id==$state_id)?'selected':''; ?>><?php echo $state_record->state_name; ?></option>
														<?php }?>
														</select>
													</div>
												</div>
												
												<div class="row">
													<div class="lft_heading">City<span class="red"> *</span></div>
													<div class="rgt_detail">
														<select name="city" id="city" class="select">
															<option value="">Select City</option>
																	<?php
																	foreach($cities as $city_record){?>
													  <option value="<?php echo $city_record->id; ?>" <?php echo ($city_record->id==$city_id)?'selected':''; ?>><?php echo $city_record->city_name; ?></option>
														<?php }?>
														</select>
													</div>
												</div>

												<div class="row">
													<div class="lft_heading">Address1 <span class="red"> *</span></div>
													<div class="rgt_detail">
														<input type="text" class="html_found" name="address1" id="address1" value="<?php echo trim($address1) ?>" />
													</div>
												</div>
												<div class="row">
													<div class="lft_heading">Address2 </div>
													<div class="rgt_detail">
														<input type="text" class="html_found" name="address2" id="address2" value="<?php echo trim($address2) ?>" />
													</div>
												</div>
												<div class="row">
													<div class="lft_heading">Zip/Pin Code <span class="red"> *</span></div>
													<div class="rgt_detail">
														<input type="text" class="html_found" onkeypress="return isNumberKey(event);" maxlength="6" name="zip" id="zip" value="<?php echo trim($zip) ?>" />
													</div>
												</div>
												
												<div class="row">
													<div class="lft_heading">Phone</div>
													<div class="rgt_detail">
														<input type="text" class="html_found" onkeypress="return isNumberKey(event);"  name="phone" id="phone" value="<?php echo trim($phone_no) ?>" />
													</div>
												</div>
												
												<div class="row">
													<div class="lft_heading">Fax</div>
													<div class="rgt_detail">
														<input type="text" class="html_found" onkeypress="return isNumberKey(event);"  name="fax" id="fax" value="<?php echo trim($fax) ?>" />
													</div>
												</div>
												
												
												
												
												<div class="row">
													<div class="lft_heading">PAN/FORM-16 Details <span class="red"> *</span> </div>
													<div class="rgt_detail">
														<span>PAN No.<input <?php if($document_type=='pan_numberid'){ echo 'checked';} else{ echo '';}?> class="showformpan radio_icon" id="pan_numberid" checked name="pan_form-16" type="radio"  value="pan_no"></span>
														<span>FORM-16 .<input <?php if($document_type=='form-16'){echo 'checked';} else{echo '';}?> class="showformpan radio_icon" id="form_16id" name="pan_form-16" type="radio"  value="form-16"></span>
												</div>
												</div>
				
											<?php
											
											
											?>
											<?php if($document_type=='pan_no'){$document_noo = $document_no;} else{$document_noo = '';}?>
											
											<div id="pan-no_data" <?php if($document_type=='pan_no'){echo 'style="display:block;"';} else{echo 'style="display:none;"';}?>>
                                                <div class="lft_heading">Pan No<span class="red"> *</span> </div>
                                                <div class="rgt_detail"><input name="pan_number" id="pan_number"  placeholder="Pan No *" maxlength="10" type="text" class="input" value="<?php echo $document_noo; ?>"style="text-transform: uppercase;"></div>
                                            </div>
                                            
											<div id="form_16-data" <?php if($document_type=='form-16'){ echo 'style="display:block;"';} else{echo 'style="display:none;"';}?> >
														<div class="lft_heading">Form 16<span class="red"> *</span> </div>
														<div class="rgt_detail"><input type="file" name="form16" id="form16">
														<input type="hidden"  name="form16_old" value="<?php echo $document_no; ?>">
														<?php if($document_type=='form-16') { ?>
														<a download href="<?php base_url();?>/public/uploads/userdoc/<?php echo $document_no; ?>">View Document</a>
														<?php  } ?>
														</div>
											</div>
											<?php /* ?>
											<div class="row">
												<div class="lft_heading">Photo</div>
												<div class="rgt_detail"><input type="file" name="broker_photo" id="broker_photo" />
											  <input type="hidden" name="broker_photo_old" value="<?php echo trim($broker_photo);?>">
											  <?php
											  if($broker_photo!='')
											  { ?>
												<img style="width:120px;"  src="<?php echo base_url();?>public/uploads/userdoc/<?php echo $broker_photo;?>">  
												  
											  <?php } ?>
											</div>
											 </div>		
							
											<?php */ ?>
										 <hr style="width:100%; margin:15px 0 0 0; float:left;">
										  
										  <div class="row" style="text-align:center;">
										  			<a href="/owner/myProfile" class="button_grey">Cancel</a>
                                                   <input type="submit"  name="addedit" id="addedit" value="Update" class="button_grey"> 
												   
										</div>
										  
                                        </div>

                                        <!--<div class="last-login">

                                            <dl>
                                            <dt>Last Login  Seen:</dt>
                                            <dd>Monday, 22/05/2015, 11:00 AM</dd>
                                            </dl>

                                            <dl>
                                                <dt>Account Opening Date:</dt>
                                                <dd><?php echo date("l, d/m/Y h:i A", strtotime($indate)); ?></dd>
                                            </dl>
                                        </div>-->
                                    </form>
                                  </div>
                            </div>
                        </div>
                    </div>
                  </div>
                  <!-- Buy > My Message end --> 
                </div>
              </div>
            </div>
            <!---- buy tab container end ----> 
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<script>
	 function isNumberKey(evt)
    {
        var charCode = (evt.which) ? evt.which : event.keyCode;
        console.log(charCode);
        if (charCode != 46 && charCode != 45 && charCode > 31
                && (charCode < 48 || charCode > 57))
            return false;

        return true;
    }
    
$('#pan_number').bind('keypress', function (event) {
    
    var regex=new RegExp("^[A-Za-z0-9\b]+$");
    var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
    if (!regex.test(key)){
      //if(!((event.keyCode >= 37 && event.keyCode <= 40))){          
        event.preventDefault();
        return false;
    //}
   }
    
});
    
jQuery(document).ready(function(){	
	
	jQuery('#broker_photo').change(function () {
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
				case 'png':case 'jpg':case 'gif':case 'jpeg':case 'pdf':
				$('#broker_photo').attr('disabled', false);
				break;
				default:
					alert('This is not an allowed file type.');
					this.value = '';
			}
	});
	
	
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
	});	
	
	jQuery('.html_found').change(function() {
	   if ($(this).val().match(/<(\w+)((?:\s+\w+(?:\s*=\s*(?:(?:"[^"]*")|(?:'[^']*')|[^>\s]+))?)*)\s*(\/?)>/)) {
		  alert('Invalid html content found');
		  $(this).focus();
		  $(this).val('');
	   }
	});
	jQuery('#country').change(function(){
		var country_id = jQuery(this).val();
		if(country_id )
		{
			var state_id = jQuery('#state_id').val();
			jQuery('#state').load('/registration/getStateDropDown/'+country_id+'/'+state_id);
		}
		
	});	
	
	jQuery('#state').change(function(){
		var state_id = jQuery(this).val();
		if(state_id )
		{
			var city_id = jQuery('#city_id').val();
			jQuery('#city').load('/registration/getCityDropDown/'+state_id+'/'+city_id);
		}
		
	});	
</script>
<script>
 function isNumberKey(evt)
    {
        var charCode = (evt.which) ? evt.which : event.keyCode;
        console.log(charCode);
        if (charCode != 46 && charCode != 45 && charCode > 31
                && (charCode < 48 || charCode > 57))
            return false;

        return true;
    }
jQuery(document).ready(function(){
	jQuery('.html_found').change(function() {
	   if (jQuery(this).val().match(/<(\w+)((?:\s+\w+(?:\s*=\s*(?:(?:"[^"]*")|(?:'[^']*')|[^>\s]+))?)*)\s*(\/?)>/)) {
		  alert('Invalid html content found');
		  jQuery(this).focus();
		  jQuery(this).val('');
	   }
	});
	
	jQuery("#myform").validate({
		rules: {
            first_name:"required",
            last_name: "required",
            father_name: "required",
            authorized_person:"required",
            designation: "required",
            company_name: "required",
            designation: "required",
            mobile_no: "required",
			country: "required",
			state: "required",
			city: {
					  required: true,
					},
			address1: "required",
			zip: "required",
			//phone: "required",
		},
		messages: {
			first_name: "Please enter first name",
			last_name: "Please enter last name",
			company_name: "Please enter company name",
			authorized_person: "Please enter authorized person name",
			father_name: "Please enter Father's/Husband's name",
			designation: "Please enter designation",
			mobile_no: "Please enter mobile no",
			country: "Please select country",
			state:"Please select state",
			city: {
				required: "Please select city",
			},
			address1: "Please enter address",
			zip: "Please enter zip code",
			//phone: "Please enter phone",
		},
		
	});
	
	jQuery.validator.addMethod("pwcheck", function(value) {
			   return /^[A-Za-z0-9\d=!\-@._*]*$/.test(value) // consists of only these
				   && /[a-z]/.test(value) // has a lowercase letter
				   && /\d/.test(value) // has a digit
			});
});


</script>
