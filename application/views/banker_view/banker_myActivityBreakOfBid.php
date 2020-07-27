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
                      <div class="box-head">Item wise break up of bid</div>
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
								  }
								  $auctionNotPriceBasis = array(99);
								  
								  ?>
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
								  <td width="15%" align="left" valign="top" class=""><strong>Category</strong></td>
								  <td width="15%" align="left" valign="top" class=""><strong>Start price</strong></td>
								  <td width="15%" align="left" valign="top" class=""><strong>Increment in Figure</strong></td>
								</tr>
								<?php 		
								$plot_area_uom = GetTitleByField('tblmst_uom_type','uom_id='.$auction_data[0]->height_unit_id,'uom_name');						
								$area_uom = GetTitleByField('tblmst_uom_type','uom_id='.$auction_data[0]->area_unit_id,'uom_name');
								$unit_price = GetTitleByField('tblmst_uom_type','uom_id='.$auction_data[0]->unit_id_of_price,'uom_name');
								$category_name = GetTitleByField('tbl_category','id='.$auction_data[0]->category_id,'name');
                                ?>
								<tr class="even">
								  <td  align="left" valign="top" class="">1</td>
								  <td  align="left" valign="top" class=""><?php echo $auction_data[0]->PropertyDescription;  ?></td>
								  <td  align="left" valign="top" class=""><?php echo ($auction_data[0]->property_height != '')?$auction_data[0]->property_height:'N/A'; ?></td>
								  <td  align="left" valign="top" class=""><?php echo ($plot_area_uom != '')?$plot_area_uom:'N/A'; ?></td>
								  <td  align="left" valign="top" class=""><?php echo ($auction_data[0]->area != '')?$auction_data[0]->area:'N/A'; ?></td>
								  <td  align="left" valign="top" class=""><?php echo ($area_uom != '')?$area_uom:'N/A'; ?></td>
								  <?php if(!in_array($auction_data[0]->id,$auctionNotPriceBasis) && false) {?><td  align="left" valign="top" class=""><?php echo 'Price per '.$unit_price; ?></td><?php } ?>
								  <td  align="left" valign="top" class=""><?php echo $category_name;//'Actual'; ?></td>
								  <td  align="left" valign="top" class=""><?php echo moneyFormatIndia($auction_data[0]->opening_price); ?></td>
								  <td  align="left" valign="top" class=""><?php echo $auction_data[0]->bid_inc; ?></td>
								  
							  </tr>
							</tbody>             
						 </table>					
					</div>
                  </div>            
                 
                   <?php if(count($auction_data[0]->bidder_bid)){ ?>
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
								  <td width="20%" align="left" valign="top" class=""><strong>Bidders/ Vendor company name</strong></td>
								  <td width="15%" align="left" valign="top" class=""><strong>Rate in Rs</strong></td>
								  <td width="25%" align="left" valign="top" class=""><strong>Rate in Word</strong></td>
                                  <td width="5%" align="left" valign="top" class=""><strong>Rank</strong></td>
                                  <?php if(!in_array($auction_data[0]->id,$auctionNotPriceBasis) && false) {?><td width="15%" align="left" valign="top" class=""><strong>Total Value</strong></td><?php } ?>
								  <td width="15%" align="left" valign="top" class=""><strong>Bid Date & Time</strong></td>
								</tr>
								<?php 
								
								//echo '<pre>';print_r($auction_data[0]->lastbidBidder);
								
								//echo '<pre>';
								//print_r($auction_data[0]->lastbidBidder);
								$tVal = 0;
								foreach($auction_data[0]->lastbidBidder as $lastbidBidder)
								{ 
                                    $rankID = array_search($lastbidBidder->bidderID, $BidderRankData); // $key = 2;
							        //$rank="H".$rankID;
							        $rank=$rankID;
							        $area = $auction_data[0]->area;
							        $tVal = $area*$lastbidBidder->bid_value;
							        
									if($rankID>0)
									{                                    
										?>
										<tr class="even">
										  <td width="25%" align="left" valign="top" class="">
										  <?php
																		  
										   if(GetTitleById('tbl_user_registration',$lastbidBidder->bidderID,'register_as')=='builder'){
										  echo   $bidderName=GetTitleById('tbl_user_registration',$lastbidBidder->bidderID,'organisation_name'. ''); 
										  }else{
										   echo $bidderName=ucfirst(GetTitleById('tbl_user_registration',$lastbidBidder->bidderID,'first_name'));  
										   echo $bidderName= ucfirst(" ".GetTitleById('tbl_user_registration',$lastbidBidder->bidderID,'last_name'));   
										  } 
										 //  echo $lastbidBidder->first_name; 
										  ?></td>
																		  
										  <td align="left" valign="top" class=""><?php echo  moneyFormatIndia($lastbidBidder->bid_value); ?></td>
										  <td align="left" valign="top" class=""><?php echo getAmountInWords($lastbidBidder->bid_value);?></td>
										  <td align="left" valign="top" class=""><?php echo $rank;?></td>
										  <?php if(!in_array($auction_data[0]->id,$auctionNotPriceBasis) && false) {?><td align="left" valign="top" class=""><?php echo moneyFormatIndia($tVal);?></td><?php } ?>
										  <td align="left" valign="top" class=""><?php echo $lastbidBidder->indate; ?></td>
									  </tr>
										<?php 
									}
								}
								?>
							</tbody>             
						 </table>					
					</div>
                  </div>
				  <?php } ?>
				  <div class="table-wrapper btmrg20">                    
                    <div class="table-section"> 						
						 <table border="1" align="left" cellpadding="2" cellspacing="1" class="mytable dataTable" id="big_table" aria-describedby="big_table_info">
							<tbody role="alert" aria-live="polite" aria-relevant="all">
								<tr class="odd">
								  <td width="25%" align="left" valign="top" class="">
								  <a href="<?php echo base_url()?>buyer/allReport/<?php echo $auctionID;?>"><input class="b_submit float-left button_grey" type="button" value="Back" />
								  </td>	
								  <td width="25%" align="right" valign="top" class="3">
								  <a target="_blank" href="/pdfdata/genete_pdf_breakup_bids_report/<?php echo $auctionID;?>"><input class="b_submit float-left button_grey" type="button" value="Export To PDF" />
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
