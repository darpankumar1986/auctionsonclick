<?php
$user_id=$this->session->userdata('id');
if($user_id>0 and !empty($_GET)){
	$pageURL .= "http://";
	$pageURL.= $_SERVER["SERVER_NAME"].$_SERVER["REQUEST_URI"];
	$search_content = serialize($_GET);
	//print_r($search_content);exit;
	$this->property_model->saveserchData($pageURL, $search_content);	
}?>
<link rel="stylesheet" href="http://netdna.bootstrapcdn.com/font-awesome/4.3.0/css/font-awesome.min.css">
<link rel="stylesheet" href="<?php echo base_url(); ?>/css/autosuggest.css">
<script type="text/javascript" src="<?php echo base_url(); ?>js/bootstrap-3.3.2.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/bootstrap-multiselect.js"></script>
<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&signed_in=true"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/jquery.countdown.js"></script>
<link rel="stylesheet" href="<?php echo base_url()?>js/calender/jquery-ui.css">
<script src="<?php echo base_url(); ?>js/calender/jquery-ui.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/jsDatePick.jquery.min.1.3.js"></script>
<link rel="stylesheet" type="text/css" media="all" href="<?php echo base_url(); ?>/css/jsDatePick_ltr.min.css" />
<script type="text/javascript" src="<?php echo base_url(); ?>js/commonsearch.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/calender/jquery-ui-sliderAccess.js"></script>

<?php
//echo "<pre>";
//print_r($AuctionRecordsList);
//print_r($_GET);
//echo "</pre>";
$viewType=$_GET['view'];
$act=$_GET['act'];
$qeryString=$_SERVER["QUERY_STRING"];
$total_Records_Found=$AuctionRecordsList[0]->total_records;
$Alltotal_Records_Found=$Alltotal_records;
?>
<section>

<?php //echo $property_list_leftsidebar_phone; ?>
  <div class="jumbotron">
    <div class="icon-menu"><img src="/images/c_search.png" width="44" height="151"></div>
  </div>
  <div class="breadcrum">
      <div class="wrapper"> <a href="<?php echo base_url() ?>" class="Home">Home</a>
          &nbsp;»&nbsp;<span><a href="<?php echo base_url()."property" ?>">List</a></span> </div>
  </div>
  <div class="row">
  
 

  
  <form name="property_serch" id="property_serch" action="/property/" method="get" > 
    <div class="wrapper">

	<?php //if(!empty($AuctionRecordsList)){ ?>
      <div class="pro_filter-wrapper btmrg20">
      <div class="pro-result"><?php echo ($total_Records_Found>0)?$total_Records_Found=$total_Records_Found:$total_Records_Found=0; ?> Items Found out of <?php echo $Alltotal_Records_Found;?></div>
			<div class="pill-container">
			
			<?php
			 if(count($_REQUEST['category']) > 0){
				 foreach($_REQUEST['category'] as $catename){
				 $cateid=GetTitleByField('tbl_category',"name='$catename'",'id');
			 ?>
			<a class="filter-pill"><span><?php echo $catename;?></span><span class="icon-cross">
			<img onclick="removeAttributeVal('category','<?php echo $cateid;?>');" src="/images/icon-close.png"></span></a>
			<?php } } if(count($_REQUEST['propertype']) > 0){
			foreach($_REQUEST['propertype'] as $propertypeVal){
			
			?>
			<a class="filter-pill"><span><?php echo ucfirst($propertypeVal);?></span><span class="icon-cross">
			<img onclick="removeAttributeVal('propertytype','propertytype_<?php echo $propertypeVal;?>');" src="/images/icon-close.png"></span></a>
	
			<?php }} if(count($_REQUEST['bankname']) > 0){
				foreach($_REQUEST['bankname'] as $bankids){
				$bank_names=GetTitleByField('tbl_bank',"id='.$bankids.'",'name');
			?>
			<a class="filter-pill"><span><?php echo ucfirst($bank_names);?></span><span class="icon-cross">
			<img onclick="removeAttributeVal('bank','<?php echo $bankids;?>');" src="/images/icon-close.png"></span></a>
			 
				<?php }} if(count($_REQUEST['postedby']) > 0) {
					foreach($_REQUEST['postedby'] as $posted_by){
					?>
			 <a class="filter-pill"><span><?php echo ucfirst($posted_by);?></span><span class="icon-cross">
			 <img onclick="removeAttributeVal('postedby','<?php echo $posted_by;?>');" src="/images/icon-close.png"></span></a>
				<?php }}
				if(count($_REQUEST['subcategory']) > 0){
					foreach ($_REQUEST['subcategory'] as $subcate)
					{
						$subcateid=GetTitleByField('tbl_category',"name='$subcate' AND parent_id!='0' AND status!='5'",'id');
						
						?>
			 <a class="filter-pill"><span><?php echo ucfirst($subcate);?></span><span class="icon-cross">
			 <img onclick="removeAttributeVal('subcategory','<?php echo $subcateid;?>');" 
			 src="/images/icon-close.png"></span></a>	
					<?php }} ?>
			
			
			
			
			<?php
			if((count($_REQUEST['category']) > 0) || (count($_REQUEST['propertype'])) || ($_REQUEST['bankname']) || (count($_REQUEST['postedby']))){
			?>
				<a class="filter-pill" href="/property"><span>Clear All</span></a>
			<?php } ?>
			</div>
        <div class="float-right">
          <div class="pro_filter">
		  <!-- <a href="" class="grid">Grid</a> -->
			 <a href="javascript:" onclick="addViewGrid('list')"  class="grid">List</a>
			 <a href="javascript:" onclick="addViewGrid('grid')"  class="list">Grid</a>
			 <?php //} ?>
			 <input type="hidden" name="view" value="<?php echo $viewType; ?>">
                         <a href="javascript:" onclick="return showMap();" class="map">Map</a> 
                      
          </div>
          <div class="sorting_wrapper">
            <select name="sort_by" onchange="processform();" class="select">
              <option value=''>Sort By</option>
              <option <?php if($_GET['sort_by']=='name'){ echo "selected";}else{echo "";}?> value="name">Name</option>
              <option value="price" <?php if($_GET['sort_by']=='price'){ echo "selected";}else{echo "";}?>>Price</option>
             
            </select>
            <select name="limit_perpage" onchange="processform();" class="select">
              <option <?php if($_GET['limit_perpage']=='15'){ echo "selected";}else{echo "";}?> value="15">15 items per page</option>
              <option <?php if($_GET['limit_perpage']=='30'){ echo "selected";}else{echo "";}?> value="30">30</option>
              <option <?php if($_GET['limit_perpage']=='60'){ echo "selected";}else{echo "";}?> value="60">60</option>
              <option <?php if($_GET['limit_perpage']=='120'){ echo "selected";}else{echo "";}?> value="120">120</option>
              <option <?php if($_GET['limit_perpage']=='150'){ echo "selected";}else{echo "";}?> value="150">150</option>
            </select>
          </div>
        </div>
      </div>
        <?php //} ?>
      <div class="auction_product_wrapper">
	  <?php echo $property_list_leftsidebar; ?>
        <div class="pro-right-wrapper"> 
		<?php if($act=='non_auction'){
		if($AuctionRecordsList!=0){	
		?>
		<ul>
		<?php
				  //echo "<pre>";
					//print_r($AuctionRecordsList);
				 // echo "</pre>";	
			$i=1;				 
		  foreach($AuctionRecordsList as $propertyData){
					$imagename		=	$propertyData->image[0]->name;
					$propertyName	=	$propertyData->name;
					$product_type	=	$propertyData->product_type;
					$product_subtype_val=$auctionData->product_subtype_val;
					$city			=	$propertyData->city;
					$state			=	$propertyData->state;
					$country		=	$propertyData->country;
					$city			=	GetTitleByField('tbl_city', "id='".$city."'", 'city_name');
					$product_type	=	GetTitleByField('tbl_category', "id='".$product_type."'", 'name');
					$reserve_price	=	$propertyData->price;
					$attribute		=	$propertyData->attribute;
					$address1		=	$propertyData->address1;
					$street			=	$propertyData->street;
					$state			=	GetTitleByField('tbl_state', "id='".$state."'", 'state_name');
					$country		=	GetTitleByField('tbl_country', "id='".$country."'", 'country_name');
					$fulladdress	= 	$address1.', '.$street.', '.$city.', '.$country;
					$product_id		=	$propertyData->id;
					$imagepath='/public/uploads/property_images/'.$imagename;								  
?>
		<?php if($viewType=='grid' && $product_id>0) { ?>
          <li class="detail-full" >
              <div class="auction_prowidget">
                <div class="image-wrapper">
				<?php if($imagename!=''){ ?>
				<img src="<?php echo $imagepath; ?>">  
				<?php }else{ ?>
				<div class="add" id="add_<?php echo $product_id;?>" style="width: 250px; height: 200px; float: left; margin: 20px;"><?php echo $fulladdress;?></div>
				<?php } ?>
                 
                </div>
                <div class="iconic_wrapper">
				
				<?php
					//echo $i; 
				if(count($attribute)>0){ 
				foreach($attribute as $atRows){
					if($atRows->values!=''){
				?>
				<div class="pro_icon"><img src="/public/uploads/attribute/<?php echo $atRows->icon ?>"> <?php echo $atRows->values; ?> </div>
				<?php } } } ?> 
                </div>
                <div class="container">
              <div class="left-section">
                    <div class="heading1"><a href="/property/detail/<?php echo $product_id; ?>">
					<?php echo ucfirst(substr($propertyName,0,40)); ?>
					
					<a/></div>
                   <div class="property-detail">
                    <div class="block reserve"><span>Reserved Price:</span> <?php echo $reserve_price; ?></div>
                      <div class="block"><span>Property Type:</span> 
					  <?php
						if($product_subtype_val!=0){	
							echo ucfirst($product_subtype_val);
						}else{
							echo ucfirst($product_type);	
						}
					  ?>
					
					  </div>
                      <div class="block"><span>Location:</span> <?php echo $city; ?></div>
                     <div class="socialicon">
					 <?php 
						echo $this->property_model->socialmediaIcon($product_id);
					  ?>  
                        </div> 
                    </div>
                    <span id="favmsg<?php echo $product_id; ?>"></span>     
                  </div>
                  <div class="right-section">
                  <div class="row">
              
                    </div>
                    <!--<input name="search" type="button" value="BID NOW" class="b_get">-->
                    <div class="bt-links">
                    <a href="/property/detail/<?php echo $product_id; ?>" class="more">View more</a>
                    </div>
                  </div>
                </div>
              </div>
            </li>
		<?php }else{ ?>
		
		    <li>
              <div class="auction_prowidget">
                <div class="image-wrapper">
				<?php if($imagename!=''){ ?>
				<img src="<?php echo $imagepath; ?>">  
				<?php }else{ ?>
				<div class="add" id="add_<?php echo $product_id;?>" style="width: 250px; height: 200px; float: left; margin: 20px;"><?php echo $fulladdress;?></div>
				<?php } ?>
				<!--<div class="socialicon">
                                   
<a class="a2a_dd" href="http://www.addtoany.com/share_save"><img src="/images/icon-share.png"></a>
 
                   
                   </div> -->
                </div>
                   <div class="iconic_wrapper">
				<?php if(count($attribute)>0){ 
				foreach($attribute as $atRows){
					if($atRows->values!=''){
				?>
				<div class="pro_icon"><img src="/public/uploads/attribute/<?php echo $atRows->icon ?>"> <?php echo $atRows->values; ?> </div>
				<?php } } } ?>
				</div>
                <div class="container">
                  <div class="left-section">
                    <div class="heading1"><a href="/property/detail/<?php echo $product_id; ?>">
					<?php echo ucfirst(substr($propertyName,0,40)); ?></a></div>
                   <div class="property-detail">
                    <div class="block reserve"><span>Reserved Price:</span> <?php echo $reserve_price; ?></div>
                      <div class="block"><span>Property Type:</span> 
					   <?php
						if($product_subtype_val!=0){	
							echo ucfirst($product_subtype_val);
						}else{
							echo ucfirst($product_type);	
						}
					  ?>
					  </div>
                      <div class="block"><span>Location:</span> <?php echo $city; ?></div>
					  <?php if($bidlastdate){?>
                      <div class="block"><span>Bid Submission Date:</span> <?php echo $bidlastdate;?></div> 
					  <?php } ?>
                       <div class="socialicon">
					 <?php 
						echo $this->property_model->socialmediaIcon($product_id);
					  ?>  
                        </div> 
                    </div>
                    <span id="favmsg<?php echo $product_id; ?>"></span>    
                  </div>
                  <div class="right-section">
         
                    <!--<input name="search" type="button" value="BID NOW" class="b_get">-->
                    <div class="bt-links">
                    
                    <a href="/property/detail/<?php echo $product_id; ?>" class="more">View more</a>
                    </div>
                  </div>
                </div>
      
              </div>
            </li>
		
		
		
		<?php } ?>
				  
		  
		<?php $i++; } ?>
		<div class="pagination2 float-right">  <?php echo $pagination_links;?> </div>
		<?php }else{ ?>
				<strong>Records Not Found.</strong>
		<?php } ?>
	
	
		 <?php }else{
			if($AuctionRecordsList!=0){
			$i=1;
			?>
		   <ul> 
		   <?php foreach($AuctionRecordsList as $auctionData){
					$imagename=$auctionData->image[0]->name;
					$propertyName=$auctionData->product_detail->name;
					$product_type=$auctionData->product_detail->product_type;
					$city=$auctionData->product_detail->city;
					$city	=	GetTitleByField('tbl_city', "id='".$city."'", 'city_name');
					$product_type	=	GetTitleByField('tbl_category', "id='".$product_type."'", 'name');
					$reserve_price=$auctionData->reserve_price;
					$bid_last_date=$auctionData->bid_last_date;
					$product_subtype_val=$auctionData->product_detail->product_subtype_val;
					$attribute=$auctionData->attribute;
					$bank_id=$auctionData->bank_id;
					$product_id=$auctionData->product_detail->id;
					$room=$this->property_model->getattributeValuedata("attribute_id='17' AND product_id='$product_id'");
					$bathroom=$this->property_model->getattributeValuedata("attribute_id='31' AND product_id='$product_id'");
					$area=$this->property_model->getattributeValuedata("attribute_id='3' AND product_id='$product_id'");
					//$bidlastdate=date("d/M/Y H:i:s A",strtotime($bid_last_date));
					$bidlastdate=date("d/M/Y",strtotime($bid_last_date));
					$imagepath='/public/uploads/property_images/'.$imagename;	
					$strbidlastdate=strtotime($bid_last_date);
					$currentime=time(); 
					
					$address1=$auctionData->product_detail->address1;
					$street=$auctionData->product_detail->street;
					$country=$auctionData->product_detail->country;
					$state	=	GetTitleByField('tbl_state', "id='".$state."'", 'state_name');
					$country=	GetTitleByField('tbl_country', "id='".$country."'", 'country_name');
					$fulladdress= $address1.', '.$street.', '.$city.', '.$country;
						
		   ?>

		   
		   <?php if($viewType=='grid' && $product_id>0) { ?>
		              <li class="detail-full" >
              <div class="auction_prowidget">
                <div class="image-wrapper">
				<?php if($imagename!=''){ ?>
				<img src="<?php echo $imagepath; ?>">  
				<?php }else{ ?>
				<div class="add" id="add_<?php echo $product_id;?>" style="width: 250px; height: 200px; float: left; margin: 20px;"><?php echo $fulladdress;?></div>
				<?php } ?>
				<!--
                   <div class="socialicon">
                      <a class="a2a_dd" href="http://www.addtoany.com/share_save"><img src="/images/icon-share.png"></a>
                   </div> -->
                </div>
                <div class="iconic_wrapper">
				<?php if(count($attribute)>0){ 
				foreach($attribute as $atRows){
					if($atRows->values!=''){
				?>
				<div class="pro_icon"><img src="/public/uploads/attribute/<?php echo $atRows->icon ?>"> <?php echo $atRows->values; ?> </div>
				<?php } } } ?>
				</div>
                <div class="container">
              <div class="left-section">
                    <div class="heading1"><a href="/property/detail/<?php echo $product_id; ?>">
					<?php echo ucfirst(substr($propertyName,0,40)); ?></a></div>
                   <div class="property-detail">
                    <div class="block reserve"><span>Reserved Price:</span> <?php echo $reserve_price; ?></div>
                      <div class="block"><span>Property Type:</span> 
					    <?php
						if($product_subtype_val!=0){	
							echo ucfirst($product_subtype_val);
						}else{
							echo ucfirst($product_type);	
						}
					  ?>
					  </div>
                      <div class="block"><span>Location:</span> <?php echo $city; ?></div>
                      <div class="block"><span>Bid Submission Date:</span> <?php echo $bidlastdate;?></div> 
                 <div class="socialicon">
					 <?php 
						echo $this->property_model->socialmediaIcon($product_id);
					  ?>  
                        </div> 
                    </div>
                    <span id="favmsg<?php echo $product_id; ?>"></span>    
                  </div>
                  <div class="right-section">
                  <div class="row">
                   
                   <?php
			   if($bank_id){ $banklogo=GetTitleByField('tbl_bank', 'id='.$bank_id, 'logopath'); 
			   ?>
                <div class="bank-icons"><a href="/property?bankname[]=<?php echo $bank_id;?>"><img src="<?php echo $banklogo; ?>" width="150" height="105"></div>
				 <?php } ?>
                    </div>
                    <!--<input name="search" type="button" value="BID NOW" class="b_get">-->
                    <div class="bt-links">
                    <a href="/property/detail/<?php echo $product_id; ?>" class="more">View more</a>
                    </div>
                  </div>
                </div>
				
				 <div class="overlay" style="display:none;">
                <div class="content">
                <p class="text-center">Time Remaining:</p>
				<div class="time">
				<div data-countdown="<?php echo $bid_last_date;?>"></div></div>
               <?php
							
							$bid_last_dt=strtotime($bid_last_date);
							$currenttime=strtotime(date('Y-m-d H:i:s'));
							$currenttime	= (int)$currenttime;
							$bid_last_dt	= (int)$bid_last_dt;
							if($bid_last_dt >= $currenttime){
				?>		
							<a href="/property/detail/<?php echo $product_id; ?>">
								<input name="search" type="button" value="Bid" class="b_bidnow">
							</a>
							<?php }else{ ?>
							<a href="/property/detail/<?php echo $product_id; ?>">
								<input name="search" type="button" value="Live" class="b_bidnow">
							</a>
							
							<?php } ?>
                </div>              
                </div>
				
              </div>
            </li>
			
		   <?php } else{ ?>
            <li>
              <div class="auction_prowidget">
                <div class="image-wrapper">
				<?php if($imagename!=''){ ?>
				<img src="<?php echo $imagepath; ?>">  
				<?php }else{ ?>
				<div class="add" id="add_<?php echo $product_id;?>" style="width: 250px; height: 200px; float: left; margin: 20px;"><?php echo $fulladdress;?></div>
				<?php } ?>
				<!--
                   <div class="socialicon">
                      <a class="a2a_dd" href="http://www.addtoany.com/share_save"><img src="/images/icon-share.png"></a>
                   </div> -->
                </div>
                   <div class="iconic_wrapper">
				<?php if(count($attribute)>0){ 
				foreach($attribute as $atRows){
					if($atRows->values!=''){
				?>
				<div class="pro_icon"><img src="/public/uploads/attribute/<?php echo $atRows->icon ?>"> <?php echo $atRows->values; ?> </div>
				<?php } } } ?>
				</div>
                <div class="container">
                  <div class="left-section">
                    <div class="heading1"><a href="/property/detail/<?php echo $product_id; ?>">
					<?php echo ucfirst(substr($propertyName,0,40)); ?></a></div>
                   <div class="property-detail">
                    <div class="block reserve"><span>Reserved Price:</span> <?php echo $reserve_price; ?></div>
                      <div class="block"><span>Property Type:</span> 
					   <?php
						if($product_subtype_val!=0){	
							echo ucfirst($product_subtype_val);
						}else{
							echo ucfirst($product_type);	
						}
					  ?>
					  
					  </div>
                      <div class="block"><span>Location:</span> <?php echo $city; ?></div>
                      <div class="block"><span>Bid Submission Date:</span> <?php echo $bidlastdate;?></div> 
                      <div class="socialicon">
					 <?php 
						echo $this->property_model->socialmediaIcon($product_id);
					  ?>  
                        </div>
                    </div>
                    <span id="favmsg<?php echo $product_id; ?>"></span>   
                  </div>
                  <div class="right-section">
                  <div class="row">
			   <?php
			   if($bank_id){
			   $banklogo=GetTitleByField('tbl_bank', 'id='.$bank_id, 'logopath'); 
			   ?>
                <div class="bank-icons">
				<a href="/property?bankname[]=<?php echo $bank_id;?>"><img src="<?php echo $banklogo; ?>" width="150" height="105">
				
				</div>
				 <?php } ?>
                    </div>
                    <!--<input name="search" type="button" value="BID NOW" class="b_get">-->
                    <div class="bt-links">
                    
                    <a href="/property/detail/<?php echo $product_id; ?>" class="more">View more</a>
                    </div>
                  </div>
                </div>
                <div class="overlay" style="display:none;">
                <div class="content">
                <p class="text-center">Time Remaining:</p>
				<div class="time">
				<div data-countdown="<?php echo $bid_last_date;?>"></div></div>
				<?php
							
							$bid_last_dt=strtotime($bid_last_date);
							$currenttime=strtotime(date('Y-m-d H:i:s'));
							$currenttime	= (int)$currenttime;
							$bid_last_dt	= (int)$bid_last_dt;
							if($bid_last_dt >= $currenttime){
				?>		
							<a href="/property/detail/<?php echo $product_id; ?>">
								<input name="search" type="button" value="Bid" class="b_bidnow">
							</a>
							<?php }else{ ?>
							<a href="/property/detail/<?php echo $product_id; ?>">
								<input name="search" type="button" value="Live" class="b_bidnow">
							</a>
							
							<?php } ?>
                </div>
                </div>
              </div>
            </li>
		   <?php } ?>
		  
			
            
		<?php } ?>
				
 
          </ul>
		 <div class="pagination2 float-right">  <?php echo $pagination_links;?> </div>
	<?php } else{ ?>
				<strong>Records Not Found.</strong>
		<?php } } ?>
          
        </div>
          <div id="multipleAddressMap">
              <?php 
              
              if($AuctionRecordsList!=0){
                  
                  if ($act == 'non_auction') {
                      foreach ($AuctionRecordsList as $mapData) {
                          $address1 = $mapData->address1;
                          $city = $mapData->city;
                          $city = GetTitleByField('tbl_city', "id='" . $city . "'", 'city_name');
                          $state = $mapData->state;
                          $state = GetTitleByField('tbl_state', "id='" . $state . "'", 'state_name');
                          $propertyName=$mapData->name;
                          
                          $mapaddress = $address1 . " " . $city;
                          $lat_long_address = $address1 . " " . $city . " " . $state;
                          //find latitude and longitude
                          $latlongddress = str_replace(" ", "+", $lat_long_address);
                          $request_url = "http://maps.googleapis.com/maps/api/geocode/xml?address=" . $latlongddress . "&sensor=true";
                          $xml = simplexml_load_file($request_url) or die("url not loading");
                          $status = $xml->status;
                          if ($status == "OK") {
                              $Lat = $xml->result->geometry->location->lat;
                              $Lon = $xml->result->geometry->location->lng;
                              $LatLng[] = "$propertyName,$mapaddress,$Lat,$Lon";
                          }
                          //find latitude and longitude
                      }
                  }else{
                      foreach ($AuctionRecordsList as $mapData) {
                        $address1=$mapData->product_detail->address1;
                        $city = $auctionData->product_detail->city;
			$city =	GetTitleByField('tbl_city', "id='".$city."'", 'city_name');
                        $state= $mapData->product_detail->state;
                        $state = GetTitleByField('tbl_state', "id='".$state."'", 'state_name');
                        $propertyName=$mapData->product_detail->name;
                        
                          $mapaddress = $address1 . " " . $city;
                          $lat_long_address = $address1 . " " . $city . " " . $state;
                          //find latitude and longitude
                          $latlongddress = str_replace(" ", "+", $lat_long_address);
                          $request_url = "http://maps.googleapis.com/maps/api/geocode/xml?address=" . $latlongddress . "&sensor=true";
                          $xml = simplexml_load_file($request_url) or die("url not loading");
                          $status = $xml->status;
                          if ($status == "OK") {
                              $Lat = $xml->result->geometry->location->lat;
                              $Lon = $xml->result->geometry->location->lng;
                              $LatLng[] = "$propertyName,$mapaddress,$Lat,$Lon";
                          }
                          //find latitude and longitude
                      }
                  }

                  for($i=0;$i<count($LatLng);$i++){
                  $arr[] = explode(",", $LatLng[$i]);
                
              }
              $json_encode = json_encode($arr);
             
              ?>
              <style>
			  
			   #map {
						 width:95%; height:85%; 
					}
			  <!--
                  #map {
                    width:760px; height:700px; 
                }-->
              </style>
             <div id="map"/>
             <script>
		var map;
		var locations = <?php echo $json_encode ?>;

		gmarkers = [];
     map = new google.maps.Map(document.getElementById('map'), {
        zoom: 5,
        center: new google.maps.LatLng(36.70406,65.10249),
        mapTypeId: google.maps.MapTypeId.ROADMAP
    });
       
    var infowindow = new google.maps.InfoWindow();
    function createMarker(latlng, html) {
        var marker = new google.maps.Marker({
            position: latlng,
            map: map
        });

        google.maps.event.addListener(marker, 'click', function() {
            infowindow.setContent(html);
            infowindow.open(map, marker);
        });
        return marker;
    }

    for (var i = 0; i < locations.length; i++) {
        gmarkers[locations[i][0]] =
        createMarker(new google.maps.LatLng(locations[i][2], locations[i][3]), locations[i][0] + "<br>" + locations[i][1]);
    }
                 
                 </script>
           <div class="pagination2 float-right">  <?php echo $pagination_links;?> </div>
              <?php } else  { echo "No Map View Available"; } ?>

          </div>
      </div>
    </div>
	</form>
  </div>
</section>
<script>
    function showMap(){
        $(".pro-right-wrapper").hide();

        $("#multipleAddressMap").show();
        google.maps.event.trigger(map, "resize");
    }
    $(document).ready(function () {
       $("#multipleAddressMap").hide();
    });
</script>
 
<script type="text/javascript" src="//static.addtoany.com/menu/page.js"></script>
  <script>
        a2a_config.orientation = "up";
  </script>

<script>
$('[data-countdown]').each(function() {
var $this = $(this), finalDate = $(this).data('countdown');
   $this.countdown(finalDate, function(event) {
     $this.html(event.strftime('%D:%H:%M:%S'));
   });
 });

</script>
<script>
    
function findmapbyaddress(address, divID)
{
var geocoder = new google.maps.Geocoder();
geocoder.geocode({ 'address': address }, function (results, status) {
    if (status == google.maps.GeocoderStatus.OK) {
        var map = new google.maps.Map($("#"+divID));
        map.setCenter(results[0].geometry.location);
        var marker = new google.maps.Marker({
            map: map,
            position: results[0].geometry.location
        });
    } else {
        //alert("Geocode was not successful for the following reason: " + status);
    }
});
    
}
</script>



<script>
    
    $(document).ready(function(){
	$('.add').each(function(){
	    var attrId = $(this).attr('id');
	    var attrAddress = $(this).text();
	    
	    var geocoder = new google.maps.Geocoder();
	    geocoder.geocode({ 'address': attrAddress }, function (results, status) {
		if (status == google.maps.GeocoderStatus.OK) {
		    var mapOptions = { zoom: 6, mapTypeId: google.maps.MapTypeId.ROADMAP };
		    var map = new google.maps.Map(document.getElementById(attrId), mapOptions);
		    map.setCenter(results[0].geometry.location);
		    var marker = new google.maps.Marker({
			map: map,
			position: results[0].geometry.location
		    });
		} else {
		    //alert("Geocode was not successful for the following reason: " + status);
		}
	    });
	    //console.log($(this).attr('id')+' '+$(this).text());
	})
    })
    
</script>
