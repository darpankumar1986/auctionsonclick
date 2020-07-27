<script type="text/javascript" src="<?= base_url(); ?>js/modernizr.custom.29473.js"></script>
<script type="text/javascript" src="<?= base_url(); ?>js/common.js"></script>
<link rel="stylesheet" href="<?= base_url(); ?>css/colorbox.css">
<link rel="stylesheet" href="<?= base_url(); ?>bankeauc/css/tables.css">
<script type="text/javascript" src="<?= base_url(); ?>js/jquery.colorbox.js"></script>
<!--<script src="<?= base_url(); ?>js/accordion.js"></script>
<link rel="stylesheet" href="<?= base_url(); ?>css/accordion.css">-->



<!--<link rel="stylesheet" href="<?= base_url(); ?>css/admin-style.css">
<link rel="stylesheet" href="<?= base_url(); ?>css/nav.css">
<link rel="stylesheet" href="<?= base_url(); ?>css/nav-select.css">-->  
<script type="text/javascript">
    jQuery(document).ready(function ($) {
        /*------- tab pannel --------------- */
        jQuery(".tab_content5").hide();
        //jQuery(".tab_content5:first").show(); 
        var activeTab = jQuery("ul.tabs5 li.active").attr("rel");
        jQuery("#" + activeTab).show();
        jQuery("ul.tabs5 li").click(function () {
            jQuery("ul.tabs5 li").removeClass("active");
            jQuery(this).addClass("active");
            jQuery(".tab_content5").hide();
            var activeTab = jQuery(this).attr("rel");
            jQuery("#" + activeTab).fadeIn();
        });
    });

    function tcAccept(auctionID)
    {
        //alert(auctionID);
        var tcval = jQuery('input[name=chktc]:checked').val();
        if (tcval != 'yes')
        {
            alert('Please accept tems & condition.');
            return false;
        }
        else
        {
            jQuery.ajax({
                url: '/owner/tcAccepted',
                type: 'POST',
                data: {auctionID: auctionID},
                success: function (data) {
                    location = location;
                    //	alert(data);

                }
            });
            return true;
        }
    }

    function auctionTrainingAccept(auctionID)
    {
        //alert(auctionID);
        var tcval = jQuery('input[name=chkauctionTraining]:checked').val();
        if (tcval != 'yes')
        {
            alert('Please accept Auction Training.');
            return false;
        }
        else
        {
            jQuery.ajax({
                url: '/owner/atAccepted',
                type: 'POST',
                data: {auctionID: auctionID},
                success: function (data) {
                    location = location;
                    //	alert(data);
                }
            });
            return true;

        }
    }
    jQuery(document).ready(function(){
        jQuery(".inline_auctiondetail").colorbox({inline:true, width:"65%"});
	jQuery(".inline_auctiondetail1").colorbox({inline:true, width:"65%"});
	jQuery(".inline_auctiondetail2").colorbox({inline:true, width:"65%"});
	//jQuery(".emd_detail_iframe").colorbox({iframe:true, width:"42%", height:"70%",onClosed: function () {location.reload(true);}});
	jQuery(".emd_detail_iframe").colorbox({iframe:true, width:"42%", height:"70%",onClosed: function () {jQuery(".inline_auctiondetail1").click();}});
	jQuery(".tenderfee_detail_iframe").colorbox({iframe:true, width:"42%", height:"70%",onClosed: function () {jQuery(".inline_auctiondetail1").click();}});
	jQuery(".doc_detail_iframe").colorbox({iframe:true, width:"42%", height:"40%",onClosed: function () {jQuery(".inline_auctiondetail1").click();}});
});
</script>

<style>
    .showbtn{display:block!important;}
</style>
<style>
    .show_input_type{display:block !important; }
    .show_agreement{float: left; width:auto;}
    .font_12{font-size:12px;}
	.show_event_details{text-align: center; border:0; outline:none;  cursor: pointer; color: #00F; font-size: 12px; padding:10px 0; width:100%; text-decoration:none;     float: left;}
	
</style>
<?php
$currentStatus = 0;
$participate = 0;
$opener = 0;
$openning = 0;
$wait_for_auction = 0;

$date = @strtotime(date('Y-m-d H:i:s'));

$bid_last_date = ($auction_data[0]->bid_last_date) ? strtotime($auction_data[0]->bid_last_date) : 0;

$bid_opening_date = ($auction_data[0]->bid_opening_date) ? strtotime($auction_data[0]->bid_opening_date) : 0;

$auction_start_date = ($auction_data[0]->auction_start_date) ? strtotime($auction_data[0]->auction_start_date) : 0;

$auction_end_date = ($auction_data[0]->auction_end_date) ? strtotime($auction_data[0]->auction_end_date) : 0;

if ($auction_data[0]->second_opener) {
    $opner_accepted = $auction_data[0]->bidder_participation_detail[0]->operner2_accepted;
} else {
    $opner_accepted = $auction_data[0]->bidder_participation_detail[0]->operner1_accepted;
}

if ($date <= $bid_last_date) {
    $currentStatus = 1;
    if ($auction_data[0]->bidder_participation_detail[0]->is_accept_tc == 1) {
        $participate = 1;
    }
} elseif ($date < $bid_opening_date) {
    $currentStatus = 2;
    $opener = 1;
} elseif (($auction_start_date - $date) < 60 && ($auction_start_date - $date) > 0) {
    $currentStatus = 3;
    $wait_for_auction = 1;
} elseif ($date > $bid_opening_date && $date < $auction_start_date) {
    $currentStatus = 2;
    $openning = 1;
} elseif ($date >= $auction_start_date AND $date <= $auction_end_date) {
    $currentStatus = 3;
} elseif ($date > $auction_end_date) {
    $currentStatus = 4;
} else {
    $currentStatus = 0;
    $participate = 0;
    $opener = 0;
    $openning = 0;
    $wait_for_auction = 0;
}
?>
<!--============================Event To Be Published==================================-->			
<?php
if(isset($_SERVER['HTTP_REFERER'])) {
    //echo $_SERVER['HTTP_REFERER'];
}	
?>	
<section class="container_12">	
    <div class="row"  style="display:none;">
        <div id="inline_content">
            <div class="heading4 btmrg20">Auction Detail</div>
            <table border="1" align="left" class="mytable dataTable" id="big_table" aria-describedby="big_table_info">
                <tbody role="alert" aria-live="polite" aria-relevant="all">                    
                    <tr class="odd">                  
                        <td align="left" valign="top" class=""><strong>Auction No. </strong></td>
                        <td align="left" valign="top" class=""><?php echo $auction_data[0]->id ?></td>
                        <td align="left" valign="top" class=""><strong>Property Address</strong></td>
                        <td align="left" valign="top" class="">
                        <?php
                         echo GetTitleByField('tbl_product', "id='" . $auction_data[0]->productID . "'", 'product_description');
                        ?>

                        </td>
                     </tr>                   
                    <tr class="odd">
                         <td align="left" valign="top" class=""><strong>Account </strong></td>
                         <td align="left" valign="top" class=""><?php echo GetTitleByField('tblmst_account_type', "account_id='" . $auction_data[0]->account_type_id . "'", 'account_name'); ?></td>
                         <td align="left" valign="top" class=""><strong>Auction Created by</strong></td>
                         <td align="left" valign="top" class="">
                            <?php
                            /*$sales_executive_id = GetTitleByField('tbl_event_log_sales', "id='" . $auction_data[0]->eventID . "'", 'sales_executive_id');
                            echo GetTitleByField('tbl_user_registration', "id='" . $sales_executive_id . "'", 'first_name');*/
                            $sales_executive_id=GetTitleByField('tbl_auction', "id='".$auction_data[0]->id."'" ,'first_opener');				
							echo  GetTitleByField('tbl_user', "id='".$sales_executive_id."'" ,'first_name');
							echo " ";
							echo  GetTitleByField('tbl_user', "id='".$sales_executive_id."'" ,'last_name');
                            ?>				
                        </td>
                    </tr>
                    <tr class="odd">
                         
                    </tr>
                    <tr class="even">
                        <td align="left" valign="top" class=""><strong>Category</strong></td>
                        <td align="left" valign="top" class="">
                            <?php
                            echo $participate_status = GetTitleByField('tbl_category', "id='" . $auction_data[0]->category_id . "'", 'name');
                            ?>
                        </td>
                        <td align="left" valign="top" class=""><strong>Reserve Price</strong></td>
                        <td align="left" valign="top" class="">
                        <?php echo $auction_data[0]->reserve_price ?>
                        </td>
                    </tr>
                    <tr class="odd">      
						<td align="left" valign="top" class=""><strong>Bid Start Date&nbsp;</strong></td>
                        <td align="left" valign="top" class=""><?php echo date("d M Y H:i", strtotime($auction_data[0]->auction_start_date)); ?></td>                  
                        <td align="left" valign="top" class=""><strong>Bid End Date&nbsp;</strong></td>
                        <td align="left" valign="top" class=""><?php echo date("d M Y H:i", strtotime($auction_data[0]->auction_end_date)); ?></td>
                    </tr>                  
                </tbody>
            </table>
        </div>
    </div>
    <!--============================MIS==================================-->	
    <div class="container_12">	
        <div class="container_12">						
            <div class="container_12">
                <div class="container_12">
                    <!--<div class="error1">Please Submit the Documents.</div>-->

                    <section class="ac-container">
                        <div>
                            <a href="#inline_content" class="show_event_details grn-txt float-right b_showevent inline_auctiondetail">Show Auction details</a>
                            <input id="ac-1" name="accordion-1" type="radio"  <?php  if ($currentStatus == 1) {?>checked <?php }?> />
                            <label for="ac-1"><span class="size_18">1</span>
                                Participation Stage
                                <?php  if ($currentStatus == 1) {?>
                                <span class="current_stage" >Current Stage</span>
                                <?php } ?>
                                <!--<span class="current_stage">Current Stage</span>--></label>
                            <article class="ac-small">
                                <p>Auction Fee : <?php echo $auction_data[0]->tender_fee ?></p>
                                <p>EMD Amount :<?php echo $auction_data[0]->emd_amt ?></p>
                                <p>Documents Required : <?php
                                    $req_doc = $auction_data[0]->doc_to_be_submitted;
                                    $req_doc_array = explode(',', $req_doc);
                                    foreach ($req_doc_array as $doc_id) {
                                    echo GetTitleById('tbl_doc_master', $doc_id); ?>,
                                    <?php } ?>
                                </p>
                                    <?php
                                    if ($currentStatus == 1) {
                                        if ($participate == '1') {
                                            ?>
                                        <p>
                                            <a href="/owner/auction_participate/<?php echo $auction_data[0]->id ?>"> Participate</a>
                                        </p>
                                    <?php } else { ?>
                                        <p>
                                        <div id="ContentPlaceHolder1_divAcptChk">
                                            <input name="chktc" class="show_input_type show_agreement" type="checkbox" id="chktc" value="yes">
                                            <span class="font_12">I agree that : I have read and accepted the <a href="#" class="terms" target="_blank">User Agreement and Privacy Policy.</a> I may receive communications from <?php echo BRAND_NAME; ?> . </span>
                                            <span id="ContentPlaceHolder1_Label1"></span>
                                            <div align="center"> <input type="button" name="submit" value="Submit"  class="button_grey show_input_type" onclick="return tcAccept(<?php echo $auction_data[0]->id ?>);">  </div>
                                        </div>
                                       </p>
                                        <?php
                                          }
                                         }
                                        ?>
                               </article>
                            </div>
                          <div>
                            <input id="ac-2" name="accordion-1" type="radio" <?php  if ($currentStatus == 2) {?>checked <?php }?> />
                            <label for="ac-2"><span class="size_18">2</span>
                                Opening Stage
                                 <?php  if ($currentStatus == 2) {?>
                                <span class="current_stage" >Current Stage</span>
                                <?php } ?>
                            </label>
                            <article class="ac-small">
                                <p>
                            <?php
                            if ($currentStatus == '2') 
                            {
                            if ($opner_accepted == '1') {
                            ?> 
                          <span class="grn-txt">Congratulation!!</span> You Have Been Qualified For The Auction by Competent Authority.
                                            <?php
                                        }elseif ($opner_accepted == '0') {
												?>
												<span class="" style="color:red;font-size:12px;padding:0 15px;">You are not qualified for Auction by Competent Authority. </span>
												<?php
											}elseif ($opener == '1') {
                                            ?>
                                            Bid yet to be open.
                                            <?php
                                        } elseif ($openning == '1') {
                                            ?>
                                            Opening is in Progress.
                                            <?php
                                        } else {
                                            ?>
                                            Opening is Scheduled at : 
                                            <?php
                                            echo $auction_data[0]->bid_opening_date;
                                        }
                                    } else {
                                        ?>
                                        Opening is Scheduled at : 
                                        <?php
                                        echo $auction_data[0]->bid_opening_date;
                                    }
                                    ?>
                                </p>
                            </article>
                         </div>
                       <div>				
                            <input id="ac-3" name="accordion-1" type="radio"  <?php  if ($currentStatus == 3) {?>checked <?php }?>  />
                            <label for="ac-3"><span class="size_18">3</span>
                                Auction
                              <?php  if ($currentStatus == 3) {?>
                                <span class="current_stage" >Current Stage</span>
                                <?php } ?>
                            </label>
                            <article class="ac-small">
                                <p>Auction Start Date : <?php echo $auction_data[0]->auction_start_date ?></p>
										<p>Scheduled End Date & Time : <?php echo $auction_data[0]->auction_end_date ?></p>
                                <?php
                                if ($currentStatus == '3') 
                                {
									if($opner_accepted == '1')
									{
										?>
										
										<?php
											//echo $opner_accepted;
											if ($auction_data[0]->bidder_participation_detail[0]->is_accept_auct_training && $wait_for_auction == '0') 
											{
												?>
												<p>
													<a href="/owner/buylistLiveAuctions/<?php echo $auction_data[0]->id ?>"> Click here to Enter Auction</a>
												</p>
												<?php
											} 
											elseif ($wait_for_auction == '1' && $auction_data[0]->bidder_participation_detail[0]->is_accept_auct_training == '1') 
											{
												?>
												<p> 
												<div class="txt" style="color:red;margin-left: 16px;font-size: 13px;margin-top: 3px;">Please wait for auction to start.</div>
												</p>
												<?php
											}
											else
											{
												?>
												<p>
												<div id="ContentPlaceHolder1_divAcptChk">
													<input name="chkauctionTraining" class="show_input_type show_agreement" type="checkbox" id="chkauctionTraining" value="yes">
													<span class="font_12">I agree that : I have read and accepted the 
													<?php /* ?><a onclick="return bidderHoleinfoPopup('owner_agreement_privacy_policy', '<?php echo $auction_data[0]->id; ?>');" class="terms" href="javascript:" >Auction Training</a><?php */ ?>
													<a href="<?php echo base_url();?>public/uploads/auction_training.pdf" target="_blank" download class="terms" >Auction Training</a>
													
													</span>
													<span id="ContentPlaceHolder1_Label1"></span>
													<div align="center"> <input type="button" name="submit" value="Submit" class="button_grey show_input_type" onclick="return auctionTrainingAccept(<?php echo $auction_data[0]->id ?>);">  </div>
												</div>
												</p>
											   <?php
											}
									}
									else
									{
										?>
										<span class="grn-txt" style="color:red;font-size:12px;padding:0 15px;">You are not qualified for Auction by Competent Authority. </span>
										<?php
										
									}
                                }
                             ?>
                                </article>
                                 </div>
                            <div>				
                            <input id="ac-4" name="accordion-1" type="radio" <?php  if ($currentStatus == 4) {?>checked <?php }?> />
                            <label for="ac-4"><span class="size_18">4</span>
                                Reports
                                  <?php  if ($currentStatus == 4) {?>
                                <span class="current_stage" >Current Stage</span>
                                <?php } ?>
                             </label>
                            <article class="ac-small">
                                <p>
                                <?php if ($currentStatus == 'viewreport' || $currentStatus == 4) { ?> <a href="/owner/viewReport/<?php echo $auction_data[0]->id ?>" class="myviewReport">Report</a> Available For Downloads of Auction.
                                    </p>
                                <?php } else { ?>
                                <p> Report Will be Available For Downloads After Completion of Auction<?php }  ?></p>
                            </article>			
                        </div>				
                     </section>
                     <div class="error1">
                        Auction Tracker shows at what stage the event is currently. You can also view the completed & next stages and navigate directly from this page.
                    </div>
                </div>
            </div>
        </div>
    </div>

<div class="bidderHolePopup" style="display:none;">
 <div class="popup" ><img src="" class="close">
   <div class="popupcontainer"></div>
    </div>
<div id="popup-overlay"></div></div>
 <!--=================================================================-->
</section>
