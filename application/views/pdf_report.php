<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $page_title; ?></title>
<style>
body {
	font-family:Arial, Helvetica, sans-serif;
	font-size:14px; font-weight:normal!important;
	color:#000;
}
h1 {
	font-size:22px;
	color:#000;
	text-transform:uppercase;
	font-weight:normal;
	margin:0;
	border-bottom:1px solid #333;
	padding-bottom:5px;
}
h2 {
	font-size:16px;
	text-align:center;
	text-transform:uppercase;
	color:#000;
	font-weight:normal;
	margin:0;
}

h3 {
	font-size:16px;
	text-transform:uppercase;
	color:#000;
	font-weight:normal;
	margin:0;
}

td {
	padding:4px 0px;
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
table tr.odd td {
	background-color: #f3f3f3;
	border-bottom: 1px solid #ddd; 	
	padding: 8px 0px;
}
table tr.even td {
	background-color: #ffffff;
	border-bottom: 1px solid #ddd;
	padding: 8px 0px;
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
    <td align="left" valign="top" scope="col">
	<?php
	/*
	$logopath=GetTitleByField('tbl_bank', "id='".$auctionData[0]->bank_id."'", 'thumb_logopath');
	if($logopath){?>
		<?php if(preg_match("/Include/",$logopath)){?>
			<img width="120" src="/public<?php echo $logopath;?>">
		<?php }else if(preg_match("/uploads/",$logopath)){?>
			<img width="120" src="<?php echo $logopath;?>">
		<?php }else{ ?>
			<img width="120" src="/public/uploads/bank/<?php echo $logopath;?>">
		<?php } ?>
	<?php }
	*/  ?>	
	</td>
    <td align="right" valign="top" scope="col"><img width="auto" height="50" src="data:image/png;base64,iVBORw0KGgoAAAANSUhEUgAAATsAAAAyCAYAAAAjpHy7AAAAGXRFWHRTb2Z0d2FyZQBBZG9iZSBJbWFnZVJlYWR5ccllPAAAAyJpVFh0WE1MOmNvbS5hZG9iZS54bXAAAAAAADw/eHBhY2tldCBiZWdpbj0i77u/IiBpZD0iVzVNME1wQ2VoaUh6cmVTek5UY3prYzlkIj8+IDx4OnhtcG1ldGEgeG1sbnM6eD0iYWRvYmU6bnM6bWV0YS8iIHg6eG1wdGs9IkFkb2JlIFhNUCBDb3JlIDUuMy1jMDExIDY2LjE0NTY2MSwgMjAxMi8wMi8wNi0xNDo1NjoyNyAgICAgICAgIj4gPHJkZjpSREYgeG1sbnM6cmRmPSJodHRwOi8vd3d3LnczLm9yZy8xOTk5LzAyLzIyLXJkZi1zeW50YXgtbnMjIj4gPHJkZjpEZXNjcmlwdGlvbiByZGY6YWJvdXQ9IiIgeG1sbnM6eG1wPSJodHRwOi8vbnMuYWRvYmUuY29tL3hhcC8xLjAvIiB4bWxuczp4bXBNTT0iaHR0cDovL25zLmFkb2JlLmNvbS94YXAvMS4wL21tLyIgeG1sbnM6c3RSZWY9Imh0dHA6Ly9ucy5hZG9iZS5jb20veGFwLzEuMC9zVHlwZS9SZXNvdXJjZVJlZiMiIHhtcDpDcmVhdG9yVG9vbD0iQWRvYmUgUGhvdG9zaG9wIENTNiAoV2luZG93cykiIHhtcE1NOkluc3RhbmNlSUQ9InhtcC5paWQ6QjQ3MzQzQzBCQTMyMTFFN0EyNjM5QUEyQ0UyNjNCRUIiIHhtcE1NOkRvY3VtZW50SUQ9InhtcC5kaWQ6QjQ3MzQzQzFCQTMyMTFFN0EyNjM5QUEyQ0UyNjNCRUIiPiA8eG1wTU06RGVyaXZlZEZyb20gc3RSZWY6aW5zdGFuY2VJRD0ieG1wLmlpZDpCNDczNDNCRUJBMzIxMUU3QTI2MzlBQTJDRTI2M0JFQiIgc3RSZWY6ZG9jdW1lbnRJRD0ieG1wLmRpZDpCNDczNDNCRkJBMzIxMUU3QTI2MzlBQTJDRTI2M0JFQiIvPiA8L3JkZjpEZXNjcmlwdGlvbj4gPC9yZGY6UkRGPiA8L3g6eG1wbWV0YT4gPD94cGFja2V0IGVuZD0iciI/PsNHqAwAAA3JSURBVHja7F1NcuO6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"></td>
  </tr>
    <tr>
	<td colspan="2"></td>
    </tr>
	
</table>

<table width="980" border="0" align="center" cellpadding="0" cellspacing="0" style="background:#fff;">
  <tr>
    <td align="left" valign="top" scope="col"><h1>Auction Details </h1></td>
    
    
  </tr>
  <tr>
    <td align="left" valign="top" scope="col">&nbsp;</td>
  </tr>
  <tr>
    <td align="left" valign="top" scope="col"><table width="100%" border="0" align="center" cellpadding="0" cellspacing="0">
      <tr>
        <td width="50%" align="left" valign="top"><table width="90%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td align="left" valign="middle"><h3>Auction Reference</h3></td>
          </tr>
          <tr>
           <!-- <td align="left" valign="middle"><?php //echo $auctionData[0]->reference_no?>/<?php //echo $auctionData[0]->eventID?> </td>-->
          <td align="left" valign="middle"><?php echo $auctionData[0]->reference_no?> </td>
          </tr>
        </table></td>
        <td width="50%" align="left" valign="top"><table width="90%" border="0" cellspacing="0" cellpadding="0">
          <tr>
            <td align="left" valign="middle"><h3>Property Address</h3></td>
          </tr>
			<tr>
			  <?php
					$product_description=GetTitleByField('tbl_product', "id='".$auctionData[0]->productID."'", 'product_description')
			  ?>
				<td align="left" valign="middle"><?php echo ucfirst($product_description); ?> </td>
			</tr>
        </table></td>
      </tr>
      <tr>
        <td colspan="2" align="left" valign="top">&nbsp;</td>
        </tr>
      <tr>
        <td colspan="2" align="left" valign="top"><h3 class="pd-tp">Auction Calendar</h3></td>
        </tr>
      <tr>
        <td colspan="2" align="left" valign="top" class="grey_bg2 pd-tp2"><table width="98%" border="0" align="center" cellpadding="0" cellspacing="0">
          
         
          <tr>
            <td width="33" align="left" valign="top">
				
				
				<table width="90%" border="0" cellspacing="0" cellpadding="0" >
              <tr>
                <th align="left" valign="middle" scope="col">
					<!--Auction Publishing Date-->
					Press Release Date
				</th>
              </tr>
              <tr>
                <td align="middle" valign="middle">
				<?php //echo date("d M-Y H:i:s A",strtotime($auctionData[0]->press_release_date));?>
					<?php if($auctionData[0]->press_release_date != '0000-00-00 00:00:00'){?>
                                  <?php echo date("Y-m-d",strtotime($auctionData[0]->press_release_date));?>
                    <?php }else{ ?>
				N.A
                    <?php } ?>
				 </td>
              </tr>
            </table></td>
            <td width="66%" colspan="2" align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <th align="center" valign="middle" scope="col">Inspection Date</th>
              </tr>
              <tr>
                <td align="left" valign="middle"><table width="100%" border="0" cellspacing="0" cellpadding="0" class="table-bor">
                  <tr>
                    <th align="center" valign="middle" class="grey_bg">From</th>
                    <th align="center" valign="middle" class="grey_bg">To</th>
                  </tr>
			  <tr>
				<td align="center" valign="middle">
					<?php if($auctionData[0]->inspection_date_from != '0000-00-00 00:00:00'){?>
						<?php echo $auctionData[0]->inspection_date_from; //echo date("d M-Y H:i:s A",strtotime($auctionData[0]->inspection_date_from));?>
					<?php }else{ ?>
						N.A
					<?php } ?>
				</td>
				<td align="center" valign="middle">
					<?php if($auctionData[0]->inspection_date_to != '0000-00-00 00:00:00'){?>
						<?php echo $auctionData[0]->inspection_date_to; //echo date("d M-Y H:i:s A",strtotime($auctionData[0]->inspection_date_to));?>
					<?php }else{ ?>
						N.A
					<?php } ?>
				</td>
			  </tr>
                </table></td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td colspan="3" align="left" valign="top">&nbsp;</td>
          </tr>
          <tr>
            <td width="33%" align="left" valign="top"><table width="90%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <th align="left" valign="middle" scope="col">Offer Submission Last Date</th>
              </tr>
              <tr>
                <td align="left" valign="middle"><?php echo $auctionData[0]->bid_last_date; //echo date("d M-Y H:i:s A",strtotime($auctionData[0]->bid_last_date));?> </td>
              </tr>
            </table></td>
            <td width="33%" align="left" valign="top"><table width="98%" border="0" cellspacing="0" cellpadding="0" class="table-bor">
              <tr>
                <th colspan="2" align="center" valign="middle" class="grey_bg pd-tp">Auction Start Date</th>
              </tr>
              <tr>
                <td width="40%" align="center" valign="middle">Actual</td>
                <td width="60%" align="center" valign="middle"><?php echo $auctionData[0]->auction_start_date;   //echo date("d M-Y H:i:s A",strtotime($auctionData[0]->auction_start_date));?> </td>
              </tr>
            </table></td>
            <td width="33%" align="left" valign="top"><table width="98%" border="0" align="right" cellpadding="0" cellspacing="0" class="table-bor">
              <tr>
                <th colspan="2" align="center" valign="middle" class="grey_bg pd-tp">Auction End Date</th>
              </tr>
              <tr>
                <td width="40%" align="center" valign="middle">Actual</td>
                <td width="60%" align="center" valign="middle"><?php echo $auctionData[0]->auction_end_date; //echo date("d M-Y H:i:s A",strtotime($auctionData[0]->auction_end_date));?> </td>
              </tr>
            </table></td>
          </tr>
          <tr>
            <td colspan="3" align="left" valign="top">&nbsp;</td>
          </tr>
          <tr>
            <td width="33%" align="left" valign="top"><table width="90%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <th align="left" valign="middle" scope="col">Bid Opened On </th>
              </tr>
              <tr>
                <!--<td align="left" valign="middle"><?php //echo date("d M-Y H:i:s A",strtotime($auctionData[0]->bid_opening_date));?> </td>-->
                <td align="left" valign="middle"><?php echo $auctionData[0]->bid_opening_date;?> </td>
              
              </tr>
            </table></td>
            <td width="66%" colspan="2" align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0" class="table-bor">
              <tr>
                <th align="center" valign="middle" class="grey_bg">First Opener </th>
                <th align="center" valign="middle" class="grey_bg">Second Opener </th>
              </tr>
              <tr>
                <td align="center" valign="middle">
				<?php 
				if($auctionData[0]->first_opener){
				echo $first_opener=ucfirst(GetTitleByField('tbl_user', "id='".$auctionData[0]->first_opener."'", 'first_name'));
				echo " ".$first_opener=ucfirst(GetTitleByField('tbl_user', "id='".$auctionData[0]->first_opener."'", 'last_name'));
				}else{
					echo "N.A";
				}
				?>	
				</td>
                <td align="center" valign="middle"><?php 
				if($auctionData[0]->second_opener){
				echo $second_opener=ucfirst(GetTitleByField('tbl_user', "id='".$auctionData[0]->second_opener."'", 'first_name'));
				echo " ".$second_opener=ucfirst(GetTitleByField('tbl_user', "id='".$auctionData[0]->second_opener."'", 'last_name'));
				}else{
					echo "N.A";
				}
				?></td>
              </tr>
            </table></td>
          </tr>
          
          
          
          <?php if($auctionData[0]->status == '6' || $auctionData[0]->status == '3' || $auctionData[0]->status == '4' || $auctionData[0]->status == '7') { 
			  
				if($auctionData[0]->status == '6' || $auctionData[0]->status == '7')
				{
					$auctionStatus = 'Completed';
				}
				if($auctionData[0]->status == '4')
				{
					$auctionStatus = 'Canceled';
				}
				if($auctionData[0]->status == '3')
				{
					$auctionStatus = 'Stay';
				}
			  
			  ?>
          
          <tr>
            <td colspan="3" align="left" valign="top">&nbsp;</td>
          </tr>
          <tr>
            <td width="33%" align="left" valign="top"><table width="90%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <th align="left" valign="middle" scope="col">Auction Status </th>
              </tr>
              <tr>
                <!--<td align="left" valign="middle"><?php //echo date("d M-Y H:i:s A",strtotime($auctionData[0]->bid_opening_date));?> </td>-->
                <td align="left" valign="middle"></td>
              
              </tr>
            </table></td>
            <td width="66%" colspan="2" align="left" valign="top"><table width="100%" border="0" cellspacing="0" cellpadding="0" class="table-bor">
              <tr>
                <th align="center" valign="middle" class="grey_bg"><?php echo $auctionStatus; ?></th>
                <th align="center" valign="middle" class="grey_bg"></th>
              </tr>
              <tr>
                <td align="center" valign="middle">
				<?php 
				
				?>	
				</td>
                <td align="center" valign="middle">
					</td>
              </tr>
            </table></td>
          </tr>
          
          <?php } ?>
          
          
          
          
          
        </table></td>
      </tr>
    </table></td>
    
  </tr>
	
  <tr>
    <td align="left" valign="top" scope="col">&nbsp;</td>
  </tr>
  <tr>
    <td align="left" valign="top" scope="col"><h1>Bid Details</h1></td>
  </tr>
  <tr>
    <td align="left" valign="top" scope="col">&nbsp;</td>
  </tr>
  
  
  
  <tr>
    <td align="left" valign="middle"><h2>Bidder/Organization Participated </h2></td>
  </tr>
  <?php
     $totalbidder_participate=count($auctionData[0]->bidder);
	if($totalbidder_participate>0){	
  ?>
  <tr>
    <td align="left" valign="top">
		<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" class="table-bor">
        <thead>
          <tr>
            <th width="25%" align="center" valign="middle" scope="col">Bidders Name</th>
            <th width="25%" align="center" valign="middle" scope="col">FRQ Participated</th>
            <th width="25%" align="center" valign="middle" scope="col">Auction Training Received</th>
            <th width="25%" align="center" valign="middle" scope="col">Auction Participated</th>
          </tr>
        </thead>
        <tbody>
		     <?php
		      $i=1;
		      $nobidderparticipate = true;
                     foreach($auctionData[0]->bidder as $bidderPar){
			$FRQParticipated=$this->banker_model->checkBidderIsFRQParticipate($bidderPar->auctionID,$bidderPar->bidderID);
			
			$BidParticipated=$this->banker_model->getLoggedInBidderType($auctionData[0]->id,$bidderPar->bidderID);           //New Condition
			
                         if(GetTitleById('tbl_user_registration',$bidderPar->bidderID,'register_as')=='builder'){
                            $bidderName=GetTitleById('tbl_user_registration',$bidderPar->bidderID,'organisation_name'); 
                          }else{
                            $bidderName=ucfirst(GetTitleById('tbl_user_registration',$bidderPar->bidderID,'first_name'))." ".ucfirst(GetTitleById('tbl_user_registration',$bidderPar->bidderID,'last_name'));    
                          } 
                        $is_accept_auct_training = $bidderPar->is_accept_auct_training;
			$frq					 = $bidderPar->frq;
			if($i%2==0){$clas="odd";}else{$clas="even";}

                        if(($auctionData[0]->first_opener > 0) && ($auctionData[0]->second_opener<=0))
			{
				$participate_status=GetTitleByField('tbl_auction_participate', "bidderID='".$bidderPar->bidderID."' AND auctionID='".$auctionData[0]->id."'", 'operner1_accepted');
				if($participate_status>0){
				$bankerAccepted=1;	
				}else{
				$bankerAccepted=0;		
				}

			}else if(($auctionData[0]->second_opener > 0) && ($auctionData[0]->first_opener > 0))
			{
				
				$participate_status=GetTitleByField('tbl_auction_participate', "bidderID='".$bidderPar->bidderID."' AND auctionID='".$auctionData[0]->id."'", 'operner2_accepted');
				if($participate_status>0){
				$bankerAccepted=1;	
				}else{
				$bankerAccepted=0;		
				}
			}
			
			 $final_submit = GetTitleByField('tbl_auction_participate', "bidderID='" . $bidderPar->bidderID . "' AND auctionID='" . $auctionData[0]->id . "'", 'final_submit');
			 
         if($final_submit==1){	$nobidderparticipate =  false;
		?>
	  <tr class="<?php echo $clas;?>">
		<td align="center" valign="middle"><?php echo ucfirst($bidderName);?></td>
		<td align="center" valign="middle"><?php echo ($FRQParticipated>0)?'Yes':'No'?></td>
		<td align="center" valign="middle"><?php if($is_accept_auct_training==1){ echo 'Yes';}else{ echo 'No';}?></td>
		<td align="center" valign="middle"> <?php echo ($BidParticipated>0)?'Yes':'No' ?></td>
	  </tr>
			<?php
			$i++;
	          }
		}
		if($nobidderparticipate)
		{
				?>
					<tbody>
	  <tr class="">
		<td align="center" valign="middle" colspan='4'>No Bidder Participated</td>
	  </tr>
 
        </tbody>
				<?php
		}
		?>	  
         
        </tbody>
      </table></td>
  </tr>
  <tr>
    <td align="left" valign="top">&nbsp;</td>
  </tr>
 <?php }else{ 
	 
	?>
	<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" class="table-bor">
        <thead>
          <tr>
            <th width="25%" align="center" valign="middle" scope="col">Bidders Name</th>
            <th width="25%" align="center" valign="middle" scope="col">FRQ Participated</th>
            <th width="25%" align="center" valign="middle" scope="col">Auction Training Received</th>
            <th width="25%" align="center" valign="middle" scope="col">Auction Participated</th>
          </tr>
        </thead>
        <tbody>
	  <tr class="">
		<td align="center" valign="middle" colspan='4'>No Bidder Participated</td>
	  </tr>
 
        </tbody>
      </table>
	<?php
	
	 
	 } 
	 
	 ?>

  <br/>
    
  <tr>
    <td align="left" valign="middle"><h2>Auction - Last Bid Details</h2></td>
  </tr>
  <?php $Totlalast_allBid=count($auctionData[0]->lastbidBidder);
  if($Totlalast_allBid>0){ ?>
  <tr>
    <td align="left" valign="top"><table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" class="table-bor">
      <thead>
        <tr>
          <th width="25%" align="center" valign="middle" scope="col">Bidders Name</th>
          <th width="25%" align="center" valign="middle" scope="col">Bid Value</th>
          <th width="25%" align="center" valign="middle" scope="col">Rank </th>
          <th width="25%" align="center" valign="middle" scope="col">Bid Date & Time</th>
        </tr>
      </thead>
      <tbody>
	 <?php
	 $i=1;
	 foreach ($auctionData[0]->lastbidBidder as $last_allBidData){
              if(GetTitleById('tbl_user_registration',$last_allBidData->bidderID,'register_as')=='builder'){
                $bidderName=GetTitleById('tbl_user_registration',$last_allBidData->bidderID,'organisation_name'); 
              }else{
                $bidderName= ucfirst(GetTitleById('tbl_user_registration',$last_allBidData->bidderID,'first_name'));    
                $bidderName .= " ".ucfirst(GetTitleById('tbl_user_registration',$last_allBidData->bidderID,'last_name'));
              } 
	  // $bidderName=GetTitleByField('tbl_user_registration', "id='".$last_allBidData->bidderID."'", 'first_name');
	   if($i%2==0){$clas="odd";}else{$clas="even";}
                $rankID = array_search($last_allBidData->bidderID, $BidderRankData); // $key = 2;
		$rank="H".$rankID;
		?>
        <tr class="<?php echo $clas;?>">
          <td align="center" valign="middle"><?php echo ucfirst($bidderName);?></td>
          <td align="center" valign="middle"><?php echo $last_allBidData->bid_value;?></td>
           <td align="center" valign="middle"><?php echo $rank;?></td>
          <td align="center" valign="middle"><?php echo $last_allBidData->indate;?></td>
        </tr>
        
			
      <?php $i++; } ?>
      </tbody>
    </table></td>
  </tr>
  <tr>
    <td align="left" valign="top">&nbsp;</td>
  </tr>
  <?php } else{ 
	 
	?>
	<table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" class="table-bor">
        <thead>
          <tr>
            <th width="15%" align="center" valign="left" scope="col">Bidders Name</th>
          <th width="15%" align="center" valign="left" scope="col">Bid Value</th>
          <th width="15%" align="center" valign="left" scope="col">Rank </th>
          <th width="15%" align="center" valign="left" scope="col">Bid Date & Time</th>
          </tr>
        </thead>
        <tbody>
	  <tr class="<?php echo $clas;?>">
		<td align="center" valign="middle" colspan='4'>No Bid Received</td>
	  </tr>
 
        </tbody>
      </table>
	<?php
	
	 
	 } 
	 
	 ?>
  <br/>
 
  <tr>
    <td align="left" valign="middle"><h2>Auction - All Bids Received</h2></td>
  </tr>
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
          <th width="25%" align="center" valign="middle" scope="col">Bidders Name</th>
          <th width="25%" align="center" valign="middle" scope="col">Bid Value</th>
          <th width="25%" align="center" valign="middle" scope="col">Rank</th>
          <th width="25%" align="center" valign="middle" scope="col">Bid Date & Time</th>
        </tr>
      </thead>
	   <tbody>
	  <?php 
	  $i=1;
	  $companyArr = array();
	  $rankID = 1;
	  foreach ($auctionData[0]->bidder_bid as $allBidData){
	  if(GetTitleById('tbl_user_registration',$allBidData->bidderID,'register_as')=='builder'){
                $bidderName=GetTitleById('tbl_user_registration',$allBidData->bidderID,'organisation_name'); 
              }else{
                $bidderName=ucfirst(GetTitleById('tbl_user_registration',$allBidData->bidderID,'first_name')).' '.ucfirst(GetTitleById('tbl_user_registration',$allBidData->bidderID,'last_name'));    
                //$bidderName .= " ".GetTitleById('tbl_user_registration',$allBidData->bidderID,'last_name');
              } 
              
              if($i%2==0){$clas="odd";}else{$clas="even";}
		//$rankID = array_search($allBidData->bidderID, $BidderRankData); // $key = 2;
		$rank="H".$rankID;
		?>
     
        <tr class="<?php echo $clas;?>">
          <td align="center" valign="middle"><?php echo ucfirst($bidderName);?></td>
          <td align="center" valign="middle"><?php echo $allBidData->bid_value;?></td>
          <td align="center" valign="middle"><?php echo $rank;?></td>
          <td align="center" valign="middle"><?php echo $allBidData->indate;?></td>
        </tr>
        <?php 
			$allbidder = $this->banker_model->getBidderRankByTimestamp($allBidData->auctionID,$allBidData->indate);										
			foreach($allbidder as $key1=>$bid_detail1){
				if(!isset($companyArr[$bid_detail1->bidderID]))
				{
				  if(GetTitleById('tbl_user_registration',$bid_detail1->bidderID,'register_as')=='builder'){
					$bidderName=GetTitleById('tbl_user_registration',$bid_detail1->bidderID,'organisation_name'); 
				  }else{
					$bidderName= ucfirst(GetTitleById('tbl_user_registration',$bid_detail1->bidderID,'first_name')).' '.ucfirst(GetTitleById('tbl_user_registration',$bid_detail1->bidderID,'last_name'));    
					//$bidderName .= " ".ucfirst(GetTitleById('tbl_user_registration',$bid_detail1->bidderID,'last_name'));
				  }
				  
				  $companyArr[$bid_detail1->bidderID] = $bidderName;
				}              
              
				?>
			 
				<tr class="<?php echo $clas;?>">
				  <td align="center" valign="middle"><?php echo ucfirst($companyArr[$bid_detail1->bidderID]);?></td>
				  <td align="center" valign="middle"><?php echo $bid_detail1->maxValue;?></td>
				  <td align="center" valign="middle">H<?php echo $bid_detail1->rank;?></td>
				  <td align="center" valign="middle">&nbsp;</td>
				</tr>
				<?php											
			 }
		?>
	<?php
       if($i%25==0){ ?> 
        </tbody>
         </table>
        </td> 
        <tr>
       <td align="left" valign="top"><table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" class="table-bor">
      <thead>
        <tr>
          <th width="25%" align="center" valign="middle" scope="col">Bidders Name</th>
          <th width="25%" align="center" valign="middle" scope="col">Bid Value</th>
          <th width="25%" align="center" valign="middle" scope="col">Rank</th>
          <th width="25%" align="center" valign="middle" scope="col">Bid Date & Time</th>
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
            <th width="10%" align="center" valign="middle" scope="col">Bidders Name</th>
          <th width="10%" align="center" valign="middle" scope="col">Bid Value</th>
          <th width="10%" align="center" valign="middle" scope="col">Rank</th>
          <th width="10%" align="center" valign="middle" scope="col">Bid Date & Time</th>
          </tr>
        </thead>
        <tbody>
	  <tr class="<?php echo $clas;?>">
		<td align="center" valign="middle" colspan='4'>No Bid Received</td>
	  </tr>
 
        </tbody>
      </table>
	<?php
	
	 
	 } 
	 
	 ?>
   
</table>
<div style="text-align:center;">
*************************Report Ended*************************
</div>
<br/><br/>
<div style="text-align:center;">
Disclaimer: This is a system generated report hence does not need any signature.
</div>
<div style="text-align:center;font-size:11px;position:absolute;bottom:20px; left: 0px;">
	<i>C1india.com © Copyright 2016  <?php echo BRAND_NAME; ?>  - All Rights Reserved</i>
	<hr/>
	<span>
		<i>Plot No. 301, First Floor, Udyog Vihar, Phase - 2, Gurgaon (HR)-122015, Tel: +91-124-4302020 Fax: +91-124-4302010 www.c1india.com</i>
	</span>
</div>
</body>
</html>
