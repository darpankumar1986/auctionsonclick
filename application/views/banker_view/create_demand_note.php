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
	.txtBx{width:74px;height:19px;}
	.txtBx1{width:126px;height:19px;}
	table.dataTable td{padding: 10px 5px;}
</style>

<link rel="stylesheet" href="<?php echo base_url(); ?>bankeauc/css/tables.css" />

<script>
    $(document).ready(function () {
        $(".define_note_iframe").colorbox({iframe: true, width: "85%", height: "90%", onClosed: function () {
            $(".inline_define_note");
        }});
    });
</script>

<section class="body_main1">
  <?php 
  /*
  echo "<pre>";
  print_r($auction_data);
  die;*/
  ?>
  <form name="add_demand_note" id="add_demand_note" action="<?php echo base_url()?>buyer/add_demand_note/<?php echo $auction_data[0]->id;?>" method="post">
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
                      <div class="box-head">Create Demand Note</div>
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
                                <tr class="even">
                                    <td width="5%" align="left" valign="top" class=""><strong>Sr.No.</strong></td>
                                    <td width="" align="left" valign="top" class=""><strong>Demand Note No. <span class="red">*</span></strong></td>
                                    <td width="10%" align="left" valign="top" class=""><strong>Demand Note Date <span class="red">*</span></strong></td>
                                    <td width="" align="left" valign="top" class=""><strong>Lease (%) </strong></td>
                                    <td width="" align="left" valign="top" class=""><strong>Site Plan Charges</strong></td>
                                    <td width="" align="left" valign="top" class=""><strong>BSUP(Shelter) Fund Rate (Rs.)</strong></td>
                                    <td width="20%" align="left" valign="top" class=""><strong>Net Payable Amount (Rs.) <span class="red">*</span></strong></td>
                                    <td width="17%" align="left" valign="top" class=""><strong>Percentage Payment to be made Against Current Demand Note (%) <span class="red">*</span> </strong></td>
                                    <td width="" align="left" valign="top" class=""><strong>Current Payment (Rs.)</strong></td>
                                    <td width="" align="left" valign="top" class=""><strong>Define Demand Note</strong></td>
                                    <td width="" align="left" valign="top" class=""><strong>Preview</strong></td>
                                    
                                </tr>
                                <?php 
									//echo "<pre>";print_r($inputCreditData);die;
									$i=1;
									$totalPercentage =0;
									if(count($demandNoteData)>0)
									{								
										
										foreach($demandNoteData as $idata)
										{
									?>												
									 <tr class="odd">									
									<td><?php echo $i; ?></td>
									<td><?php echo $idata->demand_note_no;?></td>
									<td><?php echo date("d-m-Y",strtotime($idata->demand_note_date));?></td>
									<td><?php echo $idata->lease_rate;?></td>
									<td><?php echo $idata->site_plan_charges;?></td>
									<td><?php echo $idata->bsup_rate;?></td>
									<td><?php echo $idata->net_payable_amount;?></td>
									<td><?php echo $idata->percentage_payment;?></td>
									<td><?php echo $idata->current_payment;?></td>
									<td><a class='inline_define_note define_note_iframe' href="<?php echo base_url(); ?>buyer/define_demand_note/<?php echo $auctionID;?>">Add</a></td>
									<td><a href="#">View</a></td>
									</tr>
									<?php										
										$i++;
										
										$totalPercentage +=$idata->percentage_payment; 
										$totalPaid +=$idata->current_payment; 
										
										}
									
									}
								?>                               
							</tbody>             
                        </table>					
					</div>
                </div>                
                    
				<div class="table-wrapper btmrg20">                    				 
					<div class="table-section"> 						
						<table border="1" align="left" cellpadding="2" cellspacing="1" class="mytable dataTable" id="big_table" aria-describedby="big_table_info">
							<tbody role="alert" aria-live="polite" aria-relevant="all">								
								<tr class="odd">
									<?php if(!isset($demandNoteData[0]->net_payable_amount) || $demandNoteData[0]->net_payable_amount > $totalPaid) {?>
									<td width="25%" align="center" valign="top" class="">
										<a href="javascript:void(0);" class="b_submit float-left button_grey addCF">Add</a>
										<input name="calSave" value="Calculate & Save" type="submit" class="b_submit float-left button_grey" style="margin-top: 0px;" onclick="return validateFrmDN();">
										<input name="genSend" value="Generate & Send" type="submit" class="b_submit float-left button_grey" style="margin-top: 0px;" onclick="return validateFrmDN();">
										<input type="hidden" name="bidder_id" value="<?php echo $auction_data[0]->lastbidBidder[0]->bidderID;?>" />
									</td>	
									<?php  }
									else
									{
									?>
									<td width="25%" align="center" valign="top" class="">
										Full Amount Paid
									</td>
									<?php
									}
									 ?>							  
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
                                        <a href="<?php echo base_url();?>buyer/eventTrack/<?php echo $auctionID;?>"><input class="b_submit float-left button_grey" type="button" value="Back" /></a>
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
		
		$(".customFields").append('<tr class="even"><td><?php echo $i++;?></td><td><input type="text" class="demand_note_no txtBx" name="demand_note_no" value="" /></td><td><input type="text" class="demand_note_date txtBx" name="demand_note_date" value="" /> </td><td><input type="text" class="lease_rate txtBx numericonly calRate <?php if(isset($demandNoteData[0]->net_payable_amount)) {echo 'readonly';} ?>" name="lease_rate" value="0.00" <?php if(isset($demandNoteData[0]->net_payable_amount)) {echo 'readonly';} ?> /></td><td><input type="text" class="site_plan_charges txtBx numericonly calRate <?php if(isset($demandNoteData[0]->net_payable_amount)) {echo 'readonly';} ?>" name="site_plan_charges" value="0.00" <?php if(isset($demandNoteData[0]->net_payable_amount)) {echo 'readonly';} ?>/></td><td><input type="text" class="bsup_rate txtBx numericonly calRate <?php if(isset($demandNoteData[0]->net_payable_amount)) {echo 'readonly';} ?>" name="bsup_rate" value="0.00" <?php if(isset($demandNoteData[0]->net_payable_amount)) {echo 'readonly';} ?>/></td><td><input type="text" class="total_amount_paid txtBx1 numericonly readonly" name="total_amount_paid" value="<?php echo $demandNoteData[0]->net_payable_amount; ?>" readonly/></td><td><input type="text" class="percentage_payment txtBx1 numericonly calRate" name="percentage_payment" value="" /></td><td><input type="text" class="current_payment txtBx numericonly readonly" name="current_payment" value="" readonly/></td><td><a href="javascript:void(0);" class="">Add</a></td><td><a href="javascript:void(0);" class="">View</a> | <a href="javascript:void(0);" class="remCF">Remove</a></td></tr>');
		
		$('.demand_note_date').datepicker({
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
   
  
   $(".customFields").on('blur','.calRate',function(){
	   
	   
	   var percentage_payment = $('.percentage_payment').val();
	   
	   
	    <?php 
	    if(!isset($demandNoteData[0]->net_payable_amount)) {
		?>
		var total_najarana = <?php echo ($auction_data[0]->area * $auction_data[0]->lastbidBidder[0]->bid_value) ; ?>;
		
		var lease_rate = parseFloat($('.lease_rate').val());
		if(isNaN(lease_rate))
		{
			lease_rate = 0;
		}
		var reserve_price_zone = <?php echo $auction_data[0]->reserve_price_zone; ?>;
		var lease_rate_cal = parseFloat( reserve_price_zone * lease_rate)/100;		
		var lease_amount = <?php echo  $auction_data[0]->area;?> * lease_rate_cal;
		
		var site_plan_charges = parseFloat($('.site_plan_charges').val());
		if(isNaN(site_plan_charges))
		{
			site_plan_charges = 0;
		}
		
		var bsup_rate = parseFloat($('.bsup_rate').val());		
		if(isNaN(bsup_rate))
		{
			bsup_rate = 0;
		}
		var bsup_amount = parseFloat(<?php echo  $auction_data[0]->area;?> * bsup_rate);
		var total_amount_payable = parseFloat(total_najarana + lease_amount + site_plan_charges + bsup_amount);
		var emd_amount = <?php echo $auction_data[0]->emd_amt; ?>;
		var net_payable_amount = total_amount_payable - emd_amount;
		
		
		
		if(percentage_payment >= 1 && percentage_payment<100.01)
		{
			var current_payment = parseFloat((net_payable_amount * percentage_payment)/100);
		}
		$('.total_amount_paid').val(net_payable_amount);
		$('.current_payment').val(current_payment);
		
		/*
		console.log(total_najarana);
		console.log(lease_rate);
		console.log(reserve_price_zone);
		console.log(lease_amount);
		console.log(site_plan_charges);
		console.log(bsup_rate);
		console.log(bsup_amount);
		console.log(total_amount_payable);
		console.log(net_payable_amount);
		*/
	    <?php  }
	   else
	   {
		  
		?>
			var paidPercentage = <?php echo $totalPercentage;?>;
			var totalPercentage = parseFloat(percentage_payment) + parseFloat(paidPercentage); 

			if(totalPercentage > 100)
			{
				percentage_payment = $('.percentage_payment').val('');
			}

			if(percentage_payment >= 1 && percentage_payment<100.01)
			{
				var current_payment = parseFloat((<?php echo $demandNoteData[0]->net_payable_amount;?> * percentage_payment)/100);
			}	
					
			$('.current_payment').val(current_payment);

		<?php
	   }
	   ?>
   });
  
    
});

//$('.numericonly').keypress(function(event) {
$(document).on("keypress",".numericonly",function(){	
	  if ((event.which != 46 || $(this).val().indexOf('.') != -1) &&
		((event.which < 48 || event.which > 57) &&
		  (event.which != 0 && event.which != 8))) {
		event.preventDefault();
	  }

	  var text = $(this).val();

	  if ((text.indexOf('.') != -1) &&
		(text.substring(text.indexOf('.')).length > 2) &&
		(event.which != 0 && event.which != 8) &&
		($(this)[0].selectionStart >= text.length - 2)) {
		event.preventDefault();
	  }
	});

	
</script>
