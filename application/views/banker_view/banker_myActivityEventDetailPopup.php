<?php
$auctionID=$auction_detail->id;
?>
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
<link rel="stylesheet" href="<?php echo base_url()?>/css/table-css.css">
<link rel="stylesheet" href="<?php echo base_url()?>/css/nav.css">

<!--<link rel="stylesheet" href="<?php echo base_url()?>/css/banner.css">-->
<script src="<?php echo base_url()?>/js/jquery.min.js"></script>
<!--<link rel="stylesheet" href="<?php echo base_url()?>js/calender/jquery-ui.css">-->
<script src="<?php echo base_url(); ?>js/calender/jquery-ui.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>js/calender/jquery-ui-timepicker-addon.min.js"></script>
<link rel="stylesheet" href="<?php echo base_url()?>js/calender/jquery-ui-timepicker-addon.css">
<script type="text/javascript" src="<?php echo base_url(); ?>js/calender/i18n/jquery-ui-timepicker-addon-i18n.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/calender/jquery-ui-sliderAccess.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>/application/views/admin/js/plugins/jquery.validate.min.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>/js/common.js"></script>
<style>
section{float:none;}
.wrapper-full{margin:0;}
</style>
<!--[if IE]>
<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->
<!--[if IE]>
<script type="text/javascript" src="/js/respond.js"></script>
<![endif]-->
</head>
<body>
<?php //print_r($emdrow);?>
<section>
  <div class="row">
    <div class="wrapper-full">
      <div class="dashboard-wrapper">
        
		
        <div class="container">
		
		
        <div class="heading5 btmrg20"><?php echo $auction_detail->event_title?> </div>

          <div class="secttion-right" style="width:100%;">
          <div class="heading1 btmrg20">Auction Detail </div>
			<?php foreach($auction_detail as $auction_detail){}?>
          <table border="1" align="left" cellpadding="2" cellspacing="1" class="mytable dataTable" id="big_table" aria-describedby="big_table_info">
              <tbody role="alert" aria-live="polite" aria-relevant="all">
                <tr class="odd">
                  <td width="25%" align="left" valign="top" class=""><strong>Auction No. </strong></td>
                  <td width="30%" align="left" valign="top" class="" ><?php echo $auction_detail->id?></td>
				  <td width="25%" align="left" valign="top" class=""><strong>Property ID</strong></td>
                  <td width="25%" align="left" valign="top" class=""><?php echo $auction_detail->reference_no?></td>
                  
                </tr>
               
                <tr class="even">
                  <?php
				  $discription=GetTitleByField('tbl_product', "id='$auction_detail->productID'", 'product_description');
				  ?>
                  <td align="left" valign="top" class=""><strong>Property Address</strong></td>
                  <td align="left" valign="top" class=""  ><?php echo $discription?><?php?></td>
                   <td align="left" valign="top" class=""><strong>Press Release Date</strong></td>
                  <td align="left" valign="top" class=""  ><?php echo date("d M Y H:i:s",strtotime($auction_detail->press_release_date));?></td>
                 
                  </tr>
				  
				  
				  

                <tr class="odd">
                  
                <td align="left" valign="top" class=""><strong>Date of inspection of asset (From) </strong></td>
                  <td align="left" valign="top" class="">
				  <?php
					if($auction_detail->inspection_date_from!='0000-00-00 00:00:00'){
				  echo date("d M Y H:i:s",strtotime($auction_detail->inspection_date_from));
					}else{  echo 'N/A';} ?>
				  </td>
				  <td align="left" valign="top" class=""><strong>Date of inspection of asset (To) : </strong></td>
                  <td align="left" valign="top" class="">
				  <?php 
				  if($auction_detail->inspection_date_to!='0000-00-00 00:00:00'){
				  echo date("d M Y H:i:s",strtotime($auction_detail->inspection_date_to));
				  }else{  echo 'N/A';} ?>
				  </td>
				  
                  </tr>
                <tr class="even">
                 
                  <td align="left" valign="top" class=""><strong>Sealed Bid Submission Last Date</strong></td>
				 
                  <td align="left" valign="top" class=""><?php echo date("d M Y H:i:s",strtotime($auction_detail->bid_last_date));?></td>
                  <td align="left" valign="top" class=""><strong>Sealed Bid opening Date </strong></td>
                  <td align="left" valign="top" class=""><?php echo date("d M Y H:i:s",strtotime($auction_detail->bid_opening_date));?></td>
                  </tr>
                <tr class="odd">
                 
                  <td align="left" valign="top" class=""><strong>Auction Start Date.</strong></td>
                  <td align="left" valign="top" class="">  
				  <?php echo date("d M Y H:i:s",strtotime($auction_detail->auction_start_date));?>
				 </td>
                  <td align="left" valign="top" class=""><strong>Auction End Date</strong></td>
                  <td align="left" valign="top" class="">
				<?php echo date("d M Y H:i:s",strtotime($auction_detail->auction_end_date));?>
				  </td>
                  </tr>
                <tr class="even">
                  <td align="left" valign="top" class=""><strong>View NIT Document</strong></td>
                  <td align="left" valign="top" class="">
				  
				 <a download target="_blank" href="/public/uploads/event_auction/<?php echo $auction_detail->related_doc?>"> <?php echo $auction_detail->related_doc; ?><a/>
				  
				  </td>
                  <td align="left" valign="top" class=""><strong>View Images :</strong></td>
                  <td align="left" valign="top" class="">
					<?php 
					
					if(isset($auction_detail->image) && $auction_detail->image!='') {?> 
					
					<a download target="_blank" href="/public/uploads/event_auction/<?php echo $auction_detail->image;?>"> <?php echo $auction_detail->image; ?><a/>
				   <?php }else{echo 'N/A';} ?>
		</td>
                </tr>
                 <tr class="even">
                  <td align="left" valign="top" class=""><strong>Special terms and conditions</strong></td>
                  <td align="left" valign="top" class=""> 
						<?php if(isset($auction_detail->supporting_doc) && $auction_detail->supporting_doc!='0') {?>
						<a target="_blank" target="_blank" href="/public/uploads/event_auction/<?php echo $auction_detail->supporting_doc?>"> <?php echo $auction_detail->supporting_doc; ?><a/>
						<?php }else{ 
							echo 'N/A';
							}?>
				  </td>
				  
				  <?php //echo $auction_detail->event_type; ?>
				  <?php if($auction_detail->event_type!='drt') { ?>
						 <?php if(GetTitleByField('tbl_bank','id='.$auction_detail->bank_id,'tender_doc')){   ?>
						  <td align="left" valign="top" class=""><strong>Tender Doc</strong></td>
						  <td align="left" valign="top" class=""> <a  download target="_blank" href="<?php echo GetTitleByField('tbl_bank','id='.$auction_detail->bank_id,'tender_doc');?>"> Tender Doc<a/></td>
						 <?php }?>
				  <?php } ?> 
                  </tr>
                  
                <?php if($auction_detail->event_type!='drt') { ?>  
					<tr class="even">
						 <?php  if(GetTitleByField('tbl_bank','id='.$auction_detail->bank_id,'annexure2')){ ?>
					  <td align="left" valign="top" class=""><strong>Annexure2</strong></td>
					  <td align="left" valign="top" class=""> <a  download target="_blank" href="<?php echo GetTitleByField('tbl_bank','id='.$auction_detail->bank_id,'annexure2');?>">Annexure2<a/></td>
					  <?php }?>
					   <?php if(GetTitleByField('tbl_bank','id='.$auction_detail->bank_id,'annexure3')){ ?>
					  <td align="left" valign="top" class=""><strong>Annexure3</strong></td>
					  <td align="left" valign="top" class=""> <a download target="_blank" href="<?php echo GetTitleByField('tbl_bank','id='.$auction_detail->bank_id,'annexure3');?>">Annexure3<a/></td>
					  <?php }?>
					  </tr>
                  <?php } ?> 
                  
                  <tr class="even">
                     <?php  
                     $auto_extension_time = $auction_detail->auto_extension_time;
						if(!($auto_extension_time > 0))
						{
							$auto_extension_time = "5";
						}
		
                      ?>
                  <td align="left" valign="top" class=""><strong>Auto Extension Time</strong></td>
                  <td align="left" valign="top" class=""><?php echo $auto_extension_time; ?> </td>
                  <?php ?>
                   <?php 
                   $no_of_auto_extn = $auction_detail->no_of_auto_extn;
					if(!($no_of_auto_extn > 0))
					{
							$no_of_auto_extn = "Unlimited";
					}
					
                   ?>
                  <td align="left" valign="top" class=""><strong>No of Auto Extension</strong></td>
                  <td align="left" valign="top" class=""><?php echo $no_of_auto_extn; ?> </td>
                  <?php ?>
                  </tr>
               
              </tbody>
             
            </table>
            
			</div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

</body>

</html>
