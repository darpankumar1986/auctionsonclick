<style type="text/css">
.centercontent{ margin-left:30px;}
.stdform label {width:160px;}
</style>
<div class="pageheader">
		<h1 class="pagetitle"><?php echo $heading?></h1>
		<ul class="hornav">
			<li><a href="/superadmin/product_image/page_popup/<?php echo $product_id; ?>">View Images</a></li>
			<li ><a href="/superadmin/product_image/add_popup/<?php echo $product_id; ?>">Add Image</a></li>
			<li class="current"><a href="/superadmin/product_image/add_multiple_popup/<?php echo $product_id; ?>">Add Multiple Images</a></li>
		</ul>
	</div>

<div class="centercontent">
	  <div id="contentwrapper" class="contentwrapper">
		<div id="validation" class="subcontent">            	
			<form enctype="multipart/form-data" method="post" class="stdform" id="article_multiple_image" name="article_multiple_image" accept-charset="utf-8" action="/superadmin/product_image/save_multiple">	
				<p>
					<span class="field">
						<input type="file" name="file_upload[]"  id="file_upload" multiple="true" required>
					</span>
				</p>
				
				<p class="stdformbutton">					
					<input type="submit"  name="submit" value="<?php echo ($product_id)?'Update':'Submit'?>">
					<input type="hidden" name="product_id" value="<?php echo $product_id?>">
				</p>
				
			</form>
        </div>
	</div><!--contentwrapper-->
    <br clear="all" />
</div><!-- centercontent -->

<script>
jQuery(document).ready(function(){

	jQuery("form").submit(function(){
		var flag= true;
		jQuery("input[type=file]").each(function() {
			jQuery.map(jQuery(this).get(0).files, function(file) {

			  if(file.size/1024>900){
			  alert(file.name +" Image is too big,max allow size 100 KB ! "); 
			  flag = false;
			  }
			});
		});
	return flag;
   });
   
});	
</script>

