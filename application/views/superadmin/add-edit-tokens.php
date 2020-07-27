<script type="text/javascript" src="<?php echo VIEWBASE?>js/plugins/jquery.uniform.min.js"></script>
<script type="text/javascript" src="<?php echo VIEWBASE?>js/plugins/jquery.validate.min.js"></script>
<script type="text/javascript" src="<?php echo VIEWBASE?>js/custom/forms.js"></script>

<style>
    .readonly {
    background: #ddd !important;
}
</style>

<?php 

if($row){    
    $token_id  	= $row->token_id;
    $token_name = $row->token_name;
    $token_type	= $row->token_type;    
    $status     = $row->status;
}
else
{	
    $token_id = 0;
    if(!empty($_POST)) {        
        $token_name  = $_POST['token_name'];
        $token_type  = $_POST['token_type'];        
    }
    $status = 1;
}?> 		
<section class="body_main1">	
	<div class="row">		
		<a href="<?php echo base_url().'superadmin/tokens/index'?>" class="button_grey">Tokens List</a>
	</div>
	<div class="box-head"><?php echo $heading; ?></div>
	<div class="centercontent">
		<div class="pageheader">
			<span class="pagedesc"><div style="color:red"><?php //echo validation_errors(); ?></div></span>
		</div><!--pageheader-->
		<div id="contentwrapper" class="contentwrapper box-content2">
			<div id="validation" class="subcontent">            	
				<form method="post" class="stdform" id="token_form" name="add_data_view" accept-charset="utf-8" action="/superadmin/tokens/save/<?php if($token_id) echo $token_id;?>" autocomplete="off">	

					<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash();?>" />

					<div class="row">
						<div class="lft_heading">Token Name<span class="red"> *</span></div>
						<div class="rgt_detail">
							<input type="text" name="token_name" id="token_name" class="longinput html_found" value="<?php echo $token_name ; ?>" />
							<?php echo form_error('token_name'); ?>
						</div>
					</div>
					<div class="row">
						<div class="lft_heading">Token Type<span class="red"> *</span></div>
						<div class="rgt_detail">
							<select name="token_type">
								<option value="">Select Token Type</option>
								<option value="1" <?php if($token_type==1)echo 'selected';?>>Email</option>
								<option value="2" <?php if($token_type==2)echo 'selected';?>>Demand Note</option>
							</select>
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
						<input type="submit"  class="button_grey" name="addedit" id="addedit" value="<?php echo ($token_id)?'Update':'Submit'?>">
						<input type="hidden" name="token_id" id="token_id" value="<?php echo $token_id; ?>">
					</div>
				</form>
			</div>
		</div><!--contentwrapper-->
		<br clear="all" />
	</div><!-- centercontent -->
</section>



<script>
jQuery(document).ready(function(){ 
    
    
    jQuery("#token_form").validate({
        ignore: [],
        rules: {            
            token_name:{
				required:true,
				remote: {
						url: "/superadmin/tokens/uniquetoken",
						type: "post",
						data: {
							token_name: function() {
								return jQuery( "#token_name" ).val();
								jQuery("lavel").text('');
							},					
							token_id: function() {
								return jQuery( "#token_id" ).val();
							}
						}
					}		
			},
            token_type: "required"            
        },
        messages: {           
             token_name: {
                required: "Please enter token name.",
				remote: jQuery.validator.format("{0} is already in use")
            },
            token_type: {
                required: "Please select token type."
            }
        }

    });
});	
</script>
 
