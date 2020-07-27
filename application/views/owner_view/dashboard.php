<?php
	$categoryByRank=$this->owner_model->GetPopularPropertyTypeByRank();
	$auctionByRange=$this->owner_model->GetPopularAuctionByRange();
	$cateRank1=$categoryByRank[1];
	$cateRank2=$categoryByRank[2];
	$cateRank3=$categoryByRank[3];
	$cateRank4=$categoryByRank[4];
	$cateRank5=$categoryByRank[5];
	$auctionByRangenew=$auctionByRange;
	arsort($auctionByRangenew);
	$rankArr=array();
	foreach($auctionByRangenew as $key=>$rank){
		$rankArr[]=$key;
	}
	//echo "<pre>";
	//print_r($getpopular);
	//echo "</pre>";
?>
<section>
    <?php echo $breadcrumb;?>
  <div class="row">
    <div class="wrapper-full">
      <div class="dashboard-wrapper">
        <div class="search-row">
		<form name="advance_search" id="advance_search" method="GET" action="/property">
          <div class="srch_wrp">
            <input type="text" value=""  id="key" name="key">
            <span class="ser_icon" onclick="submit_search_form();"></span>
		  </div>
		</form>
          <a href="/property">Advance Search+</a> 
        </div>
          
        <div id="tab-pannel6" class="btmrgn">
            
          <ul class="tabs6">
            <a href="/owner/"><li class="active" rel="tab1">Buy</li></a>
            <a href="/owner/sell/"><li rel="tab2">Sell</li></a>
          </ul>
            
          <div class="tab_container6"> 
              
            <!---- buy tab container start ---->
            <div id="tab1" class="tab_content6" style="display:block">
              <div id="tab-pannel3" class="btmrgn">
                  <ul class="tabs3">
                    <a href="/owner/"><li class="active" rel="tab9">My Summary</li></a>
                  <a href="/owner/liveAuction"><li rel="tab10">My Activity</li></a>
                  <a href="/owner/myMessage"><li rel="tab11">My Message</li></a>
                  <a href="/owner/myProfile"><li rel="tab12">My Profile</li></a>
                </ul>
                <div class="tab_container3 whitebg"> 
                  
                  <!-- Buy > My Summary start -->
                  <div id="tab5" class="tab_content3">
                    <div class="container"> 
                      <!---- Dashboard -left ---->
                      <div class="dashboard-left owner-bg">
                        <div class="col1">
                          <div class="block-right2">
                            <div class="auction-category">
                              <div class="auction-category-heading">Auction </div>
                              <div class="continer">
                                <dl>
                                  <dt>
                                    <div class="circle-wrapper2"><img src="/images/auction-parcipation.png"></div>
                                    Auction Participated Till Now</dt>
                                  <dd id="auc_participated"><?php echo $dashboard_statics_data['auc_participated']?></dd>
                                </dl>
                                <dl>
                                  <dt>
                                    <div class="circle-wrapper2"><img src="/images/property-sucessful.png"></div>
                                    Number of Property Successfully Own</dt>
                                  <dd id="auc_own"><?php echo $dashboard_statics_data['auc_own']?></dd>
                                </dl>
                                <dl>
                                  <dt>
                                    <div class="circle-wrapper2"><img src="/images/active-property.png"></div>
                                    Current Active Property</dt>
                                  <dd id="auc_active"><?php echo $dashboard_statics_data['auc_active']?></dd>
                                </dl>
                              </div>
                            </div>
                          </div>
                        </div>
                        <div class="col1">
                          <div class="block-right2">
                            <div class="auction-category">
                              <div class="auction-category-heading">Non-Auction </div>
                              <div class="continer">
                            
                                <dl>
                                  <dt>
                                    <div class="circle-wrapper2"><img src="/images/requirement-posted.png"></div>
                                    Requirement Posted</dt>
                                  <dd id="requirementPosted"><?php echo $dashboard_statics_data['requirementPosted']?></dd>
                                </dl>
								
							
								<!--
                                <dl>
                                  <dt>
                                    <div class="circle-wrapper2"><img src="/images/response-recived.png"></div>
                                    Response Received</dt>
                                  <dd id="responseReceived"><?php //echo $dashboard_statics_data['responseReceived']?></dd>
                                </dl>-->
                              </div>
                            </div>
                          </div>
						  	<div style="color:red;"> <?php echo $this->session->flashdata('msg');?></div>
                        </div>
                      </div>
                      <!---- Dashboard -left ----> 
                      
                       <div class="dashboard-right">
                        <div class="block-right">
						<div id="testquery"></div>
                              <div class="auction-time">
                        <select onchange="buyOwnerDashboardData(this.value,'buy','monthly')" name="month">
								  <option>Monthly</option>
								  <option value="1">Jan</option>
								  <option value="2">Feb</option>
								  <option value="3">Mar</option>
								  <option value="4">Apr</option>
								  <option value="5">May</option>
								  <option value="6">Jun</option>                              
								  <option value="7">Jul</option>                              
								  <option value="8">Aug</option>                              
								  <option value="9">Sep</option>                              
								  <option value="10">Oct</option>                              
								  <option value="11">Nov</option>                              
								  <option value="12">Dec</option> 
								</select>
                              
                        <select  onchange="buyOwnerDashboardData(this.value,'buy','quarterly')" name="Quarterly">
								  <option>Quarterly</option>
								  <option value="1-3">Jan - Mar</option>
								  <option value="4-6">Apr - Jun</option>
								  <option value="7-9">Jul - Sept</option>                          
								  <option value="10-12">Oct - Dec</option>                          
                              </select>
                              
                        <select onchange="buyOwnerDashboardData(this.value,'buy','annually')" name="Annually">
								  <option>Annually</option>
								  <option value="2015">2015</option>
								  <option value="2014">2014</option>
								  <option value="2013">2013</option>
								  <option value="2012">2012</option>
								  <option value="2011">2011</option>
								  <option value="2010">2010</option>
                              </select>
                           </div>
                            </div>
                        <div class="block-right">
                              <div class="property-type">
                            <div class="auction-category-heading"> Popular Property Types <span class="white-arrow float-right"><img src="/images/white-arrow.png"></span>
                                  <div class="arrow-down"></div>
                                </div>
                            <div class="continer2">
                                  <div class="row">
                                <div class="circle-wrapper2"><img src="/images/property-type.png"></div>
                              <span class="cloud-wrapper"> 
								<?php
								
									if($getpopular>0){
										foreach($getpopular as $category)
										{
											
											if($cateRank1==$category->name){
												$class='font5';
											}elseif($cateRank2==$category->name){
												$class='font4';
											}else if($cateRank3==$category->name)
											{
												$class='font3';
											}else if($cateRank4==$category->name){
												$class='font2';
											}else{
												$class='font1';
											}	
											?><a target="_blank" href="/property?category[]=<?php echo $category->name;?>" class="<?php echo $class; ?>"><?php echo $category->name;?></a><?php	
										}									
										
									}
								?>
								</span> 
								
								</div>
                                </div>
                          </div>
                              <div class="property-type">
                            <div class="auction-category-heading"> Most Popular <span class="white-arrow float-right"><img src="/images/white-arrow.png"></span>
                                  <div class="arrow-down"></div>
                                </div>
                            <div class="continer2">
                                  <div class="row">
                                <div class="circle-wrapper2"><img src="/images/money-less.png"></div>
                           <span class="cloud-wrapper">
								<?php
								if($rankArr[0]=='lessThen25leck'){
									$font='font5';
								}else{
									$font='font3';
								}
								if($rankArr[0]=='between50_75lack'){
									$font1='font5';
								}else{
									$font1='font3';
								}
								if($rankArr[0]=='morethan10caror'){
									$font2='font5';
								}else{
									$font2='font3';
								}
								
								if($rankArr[0]=='between1caror5caros_10caror'){
									$font3='font5';
								}else{
									$font3='font3';
								}
								if($rankArr[0]=='between1caror_2_5carors'){
									$font4='font5';
								}else{
									$font4='font3';
								}
								if($rankArr[0]=='between25_50lack'){
									$font5='font5';
								}else{
									$font5='font3';
								}
								if($rankArr[0]=='between1caror2_5carors_5caros'){
									$font6='font5';
								}else{
									$font6='font3';
								}
								?>
								<a target="_blank" href="/property?budget[]=0-500000"  class="<?php echo $font; ?>">less than 5 lakh</a> 
								
								<a target="_blank" href="/property?budget[]=500000-1000000" class="<?php echo $font1; ?>">5-10 lakhs</a> 
								
								<a target="_blank" href="/property?budget[]=1000000-2000000" class="<?php echo $font2; ?>">10-20 lakhs</a>
								
								<a target="_blank" href="/property?budget[]=2000000-3000000" class="<?php echo $font3; ?>">20-30 lakhs</a> 
								
								<a target="_blank" href="/property?budget[]=3000000-4000000" class="<?php echo $font4; ?>">30-40 lakhs</a>
								
								<a target="_blank" href="/property?budget[]=4000000-5000000" class="<?php echo $font5; ?>">40-50 lakhs </a> 
								
								<a target="_blank" href="/property?budget[]=500000-10000000000" class="<?php echo $font6; ?>">more then 50 Lacs</a> 
								
								</span> 

								</div>
                                </div>
                          </div>
                            </div>
                      </div>
                      
                      <!---- Dashboard -right ----> 
                    </div>
                  </div>
                  
                  
            
          </div>
        </div>
      </div>
    </div>
  </div>
</section>