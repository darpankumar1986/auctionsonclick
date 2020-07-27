<link rel="stylesheet" href="<?php echo base_url();?>assets/css/jquery.dataTables.css" type="text/css" media="screen"/>	
<link rel="stylesheet" href="<?php echo base_url()?>js/calender/jquery-ui.css">
<script src="<?php echo base_url(); ?>js/calender/jquery-ui.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>js/calender/jquery-ui-timepicker-addon.min.js"></script>
<link rel="stylesheet" href="<?php echo base_url()?>js/calender/jquery-ui-timepicker-addon.css">
<link rel="stylesheet" href="<?php echo base_url()?>/css/colorbox.css" />
<script src="<?php echo base_url()?>/js/jquery.colorbox.js"></script>
<style>
	.body_main1{width:80%;}
	.row{padding: 5px 0%;}
	.txtBx{width:164px;height:19px;}
</style>
<section class="body_main1">
  <?php 
  /*
  echo "<pre>";
  print_r($auction_data);
  die;*/
  ?>
  <form name="add_input_credit" id="add_input_credit" action="<?php echo base_url()?>buyer/add_input_credit/<?php echo $auction_data[0]->id;?>" method="post">
  <div class="row">
    <div class="wrapper-full">
      <div class="dashboard-wrapper">
        <div id="tab-pannel3" class="btmrgn">
			<?php if(isset($this->session->userdata['flash:old:message'])){?>
				<div class="success_msg"> <?php echo @$this->session->userdata['flash:old:message']; ?></div>
			<?php } ?>
			<?php //if(isset($this->session->userdata['flash:old:message_new'])){?>
				<div class="fail_msg"> <?php echo @$this->session->userdata['flash:old:error_msg']; ?></div>
			 <?php //} ?>
          <div class="tab_container3">
            <!-- #tab1 -->
            <div id="tab6" class="tab_content3">
              <div class="container">
                <?php echo $leftPanel?>
                <div class="secttion-right">
                  <div class="table-wrapper btmrg20">
                    <div class="table-heading btmrg">
                      <div class="box-head">Input Credit Details</div>
                    </div>
                  </div>
                     <div class="outer">
						<div class="full_acct">
							<div class="half_acct">
								<div class="row_acct">
									<label>Property ID:</label>
									<span style="font-size:12px;"><?php echo $auction_data[0]->reference_no; ?></span>
								</div>
							</div> 
							<div class="half_acct">
								<div class="row_acct">
									<label>H1 Bidder Name:</label>									
									<span style="font-size:12px;"><?php echo ucwords(strtolower($auction_data[0]->lastbidBidder[0]->first_name.' '.$auction_data[0]->lastbidBidder[0]->last_name)); ?></span>
								</div>
							</div>
						</div>
                    <br><br>
                <?php if(count($auction_data[0]->bidder_bid)){ ?>
                <div class="table-wrapper btmrg20">
                    <div class="table-section"> 
                        <table border="1" align="left" cellpadding="2" cellspacing="1" class="dataTable customFields" id="big_table" aria-describedby="big_table_info">
                            <tbody role="alert" aria-live="polite" aria-relevant="all">
                                <tr class="odd">
                                    <td width="5%" align="left" valign="top" class=""><strong>Sr.No.</strong></td>
                                    <td width="25%" align="left" valign="top" class=""><strong>Instrument No. <span class="red">*</span></strong></td>
                                    <td width="25%" align="left" valign="top" class=""><strong>Instrument Date <span class="red">*</span></strong></td>
                                    <td width="20%" align="left" valign="top" class=""><strong>Amount Paid (Rs.) <span class="red">*</span> </strong></td>
                                    <td width="25%" align="left" valign="top" class=""><strong>Remakrs</strong></td>
                                </tr>
                                <?php 
									//echo "<pre>";print_r($inputCreditData);die;
									$i=1;
									if(count($inputCreditData)>0)
									{								
										
										foreach($inputCreditData as $idata)
										{
									?>												
									 <tr class="even">									
									<td><?php echo $i; ?></td>
									<td><?php echo $idata->instrument_no;?></td>
									<td><?php echo date("d-m-Y",strtotime($idata->instrument_date));?></td>
									<td><?php echo $idata->amount_paid;?></td>
									<td><?php echo $idata->remarks;?></td>
									</tr>
									<?php
										$total +=$idata->amount_paid;
										$i++;
										
										}
									
									}
								?>
                                <tr class="even">
									<td colspan="3" align="right"><strong>Total Amount Paid (Rs.) </strong></td>									
									<td><?php echo ($total>0)?$total:0; ?></td>
									<td></td>
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
									<td width="25%" align="center" valign="top" class="">
										<a href="javascript:void(0);" class="b_submit float-left button_grey addCF">Add</a>
										<input name="save" value="Save" type="submit" class="b_submit float-left button_grey" style="margin-top: 0px;" onclick="return validateFrmICD();">
										<input type="hidden" name="bidder_id" value="<?php echo $auction_data[0]->lastbidBidder[0]->bidderID;?>" />
									</td>								  
								</tr>
							</tbody>             
						</table>
				</div>
				<?php } else { ?>
					<div class="table-section"> 						
					<table border="1" align="left" cellpadding="2" cellspacing="1" class="mytable dataTable" id="big_table" aria-describedby="big_table_info">
						<tbody role="alert" aria-live="polite" aria-relevant="all">
							<tr class="odd"><td colspan=2 align="center">No bidder participated.</td></tr>
						</tbody>             
					</table>
					</div>
				<?php  } ?>
                    
                    <div class="table-section"> 						
                        <table border="1" align="left" cellpadding="2" cellspacing="1" class="mytable dataTable" id="big_table" aria-describedby="big_table_info">
                            <tbody role="alert" aria-live="polite" aria-relevant="all">								
                                <tr class="odd">								 
                                    <td align="left" valign="top" class="3">
                                        <a href="<?php echo base_url()?>buyer/eventTrack/<?php echo $auctionID;?>"><input class="b_submit float-left button_grey" type="button" value="Back" />
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
<p style="display:block;"><a class='inline' href="#inline_content"></a></p>
<div style='display:none'>
	<div id='inline_content' style='padding:10px; background:#fff;'>
		<ul id="spMsg" style="color:#CC0000;"></ul>
	</div>
</div>
<script>
$(document).ready(function(){
	$(".addCF").click(function(){		
		$(".customFields").find('tr:last').prev().after('<tr class="even"><td><?php echo $i++;?></td><td><input type="text" class="instrument_no txtBx" name="instrument_no" value="" /></td><td><input type="text" class="instrument_date txtBx" name="instrument_date" value="" /> </td><td><input type="text" class="amount_paid txtBx" name="amount_paid" value="" /></td><td><input type="text" class="remarks txtBx" name="remarks" value="" /> &nbsp; <a href="javascript:void(0);" class="remCF">Remove</a></td></tr>');
		
		$('.instrument_date').datepicker({
				controlType: 'select',
				oneLine: true,
				//minDate: 0,
				//maxDate: 0,
				changeMonth: true,
				changeYear: true,
				dateFormat: 'dd-mm-yy',
				yearRange: '1950:<?php echo date('Y')?>'
		});
		$(this).css('display','none');
	});
    $(".customFields").on('click','.remCF',function(){
        $(this).parent().parent().remove();
        $('.addCF').css('display','');
    });
    
});



	
</script>
