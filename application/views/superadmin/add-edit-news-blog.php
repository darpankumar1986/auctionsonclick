<script type="text/javascript" src="<?php echo VIEWBASE?>js/plugins/jquery.uniform.min.js"></script>
<script type="text/javascript" src="<?php echo VIEWBASE?>js/plugins/jquery.validate.min.js"></script>
<script type="text/javascript" src="<?php echo VIEWBASE?>js/custom/forms.js"></script>
<script type="text/javascript" src="<?php echo VIEWBASE?>js/plugins/jquery.tagsinput.min.js"></script>
<script type="text/javascript" src="<?php echo VIEWBASE?>js/plugins/tinymce/jquery.tinymce.js"></script>
<?php 
if($records){
	foreach($records as $row){};
}
?> 
<section class="body_main1">
	<div class="row">						
			<a href="<?php echo base_url().'superadmin/news'?>" class="button_grey"> Homepage Breaking News List</a>
		</div>
		<div class="box-head"><?php echo $heading; ?></div>
		<div class="centercontent">
		<div class="pageheader">
			<span class="pagedesc"><div style="color:red"><?php echo validation_errors(); ?>
			<?php if( $this->session->flashdata('message')) {?>
			<?php echo $this->session->flashdata('message'); ?><?php } ?>
			
			</div></span>
		</div><!--pageheader-->
    <div id="contentwrapper" class="contentwrapper box-content2">

        <div id="validation" class="subcontent">    
			<?php
			if($type=='event'){
				$act='addedit';
			}else{
				$act='blogaddedit';
			}
			?>
            <form enctype="multipart/form-data" method="post" class="stdform" id="staticpage" name="staticpage" accept-charset="utf-8" action="/superadmin/news/<?php echo $act; ?>">	
                <div class="row">
                    <div class="lft_heading">Content <span class="red"> *</span></div>
                    <div class="rgt_detail">
                        <textarea maxlength="" rows="10"  width="500px" id="title" name="title"><?php echo $row->title; ?></textarea>
						<label class="error" style="display:none;">Please enter Title</label>
                    </div>					
                </div>

				<input type="hidden" name="category" id="category" value="<?php echo $type;?>">
                
				<div class="row">
					<div class="lft_heading">Status <span class="red"> *</span></div>
					<div class="rgt_detail">
					<select name="status">
                                          <option value="1" <?php if($row->status==1)echo 'selected';?>>Active</option>
						<option value="0" <?php if($row->status==0)echo 'selected';?>>Inactive</option>
					</select>
					</div>
				</div>
				<hr>
                <div class="stdformbutton row" style="text-align:center;">
					<a href="<?php echo base_url().'superadmin/home'?>" class="button_grey">Back</a>
                    <input type="submit" class="button_grey" id="submit" name="addedit" value="<?php echo ($row->id)?'Update':'Submit'?>">
					<input type="hidden" name="id" value="<?php echo $row->id?>">

                </div>

            </form>

        </div>
    </div><!--contentwrapper-->
    <br clear="all" />
</div><!-- centercontent -->
</section>



<script>
	jQuery(document).ready(function(){
		
	/*	
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
					jQuery('#slug').val(msg);
				}
			});
		}*/
	<?php //} ?>
		
		
		/*jQuery("#staticpage").validate({
			rules: {
				title: "required",
				short_desc: "required",
				content: "required"
			}
		});
		*/
		

jQuery(document).ready(function(){
      
               jQuery("#staticpage").validate({
		rules: {
			title: "required",
			priority : "required",
			category: "required"
			
		},
		messages: {
			title: "Please enter Title",
			priority: "Please enter priority",
			category: "Please select Category"
			
		}
	
        });
});	

		
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
