<link rel="stylesheet" href="<?php echo base_url()?>/assets/css/jquery.dataTables.css">

<script>
jQuery(document).ready(function(){
	jQuery(".emd_detail_iframe").colorbox({iframe:true, width:"42%", height:"70%"});
	jQuery(".bidder_detail_iframe").colorbox({iframe:true, width:"42%", height:"70%"});
	jQuery(".doc_detail_iframe").colorbox({iframe:true, width:"42%", height:"40%"});
});
</script>
<section class="body_main1">
  <?php echo $breadcrumb;?>
  <div class="row">
    <div class="wrapper-full">
      <div class="dashboard-wrapper">
        <div id="tab-pannel3" class="btmrgn">
          <div class="tab_container3">
            <!-- #tab1 -->
            <div id="tab6" class="tab_content3">
              <div class="container">
                <?php echo $leftPanel?>
                <div class="secttion-right">
                  <div class="table-wrapper btmrg20">
                    <div class="table-heading btmrg">
                      <div class="box-head">Accepted Bids Report</div>
                    </div>
                    <div class="table-section">
						<table border="1" align="left" cellpadding="2" cellspacing="1" class="mytable dataTable" id="big_table" aria-describedby="big_table_info">
							<tbody role="alert" aria-live="polite" aria-relevant="all">
								<tr class="odd">
								  <td width="20%" align="left" valign="top" class=""><strong>Auction ID  : </strong></td>
								  <td width="30%" align="left" valign="top" class=""><?php echo $auction_data[0]->id; ?></td>
								  
								  <td width="20%" align="left" valign="top" class=""><strong>Property ID  :  </strong></td>
								  <td width="30%" align="left" valign="top" class=""><?php echo $auction_data[0]->reference_no; ?></td>
								</tr>								
								<tr class="even">
								  <td width="20%" align="left" valign="top" class=""><strong>Property Address  :   </strong></td>
								  <td width="30%" align="left" valign="top" class="" colspan=3><?php echo $auction_data[0]->PropertyDescription; ?></td>								  
								</tr>
								<tr class="even">
								  <td width="20%" align="left" valign="top" class=""><strong>Department  :   </strong></td>
								  <td width="30%" align="left" valign="top" class=""><?php echo BRAND_NAME; ?></td>
								  
								   <td width="20%" align="left" valign="top" class=""><strong>Officer  : </strong></td>
								  
								  <td width="30%" align="left" valign="top" class=""><?php 
								  if($auction_data[0]->second_opener)
								  {
									echo GetTitleByField('tbl_user','id='.$auction_data[0]->second_opener,'first_name');
									echo " ".GetTitleByField('tbl_user','id='.$auction_data[0]->second_opener,'last_name');
								  }?>
								  </td>
								</tr>
								<tr class="even">
								  <td width="20%" align="left" valign="top" class=""><strong>Start Date and Time  :   </strong></td>
								  <td width="30%" align="left" valign="top" class=""><?php echo date('d-m-Y H:i:s',strtotime($auction_data[0]->auction_start_date)); ?></td>
								  
								  <td width="20%" align="left" valign="top" class=""><strong>End Date And Time  :  </strong></td>
								  <td width="30%" align="left" valign="top" class=""><?php echo date('d-m-Y H:i:s',strtotime($auction_data[0]->auction_end_date)); ?></td>
								</tr>
							</tbody>
             
						 </table>
						
					</div>
                  </div>
                  <?php
                   $auctionNotPriceBasis = array(99);
                   //if(count($auction_data[0]->bidder_bid)){ ?>
                  <div class="table-wrapper btmrg20">
					  <table class="mytable dataTable">
						  <tr class="even">
							  <td>&nbsp;</td>
						  </tr>
					  </table>                   
                    <div class="table-section"> 
						<table border="1" align="left" cellpadding="2" cellspacing="1" class="mytable dataTable" id="big_table" aria-describedby="big_table_info">
							<tbody role="alert" aria-live="polite" aria-relevant="all">
								<tr class="odd">
								  <td width="7%" align="left" valign="top" class=""><strong>Sr. No.</strong></td>
								  <td width="58%" align="left" valign="top" class=""><strong>Property Details</strong></td>
								  <td align="left" valign="top" class=""><strong>Plot Area</strong></td>
								  <td align="left" valign="top" class=""><strong>Plot UOM</strong></td>
								  <td align="left" valign="top" class=""><strong>Carpet Area</strong></td>
								  <td align="left" valign="top" class=""><strong>Carpet UOM</strong></td>
								  <?php if(!in_array($auction_data[0]->id,$auctionNotPriceBasis) && false) {?><td width="15%" align="left" valign="top" class=""><strong>Price Basis</strong></td><?php } ?>
								</tr>
								<?php 	
								$plot_area_uom = GetTitleByField('tblmst_uom_type','uom_id='.$auction_data[0]->height_unit_id,'uom_name');				
								$area_uom = GetTitleByField('tblmst_uom_type','uom_id='.$auction_data[0]->area_unit_id,'uom_name');
								$unit_price = GetTitleByField('tblmst_uom_type','uom_id='.$auction_data[0]->unit_id_of_price,'uom_name');							          
                                ?>
								<tr class="even">
								  <td  align="left" valign="top" class="">1</td>
								  <td  align="left" valign="top" class=""><?php echo $auction_data[0]->PropertyDescription;  ?></td>
								  <td  align="left" valign="top" class=""><?php echo ($auction_data[0]->property_height != '')?$auction_data[0]->property_height:'N/A'; ?></td>
								  <td  align="left" valign="top" class=""><?php echo ($plot_area_uom != '')?$plot_area_uom:'N/A'; ?></td>
								  <td  align="left" valign="top" class=""><?php echo ($auction_data[0]->area != '')?$auction_data[0]->area:'N/A'; ?></td>
								  <td  align="left" valign="top" class=""><?php echo ($area_uom != '')?$area_uom:'N/A'; ?></td>
								   <?php if(!in_array($auction_data[0]->id,$auctionNotPriceBasis) && false) {?><td  align="left" valign="top" class=""><?php echo 'Price per '.$unit_price; ?></td><?php } ?>
							  </tr>
							</tbody>             
						 </table>					
					</div>
                  </div>                  
				  <?php //} ?>
                   <?php if(count($auction_data[0]->bidder_bid)){ ?>
                 <table class="mytable dataTable">
						  <tr class="even">
							  <td>&nbsp;</td>
						  </tr>
					  </table>              
                  <div class="table-wrapper btmrg20">                   
                    <div class="table-section"> 
						<table border="1" align="left" cellpadding="2" cellspacing="1" class="mytable dataTable" id="big_table" aria-describedby="big_table_info">
							<tbody role="alert" aria-live="polite" aria-relevant="all">
								<tr class="odd">
								  <td width="7%" align="center" valign="top" class=""><strong>Sr. no. </strong></td>
								  <td width="25%" align="center" valign="top" class=""><strong>Bidders/ Company Name </strong></td>
								  <td width="13%" align="center" valign="top" class=""><strong>Bid Amount </strong></td>
								  <td width="15%" align="center" valign="top" class=""><strong>Bid Date & Time </strong></td>
								  <!--<td width="25%" align="center" valign="top" class=""><strong>Rank </strong></td>-->
								  <td width="15%" align="center" valign="top" class=""><strong>IP address </strong></td>
								  <td width="15%" align="center" valign="top" class=""><strong>Bid status </strong></td>
								  <td width="10%" align="center" valign="top" class=""><strong>Remarks </strong></td>
								  
								</tr>
								
								<?php 
								//echo '<pre>';
								//print_r($auction_data[0]->bidder_bid);
								?>
								<?php 
								$i=1;
								foreach($auction_data[0]->bidder_bid as $key=>$bid_detail){
							$rankID = array_search($bid_detail->bidderID, $BidderRankData); // $key = 2;
							$millDateArr = explode('.',$bid_detail->modified_date);
							$millDate = date('d-m-Y H:i:s',strtotime($millDateArr[0]));
							$millDateNew = $millDate.'.'.substr($millDateArr[1],0,3);
							//$rank="H".$rankID;
                                                     
							$rank="H1";
									?>
								<tr class="even">
								  <td align="center" valign="top" class=""><?php echo $i;?></td>
								  <td align="center" valign="top" class=""><?php 
								  //if($bid_detail->bidderID)
								  //echo GetTitleByField('tbl_user_registration','id='.$bid_detail->bidderID,'first_name')?>
								   <?php
									  echo ucfirst($bidderName=GetTitleById('tbl_user_registration',$bid_detail->bidderID,'first_name'));    
									  echo " ".ucfirst($bidderName=GetTitleById('tbl_user_registration',$bid_detail->bidderID,'last_name'));
									  echo '<br>';
									  echo '('.$bidderName=GetTitleById('tbl_user_registration',$bid_detail->bidderID,'email_id').')';
								 //  echo $lastbidBidder->first_name; 
								  ?>                                                                  
								  </td>
								  <td align="center" valign="top" class=""><?php echo moneyFormatIndia($bid_detail->bid_value); ?></td>
								  <!--<td align="center" valign="top" class=""><?php //echo $rank?></td>-->
								  <td align="center" valign="top" class=""><?php echo $millDateNew; ?></td>
								  <td align="center" valign="top" class=""><?php echo $bid_detail->ip; ?></td>
								  <td align="center" valign="top" class=""><?php echo 'Accepted'; ?></td>
								  <td align="left" valign="top" class=""><?php echo '-'; ?></td>						
								</tr>
								<?php $i++; } ?>
							</tbody>             
						 </table>
					</div>
                  </div>
				  <?php }?>
				  <div class="table-wrapper btmrg20">                    
                    <div class="table-section"> 						
						 <table border="1" align="left" cellpadding="2" cellspacing="1" class="mytable dataTable" id="big_table" aria-describedby="big_table_info">
							<tbody role="alert" aria-live="polite" aria-relevant="all">
								<tr class="odd">
								  <td width="25%" align="left" valign="top" class="">
								  <a href="<?php echo base_url()?>buyer/allReport/<?php echo $auctionID;?>"><input class="b_submit float-left button_grey" type="button" value="Back" />
								  </td>	
								  <td width="25%" align="right" valign="top" class="3">
								  <a target="_blank" href="/pdfdata/genete_pdf_accepted_bid_report/<?php echo $auctionID;?>"><input class="b_submit float-left button_grey" type="button" value="Export To PDF" />
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
</section>
