<script type="text/javascript" src="<?php echo VIEWBASE; ?>js/plugins/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="<?php echo VIEWBASE; ?>js/custom/tables.js"></script>
<link rel="stylesheet" href="<?php echo base_url()?>js/calender/jquery-ui.css">
<script src="<?php echo base_url(); ?>js/calender/jquery-ui.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>js/calender/jquery-ui-timepicker-addon.min.js"></script>
<link rel="stylesheet" href="<?php echo base_url()?>js/calender/jquery-ui-timepicker-addon.css">
<script type="text/javascript" src="<?php echo VIEWBASE; ?>js/custom/forms.js"></script>
<style>	
	.usrBtn:focus{background-color: #807c7c;color:#ffffff;}  
	.usrBtn:hover{background-color: #807c7c;color:#ffffff;} 
</style>
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
<?php } ?>		<div class="row">		
			<a href="<?php echo base_url().'superadmin/user/bidder_list'?>" class="button_grey usrBtn">Bidder List</a>
			<a href="<?php echo base_url().'superadmin/user/jda_user_list'?>" class="button_grey usrBtn"><?php echo BRAND_NAME; ?> User List</a>
		</div>
<div class="box-head"><?php echo BRAND_NAME; ?> User List</div>
   <div class="centercontent tables">
	<div class="pageheader notab">	
	</div><!--pageheader-->	
	<div id="contentwrapper" class="contentwrapper box-content2">
            <form action="" method="GET"  id="searchfm" name="searchfm" onsubmit="return validateform();">
			<table cellpadding="0" cellspacing="0" border="0" class="stdtable stdtablecb display">
			        <tbody>
                                        <tr>
                                          
                                            <td style="width:22%;  vertical-align:top; border-top: 1px solid #ddd;">
										<label><strong>Email ID: </strong></label><input type="text" value="<?php echo $email_id;?>" id="email_id" name="email_id">
											</td>
                                      <td rowspan="3" style="width:15%; vertical-align:middle; border-top: 1px solid #ddd;">
                                          <input type="submit" name="submit" class="search_submit no_top_mrgn button_grey" value="Search">
                                      </td>
                                     </tr>
                                     <tr>
									  
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
                               <th class="head0">User ID</th>
                                <!--<th class="head1">Log ID</th>-->
                                <th class="head1">User Name</th>
                                <th class="head1">Email ID</th>
                                 <th class="head1">Mobile Number</th>
                                <th class="head1">Department ID</th>
                                 <th class="head1">Department Name</th>
                                 <th class="head1">Roles</th>
                               
                            
                                
			     </tr>
			</thead>
			<tbody>
				<?php $i=0;foreach($records as $data){$i++;?>
					<tr class='gradeA'>
						<td><?php echo $i; ?></td>
                                  <!--<td><?php echo $data->id; ?></td>-->
                                  <td><?php echo $data->first_name.' '.$data->last_name; ?></td>
								  <td><?php echo $data->email_id;?></td>
                                  <td><?php echo $data->mobile_no;?></td>
                                  <td><?php echo $data->department_id;?></td>
                                  <td><?php echo $data->department_name;?></td>
                                  <td><?php echo $data->name;?></td>
						
					
						
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
		yearRange: '2016:2017',
		timeFormat: 'HH:mm:00'
	});
	jQuery('#end_date').datetimepicker({
		controlType: 'select',
		oneLine: true,
		changeMonth: true,
		changeYear: true,
		dateFormat: 'yy-mm-dd',
		yearRange: '2016:2017',
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


    
