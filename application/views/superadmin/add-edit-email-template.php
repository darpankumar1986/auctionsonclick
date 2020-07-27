<script  type="text/javascript" src="<?php echo base_url(); ?>/js/texteditor/ckeditor.js"></script>
<script type="text/javascript" src="<?php echo VIEWBASE?>js/plugins/jquery.uniform.min.js"></script>
<script type="text/javascript" src="<?php echo VIEWBASE?>js/plugins/jquery.validate.min.js"></script>
<script type="text/javascript" src="<?php echo VIEWBASE?>js/custom/forms.js"></script>
<?php 
if($row){
    $email_template_id = $row->email_template_id;
    $email_template_name = $row->email_template_name;
    $subject    =   $row->subject; 
    $msg_body   =   $row->msg;
    $status     =   $row->status;
} else {	
    $email_template_id = 0;
    if(!empty($_POST)) {
        $subject =  $_POST['template_name']; 
        $subject =  $_POST['subject']; 
        $msg_body=  $_POST['msg_body'];
    }
    $status = 1;
}
?> 		
<section class="body_main1">	
		<div class="row">		
			<a href="<?php echo base_url().'superadmin/email_template/index'?>" class="button_grey">Email Template List</a>
		</div>
		<div class="box-head"><?php echo $heading; ?></div>
		<div class="centercontent">
			<div class="pageheader">
				<span class="pagedesc"><div style="color:red"><?php echo validation_errors(); ?></div></span>
			</div><!--pageheader-->
			
			
			
			<div id="contentwrapper" class="contentwrapper box-content2">
				<div id="validation" class="subcontent">            	
					<form method="post" class="stdform" id="email_template_form" name="add_data_view" accept-charset="utf-8" action="/superadmin/email_template/save/<?php if($email_template_id) echo $email_template_id;?>" autocomplete="off">	
					
					<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash();?>" />
                                        
                                        
						<div class="row">
                                                    <div class="lft_heading">Template Name<span class="red"> *</span></div>
							<div class="rgt_detail">
								<input maxlength="250" type="text" name="template_name" id="template_name" class="longinput html_found" value="<?php echo $email_template_name; ?>" />
						
							</div>	
											
						</div>
									
						<div class="row">
							<div class="lft_heading">Subject <span class="red"> *</span></div>
							<div class="rgt_detail">
								<input maxlength="250" type="text" name="subject" id="subject" class="longinput html_found" value="<?php echo $subject; ?>" />
						
							</div>	
											
						</div>
                                        
						<div class="row">
							<div class="lft_heading">Message Body<span class="red"> *</span></div>
							<div class="rgt_detail">
                                                            <textarea name="msg_body" id="msg_body" ><?php echo $msg_body; ?></textarea>
							</div>	
						</div>	
							<script>
                                                            CKEDITOR.replace('msg_body');
                                                        </script>			    
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
							<input type="submit"  class="button_grey" name="addedit" id="addedit" value="<?php echo ($email_template_id)?'Update':'Submit'?>">
							<input type="hidden" name="email_template_id" id="email_template_id" value="<?php echo $email_template_id; ?>">
							
						</div>
						
					</form>
				</div>
			</div><!--contentwrapper-->
		<br clear="all" />
	</div><!-- centercontent -->
</section>


<script>
jQuery(document).ready(function(){
	jQuery("#email_template_form").validate({
                ignore: [],
		rules: {
                        template_name: "required",
			subject: "required",		
			msg_body: "required"
		},
		messages: {
			template_name: {
				required: "Please enter template name"
				
			},
                        subject: {
				required: "Please enter subject"
				
			},
			msg_body: {
				required: "Please enter message"
			}
		}
		
		
	});
});	
</script>
