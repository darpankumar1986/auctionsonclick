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
		<link rel="stylesheet" href="<?php echo base_url()?>bankeauc/css/common.css">
		<link rel="stylesheet" href="<?php echo base_url()?>/css/admin-style.css">
		<link rel="stylesheet" href="<?php echo base_url()?>/css/nav.css">
		<link rel="stylesheet" href="<?php echo base_url()?>/css/banner.css">
		<script src="<?php echo base_url()?>/js/jquery.min.js"></script>
		<link href="<?php echo base_url() ?>js/calendar_new/dist/css/datepicker.min.css" rel="stylesheet" type="text/css">
		<script src="<?php echo base_url() ?>js/calendar_new/dist/js/datepicker.min.js"></script>
		<!-- Include English language -->
		<script src="<?php echo base_url() ?>js/calendar_new/dist/js/i18n/datepicker.en.js"></script>
		<?php /* ?>
		<link rel="stylesheet" href="<?php echo base_url()?>js/calender/jquery-ui.css">
		<script src="<?php echo base_url(); ?>js/calender/jquery-ui.js"></script>
		<script type="text/javascript" src="<?php echo base_url()?>js/calender/jquery-ui-timepicker-addon.min.js"></script>
		<link rel="stylesheet" href="<?php echo base_url()?>js/calender/jquery-ui-timepicker-addon.css">
		<script type="text/javascript" src="<?php echo base_url(); ?>js/calender/i18n/jquery-ui-timepicker-addon-i18n.min.js"></script>
		<script type="text/javascript" src="<?php echo base_url(); ?>js/calender/jquery-ui-sliderAccess.js"></script>
		<?php */ ?>

		<script type="text/javascript" src="<?php echo base_url()?>/application/views/admin/js/plugins/jquery.validate.min.js"></script>
		<script type="text/javascript" src="<?php echo base_url()?>/js/common.js"></script>
		<script src="/js/jquery.colorbox.js"></script>
	<!--[if IE]>
	<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
	<![endif]-->
	<!--[if IE]>
	<script type="text/javascript" src="/js/respond.js"></script>
	<![endif]-->
	</head>
	<body>
	<section>
		<div class="row">
			<div class="secttion-right" style="width:100%;">
			<form name="submitEmd" id="submitEmd" action="/owner/SaveAuctionEmd" method="post" enctype="multipart/form-data">
				<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash();?>" />
				<div class="form emd_form" style="text-align:center;">
					<div class="heading4 btmrg20">EMD</div>
					<div class="success_msg"><?php echo $msg;?></div>
					<div class="seprator btmrg20"></div>
						<ul id="spMsg"></ul>
							<dl>
								<dt class="required">
									<label>Bank Name.</label>
								</dt>
								<dd>
									<input name="bank_name" autocomplete="off" id="bank_name" type="text" value="<?php echo $emdrow->bank_name;?>" class="input html_found">
									<span class="help-icon" title="Please write the bank name from which the DD has been issued or RTGS payment for EMD is remitted."></span> 
									
								</dd>
							</dl>
							<dl>
								<dt class="required">
									<label>Amount</label>
								</dt>
								<dd>
									<?php
										$emd_amt=GetTitleByField('tbl_auction', "id='".$auction_id."'", 'emd_amt');	
									?>
									<input disabled name="amount" autocomplete="off" id="amount" value="<?php echo number_format($emd_amt,2);?>" type="text"  class="input">
									<span class="help-icon" title="This is the reserve price fixed for the event. The DD/ RTGS/Challan being submitted must be of the same value."></span>
									<span style="font-size:12px; padding-top: 8px;"> (<?php echo getAmountInWords($emd_amt) ; ?> Only)</span>
									
								</dd>
							</dl>
							<dl>
								<dt class="required">
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
							  <?php
							  if($emdrow->instrument_type==1)
							  {
								$instrument_no='RTGS/NEFT RECIEPT No.'; 
								 $instrument_date='RTGS/NEFT RECIEPT date'; 
								 $instrument_expiry_date='DD expiry date'; 
							  }else if($emdrow->instrument_type==2)
							  {
								 $instrument_no='DD No.'; 
								 $instrument_date='DD date'; 
								 $instrument_expiry_date='DD expiry date'; 
							  }else if($emdrow->instrument_type==3)
							  {
								 $instrument_no='CHALAN RECIEPT No.'; 
								 $instrument_date='CHALAN RECIEPT date '; 
								 $instrument_expiry_date='DD expiry date'; 
							  }else{
								 $instrument_no='Instrument No'; 
								 $instrument_date='Instrument date'; 
								 $instrument_expiry_date='DD expiry date'; 
							  }
							  
							  ?>
							<dl>
								<dt class="required">
									<label id="instrument_no_label"><?php echo $instrument_no;?></label>
								</dt>
								<dd>
								   <input maxlength="30" autocomplete="off" name="instrument_no" id="instrument_no" value="<?php echo $emdrow->instrument_no;?>" type="text"  class="input html_found">
								   <span class="help-icon" title="DD No./ RTGS UTR No./ Challan no."></span>
								</dd>
							</dl>
							<dl>
								<dt class="required">
								  <label id="instrument_date_label"><?php echo $instrument_date;?></label>
								</dt>
								<dd>
								   <input readonly name="instrument_date" autocomplete="off" value="<?php echo $emdrow->instrument_date;?>" id="instrument_date" type="text"  class="input">
								   <span class="help-icon" title="Date of issue of DD/ date of the RTGS Payment as per the Reciept/ Date of the remittance of the payment by challan as per the challan"></span>
								</dd>
							</dl>
							<dl id="dd_expire_date" <?php if($emdrow->instrument_type != 2){ echo $dis='style="display:none;"';}else{ echo $dis='style="display:block;"';}?>>
								<dt class="required">
								  <label><?php echo $instrument_expiry_date;?></label>
								</dt>
								<dd>
									<input readonly name="instrument_expiry_date" autocomplete="off"  value="<?php echo $emdrow->instrument_expiry_date;?>" id="instrument_expiry_date" type="text"  class="input">
									<span class="help-icon" title="Date of expiry of the DD. For RTGS/Challan payment expiry date is not required"></span>
								</dd>
								<span id="error_msg_sd" style="color:#900; float: right;adding-left: 35%;text-align: left;width: 65%;"></span>
							</dl>
							<dl>
								<dt>
									<label>Upload supporting document</label>
								</dt>
								<dd>
									<input name="supporting_doc_path"  id="supporting_doc_path" type="file"  class="input">
									<span class="help-icon" title="Please upload the scanned copy of the(DD/ BG/ PO/ Challan of remittance in the nodal bank account/ RTGS transfer receipt."></span>
									<?php if($emdrow->supporting_doc){ ?>
									<br style="clear:both;"/><a style="float:left; margin-top: -10px;" target="_blank" href="/public/uploads/document/<?php echo $auction_id; ?>/<?php echo $bidderid ?>/emd_supporting_doc/<?php echo $emdrow->supporting_doc;?>"><?php echo $emdrow->supporting_doc;?></a>
									<input type="hidden" name="supporting_doc_path_old" value="<?php echo $emdrow->supporting_doc; ?>">
								  <?php } ?>
								</dd>
							</dl>
							<div class="seprator btmrg20"></div>
							<div class="heading4 btmrg20">REFUND DETAILS</div>
								<div class="seprator btmrg20"></div>
								<div class="row">
									<label style=" font-size:12px; width:96%; background:#eeeeee; padding:5px 1%;">Please provide the bank account details where the refund of EMD is to be credited</label>
								</div>
								<dl>
									<dt class="required">
										<label>Name of the beneficiary</label>
									</dt>
									<dd>
										<input name="beneficiary" id="beneficiary" autocomplete="off" type="text" value="<?php echo $emdrow->beneficiary;?>"  class="input html_found">
										<span class="help-icon" title="Provide the name of the person with a valid bank account in whose name you want the refund to be received (Usually the bidder)."></span>
									</dd>
								</dl>
								<dl>
									<dt class="required">
										<label>Bank Name</label>
									</dt>
									<dd>
									  <input name="refund_bank_name" autocomplete="off" value="<?php echo $emdrow->refund_bank_name;?>" id="refund_bank_name" type="text"  class="input html_found">
									  <span class="help-icon" title="Please provide the bank name in which the person holds the account"></span>
									</dd>
								</dl>
								<dl>
									<dt class="required">
										<label>Branch Address</label>
									</dt>
									<dd>
										<input name="branch_add"  autocomplete="off" id="branch_add" value="<?php echo $emdrow->branch_add;?>" type="text"  class="input html_found">
										<span class="help-icon" title="Please provide the branch name and address where the person has his/her account"></span>
									</dd>
								</dl>
								<dl>
									<dt class="required">
										<label>City</label>
									</dt>
									<dd>
										<input name="city" autocomplete="off" id="city" type="text"  value="<?php echo $emdrow->city;?>"  class="input html_found">
										<span class="help-icon" title="Please provide the city of the branch where the person has his/her account"></span>
									</dd>
								</dl>
								<dl>
									<dt class="required">
										<label>Account No.</label>
									</dt>
									<dd>
									<!-- IsAlphaNumeric(event) -->
										<input name="account_no" maxlength="20" autocomplete="off" id="account_no" type="text" value="<?php echo $emdrow->account_no;?>" onkeypress="return isNumberKey(event);" class="input html_found">
										<span class="help-icon" title="Please Furnish the account number"></span>
										<span id="error" style="color: Red; display: none">* Special Characters not allowed</span>
									</dd>
								</dl>
								<dl>
									<dt class="required">
									  <label>Branch IFSC Code</label>
									</dt>
									<dd>
									  <input name="branch_ifsc_code" autocomplete="off" id="branch_ifsc_code" value="<?php echo $emdrow->branch_ifsc_code;?>" type="text"  class="input alphanumeric html_found" maxlength="20">
									  <span class="help-icon" title="Please furnish the 11 digit IFSC code of the branch in which account holder is holding the account"></span>
									</dd>
								</dl>
								<div class="seprator btmrg20"></div>
								<div class="button-row"> 
										<input name="submit" onclick="return ValidateEmdTenderDate();" value="<?php if($emdrow->id){ echo $sub='Update';}else{ echo $sub='Submit'; }?> " type="submit" class="b_submit" style="margin-top:5px;">
										<input type="hidden" name="auction_id" value="<?php echo $auction_id;?>" >
										<input type="hidden" name="emdID" value="<?php echo $emdrow->id;?>" >
										<input type="hidden" name="bidderid" value="<?php echo $bidderid;?>" >
										<input type="hidden" name="currdate" id="currdate" value="<?php echo date("Y-m-d H:i:s") ?>" />
								</div>
				</div>
			</form>
        </div>
  </div>
</section>
    <script>
    jQuery(document).ready(function(){
		
		jQuery('#supporting_doc_path').change(function () {
			var getValue = this.value;
			var ext1 = getValue.split('.');
			var arr = ext1.length;
			var indexValuee = arr-1;
			if(typeof ext1[indexValuee] == "undefined")
			{
				alert('This is not an allowed file type.');
				this.value = '';
			}
			//var ext = this.value.match(/\.(.+)$/)[1];
			switch (ext1[indexValuee]) {
				case 'png':case 'jpg':case 'gif':case 'jpeg':case 'pdf':case 'xls':case 'doc':case 'docx':case 'zip':
				$('#supporting_doc_path').attr('disabled', false);
				break;
				default:
					alert('This is not an allowed file type.');
					this.value = '';
			}
		});
	
		jQuery('.alphanumeric').bind('keypress', function (event) { 			  
			var regex=new RegExp("^[-_ a-zA-Z0-9\b]+$");
			var key = String.fromCharCode(!event.charCode ? event.which : event.charCode);
		   
			if (!regex.test(key)) {
			  //  
			  //if(!((event.keyCode >= 37 && event.keyCode <= 40))){
				event.preventDefault();
				return false;
			  //}
		   }
			
		});

	 jQuery("#instrument_expiry_date").change(function(){ 
             $("#error_msg_sd").text("");
            // alert($("#instrument_date").val());
          var d1=$("#instrument_date").val().split(' ');
          var d2=$(this).val().split(' ');
             var  exptime=d2['0'].split('-');
             var  inttime=d1['0'].split('-');
             var oneDay = 24*60*60*1000; // hours*minutes*seconds*milliseconds
             var firstDate = new Date(inttime['0'],inttime['1'],inttime['2']);
             var secondDate = new Date(exptime['0'],exptime['1'],exptime['2']);
             var diffDays = Math.round(Math.abs((firstDate.getTime() - secondDate.getTime())/(oneDay)));
            
           if(diffDays<90){ //alert("Expiry date should be Greater than 3 months than Instrument date"); 
               $("#instrument_expiry_date").prop("value",'');
               setTimeout(function(){  $("#error_msg_sd").text("Expiry date should be Greater than 3 months than Instrument date");  }, 500);
              
             
           return false;
           }
      });
	<?php if($msg){	?>
		 setTimeout(function(){ parent.jQuery.colorbox.close() }, 3000);
	<?php } ?>
	$.validator.addMethod('filesize', function(value, element, param) {
            // param = size (in bytes) 
            // element = element to validate (<input>)
           // value = value of the element (file name)
           return this.optional(element) || (element.files[0].size <= param) 
        });
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
			account_no: {
							required: true,
							minlength: 6								
					    },
			instrument_type: "required",
			branch_ifsc_code: {
								required: true,
								minlength: 6
								
							   },
			instrument_expiry_date: "required",
            supporting_doc_path:{
				accept: "png|jpg|gif|jpeg|pdf|xls|doc|docx|zip",
                                 filesize:"5259526"
			}
                       
		},
		messages: {
			bank_name: {
				required: "Please Enter Bank Name."
			},
			branch_add:{
				required: "Please Enter Branch Name."
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
				required: "Please Enter Bank name."
			},
			beneficiary: {
				required: "Please Enter Beneficiary name."
			},
			city: {
				required: "Please Enter City."
			},
			account_no: {
				required: "Please Enter Account No .",
				minlength: "Enter at least {0} characters"
			},
			
			instrument_type: {
				required: "Please select instrument type ."
			}
			,
			branch_ifsc_code: {
				required: "Please Enter Branch IFSC Code.",
				minlength: "Enter at least {0} characters"
			},
			
			instrument_expiry_date:{
			required: "Please Enter Expiry Date."	
			},
			 supporting_doc_path:{
				accept:"Please Upload Valid document Format Accepted format (png,jpg,gif,jpeg,pdf,xls,doc,zip,docx)."
			},
                        
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
<?php
date_default_timezone_set("Asia/Calcutta");
$current_timestamp = round(microtime(true) * 1000);
?>
var timer1 = <?php echo $current_timestamp;?>;
var d = new Date(timer1);				
d.setTime( d.getTime() + d.getTimezoneOffset()*60*1000 + 19800000);

	jQuery('#instrument_date').datepicker({
        language: 'en',
        dateFormat: 'yyyy-mm-dd',
        timeFormat: 'hh:ii:00',
        timepicker:true,
        maxDate: new Date(d), // Now can select only dates, which goes after today
        todayButton:true,
        todayButton: new Date(d),
        showEvent:"focus",
        clearButton:true,
        autoClose:true,
    });
    
  /*jQuery('#instrument_date').datetimepicker({
		controlType: 'select',
		oneLine: true,
		maxDate: 0,
		changeMonth: false,
		changeYear: true,
		dateFormat: 'yy-mm-dd',
		timeFormat: 'HH:mm:00'
	});*/
	jQuery('#instrument_expiry_date').datepicker({
        language: 'en',
        dateFormat: 'yyyy-mm-dd',
        timeFormat: 'hh:ii:00',
        timepicker:true,
        minDate: new Date(d), // Now can select only dates, which goes after today
        todayButton:true,
        todayButton: new Date(d),
        showEvent:"focus",
        clearButton:true,
        autoClose:true,
        onSelect: function(dateText) {
			//alert("Selected date: " + dateText);
			  $("#error_msg_sd").text("");
			  var d1=$("#instrument_date").val().split(' ');
			  
			  
				var d2=dateText.split(' ');
				 var  exptime=d2['0'].split('-');
				 var  inttime=d1['0'].split('-');
				 
				 
				 var oneDay = 24*60*60*1000; // hours*minutes*seconds*milliseconds
				 var firstDate = new Date(inttime['0'],inttime['1'],inttime['2']);
				 var secondDate = new Date(exptime['0'],exptime['1'],exptime['2']);
				 var diffDays = Math.round(Math.abs((firstDate.getTime() - secondDate.getTime())/(oneDay)));
				
			   if(diffDays<90)
			   { 
				   $("#instrument_expiry_date").prop("value",'');
				   setTimeout(function(){  $("#error_msg_sd").text("Expiry date should be Greater than 3 months than Instrument date");  }, 500);
				   return false;
				}
			}
		  
    });
    
	  /*jQuery('#instrument_expiry_date').datetimepicker({
		controlType: 'select',
		oneLine: true,
		minDate: 0,
		changeMonth: false,
		changeYear: true,
		dateFormat: 'yy-mm-dd',
		timeFormat: 'HH:mm:00'
	});*/
	
	jQuery('.html_found').change(function() {
	   if ($(this).val().match(/<(\w+)((?:\s+\w+(?:\s*=\s*(?:(?:"[^"]*")|(?:'[^']*')|[^>\s]+))?)*)\s*(\/?)>/)) {
		  alert('Invalid html content found');
		  $(this).focus();
		  $(this).val('');
	   }
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
				jQuery('#instrument_no_label').html('Instrument No');	
				jQuery('#instrument_date_label').html('Instrument date');	
			}
			//jQuery('#nodal_bank_name').val(instrument_type);
		}else{
				jQuery('#dd_expire_date').hide();	
				jQuery('#instrument_no_label').html('Instrument No');	
				jQuery('#instrument_date_label').html('Instrument date');	
		}
	});	
	
  //tooltip
  jQuery(function() {
     
    jQuery('.help-icon').tooltip();
    $("#account_no").keydown(function (e) {
        // Allow: backspace, delete, tab, escape, enter and .
        if ($.inArray(e.keyCode, [46, 8, 9, 27, 13, 110, 190]) !== -1 ||
             // Allow: Ctrl+A
            (e.keyCode == 65 && e.ctrlKey === true) ||
             // Allow: Ctrl+C
            (e.keyCode == 67 && e.ctrlKey === true) ||
             // Allow: Ctrl+X
            (e.keyCode == 88 && e.ctrlKey === true) ||
             // Allow: home, end, left, right
            (e.keyCode >= 35 && e.keyCode <= 39)) {
                 // let it happen, don't do anything
                 return;
        }
        // Ensure that it is a number and stop the keypress
        if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105 ||e.keyCode > 190)) {
            e.preventDefault();
        }
    });
  });
  
  	var specialKeys = new Array();
	specialKeys.push(8); //Backspace
	specialKeys.push(9); //Tab
	specialKeys.push(46); //Delete
	specialKeys.push(36); //Home
	specialKeys.push(35); //End
	specialKeys.push(37); //Left
	specialKeys.push(39); //Right
	function IsAlphaNumeric(e) {
		var keyCode = e.keyCode == 0 ? e.charCode : e.keyCode;
		var ret = ((keyCode >= 48 && keyCode <= 57) || (keyCode >= 65 && keyCode <= 90) || (keyCode >= 97 && keyCode <= 122) || (specialKeys.indexOf(e.keyCode) != -1 && e.charCode != e.keyCode));
		document.getElementById("error").style.display = ret ? "none" : "inline";
		return ret;
	}
</script>
</body>

</html>
