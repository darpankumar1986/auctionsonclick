<script type="text/javascript" src="/application/views/admin/js/plugins/jquery.validate.min.js"></script>
<section>
  <div class="breadcrum">
    <div class="wrapper"> <a href="/" class="Home">Home</a>&nbsp;»&nbsp;<span>Edit Profile
	</span> </div>
  </div>
  <div class="row">
    <div class="wrapper">
      <div class="login registration2">
        <div class="left">
          <div class="heading1">Edit Profile</div>
		  <font color="green"><?php if($succ_msg)echo $succ_msg?></font> 
		  <form method="post" action="/registration/editprofiledo" enctype="multipart/form-data" id="registration">
          <div class="registration-box2">
			<div class="heading4 btmrg20 float-left">Basic Info</div>
			<div class="row">
				<label>Register As :</label>
              <input name="register_as"  type="radio" value="owner" <?php echo ($user_data['0']->register_as=='owner')?'checked':'' ?>>Owner<input name="register_as"  type="radio" value="broker" <?php echo ($user_data['0']->register_as=='broker')?'checked':'' ?>>Broker/Builder<input name="register_as"  type="radio" value="bider" <?php echo ($user_data['0']->register_as=='bider')?'checked':'' ?>>Bider
            </div>
			 <div class="row">
				<label>First Name* :</label>
              <input name="first_name"  placeholder="First Name*" type="text" class="input" value="<?php echo $user_data['0']->first_name; ?>">
            </div>
            <div class="row">
				<label>Last Name* :</label>
              <input name="last_name" placeholder="Last Name*" type="text" class="input" value="<?php echo $user_data['0']->last_name; ?>" >
            </div>
            <div class="row">
				<label>Email Address* :</label>
              <input name="email" placeholder="Email Address*" type="text" class="input" value="<?php echo $user_data['0']->email_id; ?>">
            </div>
			<div class="row">
				<label>Phone No.* :</label>
              <input name="mobile" placeholder="Phone No.*" type="text" class="input" value="<?php echo $user_data['0']->mobile; ?>">
            </div>
            <div class="row">
			  <label>City* :</label>
              <input name="city" placeholder="City*" type="text" class="input" value="<?php echo $user_data['0']->city; ?>" >
            </div>
            <div class="heading4 btmrg20 float-left">About your company</div>
            <div class="row">
              <label>Broker name :</label>
              <input name="broker_name" placeholder="Enter broker name" type="text" class="input" value="<?php echo $user_data['0']->broker_name; ?>">
            </div>
            <div class="row">
              <label>Broker photo :</label>
              <input name="broker_photo" placeholder="Broker photo" type="file" class="input" >
              <input name="broker_photo" placeholder="Broker photo" type="hidden" class="input" value="<?php echo $user_data['0']->broker_photo; ?>">
            </div>
            <div class="row">
              <label>Company name :</label>
              <input name="company_name" placeholder="Company Name" type="text" class="input" value="<?php echo $user_data['0']->company_name; ?>">
            </div>
            <div class="row">
              <label>Website URL :</label>
              <input name="website_URL" placeholder="Email Address" type="text" class="input" value="<?php echo $user_data['0']->website_URL; ?>">
            </div>
            <div class="row">
              <label>Company Logo :</label>
              <input name="company_logo" placeholder="Company Logo" type="file" class="input" >
              <input name="company_logo_old" placeholder="Company Logo" type="hidden" class="input" value="<?php echo $user_data['0']->company_logo; ?>">
            </div>
            <div class="row">
              <label>Operating since :</label>
              <input name="operating_since" placeholder="Operating since" type="text" class="input" value="<?php echo $user_data['0']->operating_since; ?>">
            </div>
            <div class="heading4 btmrg20 float-left">About your service</div>
            <div class="row" >
              <label>Title :</label>
              <input name="service_title" placeholder="Title" type="text" class="input" value="<?php echo $user_data['0']->service_title; ?>">
            </div>
            <div class="row">
              <label>Transacation types*</label>
              <div class="row">
              <span> <input name="transacation_type[]" type="checkbox" value="Rent" <?php echo ($user_data['0']->transacation_type=='Rent')?'selected':'' ?>> Rent</span>
              <span> <input name="transacation_type[]" type="checkbox" value="Auction" <?php echo ($user_data['0']->transacation_type=='Auction')?'selected':'' ?>> Auction</span>
              <span> <input name="transacation_type[]" type="checkbox" value="Non-Auction" <?php echo ($user_data['0']->transacation_type=='Non-Auction')?'selected':'' ?>> Non Auction</span>
              <span> <input name="transacation_type[]" type="checkbox" value="Sale" <?php echo ($user_data['0']->transacation_type=='Sale')?'selected':'' ?>> Sale</span>
              <span> <input name="transacation_type[]" type="checkbox" value="ReSale" <?php echo ($user_data['0']->transacation_type=='ReSale')?'selected':'' ?>> ReSale</span>
              </div>
            </div>
            <div class="row">
              <label>Transacation types :</label>
              <div class="row">
              <span> <input name="transacation_type[]" type="checkbox" value="all" <?php echo ($user_data['0']->transacation_type=='all')?'selected':'' ?>>All sub categories</span>
              </div>
            </div>
            <div class="row">
              <input name="" value="Submit" type="submit" class="b_login">
            </div>
          </div>
		  </form>
		  </div>
        <div class="right">
          <div class="heading-bg"><img src="/images/register-icon.png"> Why Join Bank eAuctions</div>
          <div class="content">
            <div class="heading1">View Five Reasons</div>
            <ol>
              <li>Dummy content goes here. rem ipsum dolor sit amet, consectetur adipiscing elit. rem ipsum dolor sit amet, consectetur adipiscing elit. Duis porttitor.</li>
              <li>Dummy content goes here. rem ipsum dolor sit amet, consectetur adipiscing elit. Duis porttitor.Dummy content goes here. rem ipsum dolor sit amet.</li>
              <li>Ummy content goes here. rem ipsum dolor sit amet, consectetur adipiscing elit. Duis porttitor.tor.</li>
              <li>Dummy content goes here. rem ipsum dolor sit amet, consectetur adipiscing elit. Duis porttitor.Dummy content goes here. rem ipsum dolor sit amet.</li>
            </ol>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<script>
jQuery("#registration").validate({
		rules: {
			register_as: "required",
			first_name: "required",
			last_name: "required",
			email: {
					required:true,
					email:true,
					},
			mobile:{
					required:true,
					minlength:10,
					maxlength:10,
					},
			password: {
					required:true,
                    minlength : 5
                },
			cpassword: {
					required:true,
                    minlength : 5,
                    equalTo : "#password"
                },
			city: "required",
			broker_name: "required",
			broker_photo: "required",
			company_name: "required",
			website_URL:{
			required:true,
			url:true
			},
			company_logo: "required",
			operating_since: "required",
			service_title: "required",
			transacation_type: "required"
			
		},
		messages: {
			register_as: "Please choose registeration type.",
			first_name: "Please enter first name.",
			last_name: "Please enter last name.",
			email: "Please enter email.",
			mobile: "Please enter mobile.",
			password: "Please enter password.",
			cpassword: "Please enter cpassword.",
			city: "Please enter city.",
			broker_name: "Please enter first name.",
			broker_photo: "Please enter last name.",
			company_name: "Please enter email.",
			website_URL: "Please enter mobile.",
			company_logo: "Please enter password.",
			operating_since: "Please enter cpassword.",
			service_title: "Please enter city.",
			transacation_type: "Please enter city."
		}
	});
</script>
