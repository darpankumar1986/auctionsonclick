<style>
    #spMsg {padding:15px 0 0 0;}
    #spMsg  li{font-size:13px; color:#F00; padding:0 5px; line-height:30px; margin-bottom:1px; background:#ffd8db;}
</style>
<?php
/*
  echo "<pre><br><br><br><br><br><br><br><br><br><br>";
  print_r($uploadedDocs);
  print_r($upload_document_field);die;
 */
$productID = $prows->id;
$drt_user = $this->session->userdata('user_type');
if ($drt_user != 'drt') {
    $bank_id = $this->session->userdata['bank_id'];
}

$drt_id = $erows->drt_id;
$closeBidderAuctionRows = $this->banker_model->getAllCloseAuctionBidder($auctionID);
$eventid = '';
$city = $auctionData->city;
$state = $auctionData->state;
$country = $auctionData->countryID;
$other_city = $auctionData->other_city;
?>
<script  type="text/javascript" src="<?php echo base_url(); ?>/js/texteditor/ckeditor.js"></script> 
<script type="text/javascript" src="https://maps.googleapis.com/maps/api/js?key=AIzaSyBULmzbAb2RGK6kViBw6cgjbyecvfNKIDQ"></script>
<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/1.7.2/jquery.min.js"></script>
<link rel="stylesheet" href="<?php echo base_url() ?>/css/colorbox.css" />
<script src="<?php echo base_url() ?>/js/jquery.colorbox.js"></script>
<link rel="stylesheet" href="<?php echo base_url() ?>js/calender/jquery-ui.css">
<script src="<?php echo base_url(); ?>js/calender/jquery-ui.js"></script>
<script type="text/javascript" src="<?php echo base_url() ?>js/calender/jquery-ui-timepicker-addon.min.js"></script>
<link rel="stylesheet" href="<?php echo base_url() ?>js/calender/jquery-ui-timepicker-addon.css">
<script type="text/javascript" src="<?php echo base_url(); ?>js/calender/i18n/jquery-ui-timepicker-addon-i18n.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/calender/jquery-ui-sliderAccess.js"></script>
<script type="text/javascript" src="/application/views/admin/js/plugins/jquery.validate.min.js"></script>
<?php //echo $breadcrumb; ?>
<section class="body_main1">
    <div class="row ">
        <div class="wrapper-full">
            <div class="dashboard-wrapper">
                <?php /* ?>
                  <div class="search-row">
                  <div class="srch_wrp">
                  <input type="text" value="Search" id="search" name="search">
                  <span class="ser_icon"></span>
                  </div>
                  <a href="#">Advance Search+</a>
                  </div>
                  <?php */ ?>
                <div id="tab-pannel3" class="btmrgn">
                    <div class="tab_container3">
                        <!-- #tab1 -->
                        <div id="tab6" class="tab_content3">
                            <div class="container">
                                <?php echo $leftPanel ?>
                                <div class="secttion-right">
                                    <div class="table-wrapper btmrg20">
                                        <div class="table-heading btmrg">
                                            <div class="box-head no_cursor">View Auction</div>
                                        </div>
                                        <div class="table-section">
                                           
                                            <?php
                                            $formAction = '/buyer/publishApprovedData/' . $auctionID;
                                            ?>	
                                            <form method="post" enctype="multipart/form-data" name="createauction" id="createauction" action="<?php echo $formAction; ?>">
                                                <input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash(); ?>" />
                                                <input type="hidden" name="dartEvent" id="drtEvent" value="<?php
                                                if ($drt_user == 'drt') {
                                                    echo '1';
                                                } else {
                                                    echo '0';
                                                };
                                                ?>" />
                                                <!--show error popup-->		  
                                                <p style="display:block;"><a class='inline' href="#inline_content"></a></p>
                                                <div style='display:none'>
                                                    <div id='inline_content' style='padding:10px; background:#fff;'>
                                                        <ul id="spMsg" style="color:#CC0000;"></ul>
                                                    </div>
                                                </div>
                                                <?php if (isset($this->session->userdata['flash:old:message'])) { ?>
                                                    <div class="success_msg"> <?php echo @$this->session->userdata['flash:old:message']; ?></div>
                                                <?php } ?>
                                                <!--show error popup -->
                                                <div class="form box-content2">

                                                    <input type="hidden" value="<?php echo $userID; ?>" name="first_opener"/>
                                                    <div class="plain row">
                                                        <div class="lft_heading">Institution:</div>
                                                        <div class="rgt_detail">

                                                            <?php
                                                            foreach ($accountType as $account_record) {
                                                                if ($account_record->account_id == $auctionData->account_type_id) {
                                                                    echo '<span>' . $account_record->account_name . '</span>';
                                                                }
                                                            }
                                                            ?>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="lft_heading">Property ID:</div>
                                                        <div class="rgt_detail">
                                                            <span><?php echo $auctionData->reference_no; ?></span>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="lft_heading">Auction Reference Dispatch Date: </div>
                                                        <div class="rgt_detail">
                                                            <span><?php echo (($auctionData->dispatch_date != '1970-01-01') && ($auctionData->dispatch_date != '0000-00-00')) ? date('d-m-Y', strtotime($auctionData->dispatch_date)) : 'N/A'; ?></span>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="lft_heading">Property Address:</div>
                                                        <div class="rgt_detail">
                                                            <span><?php echo $auctionData->PropertyDescription; ?></span>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="lft_heading">Carpet Area:</div>
                                                        <div class="rgt_detail">
                                                            <span><?php echo ($auctionData->area!='')?$auctionData->area:'N/A'; ?></span>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="lft_heading">Carpet Area Unit:</div>
                                                        <div class="rgt_detail">
														<?php
															$cauom = GetTitleByField('tblmst_uom_type', "uom_id='".$auctionData->area_unit_id."'" ,'uom_name');
															echo ($cauom !='')?$cauom:'N/A';
														?>  
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="lft_heading">Category/ Property Type:</div>
                                                        <div class="rgt_detail">
                                                            <?php
                                                            foreach ($category as $category_record) {
                                                                if ($category_record->id == $prows->product_type) {
                                                                    echo '<span>' . $category_record->name . '</span>';
                                                                }
                                                            }
                                                            ?>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="lft_heading">Corner: </div>
                                                        <div class="rgt_detail">
                                                            <span><?php echo ($auctionData->is_corner_property == 1) ? 'Yes' : 'No'; ?></span>
                                                        </div>
                                                    </div>

                                                    <hr>
                                                    <div class="seprator btmrg20"></div>
                                                    <div class="row">
                                                        <div class="lft_heading">Department Name: </div>
                                                        <div class="rgt_detail">
                                                            <?php $department_name = GetTitleByField('tblmst_department', "department_id='" . $auctionData->department_id . "' and status=1", 'department_name'); ?>
                                                            <span><?php echo ($department_name != '') ? $department_name : 'N/A'; ?></span>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="lft_heading">Scheme Id: </div>
                                                        <div class="rgt_detail">

                                                            <span><?php echo ($auctionData->scheme_id != '') ? $auctionData->scheme_id : 'N/A'; ?></span>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="lft_heading">Scheme Name: </div>
                                                        <div class="rgt_detail">
                                                            <span><?php echo ($auctionData->scheme_name != '') ? $auctionData->scheme_name : 'N/A'; ?></span>
                                                        </div>
                                                    </div>


                                                    <div class="row">
                                                        <div class="lft_heading">Name of Owner/ Occupier as per MCG record: </div>
                                                        <div class="rgt_detail">
                                                            <span><?php echo ($auctionData->service_no != '') ? $auctionData->service_no : 'N/A'; ?></span>
                                                        </div>
                                                    </div>
                                                    <div class="row">
                                                        <div class="lft_heading">Concerned Zone:</div>
                                                        <div class="rgt_detail">
                                                            <?php
                                                            foreach ($zoneArr as $za) {
                                                                if ($za->zone_id == $auctionData->zone_id) {
                                                                    echo '<span>' . $za->zone_name . '</span>';
                                                                }
                                                            }
                                                            ?>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="lft_heading">Applicable FAR: </div>
                                                        <div class="rgt_detail">
                                                            <span><?php echo ($auctionData->far != '') ? $auctionData->far : 'N/A'; ?></span>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="lft_heading">Plot Area: </div>
                                                        <div class="rgt_detail">
                                                            <span><?php echo ($auctionData->property_height != '') ? $auctionData->property_height : 'N/A'; ?></span>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="lft_heading">Plot Area Unit: </div>
                                                        <div class="rgt_detail">
                                                            <?php
                                                            foreach ($heightUomType as $hut) {
                                                                if ($hut->height_uom_id==$auctionData->height_unit_id) {
                                                                    echo '<span>' . $hut->height_uom_name . '</span>';
                                                                }
                                                            }
                                                            if ($auctionData->height_unit_id == 0) {
                                                                echo 'N/A';
                                                            }
                                                            ?>
                                                        </div>
                                                    </div>

                                                    <div class="row">
                                                        <div class="lft_heading">Max Coverage Area: </div>
                                                        <div class="rgt_detail">
                                                            <span><?php echo ($auctionData->max_coverage_area != '') ? $auctionData->max_coverage_area : 'N/A'; ?></span>
                                                        </div>

                                                        <div class="row">
                                                            <div class="lft_heading">Reserve Price:</div>
                                                            <div class="rgt_detail">
                                                                <span><?php echo ($auctionData->reserve_price != '') ? $auctionData->reserve_price : 'N/A'; ?></span>
                                                            </div>
                                                        </div>

                                                        <div class="row">
                                                            <div class="lft_heading">Unit of Price:</div>
                                                            <div class="rgt_detail">
                                                                <?php
                                                                foreach ($uomType as $ut) {
                                                                    if ($ut->uom_id == $auctionData->unit_id_of_price) {
                                                                        echo '<span>' . $ut->uom_name . '</span>';
                                                                    }
                                                                }
                                                                ?>
                                                            </div>
                                                        </div>

                                                        <div class="row">
                                                            <div class="lft_heading">EMD Amount:</div>
                                                            <div class="rgt_detail">
                                                                <span><?php echo ($auctionData->emd_amt != '') ? $auctionData->emd_amt : 'N/A'; ?></span>
                                                            </div>
                                                        </div>

                                                        <div class="row">
                                                            <div class="lft_heading">Bank Processing Fee:</div>
                                                            <div class="rgt_detail">
                                                                <span><?php echo ($auctionData->tender_fee != '') ? $auctionData->tender_fee : 'N/A'; ?></span>
                                                            </div>
                                                        </div>



                                                        <div class="row">
                                                            <div class="lft_heading">Press Release Date:</div>
                                                            <div class="rgt_detail">
                                                                <span><?php echo ($auctionData->press_release_date != '1970-01-01 05:30:00') ? date('d-m-Y H:i:s', strtotime($auctionData->press_release_date)) : 'N/A'; ?></span>
                                                            </div>
                                                        </div>

                                                        <div class="row">
                                                            <div class="lft_heading">Site Visit Start Date:</div>
                                                            <div class="rgt_detail">
                                                                <span><?php echo ($auctionData->inspection_date_from != '' && $auctionData->inspection_date_from != '0000-00-00 00:00:00') ? date('d-m-Y H:i:s', strtotime($auctionData->inspection_date_from)) : 'N/A'; ?>
                                                                </span>
                                                            </div>
                                                        </div>

                                                        <div class="row">
                                                            <div class="lft_heading">Site Visit End Date:</div>
                                                            <div class="rgt_detail">
                                                                <span> <?php
                                                                    echo ($auctionData->inspection_date_to != '' && $auctionData->inspection_date_to != '0000-00-00 00:00:00') ? date('d-m-Y H:i:s', strtotime($auctionData->inspection_date_to)) : 'N/A';
                                                                    ?>
                                                                </span>
                                                            </div>
                                                        </div>

                                                        <div class="row">
                                                            <div class="lft_heading">Apply And EMD Start Date:</div>
                                                            <div class="rgt_detail">
                                                                <span><?php echo ($auctionData->registration_start_date != '1970-01-01 05:30:00') ? date('d-m-Y H:i:s', strtotime($auctionData->registration_start_date)) : 'N/A'; ?></span>
                                                            </div>
                                                        </div>

                                                        <div class="row">
                                                            <div class="lft_heading">Apply And EMD End Date:</div>
                                                            <div class="rgt_detail">
                                                                <span><?php echo ($auctionData->bid_last_date != '1970-01-01 05:30:00') ? date('d-m-Y H:i:s', strtotime($auctionData->bid_last_date)) : 'N/A'; ?></span>
                                                            </div>
                                                        </div>

                                                  <!--   <div class="row">
                                                            <div class="lft_heading">Shortlisting Start Date:</div>
                                                            <div class="rgt_detail">
                                                                <span><?php //echo ($auctionData->bid_opening_date != '1970-01-01 05:30:00') ? date('d-m-Y H:i:s', strtotime($auctionData->bid_opening_date)) : 'N/A'; ?></span>
                                                            </div>
                                                        </div>
                                                    -->

                                                        <div class="row">
                                                            <div class="lft_heading">Auction Start date:</div>
                                                            <div class="rgt_detail">
                                                                <span><?php echo ($auctionData->auction_start_date != '1970-01-01 05:30:00') ? date('d-m-Y H:i:s', strtotime($auctionData->auction_start_date)) : 'N/A'; ?></span>
                                                            </div>
                                                        </div>

                                                        <div class="row">
                                                            <div class="lft_heading">Auction End date:</div>
                                                            <div class="rgt_detail">
                                                                <span><?php echo ($auctionData->auction_end_date != '1970-01-01 05:30:00') ? date('d-m-Y H:i:s', strtotime($auctionData->auction_end_date)) : 'N/A'; ?></span>
                                                            </div>
                                                        </div>

                                                        <div class="row">
                                                            <div class="lft_heading">Mode of Bid:</div>
                                                            <div class="rgt_detail">
                                                                <span><?php echo ($auctionData->mode_of_bid == 'online') ? 'Online' : 'Offline'; ?></span>
                                                            </div>
                                                        </div>

                                                        <div class="plain row">
                                                            <div class="lft_heading">Is DSC Enabled:</div>
                                                            <div class="rgt_detail">
                                                                <span><?php echo ($auctionData->dsc_enabled == 1) ? "Yes" : "No" ?></span>
                                                            </div>
                                                        </div>

                                                        <div class="row">
                                                            <div class="lft_heading">Auto Bid Allow:</div>
                                                            <div class="rgt_detail">
                                                                <span><?php echo ($auctionData->allow_auto_bid == 1) ? "Yes" : "No" ?></span>
                                                            </div>
                                                        </div>

                                                        <div class="row">
                                                            <div class="lft_heading">Bid Increment value:</div>
                                                            <div class="rgt_detail">
                                                                <span><?php echo ($auctionData->bid_inc != '0.00') ? $auctionData->bid_inc : "0.00"; ?></span>
                                                            </div>
                                                        </div>

                                                        <div class="row">
                                                            <div class="lft_heading">Auto Extension time (In Minutes.):</div>
                                                            <div class="rgt_detail">
                                                                <span><?php echo ($auctionData->auto_extension_time != '0') ? $auctionData->auto_extension_time : "0"; ?></span>
                                                            </div>
                                                        </div>

                                                        <div class="row">
                                                            <div class="lft_heading">Auto Extension(s):</div>
                                                            <div class="rgt_detail">
                                                                <span><?php echo ($auctionData->auto_extension_time >0 && $auctionData->no_of_auto_extn == '0') ? "Unlimited": $auctionData->no_of_auto_extn; ?></span>
                                                            </div>
                                                        </div>

                                                        <div class="row">
                                                            <div class="lft_heading">Property Latitude:</div>
                                                            <div class="rgt_detail">
                                                                <span><?php echo ($auctionData->latitude != '') ? $auctionData->latitude : "N/A"; ?></span>
                                                            </div>
                                                        </div>

                                                        <div class="row">
                                                            <div class="lft_heading">Property Longitude</div>
                                                            <div class="rgt_detail">
                                                                <span><?php echo ($auctionData->longitude != '') ? $auctionData->longitude : "N/A"; ?></span>
                                                            </div>
                                                        </div>

                                                        <div class="row">
                                                            <div class="lft_heading">1st Contact Person Details:</div>
                                                            <div class="rgt_detail">

                                                            </div><span><?php echo ($auctionData->contact_person_details_1 != '') ? $auctionData->contact_person_details_1 : "N/A"; ?></span>
                                                        </div>

                                                        <div class="row">
                                                            <div class="lft_heading">2nd Contact Person Details</div>
                                                            <div class="rgt_detail">

                                                            </div> <span><?php echo ($auctionData->contact_person_details_2 != '') ? $auctionData->contact_person_details_2 : "N/A"; ?></span>
                                                        </div>

                                                        <?php
                                                        //echo "<pre>"; print_r($uploadedDocs); echo "</pre><br>";                                       

                                                        if (is_array($upload_document_field) && count($upload_document_field) > 0) {
                                                            foreach ($upload_document_field as $key => $udf) {
                                                                ?>
                                                                <div class="row">
                                                                    <div class="lft_heading"><?php echo $udf->upload_document_field_name; ?>: </div>
                                                                    <?php $fieldName = strtolower(str_replace(' ', '_', $udf->upload_document_field_name)); ?>							
                                                                    <div class="rgt_detail">
                                                                        <?php
                                                                        foreach ($uploadedDocs as $ud) {
                                                                            $upload_document_field_id_arr[] = $ud->upload_document_field_id;
                                                                            if ($ud->upload_document_field_id == $udf->upload_document_field_id) {
                                                                                ?> 
                                                                                <a download href="/public/uploads/event_auction/<?php echo $ud->file_path; ?>">View</a>	
                                                                                <?php
                                                                            }
                                                                        }
                                                                        if (!in_array($udf->upload_document_field_id, $upload_document_field_id_arr)) {
                                                                            echo "N/A";
                                                                        }

                                                                        /* if($udf->isMandatory != 0){
                                                                          echo 'N/A';

                                                                          } */
                                                                        ?>
                                                                    </div>
                                                                </div>
                                                                <?php
                                                            }
                                                        }
                                                        ?>

                                                        <div class="row">
                                                            <div class="lft_heading">Any Documents Pertinent To The Auction: </div>
                                                            <div class="rgt_detail">

                                                                <?php
                                                                if ($auctionData->doc_to_be_submitted) {
                                                                    $docsubArr = explode(',', $auctionData->doc_to_be_submitted);
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

                                                            </div>
                                                        </div>
                                                        <div class="row">
                                                            <div class="lft_heading">Remark:</div>
                                                            <div class="rgt_detail">
                                                                <span><?php echo ($auctionData->remark != '') ? $auctionData->remark : 'N/A'; ?></span>
                                                            </div>
                                                        </div>

                                                        <?php /*
                                                          if ($drt_user != 'drt') {
                                                          ?>
                                                          <div class="row" id="div_second_opener">
                                                          <div class="lft_heading">Auction Approvers:</div>
                                                          <div class="rgt_detail">
                                                          <?php
                                                          if (is_array($approverArr) && count($approverArr) > 0) {

                                                          foreach ($approverArr as $approver) {
                                                          if($approver->id == $auctionData->second_opener){
                                                          echo '<span>'.$approver->email_id.'</span>';
                                                          }
                                                          }
                                                          }
                                                          ?>

                                                          </div>
                                                          </div>
                                                          <?php }
                                                         */ ?>

                                                        <div class="seprator btmrg20"></div>
                                                        <div class="button-row row" style="text-align:center;">
                                                            <a href="/buyer/savedEvents/" style="font-size:0; padding-right:5px;" class="b_submit button_grey">Back</a>
                                                            <!----> 						

                                                            <?php
                                                            if ($auctionData->approvalStatus == 2) {
                                                                ?>
                                                                <!-- <input name="Publish" value="Publish" onclick="return validateSubmitform('Publish');" type="submit" class="b_submit button_grey float-right"> -->
                                                                <input name="Publish" value="Publish" type="submit" onclick="return confirm('Are you sure you want to publish this auction ?');" class="b_submit button_grey float-right">
                                                                <!-- <input name="Publish" value="Publish" type="submit" class="b_submit button_grey float-right"> -->

                                                                <?php
                                                            }
                                                            ?>
                                                            <input type="hidden" name="auctionID" id="auctionID" value="<?php echo $auctionID ?>">

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
<div id="dialog" style="display: none">
    <div id="dvMap" style="height: 380px; width: 580px;">
