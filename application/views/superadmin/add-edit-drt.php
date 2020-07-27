<script type="text/javascript" src="<?php echo VIEWBASE ?>js/plugins/jquery.uniform.min.js"></script>
<script type="text/javascript" src="<?php echo VIEWBASE ?>js/plugins/jquery.validate.min.js"></script>
<script type="text/javascript" src="<?php echo VIEWBASE ?>js/custom/forms.js"></script>
<script type="text/javascript" src="<?php echo VIEWBASE ?>js/plugins/tinymce/jquery.tinymce.js"></script>
<script type="text/javascript" src="<?php echo VIEWBASE; ?>js/plugins/jquery.tagsinput.min.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo VIEWBASE ?>css/plugins/jquery.tagsinput.css">
<script type="text/javascript" src="<?php echo VIEWBASE; ?>js/plugins/jquery.colorbox-min.js"></script>
<script>
    jQuery(document).ready(function () {
        //Examples of how to assign the Colorbox event to elements
        jQuery(".iframe").colorbox({iframe: true, width: "90%", height: "90%"});
    });
</script>
<?php
if ($row) {
    $id = $row->id;
    $name = $row->name;
    $address1 = $row->address1;
    $address2 = $row->address2;
    $street = $row->street;
    $country = $row->country;
    $state = $row->state;
    $city = $row->city;
    $zip = $row->zip;
    $phone = $row->phone;
    $fax = $row->fax;
    $status = $row->status;
    $indate = $row->inadate;
} else {
   $status = '1';
    $id = 0;
    $slug = '';
}

?> 
<section class="body_main1">
	<div class="row">						
			<a href="<?php echo base_url().'superadmin/drt/index'?>" class="button_grey"> DRT List</a>
		</div>
		<div class="box-head">Create DRT</div>
		<div class="centercontent">
		<div class="pageheader">
			<span class="pagedesc"><div style="color:red"><?php echo validation_errors(); ?>
			<?php if( $this->session->flashdata('message')) {?>
			<?php echo $this->session->flashdata('message'); ?><?php } ?>
			
			</div></span>
		</div><!--pageheader-->
    <div id="contentwrapper" class="contentwrapper box-content2">

        <div id="validation" class="subcontent">            	
            <form enctype="multipart/form-data" method="post" class="stdform" id="drt" name="add_data_view" accept-charset="utf-8" action="/superadmin/drt/save" autocomplete="off">	
            <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash();?>" />
                <div class="row">
                    <div class="lft_heading">Name <span class="red"> *</span></div>
                    <div class="rgt_detail">
                        <input maxlength="150" type="text" name="name" id="name" class="longinput html_found" value="<?php echo $name ?>" />
                        <label class="error" style="display:none;">Please enter Name</label>
                    </div>					
                </div>

                <div class="row">
                    <div class="lft_heading">Address 1 <span class="red"> *</span></div>
                    <div class="rgt_detail">
                        <textarea  maxlength="200" name="address1" class="html_found"><?php echo $address1 ?></textarea>
                        <label class="error" style="display:none;">Please enter Address1</label>
                    </div>					
                </div>

                <div class="row">
                   <div class="lft_heading">Address 2 </div>
                    <div class="rgt_detail">
                        <textarea maxlength="200" name="address2" id="address2" class="html_found" rows="3" cols="60" ><?php echo $address2 ?></textarea>
                        <label class="error" style="display:none;">Please enter Address2</label>
                    </div>					
                </div>
                <div class="row">
                    <div class="lft_heading">Street </div>
                    <div class="rgt_detail">
                        <textarea maxlength="100" name="street" id="street" class="html_found" rows="5" cols="60" ><?php echo $street ?></textarea>
                        <label class="error" style="display:none;">Please enter street</label>
                    </div>					
                </div>
                <div class="row">
                   <div class="lft_heading">Country <span class="red"> *</span></div>
                    <div class="rgt_detail">
                        <select name="country_id" id="country_id">
                            <option value="">Select Country</option>
<?php foreach ($countries as $country_record) { ?>
                                <option value="<?php echo $country_record->id; ?>" <?php echo ($country_record->id == $country) ? 'selected' : ''; ?>><?php echo $country_record->country_name; ?></option>
                            <?php } ?>
                        </select>
                    </div>					
                </div>
                <div class="row">
                    <div class="lft_heading">State <span class="red"> *</span></div>
                    <div class="rgt_detail">
                        <select name="state_id" id="state_id">
                            <option value="">Select State</option>
<?php foreach ($states as $state_record) { ?>
                                <option value="<?php echo $state_record->id; ?>" <?php echo ($state_record->id == $state) ? 'selected' : ''; ?>><?php echo $state_record->state_name; ?></option>
                            <?php } ?>
                        </select>
                    </div>					
                </div>

                <div class="row">
                    <div class="lft_heading">City <span class="red"> *</span></div>
                    <div class="rgt_detail">
                        <select name="city_id" id="city_id">
                            <option value="">Select City</option>
						<?php foreach ($cities as $city_record) {?>
                                <option value="<?php echo $city_record->id; ?>" <?php echo ($city_record->id == $city) ? 'selected' : ''; ?>><?php echo $city_record->city_name; ?></option>
						<?php }?>
                        </select>
                    </div>					
                </div>
                <div class="row">
                   <div class="lft_heading">Zip Code <span class="red"> *</span></div>
                    <div class="rgt_detail">
                        <input maxlength="6" type="text" onkeypress="return isNumberKey(event);" name="zip" id="zip" class="longinput html_found" value="<?php echo $zip ?>" />
                        <label class="error" style="display:none;">Please enter zip</label>
                    </div>					
                </div>
               <div class="row">
                    <div class="lft_heading">Phone Number <span class="red"> *</span></div>
                    <div class="rgt_detail">
                        <input maxlength="15" type="text" onkeypress="return isNumberKey(event);" name="phone" id="phone" class="longinput html_found" value="<?php echo $phone ?>" />
                        <label class="error" style="display:none;">Please enter phone</label>
                    </div>					
                </div>
                <div class="row">
                    <div class="lft_heading">Fax</div>
                    <div class="rgt_detail">
                        <input maxlength="15" type="text" onkeypress="return isNumberKey(event);" name="fax" id="fax" class="longinput html_found" value="<?php echo $fax ?>" />
                        <label class="error" style="display:none;">Please enter fax</label>
                    </div>					
                </div>
				<div class="row">
					<div class="lft_heading">Status <span class="red"> *</span></div>
					<div class="rgt_detail">
					<select name="status">
                                          <option value="1" <?php if($status==1  )echo 'selected';?>>Active</option>
					  <option value="0" <?php if($status==0)echo 'selected';?>>Inactive</option>
					</select>
					</div>
				</div>
				<hr>
                <div class="stdformbutton row" style="text-align:center;">
					<a href="<?php echo base_url().'superadmin/home'?>" class="button_grey">Back</a>
                    <input type="submit"   class="button_grey" name="addedit" value="<?php echo ($id) ? 'Update' : 'Submit' ?>">
                    <input type="hidden" name="id" id="id" value="<?php echo $id ?>">

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
        if (charCode != 46 && charCode != 45 && charCode > 31
                && (charCode < 48 || charCode > 57))
            return false;

        return true;
    }
    jQuery(document).ready(function () {
		jQuery('.html_found').change(function() {
	   if (jQuery(this).val().match(/<(\w+)((?:\s+\w+(?:\s*=\s*(?:(?:"[^"]*")|(?:'[^']*')|[^>\s]+))?)*)\s*(\/?)>/)) {
		  alert('Invalid html content found');
		  jQuery(this).focus();
		  jQuery(this).val('');
	   }
	});
        jQuery("#drt").validate({
            rules: {
                name: {
                    required:true,
                    remote: {
					url: "/superadmin/drt/uniqueDrt",
					type: "post",
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
                address1: "required",
                country_id: "required",
                state_id: "required",
                city_id: "required",
                zip: "required",
                phone:{
					required: true,
					number: true
					} ,
                
                

            },
            messages: {
                name: {
                    required: "Please enter name",
                    remote: jQuery.validator.format("{0} is already in use")
                },
			address1:{
				 required: "Please enter address"
			},
             country_id:{
				 required: "Please select country"
			},
             state_id:{
				 required: "Please select state"
			},
             city_id:{
				 required: "Please select city"
			},
             zip:{
				 required: "Please enter zip"
			},
			phone:{
				 required: "Please enter phone number",
				 number: "Please enter valid phone number"
			}    			
            }
        });

        jQuery("#date_published").datepicker({
            changeMonth: true,
            changeYear: true,
            yearRange: '1910:'
        });

        jQuery('#country_id').change(function () {
            var country_id = jQuery(this).val();
            if (country_id)
            {
                var state_id = jQuery('#state_id').val();
                jQuery('#state_id').load('/superadmin/bank/getStateDropDown/' + country_id + '/' + state_id);
            }

        });
        jQuery('#state_id').change(function () {
            var state_id = jQuery(this).val();
            if (state_id)
            {
                var city_id = jQuery('#city_id').val();
                jQuery('#city_id').load('/superadmin/bank/getCityDropDown/' + state_id + '/' + city_id);
            }

        });


        jQuery('textarea.tinymce').tinymce({
            // Location of TinyMCE script
            script_url: '<?php echo VIEWBASE ?>js/plugins/tinymce/tiny_mce.js',
            // General options
            theme: "advanced",
            skin: "themepixels",
            width: "85%",
            plugins: "autolink,lists,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,advlist",
            inlinepopups_skin: "themepixels",
            // Theme options
            theme_advanced_buttons1: "bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,outdent,indent,blockquote,|,fontselect,fontsizeselect",
            theme_advanced_buttons2: "pastetext,pasteword,|,bullist,numlist,|,undo,redo,|,link,unlink,image,help,code,|,preview",
            theme_advanced_buttons3: "formatselect,|,forecolor,backcolor,removeformat,|,charmap,media,|,fullscreen",
            theme_advanced_toolbar_location: "top",
            theme_advanced_toolbar_align: "left",
            theme_advanced_statusbar_location: "bottom",
            theme_advanced_resizing: true,
            relative_urls: false,
            // Example content CSS (should be your site CSS)
            content_css: "css/plugins/tinymce.css",
            // Drop lists for link/image/media/template dialogs
            template_external_list_url: "lists/template_list.js",
            external_link_list_url: "lists/link_list.js",
            external_image_list_url: "lists/image_list.js",
            media_external_list_url: "lists/media_list.js",
            // Replace values for the template plugin
            template_replace_values: {
                username: "Some User",
                staffid: "991234"
            }
        });



    });

</script>
