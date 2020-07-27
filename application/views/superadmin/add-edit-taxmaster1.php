<script type="text/javascript" src="<?php echo VIEWBASE?>js/plugins/jquery.uniform.min.js"></script>
<script type="text/javascript" src="<?php echo VIEWBASE?>js/plugins/jquery.validate.min.js"></script>
<script type="text/javascript" src="<?php echo VIEWBASE?>js/custom/forms.js"></script>
<link rel="stylesheet" href="<?php echo base_url()?>js/calender/jquery-ui.css">
<script src="<?php echo base_url(); ?>js/calender/jquery-ui.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>js/calender/jquery-ui-timepicker-addon.min.js"></script>
<link rel="stylesheet" href="<?php echo base_url()?>js/calender/jquery-ui-timepicker-addon.css">
<?php
if ($row) {
    $id = $row->id;
    $stax = $row->stax;
    $educess = $row->educess;
    $secondaryhighertax = $row->secondaryhighertax;
    $swacchbharat_tax = $row->swacchbharat_tax;
    $krishi_kalyan = $row->krishi_kalyan;
    $from_date = $row->start_date;
    $to_date = $row->end_date;
} else {
    $status = 1;
    $id = 0;
}
?> 

<section class="body_main1">
<div class="centercontent">
	<div class="row">						
			<a href="<?php echo base_url().'superadmin/taxmaster/taxlist'?>" class="button_grey"> Tax List</a>
	</div>
	<span class="pagedesc" style="color:green;text-align:center;" id="msg_error"><?php if( $this->session->flashdata('message')) {?><?php echo $this->session->flashdata('message'); ?><?php } ?></span>
	<div class="box-head"> Manage Tax</div>
	
	<div class="pageheader">
		<span class="pagedesc"><div style="color:red"><?php echo validation_errors(); ?></div></span>
	</div><!--pageheader-->
	
		
    <div id="contentwrapper" class="contentwrapper box-content2">
		<div id="validation" class="subcontent">      
                                           
			 <form enctype="multipart/form-data" method="post" class="stdform" id="add_data_view" name="add_data_view" accept-charset="utf-8" action="/superadmin/taxmaster/save">
				
			
				<div class="row">
					<div class="lft_heading">Service Tax <span class="red"> *</span></div>
					<div class="rgt_detail">
					 <input onkeypress="return isNumberKey(event);" type="text" maxlength="15" name="stax" id="stax" class="longinput" value="<?php echo $stax ?>" />
                                         <span id="PositiveNumberError1" class="PositiveNumberError"></span>					
				        </div>
				<div class="row">
					<div class="lft_heading">Educess <span class="red"> *</span></div>
					<div class="rgt_detail">
						 <input  type="text" maxlength="15" name="educess" id="educess" class="longinput" value="<?php echo $educess ?>" />
                                                     <span id="PositiveNumberError2" class="PositiveNumberError"></span>
					</div>					
				</div>
				<div class="row">
					<div class="lft_heading">Secondary Higher Tax <span class="red"> *</span></div>
					<div class="rgt_detail">
						 <input  maxlength="15" type="text" name="secondaryhighertax" id="secondaryhighertax" class="longinput" value="<?php echo $secondaryhighertax ?>" />
                                                 <span id="PositiveNumberError3" class="PositiveNumberError"></span>
					</div>					
				</div>
				<div class="row">
					<div class="lft_heading">Swacchbharat Tax<span class="red"> *</span></div>
					<div class="rgt_detail">
					 <input  maxlength="15" type="text" name="swacchbharat_tax" id="swacchbharat_tax" class="longinput" value="<?php echo $swacchbharat_tax ?>" />
                                          <span id="PositiveNumberError3" class="PositiveNumberError"></span>
					</div>
				</div>	
				<div class="row">
					<div class="lft_heading">krishi_kalyan Tax<span class="red"> *</span></div>
					<div class="rgt_detail">
					 <input  maxlength="15" type="text" name="krishi_kalyan" id="krishi_kalyan" class="longinput" value="<?php echo $krishi_kalyan ?>" />
                                          <span id="PositiveNumberError4" class="PositiveNumberError"></span>
					</div>
				</div>
				<div class="row">
                    <div class="lft_heading">Tax From Date<font color='red'>*</font></div>
                    <div class="rgt_detail">
                       <input type="text" id="start_date" value="<?php echo $from_date;?>" class="longinput" name="start_date">
                        
                    </div>					
                </div>
                <div class="row">
                    <div class="lft_heading">Tax To Date<font color='red'>*</font></div>
                    <div class="rgt_detail">
                        <input type="text" value="<?php echo $to_date;?>" id="end_date" name="end_date">
                    </div>					
                </div>
                
				<hr>
				<div class="stdformbutton row" style="text-align:center;">		
					 <input type="submit"  name="addedit" id="addedit" value="<?php echo ($id) ? 'Update' : 'Submit' ?>">
                                        <input type="hidden" name="id" id="id" value="<?php echo $id ?>">
				</div>
				
			</form>
        </div>
	</div><!--contentwrapper-->
    <br clear="all" />
</div><!-- centercontent -->
</section>

<script>
	jQuery(document).ready(function() {
   
      jQuery('#start_date').datetimepicker({
		controlType: 'select',
		oneLine: true,
		changeMonth: true,
		changeYear: true,
		dateFormat: 'yy-mm-dd',
		yearRange: '2016:2019',
		timeFormat: 'HH:mm:00'
	});
	jQuery('#end_date').datetimepicker({
		controlType: 'select',
		oneLine: true,
		changeMonth: true,
		changeYear: true,
		dateFormat: 'yy-mm-dd',
		yearRange: '2016:2019',
		timeFormat: 'HH:mm:00'
	});
       
    });
jQuery(document).ready(function(){
	jQuery("#add_data_view").validate({
		rules: {
				stax: {
					//alphanumeric: true,
					required: true,
				},
			educess: "required",
			secondaryhighertax: "required",
			krishi_kalyan: "required",
			swacchbharat_tax: "required",
			start_date: "required",
			end_date: "required",
		},
		messages: {
			stax: {
				required: "Please enter stax",
			},
			educess: {
				required: "Please select educess"
			},
			secondaryhighertax: {
				required: "Please select secondaryhighertax"
			},
			krishi_kalyan: {
				required: "Please select krishi_kalyan"
			},
			swacchbharat_tax: {
				required: "Please select swacchbharat_tax"
			},
			start_date: {
				required: "Please select from date"
			},
			end_date: {
				required: "Please select to date"
			}
			
		}
	});
		
			jQuery.validator.addMethod("alphanumeric", function(value, element) {
        return this.optional(element) || /^[a-z0-9\\-\s]+$/i.test(value);
    }, "Name must contain only letters, numbers, or dashes.");
});	

	
</script>
