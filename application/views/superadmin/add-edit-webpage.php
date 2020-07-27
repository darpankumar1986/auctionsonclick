<script type="text/javascript" src="<?php echo VIEWBASE?>js/plugins/jquery.uniform.min.js"></script>
<script type="text/javascript" src="<?php echo VIEWBASE?>js/plugins/jquery.validate.min.js"></script>
<script type="text/javascript" src="<?php echo VIEWBASE?>js/custom/forms.js"></script>
<script type="text/javascript" src="<?php echo VIEWBASE?>js/plugins/jquery.tagsinput.min.js"></script>
<script type="text/javascript" src="<?php echo VIEWBASE?>js/plugins/tinymce/jquery.tinymce.js"></script>
<?php 
if($records){
	foreach($records as $row){};
	$webpage_id=$row->webpage_id; 
	$title=$row->title; 
	$slug=$row->slug; 
	$description=$row->description; 
	$short_description=$row->short_description; 
	$image_alt_text=$row->image_alt_text; 
	$image=$row->image; 
	$meta_title=$row->meta_title; 
	$meta_description=$row->meta_description; 
	$meta_keywords=$row->meta_keywords; 
	$status=$row->status; 
}else{
	//Add Records
}
//echo '<pre>';print_r($records);
?> 
<div class="centercontent">
	<div class="pageheader">
		<h1 class="pagetitle"><?php echo $heading; ?></h1>
		<span class="pagedesc"><div style="color:red"><?php echo validation_errors(); ?></div></span>
	</div><!--pageheader-->
    <div id="contentwrapper" class="contentwrapper">
		<div id="validation" class="subcontent">            	
			<form enctype="multipart/form-data" method="post" class="stdform" id="staticpage" name="staticpage" accept-charset="utf-8" action="/superadmin/webpage/addedit">	
				<p>
					<label>Title<font color='red'>*</font></label>
					<span class="field">
						<input type="text"  maxlength="200" name="title" id="title" class="longinput" value="<?php echo $title?>" />
					</span>					
				</p>
				<p>
					<label>Slug<font color='red'>*</font></label>
					<span id="spantes" class="field">
					
						<input readonly type="text"  maxlength="300" name="slug" id="slug" class="longinput" value="<?php echo $slug?>" />
					</span>					
				</p>	
				<p>
					<label> Meta Title</label>
					<span class="field"><textarea  maxlength="300" name="meta_title" ><?php echo $meta_title?></textarea></span>
				</p>
				
				<p>
					<label> Meta Description</label>
					<span class="field"><textarea  maxlength="500" name="meta_description" ><?php echo $meta_description?></textarea></span>
				</p>
				
				<p>
					<label> Meta Keywords</label>
					<span class="field"><textarea  maxlength="500" name="meta_keywords" ><?php echo $meta_keywords?></textarea></span>
				</p>
				
				<p>
					<label>Description</label>
					<span class="field editorarea">
						<textarea id="description"  maxlength="5000" name="description" class="tinymce"><?php echo $description?></textarea>
					</span>
				</p>
				<br />
				
				<p class="stdformbutton">					
					<img src="<?php echo base_url(); ?>application/views/images/gif-load.gif" id="loaderimg" style="display:none;left:4%;margin:-30px 0 0 -30px;position: relative; top: 50%;width:50px;z-index: 9999;"/>
					<input type="submit" id="submit" name="addedit" value="<?php echo ($webpage_id)?'Update':'Submit'?>">
					<input type="hidden" name="webpage_id" value="<?php echo $webpage_id?>">
				</p>
				
			</form>
        </div>
	</div><!--contentwrapper-->
    <br clear="all" />
</div><!-- centercontent -->
<script>
	jQuery(document).ready(function(){
		
		
	<?php //if(!$webpage_id){ ?>
		jQuery('#title').change(function(){
			var title = jQuery(this).val();
			title = title.replace(/[^a-z0-9\s]/gi, '');
			title = encodeURI(title);
			validateSlug(title,'tbl_webpage');
		});
		jQuery('#slug').change(function(){
			var title = jQuery(this).val();
			title = title.replace(/[^a-z0-9\s]/gi, '');
			title = encodeURI(title);
			validateSlug(title,'tbl_webpage');
		});
	
		function validateSlug(title,table){
			jQuery.ajax
			({
				type: "POST",
				url: "/superadmin/slug/validateslug/"+title+"/"+table,
				success: function(msg)
				{
					//alert(msg);
					jQuery('#slug').val(msg);
				}
			});
		}
	<?php //} ?>
		
		
		jQuery("#staticpage").validate({
			rules: {
				title:{
					required:true,
					alphanumeric:true
				},
				slug: "required"
			},
		messages: {
			title:{
				required:"Please enter page title"
				//alphanumeric:"Please enter page title"
			} ,
			slug: "Please enter slug"
			
		}
		
		
		});
			jQuery.validator.addMethod("alphanumeric", function(value, element) {
        return this.optional(element) || /^[a-z0-9\\-\s]+$/i.test(value);
    }, "Name must contain only letters, numbers, or dashes.");
	
		
		jQuery('textarea.tinymce').tinymce({
			// Location of TinyMCE script
			script_url : '<?php echo VIEWBASE?>js/plugins/tinymce/tiny_mce.js',

			// General options
			theme : "advanced",
			skin : "themepixels",
			width: "50%",
			plugins : "autolink,lists,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,advlist",
				inlinepopups_skin: "themepixels",
				pagebreak_separator: "<!-- my page break -->",
			
			//  options
				theme_advanced_buttons1 : "bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,outdent,indent,blockquote,formatselect,fontselect,fontsizeselect, pagebreak",
				theme_advanced_buttons2 : "pastetext,pasteword,|,bullist,numlist,|,undo,redo,|,link,unlink,image,help,code,|,preview,|,forecolor,backcolor,removeformat,|,charmap,media,|,fullscreen",
				theme_advanced_buttons3 : "",
				theme_advanced_toolbar_location : "top",
				theme_advanced_toolbar_align : "left",
				theme_advanced_statusbar_location : "bottom",
				theme_advanced_resizing : true,

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
