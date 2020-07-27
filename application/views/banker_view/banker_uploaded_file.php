<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<title>bankEauction</title>
<meta name="description" content="C1india Eauction" />
<meta name="keywords" content="C1india Eauction" />
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

<style>
html{overflow: hidden;}
section{float:none;}
.wrapper-full{margin:0;}
#docImg{width: 100px !important;height: auto !important;}
table tbody tr:hover {
    background-color: transparent;
}
</style>




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
          
          <div class="secttion-right" style="width:100%;max-height: 429px;overflow: auto;">
		  <form name="submitEmd" id="submitEmd" action="/helpdesk_executive/SaveAuctionEmd" method="post" enctype="multipart/form-data">
            <div class="form">
			<div class="heading1 btmrg20"> Auction Uploaded Files </div>
			<div class="seprator btmrg20"></div>
			<table width="100%" border="0px&quot;">
				<tbody>
					<tr class="bg-blue-th">
                                           
						<th width="50px" align="left" class="BidHistory-Header">S. No.</th>
						<th width="150px" align="left" class="BidHistory-Header"></th>
						<th width="150px" align="left" class="BidHistory-Header">Document Name</th>
						<th width="50px" align="left" class="BidHistory-Header">Action</th>
					</tr>
                    <?php if(is_array($uploadedDocs) && count($uploadedDocs)>0){						
						$i=1;
						foreach($uploadedDocs as $ud)
						{
						$imgArr = explode('.',$ud->file_path);
						
					?>
						<tr class="">
							<td align="left"><?php echo $i; ?></td>
							<td align="left">
					<?php if($imgArr[1] =='pdf')
						{
					?>	
							<a download class="" href="<?php echo base_url();?>public/uploads/event_auction/<?php echo $ud->file_path;?>" class="">
								<img style="width:50px;height:50px;float:left;margin-left:5px;" src="<?php echo base_url();?>images/pdf-icon.jpg">
							</a>
					<?php
						} else {?>
								<img id="docImg" src="/public/uploads/event_auction/<?php echo $ud->file_path;?>" width="100" height="100">
						<?php } ?>
							</td>
							<td align="left"><?php echo $ud->upload_document_field_name;?></td>
							<td align="left">
							<a download target="_blank" href="/public/uploads/event_auction/<?php echo $ud->file_path;?>">View</a></td>
						</tr>
                    <?php 
						$i++;
						}
                    } ?>
                    
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
