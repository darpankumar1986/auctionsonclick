<script type="text/javascript" src="<?php echo VIEWBASE?>js/plugins/jquery.uniform.min.js"></script>
<script type="text/javascript" src="<?php echo VIEWBASE?>js/plugins/jquery.validate.min.js"></script>
<script type="text/javascript" src="<?php echo VIEWBASE?>js/custom/forms.js"></script>
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
	$user_type=$row->user_type;	
	$property_type = $row->property_type;	
	$fee_type = $row->fee_type;	
	$range_from = $row->range_from;	
	$range_to = $row->range_to;
	$fees = $row->fees;
	$status = $row->status;	
	
}else{	
	$status = 0;	
	$id = 0;
	$slug = '';
}
?> 
<div class="centercontent">
	<div class="pageheader">
		<h1 class="pagetitle"><?php echo $heading; ?></h1>
		<span class="pagedesc"><div style="color:red"><?php echo validation_errors(); ?></div></span>
	</div><!--pageheader-->
    <div id="contentwrapper" class="contentwrapper">
		<div id="validation" class="subcontent">            	
			<form enctype="multipart/form-data" method="post" class="stdform" id="auctionFees" name="add_data_view" accept-charset="utf-8" action="/superadmin/auction_fees/save">	
				
				
				
				<p>
					<label>Property Type<font color='red'>*</font></label>
					<span class="field">
						<select name="property_type" id="property_type">
							<option value="">Select Type</option>
							<option <?php echo ($property_type=='sell')? $selec="selected": $selec=""; ?> value="sell">Sell</option>
							<option <?php echo ($property_type=='rent')? $selec="selected": $selec=""; ?> value="sent">Rent</option>
						</select>
						
						<label class="error" style="display:none;">Please Select type</label>
					</span>					
				</p>
			<p>
					<label>Fee Type<font color='red'>*</font></label>
					<span class="field">
						<select name="fee_type" id="fee_type">
							<option value="">Select Fee Type</option>
							<option <?php echo ($fee_type=='participation fee')? $selec="selected": $selec=""; ?> value="participation fee">Form Fee</option>
							<option <?php echo ($fee_type=='auction fee')? $selec="selected": $selec=""; ?> value="auction fee">Auction Fee</option>
						</select>
						<label class="error" style="display:none;">Please Select Fee type</label>
					</span>					
				</p>
			
				
				<p>
					<label>User type<font color='red'>*</font></label>
					<span class="field">
						<select name="user_type" id="user_type">
							<option value="">Select User Type</option>
							<option <?php echo ($user_type=='bidder')? $selec="selected": $selec=""; ?> value="bidder">Bidder</option>
							<option <?php echo ($user_type=='seller')? $selec="selected": $selec=""; ?> value="seller">Seller</option>
							<option <?php echo ($user_type=='broker')? $selec="selected": $selec=""; ?> value="broker">Broker</option>
							<option <?php echo ($user_type=='landlord')? $selec="selected": $selec=""; ?> value="landlord">Landlord</option>
							<option <?php echo ($user_type=='builder')? $selec="selected": $selec=""; ?> value="builder">Builder</option>
						</select>
						<label class="error" style="display:none;">Please Select User Type</label>
					</span>					
				</p>
				<p>
					<label>Fee Range From<font color='red'>*</font></label>
					<span class="field">
						<input maxlength="15" type="text" name="range_from" id="range_from" onkeypress="return isNumberKey(event);" class="input" value="<?php echo $range_from?>" />
						<label class="error" style="display:none;">Please enter Fee range From</label>
					</span>					
				</p>
				
			
				<p>
					<label>Fee Range to<font color='red'>*</font></label>
					<span class="field">
						<input maxlength="15" type="text" onkeypress="return isNumberKey(event);" name="range_to" id="range_to" class="input" value="<?php echo $range_to?>" />
						<label class="error" style="display:none;">Please enter Fee Range To</label>
					</span>					
				</p>
	
				<p>
					<label>Fees <font color='red'>*</font></label>
					<span class="field">
						<input type="text" onkeypress="return isNumberKey(event);" name="fees" id="fees"  class="input" value="<?php echo $fees;?>" />
						<label class="error" id="ajax_error"></label>
					</span>	
									
				</p>
				
				<p class="stdformbutton">
					<input type="submit"  name="addedit" value="<?php echo ($id)?'Update':'Submit'?>">
					<input type="hidden" name="id" id="id" value="<?php echo $id?>">
				</p>
				
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
        if (charCode != 46 && charCode != 45 && charCode > 31
                && (charCode < 48 || charCode > 57))
            return false;

        return true;
    }
jQuery(document).ready(function(){
	

	
	
	jQuery("#auctionFees").validate({
		rules: {
			property_type: "required",
			fee_type: "required",
			user_type: "required",
			range_from: {
				required:true,
				min:0			},
			range_to:{
				required:true,
				min:0				
			} ,
			fees:{
				required:true,
				min:0		
			} 
		},
		messages: {
			property_type:  "Please select property type",
			fee_type:  "Please select fee type",
			user_type:  "Please select  user type",
			range_from: {
				required:"Please enter range from",
				min:"Nagetive values not allow"
			} ,
			range_to:{
				required:"Please enter range to",
				min:"Nagetive values not allow"
			}  ,
			fees:{
				required:"Please enter fees",
				min:"Nagetive values not allow"
			} 
		}
	});
	

jQuery("#fees").blur(function() {
	property_type	=	jQuery( "#property_type").val();	
	fee_type		=	jQuery( "#fee_type").val();	
	user_type		=	jQuery( "#user_type").val();	
	range_from		=	jQuery( "#range_from").val();	
	range_to		=	jQuery( "#range_to").val();	
	fees		=	jQuery( "#fees").val();	
	id				=	jQuery( "#id").val();	
	if(property_type!='' && fee_type!='' && user_type!='' && range_from!='' && range_to!='' )
	{
			  jQuery.ajax({
              url:  "<?php echo base_url();?>superadmin/auction_fees/checkAuctionFees",
              type: "post",
              data: "property_type="+property_type+"&fee_type="+fee_type+"&user_type="+user_type+"&range_from="+range_from+"&range_to="+range_to+"&id="+id+"&fees="+fees,
              success: function(results){
				//  alert(results);
				  if(results=='true'){
					   jQuery( "#fees").val('');
					  jQuery( "#ajax_error").html('This auction fees pair already exist ');	
					  return false;
				  }else{
					   jQuery( "#ajax_error").html('');
					  return true;
				  }
				// $("#resultpropertySearchRent").css('display','block');
				// $("#resultpropertySearchRent").html(results); 
              }
            });
		
	}
});
	


});	

</script>
