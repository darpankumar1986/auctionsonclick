<script type="text/javascript" src="<?php echo VIEWBASE; ?>js/plugins/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="<?php echo VIEWBASE; ?>js/custom/tables.js"></script>
<script type="text/javascript" src="<?php echo VIEWBASE; ?>js/custom/forms.js"></script>
<section class="container_12">
	
		<?php if( $this->session->flashdata('message')) {?>
		<span class="success_msg"><img src="<?php echo VIEWBASE; ?>images/icon_checkmark_small.png" class="success_tick"><?php echo $this->session->flashdata('message'); ?></span>
		<?php } ?>		
		<div class="box-head">Blocked User List</div>
		<div class="centercontent tables">
			<div class="pageheader notab">
				<?php /* ?>
				<h1 class="pagetitle"><span style="float:left"><?php echo $heading; ?></span><span style="float:right"><a href="/superadmin/user/bankeraddedit" class="b_green"><strong>Add New Bank User</strong></a>	</span></h1>
				<?php */ ?>
			</div><!--pageheader-->	
	<div id="contentwrapper" class="contentwrapper box-content2">
	<form action="" method="POST" id="searchfm" name="searchfm">
			<table cellpadding="0" cellspacing="0" border="0" class="stdtable stdtablecb display">
				<tbody>
					<tr>
						
						<td style="width:14%; vertical-align:top; border-top: 1px solid #ddd;" colspan="6"><input type="text"  class="custom_select no_top_mrgn" name="title" value="<?php echo $search['title']?>"></td>
						<td style="width:22%;  vertical-align:top; border-top: 1px solid #ddd;">
							<select name="type" class="custom_select no_top_mrgn" id="type" style="width:30%;">
								<option value="">Select User Type</option>
							<option value="sales" <?php echo ($search['type']=='builder')?'selected':''; ?>>Organization</option>
							<option value="sales_cordinator" <?php echo ($search['type']=='owner')?'selected':''; ?>>Individual</option>
							<option value="drt" <?php echo ($search['type']=='broker')?'selected':''; ?>>Broker</option>
							</select></td>
						
						<td rowspan="3" style="width:15%; vertical-align:middle; border-top: 1px solid #ddd;">
							<input type="submit" name="btnSearch" id="btnSearch" class="search_submit no_top_mrgn button_grey" value="Search">
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
					<th class="head0">ID</th>
					<th class="head1">Name</th>
					<th class="head0">Email</th>
					
					<th class="head1">User Type</th>
					<th class="head0">Status</th>
					<!--<th class="head1"> <input type="checkbox" id="selecctall1"/> Select</th>-->
					<th class="head1">Added Date</th>
					<th class="head1">Blocked Date</th>
					<th class="head0">Actions</th>
				</tr>
			</thead>
			
			<tbody>
				<?php $i=0;foreach($records as $data){$i++;?>
					<tr class='gradeA'>
						<td><?php echo $data->id; ?></td>
						<td><?php echo $data->first_name.' '.$data->last_name; ?></td>
						<td><?php echo $data->email_id; ?></td>
						
						<td><?php echo ucfirst($data->user_type); ?></td>
						<td><?php echo ($data->status == 1)?'Active':'Inactive'; ?></td>
						<!--<td><input type="checkbox" class="status12" name="status[]" value="<?php echo $data->id; ?>"></td>-->
						<td><?php echo $data->indate; ?></td>
						<td><?php echo $data->blocked_time; ?></td>
						<td>
							<a href="<?php if($data->user_type=='b2c'){?>/superadmin/user/addedit_b2c/<?php echo $data->id; ?><?php }else{?>/superadmin/user/addedituserblock/<?php echo $data->id; ?><?php }?>"><strong>Edit</strong></a>
						 <!--|<a href="javascript:;" data-id="<?php echo $data->id; ?>" class="deletelink"><strong>Delete</strong></a>-->
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
			<span style="float:left"><input type="submit" name="submit" onclick="return checkSelection(); return confirm('Are you sure, activate all?');" value="Active all" class="button_grey">&nbsp;<input type="submit" name="submit" onclick="return checkSelection(); return confirm('Are you sure, Inactive all?');" value="Deactivate all" class="button_grey"></span>
			<span style="float:right;padding-top:9px;"><ul><?php echo $pagination_links; ?></ul></span>
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


    
