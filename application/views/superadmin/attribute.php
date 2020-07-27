<script type="text/javascript" src="<?php echo VIEWBASE; ?>js/plugins/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="<?php echo VIEWBASE; ?>js/custom/tables.js"></script>
<script type="text/javascript" src="<?php echo VIEWBASE; ?>js/plugins/jquery.colorbox-min.js"></script>
<script type="text/javascript" src="<?php echo VIEWBASE; ?>js/custom/forms.js"></script>

<div class="centercontent tables">
	<div class="pageheader notab">
		<h1 class="pagetitle"><span style="float:left"><?php echo $heading; ?></span><span style="float:right"><a href="/superadmin/attribute/addedit"  class="b_green"><strong>Add New Attribute</strong></a>	</span></h1>
		<span class="pagedesc"><?php if( $this->session->flashdata('message')) {?>
		<?php echo $this->session->flashdata('message'); ?><?php } ?></span>		
	</div><!--pageheader-->	
	<div id="contentwrapper" class="contentwrapper">
	<?php //Search start ?>
		<form action="" method="POST" id="searchfm" name="searchfm">
			<table cellpadding="0" cellspacing="0" border="0" class="stdtable stdtablecb">
				<tbody>
					<tr>
						
						<td style="width:14%; vertical-align:top; border-top: 1px solid #ddd;" colspan="6"><input type="text" placeholder="Enter Name" name="title"></td>
						<td style="width:14%;  vertical-align:top; border-top: 1px solid #ddd;">Select Type</td>
						<td style="width:22%;  vertical-align:top; border-top: 1px solid #ddd;">
							&nbsp;
							<select name="group" id="group" style="width:70%;">
								<option value="">Choose One</option>
															<?php
							foreach($groups as $group_record){?>
              <option value="<?php echo $group_record->id; ?>" <?php echo ($group_record->id==$search['group'])?'selected':''; ?>><?php echo $group_record->name; ?></option>
							<?php }?>
								
							</select>
						</td>
						
						<td rowspan="3" style="width:15%; vertical-align:middle; border-top: 1px solid #ddd;">
							<input type="submit" name="btnSearch" id="btnSearch" class="search_submit" value="Search" style="padding:15px 10px;">
						</td>
					</tr>
					<!--<tr>
						<td style="width:14%; vertical-align:top; border-top: 1px solid #ddd;">Select Category:</td>
						<td style="width:22%; vertical-align:top; border-top: 1px solid #ddd;">
							&nbsp;
							<select name="category_id" id="category_id" style="width:70%;">
								<option value="">Choose One</option>
							<?php
							foreach($category as $cat){							
								$selected = ($search['category_id'] == $cat->id)?'selected="selected"':'';
								?>
								<option value="<?php echo $cat->id; ?>" <?php echo $selected ?>><?php echo $cat->name; ?></option>
							<?php
							}
							?>
							</select>
						</td>
						<td style="width:14%; vertical-align:top; border-top: 1px solid #ddd;">Month:</td>
						<td style="width:18%; vertical-align:top; border-top: 1px solid #ddd;">
							&nbsp;
							<select name="month" id="month" style="width:70%;">
								<option value="">Choose One</option>
								<option value="1" <?php echo ($search['month'] == '1')?'selected':'';?>>Jan</option>
								<option value="2" <?php echo ($search['month'] == '2')?'selected':'';?>>Feb</option>
								<option value="3" <?php echo ($search['month'] == '3')?'selected':'';?>>Mar</option>
								<option value="4" <?php echo ($search['month'] == '4')?'selected':'';?>>Apr</option>
								<option value="5" <?php echo ($search['month'] == '5')?'selected':'';?>>May</option>
								<option value="6" <?php echo ($search['month'] == '6')?'selected':'';?>>Jun</option>
								<option value="7" <?php echo ($search['month'] == '7')?'selected':'';?>>Jul</option>
								<option value="8" <?php echo ($search['month'] == '8')?'selected':'';?>>Aug</option>
								<option value="9" <?php echo ($search['month'] == '9')?'selected':'';?>>Sep</option>
								<option value="10" <?php echo ($search['month'] == '10')?'selected':'';?>>Oct</option>
								<option value="11" <?php echo ($search['month'] == '11')?'selected':'';?>>Nov</option>
								<option value="12" <?php echo ($search['month'] == '12')?'selected':'';?>>Dec</option>
							</select>
						</td>
						<td style="width:14%;  vertical-align:top; border-top: 1px solid #ddd;">Is Published:</td>
						<td style="width:22%;  vertical-align:top; border-top: 1px solid #ddd;">
							&nbsp;
							<select name="status" id="status" style="width:70%;">
								<option value="">Choose One</option>
								<option value="1" <?php echo (is_numeric($search['status']) && $search['status'] == '1')?'selected':'';?>>Yes</option>
								<option value="0" <?php echo (is_numeric($search['status']) && $search['status'] == '0')?'selected':'';?>>No</option>
							</select>
						</td>
						<td rowspan="3" style="width:15%; vertical-align:middle; border-top: 1px solid #ddd;">
							<input type="submit" name="btnSearch" id="btnSearch" class="search_submit" value="Search" style="padding:15px 10px;">
						</td>
					</tr>
					<tr>
						<td style="vertical-align:top;">Sub Category</td>
						<td style="vertical-align:top;" id="sub-category">
						&nbsp;<?php echo $search['sub_category_id'];if($search['sub_category_id'])echo "<script> getSubcategory($search[sub_category_id]);</script>"?>
							
						</td>
						<td style=" vertical-align:top;">Show In Home Page:</td>
						<td style=" vertical-align:top;">
							&nbsp;
							<select name="home_page" id="home_page" style="width:70%;">
								<option value="">Choose One</option>
								<option value="1" <?php echo (is_numeric($search['home_page']) && $search['home_page'] == '1')?'selected':'';?>>Yes</option>
								<option value="0" <?php echo (is_numeric($search['home_page']) && $search['home_page'] == '0')?'selected':'';?>>No</option>
							</select>
						</td>
						<td style=" vertical-align:top;">Show In Carousel:</td>
						<td style=" vertical-align:top;">
							&nbsp;
							<select name="carousel" id="carousel" style="width:70%;">
								<option value="">Choose One</option>
								<option value="1" <?php echo (is_numeric($search['carousel']) && $search['carousel'] == '1')?'selected':'';?>>Yes</option>
								<option value="0" <?php echo (is_numeric($search['carousel']) && $search['carousel'] == '0')?'selected':'';?>>No</option>
							</select>
						</td>
						
						
					</tr>-->
				</tbody>
			</table>
		
		<br>
		<?php //search ends ?>
	
	
	
		<input type="hidden" name="controller" id="controller" value="attribute" />
		<table cellpadding="0" cellspacing="0" border="0" class="stdtable">
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
				<col class="con1" />
			</colgroup>
			<thead>
				<tr>
					<th class="head0" style='width: 5%;'>ID</th>
					<th class="head1" style='width: 20%;'>Name</th>
					<th class="head1" style='width: 20%;'>Group Name</th>
					<th class="head0">Status</th>
					<th class="head1"><input type="checkbox" id="selecctall1"/> Select</th>					
					<th class="head1" style='width: 10%;'>Added Date</th>
					<th class="head1" style='width: 20%;'>Actions</th>
				</tr>
			</thead>
			
			<tbody>
				<?php $i=0;foreach($records as $data){$i++;?>
					<tr class='gradeA'>
						<td><?php echo $data->id; ?></td>
						<td><?php echo $data->name; ?></td>
						<td><?php echo GetTitleById('tbl_attribute_group',$data->group_id,'name'); ?></td>
						<td><?php echo ($data->status == 1)?'Active':'Inactive'; ?></td>
						<td><input type="checkbox" class="status12" name="status[]" value="<?php echo $data->id; ?>"></td>
						
						
						<td><?php echo GetDateFormat($data->indate); ?></td>
						
						<td>
							<a href="/superadmin/attribute/addedit/<?php echo $data->id; ?>"><strong>Edit</strong></a> 
						<!--	<br>
							<a href="javascript:;" data-id="<?php echo $data->id; ?>" class="deletelink"><strong>Delete</strong></a>-->
							
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



<script>
	jQuery(document).ready(function(){		
		//Examples of how to assign the Colorbox event to elements
		jQuery(".iframe").colorbox({iframe:true, width:"90%", height:"90%"});
		

		jQuery(".pagination ul li a").click(function() {
			frm = jQuery('#searchfm');
			frm.attr("action", jQuery(this).attr("href"));
			jQuery(this).attr("href", "javascript:void(0)");
			//jQuery('#searchfm').submit();
			jQuery('#btnSearch').click();
		});
		
		jQuery('#category_id').change(function(){
		cat_id = jQuery(this).val();
		jQuery('#sub-category').load('/superadmin/category/subCatDropdown/'+cat_id+'/list_page');
		/*if(cat_id=='44'){
		jQuery('#hide_photo_category').hide();
		jQuery('#excerpt').html('default');
		}
		else jQuery('#hide_photo_category').show();*/
		});
		
		
	});
	function getSubcategory(sub_category_id){
		cat_id = jQuery('#category_id').val();
		jQuery('#sub-category').load('/superadmin/category/subCatDropdown/'+cat_id+'/list_page/'+sub_category_id);
		/*if(cat_id=='44'){
		jQuery('#hide_photo_category').hide();
		jQuery('#excerpt').html('default');
		}
		else jQuery('#hide_photo_category').show();*/
		}
	
</script>
    
