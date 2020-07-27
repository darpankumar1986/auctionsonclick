<script type="text/javascript" src="<?php echo VIEWBASE; ?>js/plugins/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="<?php echo VIEWBASE; ?>js/custom/tables.js"></script>
<link rel="stylesheet" href="<?php echo base_url()?>js/calender/jquery-ui.css">
<script src="<?php echo base_url(); ?>js/calender/jquery-ui.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>js/calender/jquery-ui-timepicker-addon.min.js"></script>
<link rel="stylesheet" href="<?php echo base_url()?>js/calender/jquery-ui-timepicker-addon.css">
<script type="text/javascript" src="<?php echo VIEWBASE; ?>js/custom/forms.js"></script>
<section class="container_12">
    <?php
   
    if(isset($_POST['from_date']) and !empty($_POST['start_date']))
    {
        $from_date=$_POST['from_date'];
    }
    
    if(isset($_POST['to_date']) and !empty($_POST['to_date']))
    {
        $to_date=$_POST['to_date'];
    }
    ?>
<?php if( $this->session->flashdata('message')) {?>
<span class="success_msg"><img src="<?php echo VIEWBASE; ?>images/icon_checkmark_small.png" class="success_tick"><?php echo $this->session->flashdata('message'); ?></span>
<?php } ?>		
<div class="box-head">Payment Logs</div>
   <div class="centercontent tables">
	<div class="pageheader notab">	
	</div><!--pageheader-->	
	<div id="contentwrapper" class="contentwrapper box-content2">
            <form action="" method="GET"  id="searchfm" name="searchfm" onsubmit="return validateform();">
				<table cellpadding="0" cellspacing="0" border="0" class="stdtable stdtablecb display">
					<tbody>
						<tr>
							<td style="width:14%; vertical-align:top; border-top: 1px solid #ddd;">
								<label><strong>From Date: </strong></label><input type="text" id="start_date" value="<?php echo $from_date;?>" name="from_date">
							</td>
							<td style="width:22%;  vertical-align:top; border-top: 1px solid #ddd;">
								<label><strong>To Date: </strong></label><input type="text" value="<?php echo $to_date;?>" id="end_date" name="to_date">
							</td>
							<td style="width:22%;  vertical-align:top; border-top: 1px solid #ddd;">
								<label><strong>Tracking ID</strong></label><input type="text" value="<?php echo $track_id;?>" id="track_id" name="track_id">
							</td>
						</tr>
						<tr>							
							
							<td style="width:22%;  vertical-align:top; border-top: 1px solid #ddd;">
								<label><strong>Email ID</strong></label><input type="text" value="<?php echo $email_id;?>" id="email_id" name="email_id">
							</td>
							<td style="width:22%;  vertical-align:top; border-top: 1px solid #ddd;">
								<label><strong>Transaction Status </strong></label><input type="text" value="<?php echo $payment_status;?>" id="payment_status" name="payment_status">
							</td>
							<td style="width:30%; vertical-align:middle; border-top: 1px solid #ddd;">
								<input type="submit" name="submit" class="search_submit no_top_mrgn button_grey" value="Search">
							<a href="<?php echo base_url()?>superadmin/user/registration_payment_log" class="button_grey">Reset</a>
							</td>
						</tr>
					</tbody>
				</table>
		<input type="hidden" name="controller" id="controller" value="user" />
		<div class=" no-pad">
			<div class="container-outer">
				<div class="container-inner">
		<table cellpadding="0" cellspacing="0" border="0" class="stdtable display">			
			<thead>
			     <tr>
						<th class="head1">S.No.</th>
						<th class="head0">Bidder Email </th>
						<th class="head0">Tracking ID</th>
						<th class="head0">Payment Mode</th>
						<th class="head0">Bank Reference No.</th>
						<th class="head0">Amount (Rs.)</th>
						<th class="head0">Date</th>
						<th class="head0">IP Address</th>
						<th class="head0">Transaction Status</th>					  
			     </tr>
			</thead>
			<tbody>
				<?php
				
				 $i=0;foreach($records as $data){$i++;
					$pay_req = json_decode($data->data);
					$pay_res = json_decode($data->data);
					//echo "<pre>";print_r($pay_res);
					
					?>
					<tr class='gradeA'>
						<td><?php echo $i; ?></td>						
						<td><?php echo $data->payu_email; ?></td>
						<td><?php echo ($pay_res != '' && $pay_res != null) ? $pay_res->tracking_id :'--'; ?></td>
						<td>
						<?php 
								echo ($pay_res != '' && $pay_res != null && $pay_res->payment_mode != 'null') ? $pay_res->payment_mode :'--';
						?>
						</td>
						<td><?php echo ($pay_res->bank_ref_no != '' && $pay_res->bank_ref_no != 'null') ? $pay_res->bank_ref_no :'--' ; ?></td>						
						<td><?php echo ($pay_res != '' && $pay_res != null) ? $pay_res->mer_amount :$data->payu_amount.'.00'; ?></td>
						<td><?php 
								$payDate = str_replace('/','-',$pay_res->trans_date);
								echo ($pay_res != '' && $pay_res != null && $payDate !='null') ? $payDate :date('d-m-Y H:i:s',strtotime($data->sendTime));
							?></td>
						<td><?php echo ($data->ip !='')? $data->ip:'--'; ?></td>
						<td><?php echo ($pay_res->order_status !='')?ucfirst($pay_res->order_status):ucfirst($data->paymentStatus); ?></td>
					     </tr>
				<?php }?>	
				
			</tbody>
		</table>
		<div class="row" style="text-align:center;">						
		  <a href="<?php echo base_url().'superadmin/home'?>" class="button_grey">Back</a> 
		   </div>
		 </div>
	       </div>
		<div class="pagination">
                     <span style="float:left;padding-top:9px;"><?php echo $total_rows; ?></span>
                   <span style="float:left">
                       <input type="submit" name="submit" value="Download" class="button_grey">
                       &nbsp;
                   </span>
                   
		 <span style="float:right;padding-top:9px;"><?php echo $pagination_links; ?></span>
		</div>
	</form>
	</div><!-- #updates -->
</div><!--contentwrapper-->
<br clear="all" />
</div><!-- centercontent -->

</section>
<script>
jQuery(document).ready(function() {
    
      jQuery('#start_date').datetimepicker({
		controlType: 'select',
		oneLine: true,
		changeMonth: true,
		changeYear: true,
		dateFormat: 'yy-mm-dd',
		yearRange: '2018:<?php echo date('Y');?>',
		timeFormat: 'HH:mm:00'
	});
	jQuery('#end_date').datetimepicker({
		controlType: 'select',
		oneLine: true,
		changeMonth: true,
		changeYear: true,
		dateFormat: 'yy-mm-dd',
		yearRange: '2018:<?php echo date('Y');?>',
		timeFormat: 'HH:mm:00'
	});
    
    
    
    jQuery('#selecctall1').click(function(event) {  //on click
        if(this.checked) { // check select status
            jQuery('.status12').each(function() { //loop through each checkbox
                this.checked = true;  //select all checkboxes with class "checkbox1"
				jQuery(this).parent().addClass('checked');
				
            });
        }else{
            jQuery('.status12').each(function() {
                //loop through each checkbox
                this.checked = false; 
                //deselect all checkboxes with class "checkbox1" 
                jQuery(this).parent().removeClass('checked');
            });        
        }
    });
   
});
function validateform(){  
 if(jQuery("#start_date").val()!=''){
         if(jQuery("#end_date").val()==''){
             alert("Please Select To Date");
             return false;
         }
    }
}
function checkSelection(){
    alert("under process");
	
}
</script>


    
