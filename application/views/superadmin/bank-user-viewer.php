<script type="text/javascript" src="<?php echo VIEWBASE; ?>js/plugins/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="<?php echo VIEWBASE; ?>js/custom/tables.js"></script>
<script type="text/javascript" src="<?php echo VIEWBASE; ?>js/custom/forms.js"></script>		
	<section class="container_12">		
		<div class="row">						
			<a href="<?php echo base_url().'superadmin/user/vieweraddedit'?>" class="button_grey">Create Viewer User</a>
		</div>
		<?php if( $this->session->flashdata('message')) {?>
				<span class="success_msg"><img src="<?php echo VIEWBASE; ?>images/icon_checkmark_small.png" class="success_tick">
				<?php echo $this->session->flashdata('message'); ?></span>		
		<?php } ?>
		<div class="box-head">Branch User List</div>
		<div class="centercontent tables">
			<div class="pageheader notab">
				<span class="pagedesc"><?php if( $this->session->flashdata('message')) {?>
				<?php //echo $this->session->flashdata('message'); ?><?php } ?></span>
			</div><!--pageheader-->	
			<div id="contentwrapper" class="contentwrapper box-content2">
			<form action="" method="GET" id="searchfm" name="searchfm">
					<table cellpadding="0" cellspacing="0" border="0" class="stdtable stdtablecb display">
						<tbody>
							<tr>
								
								<td style="width:14%; vertical-align:top; border-top: 1px solid #ddd;" colspan="6"><input type="text" class="custom_select no_top_mrgn" placeholder="Enter Search" name="title" value="<?php echo $search['title']?>"></td>
								<td rowspan="3" style="width:35%; vertical-align:middle; border-top: 1px solid #ddd;">
									<input type="submit" class="search_submit  button_grey no_top_mrgn" name="btnSearch" id="btnSearch" value="Search">
								</td>
							</tr>
						</tbody>
					</table>
				<input type="hidden" name="controller" id="controller" value="user" />
				<div class="box-content no-pad">
					<div class="container-outer">
						<div class="container-inner">
				<table cellpadding="0" cellspacing="0" border="0" class="stdtable display">
					
					<colgroup>
						<col class="con0" />
						<col class="con1" style="width:50px !important"/>
						<col class="con0" />
						<col class="con1" />
						<col class="con0" />
						<col class="con1" />
						<col class="con0" />				
					</colgroup>
					<thead>
						<tr>
							<th class="head0" >ID</th>
							<th class="" style="width:50px !important">Login ID</th>
							<th class="head1">Name</th>
							<th class="head1">Designation</th>
							<th class="head0" style="width:50px !important">User ID</th>
							
							<th class="head1">Organization Name</th>
							<th class="head1">Branch Name</th>
							<th class="head0">Status</th>
							<th class="head0">Type</th>
							<th class="head1">Creation Date</th>
							<th class="head0">Action</th>
						</tr>
					</thead>
					
					<tbody>
						<?php $i=0;foreach($records as $data){$i++;?>
							<tr class='gradeA'>
								<td><?php echo $data->id; ?></td>
								<td style="width:50px !important"><?php echo $data->email_id; ?></td>
								<td><?php echo $data->first_name.' '.$data->last_name; ?></td>
								<td><?php echo $data->designation; ?></td>
								<td><?php echo $data->user_id; ?></td>
								
								<td><?php echo $data->bank_name; ?></td>
								<td><?php echo $data->branch_name; ?></td>
								<td><?php echo ($data->status == 1)?'Active':'Inactive'; ?></td>
								<td><?php echo $data->user_type; ?></td>
								<td><?php echo $data->indate; ?></td>
								<td>
									<a href="<?php if($data->user_type=='b2c'){?>/superadmin/user/addedit_b2c/<?php echo $data->id; ?><?php }else{?>/superadmin/user/vieweraddedit/<?php echo $data->id; ?><?php }?>">Edit
									</a>
								</td>
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
					<?php /* ?><span style="float:left"><input type="submit" name="submit" onclick="return checkSelection(); return confirm('Are you sure, activate all?');" value="Active all" class="button_grey">&nbsp;<input type="submit" name="submit" onclick="return checkSelection(); return confirm('Are you sure, Inactive all?');" value="Deactivate all" class="button_grey"></span><?php */ ?>
					<span style="float:right;padding-top: 9px;"><?php echo $pagination_links; ?></span>
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


    