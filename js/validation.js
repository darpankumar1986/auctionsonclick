/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
////login
$(document).ready(function(){
    
    $(".input").blur(function(d){ $(this).siblings( ".help-block-error" ).html(''); });
    $("input[type='text'],input[type='password']").blur(function(d){ $(this).siblings( ".help-block-error" ).html(''); });
    $("select").change(function(d){ $(this).siblings( ".help-block-error" ).html(''); });
    $("#loginform-username").blur(function () {
    $("#ErrorMsg").html('');
    var status='0';
    var value = $(this).val();
 if(value!=''){ 
 if (!/^\w+([\.-]?\w+)*@\w+([\.-]?\w+)*(\.\w{2,3})+$/.test($(this).val())){ 
    status='1';
    $(".field-loginform-username ").text("Please Enter Valid Email");
  }
 if(status!='1'){   
    var datastring = $("#login-form").serialize();
    $.ajax({
        type: "POST",
        url: CHKUSERURL,
        data: datastring,
        dataType: "json",
 success: function(data) {
 if(data.resmsg=='fail' && data.restaus=='2'&& data.tbltype=='1'){ 
   $(".field-loginform-username ").text("No User Associated with this Email");
      }  
 if(data.resmsg=='fail' && data.restaus=='2'&& data.tbltype=='2'){ 
   $(".field-loginform-username ").text("No Buyer Associated with this Email");
      }
 if(data.resmsg=='fail' && data.restaus=='1'&& data.tbltype=='1'){ 
   $(".field-loginform-username").html("User Is Inactive")
      }  
 if(data.resmsg=='fail' && data.restaus=='1'&& data.tbltype=='2'){ 
   $(".field-loginform-username").html("Buyer Is Inactive")
      }
},
});
}
}else{
  $(".field-loginform-username ").html("Please Enter Email");   
}
});

$("#loginform-password").blur(function () {
var value = $(this).val();
if(value!=''){
$(".field-loginform-username").html("");  
$("#loginform-passwordhash").val(Sha256.hash(value));
}
});
    
$('#login-form').submit(function(e) { 
    var status='0';
    $(".help-block-error").html("");
    e.preventDefault();
    e.stopImmediatePropagation();
    $("#ErrorMsg").html("");
if($("#loginform-username").val()==''){ 
     status='1';
 $(".help-block-error").text("");
 $(".field-loginform-username  .help-block-error").text("Please Enter Email");
     } 
if($("#loginform-userid").val()==''&& $("#loginform-logintype").val()=='2'){ 
    status='1';
 $(".field-loginform-userid  .help-block-error").text("Please Enter User ID");
   }   
if($("#loginform-password").val()==''){ 
    status='1';
 $(".field-loginform-password  .help-block-error").text("Please Enter Password");
  }
if(status!='1'){ 
var datastring = $("#login-form").serialize();
 $.ajax({
    type: "POST",
    url: "ajaxlogin",
    data: datastring,
    dataType: "json",
 success: function(data) {
   var errortype='0';
   $(".help-block-error").html('');
   $("#ErrorMsg").html('');
  if(data.res=='fail'&& data.restype=='1'){
   errortype='1'; 
   $(".help-block-error").css('display','block');
   $("#ErrorMsg").text(data.message);
    }    
  if(data.res=='fail'&& data.restype=='2'){ 
   errortype='1';
   $(".help-block-error").css('display','block');
   $(".field-loginform-userid  .help-block-error").text(data.message); 
    }  
  if(data.res=='fail'&&data.restype=='3'){ 
   errortype='1';
   $(".help-block-error").css('display','block');
   $(".field-loginform-username  .help-block-error").text(data.message); 
    }
  if(errortype=='0'){
   $("#ErrorMsg").html("");
   window.location.reload();
   }
  },
  });
 }
});
   //registration
 if($("#signupform-password").val() && $("#signupform-password").val()!=''){ 
   $("#signupform-passwordhash").val(Sha256.hash($("#signupform-password").val()));
  }
   $("#signupform-password").blur(function () {
   var value = $(this).val();
   $("#signupform-passwordhash").val(Sha256.hash(value));
   });
   $(".input").blur(function(d){
   $(this).siblings( ".help-block-error" ).text('');
   }); 
   $(".select").change(function(d){
   $(this).siblings( ".help-block-error" ).text('');
    }); 
   $("#signupform-password").blur(function(d){
   var value = $(this).val();   
   if(value!=''){
   $("#signupform-passwordhash").val(Sha256.hash(value));
    }
   }); 
   $("#signupform-phone_no").keydown(function (e) {
        // Allow: backspace, delete, tab, escape, enter and .
   if ($.inArray(e.keyCode, [46, 8,16,61,32,109, 9, 27, 13,107, 110, 190]) !== -1 ||
         // Allow: Ctrl+A
        (e.keyCode == 65 && e.ctrlKey === true) ||
         // Allow: Ctrl+C
        (e.keyCode == 67 && e.ctrlKey === true) ||
         // Allow: Ctrl+X
        (e.keyCode == 88 && e.ctrlKey === true) ||
         // Allow: home, end, left, right
        (e.keyCode >= 35 && e.keyCode <= 39)) {
             // let it happen, don't do anything
             return;
   }
        // Ensure that it is a number and stop the keypress
    if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
        e.preventDefault();
    }
    });
  $("#signupform-zip").keydown(function (e) {
        // Allow: backspace, delete, tab, escape, enter and .
        if ($.inArray(e.keyCode, [46, 8,16,61, 9, 27, 13,110, 190]) !== -1 ||
             // Allow: Ctrl+A
            (e.keyCode == 65 && e.ctrlKey === true) ||
             // Allow: Ctrl+C
            (e.keyCode == 67 && e.ctrlKey === true) ||
             // Allow: Ctrl+X
            (e.keyCode == 88 && e.ctrlKey === true) ||
             // Allow: home, end, left, right
            (e.keyCode >= 35 && e.keyCode <= 39)) {
                 // let it happen, don't do anything
                 return;
     }
        // Ensure that it is a number and stop the keypress
    if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
        e.preventDefault();
    }
    });
});
function send(){ 
	//alert($("#email").val());
	//alert($("#pass").val());
    var status='0';
    $('.help-block-error').text('');
    $('#check_message').text('');
    $('.help-block-error').css('display','none');
     if($("#usertype").val()==''){
        status='1';
      $(".field-signupform-usertype").text("Register As cannot be blank.");
      }
      if($("#email").val()==''){
        status='1';
      $(".field-signupform-email").text("Email cannot be blank.");
      }
     if($("#email").val()!=''){
        var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,3})+$/;
        if(!regex.test($("#email").prop('value'))) {
          status='1';
          $(".field-signupform-email").text("Please enter valid email");
        }  
    
     }
       if($("#confirmemail").val()==''){
        status='1';
      $(".field-signupform-confirmemail").text("Confirm email cannot be blank.");
      }
     if($("#confirmemail").val()!=''){
          var regex = /^([a-zA-Z0-9_\.\-\+])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,3})+$/;
        if(!regex.test($("#confirmemail").prop('value'))) {
          status='1';
          $(".field-signupform-confirmemail").text("Please enter valid email");
        }
    }
      if($("#email").val()!=''&& $("#confirmemail").val()!=''){   
      var n = $("#email").val().localeCompare($("#confirmemail").val());
    if(n!='0'){  
      status='1'; 
      $(".field-signupform-confirmemail").text("Confirm email should be equal to email");
     }
    }
     
      if($("#pass").val()==''){
       status='1';
       $(".field-signupform-password").text("Password cannot be blank");
      }
      
    if($("#pass").val()!='')
    {
     var password = $("#pass").val();
        var decimal=  /^(?=.*\d)(?=.*[a-z])(?=.*[A-Z])(?=.*[^a-zA-Z0-9])(?!.*\s).{8,30}$/; 
    if(!password.match(decimal))
    { status='1'; 
      $(".field-signupform-password").text('Password should contain minimum 8 digits/letters, 1 Uppercase Letter with Special character.(Do not use $,<,>,&,#) )');
     }else{ 
      var pattern = /[$<>&-]/;
         if(password.match(pattern)) {
          $(".field-signupform-password").text('Password should contain minimum 8 digits/letters, 1 Uppercase Letter with Special character.(Do not use $,<,>,&,#) )');
    }
        
     }  
    }
    if($("#cpassword").val()==''){
      status='1';
      $(".field-signupform-cpassword").text("Confirm Password cannot be blank");
    }
    if($("#cpassword").val()!=''&& $("#pass").val()!=''){   
      var n = $("#pass").val().localeCompare($("#cpassword").val());
    if(n!='0'){  
      status='1'; 
      $(".field-signupform-cpassword").text("Confirm password Should be equal to Password");
     }
    }
    if($("#usertype").val()=='owner' || $("#usertype").val()=='')
    {
    
			 if($("#first_name").val()==''){
				status='1';
			  $(".field-signupform-first_name").text("First Name cannot be blank.");
			  }
			if($("#last_name").val()==''){
				status='1';
			  $(".field-signupform-last_name").text("Last Name cannot be blank.");
			  } 
			  
			   if($("#father_name").val()==''){
				status='1';
			  $(".field-signupform-father_name").text("Father's/Husband's Name cannot be blank.");
			  } 
      }
      if($("#usertype").val()=='builder')
      {
    
			 if($("#organisation_name").val()==''){
				status='1';
			  $(".field-signupform-organisation_name").text("Organization Name cannot be blank.");
			  }
			if($("#authorised_person").val()==''){
				status='1';
			  $(".field-signupform-authorised_person").text("Authorised person cannot be blank.");
			  } 
			 if($("#designation").val()==''){
				status='1';
			  $(".field-signupform-designation").text("Designation cannot be blank.");
			  } 
			 if($("#gst_no").val()==''){
				status='1';
			  $(".field-signupform-gst_no").text("GST number cannot be blank.");
			  } 
      }
      if($("#address1").val()==''){
        status='1';
      $(".field-signupform-address1").text("Address1 cannot be blank.");
      } 
      /*if($("#address2").val()==''){
        status='1';
      $(".field-signupform-address2").text("Address2 cannot be blank.");
      } */
      
      if($("#country").val()==''){
        status='1';
      $(".field-signupform-country").text("Country cannot be blank.");
      } 
     if($("#state").val()==''){
        status='1';
      $(".field-signupform-state").text("State cannot be blank.");
      } 
      if($("#city").val()==''){
        status='1';
      $(".field-signupform-city").text("City cannot be blank.");
      } 
       if($("#zipcode").val()==''){
        status='1';
      $(".field-signupform-zipcode").text("Zip cannot be blank.");
      } 
       if($("#zipcode").val()!=''){
           var n = $( "#zipcode" ).length;
    if( n<5 && n>6){
       status='1';
       $(".field-signupform-zip").text("Enter Six Digit Numeric zip");  
      }
    }
      
      if($("#phone_number").val()!=''){
     var n = $( "#phone_number").val().length;
    if( n<8 || n>15){ 
      status='1';
      $(".field-signupform-phone_no").text("Enter Phone Number Between 8 to 15 numbers");  
    }
    }
    if($("#mobile_number").val()==''){
      status='1';
      $(".field-signupform-mobile_number").text("Mobile Number cannot be blank");
      }
      if($("#mobile_number").val()!=''){
     var n = $( "#mobile_number").val().length;
    if( n<8 || n>14){ 
      status='1';
      $(".field-signupform-mobile_number").text("Enter Mobile Number Between 8 to 15 numbers");  
     }
  }
  
  if($("#bank_id").val()==''){
        status='1';
      $(".field-signupform-bank_name").text("Bank Name cannot be blank.");
    } 
    
    if($("#account_holder_name").val()==''){
        status='1';
      $(".field-signupform-account_holder_name").text("Account Holder Name cannot be blank.");
    }
    
    if($("#account_type").val()==''){
        status='1';
      $(".field-signupform-account_type").text("Type of Account cannot be blank.");
    }
    
    if($("#account_number").val()==''){
        status='1';
      $(".field-signupform-account_number").text("Account Number cannot be blank.");
    }
    
    if($("#ifsc_code").val()==''){
        status='1';
      $(".field-signupform-ifsc_code").text("IFSC Code cannot be blank.");
    } 
      
   /* if($("#fax_number").val()==''){
      status='1';
      $(".field-signupform-fax_number").text("Please Enter Fax No.");
      }*/
    
      $(".help-block-error").css('display','block');
    if($("#pan_numberid").is(':checked')){
     if($("#pan_number").val()==''){
     status='1'; 
     $(".field-signupform-pan_number").text("Pan No. cannot be blank");
    }
     }
      if($("#form_16id").is(':checked')){
     if($("#form16").val()==''){
         
     status='1'; 
     $(".field-signupform-form16").text("Form 16 cannot be blank");
    }
    if($("#form16").val()==''){
     status='1'; 
     $(".field-signupform-form16").text("Form 16 cannot be blank");
    }
     if($("#form16").val()!=''){
      var ext = $('#form16').val().split('.').pop().toLowerCase();
      if($.inArray(ext, ['gif','png','jpg','jpeg','pdf','doc','docx','zip']) == -1){
       status='1'; 
       $(".field-signupform-form16").text("Please Upload Valid File( Acceptable format are gif,png,jpg,jpeg,pdf,doc,docx)");
       }else{
        var file_size = $("#form16")[0].files[0].size;
       
	slimit=(1024*1024)*parseInt(5);
	if(file_size>slimit){
         status='1'; 
         $(".field-signupform-form16").text("Please Upload file less than 5MB");
       }   
           
       }
    } 
 }

   
  
    if($("#pan_form16").val()=='2'){
    if($("#signupform-formdoc").val()==''){status='1'; 
     $(".field-signupform-formdoc").text("Please Upload Form-16");
     }else{
     $(".field-signupform-formdoc").text("");
     }
    }else{
    if($("#signupform-document_no").val()==''){
     status='1'; 
     $(".field-signupform-document_no").text("Pan Number cannot be blank");
    }else{

     $(".field-signupform-document_no").text("");
      }
    } 
   if (!$("#signupform-confirmbidder").is(':checked')) {
        $("#check_message").text("Please accept User Agreement and Privacy Policy.");
        status='1';
     } 
     /*
     if($("#supply_place").val()==''){
       status='1';
     $(".field-signupform-supply-place").text("Place of Supply cannot be blank.");
    }
    if($("#delivery_address").val()==''){
        status='1';
      $(".field-signupform-delivery_address").text("Delivery Address cannot be blank.");
    } 
    
    if($("#gstin_yes").is(':checked'))
    {
		if($("#gst_no").val()=='')
		{
			status='1'; 
			$(".field-signupform-gst_no").text("GSTIN cannot be blank");
		}
    }
     */
     if($("#captcha").val() == "")
     {
		 $(".field-signupform-captcha").text("Please enter captcha code.");
        status='1';
	 }
	 else if ($("#captcha").val().length < 6) 
	 {
        $(".field-signupform-captcha").text("Please enter valid captcha code.");
        status='1';
     }
     else
     {
		 var rand = Math.random() * 10000000000000000;
			$.ajax({
					url: "/registration/checkCaptchaCode/"+$("#captcha").val()+"/?rand="+rand, 
					async: false,
					success: function(result){
						if(result != "success")
						{
							$("#captcha_cont").html(result);
							$(".field-signupform-captcha").text("Please enter valid captcha code.");
							status='1';	
						}
					}
				});
		
	 }
 
   if(status!='1'){ 
	   /*
	    var retVal = confirm("By making this payment you are agreeing that the GSTIN (if) provided by you is correct. In case GSTIN number is not provided by you, it is understood that you do not have a GSTIN number at the time of the transaction. No further requests for modification of GSTIN details with regards to the current transaction shall be entertained");
        if (retVal == true) {
             $( "#registration" ).trigger( "submit" );
        } else {
            return false;
        }	 
       */
        $( "#registration" ).trigger( "submit" );

      }else{

      return false;    
    }
  }
  //gfghfghfghfghhhgfhfghfg
function checkradio(id){ 
     if(id=='2'){ 
       $("#Pan_number").hide();
       $(".field-signupform-document_no").hide();
       $("#Form16_upload").show();
       $(".field-signupform-formdoc").show();
       $("#pan_form16").attr('value',id);
      }
     if(id=='1'){
       $("#Form16_upload").hide();
       $(".field-signupform-formdoc").hide();
       $("#Pan_number").show();
       $(".field-signupform-document_no").show();
       $("#pan_form16").attr('value',id);
       }
    }  
