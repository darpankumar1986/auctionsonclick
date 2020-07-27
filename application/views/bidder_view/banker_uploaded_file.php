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
<?php
 //echo "<pre>";
 //print_r($auctionData);
 //echo "</pre>";
 ?>
<section>
  <div class="row">
    <div class="wrapper-full">
      <div class="dashboard-wrapper">
        
        <div class="container">
          
          <div class="secttion-right" style="width:100%;">
		  <form name="submitEmd" id="submitEmd" action="/helpdesk_executive/SaveAuctionEmd" method="post" enctype="multipart/form-data">
            <div class="form" style="text-align:center;">
			<div class="heading4 btmrg20"> Bid History </div>
			<div class="seprator btmrg20"></div>
			<table width="100%" border="0px&quot;">
				<tbody>
					<tr style="background-color:#e6e6e6;">
						<th width="50px" align="left" class="BidHistory-Header">SNo.</th>
						<th width="150px" align="left" class="BidHistory-Header">File Name</th>
						<th align="left" class="BidHistory-Header">Type</th>
						<th align="left" class="BidHistory-Header">Action</th>
					</tr>
					<tr class="">
						<td align="left">1</td>
						<td align="left"><?php echo $auctionData->image;?></td>
						<td align="left">NIT Image</td>
						<td align="left">
						<a download href="/public/uploads/event_auction/<?php echo $auctionData->image;?>">View Image</a></td>
					</tr>
					<tr class="">
						<td align="left">2</td>
						<td align="left"><?php echo $auctionData->related_doc;?></td>
						<td align="left">NIT Document</td><td align="left">
						<a download href="/public/uploads/event_auction/<?php echo $auctionData->related_doc;?>"> View  NIT Doc</a></td>
					</tr>
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