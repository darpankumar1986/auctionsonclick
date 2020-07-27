<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<title>bankEauction</title>
<meta name="description" content="bankEauction" />
<meta name="keywords" content="bankEauction" />
<!-- Mobile Specific Metas -->
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<link rel="stylesheet" href="<?php echo base_url()?>/css/bace.css">
<link rel="stylesheet" href="<?php echo base_url()?>/css/admin-style.css">
<link rel="stylesheet" href="<?php echo base_url()?>/css/nav.css">
<link rel="stylesheet" href="<?php echo base_url()?>/css/banner.css">
<script src="<?php echo base_url()?>/js/jquery.min.js"></script>
<link rel="stylesheet" href="<?php echo base_url()?>js/calender/jquery-ui.css">
<script src="<?php echo base_url(); ?>js/calender/jquery-ui.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>js/calender/jquery-ui-timepicker-addon.min.js"></script>
<link rel="stylesheet" href="<?php echo base_url()?>js/calender/jquery-ui-timepicker-addon.css">
<script type="text/javascript" src="<?php echo base_url(); ?>js/calender/i18n/jquery-ui-timepicker-addon-i18n.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/calender/jquery-ui-sliderAccess.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>/application/views/admin/js/plugins/jquery.validate.min.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>/js/common.js"></script>

<!--[if IE]>
<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->
<!--[if IE]>
<script type="text/javascript" src="/js/respond.js"></script>
<![endif]-->
</head>
<body>
<?php //print_r($emdrow);?>
<section>
  <div class="row">
    <div class="wrapper-full">
      <div class="dashboard-wrapper">
        
        <div class="container">
          
          <div class="secttion-right" style="width:100%;">
		  <form name="submitEmd" id="submitEmd" action="/helpdesk_executive/SaveAuctionEmd" method="post" enctype="multipart/form-data">
            <div class="form" style="text-align:center;">
			<div class="heading4 btmrg20">EMD</div>
			<?php echo $msg;?>
			<div class="seprator btmrg20"></div>
			<ul id="spMsg"></ul>
              <dl>
                <dt class="required">
                  <label>Bank Name.</label>
                </dt>
                <dd>
                  <input name="bank_name" id="bank_name" type="text" value="<?php echo $emdrow->bank_name;?>" class="input">
                  <span class="help-icon" title="Please write the bank name from which the DD has been issued or RTGS payment for EMD is remitted."></span> </dd>
              </dl>
              <dl>
                <dt class="required">
                  <label>Amount</label>
                </dt>
                <dd>
				<?php
					$emd_amt=GetTitleByField('tbl_auction', "id='".$auction_id."'", 'emd_amt');	
				
				?>
                  <input disabled name="amount" id="amount" value="<?php echo number_format($emd_amt,2);?>" type="text"  class="input">(<?php echo getAmountInWords($emd_amt) ; ?> Only)
				  <span class="help-icon" title="This is the reserve price fixed for the event. The DD/ RTGS/Challan being submitted must be of the same value."></span>
                </dd>
              </dl>
              <dl>
                <dt>
                  <label>Instrument type</label>
                </dt>
                <dd>
                  <select name="instrument_type" id="instrument_type" class="select">
                    <option value="">Select</option>
                    <option value="1" <?php if($emdrow->instrument_type==1){ echo $sel="selected";}else{ $sel='';}?>>RTGS/NEFT RECIEPT</option>
                    <option value="2" <?php if($emdrow->instrument_type==2){ echo $sel="selected";}else{ $sel='';}?>>DD</option>
                    <option value="3" <?php if($emdrow->instrument_type==3){ echo $sel="selected";}else{ $sel='';}?>>CHALAN RECIEPT</option>
                  </select>
				  <span class="help-icon" title="Please choose type of instrument which you are using for paying EMD. This may be DD/ RTGS payment receipt/Chalan of remittance of the EMD."></span>
                </dd>
              </dl>
			  
              <dl>
                <dt class="required">
                  <label id="instrument_no_label">Instrument No.</label>
                </dt>
                <dd>
                   <input name="instrument_no" id="instrument_no" value="<?php echo $emdrow->instrument_no;?>" type="text"  class="input">
				   <span class="help-icon" title="DD No./ RTGS UTR No./ Challan no."></span>
                </dd>
              </dl>
              <dl>
                <dt class="required">
                  <label id="instrument_date_label">Instrument date</label>
                </dt>
                <dd>
                   <input name="instrument_date" value="<?php echo $emdrow->instrument_date;?>" id="instrument_date" type="text"  class="input">
				   <span class="help-icon" title="Date of issue of DD/ date of the RTGS Payment as per the Reciept/ Date of the remittance of the payment by challan as per the challan"></span>
                </dd>
              </dl>
			  <?php //echo $emdrow->instrument_expiry_date;?>
			   <dl id="dd_expire_date" <?php if($emdrow->instrument_expiry_date=='0000-00-00 00:00:00'){ echo $dis='style="display:none;"';}else{ echo $dis='style="display:block;"';}?>>
                <dt class="required">
                  <label>DD expiry date</label>
                </dt>
                <dd>
                   <input name="instrument_expiry_date"  value="<?php echo $emdrow->instrument_expiry_date;?>" id="instrument_expiry_date" type="text"  class="input">
				   <span class="help-icon" title="Date of expiry of the DD. For RTGS/Challan payment expiry date is not required"></span>
                </dd>
              </dl>
              <dl>
                <dt>
                  <label>Upload supporting document</label>
                </dt>
                <dd>
                  <input name="supporting_doc_path"  id="supporting_doc_path" type="file"  class="input">
				  <span class="help-icon" title="Please upload the scanned copy of the(DD/ BG/ PO/ Challan of remittance in the nodal bank account/ RTGS transfer receipt."></span>
				  <?php if($emdrow->supporting_doc){ ?>
				  <a download href="/public/uploads/document/<?php echo $auction_id; ?>/<?php echo $bidderid ?>/emd_supporting_doc/<?php echo $emdrow->supporting_doc;?>"><?php echo $emdrow->supporting_doc;?></a>
				  <input type="hidden" name="supporting_doc_path_old" value="<?php echo $emdrow->supporting_doc; ?>">
				  <?php } ?>
                </dd>
              </dl>
             <div class="seprator btmrg20"></div>
			  <div class="heading4">Fund Details</div>
			  <label>Please provide the bank account details where the refund of EMD is to be credited</label>
              <dl>
                <dt class="required">
                  <label>Name of the beneficiary</label>
                </dt>
                <dd>
                  <input name="beneficiary" id="beneficiary" type="text" value="<?php echo $emdrow->beneficiary;?>"  class="input">
				  <span class="help-icon" title="Provide the name of the person with a valid bank account in whose name you want the refund to be received (Usually the bidder)."></span>
                </dd>
              </dl>
              <dl>
                <dt class="required">
                  <label>Bank Name</label>
                </dt>
                <dd>
                  <input name="refund_bank_name" value="<?php echo $emdrow->refund_bank_name;?>" id="refund_bank_name" type="text"  class="input">
				  <span class="help-icon" title="Please provide the bank name in which the person holds the account"></span>
                </dd>
              </dl>
              <dl>
                <dt class="required">
                  <label>Branch Address</label>
                </dt>
                <dd>
                  <input name="branch_add" id="branch_add" value="<?php echo $emdrow->branch_add;?>" type="text"  class="input">
				  <span class="help-icon" title="Please provide the branch name and address where the person has his/her account"></span>
                </dd>
              </dl>
              <dl>
                <dt class="required">
                  <label>City</label>
                </dt>
                <dd>
                  <input name="city" id="city" type="text"  value="<?php echo $emdrow->city;?>"  class="input">
				  <span class="help-icon" title="Please provide the city of the branch where the person has his/her account"></span>
                </dd>
              </dl>
              <dl>
                <dt class="required">
                  <label>Account No.</label>
                </dt>
                <dd>
                  <input name="account_no" id="account_no" type="text" value="<?php echo $emdrow->account_no;?>"  class="input">
				  <span class="help-icon" title="Please Furnsih the account number"></span>
                </dd>
              </dl>
              <dl>
                <dt class="required">
                  <label>Branch IFSC Code</label>
                </dt>
                <dd>
                  <input name="branch_ifsc_code" id="branch_ifsc_code" value="<?php echo $emdrow->branch_ifsc_code;?>" type="text"  class="input">
				  <span class="help-icon" title="Please furnish the 11 digit IFSC code of the branch in which account holder is holding the account"></span>
                </dd>
              </dl>
              <div class="seprator btmrg20"></div>
            <div class="button-row"> 
			<input name="submit" onclick="return ValidateEmdTenderDate();" value="<?php if($emdrow->id){ echo $sub='Update';}else{ echo $sub='Submit'; }?> " type="submit" class="b_submit float-right">
			<input type="hidden" name="auction_id" value="<?php echo $auction_id;?>" >
			<input type="hidden" name="emdID" value="<?php echo $emdrow->id;?>" >
			<input type="hidden" name="bidderid" value="<?php echo $bidderid;?>" >
			<input type="hidden" name="currdate" id="currdate" value="<?php echo date("Y-m-d") ?>" />
			
			</div>
            </div>
			
			</form>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<script>

$(document).ready(function(){
	jQuery("#submitEmd").validate({
		rules: {
			bank_name: "required",
			amount: "required",
			bank_id: "required",
			instrument_no: "required",
			instrument_date: "required",
			refund_bank_name: "required",
			beneficiary: "required",
			branch_add: "required",
			city: "required",
			account_no: "required",
			branch_ifsc_code: "required"
		},
		messages: {
			bank_name: {
				required: "Please Enter Bank Name."
			},
			amount: {
				required: "Please Account Number."
			},
			instrument_no: {
				required: "Please Enter Instrument No."
			},
			instrument_date: {
				required: "Please Enter Insturment Date."
			},
			refund_bank_name: {
				required: "Please Enter Refund bank name."
			},
			beneficiary: {
				required: "Please Enter Beneficiary name."
			},
			city: {
				required: "Please Enter City."
			},
			account_no: {
				required: "Please Enter Account No ."
			},
			branch_ifsc_code: {
				required: "Please Enter Branch IFSC Code."
			}
			
		},
        errorPlacement : function(error, element) {
			if (element.next().is('.help-icon')) {
				 error.insertAfter(element.next('.help-icon'));
			} 
			else {
				 error.insertAfter(element);
			}
		}
	});
});	


  jQuery('#instrument_date').datetimepicker({
		controlType: 'select',
		oneLine: true,
		changeMonth: false,
		changeYear: true,
		dateFormat: 'yy-mm-dd',
		timeFormat: 'HH:mm:00'
	});
	
	  jQuery('#instrument_expiry_date').datetimepicker({
		controlType: 'select',
		oneLine: true,
		changeMonth: false,
		changeYear: true,
		dateFormat: 'yy-mm-dd',
		timeFormat: 'HH:mm:00'
	});

	jQuery('#instrument_type').change(function(){
		var instrument_type = jQuery(this).val();
		if(instrument_type)
		{
				//alert(instrument_type);
			if(instrument_type==1)
			{	jQuery('#dd_expire_date').hide();
				jQuery('#instrument_no_label').html('RTGS/NEFT RECIEPT No.');	
				jQuery('#instrument_date_label').html('RTGS/NEFT RECIEPT date');
			}else if(instrument_type==2){
				jQuery('#dd_expire_date').show();	
				jQuery('#instrument_no_label').html('DD No.');	
				jQuery('#instrument_date_label').html('DD date');	
			}else if(instrument_type==3){
				jQuery('#dd_expire_date').hide();
				jQuery('#instrument_no_label').html('CHALAN RECIEPT No.');	
				jQuery('#instrument_date_label').html('CHALAN RECIEPT date');	
			}else{
				jQuery('#dd_expire_date').hide();	
				jQuery('#instrument_no_label').html('Instrument date');	
				jQuery('#instrument_date_label').html('Instrument date');	
			}
			//jQuery('#nodal_bank_name').val(instrument_type);
		}else{
				jQuery('#dd_expire_date').hide();	
				jQuery('#instrument_no_label').html('Instrument date');	
				jQuery('#instrument_date_label').html('Instrument date');	
		}
	});	
	
  //tooltip
  jQuery(function() {
    jQuery('.help-icon').tooltip();
  });
</script>
</body>

</html>
