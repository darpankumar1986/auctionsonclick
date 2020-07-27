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
<div class="row">		
			<a href="<?php echo base_url().'admin/user/bidder_list'?>" class="button_grey usrBtn">Awarded List Log</a>
			<a href="<?php echo base_url().'admin/user/not_awardedList_log'?>" class="button_grey usrBtn">Not Awarded List Log</a>
		</div>
<div class="box-head">Not Awarded List Logs</div>
   <div class="centercontent tables">
	<div class="pageheader notab">	
	</div><!--pageheader-->	
	<div id="contentwrapper" class="contentwrapper box-content2">
            <form action="" method="GET"  id="searchfm" name="searchfm" onsubmit="return validateform();">
			<table cellpadding="0" cellspacing="0" border="0" class="stdtable stdtablecb display">
			        <tbody>
						<tr>
						  <td style="width:14%; vertical-align:top; border-top: 1px solid #ddd;" colspan="6">
							  <label><strong>From Date</strong></label><input type="text" id="start_date" value="<?php echo $from_date;?>" name="from_date">
							   </td>
						   <td style="width:22%;  vertical-align:top; border-top: 1px solid #ddd;">
							   <label><strong>To Date</strong></label><input type="text" value="<?php echo $to_date;?>" id="end_date" name="to_date">
						   </td>
						  
						   <td rowspan="3" style="width:15%; vertical-align:middle; border-top: 1px solid #ddd;">
							   <input type="submit" name="submit" class="search_submit no_top_mrgn button_grey" value="Search">
							   <a href="<?php echo base_url()?>admin/user/bidsubmitlog" class="button_grey">Reset</a>
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
                                <th class="head1">Sr No.</th>
                                <th class="head0">Property ID</th>
                                <th class="head0">H1 Bidder</th>
                                <?php /* ?><th class="head1">Browser Type</th><?php */ ?>
                                <th class="head0">Status</th>
                                <th class="head0">Awarded By</th>
                                <th class="head1">Date</th>
                                <th class="head1">IP Address</th>
			     </tr>
			</thead>
			<tbody>
				<?php $i=1;foreach($records as $data){?>
					<tr class='gradeA'>
						<?php /* ?><td><?php echo $data->id; ?></td><?php */ ?>
						<td><?php echo $i;?></td>
						<td><?php echo $data->reference_no; ?></td>
						<td><?php echo $data->bidder_name; ?></td>
						<td><?php if($data->awardedStatus == 1){echo "Awarded";} ?></td>
						<td><?php echo $data->awarded_by_name; ?></td>
						<td><?php echo date('d-m-Y H:i:s', strtotime($data->awarded_date)); ?></td>
						
						<td><?php echo $data->awarded_ip; ?></td>
						
						</tr>
				<?php $i++; }?>	
				
			</tbody>
		</table>
		<div class="row" style="text-align:center;">						
		  <a href="<?php echo base_url().'admin/home'?>" class="button_grey">Back</a> 
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


    
