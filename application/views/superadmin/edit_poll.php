<script type="text/javascript" src="<?php echo VIEWBASE?>superadmin/js/plugins/jquery.validate.min.js"></script>
<script type="text/javascript" src="<?php echo VIEWBASE?>superadmin/js/plugins/jquery.tagsinput.min.js"></script>
<script type="text/javascript" src="<?php echo VIEWBASE?>superadmin/js/plugins/charCount.js"></script>
<script type="text/javascript" src="<?php echo VIEWBASE?>superadmin/js/plugins/ui.spinner.min.js"></script>
<script type="text/javascript" src="<?php echo VIEWBASE?>superadmin/js/plugins/chosen.jquery.min.js"></script>
<script type="text/javascript" src="<?php echo VIEWBASE?>superadmin/js/custom/forms.js"></script>
<script type="text/javascript" src="<?php echo VIEWBASE?>js/plugins/tinymce/jquery.tinymce.js"></script>
<script>

jQuery().ready(function() {
		jQuery('textarea.tinymce').tinymce({
			// Location of TinyMCE script
			script_url : '<?php echo VIEWBASE?>js/plugins/tinymce/tiny_mce.js',

			// General options
			theme : "advanced",
			skin : "themepixels",
			width: "100%",
			plugins : "autolink,lists,pagebreak,style,layer,table,save,advhr,advimage,advlink,emotions,iespell,inlinepopups,insertdatetime,preview,media,searchreplace,print,paste,directionality,fullscreen,noneditable,visualchars,nonbreaking,xhtmlxtras,template,advlist",
			inlinepopups_skin: "themepixels",
			// Theme options
			theme_advanced_buttons1 : "bold,italic,underline,strikethrough,|,justifyleft,justifycenter,justifyright,justifyfull,outdent,indent,blockquote,formatselect,fontselect,fontsizeselect",
			theme_advanced_buttons2 : "pastetext,pasteword,|,bullist,numlist,|,undo,redo,|,link,unlink,image,help,code,|,preview,|,forecolor,backcolor,removeformat,|,charmap,media,|,fullscreen",
			theme_advanced_buttons3 : "",
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
				
		
		jQuery('.editornav a').click(function(){
			jQuery('.editornav li.current').removeClass('current');
			jQuery(this).parent().addClass('current');
			if(jQuery(this).hasClass('visual'))
				jQuery('#elm1').tinymce().show();
			else
				jQuery('#elm1').tinymce().hide();
			return false;
		});
});</script> 
<script>  function supportFile(obj){
var val=obj.value;

if(val=='image')
{
$("#image").css({"display":"block"});
$("#text").css({"display":"none"});
}
if(val=='text')
{
$("#text").css({"display":"block"});
$("#image").css({"display":"none"});
}
}

</script> 
    <div class="centercontent">
    
        <div class="pageheader">
            <h1 class="pagetitle">Edit Poll</h1>
            <span class="pagedesc"><div style="color:red"><?php echo validation_errors(); ?></div></span>
            
        </div><!--pageheader-->
        
        <div id="contentwrapper" class="contentwrapper">
		<div id="validation" class="subcontent">
            	
					
					<?php
					if(!count($listing))redirect('superadmin/poll');
						echo form_open_multipart('superadmin/poll/edits', array('name' => 'edit_data_view','id'=>'form1', 'class'=>'stdform', 'method'=>'post'));   
								foreach ($listing as $row){} 
					?>
                    	<p>
                        	<label>Type</label>
                            <span class="field">
							<?php echo ucfirst($row->poll_type) ?>
							<input type="hidden" name="poll_id" value="<?php echo $row->poll_id ?>"  ></input>
							<input type="hidden" name="count" value="<?php echo count($option) ?>"  ></input>
							<input type="hidden" name="poll_type" value="<?php echo $row->poll_type ?>"  ></input></span>
                        </p>                        
                        <p>
                        	<label>Question</label>
                            <span class="field"><textarea name="poll_question" id="elm1"  class="tinymce"><?php echo $row->poll_question ?></textarea></span>
                        </p>                     
                        <p id='text' <?php if($row->poll_type=='image') echo 'style="display:none"'?>>
                        	<label>Option</label>
                            <span class="field">
                            	<?php $i=0;foreach ($option as $row1){$i++;?>
								<input id="field_<?php echo $i?>" type="text"  name="txtOpt<?php echo $i?>" value="<?php echo $row1->option_name?>"> <br><br>
								<?php }?>
                            </span>
                        </p> 
						<p id='image' <?php if($row->poll_type=='text') echo 'style="display:none"'?>>
                        	<label>Option</label>
                            <span class="field">
                            	<?php $i=0;foreach ($option as $row1){$i++;?>
								<img src="/poll/<?php echo $row->poll_id ?>/<?php echo $row1->option_name?>" title="<?php echo $row1->option_title?>" width="50px" height="50px">
								<input  type="file"  name="txtImage<?php echo $i?>">
								<input  type="hidden"  name="txtimg<?php echo $i?>" value="<?php echo $row1->option_name?>"><br>
								<input  type="text"  name="txtText<?php echo $i?>" value="<?php echo $row1->option_title?>" ><br>
								<?php }?>
                            </span>
                        </p>
                        <p>
                        	<label>Status</label>
                            <span class="field">
                            <select name="status" id="selection">
                            	<option value="">Choose One</option>
                                <option value='1' <?php if($row->status==1)echo 'selected';?>>Active</option><option value='0' <?php if($row->status==0)echo 'selected';?>>Inactive</option>
                            </select>
                            </span>
                        </p>
                        
                        <br />
                        
                        <p class="stdformbutton">
							<input type="hidden" name="submit" value="Submit"></input>
                        	<button class="submit radius2">Submit Button</button>
                        </p>
                    </form>

            </div>
			 </div><!--contentwrapper-->
        
        <br clear="all" />
        
	</div><!-- centercontent -->
    
    
