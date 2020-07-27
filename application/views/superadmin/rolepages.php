<script type="text/javascript" src="<?php echo VIEWBASE; ?>js/plugins/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="<?php echo VIEWBASE; ?>js/custom/tables.js"></script>
<script type="text/javascript" src="<?php echo VIEWBASE; ?>js/custom/forms.js"></script>

<section class="container_12">
		<div class="centercontent tables">
			<div class="pageheader notab">
				<div class="row">						
					Role : <?php echo urldecode($this->uri->segment(5));?>
				</div>
				<?php if( $this->session->flashdata('successMsg')) {?>
						<span class="success_msg"><img src="<?php echo VIEWBASE; ?>images/icon_checkmark_small.png" class="success_tick">
						<?php echo $this->session->flashdata('successMsg'); ?></span>		
				<?php } ?>
				<div class="box-head">Assign Role</div>

						
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
			</form>
				<input type="hidden" name="controller" id="controller" value="category" />
				
				
				<div class="box-content no-pad">
					<div class="container-outer">
						<div class="container-inner">
							<form method="post" action="/superadmin/rolepage/saverolepage" >

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
												<th class="head0"><input type="checkbox" id="checkAll" /></th>
												<th class="head1">Name</th>
												<th class="head1">Link</th>
												<th class="head1">Is Show Menu</th>
												<th class="head1">Order</th>
												<th class="head0">Status</th>
												<th class="head1">Added Date</th>
												
											</tr>
										</thead>
										
										<tbody>
											<?php 
											$pageArr = array();
											if($pages != '')
											{
												$pageArr = explode(",",$pages);
											}
											$i=0;
											foreach($records as $data){
												$i++;
												
											?>
												<tr class='gradeA'>
													<td><input type="checkbox" <?php if(in_array($data->role_page_id,$pageArr)){ echo "checked";}?> name="pages[]" class="cb" value="<?php echo $data->role_page_id;?>" /></td>
													<td><?php echo $data->name; ?></td>
													<td><?php echo $data->link; ?></td>
													<td><?php echo $data->is_show_menu; ?></td>
													<td><?php echo $data->order; ?></td>
													<td><?php echo ($data->status) ? 'Active' : 'Inactive'; ?></td>
													<td><?php echo GetDateFormat($data->in_date); ?></td>
													
												</tr>
											<?php }?>	
											
										</tbody>
									</table>
								<div class="row" style="text-align:center;">	
									<input type="hidden" name="role_id" value="<?php echo $this->uri->segment(4);?>" />					
									<input type="hidden" name="role_name" value="<?php echo $this->uri->segment(5);?>" />	
									<input type="submit" name="submit" class="button_grey" value="Submit">
								</div>
								</form>
							</div>
						</div>
			
				
				<div class="pagination">
					<?php /* ?><span style="float:left">
						<input type="submit" name="submit" onclick="return checkSelection(); return confirm('Are you sure, activate all?');" value="Active all" class="button_grey">&nbsp;
						<input type="submit" name="submit" onclick="return checkSelection(); return confirm('Are you sure, Inactive all?');" value="Deactivate all" class="button_grey"></span><?php */ ?>
						<span style="float:right;padding-top:9px;"><?php echo $pagination_links; ?></span>
				</div>
			
			</div><!-- #updates -->
		</div><!--contentwrapper-->
		<br clear="all" />
		</div><!-- centercontent -->
</section>	
				
				
				
<script>

jQuery(document).ready(function() {
jQuery("#checkAll").click(function(){
    jQuery('input:checkbox').not(this).prop('checked', this.checked);
});
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


    
