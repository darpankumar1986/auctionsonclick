<script type="text/javascript" src="<?php echo VIEWBASE; ?>js/plugins/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="<?php echo VIEWBASE; ?>js/custom/tables.js"></script>
<div class="centercontent tables">
	<div class="pageheader notab">
		<h1 class="pagetitle"><?php echo $heading; ?></h1>
		<span class="pagedesc"><?php if( $this->session->flashdata('message')) {?>
		<?php echo $this->session->flashdata('message'); ?><?php } ?></span>		
	</div><!--pageheader-->	
	<div id="contentwrapper" class="contentwrapper">
		<!--contenttitle<div class="contenttitle2">
			<h3><?php echo $heading; ?></h3>
		</div>-->
	<form action="" method="POST" id="searchfm" name="searchfm">
		<table cellpadding="0" cellspacing="0" border="0" class="stdtable" id="dyntable">
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
					<th class="head1">Title</th>
					<th class="head0">Status</th>
					<th class="head1">AddeDate</th>
					<th class="head0">ModifiedDate</th>
					<th class="head1"><input type="checkbox" id="selecctall1"/> Select</th>
					<th class="head0">Actions</th>
				</tr>
			</thead>

			<tbody>
				<?php $i=0;foreach($records as $data){$i++;?>
					<tr class='gradeA'>
						<td>
							<?php echo $i; ?>
						</td>
						<td>
							<?php echo $data->title; ?>
						</td>
						<td>
							<?php echo ($data->status)?'Active':'Inactive'; ?>
						</td>
						<td>
							<?php echo $data->added_date; ?>
						</td>
						<td>
							<?php echo $data->modified_date; ?>
						</td>
						<td><input type="checkbox" class="status12" name="status[]" value="<?php echo $data->webpage_id; ?>"></td>
						<td>
							<a href="/superadmin/webpage/addedit/<?php echo $data->webpage_id; ?>"><strong>Edit</strong></a> <!--| 
							<a onclick="return confirm('Are you sure you want to delete this record.');" href="/superadmin/webpage/deleteRecord/<?php echo $data->webpage_id; ?>"><strong>Delete</strong></a>-->
						</td>
					</tr>
				<?php }?>	
			</tbody>
		</table>
				<div class="pagination">
			<span style="float:left"><input type="submit" name="submit" onclick="return checkSelection(); return confirm('Are you sure, activate all?');" value="Active all">&nbsp;<input type="submit" name="submit" onclick="return checkSelection(); return confirm('Are you sure, Inactive all?');" value="Deactivate all"></span>
			<span style="float:right"><ul><?php echo $pagination_links; ?></ul></span>
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
	jQuery(".pagination ul li a").click(function() {
			frm = jQuery('#searchfm');
			frm.attr("action", jQuery(this).attr("href"));
			jQuery(this).attr("href", "javascript:void(0)");
			//jQuery('#searchfm').submit();
			jQuery('#btnSearch').click();
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

    
