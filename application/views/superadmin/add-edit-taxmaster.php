<script type="text/javascript" src="<?php echo VIEWBASE ?>js/plugins/jquery.uniform.min.js"></script>
<script type="text/javascript" src="<?php echo VIEWBASE ?>js/plugins/jquery.validate.min.js"></script>
<script type="text/javascript" src="<?php echo base_url();?>js/common.js"></script>
<script type="text/javascript" src="<?php echo VIEWBASE ?>js/custom/forms.js"></script>
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
    $krishi_kalyan = $row->krishi_kalyan;
    
} else {
    $status = 1;
    $id = 0;
}
?> 
<div class="centercontent">
    <div class="pageheader">
        <h1 class="pagetitle"><?php echo $heading; ?></h1>
        		
    </div><!--pageheader-->
    <div id="contentwrapper" class="contentwrapper">
        <div id="validation" class="subcontent">   
<span class="pagedesc" style="color:red;text-align:center;" id="msg_error"><?php if( $this->session->flashdata('message')) {?><?php echo $this->session->flashdata('message'); ?><?php } ?></span>		
            <form enctype="multipart/form-data" method="post" class="stdform" id="add_data_view" name="add_data_view" accept-charset="utf-8" action="/superadmin/taxmaster/save">	

                <p>
                    <label>Stax <font color='red'>*</font></label>
                    <span class="field">
                        <input onkeypress="return isNumberKey(event);" type="text" maxlength="15" name="stax" id="stax" class="longinput" value="<?php echo $stax ?>" />
                        <span id="PositiveNumberError1" class="PositiveNumberError"></span>
                    </span>					
                </p>
                <p>
                    <label>Educess<font color='red'>*</font></label>
                    <span class="field">
                        <input  type="text" maxlength="15" name="educess" id="educess" class="longinput" value="<?php echo $educess ?>" />
                        <span id="PositiveNumberError2" class="PositiveNumberError"></span>
                    </span>					
                </p>
                <p>
                    <label>Secondary Higher Tax <font color='red'>*</font></label>
                    <span class="field">
                        <input  maxlength="15" type="text" name="secondaryhighertax" id="secondaryhighertax" class="longinput" value="<?php echo $secondaryhighertax ?>" />
                        <span id="PositiveNumberError3" class="PositiveNumberError"></span>
                    </span>					
                </p>
                <p>
                    <label>krishi_kalyan Tax <font color='red'>*</font></label>
                    <span class="field">
                        <input  maxlength="15" type="text" name="krishi_kalyan" id="krishi_kalyan" class="longinput" value="<?php echo $secondaryhighertax ?>" />
                        <span id="PositiveNumberError4" class="PositiveNumberError"></span>
                    </span>					
                </p>
                <p>
                    <label>Tax From Date<font color='red'>*</font></label>
                    <span class="field">
                       <input type="text" id="start_date" value="<?php echo $from_date;?>" name="from_date">
                        
                    </span>					
                </p>
                <p>
                    <label>Tax To Date<font color='red'>*</font></label>
                    <span class="field">
                        <input type="text" value="<?php echo $to_date;?>" id="end_date" name="to_date">
                    </span>					
                </p>



<!--<p>
        <label>Status</label>
        <span class="field">
        <select name="status">
                <option value="1" <?php if ($status == 1) echo 'selected'; ?>>Active</option>
                <option value="0" <?php if ($status == 0) echo 'selected'; ?>>Inactive</option>
        </select>
        </span>
</p>	-->

                <p class="stdformbutton">					
                    <input type="submit"  name="addedit" id="addedit" value="<?php echo ($id) ? 'Update' : 'Submit' ?>">
                    <input type="hidden" name="id" id="id" value="<?php echo $id ?>">
                    
                </p>

            </form>
        </div>
    </div><!--contentwrapper-->
    <br clear="all" />
</div><!-- centercontent -->
<style>
    .PositiveNumberError{
        color: #f00;
        display: block;
        font-size: 11px;
        font-weight: bold;
        text-align: left;
    }
</style>
<script>
    jQuery(document).ready(function () {
       
        jQuery("#add_data_view").validate({
            rules: {
                stax: {
                    required: true,
                    hideerrormsg: true,
                    number: true,
					notEqual: "0" 
                },
                educess: {
                    required: true,
                    number: true,
					hideerrormsg: true,
					notEqual: "0" 
                },
                secondaryhighertax: {
                    required: true,
					hideerrormsg: true,
                    number: true,
					notEqual: "0" 
                },
                krishi_kalyan: {
                    required: true,
					hideerrormsg: true,
                    number: true,
					notEqual: "0" 
                }
            },
            messages: {
                stax: {
                    required: "Please enter stax",
                    number: "Please enter valid number",
                    rangelength: "The value must be greater then 0"
                },
                educess: {
                    required: "Please enter educess",
					 number: "Please enter valid number",
					 rangelength: "The value must be greater then 0"
                },
                secondaryhighertax: {
                    required: "Please enter secondary higher tax",
					 number: "Please enter valid number",
					 rangelength: "The value must be greater then 0"
                },
                krishi_kalyan: {
                    required: "Please enter krishi_kalyan tax",
					number: "Please enter valid number",
					rangelength: "The value must be greater then 0"
                }
            },
			
			submitHandler: function(form) {
				jQuery("#msg_error").hide();
				form.submit();
				return true;
			},
			invalidHandler: function(event, validator) {
				jQuery("#msg_error").hide();
				 //var errors = validator.numberOfInvalids();
			}
			
        });
		
		
		
    });
	

		jQuery.validator.addMethod("notEqual", function(value, element, param) {
  return this.optional(element) || value != param;
}, "The value must be greater then 0");

	jQuery.validator.addMethod("hideerrormsg", function(value) {
		return jQuery("#msg_error").hide();
	},'');

</script>
