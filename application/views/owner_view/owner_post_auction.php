<?php 
$productid	=	$prows->id;
$bank_id	=	$erows->bank_id;
$branch_id	=	$erows->branch_id;
$drt_id	=	$erows->drt_id;
$closeBidderAuctionRows=$this->banker_model->getAllCloseAuctionBidder($auctionID);
?>
<link rel="stylesheet" href="<?php echo base_url()?>/css/colorbox.css" />
<script src="<?php echo base_url()?>/js/jquery.colorbox.js"></script>
<link rel="stylesheet" href="<?php echo base_url()?>js/calender/jquery-ui.css">
<script src="<?php echo base_url(); ?>js/calender/jquery-ui.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>js/calender/jquery-ui-timepicker-addon.min.js"></script>
<link rel="stylesheet" href="<?php echo base_url()?>js/calender/jquery-ui-timepicker-addon.css">
<script type="text/javascript" src="<?php echo base_url(); ?>js/calender/i18n/jquery-ui-timepicker-addon-i18n.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/calender/jquery-ui-sliderAccess.js"></script>
<script type="text/javascript" src="/application/views/admin/js/plugins/jquery.validate.min.js"></script>
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/jquery.dataTables.css" type="text/css" media="screen"/>	
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
<section>
    <?php echo $breadcrumb;?>
  <div class="row">
    <div class="wrapper-full">
      <div class="dashboard-wrapper">
          
        <div class="search-row">
          <div class="srch_wrp">
            <input type="text" value="Search" id="search" name="search">
            <span class="ser_icon"></span> </div>
          <a href="#">Advance Search+</a> 
        </div>
          
        <div id="tab-pannel6" class="btmrgn">
            
          <ul class="tabs6">
            <a href="/owner"><li rel="tab1">Buy</li></a>
            <a href="/owner/sell"><li class="active"  rel="tab2">Sell</li></a>
          </ul>
            
          <div class="tab_container6"> 
              
            <!---- buy tab container start ---->
            <div id="tab1" class="tab_content6" style="display:block">
              <div id="tab-pannel3" class="btmrgn">
                <ul class="tabs3">
                  <a href="/owner/sell"><li  rel="tab9">My Summary</li></a>
                  <a href="/owner/liveAuction"><li class="active" rel="tab10">My Activity</li></a>
                 <a href="/owner/myMessage?type=sell"><li rel="tab11">My Message</li></a>
                  <a href="/owner/myProfile?type=sell"><li rel="tab12">My Profile</li></a>
                </ul>
                <div class="tab_container3 whitebg"> 
                 
                  
                  <!-- Sell > My Activity start -->
                  
                  <div id="tab10" class="tab_content3">
                    <div class="container">
                      <div class="secttion-left">
                        <div class="left-widget">
                          <div id="cssmenu">
                        <?php echo $leftsidebar;?>
                          </div>
                        </div>
                      </div>
                      <div class="secttion-right">
						<div class="table-wrapper btmrg20">
                    <div class="table-heading btmrg">
                      <h3><?php echo $heading?></h3>
                      <!--<div class="srch_wrp2">
                        <input type="text" value="Search" id="search" name="search">
                        <span class="ser_icon"></span> </div>-->
                    </div>
                    <div class="table-section"> 
					<div id="error" style="color:red;">						
             <?php if(isset($this->session->userdata['flash:old:message'])){?>
				<div  style="color:red;text-align:center;"> <?php echo @$this->session->userdata['flash:old:message']; ?></div>
				<?php } ?>
			 </div>					
		<form method="post" enctype="multipart/form-data" name="postsellerRequirement" id="postsellerRequirement" action="/owner/saveeventdata">
		
				  
<!--show error popup-->		  
<p style="display:none;"><a class='inline' href="#inline_content"></a></p>
<div style='display:none'>
	<div id='inline_content' style='padding:10px; background:#fff;'>
		<ul id="spMsg"></ul>
	</div>
</div> 
<!--show error popup -->
		
		<div class="form">
              <input maxlength="500" name="reference_no" id="reference_no" type="hidden" value="1"  class="input">
              <input maxlength="500" name="event_title" id="event_title" type="text" value="xyz"   class="hidden">
			 <input name="category_id" id="category_id" value="<?php echo $prows->product_type?>" type="hidden">
			<input name="subcategory_id" id="subcategory_id" value="<?php echo $prows->product_subtype_id?>"  type="hidden">
          <?php /*
              <dl>
                <dt class="required">
                  <label>Asset Category</label>
                </dt>
                <dd>
                  <select name="category_id" id="category_id" class="select">
				  <option value="">Select Category</option>
                     	<?php
						foreach($category as $category_record){ ?>
						<option value="<?php echo $category_record->id; ?>" <?php echo ($category_record->id==$auctionData->category_id)?'selected':''; ?>><?php echo $category_record->name; ?></option>
						<?php }?>
                  </select>
				  <span class="help-icon" title="Assets are divided into categories. Please select the category of the asset from the dropdown."></span>
                </dd>
              </dl>
              <dl>
                <dt class="required">
                  <label>Sub Category</label>
                </dt>
                <dd >
                  <select name="subcategory_id" id="subcategory_id" class="select">
                    <option value="">Select Subcategory</option>
					<?php echo $subcategory=$this->helpdesk_executive_model->getsubcategory($auctionData->category_id);?>
					<?php
						foreach($subcategory as $subcategory_record){ ?>
						<option value="<?php echo $subcategory_record->id; ?>" <?php echo ($subcategory_record->id==$auctionData->subcategory_id)?'selected':''; ?>><?php echo $subcategory_record->name; ?></option>
						<?php }?>
                  </select>
				  <span class="help-icon" title="Under each category, sub categories are defined. You may choose the most suitable sub category."></span>
                </dd>
              </dl>
           
		   
		   
		   */
			?>
		   
             <!-- <dl>
                <dt class="required">
                  <label>Borrower Name</label>
                </dt>
                <!--<dd>
                  <input maxlength="250" name="borrower_name" id="borrower_name" value="<?php echo $auctionData->borrower_name;?>" type="text"  class="input">
				  <span class="help-icon" title="Name of the borrower."></span>
                </dd>
               
				  <span class="help-icon" title="Name of the borrower."></span>
                </dd>
              </dl>-->
               <input maxlength="250" name="borrower_name" id="borrower_name" value="t" type="text"  class="hidden">
          
              <div class="seprator btmrg20"></div>
              <dl>
                <dt class="required">
                  <label>Estimated Price</label>
                </dt>
                <dd>
                  <input maxlength="30" onkeypress="return isNumberKey(event);" name="reserve_price" id="reserve_price" type="text"  value="<?php echo $auctionData->reserve_price;?>" class="input">
				  <span class="help-icon" title="It is the base price finalised by the valuer of MCG."></span>
                </dd>
              </dl>
			  
			<?php /*  
              <dl>
                <dt class="required">
                  <label>EMD Amount</label>
                </dt>
                <dd>
                  <input name="emd_amt" id="emd_amt" type="text"  class="input" value="<?php echo $auctionData->emd_amt;?>">
				  <span class="help-icon" title="Earnest money deposit asked by the MCG."></span>
                </dd>
              </dl>
              <dl>
                <dt class="required">
                  <label>Tender Fee</label>
                </dt>
                <dd>
                  <input name="tender_fee" id="tender_fee" type="text"  class="input" value="<?php echo $auctionData->tender_fee;?>">
				  <span class="help-icon" title="This the the document fees payble by the bidder for purchasing the tender document. Please put 0 if not applicable."></span>
                </dd>
              </dl>
          */?>
             
           
              <div class="seprator btmrg20"></div>
              <?php /* ?>
              <dl>
                <dt class="required">
                  <label>Press Release Date</label>
                </dt>
                <dd>
                  <input name="press_release_date" id="press_release_date"  value="<?php echo $auctionData->press_release_date;?>" type="text"  class="input">
				  <span class="help-icon" title="The date of the press release of sale notice in news papers."></span>
                </dd>
                <dd>
                  
				  <span class="help-icon" title="The date of the press release of sale notice in news papers."></span>
                </dd>
              </dl>
              <?php */ ?>
              <input name="press_release_date" id="press_release_date"  value="2016-01-18 00:00:00" type="hidden"  class="hidden">
               <?php /* ?>
              <dl>
                <dt>
                  <label>Date of inspection of asset(From)</label>
                </dt>
                <dd>
                  <input name="inspection_date_from" id="inspection_date_from"  value="<?php echo $auctionData->inspection_date_from;?>" type="text"  class="input">
				  
                  <span class="help-icon" title="Date from when interested bidder may visit the property physically."></span> </dd>
              </dl>
              <dl>
                <dt>
                  <label>Date of inspection of asset (To)</label>
                </dt>
                <dd>
                  <input name="inspection_date_to"  value="<?php echo $auctionData->inspection_date_to;?>" id="inspection_date_to" type="text"  class="input">
                  
                  <span class="help-icon" title="Date till which any interested bidder may visit the property physically."></span> </dd>
              </dl>
               <?php */ ?>
              <dl>
                <dt class="required">
                  <label>Sealed Bid Submission Last Date</label>
                </dt>
                <dd>
                  <input name="bid_last_date"  value="<?php echo $auctionData->bid_last_date;?>" id="bid_last_date" type="text"  class="input">
                 
                  <span class="help-icon" title="Date till when the interested bidder may submit the EMD/Required Documents/Quote the initial price"></span> </dd>
              </dl>
              <dl>
                <dt>
                  <label>Sealed Bid Opening Date</label>
                </dt>
                <dd>
                  <input name="bid_opening_date"  value="<?php echo $auctionData->bid_opening_date;?>" id="bid_opening_date" type="text"  class="input">
                 
                  <span class="help-icon" title="Date of the opening of the recieved sealed bid from bidders. After opening the bank official will verify the EMD and documents submitted by the bidder."></span> </dd>
              </dl>
              <dl>
                <dt class="required">
                  <label>Auction Start date</label>
                </dt>
                <dd>
                  <input name="auction_start_date" value="<?php echo $auctionData->auction_start_date;?>" id="auction_start_date" type="text"  class="input">
                 
                  <span class="help-icon" title="Date and time from which the auction will be started."></span> </dd>
              </dl>
              <dl>
                <dt class="required">
                  <label>Auction End date</label>
                </dt>
                <dd>
                  <input name="auction_end_date" value="<?php echo $auctionData->auction_end_date;?>"  id="auction_end_date" type="text"  class="input">
                  
                  <span class="help-icon" title="Scheduled date and time to end the auction"></span> </dd>
              </dl>
              <div class="seprator btmrg20"></div>
              <?php /* ?>
              <dl class="plain">
                <dt class="required">
                  <label>Show FRQ</label>
                </dt>
                <dd> <span>
                  <label>Yes</label>
				  
				
				  
                  <input name="show_frq" checked  <?php if($auctionData->show_frq=='1') { echo $chk='checked';}else{echo $chk='';}?>  id="show_frq" type="radio" value="1">
                  </span> <span>
                  <label>No</label>
                  <input name="show_frq" <?php if($auctionData->show_frq=='0') { echo $chk='checked';}else{echo $chk='';}?>  id="show_frq1" type="radio" value="0">
                  </span> </dd>
              </dl>
			  <?php */ ?>
			   <input name="show_frq" id="show_frq"  value="1" type="hidden"  class="hidden">
			   <dl class="plain">
                <dt>
                  <label>Auto Bid Cut Off</label>
                </dt>
                <dd> <span>
                  <label>Yes</label>
                  <input name="auto_bid_cut_off" <?php if($auctionData->auto_bid_cut_off=='1') { echo $chk='checked';}else{echo $chk='';}?>  id="auto_bid_cut_off" type="radio" value="1">
                  </span> <span>
                  <label>No</label>
                  <input name="auto_bid_cut_off" <?php if($auctionData->auto_bid_cut_off=='0') { echo $chk='checked';}else{echo $chk='';}?> checked id="auto_bid_cut_off" type="radio" value="0">
                  </span> <span class="help-icon" title="Enabling auto-bid will place bids on your behalf at pre specified increments"></span></dd>
              </dl>
			 
              <dl class="plain">
                <dt class="required">
                  <label>Price Bid</label>
                </dt>
                <dd> <span>
                  <label>Applicable</label>
                  <input name="price_bid"  <?php if($auctionData->price_bid_applicable=='applicable') { echo $chk='checked';}else{echo $chk='';}?> id="price_bid" checked type="radio" value="applicable">
                  </span> <span>
                  <label>Not Applicable</label>
                  <input name="price_bid" <?php if($auctionData->price_bid_applicable=='not_applicable') { echo $chk='checked';}else{echo $chk='';}?> id="price_bid1"  type="radio" value="not_applicable">
                  </span>  <span class="help-icon" title="IF you are seeking the initial quote against reserve price then make this option ‘Applicable‘ else ‘Not Applicable‘"></span></dd>
              </dl>
			  <?php 
			  if($prows->sell_rent=='Sell'){
			  ?>
			  	  <dl class="plain">
                <dt class="required">
                  <label>Is Closed</label>
                </dt>
                <dd> <span>
                  <label>Yes</label>
				  <?php echo $auctionData->is_closed;?>
				  <?php if($auctionData->is_closed==1)
						{ 
							$ischk='checked';
					   }else if($auctionData->is_closed==0){
						  $ischk1='checked';  
					   }else{
						  $ischkDefault='checked';    
					   }
					    
			   ?>
			   
                  <input name="is_closed" onclick="showBidders(1);"  id="is_closed" <?php echo $ischk; ?> type="radio" value="1">
                  </span> <span>
                  <label>No</label>
                  <input name="is_closed" onclick="showBidders(0);"   id="is_closed1" <?php echo $ischk1; echo  $ischkDefault; ?> type="radio" value="0">
                  </span>  <span class="help-icon" title="Auction will be closed or open"></span></dd>
              </dl>
			  
			  
			  <dl class="plain" id="show_bidder" <?php if($auctionData->is_closed=='1') { echo $bchk='style="display:block;"';}else{echo $bchk='style="display:none;"';}?> >
                <dt class="required">
                  <label>Bidders</label>
                </dt>
                <dd> 
				<?php// print_r($closeBidderAuctionRows);?>
			<select name="bidders_list[]"  id="bidders_list"  class="select-text" multiple>
				   <option value="">Select Bidders</option>
                   <?php
						foreach($biddersrow as $bidder_row){
							
							if(count($closeBidderAuctionRows)>0)
							{
								
								if(in_array($bidder_row->id,$closeBidderAuctionRows)){
									$docsel='selected';	
								}else{
									$docsel='';		
								}
							}
						?>
						<option <?php echo $docsel; ?> value="<?php echo  $bidder_row->id ; ?>" > <?php echo ucfirst($bidder_row->bidder_name); ?> (<?php echo ucfirst($bidder_row->email_id); ?>)</option>
					<?php } ?>
					
            </select>
						
				  <span class="help-icon" title="Close auction Bidders"></span>
				</dd>
              </dl>
			  <?php } ?>
			  
			  <?php /* ?>
              <dl>
                <dt class="required">
                  <label>Bid Increment value</label>
                </dt>
                <dd>
                  <input name="bid_inc" maxlength="16" onkeypress="return isNumberKey(event);"  id="bid_inc" type="text" value="<?php echo $auctionData->bid_inc; ?>"  class="input">
                  <span class="help-icon" title="The value by which the bidding will increase at the time of Inter Se Bidding."></span> </dd>
              </dl>
              <?php */ ?>
              <dl>
                <dt class="required">
                  <label>Bid Increment value</label>
                </dt>
                <dd>
                   <select name="bid_inc[]" id="bid_inc1" onchange="chkvalue(this);">
                        <option value="">--Select--</option>   
                        <option value="5000">5000</option>   
                        <option value="10000">10000</option>   
                        <option value="15000">15000</option>  
                        <option value="others">Others</option>  
                     </select>
                  <!--<input name="bid_inc" maxlength="16" onkeypress="return isNumberKey(event);"  id="bid_inc" type="text" value="<?php  //echo $auctionData->bid_inc; ?>"  class="input">-->
                  <span class="help-icon" title="The value by which the bidding will increase at the time of Inter Se Bidding."></span> </dd>
              </dl>
              <dl id="show_text_box" style="display: none;">
                <dt class="required">
                  <label>Bid Increment value (others)</label>
                </dt>
                <dd>
                  <input name="bid_inc[]" maxlength="16" onkeypress="return isNumberKey(event);"  id="bid_inc2" type="text" value="<?php  //echo $auctionData->bid_inc; ?>"  class="input">
                  <span class="help-icon" title="The value by which the bidding will increase at the time of Inter Se Bidding."></span> </dd>
              </dl>  
              <dl>
                <dt>
                  <label>Auto Extension time (In Minutes.)</label>
                </dt>
                <dd>
                  <input maxlength="2" onkeypress="return isNumberKey(event);" name="auto_extension_time"  value="<?php echo $auctionData->auto_extension_time; ?>" id="auto_extension_time" size="2" type="text"  class="input">
                  <span class="help-icon" title="Time in minutes by which the auction will get extended if bid is received in last minutes. E.g. Lets say Auction Start Time is 11:00 AM, End Time is 12:00 PM and Auto Extention time is 5 minutes. If a bid is recieved at 11:58 then the end time of the auction will be extended till 12:03 and the process will continue."></span> </dd>
              </dl>
              <dl>
                <dt>
                  <label>No. Of Auto Extension(s)</label>
                </dt>
                <dd>
                  <input maxlength="2" onkeypress="return isNumberKey(event);" name="auto_extension" value="<?php echo $auctionData->no_of_auto_extn; ?>" id="auto_extension" type="text"   class="input">
                  <span class="help-icon" title="Please upload the related document by using browse button. The documents may be PoS, Sale Notice, T&C. if you have more than one document then please zip all those documents in a single file and then upload here."></span> </dd>
              </dl>
              
             
           
              <dl>
                <dt class="required">
                  <label>Identification document</label>
                </dt>
                <dd>
                  <select name="doc_to_be_submitted[]" id="doc_to_be_submitted" size="4" class="select-text">
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
                  <span class="help-icon" title="This is the higher authority. IF the event is SARFAECI then he/she may be the Senior officer from the bank. If the event is DRT he/She may be the DRT recovery officer. The dropdown will contain the name of the user depending upon the account you have chosen from top. (LIMIT 1 MB)"></span> </dd>
              </dl>
			  
			  
			  
              <div class="seprator btmrg20"></div>
			    <div class="button-row">
				 <a href="/owner/sellerPostPropety/<?php echo $propertyID?>"><input name="Back" value="Back" type="button" class="b_submit"> </a>
	
				<input name="Save" value="Next" onclick="return validateSubmitformNonBank('save');" type="submit" class="b_submit float-right">
			        <input type="hidden" name="propertyID" id="propertyID" value="<?php echo $propertyID?>">
			     <input type="hidden" name="auctionID" id="auctionID" value="<?php echo $auctionID; ?>">
					<input type="hidden" name="currdate" id="currdate" value="<?php echo date("Y-m-d H:i") ?>" />
				</div>
            </div>
			</form>
					</div>
                  </div>
                     </div>
                    </div>
                  </div>
                  <!-- Sell > My Activity end -->                  
                </div>
              </div>
            </div>
            <!---- Sell tab container end ----> 
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

<script>

  jQuery('#press_release_date').datetimepicker({
		controlType: 'select',
		maxDate: 0,
		oneLine: true,
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
		timeFormat: 'HH:mm:00'
	});
	
        
        
        
        
	jQuery('#inspection_date_to').datetimepicker({
		controlType: 'select',
		oneLine: true,
		changeMonth: true,
		changeYear: true,
		dateFormat: 'yy-mm-dd',
		timeFormat: 'HH:mm:00'
	});
	jQuery('#bid_last_date').datetimepicker({
		controlType: 'select',
		oneLine: true,
		changeMonth: true,
		changeYear: true,
		dateFormat: 'yy-mm-dd',
		timeFormat: 'HH:mm:00',
		yearRange: '2016:2017',
	});
	  jQuery('#bid_opening_date').datetimepicker({
		controlType: 'select',
		oneLine: true,
		changeMonth: true,
		changeYear: true,
		dateFormat: 'yy-mm-dd',
		timeFormat: 'HH:mm:00',
		yearRange: '2016:2017',
	});
	  jQuery('#auction_start_date').datetimepicker({
		controlType: 'select',
		oneLine: true,
		changeMonth: true,
		changeYear: true,
		dateFormat: 'yy-mm-dd',
		timeFormat: 'HH:mm:00',
		yearRange: '2016:2017',
	});
	jQuery('#auction_end_date').datetimepicker({
		controlType: 'select',
		oneLine: true,
		changeMonth: true,
		changeYear: true,
		dateFormat: 'yy-mm-dd',
		timeFormat: 'HH:mm:00',
		yearRange: '2016:2017',
	});
		jQuery('#nodal_bank_n').change(function(){
		var nodal_bank_n = jQuery(this).val();
		if(nodal_bank_n)
		{
			jQuery('#nodal_bank_name').val(nodal_bank_n);
		}
	});	
	
	jQuery('#category_id').change(function(){
		var category_id = jQuery(this).val();
		if(category_id)
		{
			jQuery('#subcategory_id').load('/owner/getsubcategory/'+category_id);
		}
		
	});	
	jQuery('#invoice_mail_to').change(function(){
		var invoice_mail_to = jQuery(this).val();
		if(invoice_mail_to)
		{
			jQuery('#invoice_mailed').load('/owner/invoice_mail_to_user/'+invoice_mail_to);
		}
		
	});	
	
	jQuery('.nodalbank').click(function(){
		var nodalbank = jQuery(this).val();
		if(nodalbank)
		{
			if(nodalbank=='others'){
				jQuery('#nodal_bank_n').prop( "disabled", false );	
			}else{
				var bank_id = jQuery("#bank_id").val();
				jQuery('#nodal_bank_name').val(bank_id);
				jQuery('#nodal_bank_n').prop( "disabled", true );			
			}
		}
		
	});
   	
  //tooltip
  jQuery(function() {
   var setvalue='<?=$auctionData->bid_inc;?>';
   
  
    if(setvalue != '')
    { 
   if(setvalue=='5000.00'||setvalue=='10000.00'||setvalue=='15000.00' ){
        
        $("#bid_inc1").prop('value', parseInt(setvalue));
        
              
    }else{
      $("#bid_inc1").prop('value','others'); 
      $("#bid_inc1").trigger('change');
      setTimeout(function(){ $("#bid_inc2").prop('value',setvalue); }, 1000);
      }
  }

    jQuery('.help-icon').tooltip();
  });

  function chkvalue(id){ 
      if(id.value=='others'){
       $("#show_text_box").css('display','block');   
        }else{
       $("#bid_inc2").prop('value','');   
       $("#show_text_box").css('display','none');  
          
      }
      
  }

/*
     jQuery(document).on('change','#related_doc',function(){
          files = this.files;
          size = files[0].size;
          //max size 50kb => 50*1000
          if( size > 50*1000){
             alert('Please upload less than 50kb file');
			 jQuery("#related_doc").val('');
             return false;
          }
          return true;
     });
    
  */

 
 
</script>

