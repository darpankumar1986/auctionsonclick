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
	$product_id=$row->product_id; 
	$image=$row->name; 
	$title=$row->title; 
	$is_banner=$row->is_banner; 
	$priority=$row->priority; 
	
}else{	
	$status = 1;	
}
?> 
<div class="pageheader">
		<h1 class="pagetitle"><?php echo $heading?></h1>
		<ul class="hornav">
			<li><a href="/superadmin/product_image/page_popup/<?php echo $product_id; ?>">View Images</a></li>
			<li class="current"><a href="/superadmin/product_image/add_popup/<?php echo $product_id; ?>">Add Image</a></li>
			<li class=""><a href="/superadmin/product_image/add_multiple_popup/<?php echo $product_id; ?>">Add Multiple Images</a></li>
		</ul>
	</div>

<div class="centercontent">
	  <div id="contentwrapper" class="contentwrapper">
		<div id="validation" class="subcontent">            	
			<form enctype="multipart/form-data" method="post" class="stdform" id="article" name="add_data_view" accept-charset="utf-8" action="/superadmin/product_image/save">	
				
				
				
				<p>
					<label>Image</label>
						<span class="field">
						<input type="file" name="image">(jpg | png | jpeg | gif )
						<input type="hidden" name="image_old" id="image_old" value="<?php echo $image; ?>">
						<?php if($image){?><br><br><img src="<?php echo base_url(); ?>public/uploads/property_images/<?php echo $image;?>" height="80" width="80" /><?php }?>	
					</span>
				</p>
				
				<p>
					<label>Priority</label>
					<span class="field">
						<input type="text" name="priority" id="priority" class="width100 longinput" value="<?php echo $priority?>" />
					</span>					
				</p>
				
				<p class="stdformbutton">					
					<input type="submit"  name="addedit" value="<?php echo ($product_id)?'Update':'Submit'?>">
					<input type="hidden" name="id" value="<?php echo $id?>">
					<input type="hidden" name="product_id" value="<?php echo $product_id?>">
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
		image: {
			accept: "Please seled vailid image format"
		}
		
	});

});	
</script>
