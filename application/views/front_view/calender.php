<?php
$start_date=$_GET['start_date'];
$end_date=$_GET['end_date'];
?>
<script type="text/javascript" src="<?php echo base_url(); ?>js/jsDatePick.jquery.min.1.3.js"></script>
<link rel="stylesheet" type="text/css" media="all" href="<?php echo base_url(); ?>/css/jsDatePick_ltr.min.css" />
<section>
<div class="breadcrum">
  <div class="wrapper"> <a href="<?php echo base_url();?>/" class="Home">Home</a>&nbsp;»&nbsp;<span>Auction Calendar</span> </div>
</div>
<div class="wrapper">
<h1 class="heading1 heading_bor btmrg20 float-left">Auction Calendar</h1>
<div class="auc-caln_wrapper">
<form name="property_serch" id="property_serch" method="get" action="/auction_calender">
<div class="row btmrg tpmrg">
<div class="float-right"> Search : <input onkeyup="searchCalenderData(this.value);" type="text" name="searchcalender" id="searchcalender"> </div>
<div class="cal-sorting float-left">
     
            <div class="row">
              <input class="hasDatepicker" type="text" value="<?php echo $start_date;?>" placeholder="From Date" name="start_date" id="start_date">
              </div>
            
            <div class="row">
              <input type="text" class="hasDatepicker" value="<?php echo $end_date;?>" placeholder="To Date" name="end_date" id="end_date">
              </div>
 </div>         
 </div>
</form>	  
  <div class="table-section">
  <div id="search-data"></div>
    <table width="100%" border="0" cellspacing="0" cellpadding="0" class="defaultTable">
      <thead>
        <tr>
          <th scope="col" width="10%"> <span class="icon_date-calendar">Date</span></th>
		  <th scope="col" width="15%"><span class="icon_auctionid">Auction ID</span></th>
          <th scope="col" width="25%"><span class="icon_events">Asset on Auction</span></th>
		  <th scope="col" width="10%"><span class="icon_city">City</span></th>
          <th scope="col" width="10%"><span class="icon_bank">Bank</span></th>
          <th scope="col" width="15%"><span class="icon_money">Price</span></th>
          <th scope="col" width="15%"><span class="icon_property-type">Type</span></th>
        </tr>
      </thead>
      <tbody id="tabledata">
	  <?php
	  
	  if($auctionData!=0)
	  {
	  foreach($auctionData as $rows){
		  $bid_last_date	=	$rows->bid_last_date;
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
          <td align="left" valign="top"><div class="icon-date"><span><?php echo date("d M Y H:i:s",strtotime($bid_last_date))?></span>
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
        
      </tbody>
    </table>
	
	<?php
	if($start_date!='' && $end_date!=''){
	?>
	<div style="float:right;"><a href="<?php echo base_url()?>auction-calender">BACK</a></div>
	<?php } ?>
  </div>
  
  
  
</div>
</div>
</section>

<script type="text/javascript">
			window.onload = function(){
				new JsDatePick({
					useMode:2,
					target:"start_date",
					dateFormat:"%d-%m-%Y"
				});
				
				g_globalObject = new JsDatePick({
					useMode:2,
					target:"end_date",
					dateFormat:"%d-%m-%Y"
					//limitToToday:true
				});
				
				
				g_globalObject.setOnSelectedDelegate(function(){
					var obj = g_globalObject.getSelectedDay();
					//alert("a date was just selected and the date is : " + obj.day + "/" + obj.month + "/" + obj.year);
					document.getElementById("end_date").value = obj.day + "-" + obj.month + "-" + obj.year;
					processform();
				});
			};
		</script>