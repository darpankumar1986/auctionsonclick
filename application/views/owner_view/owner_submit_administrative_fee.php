<!DOCTYPE HTML>
<html>
    <head>
        <meta charset="utf-8">
        <title>Administrative Fee</title>
        <meta name="description" content="bankEauction" />
        <meta name="keywords" content="bankEauction" />
        <!-- Mobile Specific Metas -->
        <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
        <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
        <link rel="stylesheet" href="/css/bace.css">
        <link rel="stylesheet" href="/css/admin-style.css">
        <link rel="stylesheet" href="/css/nav.css">
        <link rel="stylesheet" href="/css/banner.css">
        <script src="<?php echo base_url() ?>js/jquery.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url() ?>js/common.js"></script>       
        <style>
            .error_class{
               font-family:verdana;
               color:#F00;
               font-size:10.5px;
            }
            .form dl dd{float:none;text-align: left;width:100%}
            
        </style>
        <!--[if IE]>
        <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->
        <!--[if IE]>
        <script type="text/javascript" src="/js/respond.js"></script>
        <![endif]-->
        <script src="http://ajax.googleapis.com/ajax/libs/jquery/2.0.0/jquery.min.js"></script>
        <link rel="stylesheet" href="<?php echo base_url()?>js/calender/jquery-ui.css">
		<script src="<?php echo base_url(); ?>js/calender/jquery-ui.js"></script>
        <script type="text/javascript" src="<?php echo base_url()?>js/calender/jquery-ui-timepicker-addon.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url()?>js/jquery.validate.min.js"></script>
        <script type="text/javascript" src="<?php echo base_url()?>js/additional-methods.min.js"></script>
		<link rel="stylesheet" href="<?php echo base_url()?>js/calender/jquery-ui-timepicker-addon.css">
    </head>
    <body>
        <?php
        //echo $auction_id;
		//print_r($utrDetails);
        ?>
        <section>
            <div class="row">
                <div class="wrapper-full">
                    <div class="dashboard-wrapper">

                        <div class="container">
                            <div><ul class="error_class"></ul>
                                <span class="success_msg" style="color:#009000; font-weight: bold;"><?php echo $msg;?></span>
                            </div>
                            <div class="secttion-right" style="width:100%;"> 
                                <div class="form" style="text-align:center;">
                                    <form name="uaed" action="/owner/uploadAuctionEmdDocument" method="post" enctype="multipart/form-data" id="uaed">
										<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash();?>" />
                                        <div class="heading4 btmrg20">Administrative Fee</div>
                                        <div class="seprator btmrg20"></div>
										<table border="1" align="left" cellpadding="2" cellspacing="1" class="mytable dataTable" id="big_table" aria-describedby="big_table_info">
										  <tbody role="alert" aria-live="polite" aria-relevant="all">               
											<tr class="even">
												<td align="left" valign="top" class="" width="25%"><strong>UTR No.:</strong></td>
												<td align="left" valign="top" class=""><input type="text" name="utr_no" id="utr_no" value="<?php echo $utrDetails[0]->utr_no; ?>"></td>					
											</tr>
											<tr class="odd">
												<td align="left" valign="top" class=""><strong>A/c No:</strong></td>
												<td align="left" valign="top" class="">914010003068671</td>				
											</tr>
											<tr class="even">
												<td align="left" valign="top" class=""><strong>Name of A/c:</strong></td>
												<td align="left" valign="top" class="">GORAKHPUR DEVELOPMENT AUTHORITY GORAKHPUR</td>					
											</tr>
											<tr class="odd">                 
											  <td align="left" valign="top" class=""><strong>Bank Details:</strong></td>
											  <td align="left" valign="top" class="">Axis Bank Ltd</td>
											</tr>
											<tr class="even">
												<td align="left" valign="top" class=""><strong>Branch:</strong></td>
												<td align="left" valign="top" class="">Gorakhpur, UP</td>					
											</tr>
											
											<tr class="odd">
												<td align="left" valign="top" class=""><strong>IFSC Code:</strong></td>
												<td align="left" valign="top" class="">UTIB0000331</td>					
											</tr>
											
											<tr class="even">
												<td align="left" valign="top" class=""><strong>Bank Address:</strong></td>
												<td align="left" valign="top" class="">Plot No. 560, Cross Road The Mall, Near Bank Road, Gorakhpur - 273001</td>					
											</tr>
											 
										  </tbody>             
										</table>    
										<div class="seprator btmrg20"></div>
                                        <div class="button-row"> 
                                            <input type="hidden" name="utr_type" value="1" >
                                            <input type="hidden" name="auction_id" value="<?php echo $auction_id; ?>" >
                                            <input type="hidden" name="bidderid" value="<?php echo $bidderid; ?>" >
                                            <input type="submit" name="emd_doc" value="Submit"  class="b_submit button_grey"  style="margin-top:5px;">
                                        </div>
                                    </form>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </body>
</html>
<script>
jQuery("#uaed").validate({
		rules: {
			utr_no: "required"
			
		},
		messages: {
			utr_no: "Please Enter UTR Number."
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

jQuery('.numericonly').keypress(function(event) {
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

jQuery(document).ready(function(){
	
	jQuery('#emd_doc_name1').change(function () {
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
			//case 'png':case 'jpg':case 'gif':case 'jpeg':case 'pdf':case 'xls':case 'doc':case 'docx':case 'zip':
			case 'jpg':case 'pdf':case 'jpeg':
			$('.input').attr('disabled', false);
			break;
			default:
				alert('This is not an allowed file type. Only jpg and pdf file is allowed.');
				this.value = '';
		}
	});
	
	jQuery('#dd_date').datepicker({
		controlType: 'select',
		oneLine: true,
		//minDate: 0,
		//maxDate: 0,
		changeMonth: true,
		changeYear: true,
		dateFormat: 'dd-mm-yy',
		yearRange: '2017:<?php echo date('Y')?>'
	});			
		
		
  <?php if($msg){	?>
		 //setTimeout(function(){ parent.jQuery.colorbox.close() }, 3000);
	<?php } ?> 
 });
 
</script>
