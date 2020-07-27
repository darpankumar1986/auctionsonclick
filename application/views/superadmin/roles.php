<script type="text/javascript" src="<?php echo VIEWBASE; ?>js/plugins/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="<?php echo VIEWBASE; ?>js/custom/tables.js"></script>
<script type="text/javascript" src="<?php echo VIEWBASE; ?>js/custom/forms.js"></script>

<section class="container_12">
		<div class="centercontent tables">
			<div class="pageheader notab">
				<div class="row">						
					<a href="/superadmin/rolepage/addeditrole" class=" button_grey">Create Role</a>
				</div>
				<?php if( $this->session->flashdata('successMsg')) {?>
						<span class="success_msg"><img src="<?php echo VIEWBASE; ?>images/icon_checkmark_small.png" class="success_tick">
						<?php echo $this->session->flashdata('successMsg'); ?></span>		
				<?php } ?>
				<div class="box-head">Role List</div>

						
			</div><!--pageheader-->	
			
			<div id="contentwrapper" class="contentwrapper">
			<form action="" method="GET" id="searchfm" name="searchfm">
					<table cellpadding="0" cellspacing="0" border="0" id="dt1" class="stdtable stdtablecb display">
						<tbody>
							<tr>
								<td style="width:5%; vertical-align:top; border-top: 1px solid #ddd;" colspan="6"><input type="text" class="custom_select no_top_mrgn" placeholder="Search..." name="title" value="<?php echo $search['title']?>"></td>
								
								<td rowspan="3" style="width:15%; vertical-align:middle; border-top: 1px solid #ddd;">
									<input type="submit" name="btnSearch" id="btnSearch" class="search_submit no_top_mrgn button_grey" value="Search">
								</td>
							</tr>
							
						</tbody>
					</table>
				<?php //search ends ?>
			
				<input type="hidden" name="controller" id="controller" value="category" />
				
				
				<div class="box-content no-pad">
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
											<col class="con1" />
											<col class="con0" />
										</colgroup>
										<thead>
											<tr>
												<th class="head0">ID</th>
												<th class="head1">Name</th>
												<th class="head1"><?php echo BRAND_NAME; ?> Role</th>
												<th class="head0">Status</th>
												<th class="head1">Added Date</th>
												<th class="head1">Actions</th>
											</tr>
										</thead>
										
										<tbody>
											<?php $i=0;foreach($records as $data){$i++;?>
												<tr class='gradeA'>
													<td><?php echo $data->role_id; ?></td>
													<td><?php echo $data->name; ?></td>
													<td><?php echo $data->jda_role; ?></td>
													<td><?php echo ($data->status) ? 'Active' : 'Inactive'; ?></td>
													<td><?php echo GetDateFormat($data->indate); ?></td>
													<td>
														<a href="/superadmin/rolepage/addeditrole/<?php echo $data->role_id; ?>">Edit</a>&nbsp;&nbsp;|
&nbsp;&nbsp;<a href="/superadmin/rolepage/assignrole/<?php echo $data->role_id; ?>/<?php echo $data->name; ?>">Assign</a>
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
					<?php /* ?><span style="float:left">
						<input type="submit" name="submit" onclick="return checkSelection(); return confirm('Are you sure, activate all?');" value="Active all" class="button_grey">&nbsp;
						<input type="submit" name="submit" onclick="return checkSelection(); return confirm('Are you sure, Inactive all?');" value="Deactivate all" class="button_grey"></span><?php */ ?>
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


    
