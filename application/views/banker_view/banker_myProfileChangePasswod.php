<?php 
if($row){
    
        foreach($row as $tmp_data){
            
            $id=$tmp_data->id; 
            $user_id = $tmp_data->user_id;
            $first_name = $tmp_data->first_name;
            $last_name = $tmp_data->last_name;
            $password = $tmp_data->password;
            $designation = $tmp_data->designation;
            $mobile_no = $tmp_data->mobile_no;
        }
}

//echo '<pre>', print_r($row), '</pre>';
?> 



<section class="body_main1">
  <?php echo $breadcrumb;?>
  <div class="row">
    <div class="wrapper-full">
      <div class="dashboard-wrapper">
        <div class="search-row">

        <div id="tab-pannel3" class="btmrgn">

            
          <div class="tab_container3">
            
            
            <!-- #tab2 -->
            
            <div id="tab6" class="tab_content3">
              <div class="container">
               
                <div class="secttion-right">
                  <div class="profile-wrapper">
                      
                      <div class="box-head no_cursor"><?php echo $heading; ?></div>
                      
                      <div class=" table-section form box-content2">
                          <form name="myform" id="myform" method="POST" action="myProfileChangePasswordSave">
							  <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash();?>" />
                            <div class="profile-data"><?php
                            
                                if($this->session->flashdata('message_validation')){?>
                                
                                    <dl class="error2">
													<?php echo $this->session->flashdata('message_validation'); ?>
                                                </dl><?php
                                }?>
                                <?php
                            
                                if($this->session->flashdata('message_validation1')){?>
                                
                                    <dl class="error2" style="background:#33CC66 !important">
										<?php echo $this->session->flashdata('message_validation1'); ?>
                                    </dl><?php
                                }?>
                                
                                
                              
                                
                                
                                 <div class="row">
									<div class="lft_heading">Email ID <span class="red">*</span></div>
									<div class="rgt_detail">
												<?php echo $user_id; ?>
									</div>
								</div>
								
								<div class="row">
									<div class="lft_heading">Old Password <span class="red">*</span></div>
									<div class="rgt_detail">
											<input type="password" name="o_password" value="" />
									</div>
								</div>
								
								<div class="row">
									<div class="lft_heading">New Password<span class="red">*</span></div>
									<div class="rgt_detail">
											<input type="password" name="n_password" id="password" value="" />
									</div>
								</div>
								
								<div class="row">
									<div class="lft_heading">Confirm Password<span class="red">*</span></div>
									<div class="rgt_detail">
											<input type="password" name="c_password" id="cpassword" value="" />
									</div>
								</div>
								
								
                 
								<div class="button-row row" style="text-align:center;">
						
			                         <input type="submit"  name="addedit" id="addedit" value="UPDATE" class="b_publish button_grey">
					       

								</div>


                            </div>
                          </form>
                      
                      <!--<div class="last-login">
                      
                      <dl>
                      <dt>Last Login  Seen:</dt>
                      <dd>Monday, 22/05/2015, 11:00 AM</dd>
                      </dl>
                      
                      <dl>
                      <dt>Account Opening Date:</dt>
                      <dd>22/05/2015</dd>
                      </dl>
                      </div>-->
                      </div>
                    </div>
                </div>
              </div>
            </div>
            
            <!-- #tab2 --> 
          </div>
        </div>
      </div>
    </div>
  </div>
</section>







