<script type="text/javascript" src="<?php echo VIEWBASE; ?>js/plugins/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="<?php echo VIEWBASE; ?>js/custom/tables.js"></script>
<script type="text/javascript" src="<?php echo VIEWBASE; ?>js/custom/forms.js"></script>
		<section class="container_12">
				<div class="centercontent tables">
					<div class="pageheader notab">
						<div class="row">						
							<a href="/superadmin/caste_category/<?php if($type != 'main'){echo 'addedit';}else{echo 'addeditmain';}?>" class=" button_grey">Create Category</a>
						</div>
						<?php if( $this->session->flashdata('message')) {?>
								<span class="success_msg"><img src="<?php echo VIEWBASE; ?>images/icon_checkmark_small.png" class="success_tick">
								<?php echo $this->session->flashdata('message'); ?></span>		
						<?php } ?>
						<div class="box-head">Category List</div>
						<?php /* ?>
						<h1 class="pagetitle">
								<span style="float:left"><?php echo $heading; ?></span>
								<span style="float:right">
										<a href="/superadmin/category/<?php if($type != 'main'){echo 'addedit';}else{echo 'addeditmain';}?>" class=" button_grey"><strong>Add New Category</strong></a>	
								</span>
						</h1>
						<?php */ ?>
								
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
														<th class="head0">Category ID</th>
														<th class="head1">Category Name</th>														
														<th class="head0">Status</th>														
														<th class="head1">Added Date</th>
														<th class="head0">Modified Date</th>
														<th class="head1">Actions</th>
													</tr>
												</thead>
												
												<tbody>
													<?php $i=0;foreach($records as $data){$i++;?>
														<tr class='gradeA'>
															<td><?php echo $data->caste_category_id; ?></td>
															<td><?php echo $data->caste_category_name; ?></td>
															<td><?php echo ($data->status == 1)?'Active':'Inactive'; ?></td>
															<td><?php echo GetDateFormat($data->inDate); ?></td>
															<td><?php echo GetDateFormat($data->modified_date); ?></td>
															<td>
															<?php if($type == 'main'){?>
																<a href="/superadmin/caste_category/addeditmain/<?php echo $data->caste_category_id; ?>">Edit</a>
															<?php }else{?>
																<a href="/superadmin/caste_category/addedit/<?php echo $data->caste_category_id; ?>">Edit</a>
															<?php }?>															
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


    
