
	  <?php
	  
	  if($auctionData!=0)
	  {
	  foreach($auctionData as $rows){
		  $auction_start_date	=	$rows->auction_start_date;
		  $auction_end_date		=	$rows->auction_end_date;
		  $reference_no			=	$rows->reference_no;
		  $event_desc			=	$rows->product_description;
		  $reserve_price		=	$rows->reserve_price;
		  $category				=	$rows->product_type_val;
		  $productID			=	$rows->productID;
		  $auctionID			=	$rows->id;
		  $city_name			=	$rows->city_name;
		  $bank_name			=	$rows->bank_name;
		  $currentTimeStr		=	time();
		  $auction_startStr		=	strtotime($auction_end_date);
		  if($currentTimeStr>=$auction_startStr){
			  $autTitle="Live";
		  }else{
			  $autTitle="Upcoming";
		  }
	  ?>
        <tr>
          <td align="left" valign="top"><div class="icon-date"><span><?php echo date("d M",strtotime($auction_start_date))?> - <?php echo date("d M", strtotime($auction_end_date))?> <strong><?php echo date("Y", strtotime($auction_end_date))?></strong></span>
              <div class="live"><?php echo $autTitle; ?></div>
            </div>
		</td>
		
		 <td align="left" valign="top">
			<a href="property/detail/<?php echo $productID; ?>"><?php echo $auctionID ?> </a>
		  </td>
          <td align="left" valign="top">
			<div class="event-txt"><a href="property/detail/<?php echo $productID; ?>"><?php echo ucfirst($reference_no);?>, <?php echo ucfirst($event_desc); ?> </a>
		  </td>
		  <td><?php echo $city_name;?></td>
		  <td><?php echo $bank_name;?></td>
          <td align="left" valign="top"><div class="price-txt"><span class="WebRupee">Rs</span>		<?php echo number_format($reserve_price)?></div>
		  </td>
          <td align="left" valign="top">
			<div class="property-txt"><span class="icon-flat"></span><?php echo $category; ?></div>
		  </td>
        </tr>
	  <?php } }else{?>
		  <td colspan="7">
		  Auction Not Found.!
		  </td>
		  
	 <?php } ?>	
