<!DOCTYPE HTML>
<html style="overflow: hidden;">
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

<section>
  <div class="row">
    <div class="wrapper-full">
      <div class="dashboard-wrapper">
        
        <div class="container">
          
          <div class="secttion-right" style="width:100%;max-height: 429px;overflow: auto;">
		  <form name="submitEmd" id="submitEmd" action="/helpdesk_executive/SaveAuctionEmd" method="post" enctype="multipart/form-data">
            <div class="form" style="text-align:center;">
			<div class="heading4 btmrg20"> Auction Manual Bid History </div>
			<div class="seprator btmrg20"></div>
			<table width="100%" border="0px&quot;">
				<tbody>
					<tr class="bg-blue-th">
						<th width="50px" align="left" class="BidHistory-Header">SNo.</th>
						<!--<th width="150px" align="left" class="BidHistory-Header">Alias Name</th>-->
						<th align="left" class="BidHistory-Header">Bid Value</th>
						<!--<th align="left" class="BidHistory-Header">Creation date</th>-->
                                                <th align="left" class="BidHistory-Header">Bid Date & Time</th>
					</tr>
					
					<?php if($auctionManualBiddingData != 0)
					{ 
						$i=1;
						foreach ($auctionManualBiddingData as $bdata)
						{
					?>
					<tr class="">
						<td align="left"><?php echo $i; ?></td>
						<!--<td align="left"><?php //echo $bdata->alias_name; ?></td>-->
						<td align="left"><?php echo $bdata->bid_value; ?></td>
						<td align="left"><?php echo date('d-m-Y H:i:s',strtotime($bdata->indate)); ?></td>
					</tr>
					<?php 
						$i++;
						}
					}else{ ?>
					<tr>
						<td colspan="4">No Bidding History Found</td>
						
					</tr>
					
					<?php } ?>
					
				</tbody>
			</table>
             <div class="seprator btmrg20"></div>
          
            </div>
			<div class="form" style="text-align:center;">
			<div class="heading4 btmrg20"> Auction Auto Bid History </div>
			<div class="seprator btmrg20"></div>
			<table width="100%" border="0px&quot;">
				<tbody>
					<tr class="bg-blue-th">
						<th width="50px" align="left" class="BidHistory-Header">SNo.</th>
						<!--<th width="150px" align="left" class="BidHistory-Header">Alias Name</th>-->
						<th align="left" class="BidHistory-Header">Auto Bid Value</th>
						<!--<th align="left" class="BidHistory-Header">Creation date</th>-->
                                                <th align="left" class="BidHistory-Header">Bid Date & Time</th>
					</tr>
					
					<?php if($auctionAutoBiddingData != 0)
					{ 
						$i=1;
						foreach ($auctionAutoBiddingData as $bdata)
						{
					?>
					<tr class="">
						<td align="left"><?php echo $i; ?></td>
						<!--<td align="left"><?php //echo $bdata->alias_name; ?></td>-->
						<td align="left"><?php echo $bdata->auto_bid; ?></td>
						<td align="left"><?php echo date('d-m-Y H:i:s',strtotime($bdata->indate)); ?></td>
					</tr>
					<?php 
						$i++;
						}
					}else{ ?>
					<tr>
						<td colspan="4">No Bidding History Found</td>
						
					</tr>
					
					<?php } ?>
					
				</tbody>
			</table>
             <div class="seprator btmrg20"></div>
          
            </div>
			</form>
          </div>
        </div>
        
      </div>
    </div>
  </div>
</section>

</body>

</html>
