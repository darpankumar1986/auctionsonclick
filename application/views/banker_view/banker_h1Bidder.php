<link rel="stylesheet" href="<?php echo base_url()?>/assets/css/jquery.dataTables.css">

<style>
	.body_main1{width:80%;}
	.row{padding: 5px 0%;}
</style>
<section class="body_main1">
  <?php 
  /*
  echo "<pre>";
  print_r($auction_data);
  die;*/
  ?>
  <form name="auction_awarded" id="auction_awarded" action="<?php echo base_url()?>buyer/save_awrd" method="post">
  <div class="row">
    <div class="wrapper-full">
      <div class="dashboard-wrapper">
        <div id="tab-pannel3" class="btmrgn">
			<?php if(isset($this->session->userdata['flash:old:message'])){?>
				<div class="success_msg"> <?php echo @$this->session->userdata['flash:old:message']; ?></div>
			<?php } ?>
			<?php //if(isset($this->session->userdata['flash:old:message_new'])){?>
				<div class="fail_msg"> <?php echo @$this->session->userdata['flash:old:message_new']; ?></div>
			 <?php //} ?>
          <div class="tab_container3">
            <!-- #tab1 -->
            <div id="tab6" class="tab_content3">
              <div class="container">
                <?php echo $leftPanel?>
                <div class="secttion-right">
                  <div class="table-wrapper btmrg20">
                    <div class="table-heading btmrg">
                      <div class="box-head">H1 Bid Details</div>
                    </div>
                  </div>
                    
                    
                <?php if(count($auction_data[0]->bidder_bid)){ ?>
                <div class="table-wrapper btmrg20">
                    <div class="table-section"> 
                        <table border="1" align="left" cellpadding="2" cellspacing="1" class="mytable dataTable" id="big_table" aria-describedby="big_table_info">
                            <tbody role="alert" aria-live="polite" aria-relevant="all">
                                <tr class="odd">
                                    <td width="5%" align="left" valign="top" class=""><strong>Sr.No.</strong></td>
                                    <td width="7%" align="left" valign="top" class=""><strong>Auction ID</strong></td>
                                    <td width="13%" align="left" valign="top" class=""><strong>Property ID</strong></td>
                                    <td width="20%" align="left" valign="top" class=""><strong>Property Address</strong></td>
                                    <td width="15%" align="left" valign="top" class=""><strong>H1 Bidder</strong></td>
                                    <td width="10%" align="left" valign="top" class=""><strong>H1 Price</strong></td>
                                    <td width="10%" align="left" valign="top" class=""><strong>Status</strong></td>
                                    <td width="15%" align="left" valign="top" class=""><strong>View</strong></td>
                                </tr>
                                
                                <?php
                                //echo '<pre>'; print_r($auction_data[0]->lastbidBidder);

                                foreach($auction_data[0]->lastbidBidder as $lastbidBidder)
                                { 
                                    $rankID = array_search($lastbidBidder->bidderID, $BidderRankData); // $key = 2;
                                    //echo $rankID;
                                    $rank="H".$rankID;
                                    $area_uom = GetTitleByField('tblmst_uom_type','uom_id='.$auction_data[0]->area_unit_id,'uom_name');
                                    $unit_price = GetTitleByField('tblmst_uom_type','uom_id='.$auction_data[0]->unit_id_of_price,'uom_name');
                                    $gainPrice = ($lastbidBidder->bid_value)-($auction_data[0]->opening_price);
                                    //$gainPer = round(($gainPrice/$auction_data[0]->opening_price)*100, 2);
                                    $totalbidding=$this->banker_model->CountAuctionBidingData($auctionID);
                                    $gainPer = ($gainPrice/$auction_data[0]->opening_price)*100;
                                    $gainPer = number_format((float)$gainPer, 2, '.', '');
                                                                    
                                    if($rankID == 1)
                                    {
					$awardedStatus = GetTitleByField('tbl_auction_participate',"bidderID='".$lastbidBidder->bidderID."' and auctionID='".$auction_data[0]->id."'",'awardedStatus');
									
                                        ?>
                                        <input type="hidden" name="bidderId" value="<?php echo $lastbidBidder->bidderID; ?>" />
                                        <input type="hidden" name="auctionId" value="<?php echo $auction_data[0]->id; ?>" />
                                            <tr class="even">
                                                <td  align="left" valign="top" class="">1</td>
                                                <td  align="left" valign="top" class=""><?php echo $auction_data[0]->id; ?></td>
                                                <td  align="left" valign="top" class=""><?php echo $auction_data[0]->reference_no; ?></td>
                                                <td  align="left" valign="top" class=""><?php echo $auction_data[0]->PropertyDescription; ?></td>
                                                <td  align="left" valign="top" class="">
                                                <?php
                                                 /*                 
                                                if(GetTitleById('tbl_user_registration',$lastbidBidder->bidderID,'register_as')=='builder'){
                                                    echo   $bidderName=GetTitleById('tbl_user_registration',$lastbidBidder->bidderID,'organisation_name'. ''); 
                                                    }else {
                                                  */
                                                    echo $bidderName=ucfirst(GetTitleById('tbl_user_registration',$lastbidBidder->bidderID,'first_name'));  
                                                    echo $bidderName= ucfirst(" ".GetTitleById('tbl_user_registration',$lastbidBidder->bidderID,'last_name'));   
                                                    // } 
                                                    //  echo $lastbidBidder->first_name; 
                                                ?></td>
                                                <td  align="left" valign="top" class=""><?php echo moneyFormatIndia($lastbidBidder->bid_value); ?></td>
                                                <td  align="left" valign="top" class=""><?php if($awardedStatus==1){echo 'Accepted';}else if($awardedStatus==2){echo 'Not Accepted';}else{echo 'Pending';} ?></td>
                                                <td  align="left" valign="top" class="">
                                                    <?php if($awardedStatus == 1){ ?>
                                                        <a href="<?php echo base_url()?>buyer/acceptanceBidderDetails/<?php echo $auctionID;?>/<?php echo $lastbidBidder->bidderID; ?>" target="_blank"><input class="b_submit float-left button_grey" type="button" value="Acceptance bidder" /></a>
                                                    <?php } else if($awardedStatus == 2) { ?>
                                                        <a href="" target="_blank"><input class="b_submit float-left button_grey" type="button" value="rejected bidder" /></a>
                                                    <?php } else {
                                                        echo '--';
                                                        } ?></td>            
                                            </tr>
					<?php  } } ?>
					</tbody>             
                                    </table>					
				</div>
                            </div>
                    
                    
                    <div class="table-wrapper btmrg20">                    
                    <?php if($awardedStatus=='') {?>  
                        <div class="table-section"> 						
                            <table border="1" align="left" cellpadding="2" cellspacing="1" class="mytable dataTable" id="big_table" aria-describedby="big_table_info">
                                <tbody role="alert" aria-live="polite" aria-relevant="all">
                                    <tr class="odd"><td colspan=2 align="center">Do you want to accept or reject the H1 bid?</td></tr>
                                    <tr class="odd">
                                        <td width="25%" align="right" valign="top" class="">
                                            <input name="awrd_accept" value="Accept" type="submit"  onclick="return confBox('accept');" class="b_submit float-left button_grey">
                                        </td>	
                                        <td width="25%" align="left" valign="top" class="3">
                                            <input name="awrd_reject" value="Reject" type="submit" onclick="return confBox('reject');" class="b_submit float-left button_grey">
                                        </td>								  
                                    </tr>
                                </tbody>             
                            </table>
			</div>
                    <?php  } ?>
                    
                    
                    <?php } else { ?>
                        <div class="table-section"> 						
                        <table border="1" align="left" cellpadding="2" cellspacing="1" class="mytable dataTable" id="big_table" aria-describedby="big_table_info">
                            <tbody role="alert" aria-live="polite" aria-relevant="all">
                                <tr class="odd"><td colspan=2 align="center">No bidder participated.</td></tr>
                            </tbody>             
                        </table>
                        </div>
                    <?php  } ?>
                    
                    <div class="table-section"> 						
                        <table border="1" align="left" cellpadding="2" cellspacing="1" class="mytable dataTable" id="big_table" aria-describedby="big_table_info">
                            <tbody role="alert" aria-live="polite" aria-relevant="all">								
                                <tr class="odd">								 
                                    <td align="left" valign="top" class="3">
                                        <a href="<?php echo base_url()?>buyer/eventTrack/<?php echo $auctionID;?>"><input class="b_submit float-left button_grey" type="button" value="Back" />
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
        </div>
      </div>
    </div>
  </div>
  </form>
</section>
<script>
	function confBox(val)
	{			
		if(val=='accept')
		{
			var cnf = confirm('Are you sure to accept the H1 bid?');
			if (cnf == true)
			{
				return true;
			} else {
				return false;
			}
		}
		else
		{
			var cnf = confirm('Are you sure to reject the H1 bid?');
			if (cnf == true)
			{
				return true;
			} else {
				return false;
			}
		}
	}
</script>
