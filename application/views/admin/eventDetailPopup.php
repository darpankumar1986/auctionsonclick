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
            <td align="left" valign="top" class="" width="25%"><strong>Institution</strong></td>
            <td align="left" valign="top" class=""  colspan="3" width="25%">
            <?php
                echo GetTitleByField('tblmst_account_type', "account_id='".$auction_detail->account_type_id."'" ,'account_name');
            ?>  
            </td>
        </tr>
        
        <tr class="odd">
            <td align="left" valign="top" class=""><strong>Property ID </strong></td>
            <td align="left" valign="top" class=""  colspan="3"><?php echo $auction_detail->reference_no?></td>
            <td align="left" valign="top" class=""><strong>Auction Reference Dispatch Date</strong></td>
            <td align="left" valign="top" class=""  colspan="3"><?php echo (($auction_detail->dispatch_date != '1970-01-01') && ($auction_detail->dispatch_date != '0000-00-00')) ? date('d-m-Y', strtotime($auction_detail->dispatch_date)) : 'N/A'; ?></td>
        </tr>
       
        <tr class="even">
            <td align="left" valign="top" class=""><strong>Description</strong></td>
            <td align="left" valign="top" class="" colspan="3"><?php echo strtoupper($auction_detail->PropertyDescription);?></td>
            <td align="left" valign="top" class=""><strong>Carpet Area</strong></td>
            <td align="left" valign="top" class="" colspan="3"><?php echo ($auction_detail->area != '')?$auction_detail->area:'N/A';?></td>
        </tr>

        <tr class="odd">
            <td align="left" valign="top" class=""><strong>Carpet Area Unit</strong></td>
            <td align="left" valign="top" class="" colspan="3">
            <?php
                $cauom = GetTitleByField('tblmst_uom_type', "uom_id='".$auction_detail->area_unit_id."'" ,'uom_name');
                echo ($cauom !='')?$cauom:'N/A';
            ?>  
            </td>
            <td align="left" valign="top" class=""><strong>Category/ Property Type</strong></td>
            <td align="left" valign="top" class=""  colspan="3">
            <?php
            echo GetTitleByField('tbl_category', "id='".$auction_detail->category_id."'" ,'name');
            ?>
            </td> 
        </tr>
        
        <tr class="even">
            <td align="left" valign="top" class=""><strong>Plot Area</strong></td>
            <td align="left" valign="top" class="" colspan="3"><?php echo ($auction_detail->property_height != '')?$auction_detail->property_height:'N/A';?></td>
            <td align="left" valign="top" class=""><strong>Plot Area Unit</strong></td>
            <td align="left" valign="top" class="" colspan="3">
            <?php
				$cauom = GetTitleByField('tblmst_uom_type', "uom_id='".$auction_detail->height_unit_id."'" ,'uom_name');
                echo ($cauom !='')?$cauom:'N/A';
            ?>  
            </td>
        </tr>
        
        <tr class="even">
            
            <td align="left" valign="top" class=""><strong>Corner</strong></td>
            <td align="left" valign="top" class=""  colspan="3"><?php echo ($auction_detail->is_corner_property == 1) ? 'Yes' : 'No'; ?>
            </td>
            <td align="left" valign="top" class=""><strong>Scheme Id</strong></td>
            <td align="left" valign="top" class=""  colspan="3"><?php echo ($auction_detail->scheme_id)? $auction_detail->scheme_id: 'N/A';?></td>
            
        </tr>
        
        <tr class="odd">
            <td align="left" valign="top" class=""><strong>Scheme Name</strong></td>
            <td align="left" valign="top" class=""  colspan="3"><?php echo ($auction_detail->scheme_name)? $auction_detail->scheme_name: 'N/A';?></td>  
        <td align="left" valign="top" class=""><strong>Name of Owner/ Occupier as per MCG record</strong></td>
            <td align="left" valign="top" class=""  colspan="3"><?php echo ($auction_detail->service_no)? $auction_detail->service_no: 'N/A';?></td>
            
        </tr>
        
        <tr class="even">
            <td align="left" valign="top" class=""><strong>Concerned Zone</strong></td>
            <td align="left" valign="top" class=""  colspan="3">
            <?php
            echo GetTitleByField('tbl_zone', "zone_id='".$auction_detail->zone_id."'" ,'zone_name');
            ?>
            </td> 
            <td align="left" valign="top" class=""><strong>Applicable FAR</strong></td>
            <td align="left" valign="top" class=""  colspan="3"><?php echo ($auction_detail->far)? $auction_detail->far: 'N/A';?></td>
            
        </tr>
        
        <tr class="odd">
            <td align="left" valign="top" class=""><strong>Plot Area</strong></td>
            <td align="left" valign="top" class=""  colspan="3"><?php echo ($auction_detail->property_height)? $auction_detail->property_height: 'N/A';?></td>  
        <td align="left" valign="top" class=""><strong>Plot Area Unit</strong></td>
            <td align="left" valign="top" class=""  colspan="3">
            <?php
                $heightUnit = GetTitleByField('tblmst_height_uom_type', "height_uom_id='".$auction_detail->height_unit_id."'" ,'height_uom_name');
                if($heightUnit){
                    echo $heightUnit;
                }else{
                    echo "N/A";
                }
            ?>
                
            </td>
        </tr>
        
        <tr class="even">
            
            <td align="left" valign="top" class=""><strong>Max Coverage Area</strong></td>
            <td align="left" valign="top" class=""  colspan="3"><?php echo ($auction_detail->max_coverage_area)? $auction_detail->max_coverage_area: "N/A";?></td>  
            <td align="left" valign="top" class=""><strong>Reserve Price</strong></td>
            <td align="left" valign="top" class=""  colspan="3"><?php echo $auction_detail->reserve_price;?>
            </td>
        </tr>
        
        <tr class="odd">
            
            <td align="left" valign="top" class=""><strong>Reserve Price (Unit)</strong></td>
            <td align="left" valign="top" class=""  colspan="3"><?php
                echo GetTitleByField('tblmst_uom_type', "uom_id='".$auction_detail->unit_id_of_price."'" ,'uom_name');
            ?> 
            </td>  
            <td align="left" valign="top" class=""><strong>EMD Amount</strong></td>
            <td align="left" valign="top" class=""  colspan="3"><?php echo $auction_detail->emd_amt;?>
            </td>
        </tr>
        
        <?php /* ?><tr class="odd">
            
            <td align="left" valign="top" class=""><strong>Administrative Fee</strong></td>
            <td align="left" valign="top" class="" colspan="3"><?php
                echo ADMINISTRATIVE_FEE;
            ?> 
            </td>  
            <td align="left" valign="top" class="">-</td>
            <td align="left" valign="top" class="">-</td>
        </tr><?php */ ?>
        
        <tr class="even">
            
            <td align="left" valign="top" class=""><strong>Bank Processing Fee</strong></td>
            <td align="left" valign="top" class=""  colspan="3"><?php echo $auction_detail->tender_fee;?>
            </td>  
            <td align="left" valign="top" class=""><strong>Press Release Date</strong></td>
            <td align="left" valign="top" class=""  colspan="3">
            <?php echo date("d-m-Y",strtotime($auction_detail->press_release_date));?>
            </td>
        </tr>
        
        <tr class="odd">
            
            <td align="left" valign="top" class=""><strong>Site Visit Start Date</strong></td>
            <td align="left" valign="top" class=""  colspan="3">
                <?php echo (($auction_detail->inspection_date_from != '1970-01-01') && ($auction_detail->inspection_date_from != '0000-00-00 00:00:00')) ? date('d-m-Y  H:i', strtotime($auction_detail->inspection_date_from)) : 'N/A'; ?>
            </td>  
            <td align="left" valign="top" class=""><strong>Site Visit End Date</strong></td>
            <td align="left" valign="top" class=""  colspan="3">
                <?php echo (($auction_detail->inspection_date_to != '1970-01-01') && ($auction_detail->inspection_date_to != '0000-00-00 00:00:00')) ? date('d-m-Y H:i', strtotime($auction_detail->inspection_date_to)) : 'N/A'; ?>
            </td>
        </tr>
        <tr class="even">
            
            <td align="left" valign="top" class=""><strong>Apply And EMD Start Date</strong></td>
            <td align="left" valign="top" class=""  colspan="3">
                <?php echo date("d-m-Y H:i",strtotime($auction_detail->registration_start_date));?>
            </td> 
            <td align="left" valign="top" class=""><strong>EMD Submission Last Date</strong></td>
            <td align="left" valign="top" class=""  colspan="3">
                <?php echo date("d-m-Y H:i",strtotime($auction_detail->bid_last_date));?>
            </td>
        </tr>
        <tr class="odd">
            
            <td align="left" valign="top" class=""><strong>Auction Start date</strong></td>
            <td align="left" valign="top" class=""  colspan="3">
                <?php echo date("d-m-Y H:i",strtotime($auction_detail->auction_start_date));?>
            </td> 
            
            <td align="left" valign="top" class=""><strong>Auction End date</strong></td>
            <td align="left" valign="top" class=""  colspan="3">
                <?php echo date("d-m-Y H:i",strtotime($auction_detail->auction_end_date));?>
            </td> 
            
        </tr>
        
        <tr class="even">
            
            <td align="left" valign="top" class=""><strong>Mode of Bid</strong></td>
            <td align="left" valign="top" class=""  colspan="3">
               <?php echo ($auction_detail->mode_of_bid == 'online') ? 'Online' : 'Offline'; ?>
            </td>
             
            <td align="left" valign="top" class=""><strong>Is DSC Enabled </strong></td>
            <td align="left" valign="top" class=""  colspan="3">
                <?php echo ($auction_detail->dsc_enabled == 1) ? "Yes" : "No" ?>
            </td> 
        </tr>
        
         <tr class="odd">
           
            <td align="left" valign="top" class=""><strong>Auto Bid Allow</strong></td>
            <td align="left" valign="top" class=""  colspan="3">
                <?php echo ($auction_detail->auto_bid_cut_off == 1) ? "Yes" : "No" ?>
            </td>
            <td align="left" valign="top" class=""><strong>Bid Increment value</strong></td>
            <td align="left" valign="top" class=""  colspan="3">
                <?php echo $auction_detail->bid_inc;?>
            </td>
        </tr>
        
        <tr class="even">  
             <td align="left" valign="top" class=""><strong>Auto Extension time </strong>(In Minutes.)</td>
            <td align="left" valign="top" class=""  colspan="3"><?php echo ($auction_detail->auto_extension_time != '0') ? $auction_detail->auto_extension_time : "0"; ?>
            </td>
            
            <td align="left" valign="top" class=""><strong>Auto Extension(s)</strong></td>
            <td align="left" valign="top" class=""  colspan="3">
                <?php echo ($auction_detail->auto_extension_time >0 && $auction_detail->no_of_auto_extn == '0') ? "Unlimited": $auction_detail->no_of_auto_extn; ?>
            </td> 
        </tr>
        <tr class="odd">
            <td align="left" valign="top" class=""><strong>How to Reach</strong></td>
            <td td align="left" valign="top" class="" colspan="3"><a target="_blank" href="<?php echo base_url().'buyer/viewGoogleMap/'. $auction_detail->id;?>">View</a></td>
           <td align="left" valign="top" class=""><strong>1st Contact Person Details</strong></td>
            <td align="left" valign="top" class="" colspan="3"><?php echo $auction_detail->contact_person_details_1;?>
            </td>
        </tr>
        
        <tr class="even">
           <td align="left" valign="top" class=""><strong>2nd Contact Person Details</strong></td>
            <td align="left" valign="top" class="" colspan="3"><?php echo ($auction_detail->contact_person_details_2)?$auction_detail->contact_person_details_2: "N/A";?>
            </td>
            <td align="left" valign="top" class=""><strong>Any Documents Pertinent To The Auction</strong></td>
            <td align="left" valign="top" class=""  colspan="3">
                 <?php
                if ($auction_detail->doc_to_be_submitted) {
                    $docsubArr = explode(',', $auction_detail->doc_to_be_submitted);
                }else{
                    echo "None";
                }
                foreach ($document_list as $document) {
                    if (count($docsubArr) > 0) {
                        if (in_array($document->id, $docsubArr)) {
                            $docArr[] = $document->name;
                        }
                    }
                }
                $docs = implode(', ', $docArr);
                echo $docs;
                ?>
            </td>
        </tr>
        
        <tr class="odd">
            <td align="left" valign="top" class=""><strong>Remark</strong></td>
            <td align="left" valign="top" class=""  colspan="3">
                <?php echo ($auction_detail->remark)? $auction_detail->remark: "N/A";?>
            </td> 
            <td align="left" valign="top" class=""><strong>Auction Created by</strong></td>
        <td align="left" valign="top" class="" colspan="3">
            <?php
                  /*$sales_executive_id=GetTitleByField('tbl_event_log_sales', "id='".$auction_detail->eventID."'" ,'sales_executive_id');				
                  echo  GetTitleByField('tbl_user_registration', "id='".$sales_executive_id."'" ,'first_name');
                  echo " ";
                  echo  GetTitleByField('tbl_user_registration', "id='".$sales_executive_id."'" ,'last_name');*/

                  $sales_executive_id=GetTitleByField('tbl_auction', "id='".$auction_detail->id."'" ,'first_opener');				
                  echo  GetTitleByField('tbl_user', "id='".$sales_executive_id."'" ,'first_name');
                  echo " ";
                  echo  GetTitleByField('tbl_user', "id='".$sales_executive_id."'" ,'last_name');
            ?>
          </td>
        </tr>
        
        <tr class="even">  
          <td align="left" valign="top" class=""><strong>Auction Approved by</strong></td>
          <td align="left" valign="top" class="" colspan="3">
            <?php
                  $approver_id = GetTitleByField('tbl_auction', "id='".$auction_detail->id."'" ,'second_opener');				
                  echo  GetTitleByField('tbl_user', "id='".$approver_id."'" ,'first_name');
                  echo " ";
                  echo  GetTitleByField('tbl_user', "id='".$approver_id."'" ,'last_name');
            ?>
          </td>
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
