<script type="text/javascript" src="<?php echo VIEWBASE?>js/plugins/jquery.uniform.min.js"></script>
<script type="text/javascript" src="<?php echo VIEWBASE?>js/plugins/jquery.validate.min.js"></script>
<script type="text/javascript" src="<?php echo VIEWBASE?>js/custom/forms.js"></script>
<script type="text/javascript" src="<?php echo VIEWBASE?>js/plugins/tinymce/jquery.tinymce.js"></script>
<script type="text/javascript" src="<?php echo VIEWBASE; ?>js/plugins/jquery.tagsinput.min.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo VIEWBASE?>css/plugins/jquery.tagsinput.css">
<script type="text/javascript" src="<?php echo VIEWBASE; ?>js/plugins/jquery.colorbox-min.js"></script>
<script>
	jQuery(document).ready(function(){		
		//Examples of how to assign the Colorbox event to elements
		jQuery(".iframe").colorbox({iframe:true, width:"90%", height:"90%"});
	});
</script>
<?php 
if($row){
	$id=$row->id; 
	$category_id=$row->category_id; 
	$title=$row->title; 
	$description=$row->description;
	$excerpt=$row->excerpt;
	
	if($row->author_id != ''){
		$author_id = explode(",", $row->author_id);
	}
	else{
		$author_id = array();
	}
		$gauthor_id =  $row->gauthor_id;
		
	$other = $row->other;
	$tags = $row->tags;
	
	$location_id = $row->location_id;
	
	$image=$row->image; 
	//$slug=$row->slug;
	$slug=explode('-',$row->slug);
	array_pop($slug);
	$slug=implode('-',$slug);
	//remove id from slug 
	
	$priority=$row->priority; 
	$status=$row->status; 
	
	$meta_title=$row->meta_title; 
	$meta_description=$row->meta_description; 
	$meta_keywords=$row->meta_keywords;
	$seo_canonical = $row->seo_canonical;
	
	$created_by = $row->created_by; 
	$date_created = $row->date_created; 
	$date_modified = $row->date_modified;
	$date_published = $row->date_published;
	
}else{	
	$status = 0;
	$date_published = date('Y-m-d');
	$id = 0;
	$slug = '';
}
?> 
<div class="centercontent">
	<div class="pageheader">
		<h1 class="pagetitle"><?php echo $heading; ?></h1>
		<span class="pagedesc"><div style="color:red"><?php echo validation_errors(); ?></div></span>
	</div><!--pageheader-->
    <div id="contentwrapper" class="contentwrapper">
		<div id="validation" class="subcontent">            	
			<form enctype="multipart/form-data" method="post" class="stdform" id="article" name="add_data_view" accept-charset="utf-8" action="/superadmin/article/save">	
				
				<p>
					<label>Category<font color='red'>*</font></label>
					<span class="field">
						<select name="category_id" id="category_id" onchange="if(jQuery(this).val()=='260'){jQuery('#author_p').hide();jQuery('#gauthor_p').show();}">
							<option value="">Select Category</option>
							<?php
								foreach($category as $cat){
									if($parent_id == $cat->id)$selected='selected="selected"';
									else if($category_id==$cat->id)$selected='selected="selected"';
									else $selected='';
							?>
									<option value="<?php echo $cat->id; ?>" <?php echo $selected ?>><?php echo $cat->name; ?></option>
							<?php
								}
							?>
						</select>
					</span>					
				</p>
				
				<p id="sub-category">
					<?php if($parent_id != 0){?>
					<label>Sub Category<font color='red'>*</font></label>
					<span class="field">
						<select name="sub_category_id" id="sub_category_id">
							<option value="">Select Sub Category</option>
							<?php
								foreach($sub_category as $cat){					
									if($category_id == $cat->id)$selected='selected="selected"';
									else $selected='';
									?>
									<option value="<?php echo $cat->id; ?>" <?php echo $selected ?>><?php echo $cat->name; ?></option>
									<?php
								}
							?>
						</select>
					</span>
					<?php }?>
				</p>
				
				<p>
					<label>Title<font color='red'>*</font></label>
					<span class="field">
						<input type="text" name="title" id="title" class="longinput" value="<?php echo $title?>" />
						<label class="error" style="display:none;">Please enter Title</label>
					</span>					
				</p>
				
				<!--<p>
					<label>Slug<font color='red'>*</font></label>
					<span class="field">
						<input type="text" class="longinput" name="slug" id="slug" value="<?php print_r($slug)?>">
						<label class="error" style="display:none;">Please enter Slug</label>
					</span>					
				</p>-->
				
				<span id="hide_photo_category">
				<p>
					<label>Story<font color='red'>*</font></label>
					<span class="field">
						<textarea name="description" class="tinymce"><?php echo $description?></textarea>
						<label class="error" style="display:none;">Please enter Story</label>
					</span>					
				</p>
				
				<p>
					<label>Short Story<font color='red'></font></label>
					<span class="field">
						<textarea name="excerpt" id="excerpt" rows="5" cols="60" class="tinymce" ><?php echo $excerpt?></textarea>
						<label class="error" style="display:none;">Please enter Short Story</label>
					</span>					
				</p>
				
				<p style="display:none">
					<label>Image</label>
						<span class="field">
						<input type="file" name="image">(jpg | png | jpeg | gif )
						<input type="hidden" name="image_old" id="image_old" value="<?php echo $image; ?>">
						<?php if($image){?><span id="image_old_data"><br><br><img src="<?php echo base_url(); ?>public/uploads/article/<?php echo $image;?>" height="80" width="80" />&nbsp;&nbsp;<a href="javascript:void(0)" onclick="jQuery('#image_old').val('');jQuery('#image_old_data').hide()">remove</a></span><?php }?>	
					</span>
				</p>
				
				<p <?php if($category_id=='260' ||$parent_id=='260')echo 'style="display:none"' ?> id="author_p">
					<label>Author</label>
					<span class="field">
						<select multiple="multiple" size="5" name="author_id[]" id="author_id">
							<?php
							foreach($authors as $author){?>
              <option value="<?php echo $author->id; ?>" <?php echo (in_array($author->id,$author_id))?'selected':''; ?>><?php echo $author->name; ?></option>
							<?php }?>
						</select>
					</span>					
				</p>
				<p id="gauthor_p" <?php if($category_id!='260' ||$parent_id!='260')echo 'style="display:none"' ?>>
					<label>Guest Author</label>
					<span class="field">
						<select  name="gauthor_id" id="gauthor_id">
							<?php
							foreach($gauthors as $gauthor){?>
              <option value="<?php echo $gauthor->id; ?>" <?php echo ($gauthor->id==$gauthor_id)?'selected':''; ?>><?php echo $gauthor->name; ?></option>
							<?php }?>
						</select>
					</span>					
				</p>
				<p style="display:none">
					<label>Publication</label>
					<span class="field">
						<select name="publication_id" id="publication_id">
							<option value="">Select Publication</option>
							<?php
							foreach($publications as $publication){?>
              <option value="<?php echo $publication->id; ?>" <?php echo (in_array($publication->id,$publication_id))?'selected':''; ?>><?php echo $publication->name; ?></option>
							<?php }?>
						</select>
					</span>					
				</p>
				
				
				<p>
					<label>Other</label>
					<span class="field">
						<input type="text" name="other" id="other" class="longinput" value="<?php echo $other?>" />
					</span>					
				</p>
				</span>
				<p>
					<label>Tags</label>
					<span class="field">						
						<input name="tags" id="tags" class="longinput" value="<?php echo $tags?>" />
					</span>					
				</p>
				<!--
				<p>
					<label>Location</label>
					<span class="field">
						<select name="location_id" id="location_id">
							<option value="">Select Location</option>
							<?php foreach($locations as $location){?>
              <option value="<?php echo $location->id; ?>" <?php echo ($location->id == $location_id)?'selected':''; ?>><?php echo $location->name; ?></option>
							<?php }?>
						</select>
					</span>					
				</p>
				
				<p>
					<label>Priority</label>
					<span class="field">
						<input type="text" name="priority" id="priority" class="width100 longinput" value="<?php echo $priority?>" />
					</span>					
				</p>
				-->
				<input type="hidden" name="location_id" id="location_id" class="width100 longinput" value="<?php echo $location_id?>">
				<input type="hidden" name="priority" id="priority" class="width100 longinput" value="<?php echo $priority?>" />
				<p>
					<label>Page Title</label>
					<span class="field"><textarea name="meta_title" id="meta_title" ><?php echo $meta_title?></textarea></span>
				</p>
				
				<p>
					<label>Page Description</label>
					<span class="field"><textarea name="meta_description" id="meta_description" ><?php echo $meta_description?></textarea></span>
				</p>
				
				<p>
					<label>Page Keywords</label>
					<span class="field"><textarea name="meta_keywords" id="meta_keywords" ><?php echo $meta_keywords?></textarea></span>
				</p>
				
				<p>
					<label>Page Canonical</label>
					<span class="field"><textarea name="seo_canonical" id="seo_canonical" ><?php echo $seo_canonical?></textarea></span>
				</p>
				
				<p>
					<label>Status/Publish</label>
					<span class="field">
					<select name="status">
						<option value="0" <?php if($status==0)echo 'selected';?>>No</option>
						<option value="1" <?php if($status==1)echo 'selected';?>>Yes</option>
						
					</select>
					</span>
				</p>
				
				<p>
					<label>Date Publish</label>
					<span class="field">
						<input id="date_published" name="date_published" class="width100" type="text" value="<?php echo $date_published?>">
					</span>
				</p>
				
				<p class="stdformbutton">
				<?php if($id){?>
					<a href="/superadmin/article_image/page_popup/<?php echo $id?>" class="iframe" style="  background: none repeat scroll 0 0 #fb9337;
    border: 1px solid #f0882c;
    border-radius: 2px;
    box-shadow: none;
    color: #eee;
    cursor: pointer;
    font-weight: bold;
    margin: 0;
    padding: 7px 10px;
    width: auto;"><strong>Manage Image</strong></a>	
					<?php }?>
					<input type="submit"  name="submit" value="Submit">
					<input type="hidden" name="id" id="id" value="<?php echo $id?>">
					<!--<input type="hidden" name="slug" id="slug" value="<?php echo $slug?>">-->
				</p>
				
			</form>
        </div>
	</div><!--contentwrapper-->
    <br clear="all" />
</div><!-- centercontent -->

<script>
jQuery(document).ready(function(){
	jQuery('#tags').tagsInput();
	jQuery("#article").validate({
		rules: {
			category_id: "required",
			title: "required",
			slug: "required",
			description: "required",
			//excerpt: "required",
			//slug: "required",
			//'author_id[]': "required",
			image: {
				accept: "png|jp?g|gif"
			},
			priority: {
				number: true
			}
		},
		messages: {
			name: "Please enter article title"
		}
	});
	
	jQuery("#date_published" ).datepicker({
		changeMonth: true,
		changeYear: true,
		yearRange: '1910:'
	});
	
	jQuery('#category_id').change(function(){
		cat_id = jQuery(this).val();
		jQuery('#sub-category').load('/superadmin/category/subCatDropdown/'+cat_id);
		if(cat_id=='44'){
		jQuery('#hide_photo_category').hide();
		jQuery('#excerpt').html('default');
		}
		else jQuery('#hide_photo_category').show();
	});
	cat_id = jQuery('#category_id').val();
	if(cat_id=='44'){
		jQuery('#hide_photo_category').hide();
		jQuery('#excerpt').html('default');
		}
	
	jQuery('textarea.tinymce').tinymce({
		// Location of TinyMCE script
		script_url : '<?php echo VIEWBASE?>js/plugins/tinymce/tiny_mce.js',

		// General options
		theme : "advanced",
		skin : "themepixels",
		width: "85%",
		plugins : "autolink,lists,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,advlist",
		inlinepopups_skin: "themepixels",
		// Theme options
		theme_advanced_buttons1 : "bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,outdent,indent,blockquote,|,fontselect,fontsizeselect",
		theme_advanced_buttons2 : "pastetext,pasteword,|,bullist,numlist,|,undo,redo,|,link,unlink,image,help,code,|,preview",
		theme_advanced_buttons3 : "formatselect,|,forecolor,backcolor,removeformat,|,charmap,media,|,fullscreen",
		theme_advanced_toolbar_location : "top",
		theme_advanced_toolbar_align : "left",
		theme_advanced_statusbar_location : "bottom",
		theme_advanced_resizing : true,
		relative_urls : false,

		// Example content CSS (should be your site CSS)
		content_css : "css/plugins/tinymce.css",

		// Drop lists for link/image/media/template dialogs
		template_external_list_url : "lists/template_list.js",
		external_link_list_url : "lists/link_list.js",
		external_image_list_url : "lists/image_list.js",
		media_external_list_url : "lists/media_list.js",

		// Replace values for the template plugin
		template_replace_values : {
			username : "Some User",
			staffid : "991234"
		}
	});

	
	
});	

</script>
