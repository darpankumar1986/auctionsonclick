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
    if(isset($_POST['name']) and !empty($_POST['name']))
    {
        $name=$_POST['name'];
    }
	if(isset($_POST['email']) and !empty($_POST['email']))
    {
        $email=$_POST['email'];
    }
	if(isset($_POST['mobile']) and !empty($_POST['mobile']))
    {
        $mobile=$_POST['mobile'];
    }
    ?>
<?php if( $this->session->flashdata('message')) {?>
<span class="success_msg"><img src="<?php echo VIEWBASE; ?>images/icon_checkmark_small.png" class="success_tick"><?php echo $this->session->flashdata('message'); ?></span>
<?php } ?>		
<div class="box-head">Contact Us Logs</div>
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
								<label><strong>Name </strong></label><input type="text" value="<?php echo $name;?>" id="name" name="name">
							</td>
							
						</tr>
						<tr>
							<td style="width:22%;  vertical-align:top; border-top: 1px solid #ddd;">
								<label><strong>Email ID </strong></label><input type="text" value="<?php echo $email;?>" id="email" name="email">
							</td>
							<td style="width:22%;  vertical-align:top; border-top: 1px solid #ddd;">
								<label><strong>Mobile No. </strong></label><input type="text" value="<?php echo $mobile;?>" id="mobile" name="mobile">
							</td>
							<td colspan="1" style="width:22%; vertical-align:middle; border-top: 1px solid #ddd;">
								<input type="submit" name="submit" class="search_submit no_top_mrgn button_grey" value="Search">
							<a href="<?php echo base_url()?>superadmin/user/contact_us_log" class="button_grey">Reset</a>
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
						<th class="head0">Name</th>
						<th class="head0">Email Address</th>
						<th class="head0">Mobile No.</th>
						<th class="head0">Topic</th>
						<th class="head0">Message</th>
						<th class="head0">Created Date</th>
			     </tr>
			</thead>
			<tbody>
				<?php 
					$i=0;
					foreach($records as $row){
					$i++;
					$indate = date('d M Y',strtotime($row->in_date_time));
					//echo "<pre>";print_r($pay_res);
					?>
					<tr class='gradeA'>
						<td><?php echo $i; ?></td>
						<td><?php echo $row->name; ?></td>
						<td><?php echo $row->email; ?></td>
						<td><?php echo $row->mobile;?></td>
						<td><?php echo $row->topic_name;?></td>
						<td><?php echo $row->message;?></td>
						<td><?php echo $indate; ?></td>
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


    
