<script type="text/javascript" src="<?php echo VIEWBASE; ?>js/plugins/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="<?php echo VIEWBASE; ?>js/custom/tables.js"></script>
<script type="text/javascript" src="<?php echo VIEWBASE; ?>js/plugins/jquery.colorbox-min.js"></script>
<script type="text/javascript" src="<?php echo VIEWBASE; ?>js/custom/forms.js"></script>


<script>
	jQuery(document).ready(function(){		
		//Examples of how to assign the Colorbox event to elements
		jQuery(".iframe").colorbox({iframe:true, width:"90%", height:"90%"});
		

		jQuery('#category_id').change(function(){
		cat_id = jQuery(this).val();
		jQuery('#sub-category').load('/superadmin/category/subCatDropdown/'+cat_id+'/list_page');
		
		});
		
		
	});
	function getSubcategory(sub_category_id){
		cat_id = jQuery('#category_id').val();
		jQuery('#sub-category').load('/superadmin/category/subCatDropdown/'+cat_id+'/list_page/'+sub_category_id);
		}
	
</script>
<section class="container_12">
	
	<div class="row">						
			<a href="/superadmin/bank_lho/lho_addedit" class="button_grey">Add New LHO</a>
		</div>
	<div class="box-head">LHO List</div>	
<div class="centercontent tables">
	<div class="pageheader notab">
	
	

		<?php if( $this->session->flashdata('message')) {?>
				<span class="success_msg"><img src="<?php echo VIEWBASE; ?>images/icon_checkmark_small.png" class="success_tick">
				<?php echo $this->session->flashdata('message'); ?></span>		
			<?php } ?>		
	</div><!--pageheader-->	
	<div id="contentwrapper" class="contentwrapper">
	<form action="" method="GET" id="searchfm" name="searchfm">
			<table cellpadding="0" cellspacing="0" border="0" class="stdtable stdtablecb display">
				<tbody>
					<tr>
						
						<td style="width:5%; vertical-align:top; border-top: 1px solid #ddd;" colspan="6">Search: <input class="custom_select no_top_mrgn" type="text" placeholder="Search" name="title" value="<?php echo $search['title']?>"></td>
						
		
						
						<?php /* ?>
						<td style="width:10%;  vertical-align:top; border-top: 1px solid #ddd;">Is Active:</td>
						<td style="width:22%;  vertical-align:top; border-top: 1px solid #ddd;">
							&nbsp;
							<select name="status1" class="custom_select" id="status" style="width:70%;">
								<option value="">Choose One</option>
								<option value="1" <?php echo (is_numeric($search['status']) && $search['status'] == '1')?'selected':'';?>>Yes</option>
								<option value="0" <?php echo (is_numeric($search['status']) && $search['status'] == '0')?'selected':'';?>>No</option>
							</select>
						</td>
						<?php */ ?>
						<td rowspan="3" style="width:15%; vertical-align:middle; border-top: 1px solid #ddd;">
							<input type="submit" name="btnSearch" id="btnSearch" class="search_submit no_top_mrgn button_grey" value="Search" >
						
						</td>
					</tr>
					
				</tbody>
			</table>
		
		<input type="hidden" name="controller" id="controller" value="bank_lho" />
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
								<col class="con1" />
							</colgroup>
							<thead>
								<tr>
									<th class="head0" style='width: 5%;'>ID</th>
									<th class="head1" style='width: 30%;'>Name</th>
									<th class="head1" style='width: 30%;'>Bank</th>
									<th class="head0">Status</th>
									<th class="head1" style='width: 5%;'><input type="checkbox" id="selecctall1"/> Select</th>
									<th class="head1" style='width: 15%;'>Added Date</th>
									<th class="head1" style='width: 8%;'>Actions</th>
								</tr>
							</thead>
							
							<tbody>
								<?php $i=0;foreach($records as $data){$i++;?>
									<tr class='gradeA'>
										<td><?php echo $data->id; ?></td>
										<td><?php echo $data->name; ?></td>
										<td><?php echo GetTitleById('tbl_bank',$data->bank_id,'name'); ?></td>
										<td><?php echo ($data->status == 1)?'Active':'Inactive'; ?></td>
										<td><input type="checkbox" class="status12" name="status[]" value="<?php echo $data->id; ?>"></td>
										<td><?php echo GetDateFormat($data->indate); ?></td>
										
										<td>
											<a href="/superadmin/bank_lho/lho_addedit/<?php echo $data->id; ?>">Edit</a> <br>
											<!--<a href="javascript:;" data-id="<?php echo $data->id; ?>" class="deletelink"><strong>Delete</strong></a>-->
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
			<span style="float:right;padding-top: 9px;"><ul><?php echo $pagination_links; ?></ul></span>
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


    
