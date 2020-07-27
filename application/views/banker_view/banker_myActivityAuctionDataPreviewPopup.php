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
<?php //print_r($auction_datarow);?>
<section>
  <div class="row">
    <div class="wrapper-full">
      <div class="dashboard-wrapper">
        
        <div class="container">
          
          <div class="secttion-right" style="width:100%;">
			<div class="heading4 btmrg20">Auction Detail</div>
          <table border="1" align="left" cellpadding="2" cellspacing="1" class="mytable dataTable" id="big_table" aria-describedby="big_table_info">
              <tbody role="alert" aria-live="polite" aria-relevant="all">
                <tr class="odd">
                  <td width="20%" align="left" valign="top" class=""><strong>Auction Type</strong></td>
                  <td width="35%" align="left" valign="top" class="" >
				  <?php echo ($auction_data[0]->event_type=='drt')?'DRT':'SARFAESI' ?></td>
                </tr>
                
                <tr class="even">
                 
                  <td align="left" valign="top" class=""><strong>Auction No</strong></td>
                  <td align="left" valign="top" class=""><?php echo $auction_data[0]->id?></td>
				</tr>
                <tr class="even">
                 
                  <td align="left" valign="top" class=""><strong>Property ID</strong></td>
                  <td align="left" valign="top" class=""><?php echo $auction_data[0]->reference_no?></td>
				</tr>
                <tr class="even">
                 
                  <td align="left" valign="top" class=""><strong>Tender / Auction Title </strong></td>
                  <td align="left" valign="top" class=""><?php echo $auction_data[0]->event_title?></td>
				</tr>
                <tr class="even">
                 
                  <td align="left" valign="top" class=""><strong>Auction Bank</strong></td>
                  <td align="left" valign="top" class=""><?php echo $auction_data[0]->bank_id?></td>
				</tr>
                <tr class="even">
                 
                  <td align="left" valign="top" class=""><strong>Category of item to be auctioned</strong></td>
                  <td align="left" valign="top" class=""><?php echo $auction_data[0]->category_id?></td>
				</tr>
                <tr class="even">
                 
                  <td align="left" valign="top" class=""><strong>Sub Category</strong></td>
                  <td align="left" valign="top" class=""><?php echo $auction_data[0]->subcategory_id?></td>
				</tr>
                <tr class="even">
                 
                  <td align="left" valign="top" class=""><strong>Description of the property</strong></td>
                  <td align="left" valign="top" class=""><?php echo $auction_data[0]->product_description?></td>
				</tr>
                <tr class="even">
                 
                  <td align="left" valign="top" class=""><strong>Borrower Name</strong></td>
                  <td align="left" valign="top" class="">
				  <?php echo $auction_data[0]->borrower_name?></td>
				</tr>
                <tr class="even">
                 
                  <td align="left" valign="top" class=""><strong>Reserve Price</strong></td>
                  <td align="left" valign="top" class=""><?php echo $auction_data[0]->reserve_price?></td>
				</tr>
                <tr class="even">
                 
                  <td align="left" valign="top" class=""><strong>EMD Amount</strong></td>
                  <td align="left" valign="top" class=""><?php echo $auction_data[0]->emd_amt?></td>
				</tr>
                <tr class="even">
                 
                  <td align="left" valign="top" class=""><strong>Tender Fee</strong></td>
                  <td align="left" valign="top" class=""><?php echo $auction_data[0]->tender_fee?></td>
				</tr>
                <tr class="even">
                 
                  <td align="left" valign="top" class=""><strong>Nodal Bank Name</strong></td>
                  <td align="left" valign="top" class="">
				  <?php echo $auction_data[0]->nodal_bank?></td>
				</tr>
                <tr class="even">
                 
                  <td align="left" valign="top" class=""><strong>Nodal Bank account number</strong></td>
                  <td align="left" valign="top" class="">
				  <?php echo $auction_data[0]->nodal_bank_account?></td>
				</tr>
                <tr class="even">
                 
                  <td align="left" valign="top" class=""><strong>Nodal Bank IFSC Code</strong></td>
                  <td align="left" valign="top" class="">
				  <?php echo $auction_data[0]->branch_ifsc_code?></td>
				</tr>
                <tr class="even">
                 
                  <td align="left" valign="top" class=""><strong>NIT Date</strong></td>
                  <td align="left" valign="top" class="">
				  <?php echo $auction_data[0]->branch_ifsc_code?></td>
				</tr>
                <tr class="even">
                 
                  <td align="left" valign="top" class=""><strong>Date of inspection of asset (From)</strong></td>
                  <td align="left" valign="top" class="">
				  <?php echo $auction_data[0]->inspection_date_from?></td>
				</tr>
                <tr class="even">
                 
                  <td align="left" valign="top" class=""><strong>Date of inspection of asset (To)</strong></td>
                  <td align="left" valign="top" class="">
				  <?php echo $auction_data[0]->inspection_date_to?></td>
				</tr>
                <tr class="even">
                 
                  <td align="left" valign="top" class=""><strong>Offer (First Round Quote) Submission last date</strong></td>
                  <td align="left" valign="top" class="">
				  <?php echo $auction_data[0]->bid_last_date?></td>
				</tr>
                <tr class="even">
                 
                  <td align="left" valign="top" class=""><strong>Offer (First Round Quote) Opening date</strong></td>
                  <td align="left" valign="top" class="">
				  <?php echo $auction_data[0]->bid_opening_date?></td>
				</tr>
                <tr class="even">
                 
                  <td align="left" valign="top" class=""><strong>Auction End date </strong></td>
                  <td align="left" valign="top" class="">
				  <?php echo $auction_data[0]->auction_end_date?></td>
				</tr>
                <tr class="even">
                 
                  <td align="left" valign="top" class=""><strong>Auction Start date</strong></td>
                  <td align="left" valign="top" class="">
				  <?php echo $auction_data[0]->auction_start_date?></td>
				</tr>
                <tr class="even">
                 
                  <td align="left" valign="top" class=""><strong>Price Bid</strong></td>
                  <td align="left" valign="top" class="">
				  <?php echo $auction_data[0]->price_bid?></td>
				</tr>
                <tr class="even">
                 
                  <td align="left" valign="top" class=""><strong>Applicable
Bid Increment value</strong></td>
                  <td align="left" valign="top" class="">
				  <?php echo $auction_data[0]->no_of_auto_extn?></td>
				</tr>
                <tr class="even">
                 
                  <td align="left" valign="top" class=""><strong>Auto Extension time</strong></td>
                  <td align="left" valign="top" class="">
				  <?php echo $auction_data[0]->auto_extension_time?></td>
				</tr>
                <tr class="even">
                 
                  <td align="left" valign="top" class=""><strong>No. of Auto Extension </strong></td>
                  <td align="left" valign="top" class="">
				  <?php echo $auction_data[0]->no_of_auto_extn?></td>
				</tr>
                <tr class="even">
                 
                  <td align="left" valign="top" class=""><strong>Upload NIT Document</strong></td>
                  <td align="left" valign="top" class="">
				  <?php echo $auction_data[0]->related_doc?></td>
				</tr>
                <tr class="even">
                 
                  <td align="left" valign="top" class=""><strong>Upload Images</strong></td>
                  <td align="left" valign="top" class="">
				  <?php echo $auction_data[0]->image?></td>
				</tr>
                <tr class="even">
                 
                  <td align="left" valign="top" class=""><strong>Second Opener </strong></td>
                  <td align="left" valign="top" class="">
				  <?php echo $auction_data[0]->second_opener?></td>
				</tr>
                <tr class="even">
                 
                  <td align="left" valign="top" class=""><strong>Documents to be submitted </strong></td>
                  <td align="left" valign="top" class="">
				  <?php echo $auction_data[0]->doc_to_be_submitted?></td>
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
