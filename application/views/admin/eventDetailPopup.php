<?php
$auctionID=$auction_detail->id;
?>
<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<title>Auction Details</title>
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
        <tr class="even">                  
            <td align="left" valign="top" class="" width="25%"><strong>Auction No. </strong></td>
            <td align="left" valign="top" class=""  colspan="3" width="25%"><?php echo $auction_detail->id; ?></td>
            <td align="left" valign="top" class="" width="25%"><strong>Institution Name</strong></td>
            <td align="left" valign="top" class=""  colspan="3" width="25%">
            <?php
                echo GetTitleByField('tbl_bank', "id='".$auction_detail->bank_id."'" ,'name');
            ?>  
            </td>
        </tr>
        
        <tr class="odd">
            <td align="left" valign="top" class=""><strong>Branch Name</strong></td>
            <td align="left" valign="top" class=""  colspan="3"> <?php
                echo GetTitleByField('tbl_branch', "id='".$auction_detail->branch_id."'" ,'name');
            ?></td>
			<td align="left" valign="top" class=""><strong>Auction Type</strong></td>
            <td align="left" valign="top" class="" colspan="3"><?php
                echo GetTitleByField('tbl_category', "id='".$auction_detail->category_id."'" ,'name');
            ?></td></td>
            
        </tr>
       
        <tr class="even">
            
			<td align="left" valign="top" class=""><strong>Sub Type</strong></td>
            <td align="left" valign="top" class=""  colspan="3">
            <?php
            echo GetTitleByField('tbl_category', "id='".$auction_detail->subcategory_id."'" ,'name');
            ?>
            </td>
            <td align="left" valign="top" class=""><strong>Description</strong></td>
            <td align="left" valign="top" class="" colspan="3"><?php echo strtoupper($auction_detail->PropertyDescription);?></td>
            
        </tr>

        <tr class="odd">
            <td align="left" valign="top" class=""><strong>Location </strong></td>
            <td align="left" valign="top" class=""  colspan="3"><?php echo $auction_detail->reference_no?></td> 
			<td align="left" valign="top" class=""><strong>City</strong></td>
            <td align="left" valign="top" class="" colspan="3"><?php
                echo GetTitleByField('tbl_city', "id='".$auction_detail->city."'" ,'city_name');
            ?></td></td>
        </tr>
        
        <tr class="even">
            <td align="left" valign="top" class=""><strong>State</strong></td>
            <td align="left" valign="top" class="" colspan="3"><?php
                echo GetTitleByField('tbl_state', "id='".$auction_detail->state."'" ,'state_name');
            ?></td></td>
			<td align="left" valign="top" class=""><strong>Country</strong></td>
            <td align="left" valign="top" class="" colspan="3"><?php
                echo GetTitleByField('tbl_country', "id='".$auction_detail->countryID."'" ,'country_name');
            ?></td></td>
			
        </tr>
        
        <tr class="odd">
            
            <td align="left" valign="top" class=""><strong>Reserve Price</strong></td>
            <td align="left" valign="top" class=""  colspan="3"><?php echo $auction_detail->reserve_price;?>
            </td>  
            <td align="left" valign="top" class=""><strong>EMD Amount</strong></td>
            <td align="left" valign="top" class=""  colspan="3"><?php echo $auction_detail->emd_amt;?>
            </td>
        </tr>
       
        <tr class="even">
            
            <td align="left" valign="top" class=""><strong>EMD Submission Last Date</strong></td>
            <td align="left" valign="top" class=""  colspan="3">
                <?php echo date("d-m-Y H:i",strtotime($auction_detail->bid_last_date));?>
            </td>
			
            <td align="left" valign="top" class=""><strong>Auction Start date</strong></td>
            <td align="left" valign="top" class=""  colspan="3">
                <?php echo date("d-m-Y H:i",strtotime($auction_detail->auction_start_date));?>
            </td> 
            
        </tr>
        <tr class="odd">
            <td align="left" valign="top" class=""><strong>Auction End date</strong></td>
            <td align="left" valign="top" class=""  colspan="3">
                <?php echo date("d-m-Y H:i",strtotime($auction_detail->auction_end_date));?>
            </td> 
            <td align="left" valign="top" class=""><strong>How to Reach</strong></td>
            <td td align="left" valign="top" class="" colspan="3"><a target="_blank" href="<?php echo base_url().'admin/home/viewGoogleMap/'. $auction_detail->id;?>">View</a></td>
        </tr>
        
        <?php if(count($uploadedDocs)>0 && is_array($uploadedDocs)){ ?>
        <tr class="odd">
            
            <td align="left" valign="top" class=""><strong><?php echo $uploadedDocs[0]->upload_document_field_name;?></strong></td>
            <td align="left" valign="top" class=""  colspan="3">
			<a href="/public/uploads/event_auction/<?php echo $uploadedDocs[0]->file_path;?>" target="_blank">View</a>
			<td align="left" valign="top" class=""></td>
            <td align="left" valign="top" class="" colspan="3">
            </td>
        </tr>
		<?php } ?>
    
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
