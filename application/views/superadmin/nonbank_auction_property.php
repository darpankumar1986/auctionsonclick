<script type="text/javascript" src="<?php echo VIEWBASE; ?>js/plugins/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="<?php echo VIEWBASE; ?>js/custom/tables.js"></script>
<script type="text/javascript" src="<?php echo VIEWBASE; ?>js/custom/forms.js"></script>
<script type="text/javascript" src="<?php echo VIEWBASE; ?>js/plugins/jquery.colorbox-min.js"></script>
<script>
	jQuery(document).ready(function(){		
		//Examples of how to assign the Colorbox event to elements
		jQuery(".iframe").colorbox({iframe:true, width:"90%", height:"90%"});
		});</script>
<div class="centercontent tables">
	<div class="pageheader notab">
		<h1 class="pagetitle"><span style="float:left"><?php echo $heading; ?></span></h1>
		<span class="pagedesc"><?php if( $this->session->flashdata('message')) {?>
		<?php echo $this->session->flashdata('message'); ?><?php } ?></span>		
	</div><!--pageheader-->	
	<div id="contentwrapper" class="contentwrapper">
	<form action="" method="POST" id="searchfm" name="searchfm">
			<table cellpadding="0" cellspacing="0" border="0" class="stdtable stdtablecb">
				<tbody>
					<tr>
						
						<td style="width:14%; vertical-align:top; border-top: 1px solid #ddd;" colspan="6"><input type="text" placeholder="Enter title Name, Scheme Code" name="title" value="<?php echo $search['title']?>"></td>
						<td style="width:14%;  vertical-align:top; border-top: 1px solid #ddd;">Is Active:</td>
						<td style="width:22%;  vertical-align:top; border-top: 1px solid #ddd;">
							&nbsp;
							<select name="status1" id="status" style="width:70%;">
								<option value="">Choose One</option>
								<option value="1" <?php echo (is_numeric($search['status']) && $search['status'] == '1')?'selected':'';?>>Yes</option>
								<option value="0" <?php echo (is_numeric($search['status']) && $search['status'] == '0')?'selected':'';?>>No</option>
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
	
		<input type="hidden" name="controller" id="controller" value="category" />
		<table cellpadding="0" cellspacing="0" border="0" class="stdtable">
			<colgroup>
				<col class="con0" />
				<col class="con1" />
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
					<th width="5%" class="head0">ID</th>
					<th width="20%" class="head1">Property title</th>
					<th width="10%" class="head1">AuctionID</th>
					<th width="10%" class="head1">Auction Ref.</th>
					<th width="5%" class="head0">Status</th>
					<th width="5%" class="head1"><input type="checkbox" id="selecctall1"/> Select</th>
					<th width="10%" class="head1">Added Date</th>
					<th width="10%" class="head1">Update Date</th>
					<th width="18%" class="head1">Actions</th>
				</tr>
			</thead>
			
			<tbody>
				<?php $i=0;foreach($records as $data){$i++;?>
					<tr class='gradeA'>
						<td><?php echo $i; ?></td>
						<td><?php echo $data->name; ?></td>
						<td><?php echo $data->auctionID; ?></td>
						<td><?php echo GetTitleByField("tbl_auction",'productID='.$data->id,'reference_no'); ?></td>
						<!--<td><?php echo $data->priority; ?></td>-->
						<td><?php echo ($data->status == 1)?'Active':'Inactive'; ?></td>
						<td><input type="checkbox" class="status12" name="status[]" value="<?php echo $data->id; ?>"></td>
						<td><?php echo ($data->indate); ?></td>
						<td><?php echo ($data->updated_date); ?></td>
						<td>
						<a href="/superadmin/dynamic_form/addedit/<?php echo $data->id; ?>"><strong>Edit</strong></a> ||
							<a href="/superadmin/product_image/page_popup/<?php echo $data->id; ?>" class="iframe"><strong>Manage Image</strong></a>   
						 || <a href="/superadmin/product_video/page_popup/<?php echo $data->id; ?>" class="iframe"><strong>Manage Video</strong></a> ||
						<a target="_blank" href="/property/admindetail/<?php echo $data->id; ?>"><strong>View</strong></a>
						 <!--|| <a href="javascript:;" data-id="" class="deletelink"><strong>Delete</strong></a>-->
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


    
