<script type="text/javascript" src="<?php echo VIEWBASE; ?>js/plugins/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="<?php echo VIEWBASE; ?>js/custom/tables.js"></script>
<script type="text/javascript" src="<?php echo VIEWBASE; ?>js/plugins/jquery.colorbox-min.js"></script>
<script type="text/javascript" src="<?php echo VIEWBASE; ?>js/custom/forms.js"></script>


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
		function getZone(bank_id){
		//cat_id = jQuery('#zone').val();
		jQuery('#zone').load('/superadmin/bank_zone/ajax_zone/'+bank_id);
		
		}
		function getRegion(zone_id){
		//cat_id = jQuery('#zone').val();
		jQuery('#region').load('/superadmin/bank_region/ajax_region/'+zone_id);
		
		}
		
	
</script>

<section class="container_12">
	<div class="row">						
			
		</div>
		<?php if( $this->session->flashdata('message')) {?>
				<span class="success_msg"><img src="<?php echo VIEWBASE; ?>images/icon_checkmark_small.png" class="success_tick">
				<?php echo $this->session->flashdata('message'); ?></span>		
		<?php } ?>
		<div class="box-head">Event Creation : Log event</div>
	<div class="centercontent tables">
		<div class="pageheader notab">
			<?php /* ?>
			<h1 class="pagetitle"><span style="float:left"><?php echo $heading; ?></span><span style="float:right"><a href="/superadmin/bank_branch/branch_addedit" class="b_green"><strong>Add New branch</strong></a>	</span></h1>
			<?php */ ?>

		</div><!--pageheader-->	
		<div id="contentwrapper" class="contentwrapper">
			<?php //Search start ?>
			<form action="" method="POST" id="searchfm" name="searchfm">
				<table cellpadding="0" cellspacing="0" border="0" class="stdtable stdtablecb display">
					<tbody>
						<tr>
							
							<td width="20%" style="vertical-align:top; border-top: 1px solid #ddd;" ><input type="text" class="custom_select no_top_mrgn" placeholder="Enter Branch Name" name="title"></td>
							
							<td width="20%" style=" vertical-align:top; border-top: 1px solid #ddd;"> 
								<select name="bank" class="custom_select" id="bank" onchange="getZone(jQuery(this).val())" >
								<option value="">Select Bank</option>
								<?php
								foreach($banks as $bank_record){?>
				  <option value="<?php echo $bank_record->id; ?>" <?php echo ($search['bank']==$bank_record->id)?'selected':''; ?>><?php echo $bank_record->name; ?></option>
								<?php }?>
							</select>
							</td>
						
							
							<td width="20%" style="vertical-align:top; border-top: 1px solid #ddd;">
								&nbsp;
								<select name="zone" class="custom_select  "id="zone" style="width:70%;" onchange="getRegion(jQuery(this).val())">
									<option value="">Select Zone</option>
									<?php
								foreach($zones as $zone_record){?>
				  <option value="<?php echo $zone_record->id; ?>" <?php echo ($search['zone']==$zone_record->id)?'selected':''; ?>><?php echo $zone_record->name; ?></option>
								<?php }?>
								</select>
							</td>
							<td width="20%" style="vertical-align:top; border-top: 1px solid #ddd;">
								&nbsp;
								<select class="custom_select" name="region" id="region" style="width:70%;">
									<option value="">Select Region</option>
									<?php
								foreach($regions as $region_record){?>
				  <option value="<?php echo $region_record->id; ?>" <?php echo ($search['region']==$region_record->id)?'selected':''; ?>><?php echo $region_record->name; ?></option>
								<?php }?>
								</select>
							</td>
							<td width="20%" style="vertical-align:top; border-top: 1px solid #ddd;">
								<input type="submit" name="btnSearch" id="btnSearch" class="search_submit  button_grey no_top_mrgn" value="Search">
							</td>
						</tr>
						
					</tbody>
				</table>
			<?php //search ends ?>
			<input type="hidden" name="controller" id="controller" value="bank_branch" />
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
						<th class="head0" style='width: 5%;'>S. No.</th>
						<th class="head1" style='width: 10%;'>Log Id</th>
						<th class="head0" style='width: 15%;'>Activity Name</th>
						<th class="head1" style='width: 10%;'>Event Id</th>
						
						<th class="head0" style='width: 10%;'>Client Address</th>
						<th class="head1" style='width: 20%;'>Organization Name</th>					
						<th class="head1" style='width: 10%;'>Creation Date</th>
					
					</tr>
				</thead>
				
				<tbody>
					<?php $i=0;foreach($records as $data){$i++;?>
						<tr class='gradeA'>
							<td><?php echo $data->id; ?></td>
							<td><?php echo $data->id; ?></td>
							<td>Auction Logged</td>
							<td><?php echo $data->event_log_id; ?></td>
						
							<td><?php echo $data->ip; ?></td>
							<td><?php echo GetTitleById('tbl_bank',$data->bank_id,'name'); ?></td>
							<td><?php echo $data->indate; ?></td>
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
				<span style="float:right; padding-top: 9px;"><ul><?php echo $pagination_links; ?></ul></span>
			</div>
		</form>
		</div><!-- #updates -->
	</div><!--contentwrapper-->
	<br clear="all" />
	</div><!-- centercontent -->
</section>
<script>
jQuery(document).ready(function($) {
	
	jQuery('input[type=checkbox]').each(function() {
		var $this = $(this);
		$this.css({opacity: "1"});
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


    
