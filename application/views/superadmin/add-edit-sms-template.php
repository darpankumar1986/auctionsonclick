
<script type="text/javascript" src="<?php echo VIEWBASE?>js/plugins/jquery.uniform.min.js"></script>
<script type="text/javascript" src="<?php echo VIEWBASE?>js/plugins/jquery.validate.min.js"></script>
<script type="text/javascript" src="<?php echo VIEWBASE?>js/custom/forms.js"></script>
<?php 

if($row){
    $sms_template_id = $row->sms_template_id;
    $sms_template_name = $row->sms_template_name;
    $msg_body   =   $row->msg;
    $status     =   $row->status; 
} else {	
	$sms_template_id = 0;
	if(!empty($_POST)) {		 
		$msg_body =  $_POST['msg_body']; 
	}
	$status = 1;
}?> 		
<section class="body_main1">	
    <div class="row">		
            <a href="<?php echo base_url().'superadmin/sms_template/index'?>" class="button_grey">SMS Template List</a>
    </div>
    <div class="box-head"><?php echo $heading; ?></div>
        <div class="centercontent">
                    <div class="pageheader">
                            <span class="pagedesc"><div style="color:red"><?php echo validation_errors(); ?></div></span>
                    </div><!--pageheader-->



                    <div id="contentwrapper" class="contentwrapper box-content2">
                        <div id="validation" class="subcontent">            	
                            <form method="post" class="stdform" id="sms_template_form" name="add_data_view" accept-charset="utf-8" action="/superadmin/sms_template/save/<?php if($sms_template_id) echo $sms_template_id;?>" autocomplete="off">	

                                <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash();?>" />

                                        <div class="row">
                                            <div class="lft_heading">Template Name<span class="red"> *</span></div>
                                                <div class="rgt_detail">
                                                        <input maxlength="250" type="text" name="template_name" id="template_name" class="longinput html_found" value="<?php echo $sms_template_name; ?>" />

                                                </div>	

                                        </div>
                                        <div class="row">
                                                <div class="lft_heading">Message Body<span class="red"> *</span></div>
                                                <div class="rgt_detail">
                                                    <textarea name="msg_body" id="msg_body" rows="5" maxlength="500"><?php echo $msg_body; ?></textarea>
                                                </div>	
                                        </div>	

                                        <div class="row">
                                                <div class="lft_heading">Status<span class="red"> *</span></div>
                                                <div class="rgt_detail">
                                                <select name="status">
                                                        <option value="1" <?php if($status==1)echo 'selected';?>>Active</option>
                                                        <option value="0" <?php if($status==0)echo 'selected';?>>Inactive</option>
                                                </select>
                                                </div>	
                                        </div>	
                                        <hr>
                                        <div class="stdformbutton row" style="text-align:center;">		
                                            <a href="<?php echo base_url().'superadmin/home'?>" class="button_grey">Back</a>			
                                                <input type="submit"  class="button_grey" name="addedit" id="addedit" value="<?php echo ($sms_template_id)?'Update':'Submit'?>">
                                                <input type="hidden" name="sms_template_id" id="sms_template_id" value="<?php echo $sms_template_id; ?>">

                                        </div>
                                    </form>
                            </div>
                    </div><!--contentwrapper-->
            <br clear="all" />
    </div><!-- centercontent -->
</section>


<script>
jQuery(document).ready(function(){
	jQuery("#sms_template_form").validate({
                ignore: [],
		rules: {	
			msg_body: "required"
		},
		messages: {
			msg_body: {
				required: "Please enter message"
			}
		}
		
		
	});
});	
</script>
