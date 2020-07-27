<script type="text/javascript" src="<?php echo VIEWBASE?>js/plugins/jquery.uniform.min.js"></script>
<script type="text/javascript" src="<?php echo VIEWBASE?>js/plugins/jquery.validate.min.js"></script>
<script type="text/javascript" src="<?php echo VIEWBASE?>js/custom/forms.js"></script>
<?php 
if($row){
	$id=$row->newsID; 
	$title=$row->title; 
	$url=$row->url; 
	$status=$row->status; 
	$date_created=$row->indate; 
}
else{
	$status = 1;
	$id = 0;
}
?> 
<div class="centercontent">
	<div class="pageheader">
		<h1 class="pagetitle"><?php echo $heading; ?></h1>
		<span class="pagedesc"><div style="color:red"><?php echo validation_errors(); ?></div></span>
	</div><!--pageheader-->
    <div id="contentwrapper" class="contentwrapper">
		<div id="validation" class="subcontent">            	
			<form enctype="multipart/form-data" method="post" class="stdform" id="breaking_news" name="add_data_view" accept-charset="utf-8" action="/superadmin/breaking_news/save">	
				
				<p>
					<label>Title<font color='red'>*</font></label>
					<span class="field">
						<input type="text" name="title" id="title" class="longinput" value="<?php echo $title?>" />
					</span>					
				</p>
				
				<p>
					<label>URL<font color='red'>*</font></label>
					<span class="field">
						<input type="text" name="url" id="url" class="longinput" value="<?php echo $url?>" />
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
					<input type="submit"  name="addedit" id="addedit" value="Submit">
					<input type="submit"  name="addedit" id="addedit" value="Remove">
					<input type="hidden" name="id" id="id" value="<?php echo $id?>">
				</p>
				
			</form>
        </div>
	</div><!--contentwrapper-->
    <br clear="all" />
</div><!-- centercontent -->

<script>
jQuery(document).ready(function(){
	jQuery("#category").validate({
		rules: {
			title: required,
			url: required
		},
		messages: {
			title: {
				required: "Please enter name",
			},
			url: {
				accept: "Please select a valid image"
			}
		}
	});
});	
</script>
