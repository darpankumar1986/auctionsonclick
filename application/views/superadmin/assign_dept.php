<script type="text/javascript" src="<?php echo VIEWBASE?>js/plugins/jquery.uniform.min.js"></script>
<script type="text/javascript" src="<?php echo VIEWBASE?>js/plugins/jquery.validate.min.js"></script>
<script type="text/javascript" src="<?php echo VIEWBASE?>js/custom/forms.js"></script>
<?php 
//echo '<pre>'; print_r($row);die;
if(!empty($row)){
	$id=$row->id; 
	$country=$row->countryID; 
	$state_name=$row->state_name; 
	$status=$row->status; 
}
else{
	$status = 1;
	if(!empty($_POST)) {
		$country=$_POST['country_id']; 
		$state_name=$_POST['name']; 
		$status=$_POST['status']; 
	}
}
?> 



<section class="body_main1">
<div class="centercontent">
	<div class="row">						
			<a href="<?php echo base_url().'superadmin/user/banker'?>" class="button_grey">Branch User List</a>
			<a href="<?php echo base_url().'superadmin/user/assignDeptlist'?>" class="button_grey">Assigned Departments List</a>
	</div>
	
 					
			
	 
	
	
	<div class="box-head">Assign Department</div>
	
	<div class="pageheader">
		<span class="pagedesc"><div style="color:red"><?php echo validation_errors(); ?></div></span>
	</div><!--pageheader-->
	
 
    <div id="contentwrapper" class="contentwrapper box-content2">
		<div id="validation" class="subcontent">
			<form enctype="multipart/form-data" method="post" class="stdform" id="deptassign" name="add_data_view" accept-charset="utf-8" action="<?php echo base_url();?>superadmin/user/assign_dept/<?php echo $user_id; ?>">	
				<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash();?>" />
			
			<div class="row">
			<div class="lft_heading">Departments<span class="red"> *</span></div>
			<div class="rgt_detail">
					<div class="rgt_detail">
						<?php 
							
							foreach($depts as $key => $data)
							{	
								//echo $depName[$key]['department_id'];						
							?>
							
					<input type="checkbox" id="departments" name="departments[]" value="<?php echo $data->department_id; ?>" <?php 
					if($depName != ''){ 
					if(in_array($data->department_id, $depName)){ 
							echo "checked";
						}
					}
						 ?>>
					<label for="coding"><?php echo $data->department_name;?></label>
					<?php }?>
				</div>
		           
				
				
				<div class="stdformbutton row" style="text-align:center;">		
					<a href="<?php echo base_url().'superadmin/home'?>" class="button_grey">Back</a>				
					<input type="submit"  class="button_grey" name="addedit" id="addedit" value="<?php echo ($id)?'Update':'Submit'?>">
					<input type="hidden" name="id" id="id" value="<?php echo $id ?>">
				</div>
				
			</form>
        </div>
	</div><!--contentwrapper-->
    <br clear="all" />
</div><!-- centercontent -->
</section>

<script>
jQuery(document).ready(function(){
	jQuery('#deptassign').validate({ // initialize the plugin
        rules: {
            'departments[]': {
                required: true,
              
            }
        },
        messages: {
            'departments[]': {
                required: "You must check at least 1 box",
            }
        }
    });

	
});	
</script>
