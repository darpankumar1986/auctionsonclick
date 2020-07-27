<!--Start: Added by Aziz For Popup -->
 <link rel="stylesheet" href="<?php echo base_url(); ?>css/colorbox.css" />
<script src="<?php echo base_url(); ?>js/jquery.colorbox.js"></script>
<script src="<?php echo base_url(); ?>js/banker.js"></script>
<!--End: Added by Aziz For Popup -->     
<link rel="stylesheet" href="<?php echo base_url(); ?>bankeauc/css/tables.css" type="text/css" media="screen"/>	
<script type="text/javascript" src="<?php echo base_url(); ?>js/dsc.js"></script>


<section class="container_12">	
   
<!--<div class="box-head">Event Corrigendum</div>
   <div class="box-content">
           <div class="row">
                   <p>
                   <span>Note : </span>Corrigendum has been issued for Offer (First Round Quote) Submission last date,
                   </p>
           </div>
           <div class="row">
                   <p>
                   <span>Notification : </span>Corrigendum has been issued for Offer (First Round Quote) Submission last date,
                   </p>
           </div>
   </div>-->
<div style="clear:both;"></div>
<?php if(is_array($corrigendum)){?> 
	<?php foreach($corrigendum as $key => $cor){ $comm = false; $docArr = array('','0',NULL);?>
	<?php if((trim($cor->old_product_description) != trim($cor->product_description)) ||  ($cor->old_NIT_date != $cor->NIT_date) || ($cor->old_bid_last_date != $cor->bid_last_date) || ($cor->old_inspection_date_from != $cor->inspection_date_from) || ($cor->old_inspection_date_to != $cor->inspection_date_to) || ($cor->old_bid_opening_date != $cor->bid_opening_date) || ($cor->old_auction_start_date != $cor->auction_start_date) || ($cor->old_auction_end_date != $cor->auction_end_date) || ($cor->old_related_doc != $cor->related_doc) || ($cor->old_supporting_doc != $cor->supporting_doc) || ($cor->old_image != $cor->image) || ($cor->old_status != $cor->status && $cor->status > 0)){?> 	
 
	<div class="box-head">
		Auction Corrigendum<?php 
			if(count($corrigendum) > 1)
			{
				echo $key+1;
			}
		?>
		
	</div>
		<div class="box-content">
			<div class="row">
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
						<?php //if($cor->old_supporting_doc != $cor->supporting_doc) {?>
						<?php if(($cor->old_supporting_doc != $cor->supporting_doc && !in_array($cor->old_supporting_doc,$docArr) && !in_array($cor->supporting_doc,$docArr)) || (in_array($cor->old_supporting_doc,$docArr) && !in_array($cor->supporting_doc,$docArr)) || (!in_array($cor->old_supporting_doc,$docArr) && in_array($cor->supporting_doc,$docArr)) ) {?>
							  <?php if($comm){ echo ",";} $comm = true; ?> 
							  Supporting Documents
						<?php } ?>
						<?php //if($cor->old_image != $cor->image) {?>
						<?php if(($cor->old_image != $cor->image && !in_array($cor->old_image,$docArr) && !in_array($cor->image,$docArr)) || (in_array($cor->old_image,$docArr) && !in_array($cor->image,$docArr)) || (!in_array($cor->old_image,$docArr) && in_array($cor->image,$docArr)) ) {?>
							  <?php if($comm){ echo ",";} $comm = true; ?> 
							  Images
						<?php } ?>
						<?php if($cor->old_status != $cor->status && $cor->status > 0) {?>
							  <?php if($comm){ echo ",";} $comm = true; ?> 
							  Status (<?php if($cor->status == 1)echo 'Public';if($cor->status == 4)echo 'Cancel'; if($cor->status == 3)echo 'Stay';?>)
						<?php } ?>
				</div>
		   </div>
		<?php } ?>
	<?php } ?>
<?php } 
/*
echo "<pre>";
print_r($auctionData);die;
*/
?>
<style>
	.row p {
    font-size: 1em !important;
    text-transform: capitalize !important;
}
</style>
<div class="box-head">View Auction</div>
<div class="box-content">

  <table border="1" align="left" cellpadding="2" cellspacing="1" class="mytable dataTable" id="big_table" aria-describedby="big_table_info">
<tbody role="alert" aria-live="polite" aria-relevant="all">
 
     <tr class="even">
            <td align="left" valign="top" class="" style="width: 22%;"><strong>Auction ID : </strong></td>
            <td align="left" valign="top" class="" style="width: 28%;"><?php echo $auctionData[0]->id; ?></td>
            <td align="left" valign="top" class="" style="width: 22%;"><strong>Property ID </span></strong></td>
            <td align="left" valign="top" class="" style="width: 28%;"><?php echo $auctionData[0]->reference_no; ?></td>
      </tr>
     <tr class="odd">
            <td align="left" valign="top" class="" style="width: 22%;"><strong>Auction Reference Dispatch Date </strong></td>
            <td align="left" valign="top" class="" style="width: 28%;"><?php echo ($auctionData[0]->dispatch_date != '1970-01-01' && $auctionData[0]->dispatch_date != '0000-00-00') ? date('d-m-Y', strtotime($auctionData[0]->dispatch_date)): "N/A"; ?></td>
            <td align="left" valign="top" class="" style="width: 22%;"><strong>Property Address </span></strong></td>
            <td align="left" valign="top" class="" style="width: 28%;"><?php echo ucwords($auctionData[0]->PropertyDescription); ?></td>
      </tr>
      <tr class="even">
		<td align="left" valign="top" class=""><strong>Plot Area</strong></td>
		<td align="left" valign="top" class=""><?php echo ($auctionData[0]->property_height != '')?$auctionData[0]->property_height:'N/A';?></td>
		<td align="left" valign="top" class=""><strong>Plot Area Unit</strong></td>
		<td align="left" valign="top" class="">
		<?php
			$cauom = GetTitleByField('tblmst_uom_type', "uom_id='".$auctionData[0]->height_unit_id."'" ,'uom_name');
			echo ($cauom !='')?$cauom:'N/A';
		?>  
		</td>
	  </tr>
       <tr class="even">
            <td align="left" valign="top" class=""><strong>Carpet Area </strong></td>
            <td align="left" valign="top" class=""><?php echo ($auctionData[0]->area!='')?$auctionData[0]->area:'N/A'; ?></td>
            <td align="left" valign="top" class=""><strong>Carpet Area Unit </strong></td>
            <td align="left" valign="top" class=""><?php echo ($areaUnit!='')?$areaUnit:'N/A';  ?></td>
      </tr>
      <tr class="odd">
            <td align="left" valign="top" class=""><strong>Category/ Property Type</strong></td>
            <td align="left" valign="top" class=""><?php echo $catename; ?></td>
            <td align="left" valign="top" class=""><strong>Corner</strong></td>
            <td align="left" valign="top" class=""><?php echo($auctionData[0]->is_corner_property==1)? 'Yes':'No'; ?></td>
      </tr>
     
       <tr class="even">
            <td align="left" valign="top" class=""><strong>Scheme Id </strong></td>
            <td align="left" valign="top" class=""><?php echo ($auctionData[0]->scheme_id)? $auctionData[0]->scheme_id:'N/A';?></td>
            <td align="left" valign="top" class=""><strong>Scheme Name </strong></td>
            <td align="left" valign="top" class=""><?php echo ($auctionData[0]->scheme_name)?ucfirst(strtolower($auctionData[0]->scheme_name)):'N/A';?></td>
      </tr>
      
      <tr class="odd">
            <td align="left" valign="top" class=""><strong>Name of Owner/ Occupier as per MCG record </strong></td>
            <td align="left" valign="top" class=""><?php echo ($auctionData[0]->service_no)? $auctionData[0]->service_no :'N/A';?></td>
            <td align="left" valign="top" class=""><strong>Concerned Zone </strong></td>
            <td align="left" valign="top" class=""><?php echo $auctionData[0]->zone_id; ?></td>
      </tr>
     
       <tr class="even">
            <td align="left" valign="top" class=""><strong>Applicable FAR</strong></td>
            <td align="left" valign="top" class=""><?php echo ($auctionData[0]->far)?ucfirst(strtolower($auctionData[0]->far)):'N/A';?></td>
            <td align="left" valign="top" class=""><strong>Plot Area</strong></td>
            <td align="left" valign="top" class=""><?php echo ($auctionData[0]->property_height)?$auctionData[0]->property_height:'N/A';?></td>
      </tr>
     
      <tr class="odd">
            <td align="left" valign="top" class=""><strong>Plot Area Unit</strong></td>
            <td align="left" valign="top" class=""><?php echo ($heightUnit)?$heightUnit:'N/A';?></td>
            <td align="left" valign="top" class=""><strong>Max Coverage Area</strong></td>
            <td align="left" valign="top" class=""><?php echo ($auctionData[0]->max_coverage_area)?$auctionData[0]->max_coverage_area:'N/A';?></td>
      </tr
      
       <tr class="even">
            <td align="left" valign="top" class=""><strong>Reserve Price</strong></td>
            <td align="left" valign="top" class=""><?php echo $auctionData[0]->reserve_price;?></td>
            <td align="left" valign="top" class=""><strong>Reserve Price (Unit)</strong></td>
            <td align="left" valign="top" class=""><?php echo GetTitleByField('tblmst_uom_type', "uom_id='".$auction_data[0]->unit_id_of_price."'" ,'uom_name'); ?></td>
      </tr>
       <tr class="odd">
            <td align="left" valign="top" class=""><strong>EMD Amount</strong></td>
            <td align="left" valign="top" class=""><?php echo $auctionData[0]->emd_amt; ?></td>
            <td align="left" valign="top" class=""><strong>Bank Processing Fee</strong></td>
            <td align="left" valign="top" class=""><?php echo $auctionData[0]->tender_fee;?></td>
      </tr>
      <?php /* ?><tr class="even">
            
            <td align="left" valign="top" class=""><strong>Administrative Fee</strong></td>
            <td align="left" valign="top" class=""><?php echo ADMINISTRATIVE_FEE; ?></td>  
            <td align="left" valign="top" class="">-</td>
            <td align="left" valign="top" class="">-</td>
        </tr><?php */ ?>
     
       <tr class="odd">
            <td align="left" valign="top" class=""><strong>Press Release Date</strong></td>
            <td align="left" valign="top" class=""><?php echo date("d-m-Y",strtotime($press_release_date));?></td>
            <td align="left" valign="top" class=""><strong>Site Visit Start Date</strong></td>
            <td align="left" valign="top" class=""><?php if(($inspection_date_from != '1970-01-01') && ($inspection_date_from != '0000-00-00 00:00:00') && ($inspection_date_from != '')){ echo date("d-m-Y H:i",strtotime($inspection_date_from)) ; }else{ echo "N/A";} ?></td>
      </tr>
      
       <tr class="even">
            <td align="left" valign="top" class=""><strong>Site Visit End Date</strong></td>
            <td align="left" valign="top" class=""><?php if(($inspection_date_to != '1970-01-01') && ($inspection_date_to != '0000-00-00 00:00:00') && ($inspection_date_to != '')){  echo date("d-m-Y H:i",strtotime($inspection_date_to)) ; }else{ echo "N/A";} ?></td>
            <td align="left" valign="top" class=""><strong>Apply And EMD Start Date</strong></td>
            <td align="left" valign="top" class=""><?php if($auctionData[0]->registration_start_date != '0000-00-00 00:00:00' && $auctionData[0]->registration_start_date != ''){ echo date("d-m-Y H:i",strtotime($auctionData[0]->registration_start_date)) ; }else{ echo "N/A";} ?></td>
      </tr>
      
       <tr class="odd">
            <td align="left" valign="top" class=""><strong>Apply And EMD End Date</strong></td>
            <td align="left" valign="top" class=""><?php if($bid_last_date != '0000-00-00 00:00:00' && $bid_last_date != ''){ echo date("d-m-Y H:i",strtotime($bid_last_date)); }else{ echo "N/A";} ?></td>
            <td align="left" valign="top" class=""><strong>Auction Start date</strong></td>
            <td align="left" valign="top" class=""><?php echo date("d-m-Y H:i",strtotime($auction_start_date)) ; ?></td>
      </tr>
      
       <tr class="even">
            <td align="left" valign="top" class=""><strong>Auction End date</strong></td>
            <td align="left" valign="top" class=""><?php echo date("d-m-Y H:i",strtotime($auction_end_date)) ; ?></td>
            <td align="left" valign="top" class=""><strong>Mode of Bid</strong></td>
            <td align="left" valign="top" class=""><?php echo $auctionData[0]->mode_of_bid;?></td>
      </tr>
      
       <tr class="odd">
            <td align="left" valign="top" class=""><strong>Price Bid</strong></td>
            <td align="left" valign="top" class=""><?php echo ($price_bid_applicable !='not_applicable') ? $price_bid_applicable : 'N/A'; ?></td>
            <td align="left" valign="top" class=""><strong>Auto Bid Allow</strong></td>
            <td align="left" valign="top" class=""><?php echo ($auctionData[0]->auto_bid_cut_off ==1) ? 'Yes' : 'No'; ?></td>
      </tr>
      
       <tr class="even">
            <td align="left" valign="top" class=""><strong>Bid Increment value</strong></td>
            <td align="left" valign="top" class=""><?php echo $bid_inc; ?></td>
            <td align="left" valign="top" class=""><strong>Auto Extension time</strong></td>
            <td align="left" valign="top" class=""><?php echo ($auto_extension_time !='') ? $auto_extension_time: 'N/A'?> (In Minutes)</td>
      </tr>
     
       <tr class="odd">
            <td align="left" valign="top" class=""><strong>No. of Auto Extension</strong></td>
            <td align="left" valign="top" class=""><?php echo ($no_of_auto_extn !='')? $no_of_auto_extn: 'N/A'; ?></td>
            <td align="left" valign="top" class=""><strong>1st Contact Person Details</strong></td>
            <td align="left" valign="top" class=""><?php echo $auctionData[0]->contact_person_details_1; ?> </td>
      </tr>
      
       <tr class="even">
            <td align="left" valign="top" class=""><strong>2nd Contact Person Details</strong></td>
            <td align="left" valign="top" class=""><?php echo ($auctionData[0]->contact_person_details_2 !='') ? $auctionData[0]->contact_person_details_2:'N/A';?></td>
            <td align="left" valign="top" class=""><strong>How to Reach</strong></td>
            <td align="left" valign="top" class=""><a target="_blank" href="<?php echo base_url().'owner/viewGoogleMap/'. $auctionData[0]->id;?>">View</a></td>
      </tr>
      
       <tr class="odd">
            <td align="left" valign="top" class=""><strong>View Documents</strong></td>
            <td align="left" valign="top" class="">
                <?php if(is_array($uploadedDocs) && count($uploadedDocs)>0){	
                    echo '<a target="_blank" href="'.base_url().'owner/viewEventDocuments/' . $uploadedDocs[0]->auction_id . '"  >View</a>';
		} else {
                    echo "N/A";
		}
		?>
            </td>
            <td align="left" valign="top" class=""><strong>Any Documents Pertinent To The Auction</strong></td>
            <td align="left" valign="top" class="">
                <?php
            $maindocs = array();
            if (count($doc_to_be_submitted) > 0 && $doc_to_be_submitted !=0) {
                foreach ($doc_to_be_submitted as $docs) {
                    $maindocs[] = $docs->name;
                }
                echo implode(',', $maindocs);
            }else{ echo "None";}
            ?>
            </td>
            
      </tr>
      
       <tr class="even">

      <?php if (!empty($supporting_doc) && $supporting_doc!='0') { ?>
            <td align="left" valign="top" class=""><strong>Special Terms and Conditions Document</strong></td>
            
            <td td align="left" valign="top" class="">
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
            </td>
            <?php } ?>
            
            <?php if ($product_image!='') { ?>
            <td align="left" valign="top" class=""> <strong>View Images</strong></td>
            <td align="left" valign="top" class="">
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
            </td>
            <?php } ?>
      </tr>
      <tr class="even">
            <td align="left" valign="top" class=""><strong>Remark</strong></td>
            <td align="left" valign="top" class=""><?php echo ($auctionData[0]->remark)?ucfirst(strtolower($auctionData[0]->remark)):'N/A';?></td>
      </tr>
      
      <?php
        $bidder_id    =   $this->session->userdata('id');
        $auction_id   =   $auctionData[0]->id;
        $payment_status = json_decode(GetTitleByField('tbl_jda_payment_log', "auction_id='".$auction_id."' and bidder_id='".$bidder_id."' ORDER BY payment_log_id DESC",'payment_response'));
        $document_required = GetTitleByField('tbl_auction', "id='".$auction_id."'",'doc_to_be_submitted');
        $final_submit = GetTitleByField('tbl_auction_participate', "auctionID='".$auction_id."' and bidderID='".$bidder_id."' ",'final_submit');
    
        ?>
      <?php if($final_submit == '1'): ?>
      <tr class="odd">
            <td align="left" valign="top" class=""><strong>EMD/Payment Status</strong></td>
            <td align="left" valign="top" class="">
                <a class='emd_detail_iframe' href="/owner/emdDetailPopupData/<?php echo $bidder_id;?>/<?php echo $auction_id;?>"><?php echo $payment_status->ChallanPaymentDetails[0]->PaymentStatus; ?></a>
            </td>
            <td align="left" valign="top" class=""><strong>View Uploaded Documents</strong></td>
            <td td align="left" valign="top" class="">
                <?php if($document_required != 0 && $document_required != ''){ ?>
                <a class='tenderfee_detail_iframe' href="/owner/docDetailPopupData/<?php echo $bidder_id;?>/<?php echo $auction_id;?>">Docs</a>
                <?php } else { echo "N/A";} ?>
            </td>
      </tr>
      <?php endif; ?>
</tbody>    
  </table>
  <!-- Azizur class="emd_detail_iframe cboxElement"  emd_detail_iframe############################################################################################-->
  
      <hr>
    <div class="row" style="text-align:center;">
        <a href="<?= base_url(); ?>owner" class="button_grey">Back</a>
        <br><br><br><br>
        <?php
        $bid_last_date;
        $bid_last_date = strtotime($bid_last_date);
        $auction_end_date = strtotime($auction_end_date);
        //$currenttime=time();
        $currenttime = strtotime(date('Y-m-d H:i:s'));

        $currenttime = (int) $currenttime;
        $bid_last_date = (int) $bid_last_date;
        if ($bid_last_date >= $currenttime) {
            $userdID = $this->session->userdata('id');
            $user_type = $this->session->userdata('user_type');
            
         if ($userdID > 0) {
                if ($user_type == 'owner' || $user_type == 'builder' || $user_type == 'broker') {
                    if ($userdID != $created_by && $userdID != $first_opener) {
                        ?>
                       
                <?php } else {
                ?>
                      	
            <?php }
        } else {
            ?>
              

                    <?php } ?>

                <?php } else { ?>	
             
                <?php
                }
            } else {

                if ($auction_end_date < $currenttime) {
                    ?>
                    
        <?php } else {
        ?>
                    
    <?php }
} ?>
              </div>
            </div>
            </section>
