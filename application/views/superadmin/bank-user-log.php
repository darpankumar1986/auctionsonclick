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
    
    if(isset($_POST['email_id']) and !empty($_POST['email_id']))
    {
        $email_id=$_POST['email_id'];
    }
    ?>
<?php if( $this->session->flashdata('message')) {?>
<span class="success_msg"><img src="<?php echo VIEWBASE; ?>images/icon_checkmark_small.png" class="success_tick"><?php echo $this->session->flashdata('message'); ?></span>
<?php } ?>		
<div class="box-head">User Log List</div>
   <div class="centercontent tables">
	<div class="pageheader notab">	
	</div><!--pageheader-->	
	<div id="contentwrapper" class="contentwrapper box-content2">
            <form action="" method="GET"  id="searchfm" name="searchfm" onsubmit="return validateform();">
			<table cellpadding="0" cellspacing="0" border="0" class="stdtable stdtablecb display">
			        <tbody>
						<tr>
						  <td style="width:14%; vertical-align:top; border-top: 1px solid #ddd;" colspan="6">
							  <label><strong>From Date: </strong></label><input type="text" id="start_date" value="<?php echo $from_date;?>" name="from_date">
							   </td>
						   <td style="width:22%;  vertical-align:top; border-top: 1px solid #ddd;">
							   <label><strong>To Date: </strong></label><input type="text" value="<?php echo $to_date;?>" id="end_date" name="to_date">
						   </td>
						    <td style="width:22%;  vertical-align:top; border-top: 1px solid #ddd;">
								<label><strong>Email ID: </strong></label><input type="text" value="<?php echo $email_id;?>" id="email_id" name="email_id">
							</td>
						   <td rowspan="3" style="width:15%; vertical-align:middle; border-top: 1px solid #ddd;">
							   <input type="submit" name="submit" class="search_submit no_top_mrgn button_grey" value="Search">
							   <a href="<?php echo base_url()?>superadmin/user/userlog" class="button_grey">Reset</a>
						   </td>
						 </tr>
			        </tbody>
			</table>
		<input type="hidden" name="controller" id="controller" value="user" />
		<div class=" no-pad">
			<div class="container-outer">
				<div class="container-inner">
		<table cellpadding="0" cellspacing="0" border="0" class="stdtable display">
			<colgroup>
				<col class="con0" />
				<col class="con1" />
				<col class="con0" />
				<col class="con1" />
				<col class="con0" />
				<col class="con1" />
				<col class="con0" />				
			</colgroup>
			<thead>
			     <tr>
                                <?php /* ?><th class="head0">ID</th><?php */ ?>
                                <th class="head1">Email ID</th>
                                <th class="head0">User Type</th>
                                <!--<th class="head0">Main User Type</th>-->
                                <?php /* ?><th class="head1">Browser Type</th><?php */ ?>
                                <th class="head0">IP Address</th>
                                <th class="head1">Login Date/Time</th>
                                <th class="head1">Logout Date/Time</th>
			     </tr>
			</thead>
			<tbody>
				<?php $i=0;foreach($records as $data){$i++;?>
					<tr class='gradeA'>
						<?php /* ?><td><?php echo $data->id; ?></td><?php */ ?>
						<td><?php echo $data->email_id;?></td>
						<td><?php echo ($data->user_type == 'buyer') ? 'Branch User':'Bidder'; ?></td>
						<!--<td><?php echo $data->user_type_main; ?></td>-->
						<?php /* ?>
						<td>
							<?php 
						if (stripos( $data->browser_type, 'Chrome') !== false)
						{
							echo "Google Chrome";
						}

						elseif (stripos( $data->browser_type, 'Safari') !== false)
						{
						   echo "Safari";
						}else{
							echo ucfirst($data->browser_type);
						}
						 ?></td>
						<?php */ ?>
						<td><?php echo $data->ip_address; ?></td>
						<td><?php echo $data->login_datetime; ?></td>
						<td><?php echo $data->logout_datetime; ?></td>
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


    
