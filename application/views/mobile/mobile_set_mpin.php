<?php
	if(isset($_GET['track'])){$track=$_GET['track'];}else{$track='';}
	if(isset($_GET['auctionID'])){$auctionID=$_GET['auctionID'];}else{$auctionID='';}
?>
<style>
	.m-form input[type="text"], input[type="number"],.m-form input[type="email"], .m-form input[type="password"], .m-form select{width: 100%;display: block;margin-top: 10px;padding: 5px 6px;border: 1px solid #ccc;
    border-top: none;border-left: none;border-right: none;font-size:14px;}
    .m-form input[type="text"]:focus, .m-form input[type="password"]:focus{width: 100%;display: block;margin-top: 10px;padding: 5px 6px;border-bottom: 1px solid #1776ae;
    border-top: none;border-left: none;border-right: none;}
	.m-form fieldset div::after {clear: both;content: "";display: table;}
	.m-form fieldset{ margin: 10px 20px;}
	.m-form a.a_submit{ font-size:13px;width: 100%;text-align: center;margin-top: 14px;}
	.m-form .new-signup{border:1px solid #ccc;text-align:center;padding:8px 0;border-radius:2px;font-size:11px;}
	.m-form .new-signup a{color:#FF4500;font-weight: 500;}
	input[type=number] {
		-webkit-text-security: disc;
	}
	
</style>
<div class="m-form">
	<form action="<?php echo base_url();?>registration/set_mpin" method="post" id="m_login_submit_form" autocomplete="off">
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
			   <input type="number" class="keysubmit mpin numericonly" name="mpin" title="mpin" value="" Placeholder="Login PIN" max="9999" oninput="maxLengthCheck(this)">
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
				<input type="number" class="keysubmit conf_mpin numericonly" name="conf_mpin" title="Password" Placeholder="Confirm Login PIN" max="9999" oninput="maxLengthCheck(this)">
			</div>
		 </fieldset>
		 <fieldset>
			<div>
			   <input type="hidden" value="LOGIN" name="m_submit">
			   <!--<a href="" class="forgot_pswd">Forgot Password?</a>-->
			   <!--<input type="submit" value="Login" onclick="validateloginform();">-->
			   <a href="javascript:void(0);" class="a_submit" onclick="m_validateloginform();">Set mPin</a>
			</div>
			<span class="error1"></span>                                    
		 </fieldset>
		  <!--<fieldset>
			<div class="new-signup">
			   <a href="<?php echo base_url(); ?>registration/signup" class="" >New to MDA? SIGNUP</a>
			</div>
		 </fieldset>-->
	</form>
</div>
<script type="text/javascript">
		
		function maxLengthCheck(object){
			if (object.value.length > object.max.length)
			  object.value = object.value.slice(0, object.max.length)
		}
		
		function m_validateloginform(){			
			 $(".error1").text("");
			 //$("#lblError").removeClass('error');
		   var m_usertype=$(".ddlLogin").val();
		   var m_userid=$(".txtLoginID").val();  
		   var m_mpin=$(".mpin").val();  
		   var m_conf_mpin=$(".conf_mpin").val();  
		   		  
			  //alert(m_mpin.length);
			  if(m_mpin=='')
			  {
				  $(".error1").css('display','block').text("Please Enter mPin");
				  //$("#lblError").addClass('error');
			  }
			  else if(m_mpin.length < 4)
			  {
				  $(".error1").css('display','block').text("Please Enter 4 digit mPin");
			  }
			  else
			  { 
				  if(m_conf_mpin=='')
				  {
					  $(".error1").css('display','block').text("Please Enter Confirm mPin"); 
					  //$("#lblError").addClass('error');
				  }
				  if(m_mpin != m_conf_mpin)
				  {
					  $(".error1").css('display','block').text("Confirm mPin did not match!"); 
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
		});
		
$(".numericonly").keydown(function (e) { 
	// Allow: backspace, delete, tab, escape, enter and .
	if ($.inArray(e.keyCode, [46, 8, 9, 27, 13]) !== -1 ||
		 // Allow: Ctrl+A, Command+A
		(e.keyCode == 65 && ( e.ctrlKey === true || e.metaKey === true ) ) || 
		 // Allow: home, end, left, right, down, up
		(e.keyCode >= 35 && e.keyCode <= 40)) {
			 // let it happen, don't do anything
			 return;
	}
	// Ensure that it is a number and stop the keypress
	if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
		e.preventDefault();
	}
});
	</script>	
