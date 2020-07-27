<script type="text/javascript" src="<?php echo VIEWBASE; ?>js/plugins/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="<?php echo VIEWBASE; ?>js/custom/tables.js"></script>
<script type="text/javascript" src="<?php echo VIEWBASE; ?>js/custom/forms.js"></script>
<section class="container_12">

<div class="centercontent tables">
	<div class="pageheader notab">
			<div class="row">						
					<!--<a href="/superadmin/city/addedit" class="button_grey">Create City</a>-->
				</div>
				<?php if( $this->session->flashdata('message')) {?>
								<span class="success_msg"><img src="<?php echo VIEWBASE; ?>images/icon_checkmark_small.png" class="success_tick">
								<?php echo $this->session->flashdata('message'); ?></span>		
				<?php } ?>
				<div class="box-head">Enquiry List</div>
				<?php /* ?>
		<h1 class="pagetitle"><span style="float:left"><?php echo $heading; ?></span><span style="float:right"><a href="/superadmin/city/addedit" class="b_green"><strong>Add New City</strong></a>	</span></h1>
		<?php */ ?>
	
	</div><!--pageheader-->	
	
	<div id="contentwrapper" class="contentwrapper">
	<form action="" method="POST" id="searchfm" name="searchfm">
			<table cellpadding="0" cellspacing="0" border="0" class="stdtable stdtablecb display">
				<tbody>
					<tr>
						
						<td style="width:14%; vertical-align:top; border-top: 1px solid #ddd;" colspan="6">
                                                    <!--<input type="text" placeholder="Enter City Name" name="title" class="custom_select no_top_mrgn" value="<?php //echo $search['title']?>">-->
                                                    </td>
						<td style="width:14%;  vertical-align:top; border-top: 1px solid #ddd;"></td>
						<td style="width:22%;  vertical-align:top; border-top: 1px solid #ddd;">
							&nbsp;
							<!--<select name="status1" class="custom_select no_top_mrgn" id="status" style="width:70%;">
								<option value="">Choose One</option>
								<option value="1" <?php echo (is_numeric($search['status']) && $search['status'] == '1')?'selected':'';?>>Yes</option>
								<option value="0" <?php echo (is_numeric($search['status']) && $search['status'] == '0')?'selected':'';?>>No</option>
							</select>-->
						</td>
						<td rowspan="3" style="width:15%; vertical-align:middle; border-top: 1px solid #ddd;">
							<!--<input type="submit" name="btnSearch" id="btnSearch" class="search_submit no_top_mrgn button_grey" value="Search">-->
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
										<th class="head0">ID</th>
										<th class="head1">User Name</th>
										<th class="head1">Email Id</th>
										<th class="head0">Phone Number</th>
                                                                                <th class="head0">Message </th>
										<!--<th class="head1"></th>
										<th class="head0">Actions</th>-->
									</tr>
								</thead>
								
								<tbody>
									<?php $i=0;foreach($records as $data){ $i++;
									$totalrows=$this->city_model->checkcityAttributeExist($data->id);
									
									?>
										<tr class='gradeA'>
											<td><?php echo $data->id; ?> </td>
											<td><?php echo $data->first_name; ?></td>
                                                                                        <td><?php echo $data->emailID; ?></td>
											<td><?php echo $data->phoneNo; ?></td>
                                                                                        <td><?php echo $data->message; ?></td> 
                                                                                       
											<!--<td><?php echo ($data->status == 1)?'Active':'Inactive'; ?></td>-->
											<!--<td><input type="checkbox" class="status12" name="status[]" value="<?php echo $data->id; ?>"></td>-->
											<td>
												<!--<a href="/superadmin/city/addedit/<?php echo $data->id; ?>"><strong>Edit</strong></a>-->
											 
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
					
						<!--<div class="pagination">
							<span style="float:left">
								<input type="submit" name="submit" onclick="return checkSelection(); return confirm('Are you sure, activate all?');" value="Active all" class="button_grey">&nbsp;
								<input type="submit" name="submit" onclick="return checkSelection(); return confirm('Are you sure, Inactive all?');" value="Deactivate all" class="button_grey">
							</span>
							<span style="float:right;padding-top:9px;"><?php echo $pagination_links; ?></span>
						</div>-->
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
