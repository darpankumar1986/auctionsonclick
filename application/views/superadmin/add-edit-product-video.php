<script type="text/javascript" src="<?php echo VIEWBASE?>js/plugins/jquery-1.7.min.js"></script>

<script type="text/javascript" src="<?php echo VIEWBASE?>js/plugins/jquery.uniform.min.js"></script>
<script type="text/javascript" src="<?php echo VIEWBASE?>js/plugins/jquery.validate.min.js"></script>
<style type="text/css">
.centercontent{ margin-left:30px;}
.stdform label {width:160px;}
</style>

<div class="pageheader">
		<h1 class="pagetitle"><?php echo $heading?></h1>
		<ul class="hornav">
			<li><a href="/superadmin/product_video/page_popup/<?php echo $product_id; ?>">View Videos</a></li>
			<li class="current"><a href="/superadmin/product_video/add_popup/<?php echo $product_id; ?>">Add Video</a></li>
			<!--<li class=""><a href="/superadmin/product_video/add_multiple_popup/<?php echo $product_id; ?>">Add Multiple Videos</a></li>-->
		</ul>
	</div>

<div class="centercontent">
	  <div id="contentwrapper" class="contentwrapper">
		<div id="validation" class="subcontent">  
<?php 
	  $id=$row->id; 
	 $product_id=$product_id; 
	 $name=$row->name; 
	 $title=$row->title; 
	 $type=$row->type; 
	 $priority=$row->priority; 
?> 	
			<form enctype="multipart/form-data" method="post" class="stdform" id="videosform" name="add_data_view" accept-charset="utf-8" action="/superadmin/product_video/save">	
				<p>
					<label>Video Type</label>
					<span class="field">
						<select onchange="showtype(this.value)" name="type" id="type">
						<option value="">Select Type</option>
						<option <?php if($type=='url'){ echo "selected";}else{ echo "";}?> value="url">Youtube Url </option>
						<option <?php if($type=='video'){ echo "selected";}else{ echo "";}?> value="video">Video</option>
						<select>
						
					</span>					
				</p>
				
				<p id="youtube_section" <p id="video_section" <?php if($type=='url'){ echo 'style="display:block"';}else{ echo 'style="display:none"';}?> >
					<label>Youtube Url</label>
					<span class="field">
						<input type="text" name="youtubeurl" id="youtubeurl" value="<?php echo $name;?>" class="longinput"  />
						
					</span>					
				</p>
				<p id="video_section" <?php if($type=='video'){ echo 'style="display:block"';}else{ echo 'style="display:none"';}?> >
					<label>Video</label>
						<span class="field">
						<input type="file" name="video" id="video">(mp4)
						<?php if($id>0) { ?>
						<input type="hidden" name="video_old" id="video_old" value="<?php echo $name; ?>">
						<?php } ?>
						<?php if($name){?><br>
						<video height="80" width="80" controls >
						<source src="<?php echo base_url(); ?>public/uploads/videos/<?php echo $name;?>" type="<?php echo get_mime_by_extension($name)?>">
						</video><?php }?>	
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
					<label>Priority</label>
					<span class="field">
						<input type="text" name="priority" id="priority" class="width100 longinput" value="<?php echo $priority?>" />
					</span>					
				</p>

				<p class="stdformbutton">					
					<input type="submit"  name="addedit" value="<?php echo ($product_id)?'Update':'Submit'?>">
					<input type="hidden" name="id" value="<?php echo $id?>">
					<input type="hidden" name="product_id" value="<?php echo $product_id?> ">
				</p>
				
			</form>
        </div>
	</div><!--contentwrapper-->
    <br clear="all" />
</div><!-- centercontent -->
<script>


$(document).ready(function(){
	
	$( "#type" ).change(function() {
	type=$(this).val();
	if(type=='url')
	{
		$("#youtube_section").show();
		$("#video_section").hide();
	}else if(type=='video')
	{
		$("#youtube_section").hide();
		$("#video_section").show();
	}else{
		$("#youtube_section").show();
		$("#video_section").hide();	
	}
	//alert(type);	
});
/*
		$("#type").change(function(){
		type=$(this).val();	
		alert(type);
			
		});
	
	*/
	$("#videosform").validate({
		rules: {
			<?php if($id<=0) { ?>
			video: {
				required: true,
				accept: "mp4"
			},
			<?php } ?>
			type:"required",
			youtubeurl:{
				required:true,
				url:true
			},
			
			title: {
				required: true
			}
		},
		messages: {
			<?php if($id<=0) { ?>
			video:{
				required: "Please select video",
				accept: "Please select valid video type"
			},
			<?php } ?>
			title: "Please enter title",
			type: "Please select type",
			youtubeurl:{
				required:"Please enter youtube url",
				url:"Please select valid url"
			} 
			
		}
		
	});
	
});	
</script>
