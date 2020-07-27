<script src="/js/jquery.min.js"></script>
<script type="text/javascript" src="/js/jquery.countdown.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/common.js"></script>
<script>
jQuery(document).ready(function($) {	
  //  var input=$(".dynamic_price_live").val();
//showText(input);
});
 function showText(input) { 
    var inputValue = input.value; 
    var hold = numToWords(inputValue);
    output.innerHTML = hold;
   }
</script>
<?php
$condition=1;
$totalLiveAuctionData = ($auctionData);
$userid = $this->session->userdata['id'];
if ($totalLiveAuctionData != 0) {
    $currentTime = time();
    foreach ($auctionData as $adata) {
        $auctionID = $adata->id;
        $status = $adata->status;
        $is_accept_tc = $adata->is_accept_auct_training;
        if (($adata->first_opener > 0) && ($adata->second_opener <= 0)) {
            $participate_status = GetTitleByField('tbl_auction_participate', "bidderID='" . $userid . "' AND auctionID='" . $auctionID . "'", 'operner1_accepted');
            if ($participate_status > 0) {
                $bankerAccepted = 1;
            } else {
                $bankerAccepted = 0;
            }
        } else if (($adata->second_opener > 0) && ($adata->first_opener > 0)) {
            $participate_status = GetTitleByField('tbl_auction_participate', "bidderID='" . $userid . "' AND auctionID='" . $auctionID . "'", 'operner2_accepted');
            if ($participate_status > 0) {
                $bankerAccepted = 1;
            } else {
                $bankerAccepted = 0;
            }
        }

        $auto_bid_cut_off = $adata->auto_bid_cut_off;
        $max_auto_bid = $this->bidder_model->getMaxAutocutBidderBidValue($auctionID);
        $rankData = $this->bidder_model->getBidderAuctionRank($auctionID);
        if ($rankData) {
            $rankData = $rankData;
        } else {
            $rankData = 0;
        }
        $autobidExist = $this->bidder_model->checkAutocutBidderBidValue($auctionID);
        $lastBidderBidValue = $this->bidder_model->LastBidderBidValue($auctionID);
        $getAutocutRow = $this->bidder_model->getAutocutBidderBidValue($auctionID);

        $str_auction_end_date = strtotime($adata->auction_end_date);
        $remainDuration = $str_auction_end_date - $currentTime;
        $remainTime = findRemainTime($adata->auction_end_date, $adata->auction_pause_time);

        $totalbidding = $this->banker_model->CountAuctionBidingData($auctionID);
        $lastbidArr = $this->banker_model->AuctionLastBidingData($auctionID);
        $auctionLogedbidder = $this->banker_model->AuctionLoggedBidderData($auctionID);
        $gain = $this->banker_model->calculateGainvalue($auctionID);
        $firstbidValue = $lastbidArr->bid_value;

        if ($lastbidArr->bid_value > 0) {
            $lastbid = $lastbidArr->bid_value;
            $bidtextval = $adata->bid_inc + $lastbid;
            $lastbidtextval = $lastbid;
        } else {
            $lastbid = '0.00';
            $lastbidtextval = $adata->opening_price;
            if ($adata->opening_price) {
                $bidtextval = $adata->opening_price;
            } else {
                $bidtextval = $adata->reserve_price;
            }
        }


        if ($lastbid > 0) {
            $h1price = $lastbid;
        } else {
            if ($adata->opening_price) {
                $h1price = $adata->opening_price;
            } else {
                $h1price = $adata->reserve_price;
            }
        }

        if ($bankerAccepted == 1) {
            ?>   
            <div class="box-head custom123 no_cursor">Bidding Live Auction</div>
            <div class="nit_number">Property ID: <?php echo $adata->reference_no ?></div>
            <div class="nit_time_remaining">Time Remaining:  <?php if ($adata->auction_bidding_activity_status == 1) { ?>
                    <div class="heading">
                        Auction Paused!!! : <?php echo $remainTime['days']; ?> Days <?php echo $remainTime['hours']; ?> hours : <?php echo $remainTime['minute']; ?> Minutes : <?php echo $remainTime['second']; ?> Seconds
                    </div>
                <?php } else { ?>
                    <div data-countdown="<?php echo $adata->auction_end_date; ?>"></div>
                <?php } ?></div>
            <div class="view_half"><a onclick="return bidderHoleinfoPopup('owner_uploaded_file', '<?php echo $auctionID; ?>');" href="javascript:" class="grn-txt">View Uploaded File </a> </div>
            <div class="view_half txt_rgt"> <a onclick="return bidderHoleinfoPopup('owner_eventDetaillist', '<?php echo $auctionID; ?>');" href="javascript:" class="grn-txt">Show Auction Details</a></div>
			<div style="width:100%; float:left; background:#fff;">
            <div class="row1">
                <?php if ($auto_bid_cut_off == 1) { ?>
                    <div class="one_fourth">Auto Bid Cut Off
                        <span>
                            <?php
                            if ($getAutocutRow->auto_bid) {
                                echo $getAutocutRow->auto_bid;
                            } else {
                                echo '0';
                            };
                            ?>
                        </span>
                    </div>
                <?php } ?>
                <div class="one_fourth">Last Bid<span><?php echo $lastBidderBidValue ?></span>
                </div>
                <div class="one_fourth">H1 Bid<span><?php echo $h1price; ?></span></div>
               <div class="one_fourth" style="padding-bottom:10px;" >Rank
                 <?php if($rankData!=0){ ?>
                <div class="rank"><?php echo $rankData; ?></div>
                 <?php }  ?>
                </div>
                <div class="one_fourth no_rgt_border"><input name="Save" value="Refresh" onclick="location.reload(true);"  type="button" class="button_grey">
                </div>
                <div class="clear" style="border-top: solid 1px #ccc;">&nbsp;</div>
               <?php if ($is_accept_tc == 1) { ?>
                    <?php if (($status != 4) && ($status != 3)) { ?>
                        <input type="hidden" value="<?php echo $max_auto_bid; ?>" id="max_auto_bid_<?php echo $adata->id; ?>" name="max_auto_bid_<?php echo $adata->id; ?>">
                        <input type="hidden" value="<?php echo $adata->bid_inc; ?>"  name="bidder_bid_inc_<?php echo $adata->id; ?>" id="bidder_bid_inc_<?php echo $adata->id; ?>" class="input-sort">
                        <input type="hidden" value="<?php echo $adata->opening_price; ?>"  name="bid_opening_price_<?php echo $adata->id; ?>" id="bid_opening_price_<?php echo $adata->id; ?>" >
                        <?php if ($firstbidValue <= 0) { ?>
                            <input type="hidden" value="opening_bid" id="enteredbidtype_<?php echo $adata->id; ?>" name="enteredbidtype_<?php echo $adata->id; ?>"> 
                        <?php } else { ?>
                            <input type="hidden" value="chess_bid" id="enteredbidtype_<?php echo $adata->id; ?>" name="enteredbidtype_<?php echo $adata->id; ?>"> 
                        <?php } ?>
                        <input type="hidden" value="<?php echo $lastbidtextval; ?>" id="lastbidtextval_<?php echo $adata->id; ?>" name="lastbidtextval_<?php echo $adata->id; ?>"> 
                        <input type="hidden" value="<?php echo $bidtextval; ?>"  name="manual_bidder_bid_value_<?php echo $adata->id; ?>" id="manual_bidder_bid_value_<?php echo $adata->id; ?>" class="input-sort">
                        <?php
                        if ($auto_bid_cut_off == 1) {

                            if ($getAutocutRow->auto_bid) {
                                 $getAutocutvalue = $getAutocutRow->auto_bid;
                            } else {

                                $getAutocutvalue = $bidtextval;
                            }
                            ?>

                            <div class="half" style="border:none!important;">
                                Set Auto Bid Cut Off
                                <div class="cut_off"> <input type="text" onkeypress="return isNumberKey(event);"  class="input-normal" value="<?php //echo $getAutocutvalue;    ?>"  name="bidder_autobid_value_<?php echo $adata->id; ?>" id="bidder_autobid_value_<?php echo $adata->id; ?>"></div>
                                <?php if (($getAutocutRow->auto_bid > 0)) { ?>
                                    <input name="Save" value="Submit Auto Bid"  type="button" class="button_grey b_submit float-left">
                                <?php } else { ?>
                                    <input name="Save" onclick="saveAutobidLiveAuctionBid(<?php echo $adata->id; ?>);" value="Submit Auto Bid"  type="button" class="button_grey b_submit float-left">
                                <?php } ?>

                            <?php } ?>    
                        </div>
                       
                        <?php if (($autobidExist <= 0) || ($getAutocutRow->auto_bid <= $h1price)) { ?>
                            <div class="half no_rgt_border" style="border:none!important;">
                                Bid Amount
                                <div class="cut_off"> 
                                    <input type="text" onchange="showText(this);" class="dynamic_price_live" onkeypress="return isNumberKey(event);" value="<?php echo $bidtextval; ?>"  name="bidder_bid_value_<?php echo $adata->id; ?>" id="bidder_bid_value_<?php echo $adata->id; ?>" class="input-sort" readonly>
                                    <div class="float-right inc_dcm_box">
                                        <span class="increment" onclick="increseORdecriseBidValue('increase', '<?php echo $adata->id; ?>');"></span>
                                        <span class="decrement" onclick="increseORdecriseBidValue('decrease', '<?php echo $adata->id; ?>');"></span>
                                    </div>

                                </div>
                                 <span class="amount_in_words" id="price_in_ruppees_<?php echo $adata->id; ?>"></span>
                          
                            
                          
                            <script type="text/javascript">
                            //End of numToWords function
                             var button = document.getElementById('changeText');
                             var output = document.getElementById('price_in_ruppees_<?php echo $adata->id; ?>');
                             var input = document.getElementById('bidder_bid_value_<?php echo $adata->id; ?>');
                             input.addEventListener('input', showText);
                             // Timer of auction 
                            </script>
			   <div class="live_bid_cnt_btn">
                                <?php if ($adata->auction_bidding_activity_status == 1) { ?>
                                    <input name="Save" value="Submit" type="button" class="b_submit float-left button_grey">
                                <?php } else { ?>
                                    <input name="Save" value="Submit" type="button" onclick="saveLiveAuctionBid(<?php echo $adata->id ?>);" class="b_submit float-left button_grey">
                                    <?php
                                }
                            }
                            ?> 
							</div>
                            <div class="bid_error" style="text-align:center;" id="error_<?php echo $adata->id; ?>"></div>
                            </div>
                            
                            
							 </div>
                        <?php } else { ?>
                            <?php if ($status == '3') { ?>
                                <div  id="error_<?php echo $adata->id; ?>" style="width:95%; float:left; background:#f78d8d; border:solid 1px #F00; border-radius:2px; font-size:12px; color:#000; padding:30px 0 30px 5%;">
                                    Auction on stay Mode.
                                </div>


                            <?php } else if ($status == '4') { ?>
                                <div  id="error_<?php echo $adata->id; ?>" style="width:95%; float:left; background:#f78d8d; border:solid 1px #F00; border-radius:2px; font-size:12px; color:#000; padding:30px 0 30px 5%;">
                                    Auction has been changed
                                </div>
                            <?php } ?>
                            <?php
                        }
                    } else {
                        ?>

                         <div class="row" style="font_size:12px;">
                            <div  id="is_accept_tc_upid_<?php echo $auctionID; ?>">
                                <input type="checkbox" style="width:20px" onclick="is_accept_tc_update(<?php echo $auctionID; ?>);" name="is_accept_tc<?php echo $auctionID; ?>" id="is_accept_tc<?php echo $auctionID; ?>" value="1"><span>I agree that : I have read and accepted the <a href="#" target="_blank"   class="terms grn-txt">User Agreement and Privacy Policy.</a> I may receive communications from <?php echo BRAND_NAME; ?> . </span>
                            </div>
                        </div>
                    <?php } ?>
                    <?php
                }
            }
        } else { 
            
            ?>
            <div style="width:95%; float:left; background:#f78d8d; border:solid 1px #F00; border-radius:2px; font-size:12px; color:#000; padding:30px 0 30px 5%;">
                E You do not have any live Auction. !!
            </div>
        <?php } ?>			
   
</div>    
          
        <div style="background:#fff; padding:1%;text-align:right;">
         <input name="Save" value="Back"  onclick="window.location.href='<?=base_url();?>owner/'"  type="button" class="button_grey">
       </div>
    
<script>
    $('[data-countdown]').each(function () {
        var $this = $(this), finalDate = $(this).data('countdown');
        $this.countdown(finalDate, function (event) {
            $this.html(event.strftime('<span class="col"><label>Day</label> <span>%D</span></span><span class="colon">:</span> <span class="col"><label>Hour</label> <span>%H</span></span><span class="colon">:</span><span class="col"><label>Minutes</label> <span>%M</span></span><span class="colon">:</span><span class="col"><label>Seconds</label> <span>%S</span></span>'));
        });
    });
</script>
