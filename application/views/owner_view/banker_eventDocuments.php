<link rel="stylesheet" href="<?php echo base_url()?>css/colorbox.css" />
<script src="<?php echo base_url()?>js/jquery.colorbox.js"></script>
<section>
  <?php echo $breadcrumb;
  ?>
  <div class="row">
    <div class="wrapper-full">
      <div class="dashboard-wrapper">
			<?php
			/*
			echo "<pre>";
			print_r($data);
			*/
			
			foreach($data  as $img)
			{
				$name = str_replace('Upload','',$img['upload_document_field_name']);
			?>
				
				<div class="col-xs-6 col-sm-3 col-md-3 text-center" style="float:left;">
					<?php if($img['upload_document_field_type']==1) 
					{ 
						
						$imgExts = array("jpg", "jpeg", "png");
						$imgArr = explode('.',$img['file_path']);
						if(in_array($imgArr[1],$imgExts))
						{
						
					?>
							<a class="bidderwiseitem cboxElement thumbnail" href="<?php echo base_url();?>owner/quick_view/public/uploads/event_auction/<?php echo $img['file_path']; ?>" class="" data-toggle="modal" data-target="#lightbox">
						
								<img style="width:200px;height:200px;float:left;margin-left:5px;" src="<?php echo base_url();?>public/uploads/event_auction/<?php echo $img['file_path'];?>">                        						
							</a>
                    <?php 
						}
						if($imgArr[1] =='pdf')
						{
					?>	
							<a download class="" href="<?php echo base_url();?>public/uploads/event_auction/<?php echo $img['file_path']; ?>" class="">
								<img style="width:200px;height:200px;float:left;margin-left:5px;" src="<?php echo base_url();?>images/pdf-icon.jpg">
							</a>
					<?php
						}
						
					
                    } 
                    else {?>
						
						<a class="" href="<?php echo base_url();?>public/uploads/event_auction/<?php echo $img['file_path']; ?>" class="">
						<img download style="width:200px;height:200px;float:left;margin-left:5px;" src="<?php echo base_url();?>images/dummy_video.gif">
                    </a>
						<?php } ?>
                    <br>
                    <br>
                    <div style="text-align:center; width:80%;font-weight:bold; font-size:12px;"><?php echo $name;?></div>
                </div>
			<?php
			}
			
			?>			
      </div>
    </div>
  </div>
</section>
<script>
$(".bidderwiseitem").colorbox({iframe:true, width:"60%", height:"100%"});
</script>
