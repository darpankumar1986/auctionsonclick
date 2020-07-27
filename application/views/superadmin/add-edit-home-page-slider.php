<script type="text/javascript" src="<?php echo VIEWBASE?>js/plugins/jquery.uniform.min.js"></script>
<script type="text/javascript" src="<?php echo VIEWBASE?>js/plugins/jquery.validate.min.js"></script>
<script type="text/javascript" src="<?php echo VIEWBASE?>js/custom/forms.js"></script>
<?php 
if($row){
	$id=$row->id; 
	$title=$row->title; 
	$description=$row->description; 
	$image=$row->image; 
	$priority=$row->priority;
	$status=$row->status; 
	$indate=$row->indate; 
	$url=$row->url; 
}
else{
	$status = 1;
	$id = 0;
}
?> 
<div class="centercontent">
	<div class="pageheader">
		<h1 class="pagetitle"><?php echo $heading; ?></h1>
		<span class="pagedesc"><div style="color:red; text-align:center;">
		<?php echo validation_errors(); 
		     echo $this->session->flashdata('message');
		?>
		</div></span>
	</div><!--pageheader-->
    <div id="contentwrapper" class="contentwrapper">
		<div id="validation" class="subcontent">            	
			<form enctype="multipart/form-data" method="post" class="stdform" id="homeslider" name="add_data_view" accept-charset="utf-8" action="/superadmin/home_page_slider/save">	
				<p>
					<label>Title <font color="red">*</font></label>
					<span class="field">
						<input maxlength="200" type="text" name="title" id="title" class="longinput" value="<?php echo $title?>" />
						<label class="error" style="display:none;">Please enter Title</label>
					</span>					
				</p>
				<p>
					<label>Description <font color="red">*</font></label>
					<span class="field">
				
						<textarea maxlength="400" name="description" id="description" rows="5" cols="60" ><?php echo $description ?></textarea>
						<label class="error" style="display:none;">Please enter Description</label>
					</span>					
				</p>
				<p>
					<label>Image <font color="red">*</font></label>
						<span class="field">
						<input onchange="validate_upload()" type="file" name="image" id="image">(jpg | png | jpeg | gif | 890(w) x 489(h))
						
						<?php
						if($image!='') {
						?>
						<input type="hidden" name="image_old" value="<?php echo $image; ?>">
						<?php if($image){?><br><br><img src="<?php echo base_url(); ?>public/uploads/home_page_slider/<?php echo $image;?>" height="80" width="80" /><?php } 
						} ?>
						<label for="image" class="error" style="display:none;">Please select an image.</label>
						
					</span>
				</p>
				<p>
					<label>Priority <font color="red">*</font></label>
					<span class="field">
						<input maxlength="2" type="text" name="priority" id="priority" class="longinput" value="<?php echo $priority ?>" />
						<label class="error" style="display:none;">Please enter Priority</label>
					</span>					
				</p>
				<p>
					<label>Link URL <font color="red">*</font></label>
					<span class="field">
						<input maxlength="150" type="text" name="url" id="url" class="longinput" value="<?php echo $url ?>" />
						<label class="error" style="display:none;">Please enter url</label>
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
					<input type="submit"  name="addedit" id="addedit" value="<?php echo ($id)?'Update':'Submit'?>">
					<input type="hidden" name="id" id="id" value="<?php echo $id?>">
				</p>
				
			</form>
        </div>
	</div><!--contentwrapper-->
    <br clear="all" />
</div><!-- centercontent -->

<script>
jQuery(document).ready(function(){
      
               jQuery("#homeslider").validate({
		rules: {
			title: "required",
			description : "required",
			<?php if($id<=0){ ?>
			image: "required",
			<?php } ?>
			priority: "required",
			url: {
				required :true,
				url:true
			}
			
		},
		messages: {
			title: "Please enter Title",
			description: "Please enter Description",
			<?php if($id<=0){ ?>
			image: "Please select Image",
			<?php } ?>
			priority: "Please enter Priority",
			url: {
				required :"Please enter URL",
				url:"Please enter valid URL"
			}
		}
	
        });
});	



function validate_upload() {
    //Get reference of FileUpload.
    var fileUpload = document.getElementById("image");
	var size=jQuery('#image')[0].files[0].size;
	sizelimit=2;// MB 
	slimit=(1024*1024)*parseInt(sizelimit);
	
    var regex = new RegExp("([a-zA-Z0-9\s_\\.\-:])+(.jpg|.png|.gif|.jpeg)$");
    if (regex.test(fileUpload.value.toLowerCase())) {
 
        //Check whether HTML5 is supported.
        if (typeof (fileUpload.files) != "undefined") {
            //Initiate the FileReader object.
            var reader = new FileReader();
            //Read the contents of Image File.
            reader.readAsDataURL(fileUpload.files[0]);
			
			if(size <= slimit){
				
            reader.onload = function (e) {
                //Initiate the JavaScript Image object.
                var image = new Image();
 
                //Set the Base64 string return from FileReader as source.
                image.src = e.target.result;
                       
                //Validate the File Height and Width.
                image.onload = function () {
                    var height = this.height;
                    var width = this.width;
                    var size = fileUpload.files[0];
                   // alert("height-"+height+"--------width-"+width +"size--"+size);

                    if (height < 489 && width < 890) {
						 fileUpload.value='';
						jQuery("#imgerror").html('Height and Width should be 890x489.'); 
                        return false;
                    }
					
                   // alert("Uploaded image has valid Height and Width.");
                    return true;
                };
 
            }
			}else{
				 fileUpload.value='';
				 jQuery("#imgerror").html('Please upload image less than 2MB.');
				 return false;
			}
			
			
        } else {
			jQuery("#imgerror").html('This browser does not support HTML5.');
            fileUpload.value='';
            return false;
        }
    } else {
		jQuery("#imgerror").html('Please select a valid Image file.');
		 fileUpload.value='';
        //alert("Please select a valid Image file.");
        return false;
    }

	jQuery("#imgerror").html('.');
	return true;
}


</script>
