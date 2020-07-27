<!DOCTYPE HTML>
<html>
    <head>
        <meta charset="utf-8">
        <title>KDA</title>
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
//print_r($document);
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
                                        <div class="heading4 btmrg20">Upload EMD Document</div>
                                        <div class="seprator btmrg20"></div>
										<dl>
											<dt class="required">
											<label>EMD Document</label>											
											</dt>
											<dd>
												<input name="emd_doc_name" type="file" id="emd_doc_name"  class="input">	
												 <?php if ($emdDoc[0]->emd_document_name !='') { ?>											
													<div style="width: 100%;float: left;padding-bottom:5px;text-align: left;font-size: 12px;font-weight: bold; margin-top:-5px;">
													<a target="_blank" href="/public/uploads/emd_doc/<?php echo $auction_id; ?>/<?php echo $bidderid; ?>/<?php echo $emdDoc[0]->emd_document_name; ?>">View</a></div>

													<input type="hidden" name="old_emd_doc_name" id="old_emd_doc_name" value="<?php echo $emdDoc[0]->emd_document_name; ?>"> 
											<?php } ?>	
											</dd>
										</dl>
										<dl>
											<dt class="required">
											<label>Bank Name</label>											
											</dt>
											<dd>
												<input name="bank_name" type="text" id="bank_name"  class="input" value="<?php echo $emdDoc[0]->bank_name; ?>">
											</dd>
										</dl>
										<dl>
											<dt class="required">
											<label>DD Amount</label>											
											</dt>
											<dd>
												<input name="dd_amount" type="text" id="dd_amount"  class="input numericonly" value="<?php echo $emdDoc[0]->dd_amount; ?>">
											</dd>
										</dl>
										<dl>
											<dt class="required">
											<label>DD Number</label>											
											</dt>
											<dd>
												<input name="dd_no" type="text" id="dd_no"  class="input" value="<?php echo $emdDoc[0]->dd_no; ?>">
											</dd>
										</dl>
										<dl>
											<dt class="required">
											<label>DD Date</label>											
											</dt>
											<dd>
												<input name="dd_date" type="text" id="dd_date" class="input" value="<?php echo $emdDoc[0]->dd_date; ?>">
											</dd>
										</dl>
											
										<div class="seprator btmrg20"></div>
                                        <div class="button-row"> 
                                            <input type="hidden" name="documentid" value="<?php echo $doc_to_be_submitted; ?>" >
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
			bank_name: "required",
			dd_amount: "required",
			dd_no: "required",
			dd_date: "required",
			emd_doc_name:{
				<?php if ($emdDoc[0]->emd_document_name !='') {}else{ ?>		
				required: true,			
				<?php } ?>					
				extension: "jpg|jpeg|pdf"
			}
		},
		messages: {
			bank_name: "Please Enter Bank Name.",
			dd_amount: "Please Enter DD Amount.",
			dd_no: "Please Enter DD Number.",
			dd_date: "Please Enter DD Date.",
			emd_doc_name:{
				<?php if ($emdDoc[0]->emd_document_name !='') {}else{ ?>		
				required: "Please upload Emd Document",
				<?php } ?>				   
			   extension:"Please Upload Valid document Format Accepted format (jpg,pdf).",
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
