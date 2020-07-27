<?php
	$categoryByRank=$this->owner_model->GetPopularPropertyTypeByRank();
	//print_r($categoryByRank);
	$auctionByRange=$this->owner_model->GetPopularAuctionByRange();
	
	$cateRank1=$categoryByRank[1];
	$cateRank2=$categoryByRank[2];
	$cateRank3=$categoryByRank[3];
	$cateRank4=$categoryByRank[4];
	$cateRank5=$categoryByRank[5];
	//echo "<pre>";
	//print_r($getpopular);
	$auctionByRangenew=$auctionByRange;
	arsort($auctionByRangenew);
	//print_r($auctionByRangenew);
	//echo "</pre>";
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
            <div id="tab5" class="tab_content3">
              <div class="container">
                <div class="dashboard-left">
                  <div class="block">
                    <div class="heading"> <span class="circle-wrapper"><img src="../images/dash-icon1.png"></span> Total Number of Auction</div>
                    <div class="home-bg" id="bankactiveAuction"> <?php echo $dashboardData['activeAuction'];?> </div>
                  </div>
                  <div class="block">
                    <div class="heading"> <span class="circle-wrapper"><img src="../images/dash-icon2.png"></span> Total Invoice Raised</div>
                    <div class="home-bg" id="total_invoice_reaised"> <?php echo $dashboardData['total_invoice_reaised'];?> </div>
                  </div>
                  <div class="block">
                    <div class="heading"> <span class="circle-wrapper"><img src="../images/dash-icon3.png"></span> Payment Due</div>
                    <div class="home-bg" id="payment_due"> <?php echo $dashboardData['payment_due'];?> </div>
                  </div>
                  <div class="block">
                    <div class="heading"> <span class="circle-wrapper"><img src="../images/dash-icon4.png"></span> Outstanding Amount</div>
                    <div class="home-bg" id="outstanding_amount"> <?php echo $dashboardData['outstanding_amount'];?> </div>
                  </div>
                </div>
                <div class="dashboard-right">
                  <div class="block-right">
				 
                    <div class="auction-time">   <div class="auction-time">
                        <select onchange="buyOwnerDashboardData(this.value,'banker','monthly')" name="month">
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
                              
                        <select  onchange="buyOwnerDashboardData(this.value,'banker','quarterly')" name="Quarterly">
								  <option>Quarterly</option>
								  <option value="1-3">Jan - Mar</option>
								  <option value="4-6">Apr - Jun</option>
								  <option value="7-9">Jul - Sept</option>                          
								  <option value="10-12">Oct - Dec</option>                          
                              </select>
                              
                        <select onchange="buyOwnerDashboardData(this.value,'banker','annually')" name="Annually">
								  <option>Annually</option>
								  <option value="2015">2015</option>
								  <option value="2014">2014</option>
								  <option value="2013">2013</option>
								  <option value="2012">2012</option>
								  <option value="2011">2011</option>
								  <option value="2010">2010</option>
                              </select>
                           </div> </div>
                  </div>
                  <div class="block-right">
                    <div class="auction-category">
                      <div class="auction-category-heading"> Auction Conducted by Categories <span class="white-arrow float-right"><img src="/images/white-arrow.png"></span>
                        <div class="arrow-down"></div>
                      </div>
                      <div class="continer">
                        <dl>
                          <dt>
                            <div class="circle-wrapper2"><img src="/images/icon-home.png"></div>
                            Residential </dt>
                          <dd>
                            <div class="bar">
                              <div class="bar-green" style="width:<?php echo $auctionConductedbyCategories['residentialPercentage']*2 ?>px;"></div>
                            </div>
                            <div class="number"><?php echo $auctionConductedbyCategories['residentialPercentage']?>%</div>
                          </dd>
                        </dl>
                        <dl>
                          <dt>
                            <div class="circle-wrapper2"><img src="/images/icon-building.png"></div>
                            Commercial </dt>
                          <dd>
                            <div class="bar">
                              <div class="bar-green" style="width:<?php echo $auctionConductedbyCategories['commercialPercentage']*2 ?>px;"></div>
                            </div>
                            <div class="number"><?php echo $auctionConductedbyCategories['commercialPercentage']?>%</div>
                          </dd>
                        </dl>
                      </div>
                    </div>
                    <div class="auction-category">
                      <div class="auction-category-heading"> Most Popular <span class="white-arrow float-right"><img src="/images/white-arrow.png"></span>
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
								</span> </div>
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
  </div>
</section>
