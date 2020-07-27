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
<link rel="stylesheet" href="<?php echo base_url()?>bankeauc/css/common.css">
<script src="<?php echo base_url()?>/js/jquery.min.js"></script>

<?php /* ?>
<link rel="stylesheet" href="<?php echo base_url()?>js/calender/jquery-ui.css">
<script src="<?php echo base_url(); ?>js/calender/jquery-ui.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>js/calender/jquery-ui-timepicker-addon.min.js"></script>
<link rel="stylesheet" href="<?php echo base_url()?>js/calender/jquery-ui-timepicker-addon.css">
<script type="text/javascript" src="<?php echo base_url(); ?>js/calender/i18n/jquery-ui-timepicker-addon-i18n.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/calender/jquery-ui-sliderAccess.js"></script>
<?php */ ?>

<link href="<?php echo base_url() ?>js/calendar_new/dist/css/datepicker.min.css" rel="stylesheet" type="text/css">
<script src="<?php echo base_url() ?>js/calendar_new/dist/js/datepicker.min.js"></script>
		<!-- Include English language -->
<script src="<?php echo base_url() ?>js/calendar_new/dist/js/i18n/datepicker.en.js"></script>


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
<?php //print_r($emdrow);?>
<section>
  <div class="row">
    <div class="wrapper-full">
      <div class="dashboard-wrapper">
        
        <div class="container">
          
          <div class="secttion-right" style="width:100%;">
		  <form name="submitEmdtender" id="submitEmdtender" action="/owner/SaveAuctionTender" method="post" enctype="multipart/form-data">
			   <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash();?>" />
            <div class="form" style="text-align:center;">
			<div class="heading4 btmrg20">Auction/Tender Fee</div>
		<div class="success_msg">	<?php echo $msg;?></div>
			<div class="seprator btmrg20"></div>
			<ul id="spMsg"></ul>
              <dl>
                <dt class="required">
                  <label>Bank Name.</label>
                </dt>
                <dd>
                  <input name="bank_name" autocomplete="off" id="bank_name" type="text" value="<?php echo $tenderrow->bank_name;?>" class="input">
                  <span class="help-icon" title="Please write the bank name from which the DD has been issued or RTGS payment for EMD is remitted."></span> </dd>
              </dl>
              <dl>
                <dt class="required">
                  <label>Amount</label>
                </dt>
                <dd>
				<?php
					$tender_fee_amt=GetTitleByField('tbl_auction', "id='".$auction_id."'", 'tender_fee');	
				?>
                  <input disabled name="amount" id="amount" value="<?php echo number_format($tender_fee_amt,2);?>" type="text"  class="input">
				   <span class="help-icon" title="This is the reserve price fixed for the Auction. The DD/ RTGS/Challan being submitted must be of the same value."></span>
				  <span style="font-size:12px; padding-top: 8px;">(<?php echo getAmountInWords($tender_fee_amt) ; ?> Only)</span>
				 
                </dd>
              </dl>
			  
              <dl>
                <dt class="required">
                  <label>Instrument type</label>
                </dt>
                <dd>
                  <select name="instrument_type" id="instrument_type" class="select1" >
                    <option value="">Select</option>
                    <option value="1" <?php if($tenderrow->instrument_type==1){ echo $sel="selected";}else{ $sel='';}?>>RTGS/NEFT RECIEPT</option>
                    <option value="2" <?php if($tenderrow->instrument_type==2){ echo $sel="selected";}else{ $sel='';}?>>DD</option>
                    <option value="3" <?php if($tenderrow->instrument_type==3){ echo $sel="selected";}else{ $sel='';}?>>CHALAN RECIEPT</option>
                  </select>
				  <span class="help-icon" title="Please choose type of instrument which you are using for paying EMD. This may be DD/ RTGS payment receipt/Chalan of remittance of the EMD."></span>
                </dd>
              </dl>
			  <?php
			  if($tenderrow->instrument_type==1)
			  {
				 $instrument_no='RTGS/NEFT RECIEPT No.';
				 $instrument_date='RTGS/NEFT RECIEPT date';
				 $instrument_expiry_date='DD expiry date';
			  }
			  else if($tenderrow->instrument_type==2)
			  {
				 $instrument_no='DD No.';
				 $instrument_date='DD date';
				 $instrument_expiry_date='DD expiry date';
			  }
			  else if($tenderrow->instrument_type==3)
			  {
				 $instrument_no='CHALAN RECIEPT No.';
				 $instrument_date='CHALAN RECIEPT date ';
				 $instrument_expiry_date='DD expiry date'; 
			  }
			  else{
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
                   <input name="instrument_no" maxlength="30" autocomplete="off" id="instrument_no" value="<?php echo $tenderrow->instrument_no;?>" type="text"  class="input">
				   <span class="help-icon" title="DD No./ RTGS UTR No./ Challan no."></span>
                </dd>
              </dl>
              <dl>
                <dt class="required">
                  <label id="instrument_date_label"><?php echo $instrument_date;?></label>
                </dt>
                <dd>
                   <input readonly name="instrument_date" autocomplete="off" value="<?php echo $tenderrow->instrument_date;?>" id="instrument_date" type="text"  class="input">
				   <span class="help-icon" title="Date of issue of DD/ date of the RTGS Payment as per the Reciept/ Date of the remittance of the payment by challan as per the challan"></span>
                </dd>
              </dl>
				<dl id="dd_expire_date" id="dd_expire_date" <?php if($tenderrow->instrument_type != 2){ echo $dis='style="display:none;"';}else{ echo $dis='style="display:block;"';}?>>
                <dt class="required">
                  <label><?php echo $instrument_expiry_date;?></label>
                </dt>
                <dd>
                   <input readonly name="instrument_expiry_date"  value="<?php echo $tenderrow->instrument_expiry_date;?>" id="instrument_expiry_date" type="text"  class="input">
				   <span class="help-icon" title="Date of expiry of the DD. For RTGS/Challan payment expiry date is not required"></span>
				   <span id="error_msg_sd" style="color:#900;font-size: 12px;text-align: left;width: 65%;"></span>
                </dd>
              </dl>
              <dl>
                <dt>
                  <label>Upload supporting document</label>
                </dt>
                <dd>
                  <input name="supporting_doc_path"  id="supporting_doc_path" type="file"  class="input">
				  <span class="help-icon" title="Please upload the scanned copy of the(DD/ BG/ PO/ Challan of remittance in the nodal bank account/ RTGS transfer receipt."></span>
				  <?php if($tenderrow->supporting_doc){ ?>
				  <a style="font-size:11px;" target="_blank" href="/public/uploads/document/<?php echo $auction_id; ?>/<?php echo $bidderid ?>/tender_supporting_doc/<?php echo $tenderrow->supporting_doc;?>"><?php echo $tenderrow->supporting_doc;?></a>
				  <input type="hidden" name="supporting_doc_path_old" value="<?php echo $tenderrow->supporting_doc; ?>">
				  <?php } ?>
                </dd>
              </dl>
             
              <div class="seprator btmrg20"></div>
            <div class="button-row"> 
			<input name="submit" onclick="return ValidateEmdTenderDate();" value="<?php if($tenderrow->id){ echo $sub='Update';}else{ echo $sub='Submit'; }?> " type="submit" class=" button_grey" style="margin-top:5px;">
			<input type="hidden" name="auction_id" value="<?php echo $auction_id;?>" >
			<input type="hidden" name="tenderID" value="<?php echo $tenderrow->id;?>" >
			<input type="hidden" name="bidderid" value="<?php echo $bidderid;?>" >
			<input type="hidden" name="currdate" id="currdate" value="<?php echo date("Y-m-d H:i:s") ?>" />
			
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
	
	 $("#instrument_expiry_date").change(function(){ 		
             $("#error_msg_sd").text("");
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
                   param= parseInt(param);
                   //alert(element.files[0].size+'--'+param);
                // param = size (in bytes) 
                // element = element to validate (<input>)
               // value = value of the element (file name)
           return this.optional(element) || (element.files[0].size <= param) 
        });
	jQuery("#submitEmdtender").validate({
		rules: {
			bank_name: "required",
			amount: "required",
			bank_id: "required",
			instrument_type: "required",
			instrument_no: "required",
			instrument_date: "required",
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
			amount: {
				required: "Please Account Number."
			},
			instrument_type:{
				required: "Please Enter Instrument type."
			}
			,
			instrument_no: {
				required: "Please Enter Instrument No."
			},
			instrument_date: {
				required: "Please Enter Insturment Date."
			},
			instrument_expiry_date:{
			required: "Please Enter Expiry Date."	
			},
                        supporting_doc_path:{
                            accept:"Please Upload Valid document Format Accepted format (png,jpg,gif,jpeg,pdf,xls,doc,docx,zip).",
                           filesize:"Please Upload File less than 5 MB"
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


	/*jQuery('#instrument_date').datetimepicker({
		controlType: 'select',
		oneLine: true,
		maxDate: 0,
		changeMonth: false,
		changeYear: true,
		dateFormat: 'yy-mm-dd',
		timeFormat: 'HH:mm:00'
	});
	
	  jQuery('#instrument_expiry_date').datetimepicker({
		controlType: 'select',
		oneLine: true,
		minDate: 0,
		changeMonth: false,
		changeYear: true,
		dateFormat: 'yy-mm-dd',
		timeFormat: 'HH:mm:00'
	});*/
	
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
        position: "right",
        maxDate: new Date(d), // Now can select only dates, which goes after today
        todayButton:true,
        todayButton: new Date(d),
        showEvent:"focus",
        clearButton:true,
        autoClose:true,
    });
    
    
    jQuery('#instrument_expiry_date').datepicker({
        language: 'en',
        dateFormat: 'yyyy-mm-dd',
        timeFormat: 'hh:ii:00',
        timepicker:true,
        position: "right",
        minDate: new Date(d), // Now can select only dates, which goes after today
        todayButton:true,
        todayButton: new Date(d),
        showEvent:"focus",
        clearButton:true,
        autoClose:true,
        onSelect: function(dateText) {
					$("#error_msg_sd").text("");
					  var d1=$("#instrument_date").val().split(' ');
					  var d2=dateText.split(' ');
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
				jQuery('#dd_expire_date').val('');	
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
  });
</script>
</body>

</html>
