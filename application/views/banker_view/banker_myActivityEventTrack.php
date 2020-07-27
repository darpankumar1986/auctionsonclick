<link rel="stylesheet" href="<?php echo base_url();?>bankeauc/css/tables.css" type="text/css" media="screen"/>	
<section class="container_12">
	<div class="row">
		<div class="wrapper-full">
			<div class="dashboard-wrapper">
				<div id="tab-pannel3" class="btmrgn">
				  <div class="tab_container3">
					<!-- #tab1 -->
					<div id="tab61" class="tab_content3">
					  <div class="container">
						<div class="secttion-right">
						  <div class="table-wrapper btmrg20">
							<div class="table-heading btmrg">
								<div class="event_tracker_heading">Auction Tracker</div>
							</div>
							<div class="table-section"> 
								<!-- -->
								<?php
								 /*
								echo "<pre>";
								print_r($auction_data);die;
								*/
									$date = @strtotime(date('Y-m-d H:i:s'));	
									
									$bid_last_date = ($auction_data[0]->bid_last_date)?strtotime($auction_data[0]->bid_last_date):0;
								
									$bid_opening_date = ($auction_data[0]->bid_opening_date)?strtotime($auction_data[0]->bid_opening_date):0;		
									
									$auction_start_date = ($auction_data[0]->auction_start_date)?strtotime($auction_data[0]->auction_start_date):0;
									
									$auction_end_date = ($auction_data[0]->auction_end_date)?strtotime($auction_data[0]->auction_end_date):0;
									
									if($auction_data[0]->status==7 || $auction_data[0]->status==3 || $auction_data[0]->status==4 || $auction_data[0]->stageID ==7){
										$currentStatus = 7;
									}
									elseif($auction_data[0]->status==8 || $auction_data[0]->stageID==8)
									{									
										$currentStatus = 8;
									}
									//elseif($auction_data[0]->status!=1){ // 
									elseif($auction_data[0]->status!=1 && $auction_data[0]->status!=6 ){
										$currentStatus = 1;
									}elseif($auction_end_date<$date){										
										$currentStatus = 6;
									}elseif($auction_data[0]->stageID>3){
										$currentStatus = $auction_data[0]->stageID;
									}elseif($date<=$bid_last_date){
										$currentStatus = 2;
									}elseif($date>$bid_last_date && $date<$auction_start_date){
										$currentStatus = 5;
									}/*elseif($date>$bid_last_date && $date<$auction_start_date && $auction_data[0]->stageID==3){
										$currentStatus = 4;
									}elseif($auction_data[0]->stageID==4){
										$currentStatus = 5;
									}*/
									elseif($date>=$auction_start_date && $date<=$auction_end_date){
										$currentStatus = 6;
									}
									
									else{
										$currentStatus = 1;
									}
									$user_id=$this->session->userdata('id');									
									//echo $auction_data[0]->stageID.'<br />';
									//echo 'auction_start_date :'.$auction_start_date.'<br />';
									//echo 'auction_end_date :'.$auction_end_date.'<br />';
									//echo 'date :'.$date.'<br />';
									
								?>
				  <div class="row " style="text-align:center; cursor:pointer; color:#00F;  font-size:12px;"><a href="#inline_content" class="grn-txt float-right b_showevent inline_auctiondetail" style="text-decoration:none;">Show Auction details</a>
				  <!--<a id="displayText"  onclick="javascript:toggle();">Hide Event Details</a>--></div>
				  <div class="container_12">	
				<div class="container_12">						
					<div class="container_12">
						<div class="container_12">
							<!--<div class="error1">Please Submit the Documents.</div>-->
							<section class="ac-container">
								<div>
								<input id="ac-1" name="accordion-1" type="radio" <?php echo ($currentStatus==1)?'checked':'';?>  />
								<label for="ac-1"><span class="size_18">1</span>
									Auction Creation
									<?php if($currentStatus==1){ ?>
										<span class="current_stage">Current Stage</span>
									<?php } ?>	
										</label>
										<article class="ac-small">											
											<p>Last Updated : <?php echo ($auction_data[0]->updated_date=='0000-00-00 00:00:00')?'':date('d-m-Y H:i:s',strtotime($auction_data[0]->updated_date))?></p>
											<?php //echo $currentStatus; ?>
											<?php if($currentStatus==1)
											{
												?>
											<p>
                                                <?php /*	<?php if($this->banker_model->checkPageBidderPermission('createEvent'))
												{
													if($auction_data[0]->approvalStatus != 1)
													{	
													?>
														<a href="/<?php echo $controller;?>/createEvent/<?php echo $auction_data[0]->id?>">Edit Auction</a>
													<?php 
													}
													else
													{
														echo 'Auction Pending for Approval';
													}
												} ?> */ ?>
												
												<?php if($this->banker_model->checkPageBidderPermission('createEvent'))
												{
													if($this->session->userdata('role_id')==1)
													{
														if($auction_data[0]->approvalStatus != 1)
														{ 
															if($auction_data[0]->approvalStatus == 2){ ?>
																<a href="/<?php echo $controller;?>/viewEvent/<?php echo $auction_data[0]->id?>">Publish Auction</a>
															<?php }else{ ?>
															<a href="/<?php echo $controller;?>/createEvent/<?php echo $auction_data[0]->id?>">Edit Auction</a>
													   <?php }
														}
														else
														{
															echo 'Auction Pending for Approval';
														}
													}
												} ?>                
                                                                                                                
                                                                                                                
												<?php 
												if($this->session->userdata('role_id')==2)
												{
													if($this->banker_model->checkPageBidderPermission('approveRejectEvent') && $auction_data[0]->approvalStatus ==1)
													{
												?>
														<a href="/<?php echo $controller;?>/approveRejectEvent/<?php echo $auction_data[0]->id?>">Approve/ Reject Auction</a>
												<?php 
													} 
												}
												?>
											</p>
											<?php }?>
											<!--<p><a href="CreateEvent.html">Edit Event</a></p>-->
										</article>
								</div>
								
								<!--
								<div>
								<input id="ac-2" name="accordion-1" type="radio" <?php echo ($currentStatus==2)?'checked':'';?> />
								<label for="ac-2"><span class="size_18">2</span>
								Bid Submission
									<?php if($currentStatus==2){ ?>
										<span class="current_stage">Current Stage</span>
									<?php } ?>
									
									</label>
									<article class="ac-small">
										<p>Apply And EMD End Date & Time : <?php echo date('d-m-Y H:i:s',strtotime($auction_data[0]->bid_last_date))?></p>
										<p>No. of Bids received : <?php echo count($auction_data[0]->bider_detail)?></p>
								</article>
								</div>-->
								
								<div>
								<input id="ac-2" name="accordion-1" type="radio" <?php echo ($currentStatus==2)?'checked':'';?> />
								<label for="ac-2"><span class="size_18">2</span>
											Bid Submission, Payment and Document Verification
												<?php if($currentStatus==2){ ?>
													<span class="current_stage">Current Stage</span>
												<?php } ?>
												
									</label>
        <script type="text/javascript">
         function opendiv(auctionID)
         {
           jQuery.ajax({
                url: '/buyer/movetoauction',
                type: 'POST',
                data: {
                        auctionID:auctionID,
                        type:"opening",
                        message:"EMD/Payment verifier opened Bid"
                    },
                success: function(data) {
                                //location=location;
                                //alert(data);
                }
            });	  
         }
        </script>
									<article class="ac-small">
									<!--<p>Name of first Opener : <?php //echo GetTitleById('tbl_user',$auction_data[0]->first_opener,'first_name')?></p>-->
									<p>Apply And EMD End Date & Time : <?php echo date('d-m-Y H:i:s',strtotime($auction_data[0]->bid_last_date))?></p>
									<!-- <p>Date & Time of Opening : <?php // echo  date('d-m-Y H:i:s',strtotime($auction_data[0]->bid_opening_date));?></p> -->
									<p>No. of Bids received : <?php echo count($auction_data[0]->bider_detail)?></p>
									
									
									<?php 		
									//if($auction_data[0]->open_price_bid!=1){
									
									if($currentStatus==2 && strtotime($auction_data[0]->bid_opening_date) > @strtotime(date('Y-m-d H:i:s')) ){ // && $this->session->userdata('role_id')==3
										?>
									<p style="color:red">
									  Shortlisting time not reached yet
									  </p>
					
									<?php } 
									else{
										if($currentStatus==2 && $this->session->userdata('role_id')==3)
										{	
											
											//if($auction_data[0]->bider_detail[0]->payment_move_to_opener2 !=1)
												{
											?>
												<p>
												<a href="#inline_content5" class="inline_auctiondetail5"  onclick="opendiv(<?=$auction_data[0]->id;?>);" style="text-decoration:none; outline:none;">Click here to EMD/Payment Verification</a>
												</p>
											<?php 
												}
												
										}
										
										if($this->session->userdata('role_id')==5) //$currentStatus==2  && 
										{
											if($auction_data[0]->doc_to_be_submitted != 0)
											{
												//if($auction_data[0]->bider_detail[0]->opener1_move_to_opener2 !=1)
												{
										?>
													<p>
													<!--<a href="#inline_content1" class="inline_auctiondetail1"  onclick="opendiv(<?=$auction_data[0]->id;?>);" style="text-decoration:none; outline:none;">Click here to Document Verification</a>-->
													<a href="<?php echo base_url();?>buyer/add_bidder_live_auction/<?php echo $auction_data[0]->id;?>">Click here to Document Verification</a>
													</p>
										<?php 
												}
											}
											else
											{
												?>
												<p style="color:#ff0000;">Document Verification not required for this Auction </p>
												<?php
											}
											
										}
										
									}?>
									</article>
								</div>	
								<!--			
								<div>				
								<input id="ac-4" name="accordion-1" type="radio" <?php echo ($currentStatus==4)?'checked':'';?>  />
								<label for="ac-4"><span class="size_18">4</span>
											Opening - First Opener
											<?php if($currentStatus==4){ ?>
													<span class="current_stage">Current Stage</span>
												<?php } ?>
											</label>
												<script type="text/javascript">
												 function opendiv(auctionID){
													   jQuery.ajax({
																url: '/buyer/movetoauction',
																type: 'POST',
																data: {
																	   auctionID:auctionID,
																	   type:"opening",
																	   message:"Buyer opened Bid"
																	   },
																success: function(data) {
																		//location=location;
																		//alert(data);
																}
														});	  
															}
												</script>
												<article class="ac-small">
												<!--<p>Name of first Opener : <?php //echo GetTitleById('tbl_user',$auction_data[0]->first_opener,'first_name')?></p>-->
												<!--<p>Date & Time of Opening : <?php echo  date('d M Y H:i:s',strtotime($auction_data[0]->bid_opening_date));?></p>
												<p>No. of Bids received : <?php echo count($auction_data[0]->bider_detail)?></p>
												<?php 
					
													//if($auction_data[0]->open_price_bid!=1){
													
													if($currentStatus==4 && strtotime($auction_data[0]->bid_opening_date) > @strtotime(date('Y-m-d H:i:s')) and $auction_data[0]->first_opener==$user_id){?>
													<p style="color:red">
													  Opening time not reached yet
													  </p>
									
													<?php }elseif($currentStatus==4  and $auction_data[0]->first_opener==$user_id){?>
													<p>
													<a href="#inline_content1" class="inline_auctiondetail1"  onclick="opendiv(<?=$auction_data[0]->id;?>);" style="text-decoration:none; outline:none;">Click here to Open Bid</a>
													</p>
													<?php }?>
												</article>
								</div>-->
												
								<div>				
								<input id="ac-5" name="accordion-1" type="radio"  <?php echo ($currentStatus==5)?'checked':'';?>/>
								<label for="ac-5"><span class="size_18">3</span>
							Bid Opening - Approver
							<?php if($currentStatus==5){ ?>
									<span class="current_stage">Current Stage</span>
								<?php } ?>
							</label>
								<article class="ac-small">
									<!--<p>Name of Second Opener : <?php //echo GetTitleById('tbl_user',$auction_data[0]->second_opener,'first_name')?></p>-->
								<!--<p>Shortlisting Start Date & Time : <?php // echo date('d-m-Y H:i:s',strtotime($auction_data[0]->bid_opening_date));?></p> -->
									<p>No. of Bids received : <?php echo count($auction_data[0]->bider_detail)?></p>									
									 <?php 
										
									   //if($auction_data[0]->open_price_bid!=1){
									   
									   if($currentStatus==5 && $auction_data[0]->bider_total==0  and $auction_data[0]->second_opener==$user_id){?>
										<p>
										  <a href="javascript:void(0)" onClick="return concludeEvent(<?php echo $auction_data[0]->id?>)" >Click here to Conclude Auction</a>
										   
										</p>
										<?php }elseif($this->session->userdata('role_id')==2){ //$currentStatus==5 &&  ?> 
										<p>
										  <!--<a href="#inline_content2" class="inline_auctiondetail2">Click here to Open Bid</a>-->
										   <a href="<?php echo base_url();?>buyer/add_bidder_live_auction/<?php echo $auction_data[0]->id;?>">Click here to Open Bid</a>
										</p>
										<?php }
									   //}
										?>
								</article>
								</div>
								<div>				
									<input id="ac-6" name="accordion-1" type="radio"  <?php echo ($currentStatus==6)?'checked':'';?>/>
									<label for="ac-6"><span class="size_18">4</span>
									Auction
									<?php if($currentStatus==6){ ?>
											<span class="current_stage">Current Stage</span>
										<?php } ?>
									</label>
									<article class="ac-small">
										<!--<p>No. of Bidders : <?php //echo $auction_data[0]->auction_bider_total; ?></p>-->
										<p>Auction Start Date & Time : <?php echo date('d-m-Y H:i:s',strtotime($auction_data[0]->auction_start_date));?></p>
										<p>Auction End Date & Time : <?php echo date('d-m-Y H:i:s',strtotime($auction_data[0]->auction_end_date));?></p>
										<!--<p>Auto Extension time : <?php //echo $auction_data[0]->auto_extension_time?></p>-->
										<?php if($date>=$auction_start_date && $date<=$auction_end_date){?>
										<p>
											  <a href="/buyer/listLiveAuctions/<?php echo $auction_data[0]->id?>">View Auction</a>
											</p>
										<?php }else if($date<=$auction_end_date){?>
												<p class="txt" style="color:red">Auction yet to be started.</p>
										<?php }?>
									</article>
								</div>

												
								<div>				
								<input id="ac-7" name="accordion-1" type="radio"  <?php echo ($currentStatus==7)?'checked':'';?>/>
								<label for="ac-7"><span class="size_18">5</span>
								<!--Post Auction & -->Reports
								<?php if($currentStatus==7){ ?>
										<span class="current_stage">Current Stage</span>
								<?php } ?>
								</label>
								<article class="ac-small">
									<?php if($currentStatus>=7){?>										
									<p><a href="/buyer/allReport/<?php echo $auction_data[0]->id?>">Report</a></span> available for downloads of auction.</p>									
									<?php }else{?>
									 <p> Report will be available for downloads after completion of auction.</p>
									<?php }?>
								</article>			
								</div>				
								
								
								<div>				
								<input id="ac-8" name="accordion-1" type="radio"  <?php echo ($currentStatus==8)?'checked':'';?>/>
								<label for="ac-8"><span class="size_18">6</span>
								Post Auction
								<?php if($currentStatus==8){ ?>
										<span class="current_stage">Current Stage</span>
								<?php } ?>
								</label>
								<article class="ac-small">
									<?php if(true){?>
										<p><a href="/buyer/banker_h1Bidder/<?php echo $auction_data[0]->id?>">Click here</a> for accept/reject H1 Bid</span></p>
										<?php 
										$awardedStatus    =    $auction_data[0]->bider_detail;										
										if($awardedStatus[0]->awardedStatus == 1 && false){?>
										<p><a href="/buyer/input_credit_details/<?php echo $auction_data[0]->id?>">Click here</a> for add input credit details.</span></p>
										<p><a href="/buyer/create_demand_note/<?php echo $auction_data[0]->id?>">Click here</a> for add demand note.</span></p>
                                    <?php }?> 
										
									<?php }else{?>
									 <p></p>
									<?php }?>
								</article>			
								</div>		
					
							
							
							
				
			</section>
							<!-- <?php
								if($currentStatus==9){
								?>
								<div class="error1">Auction May be Stay/Cancel or Conclude</div>
								<?php } else{ ?>
								
								<div class="error1"> Auction Tracker shows at what stage the event is currently. You can also view the completed & next stages and navigate directly from this page.</div>
								<?php } ?>
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
				</div>
			</div>
		</div>
	</div>
</section>

<!-- Start: Auction Detail -->
<div class="row"  style="display:none;">
  <div id="inline_content">
  <div class="heading4 btmrg20">Auction Detail</div>
  <table border="1" align="left" cellpadding="2" cellspacing="1" class="mytable dataTable" id="big_table" aria-describedby="big_table_info">
    <tbody role="alert" aria-live="polite" aria-relevant="all">		
        <tr class="even">                  
            <td align="left" valign="top" class="" width="25%"><strong>Auction No. </strong></td>
            <td align="left" valign="top" class=""  colspan="3" width="25%"><?php echo $auction_data[0]->id?></td>
            <td align="left" valign="top" class="" width="25%"><strong>Institution</strong></td>
            <td align="left" valign="top" class=""  colspan="3" width="25%">
            <?php
                echo GetTitleByField('tblmst_account_type', "account_id='".$auction_data[0]->account_type_id."'" ,'account_name');
            ?>  
            </td>
        </tr>
        
        <tr class="odd">
            <td align="left" valign="top" class=""><strong>Property ID </strong></td>
            <td align="left" valign="top" class=""  colspan="3"><?php echo $auction_data[0]->reference_no?></td>
            <td align="left" valign="top" class=""><strong>Auction Reference Dispatch Date</strong></td>
            <td align="left" valign="top" class=""  colspan="3"><?php echo (($auction_data[0]->dispatch_date != '1970-01-01') && ($auction_data[0]->dispatch_date != '0000-00-00')) ? date('d-m-Y', strtotime($auction_data[0]->dispatch_date)) : 'N/A'; ?></td>
        </tr>
       
        <tr class="even">
            <td align="left" valign="top" class=""><strong>Property Address</strong></td>
            <td align="left" valign="top" class="" colspan="3"><?php echo strtoupper($auction_data[0]->PropertyDescription);?></td>
            <td align="left" valign="top" class=""><strong>Carpet Area</strong></td>
            <td align="left" valign="top" class="" colspan="3"><?php echo ($auction_data[0]->area != '')?$auction_data[0]->area:'N/A';?></td>
        </tr>

        <tr class="odd">
            <td align="left" valign="top" class=""><strong>Carpet Area Unit</strong></td>
            <td align="left" valign="top" class="" colspan="3">
            <?php
                $cauom = GetTitleByField('tblmst_uom_type', "uom_id='".$auction_data[0]->area_unit_id."'" ,'uom_name');
                echo ($cauom !='')?$cauom:'N/A';
            ?>  
            </td>
            <td align="left" valign="top" class=""><strong>Category/ Property Type</strong></td>
            <td align="left" valign="top" class=""  colspan="3">
            <?php
            echo GetTitleByField('tbl_category', "id='".$auction_data[0]->category_id."'" ,'name');
            ?>
            </td> 
        </tr>
        
        <tr class="even">
            <td align="left" valign="top" class=""><strong>Plot Area</strong></td>
            <td align="left" valign="top" class="" colspan="3"><?php echo ($auction_data[0]->property_height != '')?$auction_data[0]->property_height:'N/A';?></td>
            <td align="left" valign="top" class=""><strong>Plot Area Unit</strong></td>
            <td align="left" valign="top" class="" colspan="3">
            <?php
				$cauom = GetTitleByField('tblmst_uom_type', "uom_id='".$auction_data[0]->height_unit_id."'" ,'uom_name');
                echo ($cauom !='')?$cauom:'N/A';
            ?>  
            </td>
        </tr>
        
        <tr class="even">
            
            <td align="left" valign="top" class=""><strong>Corner</strong></td>
            <td align="left" valign="top" class=""  colspan="3"><?php echo ($auction_data[0]->is_corner_property == 1) ? 'Yes' : 'No'; ?>
            </td>
            <td align="left" valign="top" class=""><strong>Scheme Id</strong></td>
            <td align="left" valign="top" class=""  colspan="3"><?php echo ($auction_data[0]->scheme_id)? $auction_data[0]->scheme_id: 'N/A';?></td>
            
        </tr>
        
        <tr class="odd">
            <td align="left" valign="top" class=""><strong>Scheme Name</strong></td>
            <td align="left" valign="top" class=""  colspan="3"><?php echo ($auction_data[0]->scheme_name)? $auction_data[0]->scheme_name: 'N/A';?></td>  
        <td align="left" valign="top" class=""><strong>Name of Owner/ Occupier as per MCG record</strong></td>
            <td align="left" valign="top" class=""  colspan="3"><?php echo ($auction_data[0]->service_no)? $auction_data[0]->service_no: 'N/A';?></td>
            
        </tr>
        
        <tr class="even">
            <td align="left" valign="top" class=""><strong>Concerned Zone</strong></td>
            <td align="left" valign="top" class=""  colspan="3">
            <?php
            echo GetTitleByField('tbl_zone', "zone_id='".$auction_data[0]->zone_id."'" ,'zone_name');
            ?>
            </td> 
            <td align="left" valign="top" class=""><strong>Applicable FAR</strong></td>
            <td align="left" valign="top" class=""  colspan="3"><?php echo ($auction_data[0]->far)? $auction_data[0]->far: 'N/A';?></td>
            
        </tr>
        
        <tr class="odd">
            <td align="left" valign="top" class=""><strong>Plot Area</strong></td>
            <td align="left" valign="top" class=""  colspan="3"><?php echo ($auction_data[0]->property_height)? $auction_data[0]->property_height: 'N/A';?></td>  
        <td align="left" valign="top" class=""><strong>Plot Area Unit</strong></td>
            <td align="left" valign="top" class=""  colspan="3">
            <?php
                $heightUnit = GetTitleByField('tblmst_height_uom_type', "height_uom_id='".$auction_data[0]->height_unit_id."'" ,'height_uom_name');
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
            <td align="left" valign="top" class=""  colspan="3"><?php echo ($auction_data[0]->max_coverage_area)? $auction_data[0]->max_coverage_area: "N/A";?></td>  
            <td align="left" valign="top" class=""><strong>Reserve Price</strong></td>
            <td align="left" valign="top" class=""  colspan="3"><?php echo $auction_data[0]->reserve_price;?>
            </td>
        </tr>
        
        <tr class="odd">
            
            <td align="left" valign="top" class=""><strong>Reserve Price (Unit)</strong></td>
            <td align="left" valign="top" class=""  colspan="3"><?php
                echo GetTitleByField('tblmst_uom_type', "uom_id='".$auction_data[0]->unit_id_of_price."'" ,'uom_name');
            ?> 
            </td>  
            <td align="left" valign="top" class=""><strong>EMD Amount</strong></td>
            <td align="left" valign="top" class=""  colspan="3"><?php echo $auction_data[0]->emd_amt;?>
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
            <td align="left" valign="top" class=""  colspan="3"><?php echo $auction_data[0]->tender_fee;?>
            </td>  
            <td align="left" valign="top" class=""><strong>Press Release Date</strong></td>
            <td align="left" valign="top" class=""  colspan="3">
            <?php echo date("d-m-Y",strtotime($auction_data[0]->press_release_date));?>
            </td>
        </tr>
        
        <tr class="odd">
            
            <td align="left" valign="top" class=""><strong>Site Visit Start Date</strong></td>
            <td align="left" valign="top" class=""  colspan="3">
                <?php echo (($auction_data[0]->inspection_date_from != '1970-01-01') && ($auction_data[0]->inspection_date_from != '0000-00-00 00:00:00')) ? date('d-m-Y  H:i', strtotime($auction_data[0]->inspection_date_from)) : 'N/A'; ?>
            </td>  
            <td align="left" valign="top" class=""><strong>Site Visit End Date</strong></td>
            <td align="left" valign="top" class=""  colspan="3">
                <?php echo (($auction_data[0]->inspection_date_to != '1970-01-01') && ($auction_data[0]->inspection_date_to != '0000-00-00 00:00:00')) ? date('d-m-Y H:i', strtotime($auction_data[0]->inspection_date_to)) : 'N/A'; ?>
            </td>
        </tr>
        <tr class="even">
            
            <td align="left" valign="top" class=""><strong>Apply And EMD Start Date</strong></td>
            <td align="left" valign="top" class=""  colspan="3">
                <?php echo date("d-m-Y H:i",strtotime($auction_data[0]->registration_start_date));?>
            </td> 
            <td align="left" valign="top" class=""><strong>Apply And EMD End Date</strong></td>
            <td align="left" valign="top" class=""  colspan="3">
                <?php echo date("d-m-Y H:i",strtotime($auction_data[0]->bid_last_date));?>
            </td>
        </tr>
        <tr class="odd">
            
            <td align="left" valign="top" class=""><strong>Auction Start date</strong></td>
            <td align="left" valign="top" class=""  colspan="3">
                <?php echo date("d-m-Y H:i",strtotime($auction_data[0]->auction_start_date));?>
            </td> 
            
            <td align="left" valign="top" class=""><strong>Auction End date</strong></td>
            <td align="left" valign="top" class=""  colspan="3">
                <?php echo date("d-m-Y H:i",strtotime($auction_data[0]->auction_end_date));?>
            </td> 
            
        </tr>
        
        <tr class="even">
            
            <td align="left" valign="top" class=""><strong>Mode of Bid</strong></td>
            <td align="left" valign="top" class=""  colspan="3">
               <?php echo ($auction_data[0]->mode_of_bid == 'online') ? 'Online' : 'Offline'; ?>
            </td>
             
            <td align="left" valign="top" class=""><strong>Is DSC Enabled </strong></td>
            <td align="left" valign="top" class=""  colspan="3">
                <?php echo ($auction_data[0]->dsc_enabled == 1) ? "Yes" : "No" ?>
            </td> 
        </tr>
        
         <tr class="odd">
           
            <td align="left" valign="top" class=""><strong>Auto Bid Allow</strong></td>
            <td align="left" valign="top" class=""  colspan="3">
                <?php echo ($auction_data[0]->auto_bid_cut_off == 1) ? "Yes" : "No" ?>
            </td>
            <td align="left" valign="top" class=""><strong>Bid Increment value</strong></td>
            <td align="left" valign="top" class=""  colspan="3">
                <?php echo $auction_data[0]->bid_inc;?>
            </td>
        </tr>
        
        <tr class="even">  
             <td align="left" valign="top" class=""><strong>Auto Extension time </strong>(In Minutes.)</td>
            <td align="left" valign="top" class=""  colspan="3"><?php echo ($auction_data[0]->auto_extension_time != '0') ? $auction_data[0]->auto_extension_time : "0"; ?>
            </td>
            
            <td align="left" valign="top" class=""><strong>Auto Extension(s)</strong></td>
            <td align="left" valign="top" class=""  colspan="3">
                <?php echo ($auction_data[0]->auto_extension_time >0 && $auction_data[0]->no_of_auto_extn == '0') ? "Unlimited": $auction_data[0]->no_of_auto_extn; ?>
            </td> 
        </tr>
        <tr class="odd">
            <td align="left" valign="top" class=""><strong>How to Reach</strong></td>
            <td td align="left" valign="top" class="" colspan="3"><a target="_blank" href="<?php echo base_url().'buyer/viewGoogleMap/'. $auction_data[0]->id;?>">View</a></td>
           <td align="left" valign="top" class=""><strong>1st Contact Person Details</strong></td>
            <td align="left" valign="top" class="" colspan="3"><?php echo $auction_data[0]->contact_person_details_1;?>
            </td>
        </tr>
        
        <tr class="even">
           <td align="left" valign="top" class=""><strong>2nd Contact Person Details</strong></td>
            <td align="left" valign="top" class="" colspan="3"><?php echo ($auction_data[0]->contact_person_details_2)?$auction_data[0]->contact_person_details_2: "N/A";?>
            </td>
            <td align="left" valign="top" class=""><strong>Any Documents Pertinent To The Auction</strong></td>
            <td align="left" valign="top" class=""  colspan="3">
                 <?php
                if ($auction_data[0]->doc_to_be_submitted) {
                    $docsubArr = explode(',', $auction_data[0]->doc_to_be_submitted);
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
                <?php echo ($auction_data[0]->remark)? $auction_data[0]->remark: "N/A";?>
            </td> 
            <td align="left" valign="top" class=""><strong>Auction Created by</strong></td>
        <td align="left" valign="top" class="" colspan="3">
            <?php
                  /*$sales_executive_id=GetTitleByField('tbl_event_log_sales', "id='".$auction_data[0]->eventID."'" ,'sales_executive_id');				
                  echo  GetTitleByField('tbl_user_registration', "id='".$sales_executive_id."'" ,'first_name');
                  echo " ";
                  echo  GetTitleByField('tbl_user_registration', "id='".$sales_executive_id."'" ,'last_name');*/

                  $sales_executive_id=GetTitleByField('tbl_auction', "id='".$auction_data[0]->id."'" ,'first_opener');				
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
                  $approver_id = GetTitleByField('tbl_auction', "id='".$auction_data[0]->id."'" ,'second_opener');				
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
 

<!--start Bid Open EMD verification-->
 
<div class="row"  style="display:none;">
	<div id="inline_content5">
		<div class="heading4 btmrg20">EMD/Payment Verification</div>
		<form id="bidopenerfrm5" name="paydoc" action="/buyer/paymentVerification" method="post" enctype="multipart/form-data" onsubmit="return validateopenerfrm('bidopenerfrm5');">
			<table border="1" align="left" cellpadding="2" cellspacing="1" class="mytable dataTable" id="big_table5" aria-describedby="big_table_info">
				<tbody role="alert" aria-live="polite" aria-relevant="all">
					<tr class="odd">
						<td width="10%" align="left" valign="top" class=""><strong>S/No.</strong></td>
						<td width="15%" align="left" valign="top" class=""><strong>Bidder Name </strong></td>
						<td width="30%" align="left" valign="top" class=""><strong>View </strong></td>
						<td width="15%" align="left" valign="top" class=""><strong>Action </strong></td>
						<td width="30%" align="left" valign="top" class=""><strong>Comments<span style="color:red">*</span> </strong></td>
					</tr>
					<?php 					
					//echo '<pre>';print_r($auction_data[0]->bider_detail);
					$isAccepted2 = false;
					$isEmdMovedtoApprover = false;
					if(count($auction_data[0]->bider_detail)){
						foreach($auction_data[0]->bider_detail as $key=>$bider_detail){
						if($isAccepted2==false){
							$isAccepted2 = ($bider_detail->payment_verifier_accepted==1)?true:false;
						}
						
						if($isEmdMovedtoApprover==false){
							$isEmdMovedtoApprover = ($bider_detail->payment_move_to_opener2==1)?true:false;
						}
						
					?>
						<tr class="even">
							<td width="10%" align="left</td>" valign="top" class=""><?php echo ++$key?></td>
							<td width="15%" align="left" valign="top" class="">
							<?php 
							if( GetTitleById('tbl_user_registration',$bider_detail->bidderID,'register_as')=='builder')
							{
							   echo GetTitleById('tbl_user_registration',$bider_detail->bidderID,'organisation_name'); 
							}else
							{
							  echo GetTitleById('tbl_user_registration',$bider_detail->bidderID,'first_name');  
							}
                            ?></td>
							<td width="30%" align="left" valign="top" class="" >
								<a class='emd_detail_iframe' href="/buyer/emdDetailPopup/<?php echo $bider_detail->bidderID;?>/<?php echo $auction_data[0]->id;?>">EMD</a>
							</td>
							
							
							
							<!--<td width="15%" align="left" valign="top" class="" >
								<?php echo ($bider_detail->payment_verifier_accepted==1)?'Accepted':'Rejected';?>
							</td>
							<td width="30%" align="left" valign="top" class="" >
								<?php echo $bider_detail->payment_verifier_comment; ?>
							</td>-->
							
							<td width="15%" align="left" valign="top" class="" >
							<select class="bid_acceptance"  name="bid_acceptance[]">
								<option value="1" <?php if($bider_detail->payment_verifier_accepted==1){ echo 'selected="selected"'; }?>>Accept</option>
								<option value="2" <?php if($bider_detail->payment_verifier_accepted==0 && $bider_detail->payment_verifier_comment!=''){ echo 'selected="selected"'; }?>>Reject</option>
							</select>
							</td>
							<td width="30%" align="left" valign="top" class="" >
								<textarea class="txtComment" style="width:200px;" tabindex="2" cols="20" rows="2" name="txtComment[]"><?php echo $bider_detail->payment_verifier_comment; ?></textarea>
								<input type="hidden" value="<?php echo $bider_detail->id;?>" name="participate_id[]">
								<input type="hidden" value="<?php echo $bider_detail->bidderID;?>" name="bidderID[]">
							</td>
						</tr>
					<?php 
						}
					}
					else
					{
					?>
					<tr>
						<td colspan="5">No Bidder.</td>
					</tr>
					<?php 
					}
					?>
					<?php 
					//echo "<pre>";print_r($auction_data[0]->bider_detail);
					if($isMovedtoApprover!=1)
					{
					?>
						<tr>
							<td colspan="7">
								<input type="hidden" value="<?php echo $user_id; ?>" name="payment_verifier">
								
								<input type="hidden" value="<?php echo $auction_data[0]->id?>" name="auctionID">
								<?php 				
								if($isAccepted2){?>		
									<a href="javascript:void(0);" onclick="move_to_approver(<?php echo $auction_data[0]->id?>);"><input name="Move To Approver" value="Move To Approver" type="button" class="button_grey b_publish2 float-right"></a>
																
									<input name="submit" value="Update" type="submit" class="button_grey b_submit float-right" style="float:right;">
								<?php 
								}else{
								?>
									<input name="submit" value="Save" type="submit" class="button_grey b_submit float-right" style="float:right;">
								<?php }?>
							</td>
						</tr>
					<?php }?>
				</tbody>             
			</table>
		</form>		
	</div>
</div>
<!--End Bid Open EMD verification-->

<!--Start Bid Open Docs verification-->

<div class="row"  style="display:none;">
	<div id="inline_content1">
		<div class="heading4 btmrg20">Document Verification</div>
		<form id="bidopenerfrm1" name="submitdoc" action="/buyer/firstOpnerVerification" method="post" enctype="multipart/form-data" onsubmit="return validateopenerfrm('bidopenerfrm1');">
			<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash();?>" />
			<table border="1" align="left" cellpadding="2" cellspacing="1" class="mytable dataTable" id="big_table" aria-describedby="big_table_info">
				<tbody role="alert" aria-live="polite" aria-relevant="all">
					<tr class="odd">
						<td width="10%" align="left" valign="top" class=""><strong>S/No.</strong></td>
						<td width="15%" align="left" valign="top" class=""><strong>Bidder Name </strong></td>
						<!--<td width="20%" align="left" valign="top" class=""><strong>Payment Verifier Action </strong></td>
						<td width="30%" align="left" valign="top" class=""><strong>Payment Verifier Comments </strong></td>-->
						<td width="30%" align="left" valign="top" class=""><strong>View </strong></td>
						<td width="15%" align="left" valign="top" class=""><strong>Action </strong></td>
						<td width="30%" align="left" valign="top" class=""><strong>Comments<span style="color:red;">*</span></strong></td>
					</tr>
					<?php 					
					//echo '<pre>';print_r($auction_data[0]->bider_detail);
					$isAccepted3 = false;
					$isDocMovedtoApprover = false;
					if(count($auction_data[0]->bider_detail))
					{
						foreach($auction_data[0]->bider_detail as $key=>$bider_detail){
						if($isAccepted3==false){
							$isAccepted3 = ($bider_detail->operner1_accepted==1)?true:false;
						}
						if($isDocMovedtoApprover==false){
							$isDocMovedtoApprover = ($bider_detail->opener1_move_to_opener2==1)?true:false;
						}
						
					?>
						<tr class="even">
							<td width="10%" align="left</td>" valign="top" class=""><?php echo ++$key?></td>
							<td width="15%" align="left" valign="top" class="">
								<?php if(GetTitleById('tbl_user_registration',$bider_detail->bidderID,'register_as')=='owner'){ ?>
							    <?php echo GetTitleById('tbl_user_registration',$bider_detail->bidderID,'first_name')?>
								<?php }else{ ?>
								<?php echo GetTitleById('tbl_user_registration',$bider_detail->bidderID,'organisation_name')?>
								<?php }?>
							</td>
							<!--<td width="20%" align="left" valign="top" class="">
								<?php //echo ($bider_detail->payment_verifier_accepted)?'Accepted':'Rejected'; ?>
							</td>
							<td width="30%" align="left" valign="top" class="">
								<?php //echo $bider_detail->payment_verifier_comment; ?>
							</td>-->
							<td width="30%" align="left" valign="top" class="" >							
							<a class='tenderfee_detail_iframe' href="/buyer/docDetailPopup/<?php echo $bider_detail->bidderID;?>/<?php echo $auction_data[0]->id;?>">Docs</a>
							
							</td>
							<td width="15%" align="left" valign="top" class="" >
							<select class="bid_acceptance"  name="bid_acceptance[]">
							<option value="1" <?php if($bider_detail->operner1_accepted==1){ echo 'selected="selected"'; }?>>Accept</option>
							<option value="2" <?php if($bider_detail->operner1_accepted==0 && $bider_detail->operner1_comment!=''){ echo 'selected="selected"'; }?>>Reject</option>
							</select>
							</td>
							<td width="30%" align="left" valign="top" class="" >
							<textarea class="txtComment" style="width:200px;" tabindex="2" cols="20" rows="2" name="txtComment[]"><?php echo $bider_detail->operner1_comment; ?></textarea>
							<input type="hidden" value="<?php echo $bider_detail->id;?>" name="participate_id[]">
							<input type="hidden" value="<?php echo $bider_detail->bidderID;?>" name="bidderID[]">							
							</td>
						</tr>
					<?php 
						}
					}
					else
					{
					?>
					<tr>
						<td colspan="5">No Bidder.</td>
						
					</tr>
					<tr>
						<td colspan="5"><a href="javascript:void(0)" onClick="return concludeEvent(<?php echo $auction_data[0]->id?>)" ><input name="Save" value="Conclude Event" type="button" class="button_grey b_publish2 float-right"></a></td>
					</tr>
					<?php 
					}
					?>
					
					<?php 
					if($isDocMovedtoApprover!=1)
					{
					?>
						<tr>
							<td colspan="7">
								<input type="hidden" value="<?php echo $auction_data[0]->second_opener?>" name="doc_verifier">
								
								<input type="hidden" value="<?php echo $auction_data[0]->id?>" name="auctionID">
								
								<?php
								if($isAccepted3){
								?>
									<a href="javascript:void(0);" onclick="move_to_approver(<?php echo $auction_data[0]->id?>);"><input name="Move To Approver" value="Move To Approver" type="button" class="button_grey b_publish2 float-right"></a>
								
									<input name="submit" value="Update" type="submit" class="button_grey b_submit float-right" style="float:right;">
								<?php 
								}
								else
								{
								?>
									<input name="submit" value="Save" type="submit" class="button_grey b_submit float-right" style="float:right;">
								<?php }?>
							</td>
						</tr>
					<?php }?>	
				</tbody>             
			</table>
		</form>		
		<?php 
		//echo 'isAccepted: '.$isAccepted.'<br />';
		//echo 'first_opener: '.$auction_data[0]->first_opener.'<br />';
		//echo 'second_opener: '.$auction_data[0]->second_opener.'<br />';
		if(count($auction_data[0]->bider_detail)>0 && $auction_data[0]->first_opener>0 && $auction_data[0]->first_opener>0 && $isAccepted==true && ($auction_data[0]->second_opener==null || $auction_data[0]->second_opener==0) && $auction_data[0]->open_price_bid){?>
			
			<?php 
				if($auction_data[0]->show_frq==1 && $auction_data[0]->price_bid_applicable=='applicable'){
			?>
				<div class="heading4 btmrg20">Price Bid</div>			
			<?php }?>
			
			<table border="1" align="left" cellpadding="2" cellspacing="1" class="mytable dataTable" id="big_table" aria-describedby="big_table_info">
				<tbody role="alert" aria-live="polite" aria-relevant="all">
					
					<?php 
					if($auction_data[0]->show_frq==0 && $auction_data[0]->price_bid_applicable=='applicable'){
						$opening_price=0;
						foreach($auction_data[0]->bider_detail as $key=>$bider_detail){
							if($bider_detail->operner1_accepted){
								if($bider_detail->frq_detail[0]->frq>$opening_price){
									$opening_price = $bider_detail->frq_detail[0]->frq;
								}
							}
						}
						
					}
					if($auction_data[0]->show_frq==1 && $auction_data[0]->price_bid_applicable=='applicable'){
					?>
						<tr class="odd">
							<td width="10%" align="left" valign="top" class=""><strong>Sl No.</strong></td>
							<td width="20%" align="left" valign="top" class=""><strong>Bidder Name </strong></td>
							<td width="20%" align="left" valign="top" class=""><strong>Opener1 Action </strong></td>
							<td width="30%" align="left" valign="top" class=""><strong>Opener1 Comments </strong></td>
							<td width="15%" align="left" valign="top" class=""><strong>Price </strong></td>
						</tr>
						<?php 
							$opening_price=0;
							
							//echo '<pre>';
							//print_r($auction_data[0]->bider_detail);
							
							foreach($auction_data[0]->bider_detail as $key=>$bider_detail)
							{
									if($bider_detail->operner1_accepted){
										if($bider_detail->frq_detail[0]->frq>$opening_price){
											$opening_price = $bider_detail->frq_detail[0]->frq;
										}
									}	
						?>
						<tr class="even">
							<td width="10%" align="left</td>" valign="top" class="">
								<?php echo ++$key?>
							</td>
							<td width="20%" align="left" valign="top" class="">
                                <?php if(GetTitleById('tbl_user_registration',$bider_detail->bidderID,'register_as')=='owner'){ ?>
									<?php echo GetTitleById('tbl_user_registration',$bider_detail->bidderID,'first_name')?>
                                                            <?php }else{ ?>
                                                            <?php echo GetTitleById('tbl_user_registration',$bider_detail->bidderID,'organisation_name')?>
                                                            <?php }?>
								<?php //echo GetTitleById('tbl_user_registration',$bider_detail->bidderID,'first_name')?>
							</td>
							<td width="20%" align="left" valign="top" class="">
								<?php echo ($bider_detail->operner1_accepted)?'Accepted':'Rejected'; ?>
							</td>
							<td width="30%" align="left" valign="top" class="">
								<?php echo $bider_detail->operner1_comment; ?>
							</td>
							<td width="15%" align="left" valign="top" class="">
								<?php echo $bider_detail->frq_detail[0]->frq; ?>
							</td>
						</tr>
					<?php 
						}
					}	
					?>
					<tr>
						<td colspan="5">
							<a class="inline_auctiondetail4" href="#inline_content3" onclick="movetoauction(<?php echo $auction_data[0]->id?>);"><input name="Save" value="Move To Auction" type="button" class="button_grey b_publish2 float-right"></a>
							
							<a href="javascript:void(0)" onClick="return concludeEvent(<?php echo $auction_data[0]->id?>)" style="float:right;"><input name="Save" value="Conclude Event" type="button" class="button_grey b_publish2 float-right"></a>
						</td>
					</tr>
				</tbody>
			</table>
		<?php }?>	
	</div>	
</div>
<!--End Bid Open Docs verification-->
<!--Bid Open Second oPener-->
<?php
//print_r($auction_data);
?>
<div class="row"  style="display:none;">
	
	<div id="inline_content2">
		<div class="message_new" style="color:red;text-align:center;font-size:14px;"> <?php echo @$this->session->userdata['flash:old:message_new']; ?></div>
		<div class="heading4 btmrg20">Bid Opening- Approver</div>
		<form id="bidopenerfrm2" name="submitdoc" action="/buyer/add_bidder_auction" method="post" enctype="multipart/form-data" > 
		<!--onsubmit="return validateopenerfrm('bidopenerfrm2');"-->
			<table border="1" align="left" cellpadding="2" cellspacing="1" class="mytable dataTable" id="big_table" aria-describedby="big_table_info">
				<thead>
					<tr class="odd">
						<td width="2%" align="left" valign="top" class=""><strong><input type="checkbox" name="selectAll" id="selectAll" value="1"/></strong></td>
						<td width="5%" align="left" valign="top" class=""><strong>S/No.</strong></td>
						<td width="15%" align="left" valign="top" class=""><strong>Bidder Name </strong></td>
						<td width="30%" align="left" valign="top" class=""><strong>View </strong></td>
						<td width="20%" align="left" valign="top" class=""><strong>Payment Verifier Action </strong></td>
						<td width="30%" align="left" valign="top" class=""><strong>Payment Verifier Comments </strong></td>
						<?php if($auction_data[0]->doc_to_be_submitted == 0){}else{ ?>
						<td width="15%" align="left" valign="top" class=""><strong>Document Verifier Action </strong></td>
						<td width="30%" align="left" valign="top" class=""><strong>Document Verifier Comments </strong></td>
						<?php } ?>
						<?php
							//if($bider_detail->payment_verifier_accepted !=null && $bider_detail->operner1_accepted != null)
							{
							?>						
							<td width="15%" align="left" valign="top" class=""><strong>Action </strong></td>						
							<td width="30%" align="left" valign="top" class=""><strong>Comments<span style="color:red">*</span> </strong></td>
						<?php } ?>
					</tr>
				</thead>
				<tbody role="alert" aria-live="polite" aria-relevant="all">					
					<?php 					
					//echo '<pre>';print_r($bider_detail->payment_verifier_accepted);die;
					$isAccepted2 = false;
					$isMovedtoAuction = false;
					if(count($auction_data[0]->bider_detail)){
						foreach($auction_data[0]->bider_detail as $key=>$bider_detail){
						if($isAccepted2==false){
							$isAccepted2 = ($bider_detail->operner2_accepted==1)?true:false;
						}
						
						if($isMovedtoAuction==false){
							$isMovedtoAuction = ($bider_detail->opener2_move_to_auction==1)?true:false;
						}
					?>
						<tr class="even">
							<td align="left" valign="top" class=""><input type="checkbox" class="case" value="<?php echo $bider_detail->id;?>" name="participate_id[]"</td>
							<td align="left" valign="top" class=""><?php echo ++$key?></td>
							<td align="left" valign="top" class="">
							<?php 
							if( GetTitleById('tbl_user_registration',$bider_detail->bidderID,'register_as')=='builder'){
							   echo GetTitleById('tbl_user_registration',$bider_detail->bidderID,'organisation_name'); 
							  }else{
							  echo GetTitleById('tbl_user_registration',$bider_detail->bidderID,'first_name');  
							}
							?></td>
							<td align="left" valign="top" class="" >
							<a class='emd_detail_iframe' href="/buyer/emdDetailPopup/<?php echo $bider_detail->bidderID;?>/<?php echo $bider_detail->auctionID;?>">EMD</a>
							<?php if($auction_data[0]->doc_to_be_submitted == 0){}else{ ?>
							|
							<a class='tenderfee_detail_iframe' href="/buyer/docDetailPopup/<?php echo $bider_detail->bidderID;?>/<?php echo $bider_detail->auctionID;?>">Docs</a>
							<?php } ?>
							<!--|
							<a class='doc_detail_iframe' href="/buyer/tenderfeeDetailPopup/<?php echo $bider_detail->bidderID;?>/<?php echo $bider_detail->auctionID;?>">Fee</a>-->
							</td>
							<td align="left" valign="top" class="">
								<?php
									if($bider_detail->payment_verifier_accepted==1)
									{
										echo 'Accepted';
									}
									else if($bider_detail->payment_verifier_accepted==null)
									{
										echo '';
									}
									else if($bider_detail->payment_verifier_accepted==0)
									{
										echo 'Rejected';
									}
								 
								 ?>
							</td>
							<td align="left" valign="top" class="">
								<?php echo $bider_detail->payment_verifier_comment; ?>
							</td>							
							<?php if($auction_data[0]->doc_to_be_submitted == 0){}else{ ?>
							<td width="15%" align="left" valign="top" class="" >
								<?php 
									if($bider_detail->operner1_accepted==1)
									{
										echo 'Accepted';
									}
									else if($bider_detail->operner1_accepted==null)
									{
										echo '';
									}
									else if($bider_detail->operner1_accepted==0)
									{
										echo 'Rejected';
									}
								?>
							</td>
							<td align="left" valign="top" class="" >
								<?php echo $bider_detail->operner1_comment; ?>
							</td>
							<?php } ?>
							
							<?php
							//if($bider_detail->payment_verifier_accepted !=null && $bider_detail->operner1_accepted != null)
							{
							?>
							<td align="left" valign="top" class="" >
							<select class="bid_acceptance"  name="bid_acceptance[]" id ="acpt_<?php echo $bider_detail->id;?>" disabled >
								<option value="1" <?php if($bider_detail->operner2_accepted==1){ echo 'selected="selected"'; }?>>Accept</option>
								<option value="2" <?php if($bider_detail->operner2_accepted==0 && $bider_detail->operner2_comment!=''){ echo 'selected="selected"'; }?>>Reject</option>
							</select>							
							</td>
							
							<td align="left" valign="top" class="" >						
								<textarea class="txtComment" style="width:200px;" tabindex="2" cols="20" rows="2" name="txtComment[]" id="cmt_<?php echo $bider_detail->id;?>" disabled ><?php echo $bider_detail->operner2_comment; ?></textarea>
								<input type="hidden" value="<?php echo $bider_detail->id;?>" name="participate_id[]">
							</td>
							<?php
							 } ?>
						</tr>						
					<?php 
						}
					}
					else
					{
					?>
					<tr>
						<td colspan="8">No Bidder.</td>
					</tr>
					<?php 
					}
					?>
					<?php 
					if($isMovedtoAuction != 1)
					{
					?>
						<tr>
							<td colspan="9">
								<input type="hidden" value="<?php echo $auction_data[0]->second_opener?>" name="second_opener">
								
								<input type="hidden" value="<?php echo $auction_data[0]->id?>" name="auctionID">
								
								<?php
								//if($bider_detail->payment_verifier_accepted !=null && $bider_detail->operner1_accepted != null)
								{									
									if($isAccepted2){
									?>
										<!--<a href="javascript:void(0)" onClick="open_price_bid1(<?php echo $auction_data[0]->id?>);" >
											<input name="Save" value="Open Price Bid" type="button" class="button_grey b_publish2 float-right">
										</a>-->
										<a id="set_opening_price1" href="javascript:void(0);" onclick="set_opening_price(<?php echo $auction_data[0]->id?>, '<?php echo $auction_data[0]->reserve_price; ?>', '<?php echo $currentStatus;?>');"><input name="Save" value="Move To Auction" type="button" class="button_grey b_publish2 float-right"></a>
									<?php
									}
									?>
									
									<?php
									if($isAccepted2){
									?>
										<input name="submit" value="Update" type="submit" class="button_grey b_submit float-right" style="float:right;">
									<?php 
									}else{
									?>
										<input name="submit" value="Save" type="submit" class="button_grey b_submit float-right" style="float:right;">
									<?php }
								}
								?>
								
							</td>
						</tr>
					<?php }?>
				</tbody>             
			</table>
		</form>		
		<?php 
		//echo 'isAccepted: '.$isAccepted.'<br />';
		//echo 'first_opener: '.$auction_data[0]->first_opener.'<br />';
		//echo 'second_opener: '.$auction_data[0]->second_opener.'<br />';
		if($auction_data[0]->open_price_bid==1 && $isAccepted2==true){?>			
			<table border="1" align="left" cellpadding="2" cellspacing="1" class="mytable dataTable" id="big_table" aria-describedby="big_table_info">
				<tbody role="alert" aria-live="polite" aria-relevant="all">
					<tr>
						<td colspan="7">
							
							<a class="inline_auctiondetail3" href="#inline_content3"><input name="Save" value="Move To Auction" type="button" class="button_grey b_publish2 float-right"></a>
						</td>
					</tr>
				</tbody>
			</table>
		<?php }?>	
	</div>
</div>
<!--End Bid Open Second oPener-->

<!-- START SET OPENING PRICE -->
<div class="row"  style="display:none;">
	<div id="inline_content3">
		<div class="heading4 btmrg20">
			Set Highest Bid Price as Opening Price
		</div>
		<table border="1" align="left" cellpadding="2" cellspacing="1" class="mytable dataTable" id="big_table" aria-describedby="big_table_info">
			<tbody role="alert" aria-live="polite" aria-relevant="all">
				<tr>
					<td valign="center">
						<?php 
							if($auction_data[0]->show_frq==1 && $auction_data[0]->price_bid_applicable=='applicable'){
								//Do Nothing
							}elseif($auction_data[0]->show_frq==0 && $auction_data[0]->price_bid_applicable=='applicable'){
								//Do Nothing
							}else{
								$opening_price = $auction_data[0]->reserve_price;
							}
						?>						
						<input type="radio" name="opening_price" id="opening_price" checked="checked" />H1(
						Rs. <?php echo $opening_price; ?>) as Opening Price.
						<a id="set_opening_price1" href="javascript:void(0);" onclick="set_opening_price(<?php echo $auction_data[0]->id?>, '<?php echo $opening_price; ?>', '<?php echo $currentStatus;?>');"><input name="Save" value="Submit" type="button" class="button_grey b_publish2 float-right"></a>
						<img id="loading-image" src="/images/loading3.gif" style="height: 30px; width: 30px;top: 12px;position: relative; display: none;margin-left: 10px;"/>
					</td>
				</tr>
			</tbody>
		</table>
	</div>				
</div>
<!-- END OF OPENING PRICE -->





<?php 
//echo $this->session->userdata('open_popup');
if($this->session->userdata('open_popup')==true && $currentStatus==4){?>	
<script>    
    function opendiv(auctionID){
              jQuery.ajax({
			url: '/buyer/movetoauction',
			type: 'POST',
			data: {
				   auctionID:auctionID,
				   type:"opening"
				  },
			success: function(data) {
				//location=location;
				//alert(data);
			}
		});	  
              
    }
	jQuery(document).ready(function(){
            jQuery('.inline_auctiondetail1').trigger('click');            
	});
</script>
<?php }?>
<?php if($this->session->userdata('open_popup')==true && $currentStatus==5){?>	
<script>
	jQuery(document).ready(function(){	
		jQuery('.inline_auctiondetail2').trigger('click');
	});	
</script>
<?php }
 if($this->session->userdata('open_popup')==true && $currentStatus==3){
	 ?>	
<script>
	jQuery(document).ready(function(){	
		jQuery('.inline_auctiondetail5').trigger('click');
	});
</script>
<?php }
$this->session->set_userdata('open_popup', false);
?>
<script>
jQuery(document).ready(function(){
	jQuery('#set_opening_price1').click(function(){
		jQuery('#set_opening_price1').hide();
		jQuery('#loading-image').show();       
	});
});
</script>
