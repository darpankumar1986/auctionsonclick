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
<?php
	$userid = $this->uri->segment(4);
    $user_type =	GetTitleByField('tbl_user_registration', "id='".$userid."'", "user_type");
    if($user_type == 'owner')
    {
        $full_name =	GetTitleByField('tbl_user_registration', "id='".$userid."'", "first_name");
        $full_name .= ' '.GetTitleByField('tbl_user_registration', "id='".$userid."'", "last_name");
    }
    else
    {
        $full_name .= ' '.GetTitleByField('tbl_user_registration', "id='".$userid."'", "authorized_person");
    }

?>
<style>
table a:hover {
    text-decoration: underline;
    color: #fff;
}
</style>
<div class="box-head"><?php echo $full_name; ?>: Subscription Logs</div>
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
								<label><strong>Package Name </strong></label><input type="text" value="<?php echo $name;?>" id="name" name="name">
							</td>
							
						</tr>
						<tr>
							
							<td colspan="3" align="center" style="width:22%; vertical-align:middle; border-top: 1px solid #ddd;">
								<input type="submit" name="submit" class="search_submit no_top_mrgn button_grey" value="Search">
							<a href="<?php echo base_url()?>superadmin/user/user_subscription_logs/<?php echo $userid; ?>" class="button_grey">Reset</a>
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
						<th class="head1"style="width:2%">S.No.</th>
						<th class="head0" style="width:13%">Package Name</th>
						<th class="head0" style="width:30%">Package Description</th>
						<th class="head0" style="width:10%">Amount (Rs.)</th>
						<th class="head0" style="width:15%">Package Start Date</th>
						<th class="head0" style="width:15%">Package End Date</th>
						<th class="head0" style="width:15%">Package Purchase Date</th>
			     </tr>
			</thead>
			<tbody>
				<?php 
					$i=0;
					foreach($records as $row){
					$i++;
					$package_start_date = date('d M Y H:i:s',strtotime($row->package_start_date));
					$package_end_date = date('d M Y H:i:s',strtotime($row->package_end_date));
					$indate = date('d M Y H:i:s',strtotime($row->subscription_created_on));
					//echo "<pre>";print_r($pay_res);
					?>
					<tr class='gradeA'>
						<td><?php echo $i; ?></td>
						<td><?php echo $row->package_name; ?></td>
						<td><?php echo $row->package_description; ?></td>
						<td><?php echo $row->package_amount;?></td>
						<td><?php echo $package_start_date;?></td>
						<td><?php echo $package_end_date;?></td>
						<td><?php echo $indate; ?></td>
				<?php }?>	
				
			</tbody>
		</table>
		<div class="row" style="text-align:center;">						
		  <a href="<?php echo base_url().'superadmin/user/user_subscription_list'?>" class="button_grey">Back</a> 
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


    
