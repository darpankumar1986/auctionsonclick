<link rel="stylesheet" href="<?php echo base_url();?>assets/css/jquery.dataTables.css" type="text/css" media="screen"/>	
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery.dataTables.min.js"></script>
<style>
	.hidetd{display:none;}
</style>
<script>
	jQuery(document).ready(function(){
	jQuery(".tenderfee_detail_iframe").colorbox({iframe:true, width:"80%", height:"70%"});	
	jQuery(".emd_detail_iframe").colorbox({iframe:true, width:"70%", height:"50%"});	
});
</script>
<section class="container_12">
  <?php  
 $auctionID = $this->uri->segment(3);
 $contact_ids = 0;
if($meeting['contact_ids'] != '')
{
	$contact_ids = $meeting['contact_ids'];
}

  ?>
  
  <script type="text/javascript">

        $(document).ready(function() 
        {
			
			
			//$("#buyerdata thead tr th").eq(0).addClass("hidetd");
			$("#bidderListData thead tr th").eq(1).addClass("hidetd");
			var oTable = $('#bidderListData').dataTable({
					"bAutoWidth": false,
					"aoColumns": [{"sWidth": "5%"}, {"sWidth": "10%"}, {"sWidth": "8%"}, {"sWidth": "8%"}, {"sWidth": "8%"},{"sWidth": "8%"},{"sWidth": "8%"},{"sWidth": "8%"},{"sWidth": "8%"},{"sWidth": "8%"}],
					"bProcessing": true,
					"bServerSide": true,
					"sAjaxSource": '<?php echo base_url(); ?>buyer/mastercontactdata/<?php echo $auctionID;?>',
                    "aoColumnDefs": [ { "bSortable": false, "aTargets": [0,7,8,9] } ],      
					"sPaginationType": "full_numbers",
					"iDisplayStart ": 10,
					"aaSorting": [[ 0, "desc" ]],
					"oLanguage": {
						"sProcessing": "<img src='<?php echo base_url(); ?>assets/images/ajax-loader_dark.gif'>"
					},
					"fnInitComplete": function () {
						$('#big_table_paginate').addClass('oneTemp');
						$('#big_table_info').addClass('oneTemp');
						$('.oneTemp').wrapAll('<div class="tableFooter">');
						$('select[name="big_table_length"]').insertAfter('#big_table_length > label');
					   
					},
					'fnServerData': function (sSource, aoData, fnCallback)
					{
						$.ajax
								({
									'dataType': 'json',
									'type': 'POST',
									'url': sSource,
									'data': aoData,
									'success': fnCallback
								});
					},
					"fnRowCallback": function (nRow, aData, iDisplayIndex) {
						//$('td:eq(0)', nRow).addClass("hidetd");
						$('td:eq(1)', nRow).addClass("hidetd");
						if(aData[0]!='null')
						{
							var chkInpt = '<input type="checkbox" onclick="manageBidderIds('+aData[0]+')" class="case" value="'+aData[0]+'" name="participate_id[]" id="part_'+aData[0]+'">';
							
							if(aData[8] ==null)
							{
								aData[8] ='';
							}
							var txtArea = '<textarea class="txtComment" style="width:200px;" tabindex="2" cols="20" rows="2" name="txtComment[]" id="cmt_'+aData[0]+'">'+aData[8]+'</textarea><input type="hidden"  value="'+aData[2]+'" name="bidderID[]"><div style="color:red;font-size:10px;" class="cmt_err_div" id="cmt_err_'+aData[0]+'"></div>';
							
													
							var selectBx = '<select class="bid_acceptance"  name="bid_acceptance[]" id ="acpt_'+aData[0]+'"><option value="1" >Accept</option><option value="2" >Reject</option></select>';
							
						}
						
						
						$('td:eq(0)', nRow).html(chkInpt);
						$('td:eq(1)',nRow).css('text-transform','capitalize');												
						$('td:eq(7)',nRow).html(selectBx);
						$('td:eq(8)',nRow).html(txtArea);
						
						return nRow;
					  }
				});
          });     
</script>
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
                if($this->session->userdata('role_id')==5) {
					
                $auctionID = $this->uri->segment(3);
				$doc_to_be_submitted = GetTitleById('tbl_auction',$auctionID,'doc_to_be_submitted'); 
				 ?>
                <div class="table-wrapper btmrg20">
                    <div class="table-heading btmrg">
					<?php if(isset($this->session->userdata['flash:old:message'])){?>
						<div class="success_msg"> <?php echo @$this->session->userdata['flash:old:message']; ?></div>
					<?php } ?>
					<?php //if(isset($this->session->userdata['flash:old:message_new'])){?>
						<div class="message_new" style="color:red;text-align:center;font-size:14px;"> <?php echo @$this->session->userdata['flash:old:message_new']; ?></div>
					 <?php //} ?>
                      <div class="box-head"><?php echo "Document Verification"; ?></div>
                      <!--<div class="srch_wrp2">
                        <input type="text" value="Search" id="search" name="search">
                        <span class="ser_icon"></span> </div>-->
                    </div>
                    <div style="min-height: 0px; display: block;" class="box-content no-pad table-tp-space"> 
					

<div class="container-outer">
<div class="container-inner">
	<table border="1" align="left" cellpadding="2" cellspacing="1" class="mytable dataTable" id="big_table" aria-describedby="big_table_info">
					<thead>
						
					<tr class="odd">
						<td width="10%" align="left" valign="top" class=""><strong><input type="checkbox" name="selectAll" id="selectAll" value="1"/></strong></td>
						<td width="10%" align="left" valign="top" class=""><strong>S/No.</strong></td>
						<td width="15%" align="left" valign="top" class=""><strong>Bidder Name </strong></td>
						<td width="30%" align="left" valign="top" class=""><strong>View </strong></td>
						<td width="15%" align="left" valign="top" class=""><strong>Action </strong></td>
						<td width="30%" align="left" valign="top" class=""><strong>Comments<span style="color:red;">*</span></strong></td>
					</tr>
					</thead>
					<tbody role="alert" aria-live="polite" aria-relevant="all">
					<?php 					
					//echo '<pre>';print_r($bidders);
					
					if($doc_to_be_submitted ==0)
					{
						?>
					<tr>
						<td colspan="6">Document Verification not required for this Auction</td>
						
					</tr>					
					<?php 
					}
					else if(count($bidders[0]->bider_detail))
					{
						foreach($bidders[0]->bider_detail as $key=>$bider_detail){
					
						
					?>
						<tr class="even">
							<td width="10%" align="left" valign="top" class=""><input type="checkbox" class="case" value="<?php echo $bider_detail->id;?>" name="participate_id[]"></td>
							<td width="10%" align="left</td>" valign="top" class=""><?php echo ++$key?></td>
							<td width="15%" align="left" valign="top" class="">
								<?php if(GetTitleById('tbl_user_registration',$bider_detail->bidderID,'register_as')=='owner'){ ?>
							    <?php echo GetTitleById('tbl_user_registration',$bider_detail->bidderID,'first_name')?>
								<?php }else{ ?>
								<?php echo GetTitleById('tbl_user_registration',$bider_detail->bidderID,'organisation_name')?>
								<?php }?>
							</td>
							<!--<td width="20%" align="left" valign="top" class="">
								<?php //echo ($bider_detail->payment_verifier_accepted)?'Accepted':'Rejected'; ?>
							</td>
							<td width="30%" align="left" valign="top" class="">
								<?php //echo $bider_detail->payment_verifier_comment; ?>
							</td>-->
							<td width="30%" align="left" valign="top" class="" >							
							<a class='tenderfee_detail_iframe' href="/buyer/docDetailPopup/<?php echo $bider_detail->bidderID;?>/<?php echo $auctionID;?>">Docs</a>
							
							</td>
							<td width="15%" align="left" valign="top" class="" >
							<select class="bid_acceptance"  name="bid_acceptance[]" id ="acpt_<?php echo $bider_detail->id;?>" disabled>
							<option value="1" <?php if($bider_detail->operner1_accepted==1){ echo 'selected="selected"'; }?>>Accept</option>
							<option value="2" <?php if($bider_detail->operner1_accepted==0 && $bider_detail->operner1_comment!=''){ echo 'selected="selected"'; }?>>Reject</option>
							</select>
							</td>
							<td width="30%" align="left" valign="top" class="" >
							<textarea class="txtComment" style="width:200px;" tabindex="2" cols="20" rows="2" name="txtComment[]" id="cmt_<?php echo $bider_detail->id;?>" disabled><?php echo $bider_detail->operner1_comment; ?></textarea>							
							<input type="hidden" value="<?php echo $bider_detail->bidderID;?>" name="bidderID[]">	
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
					<tr>
						<td colspan="7">
							<input type="hidden" value="<?php echo $auction_data[0]->second_opener?>" name="doc_verifier">
							
							<input type="hidden" value="<?php echo $auctionID;?>" name="auctionID">
							
							<?php
							/*
							if($isAccepted3){
							?>
								<a href="javascript:void(0);" onclick="move_to_approver(<?php echo $auctionID; ?>);"><input name="Move To Approver" value="Move To Approver" type="button" class="button_grey b_publish2 float-right"></a>
							
								<input name="submit" value="Update" type="submit" class="button_grey b_submit float-right" style="float:right;">
							<?php 
							}
							else
							{*/
							?>
								<input name="submit" value="Move To Approver" type="submit" class="addBidder button_grey b_submit float-right" style="float:right;">								
							<?php 
							//}
							?>
							 <input name="Save" value="Back" onclick="window.location.href='<?=base_url();?>buyer/eventTrack/<?php echo $auctionID;?>'"  type="button" class="button_grey">
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
                
              </div>
            </div>
            <?php } ?>
            
            <?php if($this->session->userdata('role_id')==2) { 
				    $auctionID = $this->uri->segment(3);
					$doc_to_be_submitted = GetTitleById('tbl_auction',$auctionID,'doc_to_be_submitted'); 
					
				?>
                <div class="table-wrapper btmrg20">
                    <div class="table-heading btmrg">
					<?php if(isset($this->session->userdata['flash:old:message'])){?>
						<div class="success_msg"> <?php echo @$this->session->userdata['flash:old:message']; ?></div>
					<?php } ?>
					<?php //if(isset($this->session->userdata['flash:old:message_new'])){?>
						<div class="message_new" style="color:red;text-align:center;font-size:14px;"> <?php echo @$this->session->userdata['flash:old:message_new']; ?></div>
					 <?php //} ?>
                      <div class="box-head"><?php echo "Final Approver"; ?></div>
                      <!--<div class="srch_wrp2">
                        <input type="text" value="Search" id="search" name="search">
                        <span class="ser_icon"></span> </div>-->
                    </div>
                    <div style="min-height: 0px; display: block;" class="box-content no-pad table-tp-space"> 
					

<div class="container-outer">
<div class="container-inner">
	<table border="1" align="left" cellpadding="2" cellspacing="1" class="mytable dataTable" id="big_table" aria-describedby="big_table_info">
				<thead>
					<tr class="odd">
						<td width="10%" align="left" valign="top" class=""><strong><input type="checkbox" name="selectAll" id="selectAll" value="1"/></strong></td>
						<td width="10%" align="left" valign="top" class=""><strong>S/No.</strong></td>
						<td width="15%" align="left" valign="top" class=""><strong>Bidder Name </strong></td>
						<!-- <td width="30%" align="left" valign="top" class=""><strong>View </strong></td> -->
                        <td width="30%" align="left" valign="top" class=""><strong>Breakdown (Click on Hyperlink to view)</strong></td>
						<td width="20%" align="left" valign="top" class=""><strong>Payment Verifier Action </strong></td>
						<td width="30%" align="left" valign="top" class=""><strong>Payment Verifier Comments </strong></td>
						<?php if($doc_to_be_submitted == 0){}else{ ?>
                        <td width="30%" align="left" valign="top" class=""><strong>View Docs </strong></td>
						<td width="15%" align="left" valign="top" class=""><strong>Document Verifier Action </strong></td>
						<td width="30%" align="left" valign="top" class=""><strong>Document Verifier Comments </strong></td>
						<?php } ?>
						<!--<td width="30%" align="left" valign="top" class=""><strong>View EMD Docs </strong></td>-->
						<?php
							//if($bider_detail->payment_verifier_accepted !=null && $bider_detail->operner1_accepted != null)
							{
							?>						
							<td width="15%" align="left" valign="top" class=""><strong>Action </strong></td>						
							<td width="30%" align="left" valign="top" class=""><strong>Comments<span style="color:red">*</span> </strong></td>
						<?php } ?>
					</tr>
				</thead>
				<tbody role="alert" aria-live="polite" aria-relevant="all">
					<?php 					
					//echo '<pre>';print_r($bider_detail->payment_verifier_accepted);die;
					
					if(count($bidders[0]->bider_detail)){
						foreach($bidders[0]->bider_detail as $key=>$bider_detail){
						
					?>
						<tr class="even">
							<td width="10%" align="left" valign="top" class=""><input type="checkbox" class="case" value="<?php echo $bider_detail->id;?>" name="participate_id[]"></td>
							<td width="10%" align="left" valign="top" class=""><?php echo ++$key?></td>
							<td width="15%" align="left" valign="top" class="">
							<?php 
							if( GetTitleById('tbl_user_registration',$bider_detail->bidderID,'register_as')=='builder'){
							   echo GetTitleById('tbl_user_registration',$bider_detail->bidderID,'organisation_name'); 
							  }else{
							  echo GetTitleById('tbl_user_registration',$bider_detail->bidderID,'first_name');  
							}
							?></td>
							<td width="30%" align="left" valign="top" class="" >
								<?php if(LOCAL_URL == true){ ?>
							    <a class='emd_detail_iframe' href="/buyer/emdDetailPopup/<?php echo $bider_detail->bidderID;?>/<?php echo $bider_detail->auctionID;?>">Success</a>
							<?php } else {
							   // $pamt_status = GetTitleByField('tbl_jda_payment_log',"auction_id='".$bider_detail->auctionID."' and bidder_id='".$bider_detail->bidderID."' ORDER BY payment_log_id DESC LIMIT 1",'payment_status');
								?>
								<!--<a class='emd_detail_iframe' href="/buyer/emdDetailPopup/<?php echo $bider_detail->bidderID;?>/<?php echo $auctionID;?>"><?php echo ucfirst($bider_detail->emd_detail[0]->payment_status);?></a>-->
								<a class='emd_detail_iframe' href="/buyer/emdDetailPopup/<?php echo $bider_detail->bidderID;?>/<?php echo $auctionID;?>">View</a>
							<?php } ?>
							<!--|
							<a class='doc_detail_iframe' href="/buyer/tenderfeeDetailPopup/<?php echo $bider_detail->bidderID;?>/<?php echo $bider_detail->auctionID;?>">Fee</a>-->
							</td>
                                                        
							<td width="20%" align="left" valign="top" class="">
								<?php
									if($bider_detail->payment_verifier_accepted==1)
									{
										echo 'Accepted';
									}
									else if($bider_detail->payment_verifier_accepted==null)
									{
										echo '';
									}
									else if($bider_detail->payment_verifier_accepted==0)
									{
										echo 'Rejected';
									}
								 
								 ?>
							</td>
							<td width="30%" align="left" valign="top" class="">
								<?php echo $bider_detail->payment_verifier_comment; ?>
							</td>
							<?php if($doc_to_be_submitted == 0){}else{ ?>
								<td>							
									<a class='tenderfee_detail_iframe' href="/buyer/docDetailPopup/<?php echo $bider_detail->bidderID;?>/<?php echo $auctionID;?>">Docs</a>
								</td>
								<td width="15%" align="left" valign="top" class="" >
								<?php 
									if($bider_detail->operner1_accepted==1)
									{
										echo 'Accepted';
									}
									else if($bider_detail->operner1_accepted==null)
									{
										echo '';
									}
									else if($bider_detail->operner1_accepted==0)
									{
										echo 'Rejected';
									}
								?>
							</td>
							
							
							<td width="30%" align="left" valign="top" class="" >
								<?php echo $bider_detail->operner1_comment; ?>
							</td>

							<?php } ?>
							<!--<td>							
								<a class='tenderfee_detail_iframe' href="/buyer/emdDocDetailPopup/<?php echo $bider_detail->bidderID;?>/<?php echo $auctionID;?>">EMD Docs</a>
							</td>-->
							<?php
							//if($bider_detail->payment_verifier_accepted !=null && $bider_detail->operner1_accepted != null)
							{
							?>
							<td width="15%" align="left" valign="top" class="" >
							<select class="bid_acceptance"  name="bid_acceptance[]" id ="acpt_<?php echo $bider_detail->id;?>" disabled>
								<option value="1" <?php if($bider_detail->operner2_accepted==1){ echo 'selected="selected"'; }?>>Accept</option>
								<option value="2" <?php if($bider_detail->operner2_accepted==0 && $bider_detail->operner2_comment!=''){ echo 'selected="selected"'; }?>>Reject</option>
							</select>
							</td>
							
							<td width="30%" align="left" valign="top" class="" >
								<textarea class="txtComment" style="width:200px;" tabindex="2" cols="20" rows="2" name="txtComment[]" id="cmt_<?php echo $bider_detail->id;?>" disabled><?php echo $bider_detail->operner2_comment; ?></textarea>
								<input type="hidden"  value="<?php echo $bider_detail->bidderID;?>" name="bidderID[]">
								<div style="color:red;font-size:10px;" class="cmt_err_div" id="cmt_err_<?php echo $bider_detail->id;?>"></div>
							</td>
							<?php
							 } ?>
						</tr>
					<?php 
						}
					}
					else
					{
					?>
					<tr>
						<td colspan="7">No Bidder.</td>
					</tr>
					<?php 
					}
					?>
					</tbody>     
					<?php 
					
					//if($isMovedtoAuction != 1)
					{
						$second_opener = GetTitleById('tbl_auction',$auctionID,'second_opener');  
					?>
						<tr>
							<td colspan="11">
								<input type="hidden" value="<?php echo $second_opener;?>" name="second_opener">
								
								<input type="hidden" value="<?php echo $auctionID;?>" name="auctionID">
								
								<?php
								//if($bider_detail->payment_verifier_accepted !=null && $bider_detail->operner1_accepted != null)
								{	/*								
									if($isAccepted2){
										$currentStatus =2;
										$reserve_price = GetTitleById('tbl_auction',$bidders[0]->bider_detail[0]->auctionID,'reserve_price');  
									?>
										
										<a id="set_opening_price1" href="javascript:void(0);" onclick="set_opening_price(<?php echo $auctionID;?>, '<?php echo $reserve_price; ?>', '<?php echo $currentStatus;?>');"><input name="Save" value="Move To Auction" type="button" class="button_grey b_publish2 float-right"></a>
									<?php
									}
									?>
									
									<?php
									
									if($isAccepted2){
									?>
										<input name="submit" value="Update" type="submit" class="addBidder button_grey b_submit float-right" style="float:right;">
									<?php 
									}else{
									*/ 
									?>
										<input name="submit" value="Proceed" type="submit" class="addBidder button_grey b_submit float-right" style="float:right;"> <!-- Move To Auction -->
									<?php //}
								}
								
								?>
								 <input name="Save" value="Back" onclick="window.location.href='<?=base_url();?>buyer/eventTrack/<?php echo $auctionID;?>'"  type="button" class="button_grey">
							</td>
						</tr>
					<?php }?>
				        
			</table>
			<br><br><br>
						<?php 
						/*
								//set table id in table open tag
								$tmpl = array ( 'table_open'  => '<table id="bidderListData" border="1" cellpadding="2" cellspacing="1" class="mytable">' );
								$this->table->set_template($tmpl); 

								$this->table->set_heading('Select','BidderID','Email','Payment Verifier Action','Payment Verifier Comments','Document Verifier Action','Document Verifier Comments','Action','Comments','View');
								echo $this->table->generate(); 
						*/	
						  ?>
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
            <?php } ?>
            
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

