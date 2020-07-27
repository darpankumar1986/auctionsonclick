<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $page_title; ?></title>
<style>
body {
	font-family:'Open Sans', Arial;
	font-size:14px; font-weight:normal!important;
	color:#000;
}
h1 {
	font-size:22px;
	color:#000;
	/*text-transform:uppercase;*/
	font-weight:normal;
	margin:0;
	/*border-bottom:1px solid #333;*/
	padding-bottom:5px;
}
h2 {
	font-size:16px;
	text-align:center;
	/*text-transform:uppercase;*/
	color:#000;
	font-weight:normal;
	margin:0;
}

h3 {
	font-size:16px;
	/*text-transform:uppercase;*/
	color:#000;
	font-weight:normal;
	margin:0;
}

td {
	padding:4px 2px;
	border-top:0px solid #dfdfdf;
	border-bottom:0px solid #dfdfdf;
	border-collapse:collapse;
	font-weight:normal;
}
.table-bor td {
	border:1px solid #ddd;
	border-collapse:collapse;
	
}

.table-bor th{ padding:4px 0px;}
thead {
	font-size:14px;
	color:#000;
	
	background-color:#ccc;
}
thead th {
	height:auto;
	padding:5px 0px;
	font-size:14px;
	font-weight:bold;
	color:#000;
	background-color:#ccc;
}
table thead tr.odd td{font-size:12px;}
table tr.odd td {
	background-color: #f3f3f3;
	border-bottom: 1px solid #ddd; 	
	padding: 8px 2px;
}
table tr.even td {
	background-color: #ffffff;
	border-bottom: 1px solid #ddd;
	padding: 8px 2px;
}
.grey_bg {
	background-color:#ccc;
}
.grey_bg2 {
	background-color:#f9f9f9;
	border:1px solid #ddd;
}
.pd-tp{ padding:4px 0px;}
.pd-tp2{ padding:10px 0px;}
</style>
<?php /* ?>
<style>
 @font-face {
    font-family: kruti;
    src: url(http://bankeauction.com/bankeauc/fonts/k010.TTF);
}
 .hindi{font-family:'kruti'; font-size:18px; color:#000;}
 
  @font-face {
    font-family: AnjaliOldLipi;
    src: url(http://bankeauction.com/bankeauc/fonts/AnjaliOldLipi.ttf);
}
 .hindi_new{font-family:'AnjaliOldLipi'; font-size:18px; color:#000;}
</style>
<?php */ ?>
</head>

<body>
<pre>
<?php //print_r($auctionData);
// print_r($BidderRankData);
?>
</pre>
<table width="980" border="0" align="center" cellpadding="0" cellspacing="0" style="background:#fff;">
  <tr>
    <td align="left" valign="top" scope="col">&nbsp;</td>
    <td align="right" valign="top" scope="col"><img width="auto" height="50" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAATsAAAAyCAYAAAAjpHy7AAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAyJpVFh0WE1MOmNvbS5hZG9iZS54bXAAAAAAADw/eHBhY2tldCBiZWdpbj0i77u/IiBpZD0iVzVNME1wQ2VoaUh6cmVTek5UY3prYzlkIj8+IDx4OnhtcG1ldGEgeG1sbnM6eD0iYWRvYmU6bnM6bWV0YS8iIHg6eG1wdGs9IkFkb2JlIFhNUCBDb3JlIDUuMy1jMDExIDY2LjE0NTY2MSwgMjAxMi8wMi8wNi0xNDo1NjoyNyAgICAgICAgIj4gPHJkZjpSREYgeG1sbnM6cmRmPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIj4gPHJkZjpEZXNjcmlwdGlvbiByZGY6YWJvdXQ9IiIgeG1sbnM6eG1wPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvIiB4bWxuczp4bXBNTT0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wL21tLyIgeG1sbnM6c3RSZWY9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9zVHlwZS9SZXNvdXJjZVJlZiMiIHhtcDpDcmVhdG9yVG9vbD0iQWRvYmUgUGhvdG9zaG9wIENTNiAoV2luZG93cykiIHhtcE1NOkluc3RhbmNlSUQ9InhtcC5paWQ6QjQ3MzQzQzBCQTMyMTFFN0EyNjM5QUEyQ0UyNjNCRUIiIHhtcE1NOkRvY3VtZW50SUQ9InhtcC5kaWQ6QjQ3MzQzQzFCQTMyMTFFN0EyNjM5QUEyQ0UyNjNCRUIiPiA8eG1wTU06RGVyaXZlZEZyb20gc3RSZWY6aW5zdGFuY2VJRD0ieG1wLmlpZDpCNDczNDNCRUJBMzIxMUU3QTI2MzlBQTJDRTI2M0JFQiIgc3RSZWY6ZG9jdW1lbnRJRD0ieG1wLmRpZDpCNDczNDNCRkJBMzIxMUU3QTI2MzlBQTJDRTI2M0JFQiIvPiA8L3JkZjpEZXNjcmlwdGlvbj4gPC9yZGY6UkRGPiA8L3g6eG1wbWV0YT4gPD94cGFja2V0IGVuZD0iciI/PsNHqAwAAA3JSURBVHja7F1NcuO6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"></td>
  </tr>
    <tr><td colspan="2"></td></tr>	
</table>

<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" style="background:#fff;">
	<tr class="odd">
		<td align="left" valign="top" scope="col"><h1>Rejected Bids Report </h1></td>    
	</tr>
	<tr>
		<td align="left" valign="top" scope="col">&nbsp;</td>
	</tr>
</table>

<table  width="100%" border="0" align="left" cellpadding="0" cellspacing="0" class="table-bor" >
	<tbody role="alert" aria-live="polite" aria-relevant="all">
		<tr class="even">
			<td width="20%" align="left" valign="top" class=""><strong>Auction ID  : </strong></td>
			<td width="30%" align="left" valign="top" class=""><?php echo $auctionData[0]->id; ?></td>

			<td width="20%" align="left" valign="top" class=""><strong>Property ID  :  </strong></td>
			<td width="30%" align="left" valign="top" class=""><?php echo $auctionData[0]->reference_no; ?></td>
		</tr>								
		<tr class="even">
			<td width="20%" align="left" valign="top" class=""><strong>Property Address  :   </strong></td>
			<td width="30%" align="left" valign="top" class="" colspan=3><?php echo $auctionData[0]->PropertyDescription; ?></td>
		</tr>
			<tr class="even">
			<td width="20%" align="left" valign="top" class=""><strong>Department  :   </strong></td>
			<td width="30%" align="left" valign="top" class=""><?php echo BRAND_NAME; ?></td>
			<td width="20%" align="left" valign="top" class=""><strong>Officer  : </strong></td>
			<td width="30%" align="left" valign="top" class=""><?php 
				if($auctionData[0]->first_opener)
				{
					echo GetTitleByField('tbl_user','id='.$auctionData[0]->second_opener,'first_name');
					echo " ".GetTitleByField('tbl_user','id='.$auctionData[0]->second_opener,'last_name');
				}
				$auctionNotPriceBasis = array(99);
				?>
			</td>
		</tr>
		<tr class="even">
			<td width="20%" align="left" valign="top" class=""><strong>Start Date and Time  :   </strong></td>
			<td width="30%" align="left" valign="top" class=""><?php echo date('d-m-Y H:i:s',strtotime($auctionData[0]->auction_start_date)); ?></td>

			<td width="20%" align="left" valign="top" class=""><strong>End Date And Time  :  </strong></td>
			<td width="30%" align="left" valign="top" class=""><?php echo date('d-m-Y H:i:s',strtotime($auctionData[0]->auction_end_date)); ?></td>
		</tr>
	</tbody>
</table>
<br>
<table  width="100%" border="0" align="left" cellpadding="0" cellspacing="0" class="table-bor" >
		<tr class="odd">
		  <td width="7%" align="left" valign="top" class=""><strong>Sr. No.</strong></td>
		  <td width="58%" align="left" valign="top" class=""><strong>Property Details</strong></td>
		  <td align="left" valign="top" class=""><strong>Plot Area</strong></td>
		  <td align="left" valign="top" class=""><strong>Plot UOM</strong></td>
		  <td align="left" valign="top" class=""><strong>Carpet Area</strong></td>
		  <td align="left" valign="top" class=""><strong>Carpet UOM</strong></td>
		 <?php if(!in_array($auctionData[0]->id,$auctionNotPriceBasis) && false) {?><td width="15%" align="left" valign="top" class=""><strong>Price Basis</strong></td><?php } ?>
		  
		</tr>
		<?php 								
			$plot_area_uom = GetTitleByField('tblmst_uom_type',"uom_id='".$auctionData[0]->height_unit_id."'",'uom_name');
			$area_uom = GetTitleByField('tblmst_uom_type',"uom_id='".$auctionData[0]->area_unit_id."'",'uom_name');
			$unit_price = GetTitleByField('tblmst_uom_type','uom_id='.$auctionData[0]->unit_id_of_price,'uom_name');							          
		?>
		<tr class="even">
		  <td  align="left" valign="top" class="">1</td>
		  <td  align="left" valign="top" class=""><?php echo $auctionData[0]->PropertyDescription;  ?></td>
		  <td  align="left" valign="top" class=""><?php echo ($auctionData[0]->property_height != '')?$auctionData[0]->property_height:'N/A'; ?></td>
		  <td  align="left" valign="top" class=""><?php echo ($plot_area_uom != '')?$plot_area_uom:'N/A'; ?></td>
		  <td  align="left" valign="top" class=""><?php echo ($auctionData[0]->area != '')?$auctionData[0]->area:'N/A'; ?></td>
		  <td  align="left" valign="top" class=""><?php echo ($area_uom != '')?$area_uom:'N/A'; ?></td>
		   <?php if(!in_array($auctionData[0]->id,$auctionNotPriceBasis) && false) {?><td  align="left" valign="top" class=""><?php echo 'Price per '.$unit_price; ?></td><?php } ?>
	  </tr>
		
</table>
<br>
  <?php $totalallBid=count($auctionData[0]->bidder_bid);
  if($totalallBid>0){ ?>
  <tr>
    <td align="left" valign="top">
	
	   <!-- start-->    </tbody>
         </table>
        </td> 
        <tr>
       <td align="left" valign="top"> <!-- end added by neeraj -->
	

	<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" class="table-bor">
      <thead>		
        <tr>
		  <th width="7%" align="center" valign="middle" scope="col"><strong>Sr. no. </strong></th>
		  <th width="25%" align="center" valign="middle" scope="col"><strong>Bidders/ Company Name </strong></th>
		  <th width="13%" align="center" valign="middle" scope="col"><strong>Bid Amount </strong></th>
		  <th width="15%" align="center" valign="middle" scope="col"><strong>Bid Date & Time </strong></th>
		  <!--<th width="25%" align="center" valign="top" scope="col"><strong>Rank </strong></th>-->
		  <th width="10%" align="center" valign="middle" scope="col"><strong>IP address </strong></th>
		  <th width="10%" align="center" valign="middle" scope="col"><strong>Bid status </strong></th>
		  <th width="20%" align="center" valign="middle" scope="col"><strong>Remarks </strong></th>
		  
		</tr>
      </thead>
	   <tbody>
	  <?php 
	  $i=1;
	  $companyArr = array();
	  $rankID = 1;
	  foreach ($auctionData[0]->bidder_bid as $allBidData){
	    $millDateArr = explode('.',$allBidData->modified_date);
		$millDate = date('d-m-Y H:i:s',strtotime($millDateArr[0]));
		$millDateNew = $millDate.'.'.$millDateArr[1];   
        if($i%2==0){$clas="odd";}else{$clas="even";}
		//$rankID = array_search($allBidData->bidderID, $BidderRankData); // $key = 2;
		$rank="H".$rankID;
		?>
		<tr class="<?php echo $clas;?>">
		  <td align="center" valign="top" class=""><?php echo $i;?></td>
		  <td align="center" valign="top" class=""><?php 
		  //if($bid_detail->bidderID)
		  //echo GetTitleByField('tbl_user_registration','id='.$bid_detail->bidderID,'first_name')?>
		   <?php
			  echo ucfirst($bidderName=GetTitleById('tbl_user_registration',$allBidData->bidderID,'first_name'));    
			  echo " ".ucfirst($bidderName=GetTitleById('tbl_user_registration',$allBidData->bidderID,'last_name'));
			  echo '<br>';
			  echo '('.$bidderName=GetTitleById('tbl_user_registration',$allBidData->bidderID,'email_id').')';
		 //  echo $lastbidBidder->first_name; 
		  ?>                                                                  
		  </td>
		  <td align="center" valign="top" class=""><?php echo moneyFormatIndia($allBidData->bid_value); ?></td>
		  <!--<td align="center" valign="top" class=""><?php //echo $rank?></td>-->
		  <td align="center" valign="top" class=""><?php echo $millDateNew; ?></td>
		  <td align="center" valign="top" class=""><?php echo $allBidData->ip; ?></td>
		  <td align="center" valign="top" class=""><?php echo 'Rejected by system'; ?></td>
		  <td align="left" valign="top" class=""><?php echo $allBidData->message; ?></td>						
		</tr>
	<?php
       if($i%25==0){ ?> 
        </tbody>
         </table>
        </td> 
        <tr>
       <td align="left" valign="top"><table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" class="table-bor">
      <thead>
        <tr>
		  <th width="7%" align="center" valign="middle" scope="col"><strong>Sr. no. </strong></th>
		  <th width="25%" align="center" valign="middle" scope="col"><strong>Bidders/ Company Name </strong></th>
		  <th width="13%" align="center" valign="middle" scope="col"><strong>Bid Amount </strong></th>
		  <th width="15%" align="center" valign="middle" scope="col"><strong>Bid Date & Time </strong></th>
		  <!--<th width="25%" align="center" valign="top" scope="col"><strong>Rank </strong></th>-->
		  <th width="15%" align="center" valign="middle" scope="col"><strong>IP address </strong></th>
		  <th width="15%" align="center" valign="middle" scope="col"><strong>Bid status </strong></th>
		  <th width="10%" align="center" valign="middle" scope="col"><strong>Remarks </strong></th>
		  
		</tr>
      </thead>
	   <tbody>
            <?php  }
           $i++; }   ?>

      </tbody>
   </table></td>
 </tr>
  <?php } else{ 
	 
	?>
	<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" class="table-bor">
        <thead>
         <tr>
		  <th width="7%" align="center" valign="middle" scope="col"><strong>Sr. no. </strong></th>
		  <th width="25%" align="center" valign="middle" scope="col"><strong>Bidders/ Company Name </strong></th>
		  <th width="13%" align="center" valign="middle" scope="col"><strong>Bid Amount </strong></th>
		  <th width="15%" align="center" valign="middle" scope="col"><strong>Bid Date & Time </strong></th>
		  <!--<th width="25%" align="center" valign="top" scope="col"><strong>Rank </strong></th>-->
		  <th width="15%" align="center" valign="middle" scope="col"><strong>IP address </strong></th>
		  <th width="15%" align="center" valign="middle" scope="col"><strong>Bid status </strong></th>
		  <th width="10%" align="center" valign="middle" scope="col"><strong>Remarks </strong></th>
		  
		</tr>
        </thead>
        <tbody>
	  <tr class="<?php echo $clas;?>">
		<td align="center" valign="middle" colspan='7'>No Records Found</td>
	  </tr>
 
        </tbody>
      </table>
	<?php
	
	 
	 } 
	 
	 ?>
   
</table>
<!--
<div style="text-align:center;">
*************************Report Ended*************************
</div>
<br/><br/>
<div style="text-align:center;">
Disclaimer: This is a system generated report hence does not need any signature.
</div>
<div style="text-align:center;font-size:11px;position:absolute;bottom:20px; left: 0px;">
	 
	<hr/>
	<span>
		<i>Plot No. 301, First Floor, Udyog Vihar, Phase - 2, Gurgaon (HR)-122015, Tel: +91-124-4302020 Fax: +91-124-4302010 www.c1india.com</i>
	</span>
</div>
-->
</body>
</html>
