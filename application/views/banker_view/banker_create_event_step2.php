<link rel="stylesheet" href="<?php echo base_url()?>/assets/css/jquery.dataTables.css" />

<?php
$images=$prows->images;
$videos=$prows->video;
$attributs=$prows->attr_val;
foreach($videos as $vrow);
$productid	=	$prows->id;
//echo "<pre>";
//print_r($prows);
//echo "</pre>";
//echo 'fvfv';
//die;
?>
<link rel="stylesheet" href="/css/colorbox.css" />
<script src="/js/jquery.colorbox.js"></script>
	<script>
			$(document).ready(function(){
				//Examples of how to assign the Colorbox event to elements
				$(".iframe").colorbox({iframe:true, width:"80%", height:"80%"});
			//Example of preserving a JavaScript event for inline calls.
				$("#click").click(function(){ 
					$('#click').css({"background-color":"#f00", "color":"#fff", "cursor":"inherit"}).text("Open this window again and this message will still be here.");
					return false;
				});
			});
		</script>
<section>
  <?php //echo $breadcrumb;?>
  <div class="row">
    <div class="wrapper-full">
      <div class="dashboard-wrapper">
        <div class="search-row">
          <div class="srch_wrp">
            <input type="text" value="Search" id="search" name="search">
            <span class="ser_icon"></span> </div>
          <a href="#">Advance Search+</a> </div>
        <div id="tab-pannel3" class="btmrgn">
          <div class="tab_container3">
            
            
            <!-- #tab1 -->
            <div id="tab6" class="tab_content3">
              <div class="container">
                <?php echo $leftPanel?>
                <div class="secttion-right">
                  <div class="table-wrapper btmrg20">
                    <div class="table-heading btmrg">
                      <div class="heading4">Live Auction</div>
                      <!--<div class="srch_wrp2">
                        <input type="text" value="Search" id="search" name="search">
                        <span class="ser_icon"></span> </div>-->
                    </div>
                    <div class="table-section">
						<!--///--->
						
						<div class="stepwise-wrapper">
          <div class="step-default">
          Step 1
          <span>1</span>
          <div class="arrow-down"></div>
          </div>
          <div class="step-active">
           Step 2
          <span>2</span>
          <div class="arrow-down"></div>
          </div>
          <div class="step-default">
           Step 3
          <span>3</span>
          <div class="arrow-down"></div>
          </div>
          </div>
		  <form method="post" enctype="multipart/form-data" name="createevent" id="createevent" action="/buyer/createEventAuction/<?php echo $auctionID;?>">
            <div class="form">
			<dl>
                <dt class="required">
                  <label>Title </label>
                </dt>
                <dd>
                  <input name="name" maxlength="500" id="name" type="text" value="<?php echo @$prows->name; ?>" class="input">
                  <span class="help-icon" title="Enter Property Title"></span> </dd>
            </dl>
			<dl>
                <dt>
                  <label>Description</label>
                </dt>
                <dd>
                   <input maxlength="8000" name="description" id="description" value="<?php echo @$prows->product_description; ?>" type="text" class="input">
                   </dd>
            </dl>
			<!--
			<dl>
                <dt class="required">
                  <label>Price</label>
                </dt>
                <dd>
                   <input name="price" id="price" type="text" value="<?php echo @$prows->price; ?>" class="input">
                  <span class="help-icon" title="Enter Price"></span> </dd>
            </dl>-->
			<dl>
                <dt class="required">
                  <label>Address</label>
                </dt>
                <dd>
                   <input name="address" maxlength="2000" id="address" type="text" value="<?php echo @$prows->address1; ?>" class="input">
                  <span class="help-icon" title="Enter Address"></span> </dd>
            </dl>
			<dl>
                <dt>
                  <label>Street</label>
                </dt>
                <dd>
                   <input name="street" id="street" maxlength="400" type="text" value="<?php echo @$prows->street; ?>" class="input">
                  </dd>
            </dl>
			
		      <dl>
                <dt class="required">
                  <label>Country</label>
                </dt>
                <dd>
                  <select name="country" id="country" class="select">
				  <option value="">Select Country</option>
                   <?php
						foreach($countries as $country_record){ ?>
              <option value="<?php echo $country_record->id; ?>" <?php echo ($country_record->id==$prows->country)?'selected':''; ?>><?php echo $country_record->country_name; ?></option>
							<?php } ?>
                  </select>
                </dd>
              </dl>
		     <dl>
                <dt class="required">
                  <label>State</label>
                </dt>
                <dd>
                  <select  name="state" id="state" class="select">
				  <option value="">Select State</option>
                   				<?php
							foreach($states as $state_record){?>
              <option value="<?php echo $state_record->id; ?>" <?php echo ($state_record->id==$prows->state)?'selected':''; ?>><?php echo $state_record->state_name; ?></option>
							<?php }?>
                  </select>
                </dd>
              </dl>
			<dl>
                <dt class="required">
                  <label>City</label>
                </dt>
                <dd>
                  <select name="city" id="city" class="select">
                 	<option value="">Select City</option>
							<?php
							foreach($cities as $city_record){?>
              <option value="<?php echo $city_record->id; ?>" <?php echo ($city_record->id==$prows->city)?'selected':''; ?>><?php echo $city_record->city_name; ?></option>
							<?php }?>
                  </select>
                </dd>
              </dl>
			  
				<dl>
                <dt class="required">
                  <label>Phone</label>
                </dt>
                <dd>
                   <input name="phone" onkeypress="return isNumberKey(event);" maxlength="15" id="phone" value="<?php echo @$prows->phone; ?>" type="text" class="input">
                  <span class="help-icon" title="Enter Phone No"></span> </dd>
            </dl>
			
				<dl>
                <dt class="required">
                  <label>Fax</label>
                </dt>
                <dd>
                   <input name="fax" onkeypress="return isNumberKey(event);" maxlength="15" id="fax" type="text"  value="<?php echo @$prows->fax; ?>" class="input">
                  <span class="help-icon" title="Enter Fax no"></span> </dd>
            </dl>
			
			<div id="addmoreimages" >
			
			<dl>
                <dt >
                  <label>Images</label>
                </dt>
                <dd>
				<?php
				if(count($images)>0)
				{ ?>
				<a class="manageimages iframe" href="/helpdesk_executive/page_popup/<?php echo $productid; ?>" >Manage Images</a>
			<?php } else{ ?>
			    <input name="image[]" id="image_1" type="file" class="input">
				<!--<a class="addmoreimage" href="javascript:">Add More</a> <span class="help-icon" title="Add Property images "></span>-->
			<?php } ?>
                 
				  </dd>
            </dl>
			
			
			</div>
			
			
			<?php 
            if(count($vrow) <= 0){			
			
			?>
			<dl>
                <dt >
				<?php //echo "tititit->".$vrow->type; ?>
                  <label>Video Type</label>
                </dt>
                <dd>
				<select class="select" name="video_type" id="video_type" class="valid">
							<option value="">Select</option>
							<option <?php if($vrow->type=='url'){ echo'selected="selected"';}else{ echo '';} ?> value="url">URL</option>
							
							<option <?php if($vrow->type=='video'){echo 'selected="selected"';}else{ echo '';} ?> value="video">File</option>
			    </select>
				
				
                  
                </dd>
              </dl>

			<dl id="video_file" <?php if($vrow->type=='video'){ echo 'style="display:block"';} else{ echo 'style="display:none"'; }?> > 
                <dt >
                  <label>Video</label>
                </dt>
                <dd>
                   <input name="video" id="video" type="file" class="input">(.mp4)
				   <?php if($vrow->name){ ?>
				   <input name="old_video" id="old_video" type="hidden" value="<?php echo $vrow->name;?>">
				   <?php } ?>
                  <span class="help-icon" title="Add video  "></span> </dd>
            </dl>
			<dl id="video_url" <?php if($vrow->type=='url'){ echo 'style="display:block"';} else{ echo 'style="display:none"'; }?>>
                <dt>
                  <label>Video URL</label>
                </dt>
                <dd>
                   <input name="video_url" id="video_url" value="<?php echo @$vrow->name; ?>" type="text" class="input">
                  <span class="help-icon"></span> </dd>
            </dl>
			
			<?php } else{ ?>
			
			<dl>
                <dt >
                  <label>Video</label>
                </dt>
                <dd>
				<a class="manageimages iframe" href="/helpdesk_executive/video_page_popup/<?php echo $productid; ?>" >Manage Videos</a>
				 </dd>
            </dl>
			
			<?php  } ?>
			
			
	
			<dl>
                <dt class="required">
                  <label>Property Type</label>
                </dt>
                <dd>
                  <select class="select" name="category" id="category" onchange="showsubcategry(this.value,'bank');">
					<option value="">Select</option>
					<?php foreach($category as $category_record){?>
						<option value="<?php echo $category_record->id; ?>" <?php echo ($category_record->id==$prows->product_type)?'selected':''; ?>><?php echo $category_record->name; ?></option>
						<?php }?>
				</select>
                  <span class="help-icon" title="Select Property Type"></span> </dd>
            </dl>
			  <dl>
                <dt class="required">
                  <label>Property Sub Type</label>
                </dt>
                <dd>
                  <select class="select" name="type" id="type" onchange="ajaxFormdatabanker(this.value);">
					<option value="">Select</option>
					<?php
					$subcategory=$this->helpdesk_executive_model->GetsubCategorydata($prows->product_type,$prows->product_subtype_id);
					
				foreach($subcategory as $subcaterow){?>
				<option value="<?php echo $subcaterow->id; ?>" <?php echo ($subcaterow->id==$prows->product_subtype_id)?'selected':''; ?>><?php echo $subcaterow->name; ?></option>
				<?php }?>
				</select>
                  <span class="help-icon" title="Select Property Type"></span> </dd>
          </dl>
			
				<div id="ajaxFormData">
				<?php 
					if($prows->product_subtype_id!=''){ ?>
						<script>
							ajaxFormdatabanker(<?php echo $prows->product_subtype_id; ?>,'<?php echo $productid?>')
						</script>
						
					<?php } ?>
				</div>
              <div class="seprator btmrg20"></div>
              <div class="button-row">
			  <a href="/buyer/createEvent/<?php echo $auctionID?>"><input name="Back" value="Back" type="button" class="b_submit"> </a>
			  <input name="Save" value="Save & Continue" type="submit" class="b_publish"></div>
			  <input type="hidden" name="auctionID" id="auctionID" value="<?php echo $auctionID?>">
			  <input type="hidden" name="productID" id="productID" value="<?php echo $productid; ?>">
            </div>
			</form>
						
						<!--///--->
						
					
					</div>
                  </div>
                </div>
              </div>
            </div>
            
            
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<script type="text/javascript" src="/application/views/admin/js/plugins/jquery.validate.min.js"></script>
<link rel="stylesheet" href="<?php echo base_url(); ?>js/calender/jquery-ui.css">
<script src="<?php echo base_url(); ?>js/calender/jquery-ui.js"></script>
<script>
	jQuery( "#video_type" ).change(function() {
	type=$(this).val();
	if(type=='url')
	{
		jQuery("#video_url").show();
		jQuery("#video_file").hide();
	}else if(type=='video')
	{
		jQuery("#video_url").hide();
		jQuery("#video_file").show();
	}else{
		jQuery("#video_url").hide();
		jQuery("#video_file").hide();	
	}
	//alert(type);	
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
	
	
	jQuery(document).ready(function(){
	
	
	jQuery("#createevent").validate({
		rules: {
			name: "required",
			address: "required",
			country: "required",
			state: "required",
			city: "required",
			type: "required",
			category: "required",
			phone: "required",
			fax: "required",
			"image[]":{
			accept: "png|jpg|gif|jpeg"
			},
			video_url: {
					url:true	
			},
			//mandatory
			is_auction: "required",
			video: {
				accept: "mp4"
			},
			
		},
		messages: {
			name:  "Please enter name",
			address: "Please enter address",
			country: "Please select country",
			state: "Please select state",
			city: "Please select city",
			type: "Please select property sub type",
			category: "Please select property type",
			phone: "Please enter phone number",
			fax: "Please enter fax number",	
			video: {
				accept:"Please Select mp4 video only"
			} ,
			video_url:{
				url:"Please Enter Valid Youtube url"
			},
		       "image[]" : {
			accept :"Please enter valid image Accepted Format png,jpg,gif,jpeg"
		} 		
		},
		 submitHandler: function(form) {  
		 var album_text = [];
			  jQuery(".required_fields").each(function() {
					if(jQuery(this).val()=='')
					{   dynamicValid =jQuery("#dynamicValid").val();
						attrID=jQuery(this).attr("id");
						//jQuery('<label class="error" >Please Enter value</label>').insertAfter(jQuery("#"+attrID));
						jQuery('#msg_'+attrID).show();
						album_text.push(attrID);	
					}else{
						attrID=jQuery(this).attr("id");
						jQuery('#msg_'+attrID).hide();	
					}
				});
			if(album_text.length === 0)
			{
				form.submit();
			}else{
				return false;
			}
		}
		
		
		
	});
});

	jQuery('#type').change(function(){		
		ajaxFormdata();
	});	
	
	jQuery('#country').change(function(){
		var country_id = jQuery(this).val();
		if(country_id )
		{
			var state_id = jQuery('#state_id').val();
			jQuery('#state').load('/buyer/getStateDropDown/'+country_id+'/'+state_id);
		}
		
	});	
	jQuery('#state').change(function(){
		var state_id = jQuery(this).val();
		if(state_id )
		{
			var city_id = jQuery('#city_id').val();
			jQuery('#city').load('/buyer/getCityDropDown/'+state_id+'/'+city_id);
		}
		
	});	
	
	jQuery('.addmoreimage').click( function(){
	//alert("yrddd");	
		jQuery("#addmoreimages").append('<dl><dt><label></label></dt> <dd><input name="image[]" id="image_1" type="file" class="input"></dd></dl>');	
	});
	
	jQuery('.addMore').click(function(){
		var currentCount =  jQuery('.step_max').length;
		if(jQuery('#image_'+currentCount).val() != ''){
			var newCount = currentCount+1;
			var lastRepeatingGroup = jQuery('.step_max').last();
			var newSection = lastRepeatingGroup.clone();
			newSection.insertAfter(lastRepeatingGroup);
			newSection.find("input").each(function (index, input) {
				input.id = input.id.replace("_" + currentCount, "_" + newCount);
				input.name = input.name.replace("_" + currentCount, "_" + newCount);
				input.value='';	
				jQuery(this ).siblings('span .filename').html('');
			});
			newSection.find("select").each(function (index, input) {
				input.id = input.id.replace("_" + currentCount, "_" + newCount);
				input.name = input.name.replace("_" + currentCount, "_" + newCount);
				
			});
			jQuery('#optcount').val(newCount);
			return false;
		}
		else {alert('Current Element is empty.');}

	});
	
// tooltip code
jQuery(function() {
    jQuery('.help-icon').tooltip();
  });
</script>
