<?php
$images=$prows->images;
$videos=$prows->video;
$attributs=$prows->attr_val;
foreach($videos as $vrow);
$productid =$prows->id;

?>
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/jquery.dataTables.css" type="text/css" media="screen"/>	
<link rel="stylesheet" href="/css/colorbox.css" />
<script src="/js/jquery.colorbox.js"></script>
<script>
	jQuery(document).ready(function(){
		//Examples of how to assign the Colorbox event to elements
		jQuery(".iframe").colorbox({iframe:true, width:"80%", height:"80%"});
		//Example of preserving a JavaScript event for inline calls.
		jQuery("#click").click(function(){ 
			jQuery('#click').css({"background-color":"#f00", "color":"#fff", "cursor":"inherit"}).text("Open this window again and this message will still be here.");
			return false;
		});
	});
</script>
<section>
<section>
	<?php echo $breadcrumb;?>
	<div class="row">
		<div class="wrapper-full">
			<div class="dashboard-wrapper">
				<div class="search-row">
					<div class="srch_wrp">
						<input type="text" value="Search" id="search" name="search">
						<span class="ser_icon"></span> 
					</div>
					<a href="#">Advance Search+</a> 
				</div>
			 	<div id="tab-pannel6" class="btmrgn">
					<ul class="tabs6">
						<a href="/owner"><li rel="tab1">Buy</li></a>
						<a href="/owner/sell"><li class="active"  rel="tab2">Sell</li></a>
					</ul>
					<div class="tab_container6"> 
					<!---- buy tab container start ---->
					<div id="tab1" class="tab_content6" style="display:block">
						<div id="tab-pannel3" class="btmrgn">
							<ul class="tabs3">
								<a href="/owner/sell"><li  rel="tab9">My Summary</li></a>
								<a href="/owner/liveAuction"><li class="active" rel="tab10">My Activity</li></a>
								<a href="/owner/myMessage?type=sell"><li rel="tab11">My Message</li></a>
								<a href="/owner/myProfile?type=sell"><li rel="tab12">My Profile</li></a>
							</ul>
							<div class="tab_container3 whitebg"> 
								<!-- Sell > My Activity start -->
						  <div id="tab10" class="tab_content3">
							<div class="container">
							  <div class="secttion-left">
								<div class="left-widget">
								  <div id="cssmenu">
									<?php echo $leftsidebar;?>
								  </div>
								</div>
							  </div>
							<div class="secttion-right">
								<h3 class="btmrg20"><?php echo $heading?></h3>
								<div class="table-wrapper btmrg20">
							<div class="table-section"> 
							<div id="error" style="color:red;">
								<?php if(isset($this->session->userdata['flash:old:message'])){?>
								<div  style="color:red;text-align:center;"> <?php echo @$this->session->userdata['flash:old:message']; ?></div>
								<?php } ?>
							</div>					
				<form method="post" enctype="multipart/form-data" name="postsellerRequirement" id="postsellerRequirement" action="<?php echo  base_url();?>/owner/sellerpostPropertydata">
				<div class="form">
				
					 <dl>
						<dt class="required">
						  <label>Title </label>
						</dt>
						<dd>
						  <input maxlength="500" name="name" id="name" type="text" value="<?php echo @$prows->name; ?>" class="input">
						  <span class="help-icon" title="Enter Property Title"></span> </dd>
					</dl>

					<dl>
						<dt class="required">
						  <label>Price</label>
						</dt>
						<dd>
						   <input maxlength="30"  onkeypress="return isNumberKey(event);" name="price" id="price" type="text" value="<?php echo @$prows->price; ?>" class="input">
						  <span class="help-icon" title="Enter Price"></span> </dd>
					</dl>
					<dl>
						<dt>
						  <label>Description</label>
						</dt>
						<dd>
						   <input maxlength="8000" name="description" id="description" value="<?php echo @$prows->product_description; ?>" type="text" class="input">
						   </dd>
					</dl>
					
					<dl>
						<dt class="required">
						  <label>Address</label>
						</dt>
						<dd>
						   <input maxlength="2000" name="address" id="address" type="text" value="<?php echo @$prows->address1; ?>" class="input">
						  <span class="help-icon" title="Enter Address"></span> </dd>
					</dl>
					<dl>
						<dt>
						  <label>Street</label>
						</dt>
						<dd>
						   <input maxlength="400" name="street" id="street" type="text" value="<?php echo @$prows->street; ?>" class="input">
						  </dd>
					</dl>
					
					  <dl>
						<dt class="required">
						  <label>Country</label>
						</dt>
						<dd>
						  <select name="country" id="country" class="select">
						  <option value="">Select Country</option>
						   <?php
								foreach($countries as $country_record){ ?>
					  <option value="<?php echo $country_record->id; ?>" <?php echo ($country_record->id==$prows->country)?'selected':''; ?>><?php echo $country_record->country_name; ?></option>
									<?php } ?>
						  </select>
						</dd>
					  </dl>
					 <dl>
						<dt class="required">
						  <label>State</label>
						</dt>
						<dd>
						  <select  name="state" id="state" class="select">
						  <option value="">Select State</option>
										<?php
									foreach($states as $state_record){?>
					  <option value="<?php echo $state_record->id; ?>" <?php echo ($state_record->id==$prows->state)?'selected':''; ?>><?php echo $state_record->state_name; ?></option>
									<?php }?>
						  </select>
						</dd>
					  </dl>
					<dl>
						<dt class="required">
						  <label>City</label>
						</dt>
						<dd>
						  <select name="city" id="city" class="select">
							<option value="">Select City</option>
									<?php
									foreach($cities as $city_record){?>
					  <option value="<?php echo $city_record->id; ?>" <?php echo ($city_record->id==$prows->city)?'selected':''; ?>><?php echo $city_record->city_name; ?></option>
									<?php }?>
						  </select>
						</dd>
					  </dl>
					  
						<dl>
						<dt>
						  <label>Phone</label>
						</dt>
						<dd>
						   <input maxlength="15" name="phone" id="phone" value="<?php echo @$prows->phone; ?>" type="text" class="input">
						  <span class="help-icon" title="Enter Phone No"></span> </dd>
					</dl>
					
						<dl>
						<dt >
						  <label>Fax</label>
						</dt>
						<dd>
						   <input maxlength="15" name="fax" id="fax" type="text"  value="<?php echo @$prows->fax; ?>" class="input">
						  <span class="help-icon" title="Enter Fax no"></span> </dd>
					</dl>
					
					<div id="addmoreimages" >
					
					<dl>
						<dt >
						  <label>Images</label>
						</dt>
						<dd>
						<?php
						if(count($images)>0)
						{ ?>
						<a class="manageimages iframe" href="/owner/page_popup/<?php echo $productid; ?>" >Manage Images</a>
					<?php } else{ ?>
                                                <input name="image[]" id="image_1" type="file" class="input uploadpropertyimage" onchange="chkfiletype(this);">
						<a class="addmoreimage" href="javascript:">Add More</a> <span class="help-icon" title="Add Property images "></span>
					<?php } ?>
						 
						  </dd>
					</dl>
					
					
					</div>
					
					
					<?php /* ?>
					<div id="addmoreimages" >
					
					<dl>
						<dt >
						  <label>Images</label>
						</dt>
						<dd>
						<?php
						if(count($images)>0)
						{ ?>
						<a class="manageimages iframe" href="/owner/page_popup/<?php echo $productid; ?>" >Manage Images</a>
					<?php } else{ ?>
                                                <input name="image[]" id="image_1" type="file" class="input uploadpropertyimage" onchange="chkfiletype(this);">
						<a class="addmoreimage" href="javascript:">Add More</a> <span class="help-icon" title="Add Property images "></span>
					<?php } ?>
						 
						  </dd>
					</dl>
					
					
					</div>
					<?php */ ?>
					
			
			<?php 
            if(count($vrow) <= 0){	?>
			<dl>
                <dt >
				<?php //echo "tititit->".$vrow->type; ?>
                  <label>Video Type</label>
                </dt>
                <dd>
				<select class="select" name="video_type" id="video_type" class="valid">
							<option value="">Select</option>
							<option <?php if($vrow->type=='url'){ echo'selected="selected"';}else{ echo '';} ?> value="url">URL</option>
							
							<option <?php if($vrow->type=='video'){echo 'selected="selected"';}else{ echo '';} ?> value="video">File</option>
			    </select>
				
				
                  
                </dd>
              </dl>

			<dl id="video_file" <?php if($vrow->type=='video'){ echo 'style="display:block"';} else{ echo 'style="display:none"'; }?> > 
                <dt >
                  <label>Video</label>
                </dt>
                <dd>
                   <input name="video" id="video" type="file" class="input">(.mp4)
				   <?php if($vrow->name){ ?>
				   <input name="old_video" id="old_video" type="hidden" value="<?php echo $vrow->name;?>">
				   <?php } ?>
                  <span class="help-icon" title="Add video  "></span> </dd>
            </dl>
			<dl id="video_url" <?php if($vrow->type=='url'){ echo 'style="display:block"';} else{ echo 'style="display:none"'; }?>>
                <dt>
                  <label>Video URL</label>
                </dt>
                <dd>
                   <input name="video_url" id="video_url" value="<?php echo @$vrow->name; ?>" type="text" class="input">
                  <span class="help-icon"></span> </dd>
            </dl>
			
			<?php } else{ ?>
			
			<dl>
                <dt >
                  <label>Video</label>
                </dt>
                <dd>
				<a class="manageimages iframe" href="/owner/video_page_popup/<?php echo $productid; ?>" >Manage Videos</a>
				 </dd>
            </dl>
			
			<?php  } ?>
			
			
			
					  <dl>
						<dt class="required">
						  <label>Is Auction</label>
						</dt>
						<dd>
						   <select class="select" name="is_auction" id="is_auction">
									<option value="">Select</option>
									<option <?php if($prows->is_auction=='1'){echo $sel='selected="selected"';}else{$sel=='';} ?> value='1'>Yes</option>
									<option <?php if($prows->is_auction=='0'){echo $sel='selected="selected"';}else{$sel=='';} ?> value='0'>No</option>
							</select>
						  <span class="help-icon" title="I want to buy /rent"></span>
						</dd>
					  </dl>
					
					  <dl>
						<dt class="required">
						  <label>Sell/Rent </label>
						</dt>
						<dd>
						  <select name="sele_rent" id="sele_rent" class="select">
						  <option value="">Select</option>
						  <option value="sell" <?php echo ('sell'==$prows->sell_rent)?'selected':''; ?>>Sell</option>
						  <option value="rent" <?php echo ('rent'==$prows->sell_rent)?'selected':''; ?>>Rent</option>
						  
						  </select>
						  <span class="help-icon" title="Property type - flat/plot /villa"></span>
						</dd>
					  </dl>
					 
			<dl>
                <dt class="required">
                  <label>Property Type</label>
                </dt>
                <dd>
                  <select class="select" name="category" id="category" onchange="showsubcategry(this.value,'owner');">
					<option value="">Select</option>
					<?php foreach($category as $category_record){?>
						<option value="<?php echo $category_record->id; ?>" <?php echo ($category_record->id==$prows->product_type)?'selected':''; ?>><?php echo $category_record->name; ?></option>
						<?php }?>
				</select>
                  <span class="help-icon" title="Select Property Type"></span> </dd>
            </dl>
					 
					 
					 
					  <dl>
						<dt class="required">
						  <label>Property Sub Type</label>
						</dt>
						<dd>
						  <select class="select" name="property_type" id="property_type">
							<option value="">Select Property Type</option>
							<?php
							$subcategory=$this->helpdesk_executive_model->GetsubCategorydata($prows->product_type,$prows->product_subtype_id);
							foreach($subcategory as $category_record){?>
								<option value="<?php echo $category_record->id;?>" <?php echo ($category_record->id==$prows->product_subtype_id)?'selected':''; ?>><?php echo $category_record->name; ?></option>
								<?php }?>
						  </select>
						  <span class="help-icon" title="city"></span> </dd>
					  </dl>				  
						<div id="ajaxFormData">
						<?php 
							if($prows->product_subtype_id!=''){ ?>
								<script>
								ajaxFormdata_nonBanker('<?php echo $prows->product_subtype_id; ?>','<?php echo $prows->is_auction; ?>','<?php echo $prows->sell_rent; ?>','<?php echo $propertyID ?>')
								</script>
								
							<?php } ?>
						</div>
					  <div class="seprator btmrg20"></div> 
						<div class="button-row">	
							<input name="productID" type="hidden" value="<?php echo $propertyID;?>">
							<?php if(isset($propertyID)) {
								$btn = "Update";
							} else {
								$btn = "Post";
							}?>
							<input name="submit" id="submit" value="<?php echo $btn?>"  type="submit" class="b_submit float-right">  
						
						</div>
					</div>
					<div id="results"></div>
					</form>
							</div>
						  </div>
							 </div>
							</div>
						  </div>
						  <!-- Sell > My Activity end -->                  
						</div>
					  </div>
					</div>
					<!---- Sell tab container end ----> 
				  </div>
				</div>
			</div>
		</div>
	</div>
	
</section>
<script type="text/javascript" src="/application/views/admin/js/plugins/jquery.validate.min.js"></script>
<script>




jQuery(document).ready(function(){

	jQuery( "#video_type" ).change(function() {
	type=$(this).val();
	if(type=='url')
	{
		jQuery("#video_url").show();
		jQuery("#video_file").hide();
	}else if(type=='video')
	{
		jQuery("#video_url").hide();
		jQuery("#video_file").show();
	}else{
		jQuery("#video_url").hide();
		jQuery("#video_file").hide();	
	}
	//alert(type);	
});

	jQuery("#postsellerRequirement").validate({
		rules: {
			video: {
				accept: "mp4"
			},
			
			"image[]":{
				accept: "png|jpg|gif|jpeg"
			},
			name: "required",
			price: "required",
			address: "required",
			country: "required",
			state: "required",
			city: "required",
			is_auction: "required",
			sele_rent: "required",
			property_type: "required",
			category: "required",
			video_url: {
					url:true	
			}
		} ,
		messages: {
			is_auction:  "Please Select 'Is auction'",			
			address:  "Please Enter address",			
			name:  "Please Enter auction title",			
			price:  "Please Enter auction price",			
			country:  "Please Select country",			
			state:  "Please Select state",			
			city:  "Please Select city",			
			sele_rent:  "Please Select sell/Rent",			
			property_type:  "Please Select property type ",			
			category:  "Please Select Property Sub Type",			
			video: {
				accept:"Please Select mp4 video only"
			} ,
			video_url:{
				url:"Please Enter Valid Youtube url"
			},
			"image[]" : {
				accept :"Please enter valid image"
			}   	
		},
		 submitHandler: function(form) {
			  var album_text = [];
			  jQuery(".required_fields").each(function() {
					if(jQuery(this).val()=='')
					{   dynamicValid =jQuery("#dynamicValid").val();
						attrID=jQuery(this).attr("id");
						//jQuery('<label class="error" >Please Enter value</label>').insertAfter(jQuery("#"+attrID));
						jQuery('#msg_'+attrID).show();
						album_text.push(attrID);	
					}else{
						attrID=jQuery(this).attr("id");
						jQuery('#msg_'+attrID).hide();	
					}
				});	
			if(album_text.length === 0)
			{
				form.submit();
			}else{
				return false;
			}
	}
});	


	
	jQuery('#property_type').change(function(){
		var isauction =	jQuery('#is_auction').val();
		var sele_rent =	jQuery('#sele_rent').val();
		var property_type =	jQuery('#property_type').val();
		if(isauction==''){
			jQuery("#error").html('Please Select is_auction');
			return false;
		}else if(sele_rent==''){			
			jQuery("#error").html('Please Select sele/rent');
			return false;
		}else if(property_type==''){
			//alert("Please Sele ");
			jQuery("#error").html('Please Select Property Type');
			return false;
		}else{
			jQuery("#error").html('');
			ajaxFormdata_nonBanker(property_type,isauction,sele_rent);	
		}		
	});
	
	jQuery('#country').change(function(){
		var country = jQuery(this).val();
		if(country ){
			var state = jQuery('#state').val();
			jQuery('#state').load('/owner/getStateDropDown/'+country+'/'+state);
		}
	});	
	
	jQuery('#state').change(function(){
		var state = jQuery(this).val();
		if(state ){
			var city = jQuery('#city').val();
			jQuery('#city').load('/owner/getCityDropDown/'+state+'/'+city);
		}		
	});
        
	var imgid='1';
        jQuery('.addmoreimage').click( function(){
	    imgid++;	
            var countelement=$('.maindiv').length;
          
            if(countelement<='3'){
		jQuery("#addmoreimages").append('<dl id="main_'+imgid+'" class="maindiv"><dt><label></label></dt> <dd><input name="image[]" onchange="chkfiletype(this);" id="image_'+imgid+'" type="file" class="input"><a id="'+imgid+'" onclick="removeitem(this);" class="removelink">X</a></dd></dl>');	
            }else{
                alert("Only Five Images are Allowed");
                
            }
         });
       var imgid='1';
	  
       });
       function chkfiletype(filedata){
      if(filedata.files[0].size/1024/1024 >2){
           $("#"+filedata.id).prop('value','');
           alert("Please Upload file Less than 2MB");
           return false;
             
       }
     
       return false;
       }
function removeitem(id){ $("#main_"+id.id).remove();}

</script>	
<style>
.removelink{width: 333px !important;}
</style>
