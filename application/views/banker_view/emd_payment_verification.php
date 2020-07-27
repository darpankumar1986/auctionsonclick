<link rel="stylesheet" href="<?php echo base_url();?>assets/css/jquery.dataTables.css" type="text/css" media="screen"/>	
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery.dataTables.min.js"></script>
<script>
	jQuery(document).ready(function(){
	jQuery(".tenderfee_detail_iframe").colorbox({iframe:true, width:"80%", height:"70%"});	
	jQuery(".emd_detail_iframe").colorbox({iframe:true, width:"70%", height:"50%"});	
});
</script>
<section class="container_12">
  <?php //echo $breadcrumb;?>
  <form id="bidopenerfrm1" name="submitdoc" action="/buyer/add_bidder_auction" method="post" enctype="multipart/form-data" >
	  <!-- onsubmit="return validateopenerfrm('bidopenerfrm1');-->
  <div class="row">
    <div class="wrapper-full">
      <div class="dashboard-wrapper">
        <div id="tab-pannel3" class="btmrgn">
          <div class="tab_container3">
            
            
            <!-- #tab1 -->
            <div id="tab6" class="tab_content3">
              <div class="container">
                <?php //echo $leftPanel?>
                <div class="secttion-right">
					<?php 					
					if($this->session->userdata('role_id')==3) { ?>
                  <div class="table-wrapper btmrg20">
                    <div class="table-heading btmrg">
					<?php if(isset($this->session->userdata['flash:old:message'])){?>
						<div class="success_msg"> <?php echo @$this->session->userdata['flash:old:message']; ?></div>
					<?php } ?>
					<?php //if(isset($this->session->userdata['flash:old:message_new'])){?>
						<div class="message_new" style="color:red;text-align:center;font-size:14px;"> <?php echo @$this->session->userdata['flash:old:message_new']; ?></div>
					 <?php //} ?>
                      <div class="box-head"><?php echo "EMD/Payment Verification"?></div>
                      <!--<div class="srch_wrp2">
                        <input type="text" value="Search" id="search" name="search">
                        <span class="ser_icon"></span> </div>-->
                    </div>
                    <div style="min-height: 0px; display: block;" class="box-content no-pad table-tp-space"> 
					

<div class="container-outer">
<div class="container-inner">
	<table border="1" align="left" cellpadding="2" cellspacing="1" class="mytable dataTable" id="big_table5" aria-describedby="big_table_info">
					<thead>
					<tr class="odd">
						<td width="5%" align="left" valign="top" class=""><strong><input type="checkbox" name="selectAll" id="selectAll" value="1"/></strong></td>
						<td width="5%" align="left" valign="top" class=""><strong>S/No.</strong></td>
						<!--<td width="10%" align="left" valign="top" class=""><strong>Reference No.</strong></td>                                                
						<td width="15%" align="left" valign="top" class=""><strong>Bidder Name </strong></td> -->
						<td width="15%" align="left" valign="top" class=""><strong>Fee Payable </strong></td>
						<td width="15%" align="left" valign="top" class=""><strong>Fee Paid </strong></td>
                                                <td width="15%" align="left" valign="top" class=""><strong>Transaction Date</strong></td>
						<td width="30%" align="left" valign="top" class=""><strong>Breakdown (Click on Hyperlink to view)</strong></td>
						<!--<td width="30%" align="left" valign="top" class=""><strong>View EMD Docs </strong></td>-->
						<td width="15%" align="left" valign="top" class=""><strong>Action </strong></td>
						<td width="30%" align="left" valign="top" class=""><strong>Comments<span style="color:red">*</span> </strong></td>
					</tr>
					</thead>
					<tbody role="alert" aria-live="polite" aria-relevant="all">
					<?php 					
					//echo '<pre>';print_r($auction_data[0]->bider_detail);
					
					if(count($bidders[0]->bider_detail)){
					foreach($bidders[0]->bider_detail as $key=>$bider_detail)
					{	
							
						$payment_detail = json_decode(GetTitleByField('tbl_jda_payment_log', "auction_id='".$bider_detail->auctionID."' and bidder_id='".$bider_detail->bidderID."' ORDER BY payment_log_id DESC",'payment_response'));
							
							
					?>
						<tr class="even">							
							<td width="5%" align="left" valign="top" class=""><input type="checkbox" class="case" value="<?php echo $bider_detail->id;?>" name="participate_id[]"></td>
							<td width="5%" align="left" valign="top" class=""><?php echo ++$key?></td>
								<!--<td width="10%" align="left" valign="top" class=""><?php echo $bider_detail->emd_detail[0]->control_number; ?></td>								
								 <td width="15%" align="left" valign="top" class="">
									<?php /*
									if( GetTitleById('tbl_user_registration',$bider_detail->bidderID,'register_as')=='builder')
									{
									   echo GetTitleById('tbl_user_registration',$bider_detail->bidderID,'organisation_name'); 
									}else
									{
									  echo GetTitleById('tbl_user_registration',$bider_detail->bidderID,'first_name'); //echo ' '.$bider_detail->reference_no;  
									} */
								?>
								</td> -->
								<td width="10%" align="left</td>" valign="top" class="">
								<?php 
									//echo GetTitleByField('tbl_auction',"id='".$bider_detail->auctionID."'",'tender_fee');
									$emdfee = GetTitleByField('tbl_auction',"id='".$bider_detail->auctionID."'",'emd_amt');
									//echo $emdfee + BANK_PROCESSING_FEE + ADMINISTRATIVE_FEE;
									echo BANK_PROCESSING_FEE;
									
								?>
								</td>
								<td width="10%" align="left</td>" valign="top" class=""><?php 
								if(LOCAL_URL == false)
								{
									//echo GetTitleByField('tbl_auction_participate_emd',"bidderID='".$bider_detail->bidderID."' and auctionID='".$bider_detail->auctionID."'",'amount'); 	
									 								
									$jpr = json_decode($bider_detail->emd_detail[0]->payment_response);
										
									//echo $emdfee + (int)$jpr->amount  + ADMINISTRATIVE_FEE;
									echo (float)$jpr->mer_amount;
									
								}
								else
								{
										$jpr = json_decode($bider_detail->emd_detail[0]->payment_response);
										echo (float)$jpr->mer_amount;
								}
   
								?>
							  </td>
							<td width="10%" align="left" valign="top" class="">
								<?php if($payment_detail !='' && $payment_detail != NULL) {
									//echo date('d-m-Y H:i:s', strtotime($payment_detail->addedon));
									echo $resDate = str_replace('/','-',$payment_detail->trans_date);
									} ?></td>
   
                           
							<td width="30%" align="left" valign="top" class="" >							
							<?php 
							if(LOCAL_URL == true)
							{
							?>
								<a class='emd_detail_iframe' href="/buyer/emdDetailPopup/<?php echo $bider_detail->bidderID;?>/<?php echo $bider_detail->auctionID;?>">Success</a>
							<?php							
							}
							else
							{
							?>
								<!--<a class='emd_detail_iframe' href="/buyer/emdDetailPopup/<?php echo $bider_detail->bidderID;?>/<?php echo $bider_detail->auctionID;?>"><?php echo ucfirst($bider_detail->emd_detail[0]->payment_status);?></a>-->
								<a class='emd_detail_iframe' href="/buyer/emdDetailPopup/<?php echo $bider_detail->bidderID;?>/<?php echo $bider_detail->auctionID;?>">View</a>
							<?php
							}
                            ?>
								
							</td>
							
							<!--<td>							
								<a class='tenderfee_detail_iframe' href="/buyer/emdDocDetailPopup/<?php echo $bider_detail->bidderID;?>/<?php echo $bider_detail->auctionID;?>">EMD Docs</a>
							</td>-->
							
							<!--<td width="15%" align="left" valign="top" class="" >
								<?php echo ($bider_detail->payment_verifier_accepted==1)?'Accepted':'Rejected';?>
							</td>
							<td width="30%" align="left" valign="top" class="" >
								<?php echo $bider_detail->payment_verifier_comment; ?>
							</td>-->
							
							<td width="15%" align="left" valign="top" class="" >
							<select class="bid_acceptance"  name="bid_acceptance[]" id ="acpt_<?php echo $bider_detail->id;?>" disabled >
								<option value="1" <?php if($bider_detail->payment_verifier_accepted==1){ echo 'selected="selected"'; }?>>Accept</option>
								<option value="2" <?php if($bider_detail->payment_verifier_accepted==0 && $bider_detail->payment_verifier_comment!=''){ echo 'selected="selected"'; }?>>Reject</option>
							</select>
							</td>
							<td width="30%" align="left" valign="top" class="" >
								<textarea class="txtComment" style="width:200px;" tabindex="2" cols="20" rows="2" name="txtComment[]" id="cmt_<?php echo $bider_detail->id;?>" disabled ><?php echo $bider_detail->payment_verifier_comment; ?></textarea>
								<input type="hidden"  value="<?php echo $bider_detail->bidderID;?>" name="bidderID[]">
								<div style="color:red;font-size:10px;" class="cmt_err_div" id="cmt_err_<?php echo $bider_detail->id;?>"></div>
							</td>
						</tr>
					<?php 
						}
					}
					else
					{
					?>
					<tr>
						<td colspan="5">No Bidder.</td>
					</tr>
					<?php 
					}
					?>
					</tbody>     
					<?php 
					//echo "<pre>";print_r($auction_data[0]->bider_detail);
					
					?>
					<tr>
						<td colspan="10">
							<input type="hidden" value="<?php echo $user_id; ?>" name="payment_verifier">
							
							<input type="hidden" value="<?php echo $bidders[0]->bider_detail[0]->auctionID;?>" name="auctionID">
							<?php 
							/*				
							if($isAccepted2){?>		
								<a href="javascript:void(0);" onclick="move_to_approver(<?php echo $auction_data[0]->id?>);"><input name="Move To Approver" value="Move To Approver" type="button" class="button_grey b_publish2 float-right"></a>
															
								<input name="submit" value="Update" type="submit" class="button_grey b_submit float-right" style="float:right;">
							<?php 
							}else{*/
							?>
								<input name="submit" value="Move To Approver" type="submit" class="addBidder button_grey b_submit float-right" style="float:right;">
							<?php //} ?>
							 <!--<input name="Save" value="Back" onclick="window.location.href='<?=base_url();?>buyer/'"  type="button" class="button_grey">-->
						</td>
					</tr>
				        
			</table>
						<?php 
						
						//echo "<pre>";
						//print_r($bidders);
					?>
					</div></div>
					</div>
                  </div>
                  
                </div>
                <?php } ?>
                
						<?php 
						
						//echo "<pre>";
						//print_r($bidders);
					?>
					</div></div>
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
  </form>
</section>
<script>
	$(document).ready(function() {
    var $selectAll = $('#selectAll'); // main checkbox inside table thead
    var $table = $('.mytable'); // table selector 
    var $tdCheckbox = $table.find('tbody input:checkbox'); // checboxes inside table body
    var $tdtextarea = $table.find('tbody textarea'); // textarea inside table body
    var $tdtextsel = $table.find('tbody select'); // select inside table body
    
    var $tdCheckboxChecked = []; // checked checbox arr

    //Select or deselect all checkboxes on main checkbox change
    $selectAll.on('click', function () {
		$('.message_new').html('');
		$('.cmt_err_div').html('');
        $tdCheckbox.prop('checked', this.checked);
        var pId = $(this).val();
		if(this.checked){			
			$($tdtextarea).attr("disabled", false);
			$($tdtextsel).attr("disabled", false);
		  }
		  else{
			$($tdtextarea).attr("disabled", true);
			$($tdtextsel).attr("disabled", true);
		  }
    });

    //Switch main checkbox state to checked when all checkboxes inside tbody tag is checked
    $tdCheckbox.on('change', function(){
		var pId = $(this).val();
		if(this.checked){					
			$('#cmt_'+pId).attr("disabled", false);
			$('#acpt_'+pId).attr("disabled", false);			
		  }
		  else{
			$('#cmt_'+pId).attr("disabled", true);
			$('#acpt_'+pId).attr("disabled", true);
		  }
		$('.message_new').html('');
		$('#cmt_err_'+pId).html('');
        $tdCheckboxChecked = $table.find('tbody input:checkbox:checked');//Collect all checked checkboxes from tbody tag
    //if length of already checked checkboxes inside tbody tag is the same as all tbody checkboxes length, then set property of main checkbox to "true", else set to "false"
    //alert($tdCheckboxChecked.length +' | '+ $tdCheckbox.length);
        $selectAll.prop('checked', ($tdCheckboxChecked.length == $tdCheckbox.length));
        
    });
});

$(document).on('click','.addBidder',function(){

	var err = false;
	var chkd = $('.mytable').find('tbody input:checkbox:checked');
	if(chkd.length == 0)
	{
		err = true;
		$('.message_new').html("Please select atleast one bidder");
	}
	if(chkd.length>0)
	{	
		$.each($("input[class='case']:checked"),function(){
			var pId = $(this).val();			
			var txtboxVal = $('#cmt_'+pId).val().trim();				
			if(txtboxVal =='')
			{
				err = true;
				$('#cmt_err_'+pId).html("Please enter your comments for selected bidder");
			}
		});
	}
	if(err)
	{
		return false;
	}
	
});
</script>

