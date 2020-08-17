<script type="text/javascript" src="<?php echo base_url(); ?>js/bootstrap-3.3.2.min.js"></script>
<style>
@media screen and (max-width: 750px){
.box-head {
    width: 98%;
}
</style>

<?php 
if($row){
        foreach($row as $tmp_data);
            $id=$tmp_data->id; 
            $user_id = $tmp_data->email_id;
            $emali = $tmp_data->email_id;
            $first_name = $tmp_data->first_name;
            $last_name = $tmp_data->last_name;
            $father_name = $tmp_data->father_name;
            $address1 = $tmp_data->address1;
            $address2 = $tmp_data->address2;
			$country_id = $tmp_data->country_id;
            $state_id = $tmp_data->state_id;
            $city_id = $tmp_data->city_id;
			$state=GetTitleByField('tbl_state', "id='".$state_id."'", 'state_name');
			$country=GetTitleByField('tbl_country', "id='".$country_id."'", 'country_name');
			$city=GetTitleByField('tbl_city', "id='".$city_id."'", 'city_name');
            $zip = $tmp_data->zip;
            $user_type = $tmp_data->user_type;
            $document_type = $tmp_data->document_type;
            $document_no = $tmp_data->document_no;
            $organisation_name = $tmp_data->organisation_name;
            $authorized_person = $tmp_data->authorized_person;
            $fax = $tmp_data->fax;
            $phone_no = $tmp_data->phone_no;
            $broker_photo = $tmp_data->broker_photo;
            $website_URL = $tmp_data->website_URL;
            $company_logo = $tmp_data->company_logo;
            $operating_since = $tmp_data->operating_since;
            $transacation_type = $tmp_data->transacation_type;
            $company_name = $tmp_data->company_name;
            $user_source = $tmp_data->user_source;
            $designation = $tmp_data->designation;
            $mobile_no = $tmp_data->mobile_no;
            $gst_no = $tmp_data->gst_no;
            $indate = $tmp_data->indate;
        
}
$tabtype=$this->input->get('type');
?> 

<section class="body_main1">
  
    <?php echo $breadcrumb;?>
  
  <div class="row">
   <div class="box-head"><?php echo $heading; ?></div>  
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
                        <div class="left-widget"><?php /* ?>
                          <div class="auction-category-heading">My Message
                            <div class="arrow-down"></div>
                          </div> <?php */ ?>
                          <nav class="continer">
                            <?php //echo $leftPanel; ?>
                          </nav>
                        </div>
                      </div>
                        
                        <div class="secttion-right">
						
                            <div class="profile-wrapper">
								
                               
                                  <div class="continer2">
                                      <div class="profile-data">
										  <?php
                            
                                            if($this->session->flashdata('message_validation_1')){?>

                                                <dl class="success_msg">
                                                    <?php echo $this->session->flashdata('message_validation_1'); ?>
                                                </dl>
                                                <?php
                                            }?>
									  <?php if($user_id){ ?>
                                          <div class="row">
                                              <div class="lft_heading">Email ID:</div>
                                              <div class="rgt_detail"><strong><?php echo $user_id; ?></strong></div>
                                          </div>
									  <?php } ?>
										<?php if($organisation_name) {?>
										  <div class="row">
                                              <div class="lft_heading">Organization name</div>
                                           <div class="rgt_detail"><?php echo ucfirst($organisation_name); ?>  </div>
                                          </div>
										  <?php } ?>
										  <?php if($authorized_person) {?>
										  <div class="row">
                                              <div class="lft_heading">Authorized person</div>
                                           <div class="rgt_detail"><?php echo ucfirst($authorized_person) ?>  </div>
                                          </div>
										  <?php } ?>
									  <?php if($first_name) { ?>
                                          <div class="row">
                                              <div class="lft_heading">Name</div>
                                              <div class="rgt_detail"><?php echo ucfirst($first_name) ?> <?php echo ucfirst($last_name) ?></div>
                                          </div>
									  <?php } ?>
									  
									  <?php if($father_name) {?>
										<div class="row">
                                              <div class="lft_heading">Father's/Husband's Name</div>
                                              <div class="rgt_detail"><?php echo ucfirst($father_name) ?></div>
                                      </div>
									  <?php } ?>
                                         <?php if($designation) {?> 
                                          <div class="row">
                                              <div class="lft_heading">Designation</div>
                                              <div class="rgt_detail"><?php echo ucfirst($designation) ?></div>
                                          </div>
										 <?php } ?>
										 <?php if($address1){?>
										 <div class="row">
                                              <div class="lft_heading">Address1</div>                                    
                                                <div class="rgt_detail"><?php echo $address1 ?></div>
                                          </div>
										 <?php }?>
										 <?php if($address2) {?>
										  <div class="row">
                                              <div class="lft_heading">Address2</div>
                                              <div class="rgt_detail"><?php echo $address2 ?></div>
                                          </div>
										  <?php } ?>
										 
										  <?php if($country) {?>
										  <div class="row">
                                              <div class="lft_heading">Country</div>
                                              <div class="rgt_detail"><?php echo $country ?></div>
                                          </div>
										  <?php } ?>
										  <?php if($state) {?>
										  <div class="row">
                                              <div class="lft_heading">State</div>
                                              <div class="rgt_detail"><?php echo $state ?></div>
                                          </div>
										 <?php } ?>
										  <?php if($city) {?>
										  <div class="row">
                                              <div class="lft_heading">City</div>
                                              <div class="rgt_detail"><?php echo $city ?></div>
                                          </div>
										  <?php } ?>
										  <?php if($zip) {?>
										  <div class="row">
                                              <div class="lft_heading">Zip/Pin Code</div>
                                              <div class="rgt_detail"><?php echo $zip ?></div>
                                          </div>
										 <?php } ?>
										  <?php if($document_type) {?>
										  <div class="row">
                                              <div class="lft_heading">Document</div>
                                           <div class="rgt_detail">
										   <?php if($document_type=='form-16'){?>
										   Form 16 : 
										   <a download href="<?php base_url();?>/public/uploads/userdoc/<?php echo $document_no; ?>"><?php echo $document_no; ?></a>
										   <?php }else{ ?>
										   <?php echo "Pan No : ".strtoupper($document_no); ?> </div>
										   <?php } ?>
                                          </div>
										  <?php } ?>
										 </div>
										 <?php if($mobile_no) { ?>  
                                         <div class="row">
                                              <div class="lft_heading">Mobile No</div>
                                              <div class="rgt_detail"><?php echo $mobile_no ?></div>
                                          </div>
										 <?php } ?>
										  
										  <?php if($phone_no) {?>
											<div class="row">
                                              <div class="lft_heading">Phone no</div>
                                           <div class="rgt_detail"><?php echo $phone_no ?> </div>
                                          </div>
										  <?php } ?>
										  <?php if($gst_no) {?>
											<div class="row">
                                              <div class="lft_heading">GST No.</div>
                                           <div class="rgt_detail"><?php echo strtoupper($gst_no) ?> </div>
                                          </div>
										  <?php } ?>
										  <?php if($fax) {?>
										  <div class="row">
                                              <div class="lft_heading">Fax</div>
                                           <div class="rgt_detail"><?php echo $fax ?>  </div>
                                          </div>
										  <?php } ?>
										  <?php if($website_URL) {?>
										  <div class="row">
                                              <div class="lft_heading">Website URL</div>
                                           <div class="rgt_detail"><?php echo $website_URL ?>  </div>
                                          </div>
										  <?php } ?>
	
										  <?php if($service_title) {?>
										  <div class="row">
                                              <div class="lft_heading">Service title</div>
                                           <div class="rgt_detail"><?php echo $service_title ?> </div>
                                          </div>
											<?php } ?>
									<?php if($transacation_type) {?>
										  <div class="row">
                                              <div class="lft_heading">Transaction types</div>
                                           <div class="rgt_detail"><?php echo $transacation_type ?> </div>
                                          </div>
											<?php } ?>											
											
									   <!--<div class="row">
                                              <div class="lft_heading">Account Opening Date:</div>
                                              <div class="rgt_detail"><?php echo date("l, d/m/Y h:i A", strtotime($indate)); ?></div>
                                          </div>-->
											
											
                                      </div>
									   
									
									  

                                      <div class="last-login">

                                          <!--<dl>
                                          <dt>Last Login  Seen:</dt>
                                          <dd>Monday, 22/05/2015, 11:00 AM</dd>
                                          </dl>-->

                                         
                                      </div>
									  <hr style="width:100%; margin:15px 0 0 0; float:left;">
                                      <div class="row" style="text-align:center;">
                                                    <a href="<?=  base_url();?>owner/myProfileEdit" class="button_grey">Edit Profile</a>
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
