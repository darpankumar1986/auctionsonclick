<style>
	@media only screen and (max-width: 760px),
(min-device-width: 768px) and (max-device-width: 1024px)  {

	/* Force table to not be like tables anymore */
	.mytable1 table, .mytable1 thead, .mytable1 tbody, .mytable1 th, .mytable1 td, .mytable1 tr { 
		display: block; 
	}
	
	/* Hide table headers (but not display: none;, for accessibility) */
	.mytable1 thead tr { 
		position: absolute;
		top: -9999px;
		left: -9999px;
	}
	
	.mytable1 tr { border: 1px solid #ccc; }
	
	.mytable1 td { 
		/* Behave  like a "row" */
		border: none;
		border-bottom: 1px solid #eee; 
		position: relative;
		padding-left: 50%; 
		font-size:12px;
	}
	.mytable1 td.required{font-weight:bold;}
	.mytable1 td:before { 
		/* Now like a table header */
		position: absolute;
		/* Top/left values mimic padding */
		top: 6px;
		left: 6px;
		width: 45%; 
		padding-right: 10px; 
		white-space: nowrap;
	}
	.mytable tfoot{display:none;}
}
</style>
<section>
		<div class="row">
			<div class="secttion-right" style="width:95%;">
			<form name="submitEmd" id="submitEmd" action="/owner/SaveAuctionAmt" method="post" enctype="multipart/form-data">
				<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash();?>" />
				<div class="form emd_form" style="text-align:center;">
					<div class="heading4 btmrg20">Bank Processing Fee</div>
					<div class="success_msg"><?php echo $msg;?></div>
					<div class="btmrg20"></div>
						<ul id=""></ul>
						<?php 
							if($this->uri->segment(5) == 'emd')
							{						
						?>								
								<table width="100%" class="display mytable mytable1 dataTable">
									<tr>
										<td class="required">
											<label>Bank Processing Fee</label>
										</td>
										<td>
											<?php echo $amount = $auctionData->tender_fee;?>									
										</td>
								
									</tr>
								<!--<tr>
									<td class="required">
										<label>EMD Fee</label>
									</td>
									<td>
										<?php //echo $amount = $auctionData->emd_amt;?>									
									</td>
								</tr>-->
								</table>
						<?php
							}
							else
							{
						?>
								<dl>
									<dt class="required">
										<label>Bank Processing Fee</label>
									</dt>
									<dd>
										<?php echo $amount = $auctionData->tender_fee;?>									
									</dd>
								</dl>
						<?php
						}
						?>
							<dl>
								<dt>
									
								</dt>
								<dd>
									<input name="success" id="success" value="Proceed" type="submit"  class="button_grey">
									<input name="failure" id="failure" value="Cancel" type="submit"  class="button_grey">
									<input type="hidden" name="amount" value="<?php echo $amount;?>" />
									<input type="hidden" name="fee_type" value="<?php echo $this->uri->segment(5);?>" />
									<input type="hidden" name="auction_id" value="<?php echo $this->uri->segment(4);?>" />
									<input type="hidden" name="bidder_id" value="<?php echo $this->uri->segment(3);?>" />
								</dd>
							</dl>
			
							
							
							
							
							<div class="seprator btmrg20"></div>
							
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
				required: "Please Enter Organization Name."
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
