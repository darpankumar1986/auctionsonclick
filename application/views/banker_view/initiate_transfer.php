<link rel="stylesheet" href="<?php echo base_url();?>assets/css/jquery.dataTables.css" type="text/css" media="screen"/>	
<link rel="stylesheet" href="<?php echo base_url()?>js/calender/jquery-ui.css">
<script src="<?php echo base_url(); ?>js/calender/jquery-ui.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>js/calender/jquery-ui-timepicker-addon.min.js"></script>
<link rel="stylesheet" href="<?php echo base_url()?>js/calender/jquery-ui-timepicker-addon.css">
<link rel="stylesheet" href="<?php echo base_url()?>/css/colorbox.css" />
<script src="<?php echo base_url()?>/js/jquery.colorbox.js"></script>
<!--
<script type="text/javascript" src="<?php echo VIEWBASE?>js/plugins/jquery.uniform.min.js"></script>
<script type="text/javascript" src="<?php echo VIEWBASE?>js/plugins/jquery.validate.min.js"></script>
<script type="text/javascript" src="<?php echo VIEWBASE?>js/custom/forms.js"></script>
-->

<style>
    table.dataTable td{
            padding: 5px 5px;
    }
    
    .rfq-loader {
        border: 6px solid #f3f3f3;
        border-radius: 50%;
        border-top: 6px solid #CC3313;
        width: 30px;
        height: 30px;
        -webkit-animation: spin 2s linear infinite;
        animation: spin 2s linear infinite;
        float: right;
        display:none;
        margin-right: 5%;
    }

    @-webkit-keyframes spin {
        0% { -webkit-transform: rotate(0deg); }
        100% { -webkit-transform: rotate(360deg); }
    }

    @keyframes spin {
        0% { transform: rotate(0deg); }
        100% { transform: rotate(360deg); }
    }
    
    
</style>
<?php 
	//echo "<pre>";print_r($bidderData);die;
?>
<section class="container_12">
  <?php   
  //echo $breadcrumb;?>
  <form id="bidopenerfrm1" name="frm_init_trans" action="<?php echo base_url()?>buyer/save_initiate_transfer" method="post" enctype="multipart/form-data" >
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
					//if($this->session->userdata('role_id')==3) 
					{ 
					?>
                  <div class="table-wrapper btmrg20">
                    <div class="table-heading btmrg">
					<?php if(isset($this->session->userdata['flash:old:message'])){?>
						<div class="success_msg"> <?php echo @$this->session->userdata['flash:old:message']; ?></div>
					<?php } ?>
					<?php if(isset($this->session->userdata['flash:old:error_msg'])){?>
						<div class="fail_msg"> <?php echo @$this->session->userdata['flash:old:error_msg']; ?></div>
					 <?php } ?>
                      <div class="box-head">Initiate Transfer</div>
                      <!--<div class="srch_wrp2">
                        <input type="text" value="Search" id="search" name="search">
                        <span class="ser_icon"></span> </div>-->
                    </div>
                    
                    <div class="outer">
						<div class="full_acct">
							<div class="half_acct">
								<div class="row_acct">
									<label>Auction Id:</label>
									<span style="font-size:12px;"><?php echo $bidderData['processing'][0]->auctionID; ?></span>
								</div>
							</div> 
							<div class="half_acct">
								<div class="row_acct">
									<label>Remitter Account Id <span class="red">*</span></label>
									<select name="remitter_account" id="remitter_account">
										<option value="">Select Remitter Account</option>
										<?php foreach($accountData as $accData): ?>
										<option value="<?php echo $accData->bank_account_id; ?>"><?php echo $accData->account_nick_name.' ('.$accData->account_number.')';?></option>
										<?php endforeach; ?>
									</select>
								</div>
							</div>
						</div>
                   
                    
                    <div class="full_acct">
						<div class="half_acct">
							<div class="row_acct">
								<label>Remitter Account Holder Name <span class="red">*</span></label>
								<input type="text" name="account_holder_name" id="account_holder_name" class="readonly" value="" readonly>
							</div>
						</div>
							<div class="half_acct">
									<div class="row_acct">
									<label>Remitter Bank Name <span class="red">*</span></label>
									<input type="text" name="bank_name" id="bank_name" class="readonly" value="" readonly>
									</div>
							</div>
						</div>
                   
                    
                     <div class="full_acct">
						
							<div class="half_acct">
								<div class="row_acct">
								<label>Remitter IFSC Code <span class="red">*</span></label>
								<input type="text" name="ifsc_code" id="ifsc_code" class="readonly" value="" readonly>
							</div>
						</div>
							<div class="half_acct">
								<div class="row_acct">
								<label>Remitter Account Number <span class="red">*</span></label>
								<input type="text" name="account_number" id="account_number" class="readonly" value="" readonly>
								</div>
							</div>
						</div>
						
						 <div class="full_acct">
						
							<div class="half_acct">
								<div class="row_acct">
								<label>Sequence No. <span class="red">*</span></label>
								<input type="text" name="cheque_no" id="cheque_no" value="">
							</div>
						</div>
							<div class="half_acct">
								<div class="row_acct">
								<label>Sequence Date <span class="red">*</span></label>
								<input type="text" name="cheq_date" id="cheq_date" value="" >								
								</div>
							</div>
						
						</div>	
                    
                  </div>  
                    
                    
                    <div style="min-height: 0px; display: block;" class="box-content no-pad table-tp-space"> 
					

					<div class="container-outer">
					<div class="container-inner">
						<table border="1" align="left" cellpadding="2" cellspacing="1" class="mytable dataTable" id="big_table5" aria-describedby="big_table_info">
							<thead>
								<tr class="odd" style="border-top:solid 1px #ccc;">
									<td width="3%" align="left" valign="top" class=""><strong>S/No.</strong></td>
									<td width="8%" align="left" valign="top" class=""><strong>Bidder Name</strong></td>
									<!--<td width="35%" align="left" valign="top" class=""><strong>Email Id</strong></td>-->
									<td width="8%" align="left" valign="top" class=""><strong>Type of Payment</strong></td>						
									<td width="8%" align="left" valign="top" class=""><strong>Amount Paid (Rs.)</strong></td>
									<td width="8%" align="left" valign="top" class=""><strong>Amount Transferred (Rs.)</strong></td>
									<td width="8%" align="left" valign="top" class=""><strong>Amount Remaining (Rs.)</strong></td>
									<td width="8%" align="left" valign="top" class=""><strong>Account ID</strong></td>
									<td width="13%" align="left" valign="top" class=""><strong>Account Holder Name </strong></td>
									<td width="10%" align="left" valign="top" class=""><strong>Bank Name </strong></td>
									<td width="8%" align="left" valign="top" class=""><strong>IFSC Code </strong></td>
									<td width="10%" align="left" valign="top" class=""><strong>Account Number </strong></td>
									<td width="10%" align="left" valign="top" class=""><strong>Amount to be Refunded (Rs.)<span class="red">*</span></strong></td>
									
								</tr>
							</thead>
							<tbody role="alert" aria-live="polite" aria-relevant="all">
								<?php 					
								//echo "<pre>";print_r($bidderData['processing']);
								$sr_no = 0;
								if(count($bidderData['processing'])){
									foreach($bidderData['processing'] as $key => $bData)
									{
										$paymentResArr = json_decode($bData->payment_response);
								?>
									<input type="hidden" value="<?php echo $bidderData['processing'][0]->payment_type; ?>" name="payment_type[]">
									<tr class="even">
										<td><?php $sr_no = $key; echo ++$sr_no?></td>
										<td><?php echo $bData->first_name.' '.$bData->last_name; ?></td>
										<!--<td><?php //echo $bData->email_id; ?></td>-->										
										<td>Processing Fee</td>										
										<td><?php echo $bData->processing_fee; ?></td> 
										<td><?php echo $bData->amt_transferred; ?></td>
										<td><?php echo $bData->amt_remaining; ?></td>
										<td>
										 <?php if(($bData->amt_transferred >= $bData->amt_remaining)): ?>
											<select name="receiver_account_paid[]" class="receiver_account" disabled="disabled">
												<option value="">Select</option>										
											</select>
											 <?php else: ?>
											 <select name="receiver_account[]" class="receiver_account" >
												<option value="">Select</option>										
											</select>
											 <?php endif ?>
                                                                                    
										</td>
										<td><?php if(($bData->amt_transferred >= $bData->processing_fee)): ?>
                                                                                       --
											<?php else: ?>
												<input style="width:98%;" type="text" name="receiver_name[]" class="receiver_name readonly" value="" readonly /></td>
											<?php endif ?>
										<td><?php if(($bData->amt_transferred >= $bData->processing_fee)): ?>
											   --
											<?php else: ?>
											   <input style="width:98%;" type="text" name="receiver_bank_name[]" class="receiver_bank_name readonly" value="" readonly /></td>
											<?php endif ?>
										<td><?php if(($bData->amt_transferred >= $bData->processing_fee)): ?>
											   --
											<?php else: ?>
											   <input style="width:98%;" type="text" name="receiver_ifsc_code[]" class="receiver_ifsc_code readonly" value="" readonly /></td>
											<?php endif ?>
										<td><?php if(($bData->amt_transferred >= $bData->processing_fee)): ?>
											   --
											<?php else: ?>
											   <input style="width:98%;" type="text" name="receiver_account_no[]" class="receiver_account_no readonly" value="" readonly /></td>
											<?php endif ?>
										<td>
											<?php if(($bData->amt_transferred >= $bData->processing_fee)): ?>
												NIL
											<?php else: ?>
												<input type="hidden" value="<?php echo $bData->bidderID;?>" name="bidder_id[]">
												<input type="hidden" value="<?php echo $bData->amt_remaining;?>" name="amt_remaining[]">
												<input style="width:98%;" type="text" name="amt_to_be_paid[]" class="amt_to_be_paid" value="0.00" />
												<?php $flag_scroll_check_btn = 1; //For Disable "Generate Scrolls/Cheque" Button ?>
											<?php endif ?>
										</td>
									</tr>
									
								<?php 
									}
                                                                        
								}
									if(count($bidderData['emd'])){
                                    //echo "<pre>";print_r($bidderData['emd']);
									foreach($bidderData['emd'] as $key => $bData)
									{
										//$paymentResArr = json_decode($bData->payment_response);
								?>
									<input type="hidden" value="<?php echo $bidderData['emd'][0]->payment_type; ?>" name="payment_type[]">
									<tr class="even">
										<td><?php echo ++$sr_no?></td>
										<td><?php echo $bData->first_name.' '.$bData->last_name; ?></td>
										<!--<td><?php //echo $bData->email_id; ?></td>-->										
										<td>EMD Fee</td>										
										<td><?php echo $bData->emd_fee; ?></td> 
										<td><?php echo $bData->amt_transferred; ?></td>
										<td><?php echo $bData->amt_remaining; ?></td>
										<td>
											 <?php if(($bData->amt_transferred >= $bData->emd_fee)): ?>
											<select name="receiver_account_paid[]" class="receiver_account" disabled="disabled">
												<option value="">Select</option>										
											</select>
											 <?php else: ?>
											 <select name="receiver_account[]" class="receiver_account" >
												<option value="">Select</option>										
											</select>
											 <?php endif ?>
                                                                                    
										</td>
										<td><?php if(($bData->amt_transferred >= $bData->emd_fee)): ?>
											   --
											<?php else: ?>
												<input style="width:98%;" type="text" name="receiver_name[]" class="receiver_name readonly" value="" readonly /></td>
											<?php endif ?>
										<td><?php if(($bData->amt_transferred >= $bData->emd_fee)): ?>
											   --
											<?php else: ?>
											   <input style="width:98%;" type="text" name="receiver_bank_name[]" class="receiver_bank_name readonly" value="" readonly /></td>
											<?php endif ?>
										<td><?php if(($bData->amt_transferred >= $bData->emd_fee)): ?>
											   --
											<?php else: ?>
											   <input style="width:98%;" type="text" name="receiver_ifsc_code[]" class="receiver_ifsc_code readonly" value="" readonly /></td>
											<?php endif ?>
										<td><?php if(($bData->amt_transferred >= $bData->emd_fee)): ?>
											   --
											<?php else: ?>
											   <input style="width:98%;" type="text" name="receiver_account_no[]" class="receiver_account_no readonly" value="" readonly /></td>
											<?php endif ?>
										<td>
											<?php if(($bData->amt_transferred >= $bData->emd_fee)): ?>
												NIL
											<?php else: ?>
												<input type="hidden" value="<?php echo $bData->bidder_id;?>" name="bidder_id[]">
												<input type="hidden" value="<?php echo $bData->amt_remaining;?>" name="amt_remaining[]">
												<input style="width:98%;" type="text" name="amt_to_be_paid[]" class="amt_to_be_paid" value="0.00" />
												<?php $flag_scroll_check_btn = 1; //For Disable "Generate Scrolls/Cheque" Button ?>
											<?php endif ?>
										</td>
									</tr>
									
								<?php 
									}
                                                                        
								}
								else
								{
								?>
								<tr>
									<td colspan="11" align="center">No Record found</td>
								</tr>
								<?php 
								}
								?>
								<tr>
							<td colspan="13">
								
								<input type="hidden" value="<?php echo $bidderData['processing'][0]->auctionID; ?>" name="auction_id">								
								<?php if($flag_scroll_check_btn == 1): ?>
                                                                <input name="gen_scrl_chq" id="gen_scrl_chq" value="Generate Scrolls/Cheque" type="submit" class="addBidder button_grey b_submit float-right" style="float:right;" onclick="return validateFrmInitTrans();">
                                                                <div class="rfq-loader"></div>
                                                                <?php endif; ?>
								<input name="back" value="Back" onclick="window.location.href='<?php echo base_url();?>buyer/refund_transfer_dashboard'"  type="button" class="button_grey">
                                                                
							</td>
						</tr>
							</tbody>     					
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
<p style="display:block;"><a class='inline' href="#inline_content"></a></p>
		<div style='display:none'>
			<div id='inline_content' style='padding:10px; background:#fff;'>
                            <ul id="spMsg" style="color:#CC0000;"></ul>
			</div>
		</div>
<script>
    $( document ).ready(function() {
       $("#remitter_account").change(function () {
           
            $('#account_holder_name').val('');
            $('#bank_name').val('');
            $('#ifsc_code').val('');
            $('#account_number').val('');
            
            var bank_account_id = this.value;
            
            $.ajax({
                type: "POST",  
                url: "<?php echo base_url('buyer/get_remitter_account_by_id')?>",  
                data: {id: bank_account_id},
                datatype: 'json',
                success: function(data){
                    var jData = JSON.parse(data);
                    $('#account_holder_name').val(jData[0].account_holder_name);
                    $('#bank_name').val(jData[0].bank_name);
                    $('#ifsc_code').val(jData[0].ifsc_code);
                    $('#account_number').val(jData[0].account_number);
                }  
            });
            
            $.ajax({
                type: "POST",  
                url: "<?php echo base_url('buyer/get_remaining_account')?>",  
                data: {id: bank_account_id},
                datatype: 'json',
                success: function(data){
                    var jData = JSON.parse(data);
                    var str = '<option value="">--Select-- </option>';
					for(i=0;i<jData.length;i++)
					{
						var sel = '';
						/*if(<?php echo $item_category_id;?>==data[i].item_category_id)
						{
							sel = 'selected';
						}*/
						str+='<option value="'+jData[i].bank_account_id+'" '+sel+'>'+jData[i].account_nick_name+'('+jData[i].account_number+')</option>';
					}	
					$(".receiver_account").html(str);
                }  
            });
            
            $('.receiver_name').val('');
            $('.receiver_bank_name').val('');
            $('.receiver_ifsc_code').val('');
            $('.receiver_account_no').val('');
            
        });
        
        $(".receiver_account").change(function () {							
			bank_account_id = this.value;
			var obj = $(this).closest("tr");
			
            obj.find('.receiver_name').val('');
            obj.find('.receiver_bank_name').val('');
            obj.find('.receiver_ifsc_code').val('');
            obj.find('.receiver_account_no').val('');
            
			 $.ajax({
                type: "POST",  
                url: "<?php echo base_url('buyer/get_remitter_account_by_id')?>",  
                data: {id: bank_account_id},
                datatype: 'json',
                success: function(data){
                    var jData = JSON.parse(data);
                    obj.find('.receiver_name').val(jData[0].account_holder_name);
                    obj.find('.receiver_bank_name').val(jData[0].bank_name);
                    obj.find('.receiver_ifsc_code').val(jData[0].ifsc_code);
                    obj.find('.receiver_account_no').val(jData[0].account_number);
                }  
            });		
			
		});
    });
    
    
$('#cheq_date').datepicker({
				controlType: 'select',
		oneLine: true,
		changeMonth: true,
		changeYear: true,
		minDate: 0,
		stepMinute: 15,
		dateFormat: 'dd-mm-yy',
		yearRange: '2017:2020',
		timeFormat: 'HH:mm:00'
});

jQuery(document).ready(function(){
    jQuery(".amt_to_be_paid1").keydown(function (e) { 
        // Allow: backspace, delete, tab, escape, enter and .
        if (jQuery.inArray(e.keyCode, [46, 8, 9, 27, 13, 190]) !== -1 ||
             // Allow: Ctrl+A, Command+A
            (e.keyCode == 65 && ( e.ctrlKey === true || e.metaKey === true ) ) || 
             // Allow: home, end, left, right, down, up
            (e.keyCode >= 35 && e.keyCode <= 40)) {
                 // let it happen, don't do anything
                 return;
        }
        // Ensure that it is a number and stop the keypress
        if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
            e.preventDefault();
        }
    });
});
	
</script>

<script>
    $(function() {
        $('.amt_to_be_paid1').blur(function(e) { //onBlur handler for textbox
            $(this).val($(this).getNum()); //invoke your function, you can use it with other selectors too
        });
    });

    jQuery.fn.getNum = function() {

        /* trim the string value */
        var val = $.trim($(this).val());

        /* replace all ',' to '.' if present */
        if(val.indexOf(',') > -1) {
            val = val.replace(',', '.');
        }

        /* parse the string as float */
        var num = parseFloat(val);

        /* use two decimals for the number */
        var num = num.toFixed(2);

        /* check if 'num' is 'NaN', this will happen 
         * when using characters, two '.' and apply 
         * for other cases too.
         */ 
        if(isNaN(num)) {
            num = '';
        }

        return num;
    }
    
    $(document).on("keypress",".amt_to_be_paid",function(){	
	  if ((event.which != 46 || $(this).val().indexOf('.') != -1) &&
		((event.which < 48 || event.which > 57) &&
		  (event.which != 0 && event.which != 8))) {
		event.preventDefault();
	  }

	  var text = $(this).val();

	  if ((text.indexOf('.') != -1) &&
		(text.substring(text.indexOf('.')).length > 2) &&
		(event.which != 0 && event.which != 8) &&
		($(this)[0].selectionStart >= text.length - 2)) {
		event.preventDefault();
	  }
	});
        

</script>
