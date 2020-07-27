<section>
  
    <?php echo $breadcrumb;?>
  
  <div class="row">
    <div class="wrapper-full">
      <div class="dashboard-wrapper">
          
        <div class="search-row">
          <div class="srch_wrp">
            <input type="text" value="Search" id="search" name="search">
            <span class="ser_icon"></span> </div>
          <a href="#">Advance Search+</a> 
        </div>
          
        <div id="tab-pannel6" class="btmrgn">
            
          <ul class="tabs6">
            <a href="/owner"><li class="active" rel="tab1">Buy</li></a>
            <a href="/owner/sell"><li rel="tab2">Sell</li></a>
          </ul>
            
          <div class="tab_container6"> 
              
            <!---- buy tab container start ---->
            <div id="tab1" class="tab_content6" style="display:block">
              <div id="tab-pannel3" class="btmrgn">
                  <ul class="tabs3">
                  <a href="/owner/"><li  rel="tab9">My Summary</li></a>
                  <a href="/owner/liveAuction"><li class="active" rel="tab10">My Activity</li></a>
                  <a href="/owner/myMessage"><li rel="tab11">My Message</li></a>
                  <a href="/owner/myProfile"><li rel="tab12">My Profile</li></a>
                </ul>
                <div class="tab_container3 whitebg"> 
                 
                  
                  <!-- Sell > My Activity start -->
                  
                  <div id="tab10" class="tab_content7">
                    <div class="container">
                 <?php echo $leftsidebar;?>
                      <div class="secttion-right">
						<h4>Post Requirement</h4>
						<form method="post" enctype="multipart/form-data" name="postRequirement" id="postRequirement" action="/owner/postRequirement">
						<div class="form">
						<div class="success" style="color:red;text-align:center;">
						<?php echo $this->session->flashdata('msg'); ?>
						</div>
						
             <?php 			 
			 foreach($post_detail as $post_detail){}?>
              <dl>
                <dt class="required">
                  <label>I want to buy /rent</label>
                </dt>
                <dd>
                  <select name="is_buy" id="is_buy" required class="select">
				  <option value="">Select</option>
				  <option value="buy" <?php echo ('buy'==$post_detail->is_buy)?'selected':''; ?>>Buy</option>
				  <option value="rent" <?php echo ('rent'==$post_detail->is_buy)?'selected':''; ?>>Rent</option>
                  </select>
				  <span class="help-icon" title="I want to buy /rent"></span>
                </dd>
              </dl>
              <dl>
                <dt class="required">
                  <label>Auction /non auction based properties</label>
                </dt>
                <dd>
                  <select name="is_auction" id="is_auction" required class="select">
				  <option value="">Select</option>
				  <option value="1" <?php echo ("1"==$post_detail->is_auction)?'selected':''; ?>>Auction</option>
				  <option value="0" <?php echo ("0"==$post_detail->is_auction)?'selected':''; ?>>Non auction</option>
                  </select>
				  <span class="help-icon" title="Auction /non auction based properties"></span>
                </dd>
              </dl>
              <dl>
                <dt class="required">
                  <label>Property type</label>
                </dt>
                <dd>
				  <select name="property_type" id="property_type" required class="select" >
						<option value="">None</option>
							<?php
							foreach($category as $category_record){?>
              <option value="<?php echo $category_record->id; ?>" <?php echo ($category_record->id==$post_detail->property_type)?'selected':''; ?>><?php echo $category_record->name; ?></option>
							<?php }?>
                  </select>
				  <span class="help-icon" title="Property type - flat/plot /villa"></span>
                </dd>
              </dl>
             
              <dl>
                <dt class="required">
                  <label>City</label>
                </dt>
                <dd>
				<?php $city=explode(',',$post_detail->city);?>
				  <select name="city[]" id="city[]" class="select" required multiple style="height:100px;" >
					<option value="">Select City</option>
							<?php
				foreach($citylist as $city_record){?>
              <option <?php if(in_array($city_record->city_name,$city))echo 'selected' ?> value="<?php echo $city_record->city_name; ?>" ><?php echo $city_record->city_name; ?></option>
							<?php }?>
                  </select>
				<!--
                  <input name="city" value="<?php echo $post_detail->city;?>"  id="city" type="text"  class="input">
				  -->
				  
				  
                  
                  <span class="help-icon" title="city"></span> </dd>
              </dl>
              <div class="seprator btmrg20"></div>
              
              <dl id="bedrooms_acc" style="<?php echo ($post_detail->property_type=='plot')?'display:none':'display:block'?>">
                <dt >
                  <label>Bedrooms</label>
                </dt>
                <dd>
                  <input name="bedrooms"  id="bedrooms" type="text" value="<?php echo $post_detail->bedrooms; ?>"  class="input">
                  <span class="help-icon" title="Bedrooms"></span> </dd>
              </dl>
              <dl id="built_up_area_acc" style="<?php echo ($post_detail->property_type=='plot')?'display:none':'display:block'?>">
                <dt >
                  <label>Covered or built up area</label>
                </dt>
                <dd>
                  <input name="built_up_area"   type="text" value="<?php echo $post_detail->built_up_area; ?>"  class="input">
                  <span class="help-icon" title="Covered or built up area"></span> </dd>
              </dl>
              <dl id="plot_area_acc" style="<?php echo ($post_detail->property_type=='plot')?'display:block':'display:none'?>">
                <dt class="required">
                  <label>Plot area</label>
                </dt>
                <dd>
                  <input name="plot_area"  id="plot_area" type="text" value="<?php echo $post_detail->plot_area; ?>"  class="input">
                  <span class="help-icon" title="Plot area"></span> </dd>
              </dl>
              <dl>
                <dt >
                  <label>Budget</label>
                </dt>
                <dd>
				<?php $budget=explode(',',$post_detail->budget);?>
				<select id="multiple-selected-budget" class="select" style="height:100px;"  name="budget[]" multiple="multiple">
				<option value="0-500000" <?php if(in_array('0-5',$budget))echo 'selected' ?>>less then 5 Lacs</option>	
				<option value="500000-1000000" <?php if(in_array('500000-1000000',$budget))echo 'selected' ?>>5-10 Lacs</option>	
				<option value="1000000-2000000" <?php if(in_array('1000000-2000000',$budget))echo 'selected' ?>>10-20 Lacs</option>	
				<option value="2000000-3000000" <?php if(in_array('2000000-3000000',$budget))echo 'selected' ?>>20-30 Lacs</option>	
				<option value="3000000-4000000" <?php if(in_array('3000000-4000000',$budget))echo 'selected' ?>>30-40 Lacs</option>	
				<option value="4000000-5000000" <?php if(in_array('4000000-5000000',$budget))echo 'selected' ?>>40-50 Lacs</option>	
				<option value="5000000-10000000000" <?php if(in_array('5000000-10000000000',$budget))echo 'selected' ?>>more then 50 Lacs</option>	
				</select>
				
				<span class="help-icon" title="Budget"></span> </dd>
              </dl>
              
              <div class="seprator btmrg20"></div>
			  
			  
			    <div class="button-row">	
				<?php if(($post_detail->id)) {
						$btn = "Update";
					} else {
						$btn = "Post";
					}?>
					<input name="id" type="hidden" value="<?php echo $post_detail->id?>" >      
					<input name="submit" value="<?php echo $btn;?>"  type="submit" class="b_submit float-left">      

				</div>

			 
            </div>
			</form>
                     </div>
                    </div>
                  </div>
                  <!-- Sell > My Activity end --> 
                  
                  
                 
                  
                </div>
              </div>
            </div>
            <!---- Sell tab container end ----> 
            
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
<link rel="stylesheet" href="/js/calender/jquery-ui.css">
<script src="/js/calender/jquery-ui.js"></script>
<script>
jQuery(document).ready(function(){
	jQuery("#postRequirement").validate({
		rules: {
			is_buy: "required",
			is_auction: "required",
			property_type: "required",
			city: "required",
			budget: "required"
		},
		messages: {
			is_buy:  "Please select buy/sell."			
		}
	});
 });
jQuery('#property_type').change(function(){
		var property_type = jQuery(this).val();
		if(property_type)
		{
			if(property_type=='plot'){
				jQuery('#built_up_area_acc').hide();	
				jQuery('#plot_area_acc').show();	
				jQuery('#bedrooms_acc').hide();	
			}else{
				jQuery('#built_up_area_acc').show();	
				jQuery('#plot_area_acc').hide();
				jQuery('#bedrooms_acc').show();	
			}
		}
		
	});	
	
	
  //tooltip
  jQuery(function() {
    jQuery('.help-icon').tooltip();
  });

</script>