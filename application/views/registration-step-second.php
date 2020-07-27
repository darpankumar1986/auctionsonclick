<style>
    label.error {
        float: right;
        margin-left: 150px;
        margin-top: -16px;
}
</style>
<script type="text/javascript" src="/application/views/admin/js/plugins/jquery.validate.min.js"></script>
<section>
  <div class="breadcrum">
    <div class="wrapper"> <a href="/" class="Home">Home</a>&nbsp;»&nbsp;<span>Registration</span> </div>
  </div>
  <div class="row">
    <div class="wrapper">
      <div class="login registration2">
        <div class="left">
          <div class="heading1">Registration</div>
		  <div class="sucessfully btmrg20"><?php echo $this->session->flashdata('msg');?></div>
		  <form method="post" action="/registration/save_next" enctype="multipart/form-data" id="registration">
          <div class="registration-box2">
            <div class="heading4 btmrg20 float-left">About your company</div>
            <div class="row">
              <label>Broker name :</label>
              <input  maxlength="75" name="broker_name" placeholder="Enter broker name" id="broker_name" type="text" class="input">
            </div>
            <div class="row">
              <label>Broker photo :</label>
              <input name="broker_photo" placeholder="Broker photo" id="broker_photo" type="file" class="input">
            </div>
            <div class="row">
              <label>Company name :</label>
              <input maxlength="50" name="company_name" placeholder="Company Name" type="text" class="input">
            </div>
            <div class="row">
              <label>Website URL :</label>
              <input name="website_URL" placeholder="Email Address" type="text" class="input">
            </div>
            <div class="row">
              <label>Company Logo :</label>
              <input maxlength="200"  name="company_logo"  id="company_logo" placeholder="Company Logo" type="file" class="input">
            </div>
            <div class="row">
              <label>Operating since :</label>
              <input maxlength="50" name="operating_since" placeholder="Operating since" type="text" class="input">
            </div>
            <div class="heading4 btmrg20 float-left">About your service</div>
            <div class="row">
              <label>Title :</label>
              <input maxlength="500" name="service_title" placeholder="Title" type="text" class="input">
            </div>
            <div class="row"  style="width:100%">
              <label>Transaction types*</label>
              <div class="row">
              <span> <input name="transacation_type[]" type="checkbox" value="Rent"> Rent</span>
              <span> <input name="transacation_type[]" type="checkbox" value="Auction"> Auction</span>
              <span> <input name="transacation_type[]" type="checkbox" value="Non-Auction"> Non Auction</span>
              <span> <input name="transacation_type[]" type="checkbox" value="Sale"> Sale</span>
              <span> <input name="transacation_type[]" type="checkbox" value="ReSale"> ReSale</span>
              </div>
            </div>
            <!--<div class="row">
              <label>Transacation types :</label>
              <div class="row">
              <span> <input name="transacation_type[]" type="checkbox" value="all">All sub categories</span>
              </div>
            </div>-->
            <div class="row">
              <input name="" value="Submit" type="submit" class="b_login">
              <input name="id" value="<?php echo $id?>" type="hidden" >
              <input name="type" value="<?php echo $type?>" type="hidden" >
            </div>
          </div>
		  </form
>        </div>
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
			broker_name: "required",
			//broker_photo: "required"
			company_name: "required",
                        broker_photo:{
				accept: "png|jpg|gif|jpeg"
			   }, 
                        company_logo:{
				accept: "png|jpg|gif|jpeg"
			   },    
                           
			//website_URL:{
			//required:true,
			//url:true
			//},
			//company_logo: "required",
			//operating_since: "required",
			//service_title: "required",
			'transacation_type[]': "required"
			
		},
		messages: {
			broker_name: "Please enter first name.",
			broker_photo:{
		        accept: "Please Upload a Valid file (png,jpg,gif,jpeg).",
			},
                        company_logo:{
		        accept: "Please Upload a Valid file (png,jpg,gif,jpeg).",
			},
		      /*company_name: "Please enter email.",
			website_URL: "Please enter mobile.",
			company_logo: "Please enter password.",
			operating_since: "Please enter cpassword.",
			service_title: "Please enter city.",
			transacation_type: "Please enter city."
                      */
		}
	});
</script>
