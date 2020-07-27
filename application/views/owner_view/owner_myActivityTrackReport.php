<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<title>bankEauction</title>
<meta name="description" content="bankEauction" />
<meta name="keywords" content="bankEauction" />
<!-- Mobile Specific Metas -->
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<link rel="stylesheet" href="<?php echo base_url()?>/css/bace.css">
<link rel="stylesheet" href="<?php echo base_url()?>/css/admin-style.css">
<link rel="stylesheet" href="<?php echo base_url()?>/css/nav.css">
<link rel="stylesheet" href="<?php echo base_url()?>/css/banner.css">
<script src="<?php echo base_url()?>/js/jquery.min.js"></script>
<link rel="stylesheet" href="<?php echo base_url()?>js/calender/jquery-ui.css">
<script src="<?php echo base_url(); ?>js/calender/jquery-ui.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>js/calender/jquery-ui-timepicker-addon.min.js"></script>
<link rel="stylesheet" href="<?php echo base_url()?>js/calender/jquery-ui-timepicker-addon.css">
<script type="text/javascript" src="<?php echo base_url(); ?>js/calender/i18n/jquery-ui-timepicker-addon-i18n.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/calender/jquery-ui-sliderAccess.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>/application/views/admin/js/plugins/jquery.validate.min.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>/js/common.js"></script>
<!--[if IE]>
<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->
<!--[if IE]>
<script type="text/javascript" src="/js/respond.js"></script>
<![endif]-->
</head>
<body>
	<section class="container_12">
		<div class="row">
		  <div class="table-wrapper btmrg20">
			<div class="table-heading btmrg">
			  <div class="heading4">Auction Summary</div>
			</div>
			<div class="table-section">
				<table border="0" align="left" cellpadding="0" cellspacing="0" class="mytable dataTable" id="big_table" aria-describedby="big_table_info">
					<tbody role="alert" aria-live="polite" aria-relevant="all">
						<tr class="odd">
						  <td width="20%" align="left" valign="top" class=""><strong>Auction Name  : </strong></td>
						  <td width="30%" align="left" valign="top" class=""><?php echo $auction_data[0]->event_title?></td>
						  
						  <td width="20%" align="left" valign="top" class=""><strong> 	Auction Type  :  </strong></td>
						  <td width="30%" align="left" valign="top" class=""><?php echo strtoupper($auction_data[0]->event_type)?></td>
						</tr>
						<tr class="even">
						  <td width="20%" align="left" valign="top" class=""><strong>Auction Start Time  :   </strong></td>
						  <td width="30%" align="left" valign="top" class=""><?php echo $auction_data[0]->auction_start_date?></td>
						  
						  <td width="20%" align="left" valign="top" class=""><strong>Auction End Time  :  </strong></td>
						  <td width="30%" align="left" valign="top" class=""><?php echo $auction_data[0]->auction_end_date?></td>
						  
						</tr>
						<tr class="even">
						  <td width="20%" align="left" valign="top" class=""><strong>View Related Document  :  </strong></td>
						  <td width="30%" align="left" valign="top" class=""><a href="/public/uploads/event_auction/<?php echo $auction_data[0]->related_doc?>" target="_blank">Download</a></td>
						  <td width="20%" align="left" valign="top" class=""><strong>1st Opener  : </strong></td>
						  
						  <td width="30%" align="left" valign="top" class=""><?php 
						  if($auction_data[0]->first_opener)
						  echo GetTitleByField('tbl_user_registration','id='.$auction_data[0]->first_opener,'first_name').' '.GetTitleByField('tbl_user_registration','id='.$auction_data[0]->first_opener,'last_name');
						  ?>
						  </td>
						</tr>
						<tr class="even">
						  
						  <td width="20%" align="left" valign="top" class=""><strong>2nd Opener  : </strong></td>
						  <td width="30%" align="left" valign="top" class=""><?php

						  echo ($auction_data[0]->second_opener)?GetTitleByField('tbl_user','id='.$auction_data[0]->second_opener,'first_name'):'N.A'?></td>
						  <td width="20%" align="left" valign="top" class=""><strong></strong></td>
						  <td width="30%" align="left" valign="top" class=""></td>
						  
						</tr>
					</tbody>

				 </table>
				
			</div>
		  </div>
		  <div class="table-wrapper btmrg20">
			<div class="table-heading btmrg">
			  <div class="heading4">Bidder Participated </div>
			</div>
			<div class="table-section"> 
				<table border="1" align="left" cellpadding="2" cellspacing="1" class="mytable dataTable" id="big_table" aria-describedby="big_table_info">
					<tbody role="alert" aria-live="polite" aria-relevant="all">
						<tr class="odd">
						  <td width="25%" align="left" valign="top" class=""><strong>Bidder Name </strong></td>
						  <td width="25%" align="left" valign="top" class=""><strong>FRQ Participated  </strong></td>
						  <td width="25%" align="left" valign="top" class=""><strong>Auction Training Received </strong></td>
						  <td width="25%" align="left" valign="top" class=""><strong>Auction Participated</strong></td>
						  
						</tr>
						<?php 
						
						//echo '<pre>';print_r($auction_data[0]->bidder);
						
						foreach($auction_data[0]->bidder as $frq_detail){?>
						<tr class="even">
						  <td width="25%" align="left" valign="top" class=""><?php 
						  if($frq_detail->bidderID)
						  echo GetTitleById('tbl_user_registration',$frq_detail->bidderID,'first_name');?></td>
						  <td width="25%" align="left" valign="top" class=""><?php echo ($frq_detail->frq==1)?'Yes':'No'?></td>
						  <td width="25%" align="left" valign="top" class=""><?php echo ($frq_detail->is_accept_auct_training==1)?'Yes':'No'?></td>
						  <td width="25%" align="left" valign="top" class="">Yes</td>
						  
						</tr>
						<?php }?>
					</tbody>

				 </table>
			
			</div>
		  </div>
		  <div class="table-wrapper btmrg20">
			<div class="table-heading btmrg">
			  <div class="heading4">FRQ Details </div>
			</div>
			<div class="table-section"> 
				
				<table border="1" align="left" cellpadding="2" cellspacing="1" class="mytable dataTable" id="big_table" aria-describedby="big_table_info">
					<tbody role="alert" aria-live="polite" aria-relevant="all">
						<tr class="odd">
						  <td width="25%" align="left" valign="top" class=""><strong>Bidder Name </strong></td>
						  <td width="25%" align="left" valign="top" class=""><strong>Bid Value</strong></td>
						  <td width="25%" align="left" valign="top" class=""><strong>Bid Date </strong></td>
						  
						  
						  
						</tr>
						<?php foreach($auction_data[0]->bidder as $frq_detail){?>
						<tr class="even">
						  <td width="25%" align="left" valign="top" class=""><?php 
						  if($frq_detail->bidderID)
						  echo GetTitleById('tbl_user_registration',$frq_detail->bidderID,'first_name')?></td>
						  <td width="25%" align="left" valign="top" class=""><?php echo $frq_detail->row_bidder_frq->frq?></td>
						  <td width="25%" align="left" valign="top" class=""><?php echo $frq_detail->row_bidder_frq->indate?></td>
				
						  
						</tr>
						<?php }?>
					</tbody>

				 </table>
			</div>
		  </div>
		  <?php if(count($auction_data[0]->bidder_bid)){?>
		  <div class="table-wrapper btmrg20">
			<div class="table-heading btmrg">
			  <div class="heading4">Auction Last Bid Details </div>
			</div>
			<div class="table-section"> 
				<table border="1" align="left" cellpadding="2" cellspacing="1" class="mytable dataTable" id="big_table" aria-describedby="big_table_info">
					<tbody role="alert" aria-live="polite" aria-relevant="all">
						<tr class="odd">
						  <td width="33%" align="left" valign="top" class=""><strong>Bidder Name</strong></td>
						  <td width="33%" align="left" valign="top" class=""><strong>Bid Value</strong></td>
						  <td width="33%" align="left" valign="top" class=""><strong>Bid Date</strong></td>
						</tr>
						<?php 
						
						//echo '<pre>';print_r($auction_data[0]->bidder_bid);
						
						
						
						foreach($auction_data[0]->bidder_bid as $key=>$bid_detail){if($key ==2)break;?>
						<tr class="even">
						  <td width="33%" align="left" valign="top" class=""><?php
						  if($bid_detail->bidderID)
						  echo  GetTitleByField('tbl_user_registration','id='.$bid_detail->bidderID,'first_name')?></td>
						  <td width="33%" align="left" valign="top" class=""><?php echo $bid_detail->bid_value?></td>
						  <td width="33%" align="left" valign="top" class=""><?php echo $bid_detail->indate?></td>
					  </tr>
						<?php }?>
					</tbody>             
				 </table>					
			</div>
		  </div>
		  <div class="table-wrapper btmrg20">
			<div class="table-heading btmrg">
			  <div class="heading4">Auction All Bid Received </div>
			</div>
			<div class="table-section"> 
				<table border="1" align="left" cellpadding="2" cellspacing="1" class="mytable dataTable" id="big_table" aria-describedby="big_table_info">
					<tbody role="alert" aria-live="polite" aria-relevant="all">
						<tr class="odd">
						  <td width="25%" align="left" valign="top" class=""><strong>Bidder Name </strong></td>
						  <td width="25%" align="left" valign="top" class=""><strong>Bid Value </strong></td>
						  <td width="25%" align="left" valign="top" class=""><strong>Rank </strong></td>
						  <td width="25%" align="left" valign="top" class=""><strong>Bid Date </strong></td>
						  
						</tr>
						<?php foreach($auction_data[0]->bidder_bid as $key=>$bid_detail){
					$rankID = array_search($bid_detail->bidderID, $BidderRankData); // $key = 2;
					$rank="H".$rankID;
							?>
						<tr class="even">
						  <td width="25%" align="left" valign="top" class=""><?php 
						  if($bid_detail->bidderID)
						  echo GetTitleByField('tbl_user_registration','id='.$bid_detail->bidderID,'first_name')?></td>
						  <td width="25%" align="left" valign="top" class=""><?php echo $bid_detail->bid_value?></td>
						  <td width="25%" align="left" valign="top" class=""><?php echo $rank?></td>
						  <td width="25%" align="left" valign="top" class=""><?php echo $bid_detail->indate?></td>						</tr>
						<?php }?>
					</tbody>             
				 </table>
			</div>
		  </div>
		  <?php }?>
		  <div class="table-wrapper btmrg20">                    
			<div class="table-section"> 						
				 <table border="1" align="left" cellpadding="2" cellspacing="1" class="mytable dataTable" id="big_table" aria-describedby="big_table_info">
					<tbody role="alert" aria-live="polite" aria-relevant="all">
						<tr class="odd">
						  <td width="25%" align="left" valign="top" class="" colspan="4">
						  <a target="_blank" href="/pdfdata/genetepdf/<?php echo $auctionID;?>"><input class="b_submit float-left" type="button" value="Export To PDF" />
						  </td>								  
						</tr>
					</tbody>             
				 </table>
			</div>
		  </div>
		</div>
	</section>
</body>
</html>
