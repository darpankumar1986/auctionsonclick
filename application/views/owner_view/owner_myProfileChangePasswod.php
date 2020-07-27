<?php 
if($row){
    
        foreach($row as $tmp_data){
            
            $id=$tmp_data->id; 
            $user_id = $tmp_data->email_id;
            $first_name = $tmp_data->first_name;
            $last_name = $tmp_data->last_name;
            $password = $tmp_data->password;
            $designation = $tmp_data->designation;
            $mobile_no = $tmp_data->mobile_no;
            $indate = $tmp_data->indate;
        }
}

//echo '<pre>', print_r($row), '</pre>';
?> 


<section class="body_main1">
  
    <?php //echo $breadcrumb;?>
  
  <div class="row">
	  <div class="box-head"><?php echo $heading; ?> (<?php echo $user_id; ?>)</div>
    <div class="wrapper-full">
      <div class="dashboard-wrapper">
          
        <div id="tab-pannel6" class="btmrgn">
          <div class="tab_container6"> 
              
            <!---- buy tab container start ---->
            <div id="tab1" class="tab_content6" style="display:block">
              <div id="tab-pannel3" class="btmrgn">
                <div class="tab_container3 whitebg"> 
                  <!-- Buy > My Message start -->
                  <div id="tab7" class="tab_content3 box-content2">
                    <div class="container">
                      <div class="secttion-left">
                        <div class="left-widget">
                          <nav class="continer"></nav>
                        </div>
                      </div>
                        
                        <div class="secttion-right">
                            <div class="profile-wrapper">
		

                                  <div class="continer2">

                                      <form name="myform" id="myform" method="POST" action="myProfileChangePasswordSave">
										  <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash();?>" />
                                        <div class="profile-data">
											<?php 
											if($this->session->flashdata('message_validation')){?>

                                                <dl class="error2">
													<?php echo $this->session->flashdata('message_validation'); ?>
                                                </dl><?php
                                            }?>
                                            <?php 
											if($this->session->flashdata('message_validation_1')){?>

                                                <dl class="error2" style="background:#33CC66 !important">
													<?php echo $this->session->flashdata('message_validation_1'); ?>
                                                </dl>
                                                <?php
                                            }?>
											<?php /* ?>
                                            <dl>
                                                <dt>Email ID</dt>
                                                <dd><strong><?php echo $user_id; ?></strong></dd>
                                            </dl>
											<?php */ ?>
                                            <div class="row">
                                                <div class="lft_heading">Old Password<font color='red'>*</font></div>
                                                <div class="rgt_detail"><input type="password" name="o_password" value="" /></div>
                                            </div>

                                            <div class="row">
                                                <div class="lft_heading">New Password<font color='red'>*</font></div>
                                                <div class="rgt_detail"><input type="password" name="n_password" id="password" value="" /></div>
                                            </div>

                                             <div class="row">
                                                <div class="lft_heading">Confirm Password<font color='red'>*</font></div>
                                                <div class="rgt_detail"><input type="password" name="c_password" id="cpassword" value="" /></div>
                                            </div>

                                            <div class="row" style="text-align:center;">
                                                <dt>&nbsp;</dt>
                                                <dd>
                                                    <input type="submit"  name="addedit" id="addedit" value="UPDATE" class="button_grey">
                                                </dd>
                                            </div>
                                        </div>
                                      </form>

                                      <div class="last-login">

                                          <!--<dl>
                                          <dt>Last Login  Seen:</dt>
                                          <dd>Monday, 22/05/2015, 11:00 AM</dd>
                                          </dl>-->

                                          <div class="row">
                                              <div class="lft_heading">Account Opening Date:</div>
                                              <div class="rgt_detail"><?php echo date("l, d/m/Y h:i A", strtotime($indate)); ?></div>
                                          </div>
                                      </div>
                                  </div>
                            </div>
                        </div>
                    </div>
                  </div>
                  <!-- Buy > My Message end --> 
                </div>
              </div>
            </div>
            <!---- buy tab container end ----> 
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
