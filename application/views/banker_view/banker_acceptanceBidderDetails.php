<link rel="stylesheet" href="<?php echo base_url()?>/assets/css/jquery.dataTables.css">

<style>
	.body_main1{width:60%;}
	.row{padding: 5px 0%;}
</style>
<section class="body_main1">
  <?php 

  //echo "<pre>"; print_r($auction_data); die;
  
  // Calculation of Acceptance auction data
  
  $area         = $auction_data[0]->area;
  $emd_amt      = $auction_data[0]->emd_amt;
  $area_unit    = GetTitleByField('tblmst_uom_type', 'uom_id="'.$auction_data[0]->area_unit_id.'"', 'uom_name');
  $prop_descp   = $auction_data[0]->PropertyDescription;
  
  $prop_ser_no    = GetTitleByField('tbl_auction', 'id="'.$auctionID.'"', 'service_no');
  $prop_ser_no    = ($prop_ser_no != "")? $prop_ser_no: "N/A";
  
  $h1_price     = $auction_data[0]->lastbidBidder[0]->bid_value;
  $message      = $auction_data[0]->sms_template[0]->msg;
  
  $unit_id_of_price    = GetTitleByField('tbl_auction', 'id="'.$auctionID.'"', 'unit_id_of_price');
  if($unit_id_of_price > 4)
  {
	  $tot_najarana = ($area * $h1_price);
  }
  else
  {
	  $tot_najarana = $h1_price;
  }
  $naj_15per    = ($tot_najarana * 0.50);
  //$deps_within_24_hrs = ($naj_15per - $emd_amt);
  $deps_within_24_hrs = ($naj_15per);
  $balance_naj_amt  = ($tot_najarana - $naj_15per);
  
  ?>
    
  <form name="auction_awarded" id="auction_awarded" action="<?php echo base_url()?>buyer/acceptanceBidderSmsAndEmail" method="post">
  <div class="row">
    <div class="wrapper-full">
      <div class="dashboard-wrapper">
        <div id="tab-pannel3" class="btmrgn">
		 	<?php if(isset($this->session->userdata['flash:old:message'])){?>
				<div class="success_msg"> <?php echo @$this->session->userdata['flash:old:message']; ?></div>
			<?php } ?>
		
          <div class="tab_container3">
            <!-- #tab1 -->
            <div id="tab6" class="tab_content3">
              <div class="container">
                <?php echo $leftPanel?>
                <div class="secttion-right">
                  <div class="table-wrapper btmrg20">
                    <div class="table-heading btmrg">
                      <div class="box-head">Acceptance Bidder Details</div>
                    </div>
                  </div>
               
                    <input type="hidden" name="auction_id" value="<?php echo $auctionID; ?>" id="auction_id">
                    <input type="hidden" name="bidder_id" value="<?php echo $bidder_id; ?>" id="bidder_id">
                    <input type="hidden" name="h1_price" value="<?php echo $h1_price; ?>" id="h1_price">
                    <input type="hidden" name="area_unit" value="<?php echo $area_unit; ?>" id="area_unit">
                    <input type="hidden" name="deps_within_24_hrs" value="<?php echo $deps_within_24_hrs; ?>" id="deps_within_24_hrs">
                <div class="table-wrapper btmrg20">
                    <div class="table-section"> 
                        
                        <table border="1" align="left" cellpadding="2" cellspacing="1" class="mytable dataTable" id="big_table" aria-describedby="big_table_info">
                            <tbody role="alert" aria-live="polite" aria-relevant="all">
                              
                                <tr class="odd" style="background-color: #dff0d8 !important;">
                                    <td width="100%" align="left" valign="top" class="btn success"><strong>SMS Details</strong></td>
                                </tr>
                                <tr class="even">                                
                                    
                                    <td width="100%" align="left" valign="top" class="" style="font-size: 14px; line-height: 150%;">
                                    <?php
                                        $message    = $auction_data[0]->sms_template[0]->msg;
                                        $message    = str_replace("%bidder_name%","<strong>".$bidder_name."</strong>", $message);
                                        $message    = str_replace("%prop_descp%","<strong>".$prop_desc."</strong>", $message);
                                        $message    = str_replace("%amt_within_24_hrs%","<strong>".moneyFormatIndia(round($deps_within_24_hrs))."</strong>", $message);
                                        $message    = str_replace("%seller_name%","<strong>".$this->session->userdata("full_name")."</strong>", $message);
                                        echo $message;
                                        
                                    ?>
                                    </td>
                                    
                                </tr>
                               
                                 <tr class="odd">
                                   
                                    <td width="100%" align="right" valign="top" class="">
                                        <input name="send_sms" value="Send SMS" type="submit"  onclick="return confBox('sms');" class="b_submit float-left button_grey"></td>
                                </tr>
                                 <tr class="even">
                                    <td width="100%" align="left" valign="top" class=""><strong></strong></td>
                                </tr>
                                <tr class="odd" style="background-color: #dff0d8 !important;">
                                    <td width="100%" align="left" valign="top" class=""><strong>EMAIL Details</strong></td>
                                </tr>
                                <tr class="even">
                                    <td width="100%" align="left" valign="top" class=""  style="font-size: 18px; line-height: 120%;">
                                    <?php
                                        $subject    = $auction_data[0]->email_template[0]->subject;
                                        $body    = $auction_data[0]->email_template[0]->msg;
                                        
                                        $body = str_replace("%bidder_name%", $bidder_name, $body);
                                        $body = str_replace("%bidder_email%", $bidder_email, $body);
                                        $body = str_replace("%prop_descp%", $prop_descp, $body);
                                        $body = str_replace("%auction_id%", $auctionID, $body);
                                        $body = str_replace("%h1_price%", $h1_price, $body);
                                        $body = str_replace("%area_unit%",$area_unit, $body);
                                        $body = str_replace("%amt_within_24_hrs%", moneyFormatIndia(round($deps_within_24_hrs)), $body);
                                        $body = str_replace("%prop_ser_no%", $prop_ser_no, $body);
                                        
                                        echo $body;
                                    ?>
                                    </td>
                                </tr>
                                 <tr class="odd">
                                    <td width="100%" align="right" valign="top" class=""><input name="send_email" value="Send Email" type="submit"  onclick="return confBox('email');" class="b_submit float-left button_grey"></td>
                                </tr>
                            </tbody>             
                        </table>					
                    </div>
                </div>
                    
                    
                    <div class="table-wrapper btmrg20">                    
                 
                    <div class="table-section"> 						
                        <table border="1" align="left" cellpadding="2" cellspacing="1" class="mytable dataTable" id="big_table" aria-describedby="big_table_info">
                            <tbody role="alert" aria-live="polite" aria-relevant="all">								
                                <tr class="odd">								 
                                    <td align="left" valign="top" class="3">
                                        <a href="<?php echo base_url()?>buyer/banker_h1Bidder/<?php echo $auctionID;?>"><input class="b_submit float-left button_grey" type="button" value="Back" />
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
  </form>
</section>
<script>
    function confBox(val)
    {			
        if(val=='sms')
        {
            var cnf = confirm('Are you sure to send the SMS?');
            if (cnf == true)
            {
                return true;
            } else {
                return false;
            }
        } else if(val=='email'){
            var cnf = confirm('Are you sure to send the email?');
            if (cnf == true)
            {
                return true;
            } else {
                return false;
            }
        }
    }
</script>
