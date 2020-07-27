<?php 
$productID	=	$prows->id;
$branch_id	=	$erows->branch_id;
$drt_id	=	$erows->drt_id;
$eventid='';
$city=$auctionData->city;
$state=$auctionData->state;
$country=$auctionData->countryID;
$other_city=$auctionData->other_city;
?>
<link href="<?php echo base_url()?>/bankeauc/css/common.css" rel="stylesheet" type="text/css">

  <?php //echo $breadcrumb;?>

	 <section class="body_main1">
		  <div class="row ">
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
							  <div class="box-head no_cursor">Preview Auction (Auction Id: <?php echo $auctionID;?> )</div>
							  <!--<div class="srch_wrp2">
								<input type="text" value="Search" id="search" name="search">
								<span class="ser_icon"></span> </div>-->
							</div>
							<div class="table-section">
					
				  <form method="post" enctype="multipart/form-data" name="createauction" id="createauction" action="">
				  
		<!--show error popup-->		  
		<p style="display:block;"><a class='inline' href="#inline_content"></a></p>
		<div style='display:none'>
			<div id='inline_content' style='padding:10px; background:#fff;'>
                            <ul id="spMsg" style="color:#CC0000;"></ul>
			</div>
		</div>  
		<!--show error popup -->
					<div class="form box-content2">

						
						<input type="hidden" value="<?php echo $userID;?>" name="first_opener"/>
					  <div class="plain row">
						  <div class="lft_heading">Account: </div>

						<div class="rgt_detail">							
						  <label>
							  <?php if($auctionData->event_type=='drt' || $drt_user == 'drt'){?>
								    DRT
							  <?php }else if($auctionData->event_type=='sarfaesi') { ?>
									Sarfaesi
							  <?php }else{ ?>
									Other
							  <?php } ?>							  
						 </div>
					  </div>
					  
					  <div class="row">
							<div class="lft_heading">Property ID: </div>
							<div class="rgt_detail">
								<?php echo $auctionData->reference_no;?>										
							</div>
						</div>

					  
					  <div class="row">
							<div class="lft_heading">Event Title: </div>
							<div class="rgt_detail">
								<?php echo $auctionData->event_title;?>										
							</div>
						</div>

					  
					  <div class="row">
							<div class="lft_heading">Name of the Organization: </div>
							<div class="rgt_detail">
								<?php
									foreach($banks as $bank_record){ ?>
										<?php if($bank_record->id==$bank_id){ ?><?php echo $bank_record->name; ?> <?php } ?>
								<?php }?>
							</div>
						</div>
				
					  <div class="row">
							<div class="lft_heading">Asset Category: </div>
							<div class="rgt_detail">									
								<?php				
									foreach($category as $category_record){ ?>
										<?php if($category_record->id==$auctionData->category_id){ ?> <?php echo $category_record->name; ?> <?php } ?>
								<?php }?>
										  
							</div>
						</div>
						
				
					  <div class="row">
							<div class="lft_heading">Sub Category: </div>
							<div class="rgt_detail">
								<?php
									$subcategory=$this->helpdesk_executive_model->GetsubCategorydata($auctionData->category_id,$auctionData->subcategory_id);									
									foreach($subcategory as $subcaterow){?>
										<?php if($subcaterow->id==$auctionData->subcategory_id){ ?><?php echo $subcaterow->name; ?><?php } ?>
								<?php }?>								
							</div>
					  </div>
					  
					  <div class="row">
						<div class="lft_heading">Description of the property: </div>
						<div class="rgt_detail">
                           <?php echo @$auctionData->product_description;?>						  
						</div>
					  </div>
					  
                      <div class="row">
							<div class="lft_heading">Country: </div>
							<div class="rgt_detail">								
								<?php
								foreach($countries as $country_record){?>
									<?php if($country_record->id==$country){ ?><?php echo $country_record->country_name; ?><?php } ?>
								<?php }?>								
							</div>					
						</div>
                   <div class="row">
							<div class="lft_heading">Property State: </div>
							<div class="rgt_detail">							
									<?php foreach($states as $state_record){ ?>
                                            <?php if($state_record->id==$auctionData->state){ ?><?php echo $state_record->state_name; ?> <?php } ?>
									<?php } ?> 
							</div>					
						</div>
						
						<div class="row">
							<div class="lft_heading">Property City: </div>
							<div class="rgt_detail">
								<?php foreach($cities as $city_record){?>
					                        <?php if($city_record->id == $city){?> <?php echo $city_record->city_name; ?> <?php } ?>
								<?php } ?>
                                <?php if (!empty($other_city)){ ?> ><?=$other_city;?><?php } ?>
							</div>					
						</div>                                  
        
				      <div class="row">
							<div class="lft_heading">Borrower Name: </div>
							<div class="rgt_detail">
								<?php echo $auctionData->borrower_name;?>										
							</div>
						</div>

					  
					  <div class="row">
							<div class="lft_heading">Kind Attention To.(Invoiced to be mailed): </div>
							<div class="rgt_detail">
								<?php 
								 $totalUser= count($banksUsersList); 
								  if($totalUser>0)
								  { 
									 foreach($banksUsersList as $urow){?>
										<?php if($urow->id==$auctionData->invoice_mail_to){ ?> <?php echo $urow->email_id;?>, <?php echo $urow->user_id;?>, <?php echo ucfirst($urow->first_name);?>  <?php echo $urow->last_name;?><?php } ?>
									<?php }
								  
								  } ?>
									  
							</div>
						</div>
		
					  
					  <div class="row">
							<div class="lft_heading">To.(Invoice to be Mailed): </div>
							<div class="rgt_detail">
								   <?php 
								   $banksUsersList_comma = false;
								  if($auctionData->invoice_mailed){
									  $tosubArr=explode(',',$auctionData->invoice_mailed);
								  }
								 $totalUser= count($banksUsersList); 
								  if($totalUser>0)
								  { 
									 foreach($banksUsersList as $urow){										
										if(in_array($urow->id,$tosubArr)){
											if($banksUsersList_comma == true)
											{
												echo ',';
											}
											$banksUsersList_comma = true;
											echo $urow->email_id.", ".$urow->user_id.", ".ucfirst($urow->first_name).' '.$urow->last_name;   
										}
									}
								  
								  }
								  if(!$banksUsersList_comma)
								  {
									echo '-';
								  }
								  
								  ?>
									 
							</div>
						</div>
			
					  <hr>
					 <div class="seprator btmrg20"></div>
					  <div class="row">
							<div class="lft_heading">Reserve Price: </div>
							<div class="rgt_detail">
								<?php echo $auctionData->reserve_price;?>										
							</div>
						</div>
					  
					  <div class="row">
							<div class="lft_heading">EMD Amount: </div>
							<div class="rgt_detail">
								<?php echo $auctionData->emd_amt;?>
							</div>										
					  </div>
					  
					  <div class="row">
							<div class="lft_heading">Tender Fee: </div>
							<div class="rgt_detail">
								<?php echo $auctionData->tender_fee;?>
							</div>
						</div>
						
					<div class="plain row">
							<div class="lft_heading">Nodal Bank</div>
							<div class="rgt_detail">
							  <label>
								  <?php if($auctionData->nodal_bank=='same'){?>
									Same
								  <?php }else{ ?>
									Others
								<?php } ?>
							  </label>
							</div>
					  </div>
					  
					  <div class="row">
							<div class="lft_heading">Nodal Bank Name: </div>
							<div class="rgt_detail">
								<?php
									if($auctionData->nodal_bank=='same'){
										$nsele='disabled="disabled"';
										$bank_id1=$auctionData->nodal_bank_name;
									}else if($auctionData->nodal_bank=='others'){
										$nsele='';
										$bank_id1=$auctionData->nodal_bank_name;
									}else{
										$nsele='disabled="disabled"';
										$bank_id1=$bank_id;
									}
									?>
									   <?php foreach($banks as $bank_record){ ?>
												<?php if($bank_record->id==$bank_id1){ ?> <?php echo $bank_record->name; ?>  <?php } ?>
										<?php }	?>
									 
							</div>
						</div>					
					
					  
					  <div class="row">
							<div class="lft_heading">Nodal Bank account number: </div>
							<div class="rgt_detail">
								<?php echo $auctionData->nodal_bank_account;?>
							</div>
						</div>
		
					  
					  <div class="row">
							<div class="lft_heading">Branch IFSC Code: </div>
							<div class="rgt_detail">
                               <?php echo $auctionData->branch_ifsc_code;?>										
							</div>
						</div>
						
				  <hr>
					  
					  <div class="row">
							<div class="lft_heading">Press Release Date: </div>
							<div class="rgt_detail">
								<?php echo $auctionData->press_release_date;?>										
							</div>
						</div>
	
					  
					  <div class="row">
							<div class="lft_heading">Date of inspection of asset(From): </div>
							<div class="rgt_detail">
								<?php echo $auctionData->inspection_date_from;?>								
							</div>
						</div>
						
					
					   <div class="row">
							<div class="lft_heading">Date of inspection of asset(To): </div>
							<div class="rgt_detail">
								<?php echo $auctionData->inspection_date_to;?>								
							</div>
						</div>
		
					  <div class="row">
							<div class="lft_heading">Sealed Bid Submission Last Date: </div>
							<div class="rgt_detail">
								<?php echo $auctionData->bid_last_date;?>
							</div>
						</div>
						
						<div class="row">
							<div class="lft_heading">Sealed Bid Opening Date: </div>
							<div class="rgt_detail">
								<?php echo $auctionData->bid_opening_date;?>										
							</div>
						</div>
	
					  <div class="row">
							<div class="lft_heading">Auction Start date: </div>
							<div class="rgt_detail">
								<?php echo $auctionData->auction_start_date;?>										
							</div>
						</div>
						
						<div class="row">
							<div class="lft_heading">Auction End date: </div>
							<div class="rgt_detail">
								<?php echo $auctionData->auction_end_date;?>
							</div>
						</div>
						<hr>
						
						<?php if($drt_user == 'drt'){ ?>
							<div class="row">
								<div class="lft_heading">Bank & Branch: </div>
								<div class="rgt_detail">
									<?php 
									foreach($banks as $bank_record){ ?>
										<?php if($bank_record->id==$bank_id){ ?><?php echo $bank_record->name; ?><?php } ?>
									<?php }?>
								
									<?php 
									foreach($bankbranch as $branch){ ?>
										<?php if($branch->id== $auctionData->bank_branch_id){?> <?php echo $branch->name; ?> <?php } ?>
									<?php }?>		
								</div>
							</div>
						<?php } ?>
						
					  <div class="seprator btmrg20"></div>
					 
					 <div class="plain row">
						<div class="lft_heading">Auction Type: </div>
						<div class="rgt_detail">
						  <label>
							  <?php if($auctionData->show_home == '1'){?>
								Open
							  <?php }else{ ?>
								Limited User
							  <?php } ?>
						  </label>
                        </div>
                                                
					  </div>
						
					  <div class="plain row">
						<div class="lft_heading">Show FRQ: </div>
						<div class="rgt_detail">
						  <label>
							  <?php if($auctionData->show_frq=='1'){?>
								Yes
							  <?php }else{ ?>
								No
							  <?php } ?>
						  </label>
                        </div>
                                                
					  </div>
					  
					   <?php if(false) { ?>
					  <div class="plain row">
						<div class="lft_heading">Is DSC Enabled: </div>
						<div class="rgt_detail">
							<label>
							  <?php if($auctionData->dsc_enabled=='1'){?>
								Yes
							  <?php }else{ ?>
								No
							  <?php } ?>
						  </label>
						  </div>
					  </div>
					  <?php } ?>
                      <div class="plain row">
						<div class="lft_heading">Auto Bid Cut Off: </div>
						<div class="rgt_detail">
							<label>
							  <?php if($auctionData->auto_bid_cut_off=='1'){?>
								Yes
							  <?php }else{ ?>
								No
							  <?php } ?>
						  </label>						  
						</div>
                      </div>
			   
				      <div class="plain row">
						<div class="lft_heading">Price Bid: </div>
						<div class="rgt_detail">
						  <label>
							  <?php if($auctionData->price_bid_applicable=='applicable') {?>
								Applicable
							  <?php }else { ?>
								Not Applicable
							  <?php } ?>          
							</div>
					  </div>
					  <div class="row">
							<div class="lft_heading">Bid Increment value: </div>
							<div class="rgt_detail">
                                <?php if($auctionData->bid_inc!='0.00'){echo $auctionData->bid_inc; }; ?>									
							</div>
						</div>
						
				  
					  <div class="row">
							<div class="lft_heading">Auto Extension time (In Minutes.): </div>
							<div class="rgt_detail">
								<?php if($auctionData->auto_extension_time!='0'){echo $auctionData->auto_extension_time; }; ?>										
							</div>
						</div>
							  
					  <div class="row">
							<div class="lft_heading">Auto Extension(s): </div>
							<div class="rgt_detail">								
								 <?php echo ($auctionData->auto_extension_time >0 && $auctionData->no_of_auto_extn == '0') ? "Unlimited": $auctionData->no_of_auto_extn; ?>										
							</div>
						</div>
						
					  
					  <div class="row">
							<div class="lft_heading">Upload Related Documents:  </div>
							<div class="rgt_detail">										
								<?php
								  if($auctionData->related_doc){?>										   
									<a style="font-size: 10px;" download href="/public/uploads/event_auction/<?php echo $auctionData->related_doc;?>"> <?php echo $auctionData->related_doc;?></a>
								  <?php } else {?>
								   -
								   <?php } ?>
							</div>
						</div>
						
					 <div class="row">
							<div class="lft_heading">Upload Images: </div>
							<div class="rgt_detail">
								<?php
								  if($auctionData->image){ ?>
									 
									<a style="font-size: 10px;" download href="/public/uploads/event_auction/<?php echo $auctionData->image;?>"><?php echo $auctionData->image?></a>	
								  <?php }else{ ?>
									-
								  <?php }?>										
							</div>
						</div>
                     <div class="row">
                         <div class="lft_heading"> Check To Upload Special terms and conditions:</div>
                         <div class="rgt_detail">
                               <?php  if($auctionData->supporting_doc){ ?> 
									Yes
                               <?php }else {?>
									No
                               <?php } ?>           
                          </div>
					</div>
                    <div class="row">
						<div class="lft_heading"> Upload Special terms and conditions documents:</div>
						<div class="rgt_detail">                                                            
									<?php  if($auctionData->supporting_doc){ ?>                                                                                
										<a style="font-size: 10px;" download href="/public/uploads/event_auction/<?php echo $auctionData->supporting_doc;?>"><?php echo $auctionData->supporting_doc?></a>	
									<?php }else{ ?>
										-
									<?php } ?>
										
                         </div>
                    </div>
						<div class="row">
							<div class="lft_heading">Documents to be submitted:  </div>
							<div class="rgt_detail">
								  <?php
								  if($auctionData->doc_to_be_submitted){
									  $docsubArr=explode(',',$auctionData->doc_to_be_submitted);
								  }
								  $document_list_comma = false;
									foreach($document_list as $document){
									if(count($docsubArr)>0)
									{
										if(in_array($document->id,$docsubArr)){
											if($document_list_comma == true)
											{
												echo ',';	
											}
											$document_list_comma = true;
											echo $document->name;
										}
									}
									?>									
								<?php }?>
										 
							</div>
						</div>
						
						
					  <div class="row" id="div_second_opener">
							<div class="lft_heading">Second Opener: </div>
							<div class="rgt_detail">
								 <?php
									 $second_opener_flag = true;
									 $totalUser= count($banksUsersList);
									  if($totalUser>0)
									  { 
											foreach($banksUsersList as $urow){
												 if($urow->id==$auctionData->second_opener){ 
													 $second_opener_flag = false;
													 echo $urow->email_id;?>, <?php echo $urow->user_id;?>, <?php echo ucfirst($urow->first_name);?>  <?php echo $urow->last_name;?> <?php 
												 }												
											}
									  
									  } 
									  if($second_opener_flag)
									  {
										  echo '-';
									  }
									  ?>
								 
							</div>
						</div>
						<div id="div_second_opener" class="row">
							<div class="lft_heading">Status: </div>
							<div class="rgt_detail">																			
								<?php 
									if($auctionData->status == 1){ 
										echo 'Published';
									}
									else if($auctionData->status == 3)
									{ 
										echo 'Stay';
									}
									else if($auctionData->status == 4)
									{ 
										echo 'Cancel';
									}
								?>
							</div>
						</div>
						
						<div id="div_second_opener" class="row">
							<div class="lft_heading">Publish Date: </div>
							<div class="rgt_detail">																			
								<?php echo $auctionData->indate;?>									
							</div>
						</div>
						
						<hr>
					  <div class="seprator btmrg20"></div>
						<div class="button-row row" style="text-align:center;">						
							<a href="/superadmin/corrigendum/searchevent/<?php echo $auctionID;?>" style="font-size:0; padding-right:5px;" class="b_submit button_grey">Back</a>                      					         
							<input name="final_submit" value="Final Submit"  type="submit" class="b_submit button_grey float-right">
						</div>
					</div>
					</form>
								
								<!--///--->
								
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
