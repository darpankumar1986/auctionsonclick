<!--Start: Added by Aziz For Popup -->
 <script src="<?php echo base_url(); ?>js/banker.js"></script> 
<!--End: Added by Aziz For Popup -->
<link rel="stylesheet" href="<?php echo base_url(); ?>css/colorbox.css" />
<link rel="stylesheet" href="<?php echo base_url(); ?>bankeauc/css/tables.css" />
<script src="<?php echo base_url(); ?>js/jquery.colorbox.js"></script>

<style>
	table.dataTable tfoot th {
    padding: 3px 10px 3px 10px;
    border-top: 1px solid black;
    font-weight: bold;
}
</style>
<section class="container_12">
		<div class="row">
			<div class="secttion-right">
			<form name="submitEmd" id="submitEmd" action="<?php echo base_url(); ?>owner/SaveAuctionAmt" method="post" enctype="multipart/form-data">
				<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash();?>" />
				<div class="table-heading btmrg">
					<div class="box-head">Bank Processing Fee</div>
					<div class="success_msg"><?php echo $msg;?></div>
					<div style="min-height: 0px; display: block;" class="box-content no-pad table-tp-space"> 
					<div class="container-outer">
					<div class="container-inner">
						<table border="1" align="left" cellpadding="2" cellspacing="1" class="mytable dataTable" id="big_table5" aria-describedby="big_table_info">					
					<tbody>
						<!--<tr class="odd">	
							<td align="left" valign="top" class="bold_txt sorting_1">1</td>
							<td align="left" valign="top" class="participate_heading"><strong>EMD Fee</strong></td>
							<td class="bold_txt"><?php //echo $amount = $auctionData->emd_amt;?></td>
						</tr>-->
						<tr>
							<td align="left" valign="top" class="bold_txt sorting_1">1</td>	
							<td align="left" valign="top" class="participate_heading"><strong>Bank Processing Fee</strong></td>
							<td class="bold_txt"><?php echo $amount = $auctionData->tender_fee;?></td>						
							
						</tr>													
					</tbody>
					<tfoot>
						<tr>
							<th colspan="3"></th>
						</tr>
					</tfoot>
					</table>	
					</div>
					<div class="row" align="center">
					<input name="success" id="success" value="Proceed" type="submit"  class="button_grey">
					<input name="failure" id="failure" value="Cancel" type="submit"  class="button_grey">
					<input type="hidden" name="amount" value="<?php echo $amount;?>" />
					<input type="hidden" name="fee_type" value="<?php echo $this->uri->segment(5);?>" />
					<input type="hidden" name="auction_id" value="<?php echo $this->uri->segment(4);?>" />
					<input type="hidden" name="bidder_id" value="<?php echo $this->uri->segment(3);?>" />
				</div>	
					</div>					
				</div>	
				
			</form>
        </div>
  </div>
</section>
