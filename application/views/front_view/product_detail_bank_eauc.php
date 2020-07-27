<?php 
	$annexureNotShowEventArr[] = 27777;
?>
<style>.button{padding: 5px 11px!important}</style>
<section id="body_wrapper">
	<div class="body_main no_margn">
    <div style="clear:both;"></div>
	<h1><?php echo ucfirst($catename)."/".ucfirst($subcategory)."/".ucfirst($cityNameMain); ?></h1>
	
	<div style="clear:both;"></div>
	<?php if(is_array($corrigendum)){?> 
		<?php foreach($corrigendum as $key => $cor)
			  {
				$comm = false; 
				$docArr = array('','0',NULL);
				?>
		<?php if((trim($cor->old_product_description) != trim($cor->product_description)) ||  ($cor->old_NIT_date != $cor->NIT_date) || ($cor->old_bid_last_date != $cor->bid_last_date) || ($cor->old_inspection_date_from != $cor->inspection_date_from) || ($cor->old_inspection_date_to != $cor->inspection_date_to) || ($cor->old_bid_opening_date != $cor->bid_opening_date) || ($cor->old_auction_start_date != $cor->auction_start_date) || ($cor->old_auction_end_date != $cor->auction_end_date) || ($cor->old_related_doc != $cor->related_doc) || ($cor->old_supporting_doc != $cor->supporting_doc) || ($cor->old_image != $cor->image) || ($cor->old_status != $cor->status && $cor->status > 0)){?> 	
	 
		<div class="box-heading corrigemdum-bg">Auction Corrigendum<?php 
			if(count($corrigendum) > 1)
			{
				echo $key+1;
			}
		?></div>
			<div class="corrigemdum-note">
				  <strong>Note</strong>: </span>Corrigendum has been issued for 
					<?php if(trim($cor->old_product_description) != trim($cor->product_description)) {?>
						  <?php if($comm){ echo ",";} $comm = true; ?> 
						  Description of the property
					<?php } ?>
					<?php if($cor->old_NIT_date != $cor->NIT_date) {?>
						  <?php if($comm){ echo ",";} $comm = true; ?> 
						  Press Release Date
					<?php } ?>
					<?php if($cor->old_bid_last_date != $cor->bid_last_date) {?>
						  <?php if($comm){ echo ",";} $comm = true; ?> 
						  Offer (First Round Quote) Submission last date
					<?php } ?>
					<?php if($cor->old_inspection_date_from != $cor->inspection_date_from) {?>
						  <?php if($comm){ echo ",";} $comm = true; ?> 
						  Date of inspection of asset (From)
					<?php } ?>
					<?php if($cor->old_inspection_date_to != $cor->inspection_date_to) {?>
						  <?php if($comm){ echo ",";} $comm = true; ?> 
						  Date of inspection of asset (To)
					<?php } ?>
					<?php if($cor->old_bid_opening_date != $cor->bid_opening_date) {?>
						  <?php if($comm){ echo ",";} $comm = true; ?> 
						  Offer (First Round Quote) Opening date
					<?php } ?>
					<?php if($cor->old_auction_start_date != $cor->auction_start_date) {?>
						  <?php if($comm){ echo ",";} $comm = true; ?> 
						  Auction Start date
					<?php } ?>
					<?php if($cor->old_auction_end_date != $cor->auction_end_date) {?>
						  <?php if($comm){ echo ",";} $comm = true; ?> 
						  Auction End date
					<?php } ?>
					<?php if($cor->old_related_doc != $cor->related_doc) {?>
						  <?php if($comm){ echo ",";} $comm = true; ?> 
						  Related Documents
					<?php } ?>
					<?php
		  
						if(($cor->old_supporting_doc != $cor->supporting_doc && !in_array($cor->old_supporting_doc,$docArr) && !in_array($cor->supporting_doc,$docArr)) || (in_array($cor->old_supporting_doc,$docArr) && !in_array($cor->supporting_doc,$docArr)) || (!in_array($cor->old_supporting_doc,$docArr) && in_array($cor->supporting_doc,$docArr)) ) {?>
						  <?php if($comm){ echo ",";} $comm = true; ?> 
						  Supporting Documents
					<?php } ?>
					<?php //if($cor->old_image != $cor->image) {?>
					
					<?php					 
						  if(($cor->old_image != $cor->image && !in_array($cor->old_image,$docArr) && !in_array($cor->image,$docArr)) || (in_array($cor->old_image,$docArr) && !in_array($cor->image,$docArr)) || (!in_array($cor->old_image,$docArr) && in_array($cor->image,$docArr)) ) {?>
						  <?php if($comm){ echo ",";} $comm = true; ?> 
						  Images
					<?php } ?>
					<?php if($cor->old_status != $cor->status && $cor->status > 0) {?>
						  <?php if($comm){ echo ",";} $comm = true; ?> 
						  Status (<?php if($cor->status == 1)echo 'Publish';if($cor->status == 4)echo 'Cancel'; if($cor->status == 3)echo 'Stay';?>)
					<?php } ?>
			   </div>
			<?php } ?>
		<?php } ?>
	<?php } ?>
	<div class="box-content-details">
		<fieldset>
			<legend>Account Details</legend>
				<div class="row">
					<div class="lft_heading">Auction Type :</div>
					<?php if (!empty($account_name)) { ?>
						<div class="rgt_detail"><?php echo strtoupper($account_name); ?></div>
					<?php } ?>
				</div>
				<div class="row">
					<div class="lft_heading">Auction No. :</div>
					<div class="rgt_detail"><?php echo $auctionID ?></div>
				</div>

				<div class="row">
					<div class="lft_heading">Property ID :</div>
					<div class="rgt_detail"><?php echo $reference_no; ?></div>
				</div>

				<div class="row">
					<div class="lft_heading">Tender / Auction Title :</div>
					<div class="rgt_detail"><?php echo $event_title ?></div>
				</div>

				<div class="row">
					<div class="lft_heading">Auction Bank :</div>
					<div class="rgt_detail"><?= $bank_name ?></div>
				</div>
		</fieldset>
		<fieldset>
			<legend>Property Details</legend>
				<div class="row">
					<div class="lft_heading">Property Category :</div>
					<div class="rgt_detail"><?= $catename ?></div>
				</div>

				<div class="row">
					<div class="lft_heading">Property Sub Category :</div>
					<div class="rgt_detail"><?= $subcategory ?></div>
				</div>

				<div class="row">
					<div class="lft_heading">Property Address :</div>
					<div class="rgt_detail"><?= $product_description ?></div>
				</div>
				<div class="row">
					<div class="lft_heading">Borrower's Name :</div>
					<div class="rgt_detail"><?= $borrower_name; ?></div>
				</div>
				<?php if ($product_image!='') { ?>
				<div class="row">
					<div class="lft_heading">View Images :</div>
					<div class="rgt_detail">
						
							<?php /* ?>
							<a class="b_download float-right" style="font-size:12px; text-decoration:none;"   target="_blank" download="" href="/public/uploads/event_auction/<?php echo $product_image; ?>">Download</a>
							<?php */ ?>
							 <?php 
							 if($CorrigendumDocImages!=''){  
								 
								 //print_r($CorrigendumDocImages);
								 $imagesData = array();
									if (count($CorrigendumDocImages) > 0) {
										$i = 0;
										foreach ($CorrigendumDocImages as $CorrigendumDocImage) {
											if($CorrigendumDocImage != '0'){ //Line added
											?>
												<a class="b_download float-right" style="font-size:12px; text-decoration:none;"   target="_blank" download="" href="/public/uploads/event_auction/<?php echo $CorrigendumDocImage; ?>"><?php echo "Corrigendum".$i; ?></a>
											<?php
												echo ',';
												}  //Line added
											$i++;
										}
										?>
										<a class="b_download float-right" style="font-size:12px; text-decoration:none;"   target="_blank" download="" href="/public/uploads/event_auction/<?php echo $product_image; ?>"><?php echo "Corrigendum".$i; ?></a>
										<?php 
									}
							   }else{
							 ?>
							 <a class="b_download float-right" style="font-size:12px; text-decoration:none;"   target="_blank" download="" href="/public/uploads/event_auction/<?php echo $product_image; ?>">Download</a>
							 
							 <?php } ?>
							
					</div>
				</div>
				<?php } ?>
		</fieldset>
		<fieldset>
			<legend>Auction Details</legend>
				<div class="row">
					<div class="lft_heading">Reserve Price :</div>
					<div class="rgt_detail"><?= $reserve_price; ?></div>
				</div>
				
				<div class="row">
					<div class="lft_heading">Tender Fee :</div>
					<div class="rgt_detail"><?= $tender_fee; ?> </div>
				</div>
				<div class="row">
					<div class="lft_heading">Price Bid :</div>
					<div class="rgt_detail"><?= $price_bid_applicable; ?></div>
				</div>
				<div class="row">
					<div class="lft_heading">Bid Increment value :</div>
					<div class="rgt_detail"><?= $bid_inc; ?></div>
				</div>
				<div class="row">
					<div class="lft_heading">Auto Extension time :</div>
					<div class="rgt_detail"><?= $auto_extension_time; ?> (In Minutes)</div>
				</div>
				<div class="row">
					<div class="lft_heading">No. of Auto Extension :</div>
					<div class="rgt_detail"><?= $no_of_auto_extn; ?> </div>
				</div>
				<div class="row">
					<div class="lft_heading">DSC Required :</div>
					<div class="rgt_detail"><?= $dscStatus; ?> </div>
				</div>
				
					<fieldset class="fieldset1">
					<legend class="legend1">EMD Details</legend>
						<div class="row">
							<div class="lft_heading">EMD Amount :</div>
							<div class="rgt_detail"><?= $emd_amt; ?></div>
						</div>
						<div class="row">
							<div class="lft_heading">EMD Deposit Bank Name :</div>
							<div class="rgt_detail"><?= $nodelbranchname; ?></div>
						</div>
						<div class="row">
							<div class="lft_heading">EMD Deposit Bank Account Number :</div>
							<div class="rgt_detail"><?= $nodal_bank_account; ?></div>
						</div>
						<div class="row">
							<div class="lft_heading">EMD Deposit Bank IFSC Code :</div>
							<div class="rgt_detail"><?= $branch_ifsc_code; ?></div>
						</div>
						<div class="row">
							<div class="lft_heading">Bank :</div>
							<div class="rgt_detail"><?= $bank_name; ?></div>
						</div>
						<div class="row">
							<div class="lft_heading">Branch :</div>
							<div class="rgt_detail"><?= $branchname; ?></div>
						</div>
			</fieldset>
			</fieldset>
		<fieldset>
			<legend>Important Dates</legend>	
				<div class="row">
					<div class="lft_heading">Press Release Date :</div>
					<div class="rgt_detail"><?php if(isset($press_release_date) && $press_release_date!=''){  echo date('d M Y H:i',strtotime($press_release_date));}else if(isset($NIT_date) && $NIT_date!=''){ 
						echo date('d M Y H:i',strtotime($NIT_date));
					}else {echo "Not available";}?></div>
				</div>
				<div class="row">
					<div class="lft_heading">Date of Inspection of Property (From) :</div>
					<div class="rgt_detail"><?php if($inspection_date_from != '0000-00-00 00:00:00' && $inspection_date_from != ''){ ?><?= date('d M Y H:i',strtotime($inspection_date_from));?><?php }else{ echo "Not available";}?></div>
				</div><div class="row">
					<div class="lft_heading">Date of Inspection of Property (To) :</div>
					<div class="rgt_detail"><?php if($inspection_date_to != '0000-00-00 00:00:00' && $inspection_date_to != ''){ ?><?= date('d M Y H:i',strtotime($inspection_date_to));?><?php }else{ echo "Not available";}?></div>
				</div>
				<div class="row">
					<div class="lft_heading">Offer (First Round Quote) Submission Last Date :</div>
					<div class="rgt_detail"><?= date('d M Y H:i',strtotime($bid_last_date)); ?></div>
				</div>
				<div class="row">
					<div class="lft_heading">Offer (First Round Quote) Opening Date :</div>
					<div class="rgt_detail"><?= date('d M Y H:i',strtotime($bid_opening_date)); ?></div>
				</div>
				<div class="row">
					<div class="lft_heading">Auction Start Date and Time :</div>
					<div class="rgt_detail"><?= date('d M Y H:i',strtotime($auction_start_date)); ?></div>
				</div>
				<div class="row">
					<div class="lft_heading">Auction End Date and Time :</div>
					<div class="rgt_detail"><?= date('d M Y H:i',strtotime($auction_end_date)); ?></div>
				</div>
		</fieldset>
		<fieldset>
			<legend>Auction Related Documents</legend>
		
				<div class="row">
					<div class="lft_heading">View NIT Documents : </div>
					<div class="rgt_detail">
						<?php if (!empty($docName)) { ?>
							<?php /* ?>
							<a class="b_download float-right" style="font-size:12px; text-decoration:none;"   target="_blank" download="" href="/public/uploads/event_auction/<?php echo $docName ?>">Download</a>
							<?php */ ?>
							<?php
							 if($getCorrigendumRelatedDocImages!=''){  
									if (count($getCorrigendumRelatedDocImages) > 0) {
										$i = 0;
										foreach ($getCorrigendumRelatedDocImages as $key=>$getCorrigendumRelatedDoc) 
										{
											if($getCorrigendumRelatedDoc != '0'){ //Line added
												if($key == 0){
													?>
														<a class="b_download float-right" style="font-size:12px; text-decoration:none;"   target="_blank" download="" href="/public/uploads/event_auction/<?php echo $getCorrigendumRelatedDoc; ?>"><?php echo "Download"; ?></a><?php echo ", "; ?>
													<?php
												}else{
											
											?>
												<a class="b_download float-right" style="font-size:12px; text-decoration:none;"   target="_blank" download="" href="/public/uploads/event_auction/<?php echo $getCorrigendumRelatedDoc; ?>"><?php echo "Corrigendum".$i; ?></a>
												
											<?php
											echo ',';
												} //key
											
											}
											$i++;
										}
									//	echo $i;
										?>
										<a class="b_download float-right" style="font-size:12px; text-decoration:none;"   target="_blank" download="" href="/public/uploads/event_auction/<?php echo $docName ?>"><?php echo "Corrigendum".$i; ?></a>
										<?php
									}
									
							   }else{
						 ?> 
							<a class="b_download float-right" style="font-size:12px; text-decoration:none;"   target="_blank" download="" href="/public/uploads/event_auction/<?php echo $docName ?>">Download</a>
							<?php } ?>
							
							
							
							
						<?php } ?>
					</div>
				</div>
				<?php if (!empty($supporting_doc)) { ?>
					<div class="row">
						<div class="lft_heading">Special Terms and Conditions Document :</div>
						<div class="rgt_detail">
							<?php /* ?>
						   <a class="b_download float-right" style="font-size:12px; text-decoration:none;"   target="_blank" download="" href="/public/uploads/event_auction/<?php echo $supporting_doc; ?>">Download</a>      
						   <?php */ ?>
						   <?php
							 if($CorrigendumSupportingDocSpecialImages!=''){  
									if (count($CorrigendumSupportingDocSpecialImages) > 0) {
										$i = 0;
										foreach ($CorrigendumSupportingDocSpecialImages as $key=>$CorrigendumSupportingDocSpecial) {
												if($CorrigendumSupportingDocSpecial != '0'){ //Line added
												
													if($key == 0)
													{
													?>
													<a class="b_download float-right" style="font-size:12px; text-decoration:none;"   target="_blank" download="" href="/public/uploads/event_auction/<?php echo $CorrigendumSupportingDocSpecial; ?>"><?php echo "Download"; ?></a><?php echo ", "; ?>
													<?php
													}
													else
													{
											
											?>
												<a class="b_download float-right" style="font-size:12px; text-decoration:none;"   target="_blank" download="" href="/public/uploads/event_auction/<?php echo $CorrigendumSupportingDocSpecial; ?>"><?php echo "Corrigendum".$i; ?></a>
											<?php
												echo ',';
												}
												}
											$i++;
										}
										?>
										<a class="b_download float-right" style="font-size:12px; text-decoration:none;"   target="_blank" download="" href="/public/uploads/event_auction/<?php echo $supporting_doc; ?>"><?php echo "Corrigendum".$i; ?></a> 
										<?php
									}
							   }else{ 
							?>       
							<a class="b_download float-right" style="font-size:12px; text-decoration:none;"   target="_blank" download="" href="/public/uploads/event_auction/<?php echo $supporting_doc; ?>">Download</a> 
							<?php } ?>
						</div>
					 </div>
				 <?php } ?>
				<div class="row">
					<div class="lft_heading">Documents to be Submitted :</div>
					<div class="rgt_detail">
						<?php
							$maindocs = array();
							if (count($doc_to_be_submitted) > 0) {
								foreach ($doc_to_be_submitted as $docs) {
									$maindocs[] = $docs->name;
								}
								echo implode(',', $maindocs);
								?>
							<?php }?>
					</div>
				</div>
		
		<?php 
			if(isset($event_type) && $event_type!='drt' && !in_array($auctionID,$annexureNotShowEventArr)) 
			{ ?>
				<?php if (!empty($tender_doc)) { ?>
					<div class="row">
						<div class="lft_heading">Tender Documents :</div>
						<div class="rgt_detail">
							<a class="b_download float-right" style="font-size:12px; text-decoration:none;"   target="_blank" download="" href="<?php echo $tender_doc; ?>">Download</a>       
						</div>
					</div>
				<?php } ?>
        
				<?php if (!empty($annexure2)) { ?>
					<div class="row">
						<div class="lft_heading">Annexure 2/Details of Bidders :</div>
						<div class="rgt_detail">
							<a class="b_download float-right" style="font-size:12px; text-decoration:none;"   target="_blank" download="" href="<?php echo $annexure2; ?>">Download</a>       
						</div>
					</div>
				<?php }?>
				<?php if (!empty($annexure3)) { ?>
					<div class="row">
						<div class="lft_heading">Annexure 3/Declaration by Bidders :</div>
						<div class="rgt_detail">
							<a class="b_download float-right" style="font-size:12px; text-decoration:none;"   target="_blank" download="" href="<?php echo $annexure3; ?>">Download</a>       
						</div>
					</div>
				<?php }?>
		<?php } ?>
		</fieldset>
		
		<div class="row center-align">
			<?php if(isset($bankIdbyshortname) && $bankIdbyshortname!=''){ ?>
				<a href="<?= base_url(); ?><?php echo $bankShortname; ?>" class="button">Back</a>
				<?php }else{ ?>
				<a href="<?= base_url(); ?>" class="button">Back</a>
			<?php } ?>
			<?php
				$bid_last_date;
				$bid_last_date = strtotime($bid_last_date);
				$auction_end_date = strtotime($auction_end_date);
				$currenttime = strtotime(date('Y-m-d H:i:s'));
				$currenttime = (int) $currenttime;
				$bid_last_date = (int) $bid_last_date;
				if ($bid_last_date >= $currenttime) 
				{
					$userdID = $this->session->userdata('id');
					$user_type = $this->session->userdata('user_type');
					if ($userdID > 0) 
					{
						if ($user_type == 'owner' || $user_type == 'builder' || $user_type == 'broker') 
						{
							if ($userdID != $created_by && $userdID != $first_opener) 
							{
                        ?>
							<a href="/owner/auctionParticipage/<?php echo $auctionID; ?>" class="b_bidnow button">Participate</a>
						<?php }
							  else 
							  {
						?>
							<a href="javascript:"><input name="bid now" value="Participate" type="button" class="b_bidnow button"></a>	
						<?php }
						} 
						else 
						{
                        ?>
						<a href="javascript:"><input name="bid now" value="Participate" type="button" class="b_bidnow button"></a>

                    <?php } ?>

                <?php 
					} 
					else 
					{ 
				?>	
					<?php if($status != '4' && $status != '3') 
						{ 
							 if(isset($bankIdbyshortname) && $bankIdbyshortname!='')
							 { 
						?>
							<a class="b_bidnow button" href="/registration/bidderlogin?track=bidder&status=1&auctionID=<?php echo $auctionID; ?>&bu=<?php echo $bankShortname; ?>">Participate</a>
						<?php }else{ ?>
							<a href="/registration/bidderlogin?track=bidder&status=1&auctionID=<?php echo $auctionID; ?>" class="b_bidnow button">Participate</a>
							<?php } ?>
				 <?php  } ?>
					<?php
					}
				}
				else 
				{
					if ($auction_end_date < $currenttime) 
					{
                    ?>
						<a href="javascript:" class="b_bidnow button">Auctioned</a>
				<?php } else { ?>
						<a href="javascript:" class="b_bidnow button">Auction Is Live</a>
				<?php }
				} ?>
              </div>
        </div>
    </section>
