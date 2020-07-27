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



<section>
  <?php echo $breadcrumb;?>
  <div class="row">
    <div class="wrapper-full">
      <div class="dashboard-wrapper">
        <div class="search-row">
          <div class="srch_wrp">
            <input type="text" value="Search" id="search" name="search">
            <span class="ser_icon"></span> </div>
          <a href="#">Advance Search+</a> </div>
        <div id="tab-pannel3" class="btmrgn">
          <div class="tab_container3">
            
            
            <!-- #tab2 -->
            
            <div id="tab8" class="tab_content3">
              <div class="container">
                <div class="secttion-left">
				 <div class="left-widget">
                  <div class="auction-category-heading">My Profile</div>
                  <div class="continer">
                    <ul>
                      <li> <a href="#"> <span class="circle-wrapper2"><img src="<?php echo base_url(); ?>images/mymessage-icon1.png"></span> View Profile</a></li>
                      <li> <a href="#"> <span class="circle-wrapper2"><img src="<?php echo base_url(); ?>images/mymessage-icon2.png"></span> <?php echo BRAND_NAME; ?></a></li>
                    </ul>
                  </div>
                  </div>
                </div>
                <div class="secttion-right">
                  <div class="profile-wrapper">
                      
                      <div class="category-heading2"><?php echo $heading; ?></div>
                      
                        <div class="profile-edit">
                            <a href="/buyer/myProfile">Cancel</a>
                        </div>
                      
                      <div class="continer2">
                          <form name="myform" id="myform" method="POST" action="myProfileEditSave">
                            <div class="profile-data"><?php
                            
                                if($this->session->flashdata('message_validation')){?>
                                
                                    <dl style="color: red;">
                                        <?php echo $this->session->flashdata('message_validation'); ?>
                                    </dl><?php
                                }?>
                                
                                <dl>
                                    <dt>Email ID</dt>
                                    <dd><strong><?php echo $user_id; ?></strong></dd>
                                </dl>

                                <dl>
                                    <dt>First Name<font color='red'>*</font></dt>
                                    <dd><input type="text" name="first_name" id="first_name" value="<?php echo $first_name ?>" /></dd>
                                </dl>

                                <dl>
                                    <dt>Last Name<font color='red'>*</font></dt>
                                    <dd><input type="text" name="last_name" id="last_name" value="<?php echo $last_name ?>" /></dd>
                                </dl>

                                <dl>
                                    <dt>Designation<font color='red'>*</font></dt>
                                    <dd><input type="text" name="designation" id="designation" value="<?php echo $designation ?>" /></dd>
                                </dl>

                                <dl>
                                    <dt>Mobile No<font color='red'>*</font></dt>
                                    <dd><input type="text" name="mobile_no" id="mobile_no" value="<?php echo $mobile_no ?>" /></dd>
                                </dl>

                                <dl>
                                    <dt>&nbsp;</dt>
                                    <dd>
                                        <input type="submit"  name="addedit" id="addedit" value="UPDATE">
                                    </dd>
                                </dl>
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







