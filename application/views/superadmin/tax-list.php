<script type="text/javascript" src="<?php echo VIEWBASE; ?>js/plugins/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="<?php echo VIEWBASE; ?>js/custom/tables.js"></script>
<script type="text/javascript" src="<?php echo VIEWBASE; ?>js/custom/forms.js"></script>

	<section class="container_12">		
		<div class="row">						
			<a href="<?php echo base_url().'superadmin/taxmaster/addedit'?>" class="button_grey">Create New Tax</a>
		</div>
		<?php if( $this->session->flashdata('message')) {?>
				<span class="success_msg"><img src="<?php echo VIEWBASE; ?>images/icon_checkmark_small.png" class="success_tick">
				<?php echo $this->session->flashdata('message'); ?></span>		
		<?php } ?>
		<div class="box-head">Tax List</div>
		<div class="centercontent tables">
			<div class="pageheader notab">
				<?php /* ?>
				<h1 class="pagetitle"><span style="float:left"><?php echo $heading; ?></span><span style="float:right"><a href="/superadmin/user/bankeraddedit" class="b_green"><strong>Add New Bank User</strong></a>	</span></h1>
				<?php */ ?>
			</div><!--pageheader-->	
			<div id="contentwrapper" class="contentwrapper box-content2">
			<form action="" method="POST" id="searchfm" name="searchfm">

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
							<th class="head0">ID</th>
							<th class="head1">Service Tax</th>
							<th class="head0">Educess</th>
							<th class="head1">Secondary Higher Tax</th>
							<th class="head0">Swacchbharat Tax </th>
							<th class="head0">krishi_kalyan Tax </th>
							<th class="head1">Tax From Date</th>
							<th class="head1">Tax To Date</th>
							<th class="head1">Creation Date</th>
							<th class="head0">Action</th>
						</tr>
					</thead>
					<tbody>
						<?php $i=0;foreach($records as $data){$i++;?>
							<tr class='gradeA'>
								<td><?php echo $data->id; ?></td>
								<td><?php echo $data->stax; ?></td>
								<td><?php echo $data->educess; ?></td>
								<td><?php echo $data->secondaryhighertax; ?></td>
								<td><?php echo $data->swacchbharat_tax; ?></td>
								<td><?php echo $data->krishi_kalyan; ?></td>
								<td><?php echo $data->start_date; ?></td>
								<td><?php echo $data->end_date; ?></td>
								<td><?php echo $data->indate; ?></td>
								<?php  ?>
								<td>
									<a href="<?php echo base_url();?>superadmin/taxmaster/addedit/<?php echo $data->id; ?>">Edit</a>
								</td>
								</php  ?>
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
    jQuery('#selecctall1').click(function(event) {  //on click
        if(this.checked) { // check select status
            jQuery('.status12').each(function() { //loop through each checkbox
                this.checked = true;  //select all checkboxes with class "checkbox1"
				jQuery(this).parent().addClass('checked');
				
            });
        }else{
            jQuery('.status12').each(function() { //loop through each checkbox
                this.checked = false; //deselect all checkboxes with class "checkbox1" 
				jQuery(this).parent().removeClass('checked');
            });        
        }
    });
   
});
function checkSelection()
{
	var flag=false;
	jQuery('.status12').each(function() { //loop through each checkbox
		if(this.checked)
		 flag=true;		
	});
	if(flag)
	{
	 return true;
	}
	else
	{
		alert('Select any one.');
		return false;
	}
}
</script>


    
