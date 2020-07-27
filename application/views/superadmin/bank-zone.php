<script type="text/javascript" src="<?php echo VIEWBASE; ?>js/plugins/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="<?php echo VIEWBASE; ?>js/custom/tables.js"></script>
<script type="text/javascript" src="<?php echo VIEWBASE; ?>js/plugins/jquery.colorbox-min.js"></script>
<script type="text/javascript" src="<?php echo VIEWBASE; ?>js/custom/forms.js"></script>

<section class="container_12">
<div class="centercontent tables">
	<div class="pageheader notab">
		<div class="row">						
			<a href="/superadmin/bank_zone/zone_addedit" class=" button_grey">Create Zone</a>
		</div>
		<?php if( $this->session->flashdata('message')) {?>
				<span class="success_msg"><img src="<?php echo VIEWBASE; ?>images/icon_checkmark_small.png" class="success_tick">
				<?php echo $this->session->flashdata('message'); ?></span>		
		<?php } ?>
		<div class="box-head">Zone List</div>
		<?php /* ?>
		<h1 class="pagetitle"><span style="float:left"><?php echo $heading; ?></span><span style="float:right"><a href="/superadmin/bank_zone/zone_addedit" class="b_green"><strong>Add New</strong></a>	</span></h1>
		<?php */ ?>	
	</div><!--pageheader-->	
	<div id="contentwrapper" class="contentwrapper">
	<form action="" method="GET" id="searchfm" name="searchfm">
			<table cellpadding="0" cellspacing="0" border="0" class="stdtable stdtablecb display">
				<tbody>
					<tr>
						
						<td style="width:5%; vertical-align:top; border-top: 1px solid #ddd;" colspan="6"><input class="custom_select no_top_mrgn" type="text" placeholder="Search..." name="title" value="<?php echo $search['title']?>"></td>
						<?php /* ?>
						<td style="width:22%;  vertical-align:top; border-top: 1px solid #ddd;">
							&nbsp;
							<select name="status1" class="custom_select no_top_mrgn" id="status" style="width:30%;">
								<option value="">Select Status</option>
								<option value="1" <?php echo (is_numeric($search['status']) && $search['status'] == '1')?'selected':'';?>>Yes</option>
								<option value="0" <?php echo (is_numeric($search['status']) && $search['status'] == '0')?'selected':'';?>>No</option>
							</select>
						</td>
						<?php */ ?>
						<td rowspan="3" style="width:15%; vertical-align:middle; border-top: 1px solid #ddd;">
							<input type="submit" name="btnSearch" id="btnSearch" class="search_submit no_top_mrgn button_grey" value="Search">
						</td>
					</tr>
					
				</tbody>
			</table>
		
		<input type="hidden" name="controller" id="controller" value="bank_zone" />
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
							<th class="head0" style='width: 5%;'>Zone ID</th>
							<th class="head1" style='width: 20%;'>Zone Name</th>
							<th class="head0" style='width: 8%;'>Status</th>
							<th class="head1" style='width: 10%;'>Creation Date</th>
							<th class="head1" style='width: 10%;'>Modification Date</th>
							<th class="head1" style='width: 7%;'>Action</th>
						</tr>
					</thead>
					
					<tbody>
						<?php $i=0;foreach($records as $data){$i++;?>
							<tr class='gradeA'>
								<td><?php echo $data->zone_id; ?></td>
								<td><?php echo $data->zone_name; ?></td>
								<td><?php echo ($data->status == 1)?'Active':'Inactive'; ?></td>
								<td><?php echo GetDateFormat($data->date_created); ?></td>
								<td><?php echo GetDateFormat($data->date_modified); ?></td>
								<td>
									<a href="/superadmin/bank_zone/zone_addedit/<?php echo $data->zone_id; ?>">Edit</a> 									
								</td>
							</tr>
						<?php }?>	
					</tbody>
				</table>
					<div class="row" style="text-align:center;">						
						<a href="<?php echo base_url().'superadmin/category/main'?>" class="button_grey">Back</a> 
					</div>
				</div>
			</div>
			<div class="pagination">
			<span style="float:left">
				<?php /* ?><input type="submit" name="submit" onclick="return checkSelection(); return confirm('Are you sure, activate all?');" value="Active all" class="button_grey">&nbsp;<input type="submit" name="submit" onclick="return checkSelection(); return confirm('Are you sure, Inactive all?');" value="Deactivate all" class="button_grey"><?php */ ?>
			</span>
			<span style="float:right; padding-top: 9px;"><ul><?php echo $pagination_links; ?></ul></span>
		</div>
	</form>
	</div><!-- #updates -->
</div><!--contentwrapper-->
<br clear="all" />
</div><!-- centercontent -->
</section>
