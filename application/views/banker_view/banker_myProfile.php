<link rel="stylesheet" href="<?php echo base_url()?>assets/css/jquery.dataTables.css" />
<link rel="stylesheet" href="<?php echo base_url()?>bankeauc/css/tables.css" />
<link rel="stylesheet" href="<?php echo base_url()?>bankeauc/css/common.css" />


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
            $indate = $tmp_data->indate;
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
                  <div class="auction-category-heading">View My Profile
                    <div class="arrow-down"></div>
                  </div>
                  <div class="continer">
                    <ul>
                      <li> <a class="active" href="/buyer/myProfile"> <span class="circle-wrapper2"><img src="<?php echo base_url(); ?>images/mymessage-icon1.png"></span> View Profile</a></li>
                      <li> <a href="<?php echo "/buyer/myProfileChangePassword"; ?>"> <span class="circle-wrapper2"><img src="<?php echo base_url(); ?>images/mymessage-icon2.png"></span> Change Password</a></a></li>
		     
                    </ul>
                  </div>
                  </div>
                </div>
                <div class="secttion-right">
                  <div class="profile-wrapper">
                      
                      <div class="category-heading2"><?php echo $heading; ?></div>
                                           
                      <div class="continer2">
                          
                      <div class="profile-data">
                            <dl>
                                <dt>Email ID</dt>
                                <dd><strong><?php echo $user_id; ?></strong></dd>
                            </dl>

                            <dl>
                                <dt>First Name</dt>
                                <dd><?php echo $first_name ?></dd>
                            </dl>

                            <dl>
                                <dt>Last Name</dt>
                                <dd><?php echo $last_name ?></dd>
                            </dl>

                            <dl>
                                <dt>Designation</dt>
                                <dd><?php echo $designation ?></dd>
                            </dl>

                            <dl>
                                <dt>Mobile No</dt>
                                <dd><?php echo $mobile_no ?></dd>
                            </dl>
                        </div>
                      
                      <div class="last-login">
                      
                      <!--<dl>
                      <dt>Last Login  Seen:</dt>
                      <dd>Monday, 22/05/2015, 11:00 AM</dd>
                      </dl>-->
                      
                      <dl>
                      <dt>Account Opening Date:</dt>
                      <dd><?php echo date ("l, d/m/Y h:i A",strtotime($indate)); ?></dd>
                      </dl>
                      </div>
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
