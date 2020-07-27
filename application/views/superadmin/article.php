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
			jQuery('#searchfm').submit();
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
<div class="centercontent tables">
	<div class="pageheader notab">
		<h1 class="pagetitle"><?php echo $heading; ?></h1>
		<span class="pagedesc"><?php if( $this->session->flashdata('message')) {?>
		<?php echo $this->session->flashdata('message'); ?><?php } ?></span>		
	</div><!--pageheader-->	
	<div id="contentwrapper" class="contentwrapper">
	<?php //Search start ?>
		<form action="" method="POST" id="searchfm" name="searchfm">
			<table cellpadding="0" cellspacing="0" border="0" class="stdtable stdtablecb">
				<tbody>
					<tr>
						
						<td style="width:14%; vertical-align:top; border-top: 1px solid #ddd;" colspan="6"><input type="text" placeholder="Enter Title" name="title"></td>
						
					</tr>
					<tr>
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
							<!--<select name="category_id" id="category_id" style="width:70%;">
								<option value="">Select Sub Category</option>
							</select>-->
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
						
						
					</tr>
				</tbody>
			</table>
		</form>
		<br>
		<?php //search ends ?>
	
	
	
		<input type="hidden" name="controller" id="controller" value="article" />
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
					<th class="head1" style='width: 20%;'>Title</th>
					<th class="head0" style='width: 11%;'>Category</th>
					<!--<th class="head1" style='width: 10%;'>Priority</th>-->
					<th class="head0" style='width: 7%;'>Status</th>
					<th class="head1" style='width: 7%;'>Home page</th>
					<th class="head0" style='width: 7%;'>Carousel</th>
					<th class="head1" style='width: 10%;'>Added Date</th>
					<th class="head0" style='width: 10%;'>ModifiedDate</th>
					<th class="head1" style='width: 20%;'>Actions</th>
				</tr>
			</thead>
			
			<tbody>
				<?php $i=0;foreach($records as $data){$i++;?>
					<tr class='gradeA'>
						<td><?php echo $data->id; ?></td>
						<td><?php echo $data->title; ?></td>
						<td><?php echo getCatSubcatTitle($data->category_id); ?></td>
						<!--<td><?php echo $data->priority; ?></td>-->
						<td><input type="checkbox" data-id="<?php echo $data->id; ?>" class="status" name="status" id="status_<?php echo $i; ?>" value="1" <?php echo ($data->status == 1)?'checked':''; ?>></td>
						
						<td><input type="checkbox" data-id="<?php echo $data->id; ?>" class="home_page" name="home_page" id="home_page_<?php echo $i; ?>" value="1" <?php echo ($data->home_page == 1)?'checked':''; ?>></td>
						
						<td><input type="checkbox" data-id="<?php echo $data->id; ?>" class="carousel" name="carousel" id="carousel_<?php echo $i; ?>" value="1" <?php echo ($data->carousel == 1)?'checked':''; ?>></td>
						<td><?php echo GetDateFormat($data->date_created); ?></td>
						<td><?php echo GetDateFormat($data->date_modified); ?></td>
						<td>
							<a href="/superadmin/article/addedit/<?php echo $data->id; ?>"><strong>Edit</strong></a> <br>
							<a href="javascript:;" data-id="<?php echo $data->id; ?>" class="deletelink"><strong>Delete</strong></a><br>
							<a href="/superadmin/article_image/page_popup/<?php echo $data->id; ?>" class="iframe"><strong>Manage Image</strong></a> <br> 
							<a href="/superadmin/article_quote/page_popup/<?php echo $data->id; ?>" class="iframe"><strong>Manage Quote</strong></a><br>
							<a href="/<?php $cat_d=$this->category_model->GetRecordById( $data->category_id);if($cat_d->parent_id)echo $this->category_model->GetRecordById($cat_d->parent_id)->slug.'/'.$cat_d->slug;else echo $cat_d->slug;?>/<?php echo $data->slug; ?>" target="_blank"><strong>Preview</strong></a>
							
						</td>
					</tr>
				<?php }?>	
			</tbody>
		</table>
		<div class="pagination" style="float:right; margin:20px 0px 20px 0px;">
			<ul>
				<?php echo $pagination_links; ?>
			</ul>
		</div>
	</div><!-- #updates -->
</div><!--contentwrapper-->
<br clear="all" />
</div><!-- centercontent -->



    
