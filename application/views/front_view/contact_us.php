<script type="text/javascript" src="<?php echo base_url();?>application/views/admin/js/plugins/jquery.uniform.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>application/views/admin/js/plugins/jquery.validate.min.js"></script>
<div class="container-fluid container_margin">
            <div class="row row_bg">
               <div class="container">
                <div class="col-sm-12">
                    <div class="breadcrumb_main">
                        <ol class="breadcrumb">
                            <li><a href="<?php echo base_url();?>">Home</a></li>
                            <li class="active">Contact Us</li>
                        </ol>
<!--                        <h3>Bank Auctions in Amritsar</h3>-->
                    </div><!--breadcrumb_main-->
                </div>
            </div>
            </div><!--row-->
        </div><!--container-fluid-->
           <div class="container-fluid">
               <div class="row ad_row_width">
                   <div class="col-sm-12">
                       <h3 class="premium_service">Contact Us</h3>
                   </div>
               </div>
           </div>
        <div class="container">
			<?php
             if($this->session->flashdata('message_validation')){?>

				<dl class="error2">
					<?php echo $this->session->flashdata('message_validation'); ?>
				</dl>
			<?php } ?>
            <div class="row advanced_search_row">
                <div class="col-sm-6">
                    <form class="custom_form register_form custom_search_form contact_us_form" name="myform" id="myform" method="POST" action="/home/contactUsSave">
                        <div class="floating-form">
                            <div class="floating-label">
                                <input class="floating-input html_found" type="text" name="name" placeholder=" ">
                                <label class="custom_label">Name</label>
                            </div>
                            <div class="floating-label">
                                <input class="floating-input html_found" type="text" name="email" placeholder=" ">
                                <label class="custom_label">Email ID</label>
                            </div>
                            <div class="floating-label">
                                <input class="floating-input html_found" type="text" name="mobile" placeholder=" " onkeypress="return isNumberKey(event);">
                                <label class="custom_label">Mobile Number</label>
                            </div>
                            <div class="floating-label">
                                <select class="floating-select" name="topic_id" onclick="this.setAttribute('value', this.value);" value="">
                                    <option value=""></option>
									<?php 
									if(is_array($getContactUsTopic) && count($getContactUsTopic)>0)
									{
										foreach($getContactUsTopic as $topic)
										{
									?>
											<option value="<?php echo $topic->topic_id; ?>"><?php echo $topic->topic_name; ?></option>
									<?php
										}
									}	
									?>
                                </select>
                                <span class="highlight"></span>
                                <label class="custom_label">Topic</label>
                                <span class="eye_icon down_icon"><i class="fa fa-chevron-down"></i></span>
					</div>
					<div class="floating-label">
						<textarea class="floating-input floating-textarea" placeholder=" " maxlength="500" name="message"></textarea>
						<label class="custom_label">Message</label>
					</div>
				</div>
				<div class="advanced_search_btn">
					<!--<button type="button" class="btn search_btn_new">Submit</button>-->
					<input class="btn search_btn_new" type="submit" name="Send" value="Submit" />
				</div>
			</form>
		</div>
		<div class="col-sm-6">
			<div class="contact_us_address">
			   <div class="contact_us_office">
				   <h3>Corporate Office</h3>
				   <p>Plot Number 301, 1st Floor, Udyog Vihar,<br/>Phase - II, Gurgaon - 122015,<br/>Haryana, India</p>
			   </div>
				<div class="sales_enquery_section">
					<h4>Sales Enquiry</h4>
					<p>Mobile Number: +91- 7291981129</p>
					<p class="enquiry">Email ID: <a href="mailto:enquiry@auctionsonclick.com">enquiry@auctionsonclick.com</a></p>
				</div>
			</div>
		</div>
	</div>
</div>
<script>
function isNumberKey(evt)
{
	var charCode = (evt.which) ? evt.which : event.keyCode;
	//console.log(charCode);
	if (charCode != 46 && charCode != 45 && charCode > 31
			&& (charCode < 48 || charCode > 57))
		return false;

	return true;
} 
jQuery('.html_found').change(function() {
   if (jQuery(this).val().match(/<(\w+)((?:\s+\w+(?:\s*=\s*(?:(?:"[^"]*")|(?:'[^']*')|[^>\s]+))?)*)\s*(\/?)>/)) {
	  alert('Invalid html content found');
	  jQuery(this).focus();
	  jQuery(this).val('');
   }
})

jQuery("#myform").validate({
		rules: {
            name:"required",
			email: {
			  required: true,
			  email: true
			},
           mobile: {
					required: true,
					number: true
			},
			topic_id:"required",
			message:"required",
			
		},
		messages: {
			name: "Please enter your name",
			email:{
				required:"Please enter email",
				email:"Please enter valid email",
			} ,
			mobile:{
				required: "Please enter mobile number",
				number: "Please enter valid mobile number"
			},
			topic_id:"Please select topic",
			message:"Please enter message",
			
		},
		
	})
</script>