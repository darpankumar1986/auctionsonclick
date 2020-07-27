<script type="text/javascript" src="<?php echo VIEWBASE?>js/plugins/jquery.uniform.min.js"></script>
<script type="text/javascript" src="<?php echo VIEWBASE?>js/plugins/jquery.validate.min.js"></script>
<?php 
if($row){
	$id=$row->id; 
	$firstname=$row->first_name." ".$row->last_name; 
	$organisation_name=$row->organisation_name;
	$type=$row->register_as;
	$email=$row->email_id; 
	
	$userid=$row->user_id; 
	$status=$row->status; 
	if($status == '1')
	{
			$status1 = 'Active';
	}else if($status == '0')
	{
		$status1 = 'Inactive';
	}else if($status == '9')
	{
		$status1 = 'Block';
	}else{
		$status1 = 'N/A';
	}

} else {
	$status = 1;
	$id = 0;
	if(!empty($_POST)) {
	}
}?> 		
<section class="body_main1">	
		<div class="row">		

					<a href="<?php echo base_url().'superadmin/pass'?>" class="button_grey"> Bidder List</a>
		</div>
		<?php if( $this->session->flashdata('error')) {?>
								<span class="success_msg"><img src="<?php echo VIEWBASE; ?>images/icon_checkmark_small.png" class="success_tick">
								<?php echo $this->session->flashdata('error'); ?></span>		
						<?php } ?>
		<div class="box-head">Change Bidder Password</div>
		<div class="centercontent">
			<div class="pageheader">
				<span class="pagedesc"><div style="color:red"><?php echo validation_errors(); ?></div></span>
			</div><!--pageheader-->
			<div id="contentwrapper" class="contentwrapper box-content2">
				<div id="validation" class="subcontent">            	
					<form enctype="multipart/form-data" method="post" class="stdform" id="category" name="add_data_view" accept-charset="utf-8" action="/superadmin/pass/saveBidder/<?php if($id) echo $id;?>">	
		
						<div class="row">
							<div class="lft_heading">Name</div>
							<div class="rgt_detail">
								<?php echo $firstname; ?>
							</div>				
						</div>
						<div class="row">
							<div class="lft_heading">Organisation name</div>
							<div class="rgt_detail">
								<?php echo $organisation_name; ?>
							</div>				
						</div>
						<div class="row">
							<div class="lft_heading">Email</div>
							<div class="rgt_detail">
								<?php echo $email; ?>
							</div>				
						</div>
						<div class="row">
							<div class="lft_heading">Type</div>
							<div class="rgt_detail">
								<?php echo $type; ?>
							</div>				
						</div>
						<div class="row">
							<div class="lft_heading">Name</div>
							<div class="rgt_detail">
								<?php echo $firstname; ?>
							</div>				
						</div>
						<div class="row">
							<div class="lft_heading">Current Status</div>
							<div class="rgt_detail">
								<?php echo $status1; ?>
							</div>				
						</div>
						
						<div class="row">
							<div class="lft_heading">New Password<span class="red"> *</span></div>
							<div class="rgt_detail">
								<input maxlength="100" type="text" name="password" id="password" class="longinput" value="" />
							</div>	
											
						</div>
						<div class="row">
							<div class="lft_heading">Status<span class="red"> *</span></div>
							<div class="rgt_detail">
							<select name="status">
								<option value="1" <?php if($status==1)echo 'selected';?>>Active</option>
								<option value="0" <?php if($status==0)echo 'selected';?>>Inactive</option>
								<option value="9" <?php if($status==9)echo 'selected';?>>Blocked</option>
							</select>
							</div>	
						</div>	
						<hr>
						<div class="stdformbutton row" style="text-align:center;">		
						    <a href="<?php echo base_url().'superadmin/home'?>" class="button_grey">Back</a>			
							<input type="submit"  class="button_grey" name="addedit" id="addedit" value="<?php echo ($id)?'Update':'Submit'?>">
							<input type="hidden" name="id" id="id" value="<?php echo $id?>">
							<input type="hidden" name="type" id="type" value="<?php echo $type?>">
							<input type="hidden" name="email" id="email" value="<?php echo $email?>">
							<input type="hidden" name="userid" id="userid" value="<?php echo $userid?>">
						</div>
						
					</form>
				</div>
			</div><!--contentwrapper-->
		<br clear="all" />
	</div><!-- centercontent -->
</section>


<script>
jQuery(document).ready(function(){

	jQuery("#category").validate({
		rules: {
			password: "required",
		},
		messages: {
			password: "Please select password",
		}
	});
});	
</script>
