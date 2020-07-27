<section class="middle-container tpmrgn">
  <div class="wrapper clear">
	<div class="loginform clear">
	
	
		
		<?PHP 
		if($msgType=='error'){
			if(count($msg)>0){ ?>
				<div class="error-msg" allign="center">
					<ul>		
				<?php foreach($msg as $error_msg){?>				
						<li class="error"><?PHP echo $msgArray[$error_msg]; ?></li>	
				<?php } ?>
					<ul>
				</div>
		<?php
		}		
		 $msg=""; 		
		}else if($msgType=='sucess'){
			if(count($msg)>0){
				foreach($msg as $error_msg){
					?>
					<div class="sucessful-msg" allign="center">
						<ul>		
							<li class="sucessful"><?PHP echo $msgArray[$error_msg]; ?></li>	
						<ul>
					</div>
					<?php 
				} 
			}$msg=""; 
		}		
		?>
		
		
	
		<form class="input-form clear" action="<?php echo base_url(); ?>registration/update_password " method="post" name="loginfrm" id="loginfrm">
			<div class="row">			
			<div class="login">
			<h3>Reset Password</h3>
			<label>New Password</label>
			<input type="password" name="new_password" id="new_password" />
			<label>Confirm Password</label>
			<input type="password" name="cpassword" id="cpassword" />
			<button type="SUBMIT"  class="b_login" >Submit</button>
			<input type="hidden" name="email" id="email" value="<?php echo $email; ?>" />
			</div>
			</div>
		</form
    </div>
  </div>
</section>





<?php define('VIEWBASE',site_url().'application/views/admin/'); ?>
<script type="text/javascript" src="<?php echo VIEWBASE?>js/plugins/jquery.validate.min.js"></script>	  

<style>
	form label.error {
display: inline-block;
font: 10px Tahoma,sans-serif;
color: #ED7476;
margin-left: 5px;
}
</style>

	
	
<script>	

jQuery(document).ready(function(){
	jQuery.validator.setDefaults({ ignore: '' });
	jQuery("#loginfrm").validate({
		rules: {			
			new_password: {
                required: true,
                minlength: 5
            },			
			cpassword: {
			required: true,
			equalTo: "#new_password"
			}          
		},
		messages: {			
			new_password: {
                required: "Please enter new password..!",
                minlength: "Your password must be at least 5 characters long..!"
            },			
			cpassword: {
			required: "Please enter confirm password..!",
			equalTo: "Password and confirm password not matched..!"
			}
		}
		
	});
	
});	
</script>