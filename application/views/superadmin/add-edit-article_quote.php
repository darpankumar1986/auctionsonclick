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
	$description=$row->description;
	$image=$row->image; 
	$priority=$row->priority; 
	$status=$row->status;
	$created_by=$row->created_by;  
	
	$date_created=$row->date_created; 
	$date_modified=$row->date_modified; 
}else{	
	$status = 1;
}
?> 
<div class="pageheader">
		<h1 class="pagetitle"><?php echo $heading?></h1>
		<ul class="hornav">
			<li><a href="/superadmin/article_quote/page_popup/<?php echo $article_id; ?>">View Quotes</a></li>
			<li class="current"><a href="/superadmin/article_quote/add_popup/<?php echo $article_id; ?>">Add Quote</a></li>
		</ul>
	</div>

<div class="centercontent">
	  <div id="contentwrapper" class="contentwrapper">
		<div id="validation" class="subcontent">            	
			<form enctype="multipart/form-data" method="post" class="stdform" id="article" name="add_data_view" accept-charset="utf-8" action="/superadmin/article_quote/save">	
				
				<p>
					<label>Title</label>
					<span class="field">
						<input type="text" name="title" id="title" class="longinput" value="<?php echo $title?>" />
						<label class="error" style="display:none;">Please enter Title</label>
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
					<label>Image</label>
						<span class="field">
						<input type="file" name="image">(jpg | png | jpeg | gif )
						<input type="hidden" name="image_old" id="image_old" value="<?php echo $image; ?>">
						<?php if($image){?><br><br><img src="<?php echo base_url(); ?>public/uploads/article/quote/<?php echo $image;?>" height="80" width="80" /><?php }?>	
					</span>
				</p>
				
				<p>
					<label>Priority</label>
					<span class="field">
						<input type="text" name="priority" id="priority" class="width100 longinput" value="<?php echo $priority?>" />
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

				<p class="stdformbutton">					
					<input type="submit"  name="submit" value="Submit">
					<input type="hidden" name="id" value="<?php echo $id?>">
					<input type="hidden" name="article_id" value="<?php echo $article_id?>">
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
			title: required,
			image: {
				accept: "png|jp?g|gif"
			},
			priority: {
				number: true
			}
		},
		messages: {
			name: "Please enter title"
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
		theme_advanced_buttons1 : "bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,outdent,indent,blockquote,formatselect|fontselect,fontsizeselect",
		theme_advanced_buttons2 : "pastetext,pasteword,|,bullist,numlist,|,undo,redo,|,link,unlink,image,help,code,|,preview",
		theme_advanced_buttons3 : "fontselect,fontsizeselect,              	|,forecolor,backcolor,removeformat,|,charmap,media,|,fullscreen",
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
