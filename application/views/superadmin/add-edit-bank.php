<script type="text/javascript" src="<?php echo VIEWBASE?>js/plugins/jquery.uniform.min.js"></script>
<script type="text/javascript" src="<?php echo VIEWBASE?>js/plugins/jquery.validate.min.js"></script>
<script type="text/javascript" src="<?php echo VIEWBASE?>js/plugins/tinymce/jquery.tinymce.js"></script>
<script type="text/javascript" src="<?php echo VIEWBASE; ?>js/plugins/jquery.tagsinput.min.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo VIEWBASE?>css/plugins/jquery.tagsinput.css">
<script type="text/javascript" src="<?php echo VIEWBASE; ?>js/plugins/jquery.colorbox-min.js"></script>
<script>
	jQuery(document).ready(function(){		
		//Examples of how to assign the Colorbox event to elements
		jQuery(".iframe").colorbox({iframe:true, width:"90%", height:"90%"});
	});
</script>
<?php 
if($row){
	$id=$row->id;	
	$name=$row->name;	
	$logopath = $row->logopath;
    $tender_docpath=$row->tender_doc;
    $annexure2path=$row->annexure2;
    $annexure3path=$row->annexure3;
    $thumb_logopath = $row->thumb_logopath;	
	$url = $row->url;	
	$shortname = $row->shortName;
	$address1 = $row->address1;
	$address2 = $row->address2;	
	$street=$row->street;
	$country=$row->country;
	$state=$row->state;
	$city=$row->city;
	$zip=$row->zip;
	$phone=$row->phone;
	$fax=$row->fax;
	$bank_header_color=$row->bank_header_color;
	$status=$row->status; 
	$indate = $row->inadate; 
	$priority = $row->priority; 
}else{	
	$status = 0;	
	$id = 0;
	$slug = '';
}
?> 
<style>
.rgt_detail > select, .rgt_detail >input, .rgt_detail > textarea{color: #333 !important;font-weight: bold; }
</style>
<script src="<?=  base_url();?>js/jscolor.js"></script>
<style>
#image_old_data img{width:50px !important;}
#thumb_logopath_old_data img{width:90px !important;}
</style>
<section class="body_main1">
		<div class="row">		
			<a href="<?php echo base_url().'superadmin/bank'?>" class="button_grey"> Bank List</a>
		</div>
		<div class="box-head">Create Bank</div>
		<div class="centercontent">
			<div class="pageheader">
				<span class="pagedesc"><div style="color:red"><?php echo validation_errors(); ?></div></span>
			</div><!--pageheader-->
			<div id="contentwrapper" class="contentwrapper box-content2">
				<div id="validation" class="subcontent">
					<form enctype="multipart/form-data" method="post" class="stdform" id="bank" name="add_data_view" accept-charset="utf-8" action="/superadmin/bank/save" autocomplete="off">	
<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash();?>" />
						<div class="row">
							<div class="lft_heading">Name <span class="red"> *</span></div>
							<div class="rgt_detail">
								<input type="text" maxlength="200" name="name" id="name" class="longinput html_found" value="<?php echo $name?>" />
								<label class="error" style="display:none;">Please enter Name</label>
							</div>					
						</div>
						<div class="row">
							<div class="lft_heading"> Upload Logo <span class="red"> *</span></div>
								<div class="rgt_detail">
								<input onchange="validate_upload('image');" type="file" name="image" id="image">(jpg | png | jpeg | gif )
								<input type="hidden" name="image_old" id="image_old" value="<?php echo $logopath; ?>"><div id="imgerror_image" class="error" style="color:red;"></div>
								<?php if($logopath){?><span id="image_old_data" style="80px !important"><br><br><img src="<?php echo $logopath;?>"   /></span><?php }?>	
							</div>
						</div>
						<?php /* ?>
						<div class="row">
							<div class="lft_heading">Large logo</div>
								<div class="rgt_detail">
								<input  type="file" onchange="validate_upload('thumb_logopath');" name="thumb_logopath" id="thumb_logopath">(jpg | png | jpeg | gif )
								<div id="imgerror_thumb_logopath" class="error" style="color:red;"></div>
								<input type="hidden" name="thumb_logopath_old" id="thumb_logopath_old" value="<?php echo $thumb_logopath; ?>">
								<?php if($thumb_logopath){?><span id="thumb_logopath_old_data" style="80px !important"><br><br><img src="<?php echo $thumb_logopath;?>" />&nbsp;&nbsp;</span><?php }?>	
							</div>
						</div>
							
						<div class="row">
							<div class="lft_heading">Website Url</div>
							<div class="rgt_detail">
								<input type="text" maxlength="200" name="url" id="url" class="longinput html_found" value="<?php echo $url?>" />
								<label class="error" style="display:none;">Please enter url</label>
							</div>					
						</div>
						<?php */ ?>
						<div class="row">
							<div class="lft_heading">Short Name <span class="red"> *</span></div>
							<div class="rgt_detail">
								<input type="text" maxlength="200" name="shortname" id="shortname" class="longinput html_found" value="<?php echo $shortname?>" />
								<label class="error" style="display:none;">Please enter shortname</label>
							</div>					
						</div>
						<div class="row">
							<div class="lft_heading">Address <span class="red"> *</span></div>
							<div class="rgt_detail">
								<textarea maxlength="200" class="html_found" name="address1" ><?php echo $address1?></textarea>
								<label class="error" style="display:none;">Please enter Address1</label>
							</div>					
						</div>
						<?php /* ?>
						<div class="row">
							<div class="lft_heading">Address 2 </div>
							<div class="rgt_detail">
								<textarea name="address2" id="address2" class="html_found" rows="3	" cols="60" ><?php echo $address2?></textarea>
								<label class="error" style="display:none;">Please enter Address2</label>
							</div>					
						</div>
						<div class="row">
							<div class="lft_heading">Street </div>
							<div class="rgt_detail">
								<textarea name="street" id="street" class="html_found" rows="3" cols="60" ><?php echo $street?></textarea>
								<label class="error" style="display:none;">Please enter street</label>
							</div>					
						</div>
						<?php */ ?>
						<div class="row">
							<div class="lft_heading">Country <span class="red"> *</span></div>
							<div class="rgt_detail">
								<select name="country_id" id="country_id">
									<option value="">Select Country</option>
									<?php
									foreach($countries as $country_record){?>
					  <option value="<?php echo $country_record->id; ?>" <?php echo ($country_record->id==$country)?'selected':''; ?>><?php echo $country_record->country_name; ?></option>
									<?php }?>
								</select>
							</div>					
						</div>
						<div class="row">
							<div class="lft_heading">State <span class="red"> *</span></div>
							<div class="rgt_detail">
								<select name="state_id" id="state_id">
									<option value="">Select State</option>
									<?php foreach($states as $state_record){ ?>
                                                                         <option value="<?php echo $state_record->id; ?>" <?php echo ($state_record->id==$state)?'selected':''; ?>><?php echo $state_record->state_name; ?></option>
									<?php } ?>
								</select>
							</div>					
						</div>
						
						<div class="row">
							<div class="lft_heading">City <span class="red"> *</span></div>
							<div class="rgt_detail">
								<select name="city_id" id="city_id">
									<option value="">Select City</option>
									<?php
									foreach($cities as $city_record){?>
					  <option value="<?php echo $city_record->id; ?>" <?php echo ($city_record->id==$city)?'selected':''; ?>><?php echo $city_record->city_name; ?></option>
									<?php }?>
								</select>
							</div>					
						</div>
						<div class="row">
							<div class="lft_heading">Zip Code <span class="red"> *</span></div>
							<div class="rgt_detail">
								<input maxlength="6" type="text" onkeypress="return isNumberKey(event);" name="zip" id="zip" class="html_found longinput" value="<?php echo $zip?>" />
								<label class="error" style="display:none;">Please enter zip</label>
							</div>					
						</div>
						<?php /* ?>
						<div class="row">
							<div class="lft_heading">Phone Number</div>
							<div class="rgt_detail">
								<input maxlength="15" type="text" onkeypress="return isNumberKey(event);" name="phone" id="phone" class="html_found longinput" value="<?php echo $phone?>" />
								<label class="error" style="display:none;">Please enter phone</label>
							</div>					
						</div>
						<div class="row">
							<div class="lft_heading"> Bank header color </div>
							<div class="rgt_detail">
                                                               <input class="jscolor" id="color_value" name="bank_header_color" value="<?php echo $bank_header_color;?>">
                                                            <!--<input maxlength="15" type="text" onkeypress="return isNumberKey(event);" name="fax" id="fax" class="longinput" value="<?php echo $fax?>" />-->
								<label class="error" style="display:none;">Please header color </label>
							</div>					
						</div>
                        <div class="row">
							<div class="lft_heading">Fax Number </div>
							<div class="rgt_detail">
								<input maxlength="15" type="text" onkeypress="return isNumberKey(event);" name="fax" id="fax" class="html_found longinput" value="<?php echo $fax?>" />
								<label class="error" style="display:none;">Please enter fax</label>
							</div>					
						</div>
                                                
                                                <div class="row">
							<div class="lft_heading">Tender Document</div>
								<div class="rgt_detail">
								<input accept="jpg,png,pdf,jpeg,gif,zip" type="file" name="tender_doc" id="tender_doc" onchange="ImageValidate('tender_doc','5');">(jpg | png | jpeg | gif | pdf |zip )
								<input type="hidden" name="tender_doc_old" id="tender_doc_old" value="<?php echo $tender_docpath; ?>" >
                                                                <div id="imgerror_tender_doc" class="error" style="color:red;"></div>
								<?php if($tender_docpath){?><span id="tender_doc_old_data">
                                                                    <br><br><a href="<?php echo $tender_docpath;?>" target="_blank"><?php echo explode('/',$tender_docpath)[4];?></a></span><?php }?>	
							</div>
						</div>
                                                 <div class="row">
							<div class="lft_heading">Annexure 2  </div>
								<div class="rgt_detail">
								<input type="file" name="annexure2" id="annexure2" accept="jpg,png,pdf,jpeg,gif,zip" onchange="ImageValidate('annexure2','5');">(jpg | png | jpeg | gif | pdf |zip )
								<input type="hidden" name="annexure2_old" id="annexure2_old" value="<?php echo $annexure2path; ?>"><div id="imgerror_annexure2" class="error" style="color:red;"></div>
								<?php if($annexure2path){?><span id="annexure2_old_data"><br><br><a href="<?php echo $annexure2path;?>" target="_blank"><?php echo  explode('/',$annexure2path)[4]; ?></a></span><?php }?>	
							</div>
						</div>
                        <div class="row">
							<div class="lft_heading">Annexure 3 </div>
								<div class="rgt_detail">
								<input accept="jpg,png,pdf,jpeg,gif,zip" type="file" name="annexure3" id="annexure3" onchange="ImageValidate('annexure3','5');">(jpg | png | jpeg | gif | pdf |zip )
								<input type="hidden" name="annexure3_old" id="annexure3_old" value="<?php echo $annexure3path; ?>"><div id="imgerror_annexure3" class="error" style="color:red;"></div>
								<?php if($annexure3path){?><span id="annexure3_old_data"><br><br><a href="<?php echo $annexure3path;?>" target="_blank"><?php  echo  explode('/',$annexure3path)[4];?></a></span><?php }?>	
						</div>
						<div class="row">
							<div class="lft_heading">Homepage Show Order</div>
							<div class="rgt_detail">
								<input maxlength="15" type="text" name="priority" id="priority" class="longinput html_found" value="<?php echo $priority?>" />
								<label class="error" style="display:none;">Please enter Order</label>
							</div>					
						</div>
						<?php */ ?>
						<div class="row">
							<div class="lft_heading">Status<span class="red"> *</span></div>
							<div class="rgt_detail">
							<select name="status">
								<option value="1" <?php if($status==1)echo 'selected';?>>Active</option>
								<option value="0" <?php if($status==0)echo 'selected';?>>Inactive</option>
							</select>
							</div>	
						</div>	
                                                <div class="stdformbutton row" style="text-align:center;">
							<a href="<?php echo base_url().'superadmin/home'?>" class="button_grey">Back</a>
							<input type="submit" name="addedit" value="<?php if($id){ ?>Update <?php }else{ ?>Submit<?php } ?>" class="button_grey">
							<input type="hidden" name="id" id="id" value="<?php echo $id?>">
						</div>
						
					</form>
				</div>
			</div><!--contentwrapper-->
			<br clear="all" />
		</div><!-- centercontent -->
</section>
<script>
     function isNumberKey(evt)
    {
        var charCode = (evt.which) ? evt.which : event.keyCode;
        console.log(charCode);
        if ( charCode != 45 && charCode > 31
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
	
	jQuery('.upload_file_ext').change(function () {
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
				jQuery('#form16').attr('disabled', false);
				break;
				default:
					alert('This is not an allowed file type.');
					this.value = '';
			}
	});
	
	
	jQuery('#tender_doc').change(function () {
		
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
				$('#tender_doc').attr('disabled', false);
				break;
				default:
					alert('This is not an allowed file type.');
					this.value = '';
			}
		});
	jQuery('#annexure2').change(function () {
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
				$('#annexure2').attr('disabled', false);
				break;
				default:
					alert('This is not an allowed file type.');
					this.value = '';
			}
		});
	jQuery('#annexure3').change(function () {
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
				$('#annexure3').attr('disabled', false);
				break;
				default:
					alert('This is not an allowed file type.');
					this.value = '';
			}
		});
					
		
	jQuery("#bank").validate({
		rules: {
			 name: {
				required:true,
				remote: {
						    url: "/superadmin/bank/uniqueBank",
						    type: "get",
						    data: {
							    name: function() {
									
								    return jQuery( "#name" ).val();
							    },
							    id: function() {
								    return jQuery( "#id" ).val();
							    }
						    }
					    }
			    },
			
			/*
				priority: {
				required:true,
				remote: {
						    url: "/superadmin/bank/uniquePriority",
						    type: "get",
						    data: {
							    name: function() {
									
								    return jQuery( "#priority" ).val();
							    },
							    id: function() {
								    return jQuery( "#id" ).val();
							    }
						    }
					    }
			    },
			*/
			//url: "required",
			//shortname: "required",
			shortname: {
				required:true,
				remote: {
						    url: "/superadmin/bank/uniqueshortname",
						    type: "get",
						    data: {
							    name: function() {
									
								    return jQuery( "#shortname" ).val();
							    },
							    id: function() {
								    return jQuery( "#id" ).val();
							    }
						    }
					    }
			    },
			address1: "required",
			country_id: "required",
			state_id: "required",
			city_id: "required",
			zip: "required",
			//phone: "required",
			image: {
				<?php if($logopath == ''){?>
				required: true,
				<?php } ?>
				accept: "png|jp?g|gif"
			},
			thumb_logopath:{
				accept: "png|jp?g|gif"
			}
			
		},
		messages: {
			
			//url: {required: "Please enter url"},
			//shortname: {required: "Please enter shortname"},
			shortname: {
				remote: jQuery.validator.format("'{0}' is already in use"),
				required: "Please enter shortname"
		    },
			/*
		    priority: {
				remote: jQuery.validator.format("'{0}' is already in use"),
				required: "Please enter priority"
		    },*/
			address1: {required: "Please enter address"},
			country_id: {required: "Please select country"},
			state_id: {required: "Please select state"},
			city_id: {required: "Please select city"},
			zip: {required: "Please enter zip"},
			phone: {required: "Please enter phone"},
			image: {
				
				required: "Please upload small logo.",
				accept: "Invailid image format."},
			thumb_logopath:{
				accept: "Invailid image format."
			},
			name: {
				remote: jQuery.validator.format("'{0}' is already in use"),
				required: "Please enter name"
		    }
		}
		/*,
		submitHandler: function (form) {
			//alert(form+"yyyyyyyyyyyy");
			jQuery(form).submit();
            // stuff to do when form is valid
            // ajax, etc?
        }*/
	});
	
	jQuery("#date_published" ).datepicker({
		changeMonth: true,
		changeYear: true,
		yearRange: '1910:'
	});
	
	jQuery('#country_id').change(function(){
		var country_id = jQuery(this).val();
		if(country_id )
		{
			var state_id = jQuery('#state_id').val();
			jQuery('#state_id').load('/superadmin/bank/getStateDropDown/'+country_id+'/'+state_id);
		}
		
	});	
	jQuery('#state_id').change(function(){
		var state_id = jQuery(this).val();
		if(state_id )
		{
			var city_id = jQuery('#city_id').val();
			jQuery('#city_id').load('/superadmin/bank/getCityDropDown/'+state_id+'/'+city_id);
		}
		
	});
});


function ImageValidate(field_name,sizelimit) {
	//2097152
	//$("#file_error").html("");
	
	jQuery(".images_error"+field_name).remove();
	var file_size =jQuery('#'+field_name)[0].files[0].size;
	//alert("asdfasdfdsaf"+file_size);
	slimit=1024*1024*parseInt(sizelimit);
	if(file_size>slimit){
		//$("#file_error").html("File size is greater than 2MB");
		jQuery("#"+field_name).val('');
		jQuery("<span class='images_error"+field_name+"' style='color:red;'>Images size is greater then "+sizelimit+"MB.</span>" ).insertAfter("#"+field_name);
		return false;
	}else{
		jQuery(".images_error"+field_name).remove();
		return true;
	} 
}	



function validate_upload(fname) {
    //Get reference of FileUpload.
        var fileUpload = document.getElementById(fname);
	var size=jQuery('#'+fname)[0].files[0].size;
	sizelimit=50;// MB 
	slimit=(1024)*parseInt(sizelimit);
        var regex = new RegExp("([a-zA-Z0-9\s_\\.\-:])+(.jpg|.png|.gif|.jpeg|.pdf|.JPG)$");
    if (regex.test(fileUpload.value.toLowerCase())) {
        //Check whether HTML5 is supported.
        if (typeof (fileUpload.files) != "undefined") {
            //Initiate the FileReader object.
            var reader = new FileReader();
            //Read the contents of Image File.
            reader.readAsDataURL(fileUpload.files[0]);
			
			if(size <= slimit){
				
            reader.onload = function (e) {
                //Initiate the JavaScript Image object.
                var image = new Image();
 
                //Set the Base64 string return from FileReader as source.
                image.src = e.target.result;
                       
                //Validate the File Height and Width.
                image.onload = function () {
                    var height = this.height;
                    var width = this.width;
                    var size = fileUpload.files[0];
                    //alert("height-"+height+"--------width-"+width +"size--"+size);
                    if (height > 100 && width > 100) {
                    fileUpload.value='';
                   jQuery("#imgerror_"+fname).html('Height and Width should be 100x100.'); 
                        return false;
                    }
					
                   // alert("Uploaded image has valid Height and Width.");
                    return true;
                };
 
            }
			}else{
				 fileUpload.value='';
				 jQuery("#imgerror_"+fname).html('Please upload image less than 50 kb.');
				 return false;
			}
			
			
        } else {
			jQuery("#imgerror_"+fname).html('This browser does not support HTML5.');
            fileUpload.value='';
            return false;
        }
    } else {
		jQuery("#imgerror_"+fname).html('Please select a valid Image file.');
		 fileUpload.value='';
        //alert("Please select a valid Image file.");
        return false;
    }

	jQuery("#imgerror_"+fname).html('');
	return true;
}

</script>
