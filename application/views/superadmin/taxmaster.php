<script type="text/javascript" src="<?php echo VIEWBASE; ?>js/plugins/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="<?php echo VIEWBASE; ?>js/custom/tables.js"></script>
<script type="text/javascript" src="<?php echo VIEWBASE; ?>js/custom/forms.js"></script>
<div class="centercontent tables">
	<div class="pageheader notab">
		<h1 class="pagetitle"><span style="float:left"><?php echo $heading; ?></span><span style="float:right"><a href="/superadmin/superadmin/addedit" class="b_green"><strong>Add New</strong></a>	</span></h1>
		<span class="pagedesc"><?php if( $this->session->flashdata('message')) {?>
		<?php echo $this->session->flashdata('message'); ?><?php } ?></span>		
	</div><!--pageheader-->	
	<div id="contentwrapper" class="contentwrapper">
	<form method="post" action="">
		<input type="hidden" name="controller" id="controller" value="admin" />
		<table cellpadding="0" cellspacing="0" border="0" class="stdtable">
			
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
					<th class="head1">Role</th>
					<th class="head0">Status</th>
					<th class="head1">Select <input type="checkbox" id="selecctall1"/></th>
					<th class="head1">Added Date</th>
					<th class="head0">Actions</th>
				</tr>
			</thead>
			
			<tbody>
				<?php $i=0;foreach($records as $data){$i++;?>
					<tr class='gradeA'>
						<td><?php echo $data->id;; ?></td>
						<td><?php echo $data->name; ?></td>
						<td><?php echo $data->email; ?></td>
						<td><?php echo GetTitleById('tbl_role', $data->role); ?></td>
						<td><?php echo ($data->status == 1)?'Active':'Inactive'; ?></td>
						<td><input type="checkbox" class="status12" name="status[]" value="<?php echo $data->id; ?>"></td>
						<td><?php echo GetDateFormat($data->indate); ?></td>
						<td>
							<a href="/superadmin/superadmin/addedit/<?php echo $data->id; ?>"><strong>Edit</strong></a>
						 | <a href="javascript:;" data-id="<?php echo $data->id; ?>" class="deletelink"><strong>Delete</strong></a>
						</td>
					</tr>
				<?php }?>	
				
			</tbody>
		</table>
		<div class="pagination">
			<span style="float:left"><input type="submit" name="submit" onclick="return checkSelection(); return confirm('Are you sure, activate all?');" value="Active all">&nbsp;<input type="submit" name="submit" onclick="return checkSelection(); return confirm('Are you sure, Inactive all?');" value="Deactivate all"></span>
			<span style="float:right"><?php echo $pagination_links; ?></span>
		</div>
	</form>
	</div><!-- #updates -->
</div><!--contentwrapper-->
<br clear="all" />
</div><!-- centercontent -->
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


    
