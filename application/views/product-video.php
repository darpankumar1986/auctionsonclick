<script type="text/javascript" src="<?php echo VIEWBASE; ?>js/plugins/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="<?php echo VIEWBASE; ?>js/custom/tables.js"></script>


<div class="centercontent tables" style="margin-left:0px;">
	<div class="pageheader">
		<h1 class="pagetitle"><?php echo $heading?></h1>
		<ul class="hornav">
			<li class="current"><a href="/product_video/page_popup/<?php echo $product_id; ?>">View Videos</a></li>
			<li ><a href="/product_video/add_popup/<?php echo $product_id; ?>">Add Video</a></li>
			<!--<li class=""><a href="/admin/product_video/add_multiple_popup/<?php echo $product_id; ?>">Add Multiple Videos</a></li>-->
		</ul>
	</div>	
	
	<!--<div class="pageheader notab">
		<h1 class="pagetitle"><?php echo $heading; ?></h1>
		<span class="pagedesc"><?php if( $this->session->flashdata('message')) {?>
		<?php echo $this->session->flashdata('message'); ?><?php } ?></span>		
	</div><!--pageheader-->	
	<div id="contentwrapper" class="contentwrapper">
		<div class="subcontent">
			<input type="hidden" name="controller" id="controller" value="product_video" />
			<table cellpadding="0" cellspacing="0" border="0" class="stdtable" id="dyntable">
				<colgroup>
					<col class="con0" />
					<col class="con1" />
					<col class="con0" />
					<col class="con0" />
					<col class="con1" />
					<col class="con0" />
					<col class="con1" />
					
				</colgroup>
				<thead>
					<tr>
						<th class="head0" style='width: 5%;'>ID</th>
						<th class="head1" style='width: 10%;'>Preview</th>
						<th class="head0" style='width: 10%;'>Priority</th>
						<th class="head1" style='width: 10%;'>Update Status</th>
						<th class="head1" style='width: 10%;'>Status</th>
						<th class="head0" style='width: 15%;'>Added Date</th>
						<th class="head1" style='width: 20%;'>Actions</th>
					</tr>
				</thead>
	
				<tbody>
					<?php $i=0;
					foreach($records as $data){$i++;
					
					?>
					<?php
						
							if($data->status == 1){
								$stVal=0;
								$status_name="Active";
							}else{
								$stVal=1;
								$status_name="Inactive";
							}
							
							?>
							
							
						<tr class='gradeA'>
							<td><?php echo $i; ?></td>
							<td>
							<?php if($data->type=='file'){?>
							<video height="80" width="80" controls >
							  <source src="<?php echo base_url(); ?>public/uploads/images/<?php echo $data->name?>" type="<?php echo get_mime_by_extension($data->name)?>">
							</video>
							<?php }else echo $data->name?>
							</td>
							<td><input type="text" name="priority" id="priority" data-id="<?php echo $data->id; ?>" class="priority" value="<?php echo $data->priority; ?>" style="width:30px; text-align:center;" ></td>
							
							<td><input onclick="updatestatus('video',<?php echo $data->id; ?>,<?php echo $stVal;?>)" type="checkbox" data-id="<?php echo $data->id; ?>" class="status" name="status" id="status_<?php echo $i; ?>" value="1" <?php echo ($data->status == 1)?'checked':''; ?>></td>
							<td><?php echo ($status_name); ?></td>
							<td><?php echo ($data->indate); ?></td>
							<td>
								<a href="/product_video/edit_popup/<?php echo $data->id; ?>"><strong>Edit</strong></a>
								| <a href="javascript:;" onclick="deleteImage('video',<?php echo $data->id; ?>,<?php echo $stVal;?>)"><strong>Delete</strong></a>
							</td>
						</tr>
					<?php }?>	
				</tbody>
			</table>
		</div>
	</div><!-- #updates -->
</div><!--contentwrapper-->
<br clear="all" />
</div><!-- centercontent -->
<script>

function updatestatus(type,imgID,stval){
	 jQuery.ajax({
              url:  "<?php echo base_url();?>product_video/updateimageVideoStatus",
              type: "post",
              data: "type="+type+"&id="+imgID+"&stval="+stval,
              success: function(results){
				  alert(results);
				  location.reload();
				 // jQuery("#error_"+imgID).html(results);
			  }
            });
	
}
function deleteImage(type,imgID,stval){
	if(confirm('Are you sure want to delete this record?')){
	 jQuery.ajax({
              url:  "<?php echo base_url();?>product_video/DeleteimageVideoStatus",
              type: "post",
              data: "type="+type+"&id="+imgID+"&stval="+stval,
              success: function(results){
				  alert(results);
				  location.reload();
				  //jQuery("#error_"+imgID).html(results);
			  }
            });
	}
}

</script>