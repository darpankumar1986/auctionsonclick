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
<div class="box-head">GST MIS Report of Registration Fee</div>
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
								<label><strong>Email ID </strong></label><input type="text" value="<?php echo $email_id;?>" id="email_id" name="email_id">
							</td>
							
						</tr>
						<tr>
							<td style="width:22%;  vertical-align:top; border-top: 1px solid #ddd;">
								<label><strong>Transaction No. </strong></label><input type="text" value="<?php echo $track_id;?>" id="track_id" name="track_id">
							</td>
							<td colspan="2" style="width:30%; vertical-align:middle; border-top: 1px solid #ddd;">
								<input type="submit" name="submit" class="search_submit no_top_mrgn button_grey" value="Search">
							<a href="<?php echo base_url()?>superadmin/user/gst_mis_report_registration_fee" class="button_grey">Reset</a>
							</td>
						</tr>
					</tbody>
				</table>
		<input type="hidden" name="controller" id="controller" value="user" />
		<div class=" no-pad">
			<div class="container-outer">
				<div class="container-inner"  style="width:160% !important;">
		<table cellpadding="0" cellspacing="0" border="0" class="stdtable display">			
			<thead>
			     <tr>
						<th class="head1">S.No.</th>
						<th class="head0">Company Name</th>
						<th class="head0">Customer Name</th>
						<th class="head0">Email Address</th>
						<th class="head0">Contact Number</th>
						<th class="head0">Address of Customer</th>
						<th class="head0">Place of Supply</th>
						<th class="head0">Address of Delivery</th>
						<th class="head0">GST Number</th>
						<th class="head0">Description Of Service</th>
						<th class="head0">Base Amount</th>
						<th class="head0">Rate of tax (%)</th>
						<th class="head0">Total Tax Applicable</th>
						<th class="head0">Net Amount Paid</th>					  
						<th class="head0">Payment Date</th>					  
						<th class="head0">Payment Mode</th>					  
						<th class="head0">Transaction Number</th>					  
											  
			     </tr>
			</thead>
			<tbody>
				<?php 
					//echo '<pre>';print_r($records);die;
					$i=0;foreach($records as $data){$i++;
					$pay_res = json_decode($data->data);
					//echo "<pre>";print_r($pay_res);
					$address1 = GetTitleByField('tbl_user_registration',"id='".$data->regoriginalID."'",'address1');
					$address2 = GetTitleByField('tbl_user_registration',"id='".$data->regoriginalID."'",'address2');
					$city_id = GetTitleByField('tbl_user_registration',"id='".$data->regoriginalID."'",'city_id');
					$state_id = GetTitleByField('tbl_user_registration',"id='".$data->regoriginalID."'",'state_id');
					$country_id = GetTitleByField('tbl_user_registration',"id='".$data->regoriginalID."'",'country_id');
					$zip = GetTitleByField('tbl_user_registration',"id='".$data->regoriginalID."'",'zip');
					
					$cityName = GetTitleByField('tbl_city', "id='".$city_id."'", 'city_name');
					$stateName = GetTitleByField('tbl_state', "id='".$state_id."'", 'state_name');
					$countryName = GetTitleByField('tbl_country', "id='".$country_id."'", 'country_name');
					
					$customer_address = $address1;
					if($address2 !='')
					{
						$customer_address .= ', '.$address2;
					}
					$customer_address .= ', '.$cityName.', '.$stateName.', '.$countryName.', '.$zip;
					
					?>
					<tr class='gradeA'>
						<td><?php echo $i; ?></td>
						<td>
						<?php 
							$organisation_name = GetTitleByField('tbl_user_registration',"id='".$data->regoriginalID."'",'organisation_name');
							echo ($organisation_name != '')? $organisation_name:'N/A'; 
						?>
						 </td>
						<td>
						 <?php 
							if($organisation_name !='')
							{
								$customerName = GetTitleByField('tbl_user_registration',"id='".$data->regoriginalID."'",'authorized_person');
							}
							else
							{
								$fname = GetTitleByField('tbl_user_registration',"id='".$data->regoriginalID."'",'first_name');
								$lname = GetTitleByField('tbl_user_registration',"id='".$data->regoriginalID."'",'last_name');
								$customerName = $fname.' '.$lname;
							}
							echo ucwords(strtolower($customerName));
						 ?>
						 </td>
						 <td><?php echo $email_id = GetTitleByField('tbl_user_registration',"id='".$data->regoriginalID."'",'email_id'); ?></td>
						<td><?php echo $mobile_no = GetTitleByField('tbl_user_registration',"id='".$data->regoriginalID."'",'mobile_no');
						 ?></td>
						<td><?php echo $customer_address;?></td>
						<td><?php echo $stateName;?></td>
						<td><?php echo $customer_address;?></td>
						<td>
						<?php  
							$gst_no = GetTitleByField('tbl_user_registration',"id='".$data->regoriginalID."'",'gst_no');
							echo ($gst_no != '')? strtoupper($gst_no):'N/A'; 
						?>
						</td>
						<td><?php echo 'Registration Fee';?></td>
						<td><?php echo $baseAmt= round(($data->payu_amount*100)/118,2); ?></td>
						<td><?php echo '18.00'; ?></td>
						<td><?php echo $data->payu_amount - $baseAmt; ?></td>
						<td><?php echo $data->payu_amount; ?></td>
						<td><?php echo ($data->returnTime != 'null') ? $data->returnTime :'N/A' ; ?></td>
						<td><?php echo 'Online Payment'; ?></td>
						<td><?php echo ($data->payu_mihpayid != 'null') ? $data->payu_mihpayid :'--' ; ?></td>
						
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


    
