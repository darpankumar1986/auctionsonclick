<script src="<?php echo base_url(); ?>assets/auctiononclick/js/bootstrap.min.js?rand=<?php echo CACHE_RANDOM; ?>"></script>
<script type="text/javascript">
            $(document).ready(function(){
                $('.error1').css('display','none');
                $("#username").focus();
                /*$('.keysubmit').keypress(function (e) {
                    if (e.which == 13) {
                        validateloginform();
                        return false;    //<---- Add this line
                    }
                });*/


            $("#ddlLogin").change(function(){
                $("#username").focus();
                $(this).find("option:selected").each(function(){
                  if($(this).attr("value")=="banker"){
                        $(".box").not(".banker").hide();
                        $(".banker").show();
                        //$(".forgotLink").hide();
                    }
                    else{
                        $(".box").hide();
                        //$(".forgotLink").show();
                    }
                });
                }).change();

				$("#username").keyup(function(){
					$("#login_email").hide();
				});

				$("#password").keyup(function(){
					$("#login_password").hide();
				});


                $("#login_submit_form").submit(function(){
                    var loginType = $("#loginType").val();
					var username = $("#username").val();
                    var pass = $("#password").val();
					var error = false;

					if(username == '')
					{
						$("#login_email").html('Please Enter Email ID.');
						$("#login_email").show();
						error = true;
					}
					else
					{
						$("#login_email").hide();
					}

					if(pass == '')
					{
						$("#login_password").show();
						error = true;
					}
					else
					{
						$("#login_password").hide();
					}
					

					if(!error)
					{
                    var hash = CryptoJS.SHA256(pass);
                    $("#password").val(hash);

                    if(loginType =='owner')
                    {
                        var ckUrl = "<?php echo base_url();?>registration/chk_login";
                    }
                    else
                    {
                        var ckUrl = "<?php echo base_url();?>registration/chk_banker_login";
                    }

                    var  formData = "user_name="+$("#username").val();
                         formData += "&user_id="+$("#txtLoginID").val();
                         formData += "&password="+$("[name=password]").val();
                         formData += "&submit1="+$("[name=submit1]").val();

                         var val =0;
                         $.ajax({
                            url: ckUrl, //
                            type:"POST",
                            data: formData,
                            async: false,
                            success:function(response)
                            {
                                //alert(response);
                                //return false;
                                if(response==1)
                                {
                                    $(".error1").css('display','block').html('<div class="flogout1"> You already have an active session;Force logout in existing session !! <a href=<?php echo base_url(); ?>registration/logout style="color:#000;font-weight:bold;">Force Logout</a> </div>');
                                    return false;
                                }
                                else if(response==2)
                                {
                                    $(".error1").css('display','block').html('Your account is blocked!<br> Please contact administrator to unblock it.');
                                    $("#password").val(pass);
                                    return false;
                                }
                                else if(response==3)
                                {
                                    $(".error1").css('display','block').html('Invalid Email ID or Password..!');
                                   $("#password").val(pass);
                                    return false;
                                }
                                else if(response==4)
                                {
                                    $(".error1").css('display','block').html('Invalid Email ID or Password..!<br/>Account will be blocked after 5 failed attempt!');
                                    $("#password").val(pass);
                                    return false;
                                }
                                else if(response==5)
                                {
                                    $(".error1").css('display','block').html('Your account has been blocked!<br> Please contact administrator to unblock it.');
                                    $("#password").val(pass);
                                    return false;
                                }
                                else{
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
					}

                        return false;

                });

				

        });

        $(document).on('click','.cd-close',function(){
            $(".error1").css('display','none').html("");
            $("#username").val("");
            $("#txtLoginID").val("");
            $("#password").val("");

        });
        </script>

    <script type="text/javascript">
        function validateloginform(){

             $(".error1").text("");
             //$("#lblError").removeClass('error');
           var usertype=$("#ddlLogin").val();
           var userid=$("#txtLoginID").val();
           var username=$("#username").val();
           var password=$("#password").val();
           if(usertype=='owner')
           {
              if(username=='')
              {
                  $(".error1").css('display','block').text("Please Enter Email ID");
                  //$("#lblError").addClass('error');
              }
              else
              {
                  if(password=='')
                  {
                      $(".error1").css('display','block').text("Please Enter Password");
                      //$("#lblError").addClass('error');
                  }
                  else
                  {
                    $(".error1").css('display','none');
                    $("#login_submit_form").trigger("submit");
                  }
              }
          }
          if(usertype=='banker'){
              /*
              if(username==''){
                    $(".error1").css('display','block').text("Please Enter Email");
                    //$("#lblError").addClass('error');
              }
              */
              if(userid=='')
              {
                    $(".error1").css('display','block').text("Please Enter User ID");
                    //$("#lblError").addClass('error');
              }
              else
              {
                  if(password=='')
                  {
                      $(".error1").css('display','block').text("Please Enter Password");
                      //$("#lblError").addClass('error');
                  }
                  else
                  {
                        $(".error1").css('display','none');
                        $("#login_submit_form").trigger("submit");

                  }
              }
          }
        }

    </script>
	<style>
		.error2 {
				color: #e83c3c;
				font-size: 13px;
				margin-left: 14px;
				display: block;
			}
		#login_email,#login_password{display: none;}
	</style>
    <div class="container-fluid container_margin">
            <div class="row">
                <div class="col-sm-12">
                   <div class="login_page">
                      <div class="login_inner_page">
                       <ul class="nav nav-tabs">
                           <li class="active"><a data-toggle="tab" href="#Login">Login</a></li>
                           <li><a href="<?php echo base_url(); ?>registration/signup">Register</a></li>
                       </ul>

                       <div class="tab-content">

                           <div id="Login" class="tab-pane fade in active">
                               <form class="custom_form" action="<?php echo base_url(); ?>registration/checklogintype" method="post" id="login_submit_form" autocomplete="off">


                                   <div class="floating-form">
                                       <div class="floating-label">
                                            <input type="hidden" id="loginType" name="login_as" value="owner">
                                            <input type="hidden" id="action" name="action" value="<?php echo $_GET['action']; ?>">

                                            <input type="text" placeholder=" " class="keysubmit floating-input" name="user_name" id="username" value="<?php if($this->session->userdata('session_found_emailid')) { echo $this->session->userdata('session_found_emailid');} ?>">
                                           <label class="custom_label">Email ID</label>
										   <span id="login_email" class="error2">Please Enter Email ID</span>
                                       </div>
                                       <div class="floating-label">
                                            <input type="hidden" name="track" value="<?php echo $track; ?>">
                                            <input type="hidden" name="auctionID" value="<?php echo $auctionID; ?>">
                                           <input type="password" class="keysubmit floating-input" name="password" id="password" placeholder=" ">
                                           <label class="custom_label">Password</label>
                                           <span toggle="#password" class="eye_icon toggle-password fa-eye-slash fa"></span>

										   <span id="login_password" class="error2">Please Enter Password</span>
                                       </div>
                                   </div>
                                   <div class="checkbox">
                                       <!--<label><input type="checkbox" name="remember"> Remember me</label>-->
                                       <label class="forget"><a href="<?php echo base_url()?>registration/forgetpassword" class="forget">Forgot password?</a></label>
                                   </div>
                                   <button type="submit" class="btn btn-default login_btn" name="submit1">Login</button>

                                   <div class="success_msg error1" style="padding-left:15px;color: #ffffff !important;background-color:#e71c28; clear:both;width: 100%;clear: both; margin-bottom: 20px;">
                                        <?php echo $this->session->flashdata('error_msg'); ?>
                                    </div>
                               </form>
                           </div>
                           <div id="Register" class="tab-pane fade">
                               <form class="custom_form register_form">
                                   <div class="floating-form">
                                       <div class="floating-label">
                                           <select class="floating-select" onclick="this.setAttribute('value', this.value);" value="">
                                               <option value=""></option>
                                               <option value="1">Organisation</option>
                                               <option value="2">Organisation2</option>
                                               <option value="3">Organisation3</option>
                                           </select>
                                           <span class="highlight"></span>
                                           <label class="custom_label">Registered As</label>
                                           <span class="eye_icon down_icon"><i class="fa fa-chevron-down"></i></span>
                                       </div>
                                       <div class="floating-label">
                                           <input class="floating-input" type="text" placeholder=" ">
                                           <label class="custom_label">Company Name</label>
                                       </div>
                                       <div class="floating-label">
                                           <input class="floating-input" type="text" placeholder=" ">
                                           <label class="custom_label">GST Number (Optional)</label>
                                       </div>
                                       <div class="floating-label">
                                           <input class="floating-input" type="text" placeholder=" ">
                                           <label class="custom_label">Person In Charge</label>
                                       </div>
                                       <div class="floating-label">
                                           <input class="floating-input floating-float" type="text" placeholder=" ">
                                           <label class="custom_label">Email ID</label>
                                           <button type="button" class="btn verify_btn">Send code</button>
                                           <p class="error_desc">Your account verification code will be sent to this email ID</p>
                                       </div>
                                       <div class="floating-label">
                                           <input class="floating-input floating-float" type="text" placeholder=" ">
                                           <label class="custom_label">XXXXXX</label>
                                           <button type="button" class="btn verify_btn verify_btn2">Verify</button>
                                           <p class="error_desc">Enter verification code sent to your email ID</p>
                                       </div>
                                       <div class="floating-label">
                                           <input class="floating-input" type="Password" placeholder=" ">
                                           <label class="custom_label">Password</label>
                                       </div>
                                       <div class="floating-label">
                                           <input class="floating-input" type="Password" placeholder=" ">
                                           <label class="custom_label">Confirm Password</label>
                                       </div>
                                       <div class="floating-label">
                                           <input class="floating-input floating-float" type="text" placeholder=" ">
                                           <label class="custom_label">Mobile Number</label>
                                           <button type="button" class="btn verify_btn verify_btn3">Resend in 30</button>
                                           <p class="error_desc">OTP verification will be sent to this mobile number</p>
                                       </div>
                                       <div class="floating-label">
                                           <input class="floating-input floating-float" type="text" placeholder=" ">
                                           <label class="custom_label">XXXXXX</label>
                                           <button type="button" class="btn verify_btn verify_btn2">Verify</button>
                                           <p class="error_desc">Enter OTP sent to your mobile number</p>
                                       </div>
                                       <div class="floating-label">
                                           <input class="floating-input" type="text" placeholder=" ">
                                           <label class="custom_label">Address</label>
                                       </div>
                                       <div class="floating-label">
                                           <input class="floating-input" type="text" placeholder=" ">
                                           <label class="custom_label">City</label>
                                       </div>
                                       <div class="floating-label">
                                           <input class="floating-input" type="text" placeholder=" ">
                                           <label class="custom_label">Pincode</label>
                                       </div>
                                       <div class="floating-label">
                                           <select class="floating-select" onclick="this.setAttribute('value', this.value);" value="">
                                               <option value=""></option>
                                               <option value="1">India</option>
                                               <option value="2">Usa</option>
                                               <option value="3">Uk</option>
                                           </select>
                                           <span class="highlight"></span>
                                           <label class="custom_label">Country</label>
                                           <span class="eye_icon down_icon"><i class="fa fa-chevron-down"></i></span>
                                       </div>
                                       <div class="floating-label">
                                           <select class="floating-select" onclick="this.setAttribute('value', this.value);" value="">
                                               <option value=""></option>
                                               <option value="1">New Delhi</option>
                                               <option value="2">Up</option>
                                               <option value="3">Goa</option>
                                           </select>
                                           <span class="highlight"></span>
                                           <label class="custom_label">State</label>
                                           <span class="eye_icon down_icon"><i class="fa fa-chevron-down"></i></span>
                                       </div>
                                       <div class="floating-label">
                                           <input class="floating-input floating-float" type="text" placeholder=" ">
                                           <label class="custom_label">Enter the code here</label>
                                           <div class="btn verify_btn verify_btn2">Captcha</div>
                                       </div>
                                   </div>
                                   <button type="submit" class="btn btn-default login_btn">Register</button>
                               </form>
                           </div>
                       </div>
                       </div>
                    </div><!--login_page-->
                </div>
            </div><!--row-->

        </div><!--container-fluid-->
        <script src="<?php echo base_url(); ?>assets/auctiononclick/js/bootstrap.min.js?rand=<?php echo CACHE_RANDOM; ?>"></script>
