
<script type="text/javascript" src="<?php echo VIEWBASE?>js/plugins/jquery.uploadify.min.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo VIEWBASE?>css/plugins/uploadify.css">
<style type="text/css">
.centercontent{ margin-left:30px;}
.stdform label {width:160px;}
</style>
<div class="pageheader">
		<h1 class="pagetitle"><?php echo $heading?></h1>
		<ul class="hornav">
			<li><a href="/superadmin/article_image/page_popup/<?php echo $article_id; ?>">View Images</a></li>
			<li><a href="/superadmin/article_image/add_popup/<?php echo $article_id; ?>">Add Image</a></li>
			<li class="current"><a href="/superadmin/article_image/add_multiple_popup/<?php echo $article_id; ?>">Add Multiple Images</a></li>
		</ul>
	</div>

<div class="centercontent">
	  <div id="contentwrapper" class="contentwrapper">
		<div id="validation" class="subcontent">            	
			<form>	
				
				<p>
						<span class="field">
						<input type="file" name="file_upload"  id="file_upload" multiple="true">
					</span>
				</p>
				
				<p>
					<div id="queue"></div>
				</p>
				
				<p class="stdformbutton">					
					<input type="hidden" name="article_id" value="<?php echo $article_id?>">
				</p>
				
			</form>
        </div>
	</div><!--contentwrapper-->
    <br clear="all" />
</div><!-- centercontent -->

<script>
jQuery(document).ready(function(){
	jQuery('#file_upload').uploadify({
		'formData'     : {
			'article_id' : '<?php echo $article_id?>',
			'sess' : '<?php echo $this->session->userdata('session_id');?>'
		},
		'fileTypeDesc' : 'Image Files',
    'fileTypeExts' : '*.gif; *.jpg; *.png; *.jpeg',
		'swf'      : '<?php echo VIEWBASE?>images/uploadify.swf',
		'uploader' : '/superadmin/article_image/save_multiple',
		'onQueueComplete': function() {
			location.href = '/superadmin/article_image/page_popup/<?php echo $article_id?>';
		}
	});
	
});	
</script>

