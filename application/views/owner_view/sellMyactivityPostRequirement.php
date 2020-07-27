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
                    <a href="/owner/sell"><li class="active" rel="tab9">My Summary</li></a>
                  <a href="/owner/liveAuction"><li rel="tab10">My Activity</li></a>
                 <a href="/owner/myMessage?type=sell"><li rel="tab11">My Message</li></a>
                  <a href="/owner/myProfile?type=sell"><li rel="tab12">My Profile</li></a>
                </ul>
                <div class="tab_container7 whitebg"> 
                 
                  
                  <!-- Sell > My Activity start -->
                  
                  <div id="tab10" class="tab_content7">
                    <div class="container">
                      <div class="secttion-left">
                        <div class="left-widget">
                          <div id="cssmenu">
                            <ul>
                              <li class="has-sub "><a href="#"><span>My Auction</span></a>
                                <ul >
                                  <li><a href="/owner/liveAuction">Live Auction</a> </li>
                                  <li><a href="/owner/upcomingAuction">Upcoming Auction</a> </li>
                                  <li><a href="/owner/completedAuction">Completed Auction</a> </li>
                                  <li><a href="/owner/CancelAuction">Cancel Auction</a> </li>
                                  <!--<li><a href="/owner/postRequirement">Report Generated</a> </li>-->
                                </ul>
                              </li>
                              <li class="has-sub active"><a href="#"><span>My Requirement</span></a>
                                <ul style="display: block;">
                                  <li><a href="/owner/postRequirement" >Post Requirement</a> </li>
                                  <li><a href="/owner/manageRequirement">Manage Requirement</a> </li>
                                  <li><a href="/owner/matchingRequirement">Matching Requirement</a> </li>
                                </ul>
                              </li>
                              <li><a href="/owner/followBank" class="no-drop"><span>Bank you follow</span></a></li>
                              <li><a href="/owner/allFavorites" class="no-drop"><span>All Favorites</span></a></li>
                              <li><a href="/owner/lastSearch" class="no-drop"><span>View Last Search</span></a></li>
                            </ul>
                          </div>
                        </div>
                      </div>
                      <div class="secttion-right">
						<h4>Post Requirement</h4>
						<form method="post" enctype="multipart/form-data" name="postRequirement" id="postRequirement" action="/owner/postRequirement">
						<div class="form">
             <?php echo ($msg)?$msg:'';foreach($post_detail as $post_detail){}?>
              <dl>
                <dt class="required">
                  <label>I want to buy /rent</label>
                </dt>
                <dd>
                  <select name="is_buy" id="is_buy" class="select">
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
                  <select name="is_auction" id="is_auction" class="select">
				  <option value="">Select</option>
				  <option value="auction" <?php echo ("auction"==$post_detail->is_auction)?'selected':''; ?>>Auction</option>
				  <option value="non-auction" <?php echo ("non-auction"==$post_detail->is_auction)?'selected':''; ?>>Non auction</option>
                  </select>
				  <span class="help-icon" title="Auction /non auction based properties"></span>
                </dd>
              </dl>
              <dl>
                <dt class="required">
                  <label>Property type</label>
                </dt>
                <dd>
                  <select name="property_type" id="property_type" class="select">
				  <option value="">Select</option>
				  <option value="flat" <?php echo ('flat'==$post_detail->property_type)?'selected':''; ?>>flat</option>
				  <option value="plot" <?php echo ('plot'==$post_detail->property_type)?'selected':''; ?>>plot</option>
				  <option value="villa" <?php echo ('villa'==$post_detail->property_type)?'selected':''; ?>>villa</option>
                  </select>
				  <span class="help-icon" title="Property type - flat/plot /villa"></span>
                </dd>
              </dl>
             
              <dl>
                <dt class="required">
                  <label>City</label>
                </dt>
                <dd>
                  <input name="city" value="<?php echo $post_detail->city;?>"  id="city" type="text"  class="input">
                  
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
                <dt class="required">
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
                <dt class="required">
                  <label>Budget</label>
                </dt>
                <dd>
                  <input name="budget"  id="budget" type="text" value="<?php echo $post_detail->budget; ?>"  class="input">
                  <span class="help-icon" title="Budget"></span> </dd>
              </dl>
              
              <div class="seprator btmrg20"></div>
			  
			  
			    <div class="button-row">	
					<input name="id" type="hidden" value="<?php echo $post_detail->id?>" >      
					<input name="submit" value="Post"  type="submit" class="b_submit float-right">      

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