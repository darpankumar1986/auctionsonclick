<script type="text/javascript" src="<?php echo VIEWBASE; ?>js/plugins/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="<?php echo VIEWBASE; ?>js/custom/tables.js"></script>
<script type="text/javascript" src="<?php echo VIEWBASE; ?>js/plugins/jquery.colorbox-min.js"></script>
<script type="text/javascript" src="<?php echo VIEWBASE; ?>js/custom/forms.js"></script>
<script>
	jQuery(document).ready(function(){		
		//Examples of how to assign the Colorbox event to elements
		jQuery(".iframe").colorbox({iframe:true, width:"90%", height:"90%"});
		});</script>
<div class="centercontent tables">
	<div class="pageheader notab">
		<h1 class="pagetitle"><span style="float:left"><?php echo $heading; ?></span><span style="float:right"><a href="/superadmin/dynamic_form/addedit" class="b_green"><strong>Add New</strong></a>	</span></h1>
		<span class="pagedesc"><?php if( $this->session->flashdata('message')) {?>
		<?php echo $this->session->flashdata('message'); ?><?php } ?></span>		
	</div><!--pageheader-->	
	<div id="contentwrapper" class="contentwrapper">
	<form action="" method="POST" id="searchfm" name="searchfm">
			<table cellpadding="0" cellspacing="0" border="0" class="stdtable stdtablecb">
				<tbody>
					<tr>
						
						<td style="width:14%; vertical-align:top; border-top: 1px solid #ddd;" colspan="6"><input type="text" placeholder="Enter Name" name="title" value="<?php echo $search['title']?>"></td>
						<td style="width:14%;  vertical-align:top; border-top: 1px solid #ddd;"><select name="type" id="type" style="width:70%;">
								<option value="">Select Property Type</option>
								<?php
							foreach($category as $category_record){?>
              <option value="<?php echo $category_record->id; ?>" <?php echo ($category_record->id==$search['type'])?'selected':''; ?>><?php echo $category_record->name; ?></option>
							<?php }?>
							</select></td>
						<td style="width:22%;  vertical-align:top; border-top: 1px solid #ddd;">
							&nbsp;
							<select name="status1" id="status" style="width:70%;">
								<option value="">Select Status</option>
								<option value="1" <?php echo (is_numeric($search['status']) && $search['status'] == '1')?'selected':'';?>>Active</option>
								<option value="0" <?php echo (is_numeric($search['status']) && $search['status'] == '0')?'selected':'';?>>Inactive</option>
							</select>
						</td>
						<td style="width:22%;  vertical-align:top; border-top: 1px solid #ddd;">
							&nbsp;
							<select name="posted_by" id="status" style="width:70%;">
								<option value="">Posted By</option>
								<option value="1" <?php echo (is_numeric($search['posted_by']) && $search['posted_by'] == '1')?'selected':'';?>>Owner</option>
								<option value="0" <?php echo (is_numeric($search['posted_by']) && $search['posted_by'] == '0')?'selected':'';?>>Banker</option>
							</select>
						</td>
						<td style="width:22%;  vertical-align:top; border-top: 1px solid #ddd;">
							&nbsp;
							<select name="product_type" id="status" style="width:70%;">
								<option value="">Product Type</option>
								<option value="1" <?php echo (is_numeric($search['product_type']) && $search['product_type'] == '1')?'selected':'';?>>Auction</option>
								<option value="0" <?php echo (is_numeric($search['product_type']) && $search['product_type'] == '0')?'selected':'';?>>Non-Auction</option>
							</select>
						</td>
						<td rowspan="3" style="width:15%; vertical-align:middle; border-top: 1px solid #ddd;">
							<input type="submit" name="btnSearch" id="btnSearch" class="search_submit" value="Search" style="padding:15px 10px;">
						</td>
					</tr>
				</tbody>
			</table>
		
		<br>
		<?php //search ends ?>
		<input type="hidden" name="controller" id="controller" value="dynamic_form" />
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
					<th class="head1">Type</th>
					<th class="head0">Status</th>
					<th class="head1">Select <input type="checkbox" id="selecctall1"/></th>
					<th class="head1">Added Date</th>
					<th class="head0">Actions</th>
				</tr>
			</thead>
			
			<tbody>
				<?php $i=0;foreach($records as $data){$i++;?>
					<tr class='gradeA'>
						<td><?php echo $data->id; ?></td>
						<td><?php echo $data->name; ?></td>
						<td><?php echo $data->product_type_val; ?></td>
						<td><?php echo ($data->status == 1)?'Active':'Inactive'; ?></td>
						<td><input type="checkbox" class="status12" name="status[]" value="<?php echo $data->id; ?>"></td>
						<td><?php echo GetDateFormat($data->indate); ?></td>
						<td>
							<a href="/superadmin/dynamic_form/addedit/<?php echo $data->id; ?>"><strong>Edit</strong></a> || 
							<a href="/superadmin/product_image/page_popup/<?php echo $data->id; ?>" class="iframe"><strong>Manage Image</strong></a>   
						 || <a href="/superadmin/product_video/page_popup/<?php echo $data->id; ?>" class="iframe"><strong>Manage Video</strong></a>   
						 || <a href="javascript:;" data-id="<?php echo $data->id; ?>" class="deletelink"><strong>Delete</strong></a>
						 || <a href="/superadmin/dynamic_form/preview/<?php echo $data->id; ?>"class="iframe"><strong>Preview</strong></a>
						</td>
					</tr>
				<?php }?>	
				
			</tbody>
		</table>
		<div class="pagination">
			<span style="float:left"><input type="submit" name="submit" onclick="return checkSelection(); return confirm('Are you sure, activate all?');" value="Active all">&nbsp;<input type="submit" name="submit" onclick="return checkSelection(); return confirm('Are you sure, Inactive all?');" value="Deactivate all"></span>
			<span style="float:right"><ul><?php echo $pagination_links ?></ul></span>
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



    
