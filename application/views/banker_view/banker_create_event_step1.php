<?php
	$bank_users	=	$this->session->userdata['id'];
	//echo "<pre>";
	//print_r($arows);
	//echo "</pre>";
	if($arows->first_opener)
	{
	$bank_users=$arows->first_opener;	
	}else{
	$bank_users=$bank_users	;	
	}
	
	//echo $bank_users;
	//$this->session->userdata();
	
?>
<section>
  <?php //echo $breadcrumb;?>
  <div class="row">
    <div class="wrapper-full">
      <div class="dashboard-wrapper">
        <div id="tab-pannel3" class="btmrgn">
          <div class="tab_container3">
            
            
            <!-- #tab1 -->
            <div id="tab6" class="tab_content3">
              <div class="container">
                <?php echo $leftPanel?>
                <div class="secttion-right">
                  <div class="table-wrapper btmrg20">
                    <div class="table-heading btmrg">
                      <div class="heading4">Live Auction</div>
                      <!--<div class="srch_wrp2">
                        <input type="text" value="Search" id="search" name="search">
                        <span class="ser_icon"></span> </div>-->
                    </div>
                    <div class="table-section">
						<!--///--->
						<?php /* ?>
						<div class="stepwise-wrapper">
								  <div class="step-active">
								  Step 1
								  <span>1</span>
								  <div class="arrow-down"></div>
								  </div>
								  <div class="step-default">
								   Step 2
								  <span>2</span>
								  <div class="arrow-down"></div>
								  </div>
								  <div class="step-default">
								   Step 3
								  <span>3</span>
								  <div class="arrow-down"></div>
								  </div>
					  </div>
					  <?php */ ?>
					  <form method="post" name="createevent" id="createevent" action="/buyer/createEventproperty/<?php echo $eventid;?>">
					  <?php 
						$totalUser= count($banksUsersList); ?>
					  <div class="form">
						   <dl>
								<dt class="required">
								  <label>User ID (Email ID)</label>
								</dt>
								<dd>
								  <select name="bankuser" id="bankuser" class="select">
								  <option value="">Select Bank Users</option>
								  <?php
								  if($totalUser>0)
								  { 
									foreach($banksUsersList as $urow){
									if($bank_users==$urow->id){$sele="selected";}else{$sele="";}
									?>
									<option <?php echo $sele; ?> value="<?php echo $urow->id;?>"><?php echo $urow->email_id;?>, <?php echo $urow->user_id;?>, <?php echo ucfirst($urow->first_name);?>  <?php echo $urow->last_name;?></option>    
								  <?php }
								  
								  } ?>

								  </select>
								</dd>
						  </dl>
						  <div class="seprator btmrg20"></div>
						  <div class="button-row">
						  <a href="/buyer/savedEvents"><input name="Back" value="Back" type="button" class="b_submit"> </a>
							<input name="submit" value="Create Auction(Continue)" type="submit" class="b_publish"> 
							<input type="hidden" name="auctionID" id="auctionID" value="<?php echo $auctionID?>">
						  </div>
					  </div>
						</form>
					</div>
                  </div>
                </div>
              </div>
            </div>
            
            
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<script type="text/javascript" src="/application/views/admin/js/plugins/jquery.validate.min.js"></script>
<script>
jQuery(document).ready(function(){
	jQuery("#createevent").validate({
		rules: {
			bankuser: "required"
		},
		messages: {
			name:  "Please select user name"			
		}
	});
});
</script>
