<?php
	if(isset($_GET['track'])){$track=$_GET['track'];}else{$track='';}
	if(isset($_GET['auctionID'])){$auctionID=$_GET['auctionID'];}else{$auctionID='';}
?>
<style>
	.m-form input[type="text"], .m-form input[type="email"], .m-form input[type="password"], .m-form select{width: 100%;display: block;margin-top: 10px;padding: 5px 6px;border: 1px solid #ccc;
    border-top: none;border-left: none;border-right: none;font-size:14px;}
    .m-form input[type="text"]:focus, .m-form input[type="password"]:focus{width: 100%;display: block;margin-top: 10px;padding: 5px 6px;border-bottom: 1px solid #1776ae;
    border-top: none;border-left: none;border-right: none;}
	.m-form fieldset div::after {clear: both;content: "";display: table;}
	.m-form fieldset{ margin: 10px 20px;}
	.m-form a.a_submit{ font-size:13px;width: 100%;text-align: center;margin-top: 14px;}
	.m-form .new-signup{border:1px solid #ccc;text-align:center;padding:8px 0;border-radius:2px;font-size:11px;}
	.m-form .new-signup a{color:#FF4500;font-weight: 500;}
	
</style>
<div class="m-form">
	<form action="<?php echo base_url();?>registration/m_checklogintype" method="post" id="m_login_submit_form" autocomplete="off">
		 <fieldset>
			<!--<legend>Login</legend>-->
			<?php /*?>
			<div class="half-width">
			   <label for="userName">Login As</label>
			   <select class="select minimal" name="login_as" id="ddlLogin">
				  <option value="owner">Bidder</option>
				  <option value="banker">Seller</option>
			   </select>
			</div><?php */?>
			<input type="hidden" name="login_as" value="owner" class="ddlLogin" />
			<div class="half-width">
			   <!--<label for="userEmail">Email</label>-->
			   <!--<input type="email" id="userEmail" name="userEmail">-->
			   <input type="text" class="keysubmit username" name="user_name" title="Login ID" value="" Placeholder="Email">
			</div>
			<div class="half-width  banker box">
			   <label for="userid">User ID</label>
			   <!--<input type="text" id="userid" name="userid">-->
				<input id="txtLoginID" class="keysubmit user_id" name="user_id"  type="text" title="User ID" >
			</div>
			<div class="half-width">
			   <!--<label for="userPassword">Password</label>-->
			   <!--<input type="password" id="userPassword" name="userPassword">-->
				<input type="hidden" name="track" value="<?php echo $track; ?>">
				<input type="hidden" name="auctionID" value="<?php echo $auctionID; ?>">
				<input type="password" class="keysubmit password" name="password" title="Password" Placeholder="Password">
			</div>
		 </fieldset>
		 <fieldset>
			<div>
			   <input type="hidden" value="LOGIN" name="m_submit">
			   <!--<a href="" class="forgot_pswd">Forgot Password?</a>-->
			   <!--<input type="submit" value="Login" onclick="validateloginform();">-->
			   <a href="javascript:void(0);" class="a_submit" onclick="m_validateloginform();">SIGN IN</a>
			</div>
			<span class="error1"></span>                                    
		 </fieldset>
		 <fieldset>
			<div class="new-signup">
			   <a href="<?php echo base_url()?>registration/forgetpassword" class="forgot_pswd" style="color:#1776ae !important;">Forgot Password?</a>
			</div>
		 </fieldset>
		  <fieldset>
			<div class="new-signup">
			   <a href="<?php echo base_url(); ?>registration/signup" class="" style="color:#1776ae !important;">New to MCG? SIGNUP</a>
			</div>
		 </fieldset>
	</form>
</div>
<script type="text/javascript">
		function m_validateloginform(){			
			 $(".error1").text("");
			 //$("#lblError").removeClass('error');
		   var m_usertype=$(".ddlLogin").val();
		   var m_userid=$(".txtLoginID").val();  
		   var m_username=$(".username").val();  
		   var m_password=$(".password").val();  
		   		  
			  //alert(m_username);
			  if(m_username=='')
			  {
				  $(".error1").css('display','block').text("Please Enter Email ID");
				  //$("#lblError").addClass('error');
			  }
			  else
			  { 
				  if(m_password=='')
				  {
					  $(".error1").css('display','block').text("Please Enter Password"); 
					  //$("#lblError").addClass('error');
				  }
				  else
				  {
					$(".error1").css('display','none');  
					$("#m_login_submit_form").trigger("submit");  					
				  }    
			  }
		  
		  
		}
		$(document).ready(function(){
			$('.keysubmit').keypress(function (e) {
				if (e.which == 13) {
					m_validateloginform();
					return false;    //<---- Add this line
				}
			});
		$("#m_login_submit_form").submit(function(){								
					var pass = $(".password").val();
					var hash = CryptoJS.SHA256(pass);
					$(".password").val(hash);					
					var ckUrl = "<?php echo base_url();?>registration/chk_login";
					
					
					
					var  formData = "user_name="+$(".username").val();
						 formData += "&password="+$(".password").val();			 
						 formData += "&submit1="+$("[name=m_submit]").val();	
						 var val =0;
						 $.ajax({
							url: ckUrl, // 
							type:"POST",
							data: formData,
							async: false,
							success:function(response)
							{	
								//return false;
								if(response==1)
								{
									$(".error1").css('display','block').html('<div class="flogout1"> You already have an active session;Force logout in existing session !! <a href=<?php echo base_url(); ?>registration/logout style="color:#000;font-weight:bold;">Force Logout</a> </div>');   
									return false;
								}									
								else if(response==2)
								{
									$(".error1").css('display','block').html('Your account is blocked!<br> Please contact administrator to unblock it.');   
									$("#password").val('');
									return false;
								}
								else if(response==3)
								{
									$(".error1").css('display','block').html('Invalid username or password..!');   
									$("#password").val('');
									return false;
								}
								else if(response==4)
								{
									$(".error1").css('display','block').html('Invalid username or password..!<br/>Account will be blocked after 5 failed attempt!');   
									$("#password").val('');
									return false;
								}
								else if(response==5)
								{
									$(".error1").css('display','block').html('Your account has been blocked!<br> Please contact administrator to unblock it.'); 
									$("#password").val('');  
									return false;
								}														
								else if(response== 'success'){	
									//alert(0);	
									val =1;					
									return true;									
								}
								
							}
							
							
						});
						if(val == 1)
						{
							return true;
						}
						
						return false;
					
				});
		});
	</script>	
