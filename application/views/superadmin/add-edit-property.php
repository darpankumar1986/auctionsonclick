<script type="text/javascript" src="<?php echo VIEWBASE?>js/plugins/jquery.uniform.min.js"></script>
<script type="text/javascript" src="<?php echo VIEWBASE?>js/plugins/jquery.validate.min.js"></script>
<script type="text/javascript" src="<?php echo VIEWBASE?>js/custom/forms.js"></script>
 <script type="text/javascript" src="<?php echo VIEWBASE; ?>js/plugins/jquery.colorbox-min.js"></script>
<script>
	jQuery(document).ready(function(){		
		//Examples of how to assign the Colorbox event to elements
		jQuery(".iframe").colorbox({iframe:true, width:"90%", height:"90%"});
	});
	
	function showSubcategory(cate){
		
	var category_id = cate;
		if(category_id)
		{
			//alert("fff"+category_id);
			
			jQuery('#type').load('/superadmin/dynamic_form/showSubcategory/'+category_id);
			
		}	
	}
	function ajaxFormdata(){
		var category_id = jQuery('#type').val();
		if(category_id )
		{
			var product_id = jQuery('#id').val();
			jQuery('#ajaxFormData').load('/superadmin/dynamic_form/ajaxFormData/'+category_id+'/'+product_id);
		}
	}
</script>
<div class="centercontent">
	<div class="pageheader notab">
		<h1 class="pagetitle"><?php echo $heading; ?></h1>
		<span class="pagedesc"><div style="color:red"><?php echo validation_errors(); ?></div></span>
	</div><!--pageheader-->
    <div id="contentwrapper" class="contentwrapper">
		<div id="validation" class="subcontent">   
		<div style="color:red;text-align:center;">
<?php echo $this->session->flashdata('msg');?>		</div>

			<form enctype="multipart/form-data" method="post" class="stdform" id="property" name="add_data_view" accept-charset="utf-8" action="/superadmin/dynamic_form/save">	
				
				<p>
					<label>Name<font color='red'>*</font></label>
					<span class="field">
						<input type="text" name="name" maxlength="200" id="name" class="longinput" value="<?php echo $detail_records->name?>" />
					</span>					
				</p>
				<p>
					<label>Description<font color='red'>*</font></label>
					<span class="field">
						<textarea maxlength="8000" name="description" id="description" class="longinput" ><?php echo $detail_records->product_description ?> </textarea>
					</span>					
				</p>
				<p>
					<label>Price<font color='red'>*</font></label>
					<span class="field">
					
						<input onkeypress="return priceisNumberKey(event);" maxlength="30" type="text" name="price" id="price" class="longinput"  value="<?php echo $detail_records->price?>" />
					</span>
				</p>
				<p>
					<label>Address<font color='red'>*</font></label>
					<span class="field">
						<input maxlength="2000" type="text" name='address' id='address' class="longinput" value="<?php echo $detail_records->address1?>" />
					</span>
				</p>
				<p>
					<label>Street</label>
					<span class="field">
						<input maxlength="400" type="text" name='street' class="longinput" value="<?php echo $detail_records->street?>" />
					</span>
				</p>
				<p>
					<label>Country<font color='red'>*</font></label>
					<span class="field">
						<select name="country" id="country">
							<option value="">Select Country</option>
							<?php
							foreach($countries as $country_record){?>
              <option value="<?php echo $country_record->id; ?>" <?php echo ($country_record->id==$detail_records->country)?'selected':''; ?>><?php echo $country_record->country_name; ?></option>
							<?php }?>
						</select>
					</span>					
				</p>
				<p>
				
				<div id="state_data"></div>
					<label>State<font color='red'>*</font></label>
					<span class="field">
						<select name="state" id="state">
							<option value="">Select State</option>
							<?php
							foreach($states as $state_record){?>
              <option value="<?php echo $state_record->id; ?>" <?php echo ($state_record->id==$detail_records->state)?'selected':''; ?>><?php echo $state_record->state_name; ?></option>
							<?php }?>
						</select>
					</span>					
				</p>
				
				<p>
					<label>City<font color='red'>*</font></label>
					<span class="field">
						<select name="city" id="city">
							<option value="">Select City</option>
							<?php
							foreach($cities as $city_record){?>
              <option value="<?php echo $city_record->id; ?>" <?php echo ($city_record->id==$detail_records->city)?'selected':''; ?>><?php echo $city_record->city_name; ?></option>
							<?php }?>
						</select>
					</span>					
				</p>
				<p>
					<label>Phone <font color='red'>*</font></label>
					<span class="field">
						<input  type="text" onkeypress="return isNumberKey(event);" maxlength="15" name='phone' id='phone' class="longinput" value="<?php echo $detail_records->phone?>" />
					</span>
				</p>
				<p>
					<label>Fax</label>
					<span class="field">
						<input type="text" onkeypress="return isNumberKey(event);" maxlength="15" name='fax' class="longinput" value="<?php echo $detail_records->fax?>" />
					</span>
				</p>
				<div class="actionBar">
				<h4>Images</h4>
				<?php if($totalimages<=0){?>		
				<div class="step_max" >		
				
				<p>
					<label>Image</label>
						<span class="field">
						<input type="file" name="image[]" id="image">(jpg | png | jpeg | gif )
						
					</span>
				</p>
				</div>
				<?php } ?>
				<?php if($product_id){?>
				<a href="/superadmin/product_image/page_popup/<?php echo $product_id?>" class="iframe" style="background: none repeat scroll 0 0 #fb9337;
				border: 1px solid #f0882c;
				border-radius: 2px;
				box-shadow: none;
				color: #eee;
				cursor: pointer;
				font-weight: bold;
				margin: 0;
				padding: 7px 10px;
				float:left;
				width: auto;"><strong>Manage Image</strong></a>	
				<?php }?>
				
				
					
				</div>
				<br />
				<div class="actionBar">
				<h4>Video</h4>					
				
				<p>
					<label>Video Type</label>
						<span class="field">
						<select name="video_type" id="video_type" onchange="if(jQuery(this).val()=='url'){jQuery('#video_url').show();jQuery('#video_file').hide();}else { jQuery('#video_file').show();jQuery('#video_url').hide();}">
							<option value="">Select</option>
							<option value="url">URL</option>
							<option value="file">File</option>
						</select>
						
					</span>
				</p>
				<p id="video_file" style="display:none">
					<label>Video</label>
						<span class="field">
						<input type="file" name="video" id="video">(mp4)
						
					</span>
				</p>
				<p id="video_url" style="display:none">
					<label>Video URL</label>
						<span class="field">
						<input type="text" name="video_url" id="video_url">
						
					</span>
				</p>
				<?php if($product_id){?>
				<a href="/superadmin/product_video/page_popup/<?php echo $product_id?>" class="iframe" style="  background: none repeat scroll 0 0 #fb9337;
				border: 1px solid #f0882c;
				border-radius: 2px;
				box-shadow: none;
				color: #eee;
				cursor: pointer;
				font-weight: bold;
				margin: 0;
				padding: 7px 10px;
				float:left;
				width: auto;"><strong>Manage Video</strong></a>	
				<?php }?>
				</div>	
				<p>
					<label>Product For<font color='red'>*</font></label>
					<span class="field">
						<select name="product_for" id="product_for">
							<option value="">Select</option>
							<option <?php echo ($detail_records->sell_rent=='sell')?'selected':''?> value="sell">sell</option>
							<option <?php echo ($detail_records->sell_rent=='rent')?'selected':''?>  value="rent">rent</option>
							
						</select>
					</span>					
				</p>
				<p>
					<label>Is Auction<font color='red'>*</font></label>
					<span class="field">
						<select name="is_auction" id="is_auction">
							<option value="">Select</option>
							<option value='1' <?php echo ($detail_records->is_auction=='1')?'selected':''?>>Yes</option>
			   <option value='0' <?php echo ($detail_records->is_auction=='0')?'selected':''?>>No</option>
						</select>
					</span>					
				</p>
				<p>
					<label>Property Type<font color='red'>*</font></label>
					<span class="field">
						<select name="category" id="category" onchange="showSubcategory(this.value);">
							<option value="">Select</option>
							<?php
							foreach($categorylist as $catlist){?>
              <option value="<?php echo $catlist->id; ?>" <?php echo ($catlist->id==$detail_records->product_type)?'selected':''; ?>><?php echo $catlist->name; ?></option>
							<?php }?>
						</select>
					</span>					
				</p>
				
				<p>
				<label>Property Sub Type<font color='red'>*</font></label>
				<span class="field" id="subcategorydata">
				<select name="type" id="type">
<?php echo $records = $this->attribute_group_model->showSubcategory($detail_records->product_type,$detail_records->product_subtype_id); ?>
				
				</select>
				</span>					
				</p>

<br>

				
				<p id='ajaxFormData'></p>	
				
				<p class="stdformbutton">					
					<input type="submit"  name="addedit" id="addedit" value="<?php echo ($product_id)?'Update':'Submit'?>">
					<input type="hidden" name="id" id="id" value="<?php echo $product_id?>">
					<!--<input type="hidden" name="type" id="type" value="<?php echo $type?>">-->
				</p>
				<?php 
				if($detail_records->product_subtype_id)
				echo "<script> ajaxFormdata();</script>";
				?>
			</form>
        </div>
	</div><!--contentwrapper-->
    <br clear="all" />
</div><!-- centercontent -->

<script>
	function isNumberKey(evt)
    {
        var charCode = (evt.which) ? evt.which : event.keyCode;
        console.log(charCode);
        if (charCode != 45 && charCode > 31
                && (charCode < 48 || charCode > 57))
            return false;

        return true;
    }
	
			function priceisNumberKey(evt)
    {
        var charCode = (evt.which) ? evt.which : event.keyCode;
        console.log(charCode);
        if (charCode != 46 && charCode != 45 && charCode > 31
                && (charCode < 48 || charCode > 57))
            return false;

        return true;
    }

function checkboxval(lid,id){
		var count_checked = jQuery("[name='form_field_"+id+"[]']:checked").length;	
			if(count_checked>0)
			{
				jQuery("#"+id).val('yes');
			}else{
				jQuery("#"+id).val('');
			}
		}	
jQuery(document).ready(function(){
	jQuery("#property").validate({
		rules: {
		description:{
				required:true
			},
		product_for:{
				required:true
		  },
		is_auction:{
			required:true
			},
		type:{
			required:true
			},
		name: "required",
		
		"image[]":{
			accept: "png|jpg|gif|jpeg"
		} ,
		phone:{
			required:true,
		    number: true	
		},
		price:{
			required:true,
		    number: true
		} ,
		address: "required",
		country: "required",
		state: "required",
		category: "required" ,    
		city: "required"   
		
                },
		messages: {
			name:  "Please enter name"	,		
			description:  "Please enter description",			
			product_for:  "Please enter product for",			
			is_auction:  "Please select 'is auction'",			
			type:  "Please select property sub type",			
			price: {
				required:"Please enter price",
				number: "Please enter valid number"
			} ,
			phone: {
				required:"Please enter phone",
				number: "Please enter valid phone"
			},			
			address:  "Please enter address",			
			country:  "Please select country",			
			state:  "Please select state",			
			city:  "Please select city",			
			category:  "Please select Property Type",
			"image[]" : {
				accept :"Please enter valid image"
			}     			
		},
		 submitHandler: function(form) {  
		 var album_text = [];
			  jQuery(".required_fields").each(function() {
					if(jQuery(this).val()=='')
					{  
						attrID=jQuery(this).attr("id");
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
				//alert("false");
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
		
		if(country_id)
		{
			jQuery('#state').load('/superadmin/bank/getStateDropDown/'+country_id+'/'+state_id);
		}
		
	});	
	jQuery('#state').change(function(){
		var state_id = jQuery(this).val();
		if(state_id )
		{
			var city_id = jQuery('#city_id').val();
			jQuery.ajax({
              url:  '/superadmin/bank/getCityDropDown',
              type: "post",
              data: "city_id="+city_id+"&state_id="+state_id,
              success: function(results){
				 // alert(results);
				jQuery('#city').html(results);  
			
              }
            });
			
			
			//jQuery('#city').load('/superadmin/bank/getCityDropDown/'+state_id+'/'+city_id);
		}
		
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
</script>
