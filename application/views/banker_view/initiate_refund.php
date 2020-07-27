
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/jquery.dataTables.css" type="text/css" media="screen"/>	
<link rel="stylesheet" href="<?php echo base_url()?>js/calender/jquery-ui.css">
<script src="<?php echo base_url(); ?>js/calender/jquery-ui.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>js/calender/jquery-ui-timepicker-addon.min.js"></script>
<link rel="stylesheet" href="<?php echo base_url()?>js/calender/jquery-ui-timepicker-addon.css">
<!--<link rel="stylesheet" href="<?php echo base_url()?>/css/colorbox.css" />
<script src="<?php echo base_url()?>/js/jquery.colorbox.js"></script>
-->
<style>
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

<section class="container_12">

    <form id="frm_init_refund" name="frm_init_refund" action="<?php echo base_url('buyer/save_initiate_refund')?>" method="post" enctype="multipart/form-data" > 
        <div class="row">
            <div class="wrapper-full">
                <div class="dashboard-wrapper">
                    <div id="tab-pannel3" class="btmrgn">
                        <div class="tab_container3">
                            
                            <!-- #tab1 -->
                                <div id="tab6" class="tab_content3">
                                    <div class="container">
                                        <div class="secttion-right">
                                          
                                            <div class="table-wrapper btmrg20">
                                                <div class="table-heading btmrg">
                                                    <?php if(isset($this->session->userdata['flash:old:message'])){?>
                                                        <div class="success_msg"> <?php echo @$this->session->userdata['flash:old:message']; ?></div>
                                                    <?php } ?>
                                                    <?php if(isset($this->session->userdata['flash:old:error_msg'])){?>
                                                            <div class="fail_msg"> <?php echo @$this->session->userdata['flash:old:error_msg']; ?></div>
                                                     <?php } ?>
                                                    <div class="box-head">Process EMD Refund</div>
                                                </div>

                                                <div class="outer">
                                                    <div class="full_acct">
                                                        <div class="half_acct">
                                                            <div class="row_acct">
                                                                <label>Auction Id:</label>
                                                                <span style="font-size:12px;"><?php echo $auction_id; ?></span>
                                                            </div>
                                                        </div> 
                                                        <div class="half_acct">
                                                            <div class="row_acct">
                                                                <label>Remitter Account Id <span class="red">*</span></label>
                                                                <select name="remitter_account" id="remitter_account">
                                                                    <option value="">Select Remitter Account</option>
                                                                    <?php foreach($accountData as $accData): ?>
                                                                    <option value="<?php echo $accData->bank_account_id; ?>"><?php echo $accData->account_nick_name.' ('.$accData->account_number.')'; ?></option>
                                                                    <?php endforeach; ?>
                                                                </select>
                                                            </div>
                                                        </div>
                                                    </div>


                                                    <div class="full_acct">
                                                        <div class="half_acct">
                                                            <div class="row_acct">
                                                                <label>Remitter Account Holder Name <span class="red">*</span></label>
                                                                <input type="text" name="account_holder_name" id="account_holder_name" class="readonly" readonly>
                                                            </div>
                                                        </div>
                                                        <div class="half_acct">
                                                            <div class="row_acct">
                                                                <label>Remitter Bank Name <span class="red">*</span></label>
                                                                <input type="text" name="bank_name" id="bank_name" class="readonly" readonly>
                                                            </div>
                                                        </div>
                                                    </div>


                                                    <div class="full_acct">			
                                                       <div class="half_acct">
                                                           <div class="row_acct">
                                                               <label>Remitter IFSC Code <span class="red">*</span></label>
                                                               <input type="text" name="ifsc_code" id="ifsc_code" class="readonly" readonly>
                                                           </div>
                                                       </div>
                                                       <div class="half_acct">
                                                           <div class="row_acct">
                                                           <label>Remitter Account Number <span class="red">*</span></label>
                                                           <input type="text" name="account_number" id="account_number" class="readonly" readonly>
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
                                                                  <td width="10%" align="left" valign="top" class=""><strong>Bidder Name</strong></td>
                                                                  <td width="10%" align="left" valign="top" class=""><strong>Email Id</strong></td>						
                                                                  <td width="8%" align="left" valign="top" class=""><strong>EMD Amount Paid(Rs.)</strong></td>
                                                                  <td width="8%" align="left" valign="top" class=""><strong>EMD Amount Refunded(Rs.)</strong></td>
                                                                  <td width="8%" align="left" valign="top" class=""><strong>EMD Amount Remaining(Rs.)</strong></td>
                                                                  <td width="10%" align="left" valign="top" class=""><strong>Account Holder Name </strong></td>
                                                                  <td width="10%" align="left" valign="top" class=""><strong>Bank Name </strong></td>
                                                                  <td width="5%" align="left" valign="top" class=""><strong>IFSC Code </strong></td>
                                                                  <td width="10%" align="left" valign="top" class=""><strong>Account Number </strong></td>
                                                                  <td width="10%" align="left" valign="top" class=""><strong>Amount to be Refunded (Rs.)<span class="red">*</span></strong></td>
                                                                </tr>
                                                          </thead>
                                                          <tbody role="alert" aria-live="polite" aria-relevant="all">
                                                              <?php 					
                                                              //echo '<pre>';print_r($bidderData);die;
                                                              if(count($bidderData))
                                                              {
                                                                  foreach($bidderData as $key => $bData)
                                                                  {
                                                                    $paymentResArr = json_decode($bData->payment_response);	
                                                                    //echo "<pre>";print_r($paymentResArr);die;
                                                              ?>
                                                                    <tr class="even">
                                                                        
                                                                        
                                                                        

                                                                        <td><?php echo ++$key?></td>
                                                                        <td><?php echo $bData->first_name.' '.$bData->last_name; ?></td>
                                                                        <td><?php echo $bData->email_id; ?></td>
                                                                        <td><?php echo $bData->amount;//$paymentResArr->ChallanDetails[0]->Amount; ?></td>
                                                                        <td><?php echo $bData->refunded_emd; ?></td>
                                                                        <td><?php echo $bData->remaining_emd; ?></td>
                                                                        <td><?php echo (($bData->AccountHolderName == '')? $bData->first_name.' '.$bData->last_name : $bData->AccountHolderName); ?></td>
                                                                        <td><?php echo (($bData->RefundBankName == '')? 'Test Bank': $bData->RefundBankName); ?></td>
                                                                        <td><?php echo (($bData->RefundAccountIFSC == '')? 'TEST0001': $bData->RefundAccountIFSC); ?></td>
                                                                        <td><?php echo (($bData->AccountNumber == '')? '1234567890000000': $bData->AccountNumber); ?></td>
                                                                        <td>
                                                                            <?php if(($bData->refunded_emd >= $bData->amount)): ?>
                                                                                NIL
                                                                            <?php else: ?>
                                                                                <input type="hidden" value="<?php echo $bData->bidderID;?>" name="bidder_id[]">
                                                                                <input type="hidden" value="<?php echo $bData->first_name.' '.$bData->last_name;?>" name="remaining_emd[]">
                                                                                <input type="hidden" value="<?php echo (($bData->AccountHolderName == '')? $bData->first_name.' '.$bData->last_name : $bData->AccountHolderName); ?>" name="receiver_name[]">
                                                                                <input type="hidden" value="<?php echo (($bData->RefundBankName == '')? 'Test Bank': $bData->RefundBankName); ?>" name="receiver_bank_name[]">
                                                                                <input type="hidden" value="<?php echo (($bData->RefundAccountIFSC == '')? 'TEST0001': $bData->RefundAccountIFSC); ?>" name="receiver_ifsc_code[]">
                                                                                <input type="hidden" value="<?php echo (($bData->AccountNumber == '')? '1234567890000000': $bData->AccountNumber); ?>" name="receiver_account_no[]">
                                                                                <input type="text" style="width:98%;" name="amt_to_be_paid[]" id="amt_to_be_paid" class="amt_to_be_paid" value="0.00" />
                                                                                <?php $flag_scroll_check_btn = 1; //For Disable "Generate Scrolls/Cheque" Button ?>
                                                                            <?php endif ?>
                                                                        </td>
                                                                    </tr>
                                                              <?php 
                                                                  }//End Foreach
                                                              }
                                                              else
                                                              {
                                                              ?>
                                                                  <tr class="even">
                                                                      <td colspan="11" align="center">No Bidder found for refund</td>
                                                                  </tr>
                                                              <?php 
                                                              }
                                                              ?>
                                                                  <tr>
                                                                      <td colspan="11">
                                                                          <input type="hidden" value="<?php echo $bidderData[0]->auctionID; ?>" name="auction_id">
                                                                          <?php if($flag_scroll_check_btn == 1): ?>
                                                                          <input name="gen_scrl_chq" id="gen_scrl_chq" value="Generate Scrolls/Cheque" type="submit" class="addBidder button_grey b_submit float-right" style="float:right;" onclick="return validateFrmInitRefund();">
                                                                          <div class="rfq-loader"></div>
                                                                          <?php endif; ?>
                                                                          <input name="back" value="Back" onclick="window.location.href='<?php echo base_url();?>buyer/refund_transfer_dashboard'"  type="button" class="button_grey">

                                                                      </td>
                                                                  </tr>
                                                              </tbody>     					
                                                          </table>

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
        });
    });
    
      
   jQuery('#cheq_date').datepicker({
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

</script>

 <script>
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
