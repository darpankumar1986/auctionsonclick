<script type="text/javascript" src="<?php echo VIEWBASE?>js/plugins/jquery.uniform.min.js"></script>
<script type="text/javascript" src="<?php echo VIEWBASE?>js/plugins/jquery.validate.min.js"></script>
<script type="text/javascript" src="<?php echo VIEWBASE?>js/plugins/tinymce/jquery.tinymce.js"></script>
<script type="text/javascript" src="<?php echo VIEWBASE; ?>js/plugins/jquery.tagsinput.min.js"></script>
<link rel="stylesheet" type="text/css" href="<?php echo VIEWBASE?>css/plugins/jquery.tagsinput.css">
<script type="text/javascript" src="<?php echo VIEWBASE; ?>js/plugins/jquery.colorbox-min.js"></script>
<script>
	jQuery(document).ready(function(){		
		//Examples of how to assign the Colorbox event to elements
		jQuery(".iframe").colorbox({iframe:true, width:"90%", height:"90%"});
	});
</script>

<?php 
if($records){
	foreach($records as $row){};
}

if($records){
	$id=$row->id;	
	$name=$row->title;	
	$image = $row->image;
	$url = $row->content;
	$order = $row->priority;
	$status=$row->status; 
	$indate = $row->inadate; 
}else{	
	$status = 0;	
	$id = 0;
}
?> 
<style>
.rgt_detail > select, .rgt_detail >input, .rgt_detail > textarea{color: #333 !important;font-weight: bold; }
</style>
<script src="<?=  base_url();?>js/jscolor.js"></script>
<style>
#image_old_data img{width:150px !important;height:50px;}
</style>
<section class="body_main1">
		<div class="row">		
			<a href="<?php echo base_url().'superadmin/news/homesliderlist'?>" class="button_grey"> Homepage Header Slider</a>
		</div>
		<div class="box-head">Add/Edit Homepage Header Slider</div>
		<div class="centercontent">
			<div class="pageheader">
				<span class="pagedesc"><div style="color:red"><?php echo validation_errors(); ?></div></span>
			</div><!--pageheader-->
			<div id="contentwrapper" class="contentwrapper box-content2">
				<div id="validation" class="subcontent">
					<form enctype="multipart/form-data" method="post" class="stdform" id="bank" name="add_data_view" accept-charset="utf-8" action="/superadmin/news/addedithomesliderSave/<?php echo $row->id?>">	

						<div class="row">
							<div class="lft_heading">Name <span class="red"> *</span></div>
							<div class="rgt_detail">
								<input type="text" maxlength="200" name="name" id="name" class="longinput" value="<?php echo $name?>" />
								<label class="error" style="display:none;">Please enter Name</label>
							</div>					
						</div>
						<div class="row">
							<div class="lft_heading"> Upload Banner (846 x 312px) </div>
								<div class="rgt_detail">
								<input onchange="validate_upload('image');" type="file" name="image" id="image">(jpg | png | jpeg | gif )
								<input type="hidden" name="image_old" id="image_old" value="<?php echo $image; ?>"><div id="imgerror_image" class="error" style="color:red;"></div>
								<?php if($image){?><span id="image_old_data"><br><br><img src="<?php echo $image;?>"   /></span><?php }?>	
							</div>
						</div>
						<div class="row">
							<div class="lft_heading">Banner Link</div>
							<div class="rgt_detail">
								<input type="text" maxlength="200" name="url" id="url" class="longinput" value="<?php echo $url?>" />
								<label class="error" style="display:none;">Please enter url</label>
							</div>					
						</div>
						<div class="row">
							<div class="lft_heading">Order <span class="red"> *</span></div>
							<div class="rgt_detail">
								<input type="text" maxlength="200" name="order" id="order" class="longinput" value="<?php echo $order?>" />
								<label class="error" style="display:none;">Please enter Order</label>
							</div>					
						</div>
						<div class="row">
							<div class="lft_heading">Status<span class="red"> *</span></div>
							<div class="rgt_detail">
							<select name="status">
								<option value="1" <?php if($status==1)echo 'selected';?>>Active</option>
								<option value="0" <?php if($status==0)echo 'selected';?>>Inactive</option>
							</select>
							</div>	
						</div>	
                                                <div class="stdformbutton row" style="text-align:center;">
							<a href="<?php echo base_url().'superadmin/home'?>" class="button_grey">Back</a>
							<input type="submit" name="addedit" value="<?php if($id){ ?>Update <?php }else{ ?>Submit<?php } ?>" class="button_grey">
							<input type="hidden" name="id" id="id" value="<?php echo $id;?>">
						</div>
						
					</form>
				</div>
			</div><!--contentwrapper-->
			<br clear="all" />
		</div><!-- centercontent -->
</section>
<script>
     function isNumberKey(evt)
    {
        var charCode = (evt.which) ? evt.which : event.keyCode;
        console.log(charCode);
        if ( charCode != 45 && charCode > 31
                && (charCode < 48 || charCode > 57))
            return false;

        return true;
    }
jQuery(document).ready(function(){	
	jQuery("#bank").validate({
		rules: {
			 name: {
				required:true,
			    },
			image: {
				accept: "png|jp?g|gif"
			},
			 order: {
				required:true,
			    },
		},
		messages: {
			image: {
				accept: "Invailid image format."},
			name: {
				required: "Please enter banner title"
		    },
		    order: {
				required: "Please enter banner order"
		    }
		}
	});
});

function validate_upload(fname) {
    //Get reference of FileUpload.
        var fileUpload = document.getElementById(fname);
	var size=jQuery('#'+fname)[0].files[0].size;
	sizelimit=5000;// MB 
	slimit=(1024)*parseInt(sizelimit);
        var regex = new RegExp("([a-zA-Z0-9\s_\\.\-:])+(.jpg|.png|.gif|.jpeg|.pdf|.JPG)$");
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
                    //alert("height-"+height+"--------width-"+width +"size--"+size);
                    if (height > 100 && width > 100) 
					{
						//fileUpload.value='';
						//jQuery("#imgerror_"+fname).html('Height and Width should be 100x100.'); 
                        //return false;
                    }
					
                    return true;
                };
 
            }
			}else{
				 fileUpload.value='';
				 jQuery("#imgerror_"+fname).html('Please upload image less than 5000 kb.');
				 return false;
			}
			
			
        } else {
			jQuery("#imgerror_"+fname).html('This browser does not support HTML5.');
            fileUpload.value='';
            return false;
        }
    } else {
		jQuery("#imgerror_"+fname).html('Please select a valid Image file.');
		 fileUpload.value='';
        return false;
    }

	jQuery("#imgerror_"+fname).html('');
	return true;
}

</script>
