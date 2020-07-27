<link href="<?php echo base_url(); ?>assets/css/colorbox.css" rel="stylesheet" type="text/css">
<link href="<?php echo base_url(); ?>assets/home/css/style.css" rel="stylesheet">   
<link href="<?php echo base_url(); ?>assets/home/css/style1.css" rel="stylesheet">  
<link href="<?php echo base_url(); ?>assets/home/css/quick_view.css" rel="stylesheet">  
<script src="<?php echo base_url(); ?>assets/home/js/jquery.etalage.min.js"></script>
<script src="<?php echo base_url(); ?>assets/js/jquery.colorbox.js"></script> 
<script>
	 jQuery(document).ready(function($){
		$('#etalage').etalage({
			thumb_image_width: 300,
			thumb_image_height: 250,
			source_image_width: 800,
			source_image_height: 800,
			show_hint: true,
		});
	 });
</script>
<style>
.modal-dialog {
    margin: 0% auto 0 auto!important;   
}
</style>
<?php
//print_r($data);
?>

<div class="modal fade" id="quick-view-modal1" tabindex="-1" role="dialog" aria-labelledby="myModalLabel" aria-hidden="true"> 
	<div class="modal-dialog">
		<div class="modal-content"> 
			<div class="modal-body"> 
				<div class="row"> 
					<img class="etalage_thumb_image img-responsive" src="<?php echo base_url();?><?php echo $this->uri->segment(3)."/".$this->uri->segment(4)."/".$this->uri->segment(5)."/".$this->uri->segment(6);?>" style="max-width: 844px; max-height: 314px;" />
				</div>
			</div>
		</div>
	</div>
</div>
