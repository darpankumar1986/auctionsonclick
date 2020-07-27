<script type="text/javascript" src="<?php echo VIEWBASE?>js/plugins/jquery.uniform.min.js"></script>
<script type="text/javascript" src="<?php echo VIEWBASE?>js/plugins/jquery.validate.min.js"></script>
<script type="text/javascript" src="<?php echo VIEWBASE?>js/custom/forms.js"></script>
<script type="text/javascript" src="<?php echo VIEWBASE?>js/plugins/tinymce/jquery.tinymce.js"></script>
<style type="text/css">
.centercontent{ margin-left:30px;}
.stdform label {width:160px;}
</style>
<?php 
if($row){
	$id=$row->id; 
	$article_id=$row->article_id; 
	$title=$row->title; 
	$photo_credit=$row->photo_credit;
	$photo_credit_url=$row->photo_credit_url;
	$description=$row->description;
	$excerpt=$row->excerpt;
	$image=$row->image; 
	$slug=$row->slug; 
	$priority=$row->priority; 
	$status=$row->status;
	$created_by=$row->created_by;  
	
	$home_page=$row->home_page; 
	$carousel=$row->carousel; 
	$thumbnail=$row->type;
	
	$meta_title=$row->meta_title; 
	$meta_description=$row->meta_description; 
	$meta_keywords=$row->meta_keywords; 
	
	$date_created=$row->date_created; 
	$date_modified=$row->date_modified; 
}else{	
	$status = 1;
	$home_page = 0;
	$thumbnail = 'home';
	$carousel = 0;
	$title=$records[0]->title;
}
?> 
<div class="pageheader">
		<h1 class="pagetitle"><?php echo $heading?></h1>
		<ul class="hornav">
			<li><a href="/superadmin/article_image/page_popup/<?php echo $article_id; ?>">View Images</a></li>
			<li class="current"><a href="/superadmin/article_image/add_popup/<?php echo $article_id; ?>">Add Image</a></li>
			<li class=""><a href="/superadmin/article_image/add_multiple_popup/<?php echo $article_id; ?>">Add Multiple Images</a></li>
		</ul>
	</div>

<div class="centercontent">
	  <div id="contentwrapper" class="contentwrapper">
		<div id="validation" class="subcontent">            	
			<form enctype="multipart/form-data" method="post" class="stdform" id="article" name="add_data_view" accept-charset="utf-8" action="/superadmin/article_image/save">	
				
				<?php /*
				<p>
					<label>Category</label>
					<span class="field">
						<select name="category_id">
							<option value="">Select Category</option>
							<?php
								foreach($category as $cat){
									
									if($category_id==$cat->id)$selected='selected="selected"';
									else $selected='';
									
									$parent_space = ($cat->parent_id != 0)?' -- ':'';
									
									
									?>
									<option value="<?php echo $cat->id; ?>" <?php echo $selected ?>><?php echo $parent_space.$cat->name; ?></option>
									<?php
								}
							?>
						</select>
					</span>					
				</p>
				*/
				?>
				
				<p>
					<label>Image</label>
						<span class="field">
						<input type="file" name="image">(jpg | png | jpeg | gif )&nbsp;&nbsp;&nbsp;<b>[Home=(650 x 385), Thumb=(142 x 126), Medium=(470 x 329)]</b>
						<input type="hidden" name="image_old" id="image_old" value="<?php echo $image; ?>">
						<?php if($image){?><br><br><img src="<?php echo base_url(); ?>public/uploads/article/gallery/<?php echo $image;?>" height="80" width="80" /><?php }?>	
					</span>
				</p>
				
				<p>
					<label>Title</label>
					<span class="field">
						<input type="text" name="title" id="title" class="longinput" value="<?php echo $title?>" />
						<label class="error" style="display:none;">Please enter Title</label>
					</span>					
				</p>
				<p>
					<label>Photo Credit</label>
					<span class="field">
						<input type="text" name="photo_credit" id="photo_credit" class="longinput" value="<?php echo $photo_credit?>" />
						<label class="error" style="display:none;">Please enter Photo Credit</label>
					</span>					
				</p>
				<p>
					<label>Photo Credit URL</label>
					<span class="field">
						<input type="text" name="photo_credit_url" id="photo_credit_url" class="longinput" value="<?php echo $photo_credit_url?>" />
						<label class="error" style="display:none;">Please enter Photo Credit URL</label>
					</span>					
				</p>
				<p>
					<label>Story</label>
					<span class="field">
						<textarea name="description" class="tinymce"><?php echo $description?></textarea>
						<label class="error" style="display:none;">Please enter Story</label>
					</span>					
				</p>
				<p>
					<label>Priority</label>
					<span class="field">
						<input type="text" name="priority" id="priority" class="width100 longinput" value="<?php echo $priority?>" />
					</span>					
				</p>
				
				<!--<p>
					<label>Short Story</label>
					<span class="field">
						<textarea name="excerpt" rows="5" cols="60" ><?php echo $excerpt?></textarea>
						<label class="error" style="display:none;">Please enter Short Story</label>
					</span>					
				</p>
				
				
				
				<p>
					<label>Status</label>
					<span class="field">
					<select name="status">
						<option value="1" <?php if($status==1)echo 'selected';?>>Active</option>
						<option value="0" <?php if($status==0)echo 'selected';?>>Inactive</option>
					</select>
					</span>
				</p>

				
				
				<p>
					<label>Show Image In Carousel</label>
					<span class="field">
					<input type="radio" name="carousel" id="carousel_yes" <?php echo ($carousel==1)?'checked':'';?> value="1">&nbsp;Yes
					<input type="radio" name="carousel" id="carousel_no" <?php echo ($carousel==0)?'checked':'';?> value="0">&nbsp;No
					</span>
				</p>
				
				<p>
					<label>Is Thumbnail Image</label>
					<span class="field">
					<input type="radio" name="thumbnail" id="thumbnail_yes" <?php echo ($thumbnail==1)?'checked':'';?> value="1">&nbsp;Yes
					<input type="radio" name="thumbnail" id="thumbnail_no" <?php echo ($thumbnail==0)?'checked':'';?> value="0">&nbsp;No
					</span>
				</p>-->
				<p>
					<label>Image Type</label>
					<span class="field">
					<input type="radio" name="thumbnail" id="thumbnail_yes" <?php echo ($thumbnail=='home')?'checked':'';?> value="home">&nbsp;Home
					<input type="radio" name="thumbnail" id="thumbnail_no" <?php echo ($thumbnail=='medium')?'checked':'';?> value="medium">&nbsp;Medium
					<input type="radio" name="thumbnail" id="thumbnail_no" <?php echo ($thumbnail=='thumbnail')?'checked':'';?> value="thumbnail">&nbsp;Thumbnail
					</span>
				</p>
				<p>
					<label>Show on home page</label>
					<span class="field">
					<input type="radio" name="home_page" id="home_page_yes" <?php echo ($home_page==1)?'checked':'';?> value="1">&nbsp;Yes
					<input type="radio" name="home_page" id="home_page_no" <?php echo ($home_page==0)?'checked':'';?> value="0">&nbsp;No
					</span>
				</p>
				
				<p class="stdformbutton">					
					<input type="submit"  name="submit" value="Submit">
					<input type="hidden" name="id" value="<?php echo $id?>">
					<input type="hidden" name="article_id" value="<?php echo $article_id?>">
					<input type="hidden" name="meta_title" value="<?php echo $meta_title?>">
					<input type="hidden" name="meta_description" value="<?php echo $meta_description?>">
					<input type="hidden" name="meta_keywords" value="<?php echo $meta_keywords?>">
				</p>
				
			</form>
        </div>
	</div><!--contentwrapper-->
    <br clear="all" />
</div><!-- centercontent -->

<script>
jQuery(document).ready(function(){
	jQuery("#article").validate({
		rules: {
			image: {
				required: function() {
					return (jQuery('#image_old').val()=='');
				},
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
	
	jQuery('textarea.tinymce').tinymce({
		// Location of TinyMCE script
		script_url : '<?php echo VIEWBASE?>js/plugins/tinymce/tiny_mce.js',

		// General options
		theme : "advanced",
		skin : "themepixels",
		width: "400px",
		plugins : "autolink,lists,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,advlist",
		inlinepopups_skin: "themepixels",
		// Theme options
		theme_advanced_buttons1 : "bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,outdent,indent,blockquote,formatselect,|,fontselect,fontsizeselect",
		theme_advanced_buttons2 : "pastetext,pasteword,|,bullist,numlist,|,undo,redo,|,link,unlink,image,help,code,|,preview",
		theme_advanced_buttons3 : "forecolor,backcolor,removeformat,|,charmap,media,|,fullscreen",
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
  jQuery("form").submit(function(){
     var OrgFile = jQuery(this).find("[type=file]"),
         FileName = OrgFile.val(),
         FileExtension = FileName.split('.').pop().toLowerCase();
         if(FileName.indexOf(".")==-1 || FileExtension != "jpg" && FileExtension != "jpeg" && FileExtension != "png" && FileExtension != "gif" ){ // Curstom File Extension
         // alert("This isn't a Photo !");
         //return false;
         }else
         if((OrgFile[0].files[0].size/1024) > (100)){ // Max Photo Size 1MB
          alert("Image is too big,max allow size 100 KB!");
          return false;
         }else{
          //alert("every thing Fine :)");
          return true;
         }
   });
	
});	
</script>
