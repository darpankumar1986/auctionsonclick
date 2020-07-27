<script type="text/javascript" src="<?php echo VIEWBASE; ?>js/plugins/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="<?php echo VIEWBASE; ?>js/custom/tables.js"></script>
<script type="text/javascript" src="<?php echo VIEWBASE; ?>js/custom/forms.js"></script>

<section class="container_12">

<div class="centercontent tables">
	<div class="pageheader notab">
			<div class="row">						
					<a href="<?php echo base_url()?>superadmin/upload_document/addedit" class="button_grey">Create Upload Document Field</a>
				</div>
				<?php if( $this->session->flashdata('message')) {?>
								<span class="success_msg"><img src="<?php echo VIEWBASE; ?>images/icon_checkmark_small.png" class="success_tick">
								<?php echo $this->session->flashdata('message'); ?></span>		
				<?php } ?>
				<div class="box-head">Upload Document Field List</div>
				<?php /* ?>
		<h1 class="pagetitle"><span style="float:left"><?php echo $heading; ?></span><span style="float:right"><a href="/superadmin/city/addedit" class="b_green"><strong>Add New City</strong></a>	</span></h1>
		<?php */ ?>
	
	</div><!--pageheader-->	
	
	<div id="contentwrapper" class="contentwrapper">
	<form action="" method="GET" id="searchfm" name="searchfm">
			<table cellpadding="0" cellspacing="0" border="0" class="stdtable stdtablecb display">
				<tbody>
					<tr>
						
						<td style="width:3%; vertical-align:top; border-top: 1px solid #ddd;" colspan="6"><input type="text" placeholder="Search..." name="title" class="custom_select no_top_mrgn" value="<?php echo $search['title']?>"></td>
						<td rowspan="3" style="width:15%; vertical-align:middle; border-top: 1px solid #ddd;">
							<input type="submit" name="btnSearch" id="btnSearch" class="search_submit no_top_mrgn button_grey" value="Search">
						</td>
					</tr>
					
				</tbody>
			</table>
		
		
	<input type="hidden" name="controller" id="controller" value="city" />
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
								</colgroup>
								<thead>
									<tr>
										<th class="head0">Field ID</th>
										<th class="head1">Field Name</th>
										<th class="head1">Field Type</th>
										<th class="head1">Field Mandatory</th>
										<th class="head0">Status</th>
										<!--<th class="head1"><input type="checkbox" id="selecctall1"/></th>-->
										<th class="head0">Actions</th>
									</tr>
								</thead>
								
								<tbody>
									<?php $i=0;foreach($records as $data){ $i++;
									$totalrows=$this->upload_document_model->GetTotalRecord($data->upload_document_field_id);
									
									?>
										<tr class='gradeA'>
											<td><?php echo $data->upload_document_field_id; ?> </td>
											<td><?php echo $data->upload_document_field_name; ?></td>
											<td><?php echo ($data->upload_document_field_type == 1)?'Image':'Video'; ?></td>
											<td><?php echo ($data->isMandatory == 1)?'Yes':'No'; ?></td>
											<td><?php echo ($data->status == 1)?'Active':'Inactive'; ?></td>
											<!--<td><input type="checkbox" class="status12" name="status[]" value="<?php echo $data->upload_document_field_id; ?>"></td>-->
											<td>
												<a href="/superadmin/upload_document/addedit/<?php echo $data->upload_document_field_id; ?>">Edit</a>
											 
											 <!--
											 <?php if($totalrows<=0) { ?>
											 | 
											 <a href="javascript:;" data-id="<?php echo $data->id; ?>" class="deletelink"><strong>Delete</strong></a>
											 
											 <?php }else{ ?>
											 |
											<b> <?php echo $totalrows;?> Auction </b>
											 <?php } ?>
											 -->
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
								<input type="submit" name="submit" onclick="return checkSelection(); return confirm('Are you sure, Inactive all?');" value="Deactivate all" class="button_grey">
							</span><?php */ ?>
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
