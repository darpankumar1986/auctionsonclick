<link rel="stylesheet" href="<?php echo base_url()?>css/colorbox.css" />
<script src="<?php echo base_url()?>js/jquery.colorbox.js"></script>
<script type="text/javascript" src="<?php echo VIEWBASE?>js/plugins/jquery.uniform.min.js"></script>
<script type="text/javascript" src="<?php echo VIEWBASE?>js/plugins/jquery.validate.min.js"></script>
<script type="text/javascript" src="<?php echo VIEWBASE?>js/custom/forms.js"></script>
 <script type="text/javascript" src="<?php echo VIEWBASE; ?>js/plugins/jquery.colorbox-min.js"></script>
<link rel="stylesheet" href="<?php echo base_url()?>js/calender/jquery-ui.css">
<script src="<?php echo base_url(); ?>js/calender/jquery-ui.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>js/calender/jquery-ui-timepicker-addon.min.js"></script>
<link rel="stylesheet" href="<?php echo base_url()?>js/calender/jquery-ui-timepicker-addon.css">

<script type="text/javascript" src="<?php echo base_url(); ?>js/calender/jquery-ui-sliderAccess.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>application/views/superadmin/js/plugins/jquery.validate.min.js"></script>
<div class="centercontent">
	<div class="pageheader notab">
		<h1 class="pagetitle"><?php echo $heading; ?></h1>
		<span class="pagedesc"><div style="color:red"><?php echo validation_errors(); ?></div></span>
	</div><!--pageheader-->
    <div id="contentwrapper" class="contentwrapper">
		<div id="validation" class="subcontent">   
		<div style="color:red;text-align:center;">
<?php echo $this->session->flashdata('msg');?>		</div>


		
<!--show error popup-->		  
<!--show error popup-->		  
<p style="display:none;"><a class='inline' href="#inline_content"></a></p>
<div style='display:none'>
	<div id='inline_content' style='padding:10px; background:#fff;'>
		<ul id="spMsg"></ul>
	</div>
</div> 
<!--show error popup -->
<!--show error popup -->

	<form method="post" enctype="multipart/form-data" class="stdform" name="postsellerRequirement" id="postsellerRequirement" action="/superadmin/dynamic_form/saveeventdata">
				<p>
					<label>Reference No1.<font color='red'>*</font></label>
					<span class="field">
						<input type="text" maxlength="500" name="reference_no" id="reference_no" class="longinput" value="<?php echo $auctionData->reference_no?>" />
					</span>					
				</p>
				<p>
					<label>Auction Title<font color='red'>*</font></label>
					<span class="field">
					<input type="text"  maxlength="500" name="event_title" id="event_title" class="longinput" value="<?php echo $auctionData->event_title?>" />
					
					</span>					
				</p>
			<input name="category_id" id="category_id" value="<?php echo $prows->product_type?>" type="hidden">
			<input name="subcategory_id" id="subcategory_id" value="<?php echo $prows->product_subtype_id?>"  type="hidden">
				<p>
					<label>Borrower Name<font color='red'>*</font></label>
					<span class="field">
						<input type="text" maxlength="250" name="borrower_name" id="borrower_name" class="longinput" value="<?php echo $auctionData->borrower_name?>" />
					</span>
				</p>
				
				<p>
					<label>Reserve Price<font color='red'>*</font></label>
					<span class="field">
					
						<input onkeypress="return isNumberKey(event);" type="text" maxlength="30" name='reserve_price' id='reserve_price' class="longinput" value="<?php echo $auctionData->reserve_price?>" />
					</span>
				</p>
				<p>
					<label>Press Release Date <font color='red'>*</font></label>
					<span class="field">
					<input name="press_release_date"  id="press_release_date"  value="<?php echo $auctionData->press_release_date;?>" type="text"  class="longinput">
						
					</span>
				</p>
			<p>
					<label>Date of inspection of asset(From)</label>
					<span class="field">
					<input name="inspection_date_from" id="inspection_date_from"  value="<?php echo $auctionData->inspection_date_from;?>" type="text"  class="input longinput">
					
					</span>
				</p>
				<p>
					<label>Date of inspection of asset (To</label>
					<span class="field">
						<input type="text" name='inspection_date_to' id='inspection_date_to' class=" longinput" value="<?php echo $auctionData->inspection_date_to;?>" />
					</span>
				</p><p>
					<label>Sealed Bid Submission Last Date <font color='red'>*</font></label>
					<span class="field">
						<input type="text"  name='bid_last_date' id='bid_last_date' class=" longinput" value="<?php echo $auctionData->bid_last_date;?>" />
					</span>
				</p><p>
					<label>Sealed Bid Opening Date <font color='red'>*</font></label>
					<span class="field">
						<input type="text" name='bid_opening_date' id='bid_opening_date' class=" longinput" value="<?php echo $auctionData->bid_opening_date;?>" />
					</span>
				</p><p>
					<label>Auction Start date <font color='red'>*</font></label>
					<span class="field">
						<input type="text" name='auction_start_date' id='auction_start_date' class=" longinput" value="<?php echo $auctionData->auction_start_date?>" />
					</span>
				</p><p>
					<label>Auction End date <font color='red'>*</font></label>
					<span class="field">
						<input type="text" name='auction_end_date' id='auction_end_date' class=" longinput" value="<?php echo $auctionData->auction_end_date?>" />
					</span>
				</p>
				<p>
					<label>Show FRQ</label>
					Yes
					<input name="show_frq" checked  <?php if($auctionData->show_frq=='1') { echo $chk='checked';}else{echo $chk='';}?>  id="show_frq" type="radio" value="1">
					No
					<input name="show_frq" <?php if($auctionData->show_frq=='0') { echo $chk='checked';}else{echo $chk='';}?>  id="show_frq1" type="radio" value="0">
				</p>
				<p>
				<label>Auto Bid Cut Off</label>
				<?php 
					if($auctionData->auto_bid_cut_off == 1)
					{  $chk1='checked';}
					else if($auctionData->auto_bid_cut_off == 0)
					{
					 $chk2='checked';
					}
					else
					{  $chk3='';}
				?>
					Yes
                  <input name="auto_bid_cut_off" <?php echo $chk1;?>   id="auto_bid_cut_off" type="radio" value="1">
                  No
                  <input  name="auto_bid_cut_off" <?php echo $chk2;?> <?php echo $chk3;?> id="auto_bid_cut_off" type="radio" value="0">
                  </p>
				  
				  <p>
				  <label>Price Bid</label>
                  Applicable
                  <input name="price_bid"  <?php if($auctionData->price_bid_applicable=='applicable') { echo $chk='checked';}else{echo $chk='';}?> id="price_bid" checked type="radio" value="applicable">
                 
                  Not Applicable
                  <input name="price_bid" <?php if($auctionData->price_bid_applicable=='not_applicable') { echo $chk='checked';}else{echo $chk='';}?> id="price_bid1"  type="radio" value="not_applicable">
                  
				</p>
				<p>
					<label>Bid Increment value <font color='red'>*</font></label>
					<span class="field">
						<input onkeypress="return isNumberKey(event);" maxlength="15" type="text" name='bid_inc' id='bid_inc' class="longinput" value="<?php echo $auctionData->bid_inc?>" />
					</span>
				</p>
				<p>
					<label>Auto Extension time (In Minutes.) </label>
					<span class="field">
						<input onkeypress="return isNumberKey(event);" maxlength="2" type="text" name='auto_extension_time' id='auto_extension_time' class="longinput" value="<?php echo $auctionData->auto_extension_time ?>" />
					</span>
				</p>
				<p>
					<label>No. Of Auto Extension(s) </label>
					<span class="field">
						<input onkeypress="return isNumberKey(event);" maxlength="2" type="text" name='auto_extension' id='auto_extension' class="longinput" value="<?php echo $auctionData->no_of_auto_extn ?>" />
					</span>
				</p>
				<p>
					<label>Upload Related Documents <font color='red'>*</font></label>
					<span class="field">
				 <input name="related_doc"  onchange="ImageValidate('related_doc','2');" id="related_doc" type="file"  class="input">
				  <?php
				  if($auctionData->related_doc){?>
				   <input name="old_related_doc"  id="old_related_doc" value="<?php echo $auctionData->related_doc;?>" type="hidden"  class="input">
				   <a download href="/public/uploads/event_auction/<?php echo $auctionData->related_doc;?>"> <?php echo $auctionData->related_doc;?></a>
				  <?php }else{ ?>
				  <input type="hidden" name="old_related_doc" id="old_related_doc" value="">
				  <?php } ?>
					</span>
				</p>
				<p>
					<label>Upload Image <font color='red'>*</font></label>
					<span class="field">
						<input type="file" onchange="ImageValidate('image','2');" name='image' id="image" class="longinput"  />
							<?php
				  if($auctionData->image){ ?>
					 <input name="old_image"  id="old_image"  value="<?php echo $auctionData->image;?>" type="hidden"  class="input">
					<a download href="/public/uploads/event_auction/<?php echo $auctionData->image;?>"><?php echo $auctionData->image?></a>	
				  <?php }else{ ?>
				  <input type="hidden" name="old_image" id="old_image" value="">
				  <?php } ?>

					</span>
				</p>
				<p>
					<label>Documents to be submitted <font color='red'>*</font></label>
					<span class="field">
						 <select multiple name="doc_to_be_submitted[]" id="doc_to_be_submitted" size="4" class="select-text">
				      <?php
					  if($auctionData->doc_to_be_submitted){
						  $docsubArr=explode(',',$auctionData->doc_to_be_submitted);
					  }
						foreach($document_list as $document){
						if(count($docsubArr)>0)
						{
							if(in_array($document->id,$docsubArr)){
								$docsel='selected';	
							}else{
								$docsel='';		
							}
						}
						?>
						<option <?php echo $docsel; ?> value="<?php echo $document->id; ?>"><?php echo $document->name; ?></option>
					<?php }?>
                  </select>
					</span>
				</p>
<br>	
				
				
<p class="stdformbutton">	
			
	<input onclick="return validateAdminformNonBank('save');" type="submit"  name="Save" id="Save" value="Save">
	<input type="hidden" name="propertyID" id="propertyID" value="<?php echo $propertyID?>">
	<input type="hidden" name="auctionID" id="auctionID" value="<?php echo $auctionID; ?>">
	<input type="hidden" name="currdate" id="currdate" value="<?php echo date("Y-m-d H:i:s") ?>" />

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
				//Examples of how to assign the Colorbox event to elements
				jQuery(".iframe").colorbox({iframe:true, width:"80%", height:"80%"});
				//Example of preserving a JavaScript event for inline calls.
				jQuery("#click").click(function(){ 
					jQuery('#click').css({"background-color":"#f00", "color":"#fff", "cursor":"inherit"}).text("Open this window again and this message will still be here.");
					return false;
				});
			});
		</script>

<script>
  jQuery('#press_release_date').datetimepicker({
		controlType: 'select',
		oneLine: true,
		maxDate: 0,
		changeMonth: true,
		changeYear: true,
		dateFormat: 'yy-mm-dd',
		timeFormat: 'HH:mm:00',
		yearRange: '1950:<?php echo date('Y')?>'
	});
	
  jQuery('#inspection_date_from').datetimepicker({
		controlType: 'select',
		oneLine: true,
		changeMonth: true,
		changeYear: true,
		dateFormat: 'yy-mm-dd',
		yearRange: '2016:2017',
		timeFormat: 'HH:mm:00'
	});
	
	jQuery('#inspection_date_to').datetimepicker({
		controlType: 'select',
		oneLine: true,
		changeMonth: true,
		changeYear: true,
		dateFormat: 'yy-mm-dd',
		yearRange: '2016:2017',
		timeFormat: 'HH:mm:00'
	});
	jQuery('#bid_last_date').datetimepicker({
		controlType: 'select',
		oneLine: true,
		changeMonth: true,
		changeYear: true,
		dateFormat: 'yy-mm-dd',
		yearRange: '2016:2017',
		timeFormat: 'HH:mm:00'
	});
	  jQuery('#bid_opening_date').datetimepicker({
		controlType: 'select',
		oneLine: true,
		changeMonth: true,
		changeYear: true,
		dateFormat: 'yy-mm-dd',
		yearRange: '2016:2017',
		timeFormat: 'HH:mm:00'
	});
	  jQuery('#auction_start_date').datetimepicker({
		controlType: 'select',
		oneLine: true,
		changeMonth: true,
		changeYear: true,
		dateFormat: 'yy-mm-dd',
		yearRange: '2016:2017',
		timeFormat: 'HH:mm:00'
	});
	jQuery('#auction_end_date').datetimepicker({
		controlType: 'select',
		oneLine: true,
		changeMonth: true,
		changeYear: true,
		dateFormat: 'yy-mm-dd',
		yearRange: '2016:2017',
		timeFormat: 'HH:mm:00'
	});
	
	
	
	
	
function validateAdminformNonBank(btn) {
	  jQuery('#spMsg').html("");
		flag='';
		if (jQuery('#reference_no').val() == '') {
            jQuery('#spMsg').append("<li>Please Enter Property ID </li>");
            flag = 1;
        }
		
		
		if (jQuery('#event_title').val() == '') {
			jQuery('#spMsg').append("<li>Please Enter Title </li>");
			flag = 1;
		}
		if (jQuery('#borrower_name').val() == '') {
			jQuery('#spMsg').append("<li>Please Enter Borrower Name </li>");
			flag = 1;
		}
		
		if (jQuery('#reserve_price').val() == '') {
			jQuery('#spMsg').append("<li>Please Enter Reserve Price</li>");
			flag = 1;
		}
		if ((jQuery('#reserve_price').val() == 0) && (jQuery('#reserve_price').val() != '')) {
			jQuery('#spMsg').append("<li>Reserve Price can not be zero</li>");
			flag = 1;
		}
		if (jQuery('#press_release_date').val() == '') {
			jQuery('#spMsg').append("<li>Please Enter Press Release Date</li>");
			flag = 1;
		}
		
		if (jQuery('#bid_last_date').val() == '') {
			jQuery('#spMsg').append("<li>Please Enter Sealed Bid Submission Last Date</li>");
			flag = 1;
		}
	
		if(jQuery('#old_related_doc').val()==''){
			if (jQuery('#related_doc').val() == '') {
				jQuery('#spMsg').append("<li>Please Upload Related Documents</li>");
				flag = 1;
			}
		}
		
		if(jQuery('#old_image').val()==''){
			if (jQuery('#image').val() == '') {
				jQuery('#spMsg').append("<li>Please Upload Image</li>");
				flag = 1;
			}
		}
		
		
		if (jQuery('#bid_opening_date').val() == '') {
			jQuery('#spMsg').append("<li>Please Enter Sealed Bid Opening Date</li>");
			flag = 1;
		}
		
		if (jQuery('#auction_start_date').val() == '') {
			jQuery('#spMsg').append("<li>Please Enter Auction Start date</li>");
			flag = 1;
		}
		
		if (jQuery('#auction_end_date').val() == '') {
			jQuery('#spMsg').append("<li>Please Enter Auction End date</li>");
			flag = 1;
		}
		
		if (jQuery('#bid_inc').val() == '') {
			jQuery('#spMsg').append("<li>Please Enter Bid Increment value</li>");
			flag = 1;
		}
		
		
	var options = jQuery('#doc_to_be_submitted > option:selected');
         if(options.length == 0){
             jQuery('#spMsg').append("<li>Please Select Documents to be submitted</li>");
             flag = 1;
         }
		
	if(flag != 1){
			returnFlag	=	ValidateDate();
			//alert("return val->"+returnFlag);
			if(returnFlag==1){
				jQuery("#showerror_msg").show();
				
				jQuery("#showerror_msg").show();
				jQuery(".inline").colorbox({inline:true, width:"50%"});
				jQuery(".inline").click();
				jQuery(".inline").colorbox({inline:true, width:"50%"});
				jQuery(".inline").click();
				return false;
			}else{
				return true;	
			}
				
		}else{
			jQuery("#showerror_msg").show();
			jQuery(".inline").colorbox({inline:true, width:"50%"});
			jQuery(".inline").click();
			return false;
		}
	
	
	return false;
   // return flag;
}

function ValidateDate() {
	
var nitdate = "", FromInsdate = "", ToInsdate = "", offerdate = "", openingdate = "", starttime = "", endtime = "";	
var flag = '';
var currdate=jQuery("#currdate").val();


var currdatetime = new Date(currdate);
//alert(currdatetime);
	nitdate 		=	jQuery('#press_release_date').val();
	FromInsdate 	=	jQuery('#inspection_date_from').val();
	ToInsdate 		=	jQuery('#inspection_date_to').val();
	offerdate 		=	jQuery('#bid_last_date').val();
	openingdate 	=	jQuery('#bid_opening_date').val();
	starttime 		=	jQuery('#auction_start_date').val();
	endtime 		=	jQuery('#auction_end_date').val();
	
	
	
	nitdate				= nitdate.replace(/-/g, '/');
	FromInsdate			= FromInsdate.replace(/-/g, '/');
	ToInsdate			= ToInsdate.replace(/-/g, '/');
	offerdate			= offerdate.replace(/-/g, '/');
	openingdate			= openingdate.replace(/-/g, '/');
	starttime			= starttime.replace(/-/g, '/');
	endtime				= endtime.replace(/-/g, '/');
	if (nitdate != ''){
		 nitdate = new Date(nitdate); 
	
		if (nitdate > currdatetime) {
        jQuery('#spMsg').append("<li>Press Release Date or time should be less than current date or time !! <li/>");
        flag = 1;
    }
		
		
	}   
	if (FromInsdate != ''){
		 FromInsdate = new Date(FromInsdate); 
	}
	if (ToInsdate != ''){
		 ToInsdate = new Date(ToInsdate); 
	}
	if (offerdate != ''){
		 offerdate = new Date(offerdate); 
	}
	if (openingdate != ''){
		 openingdate = new Date(openingdate); 
	}
	if (starttime != ''){
		 starttime = new Date(starttime); 
	}
	if (endtime != ''){
		 endtime = new Date(endtime); 
	}	  	
	
	if (offerdate <= currdatetime) {
		//alert("dsfasfdsfsad");
        jQuery('#spMsg').append("<li>Offer Submission last date or time should be greater than current date or time !! <li/>");
        flag = 1;
    }
    if (openingdate <= currdatetime) {
        jQuery('#spMsg').append("<li>Opening date or time should be greater than current date or  time !! <li/>");
        flag = 1;
    }
    if (starttime <= currdatetime) {
        jQuery('#spMsg').append("<li>Auction date or time should be greater than current date or time !! <li/>");
        flag = 1;
    }
    if (endtime != "") {
        if (starttime >= endtime) {
            jQuery('#spMsg').append("<li>Auction End date should be greater than Auction Start date or time !! <li/>");
            flag = 1;
        }

    }
	
	if(flag != 1){
		if (openingdate <= offerdate) {
				jQuery('#spMsg').append("Opening date or time should be greater than Offer submission last date or time !! <br/>");
				flag = 1;
			}
		if (starttime <= openingdate) {
				jQuery('#spMsg').append("Auction Start date and time should be greater than Opening date or time !! <br/>");
				flag = 1;
			}
	}
return flag;
}	

function ImageValidate(field_name,sizelimit) {
	//2097152
	//$("#file_error").html("");
	jQuery(".images_error"+field_name).remove();
	var file_size =jQuery('#'+field_name)[0].files[0].size;
	slimit=(1024*1024)*parseInt(sizelimit);
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
</script>
