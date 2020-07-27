<?php
//echo "<pre>";
//print_r($auction_data);
//echo "</pre>";
//echo "latest-".$latest_frq;
//echo "<br>id-".$auction_participateID;
?>
<link rel="stylesheet" href="<?= base_url(); ?>css/colorbox.css" />
<link rel="stylesheet" href="<?= base_url(); ?>bankeauc/css/tables.css" />
<script src="<?= base_url(); ?>js/jquery.colorbox.js"></script>
<script>
    $(document).ready(function () {
        $(".upload_doc_iframe").colorbox({iframe: true, width: "42%", height: "70%", onClosed: function () {
                location.reload(true);
            }});
        $(".iframe").colorbox({iframe: true, width: "70%", height: "100%", onClosed: function () {
                location.reload(true);
            }});
        $(".iframe_paytenderfee").colorbox({iframe: true, width: "56%", height: "70%", onClosed: function () {
                location.reload(true);
            }});
        $(".inline_auctiondetail").colorbox({inline: true, width: "65%", onClosed: function () {
                location.reload(true);
            }});

    });
    /*
     jQuery(function() {
     jQuery('.help-icon').tooltip();
     });*/
</script>
<style>
    table td {
        padding: 5px;
        border-right: 1px solid #A5A5A5;
        vertical-align: middle;
    }
    table{border-collapse:collapse;}
</style>
<section class="container_12">
    <?php //echo $breadcrumb;?>
    <div class="container_12">
        <div class="wrapper-full">
            <div class="dashboard-wrapper">
                
                <div id="tab-pannel6" class="btmrgn">
                     <div class="tab_container6"> 

                        <!---- buy tab container start ---->
                        <div id="tab1" class="tab_content6" style="display:block">
                            <div id="tab-pannel3" class="btmrgn">
                                
                                <div class="tab_container3 whitebg"> 


                                    <!-- Sell > My Activity start -->

                                    <div id="tab6" class="tab_content3">
                                        <div class="container">
                                            <div class="secttion-right">
                                                <div class="show_details"> <a class='inline_auctiondetail green-more float-right show_details' href="#inline_content" >Show Auction Details</a></div>
                                                <div class="table-wrapper btmrg20">
                                                    <div class="table-heading btmrg">
                                                        <div class="box-head"><?php echo $heading ?></div>
                                                    </div>
                                                    <div class="row"  style="display:none;">
                                                        <div id="inline_content">
                                                            <div class="heading4 btmrg20">Auction Detail</div>
                                                            <table border="1" align="left" cellpadding="2" cellspacing="1" class="mytable dataTable" id="big_table" aria-describedby="big_table_info">
                                                                <tbody role="alert" aria-live="polite" aria-relevant="all">
                                                                    <tr class="odd">
                                                                        <td width="20%" align="left" valign="top" class=""><strong>Auction No</strong></td>
                                                                        <td width="35%" align="left" valign="top" class="">
                                                                            <?php echo $auction_data->id; ?></td>
                                                                        <td width="20%" align="left" valign="top" class=""><strong>Reference No</strong></td>
                                                                        <td width="20%" align="left" valign="top" class=""><?php echo $auction_data->reference_no; ?></td>
                                                                    </tr>
                                                                    <tr class="even">
                                                                        <?php $brows = $this->bank_model->GetRecordByid($auction_data->bank_id); ?>
                                                                        <?php $crows = $this->helpdesk_executive_model->GetCategoryRecordById($auction_data->category_id); ?>
                                                                        <?php $srows = $this->helpdesk_executive_model->GetCategoryRecordById($auction_data->subcategory_id); ?>
                                                                        <td align="left" valign="top" class=""><strong>Organization Name</strong></td>
                                                                        <td align="left" valign="top" class=""><?php echo $brows->name; ?></td>
                                                                        <td align="left" valign="top" class=""><strong>Property Type</strong></td>
                                                                        <td align="left" valign="top" class=""><?php echo $crows->name; ?> - <?php echo $srows->name; ?></td>
                                                                    </tr>
                                                                    <tr class="odd">

                                                                        <?php $prows = $this->helpdesk_executive_model->GetProductDetail($auction_data->productID); ?>

                                                                        <td align="left" valign="top" class=""><strong>Property Address</strong></td>
                                                                        <td align="left" valign="top" class=""><?php echo $prows->product_description; ?></td>
                                                                        <td align="left" valign="top" class=""><strong>Reserve Price</strong></td>
                                                                        <td align="left" valign="top" class=""><?php echo number_format($auction_data->reserve_price, 2); ?>&nbsp;&nbsp;&nbsp;( <?php echo getAmountInWords($auction_data->reserve_price); ?> )</td>
                                                                    </tr>
                                                                    <tr class="even">

                                                                        <td align="left" valign="top" class=""><strong>EMD Amount</strong></td>
                                                                        <td align="left" valign="top" class=""><?php echo number_format($auction_data->emd_amt, 2); ?>  (<?php echo getAmountInWords($auction_data->emd_amt); ?> )</td>
                                                                        <td align="left" valign="top" class=""><strong>Borrower Name</strong></td>
                                                                        <td align="left" valign="top" class=""><?php echo ucfirst($auction_data->borrower_name); ?></td>
                                                                    </tr>
                                                                    <tr class="odd">

                                                                        <td align="left" valign="top" class=""><strong>Auction Start Date&nbsp;</strong></td>

                                                                        <td align="left" valign="top" class=""><?php echo date("d M Y H:i", strtotime($auction_data->auction_start_date)); ?> </td>
                                                                        <td align="left" valign="top" class=""><strong>Auction End Date</strong></td>
                                                                        <td align="left" valign="top" class=""><?php echo date("d M Y H:i", strtotime($auction_data->auction_end_date)); ?></td>
                                                                    </tr>
                                                                    <tr class="even">

                                                                        <td align="left" valign="top" class=""><strong>View NIT Document</strong></td>
                                                                        <td align="left" valign="top" class=""><a href="#">  
                                                                                <?php
                                                                                if ($auction_data->related_doc) {
                                                                                    echo '<a download href="/public/uploads/event_auction/' . $auction_data->related_doc . '" Download>Download</a>';
                                                                                } else {
                                                                                    echo "Not available";
                                                                                }
                                                                                ?>
                                                                            </a></td>
                                                                        <td align="left" valign="top" class=""><strong>View Image</strong></td>
                                                                        <td align="left" valign="top" class="">
                                                                            <?php
                                                                            if ($auction_data->image) {
                                                                                echo '<a download href="/public/uploads/event_auction/' . $auction_data->image . '" Download>Download</a>';
                                                                            } else {
                                                                                echo "Not available";
                                                                            }
                                                                            ?>
                                                                        </td>
                                                                    </tr>
                                                                    <tr class="odd">

                                                                        <td align="left" valign="top" class=""><strong>Documents Required&nbsp;</strong></td>
                                                                        <td align="left" valign="top" class="">

                                                                            <?php
                                                                            if ($auction_data->doc_to_be_submitted) {
                                                                                $docArr = explode(",", $auction_data->doc_to_be_submitted);
                                                                                if (count($docArr)) {
                                                                                    $docnameArr = array();
                                                                                    foreach ($docArr as $docID) {
                                                                                        $docnameArr[] = GetTitleById('tbl_doc_master', $docID);
                                                                                    }
                                                                                }
                                                                            }
                                                                            if (count($docnameArr)) {
                                                                                echo implode(', ', $docnameArr);
                                                                            }
                                                                            
                                                                            ?>
                                                                           
                                                                        </td>
                                                                        <td align="left" valign="top" class=""><strong>Offer Submission Last Date&nbsp;</strong></td>
                                                                        <td align="left" valign="top" class=""><?php echo date("d M Y H:i", strtotime($auction_data->bid_last_date)); ?></td>
                                                                    </tr>
                                                                    <tr class="odd">

                                                                        <td align="left" valign="top" class=""><strong>Special Terms and conditions &nbsp;</strong></td>
                                                                        <td align="left" valign="top" class="">
                                                                             <?php
                                                                            if ($auction_data->supporting_doc) {
                                                                                echo '<a target="_blank" href="/public/uploads/event_auction/' . $auction_data->supporting_doc . '" download >Download</a>';
                                                                            } else {
                                                                                echo "Not available";
                                                                            }
                                                                            ?>
                                                                         </td>
                                                                      
                                                                        <td align="left" valign="top" class=""><strong>Annexure2/Details of Bidder</strong></td>
                                                                        <td align="left" valign="top" class=""><?php if($bankData->annexure2){ ?><a  target="_blank" href="<?php echo $bankData->annexure2;?>"> Download</a><?php } else {
                                                                                echo "Not available";
                                                                            }?></td>
                                                                    </tr>
                                                                    <tr class="odd">

                                                                        <td align="left" valign="top" class=""><strong>Tender Documents&nbsp;</strong></td>
                                                                        <td align="left" valign="top" class="">
                                                                             <?php
                                                                            if ($bankData->tender_doc) {
                                                                                echo '<a target="_blank" href="' . $bankData->tender_doc . '" download >Download</a>';
                                                                            } else {
                                                                                echo "Not available";
                                                                            }
                                                                            ?>
                                                                         </td>
                                                                        <td align="left" valign="top" class=""><strong>Annexure3/Declaration by Bidder</strong></td>
                                                                        <td align="left" valign="top" class=""><?php if($bankData->annexure3){ ?><a  target="_blank" href="<?php echo $bankData->annexure3; ?>"> Download</a><?php }else {
                                                                                echo "Not available";
                                                                            } ?></td>
                                                                    </tr>
                                                                </tbody>

                                                            </table>
                                                           </div>
                                                    </div>

                                                    <div class="seprator btmrg20"></div>

                                <div style="text-align:center;" id="spMsg"></div>
                                                        <?php if (isset($this->session->userdata['flash:old:message'])) { ?>
                                                            <div class="success_msg"> <?php echo @$this->session->userdata['flash:old:message']; ?></div>
                                                        <?php } ?>
                                                        <div style="min-height: 0px; display: block;" class="box-content no-pad">
                                                        <form name="quote_price_submit" id="quote_price_submit" action="/owner/saveFrqParticipate/" method="post">
                                                             <div id="dt1_wrapper" class="dataTables_wrapper" role="grid">
                                                                <div class="fg-toolbar ui-toolbar ui-corner-tl ui-corner-tr ui-helper-clearfix">
                                                                    <div class="box-content no-pad">
                                                                        <div class="container-outer">
                                                                            <div class="container-inner">


                                                                                <table id="big_table" width="100%" border="1" cellpadding="2" cellspacing="1" class="display mytable dataTable" aria-describedby="big_table_info">
                                                                                    <?php //echo $auction_data->price_bid_applicable;?>
                                                                                    <tbody>


                                                                                        <tr class="odd">
                                                                                            <td width="15%" align="left" valign="top" class=" sorting_1">1</td>
                                                                                            <td width="30%" align="left" valign="top" class="participate_heading">Auction/Tender Fee</td>
                                                                                            <?php
                                                                                            //echo "tenderfees-->".$auction_data->tender_fee;
                                                                                          /*  if (($auction_data->price_bid_applicable == 'not_applicable')) {
                                                                                                ?>
                                                                                                <td width="28%" align="left" valign="top" class="bold_txt">Not Applicable</td>
                                                                                                <td width="30%" align="left" valign="top" class="bold_txt">Not Applicable</td>	
                                                                                                <?php
                                                                                            } else*/
                                                                                                if ($auction_data->tender_fee != 0) {
                                                                                                ?>
                                                                                                <td width="35%" align="left" valign="top" class="">
                                                                                                    <a class='iframe_paytenderfee green_link' href="/owner/paytenderfee/<?php echo $bidderid; ?>/<?php echo $auction_id; ?>">Pay/Update</a>
                                                                                                </td>
                                                                                                <td width="30%" align="left" valign="top" class="bold_txt"><?php
                                                                                                    if ($tender_paid) {
                                                                                                        echo "Paid"; $tender_paid_status=1;
                                                                                                    } else {
                                                                                                        echo "Not Paid";$tender_paid_status=0;
                                                                                                    }
                                                                                                    ?>
                                                                                                    <input type="hidden" id="tender_fee_paid" value="<?=$tender_paid_status;?>">
                                                                                                </td>	

                                                                                            <?php } else if ($auction_data->tender_fee <= 0) { ?>
                                                                                                <td width="35%" align="left" valign="top" class=""></td>
                                                                                                <td width="30%" align="left" valign="top" class="bold_txt">Not Applicable</td>	
<?php } ?>
                                                                                        </tr>




                                                                                        <tr class="even">
                                                                                            <td align="left" valign="top" class=" sorting_1">2</td>
                                                                                            <td align="left" valign="top" class="participate_heading">EMD Amount</td>
                                                                                            <td align="left" valign="top" class=""><a class='iframe green_link' href="/owner/payEmd/<?php echo $bidderid; ?>/<?php echo $auction_id; ?>">Pay/Update</a></td>
                                                                                            <td align="left" valign="top" class="bold_txt"><?php
                                                                                                if ($emd_paid) {
                                                                                                    echo "Paid";$emd_paid_status=1;
                                                                                                } else {
                                                                                                    echo "Not Paid";$emd_paid_status=0;
                                                                                                }
                                                                                                ?> <input type="hidden" id="emd_amount_paid" value="<?=$emd_paid_status;?>"></td>
                                                                                        </tr>

                                                                                        <tr class="odd">
                                                                                            <td align="left" valign="top" class=" sorting_1">3</td>
                                                                                            <td align="left" valign="top" class="participate_heading">Documents</td>
                                                                                            <td align="left" valign="top" class=""><a class='upload_doc_iframe green_link' href="/owner/submitDocument/<?php echo $bidderid; ?>/<?php echo $auction_id; ?>">Upload Doc</a></td>
                                                                                            <td align="left" valign="top" class="bold_txt"><?php
                                                                                                if ($documents_paid) {
                                                                                                    echo "Uploaded";$doc_uploaded_status=1;
                                                                                                } else {
                                                                                                    echo "Not Uploaded";$doc_uploaded_status=0;
                                                                                                }
                                                                                                ?><input type="hidden" id="document_uploaded" value="<?=$doc_uploaded_status;?>"></td>
                                                                                        </tr>
                                                                                        <tr class="even">
                                                                                            <td align="left" valign="top" class=" sorting_1">4</td>
                                                                                            <td align="left" valign="top" class="participate_heading">Quote Price</td>
                                                                                            <?php if ($auction_data->price_bid_applicable == 'applicable') { ?>


                                                                                                <td align="left" valign="top" class="">
                                                                                                    <input onkeypress="return isNumberKey(event);" maxlength="30" value="<?php echo $latest_frq; ?>"  name="quote_price" id="quote_price" type="text" class="input"> <?php // echo $latest_frq;  ?>
                                                                                                    <td align="left" valign="top" class=""><input name="Save" onclick="return validateParticipate('save');" value="Submit" type="submit" class="b_submit float-right button_grey"></td>                                                                                                   <span class="help-icon" title="This is the initial quote for the asset against the reserve price. This Amount cannot be lower than the reserve price. You may modify the price any time before the last date/Time of submission of sealed Bid."></span></td>
                                                                                            <?php } else { ?>
                                                                                        <input type='hidden' maxlength="30" name="quote_price" value="not_application" id="quote_price">
                                                                                        <td align="left" valign="top" class="">Not Applicable</td>
                                                                                                <?php } ?>
                                                                                                 </tr>
                                                                                    </tbody>
                                                                                    <tfoot>
                                                                                        <tr>
                                                                                            <th colspan="4"></th>
                                                                                        </tr>
                                                                                    </tfoot>
                                                                                </table>




                                                                                <div class="button-row tpmrg20">
                                                                                    <input name="documents_paid" id="documents_paid"  value="<?php
                                                                                    if ($documents_paid > 0) {
                                                                                        echo $saveval = 1;
                                                                                    } else {
                                                                                        echo $saveval = '';
                                                                                    }
                                                                                    ?>" type="hidden">

<?php
$alaise_name = GetTitleByField('tbl_auction_participate', "auctionID='" . $auction_id . "' AND bidderID='" . $bidderid . "'", 'alaise_name');
?>
                                                                                    <input type="hidden" value="<?php echo $alaise_name; ?>" name="alaise_name" id="alaise_name">
                                                                                    <input type="hidden" value="<?php echo $auction_participateID; ?>" name="auction_participateID" id="auction_participateID">


                                                                                    <input type="hidden" value="<?php echo $auction_participateFRQID; ?>" name="auction_participateFRQID" id="auction_participateFRQID">

                                                                                    <input name="emd_paid" id="emd_paid" value="<?php
                                                                                    if ($emd_paid > 0) {
                                                                                        echo $saveval = 1;
                                                                                    } else {
                                                                                        echo $saveval = '';
                                                                                    }
?>" type="hidden">

                                                                                    <input name="auction_id" id="auction_id" type="hidden" value="<?php echo $auction_id; ?>">
                                                                                    <input name="reserve_price" id="reserve_price" type="hidden" value="<?php echo $auction_data->reserve_price; ?>">
                                                                                       <?php 
                                                                                        $column='final_submit';
                                                                                        $condition='bidderID='.$bidderid.' and auctionID='.$auction_id.'';
                                                                                        $finalsubmit=  GetTitleByField('tbl_auction_participate', $condition, $column); 
                                    
                                                                                       ?>
                                                                                    <input type="hidden" value="<?=$finalsubmit;?>" id="final_submit" name="final_submit">

                                                                                    <div class="row" align="center">
                                                                                        <a href="/owner/eventTrack/<?php echo $auction_id; ?>"><input name="back" value="Back" onclick="window.location.href='<?=  base_url();?>/owner'" type="button" class="b_submit float-left button_grey"></a>
                                                                                        <input name="fSave" value="Final Submit" onclick="return validateParticipate('final_save');" type="submit" class="b_submit float-right button_grey">
                                                                                    </div>
                                                                                </div>


                                                                            </div>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>
                                                    </form>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                    <!-- Sell > My Activity end --> 
                                </div>
                            </div>
                        </div>
                        <!---- Sell tab container end ----> 
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<script>
    function isNumberKey(evt)
    {
        var charCode = (evt.which) ? evt.which : event.keyCode;
        console.log(charCode);
        if (charCode != 46 && charCode != 45 && charCode > 31
                && (charCode < 48 || charCode > 57))
            return false;

        return true;
    }
</script>
