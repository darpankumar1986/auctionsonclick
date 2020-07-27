<script type="text/javascript" src="<?php echo VIEWBASE; ?>js/plugins/jquery.dataTables.min.js"></script>
<script type="text/javascript" src="<?php echo VIEWBASE; ?>js/custom/tables.js"></script>
<script type="text/javascript" src="<?php echo VIEWBASE; ?>js/custom/forms.js"></script>

<div class="centercontent tables" style="margin-left:0px;">
	<div class="pageheader">
		<h1 class="pagetitle"><?php echo $heading?></h1>
		<ul class="hornav">
			<li class="current"><a href="/superadmin/article_image/page_popup/<?php echo $article_id; ?>">View Images</a></li>
			<li class=""><a href="/superadmin/article_image/add_popup/<?php echo $article_id; ?>">Add Image</a></li>
			<li class=""><a href="/superadmin/article_image/add_multiple_popup/<?php echo $article_id; ?>">Add Multiple Images</a></li>
		</ul>
	</div>	
	
	<!--<div class="pageheader notab">
		<h1 class="pagetitle"><?php echo $heading; ?></h1>
		<span class="pagedesc"><?php if( $this->session->flashdata('message')) {?>
		<?php echo $this->session->flashdata('message'); ?><?php } ?></span>		
	</div><!--pageheader-->	
	<div id="contentwrapper" class="contentwrapper">
		<div class="subcontent">
			<input type="hidden" name="controller" id="controller" value="article_image" />
			<table cellpadding="0" cellspacing="0" border="0" class="stdtable" id="dyntable">
				<colgroup>
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
						<th class="head1" style='width: 10%;'>Preview</th>
						<th class="head0" style='width: 10%;'>Priority</th>
						<th class="head0" style='width: 10%;'>Home page</th>
						<!--<th class="head0" style='width: 10%;'>Carousel</th>
						<th class="head1" style='width: 10%;'>Thumbnail</th>-->
						<th class="head1" style='width: 10%;'>Status</th>
						<th class="head0" style='width: 15%;'>Added Date</th>
						<th class="head1" style='width: 20%;'>Actions</th>
					</tr>
				</thead>
				<tfoot>
					<tr>
						<th class="head0" style='width: 5%;'>ID</th>
						<th class="head1" style='width: 10%;'>Preview</th>
						<th class="head0" style='width: 10%;' >Priority</th>
						<th class="head0" style='width: 10%;'>Home page</th>
						<!--<th class="head0" style='width: 10%;' >Carousel</th>
						<th class="head1" style='width: 10%;' >Thumbnail</th>-->
						<th class="head1" style='width: 10%;'>Status</th>
						<th class="head0" style='width: 15%;'>Added Date</th>
						<th class="head1" style='width: 20%;'>Actions</th>
					</tr>
				</tfoot>
				<tbody>
					<?php $i=0;
					foreach($records as $data){$i++;?>
						<tr class='gradeA'>
							<td><?php echo $i; ?></td>
							<td><img src="<?php echo base_url(); ?>public/uploads/article/gallery/<?php echo $data->image;?>" height="80" width="80" /></td>
							<td><input type="text" name="priority" id="priority" data-id="<?php echo $data->id; ?>" class="priority" value="<?php echo $data->priority; ?>" style="width:30px; text-align:center;" ></td>
							<td><input type="checkbox" data-id="<?php echo $data->id; ?>" class="home_page" name="home_page" id="home_page_<?php echo $i; ?>" value="1" <?php echo ($data->home_page == 1)?'checked':''; ?>></td>
							<!--<td style="display:none"><input type="checkbox" data-id="<?php echo $data->id; ?>" class="carousel" name="carousel" id="carousel_<?php echo $i; ?>" value="1" <?php echo ($data->carousel == 1)?'checked':''; ?>></td>-->
							<!--<td style="display:none"><input type="checkbox" data-id="<?php echo $data->id; ?>" class="thumbnail" name="thumbnail" id="thumbnail_<?php echo $i; ?>" value="1" <?php echo ($data->thumbnail == 1)?'checked':''; ?>></td>-->
							<td><input type="checkbox" data-id="<?php echo $data->id; ?>" class="status" name="status" id="status_<?php echo $i; ?>" value="1" <?php echo ($data->status == 1)?'checked':''; ?>></td>
							<td><?php echo GetDateFormat($data->date_created); ?></td>
							<td>
								<a href="/superadmin/article_image/edit_popup/<?php echo $data->id; ?>"><strong>Edit</strong></a>
								| <a href="javascript:;" data-id="<?php echo $data->id; ?>" class="deletelink"><strong>Delete</strong></a>
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
	jQuery('.hornav a').click(function(){
		
		//this is only applicable when window size below 450px
		if(jQuery(this).parents('.more').length == 0)
			jQuery('.hornav li.more ul').hide();
		
		//remove current menu
		jQuery('.hornav li').each(function(){
			jQuery(this).removeClass('current');
		});
		
		jQuery(this).parent().addClass('current');	// set as current menu
		
		var url = jQuery(this).attr('href');
		if(jQuery(url).length > 0) {
			jQuery('.contentwrapper .subcontent').hide();
			jQuery(url).show();
		} else {
			jQuery.post(url, function(data){
				jQuery('#contentwrapper').html(data);
				jQuery('.stdtable input:checkbox').uniform();	//restyling checkbox
			});
		}
		return false;
	});
</script>	
