<style>
div.gallery {margin: .5%;border: 1px solid #ccc;float: left;width: 180px;box-sizing: border-box;border-radius: 5px !important;}
div.gallery img {width: 45%;height: auto;padding-top: 10%;padding-left: 27%;}
.color1{background:#496fbc;}
.color2{background:#de6d75}
.color3{background:#776fce}
.color4{background: -webkit-radial-gradient(center, ellipse cover, #0e4588 0%, #22bdff 0%, #11719a 100%);}
.color5{background: -webkit-radial-gradient(center, ellipse cover, #5287c7 0%, #96cffd 0%, #2196F3 100%);}
.color6{background: -webkit-radial-gradient(center, ellipse cover, #5287c7 0%, #aeebf7 0%, #00BCD4 100%);}
.color7{background: -webkit-radial-gradient(center, ellipse cover, #5287c7 0%, #0671b8 0%, #07192e 100%);}
.color8{background:#ff920a}
div.desc {padding: 15px 0;text-align: center;color: #fff;}
.main-div{padding-top: 10px;float: left;margin-bottom: 170px;width: 100%;}

@media only screen and (max-width: 767px) {
	div.gallery {border: 1px solid #ccc;float:left;width: 32%; box-sizing: border-box;border-radius: 5px !important;}
	div.desc{font-size:11px;}
}
</style>
<div class="main-div">
	<!--<div class="gallery color1" onclick="window.location.href='<?php echo base_url();?>owner/dashboard_list'">
	  <a href="<?php echo base_url();?>owner/dashboard_list">
		<img src="<?php echo base_url()?>bankeauc/images/dashboard.png" alt="dashboard">	  
	    <div class="desc">Dashboard</div>
	  </a>
	</div>

	<div class="gallery color2" onclick="window.location.href='<?php echo base_url();?>owner/buylistLiveAuctions'">
	  <a href="<?php echo base_url();?>owner/buylistLiveAuctions">
		<img src="<?php echo base_url()?>bankeauc/images/live_auc.png" alt="Live Auction">	 
	    <div class="desc">Live Auction</div>
	  </a>
	</div>
	<div class="gallery color3" onclick="window.location.href='<?php echo base_url();?>owner/completedAuction'">
	  <a href="<?php echo base_url();?>owner/completedAuction">
		<img src="<?php echo base_url()?>bankeauc/images/past_auc.png" alt="Completed Auction">
		<div class="desc">Completed Auction</div>
	  </a>
	  
	</div>-->
	
	<div class="gallery color7" onclick="window.location.href='<?php echo base_url();?>owner/dashboard_list'">
	  <a href="<?php echo base_url();?>owner/dashboard_list">
		<img src="<?php echo base_url()?>bankeauc/images/dashboard.png" alt="dashboard">	  
	    <div class="desc">Dashboard</div>
	  </a>
	</div>
	
	<div class="gallery color7" onclick="window.location.href='<?php echo base_url();?>owner/liveAuction'">
	  <a href="<?php echo base_url();?>owner/liveAuction">
		<img src="<?php echo base_url()?>bankeauc/images/participation_icon.png" alt="Participation Stage">	 
	    <div class="desc">Participation Stage</div>
	  </a>
	</div>

	<div class="gallery color7" onclick="window.location.href='<?php echo base_url();?>owner/buylistLiveAuctions'">
	  <a href="<?php echo base_url();?>owner/buylistLiveAuctions">
		<img src="<?php echo base_url()?>bankeauc/images/live_auc.png" alt="Live Auction">	 
	    <div class="desc">Live Auction</div>
	  </a>
	</div>
	<div class="gallery color7" onclick="window.location.href='<?php echo base_url();?>owner/completedAuction'">
	  <a href="<?php echo base_url();?>owner/completedAuction">
		<img src="<?php echo base_url()?>bankeauc/images/past_auc.png" alt="Completed Auction">
		<div class="desc">Completed Auction</div>
	  </a>
	  
	</div>
	
	<div class="gallery color7" onclick="window.location.href='<?php echo base_url();?>owner/myProfile'">
	  <a href="<?php echo base_url();?>owner/myProfile">
		<img src="<?php echo base_url()?>bankeauc/images/profile_icon.png" alt="Edit Profile">	  
	    <div class="desc">Edit Profile</div>
	  </a>
	</div>

	<div class="gallery color7" onclick="window.location.href='<?php echo base_url();?>owner/myProfileChangePassword'">
	  <a href="<?php echo base_url();?>owner/myProfileChangePassword">
		<img src="<?php echo base_url()?>bankeauc/images/password_change.png" alt="Change Password">	 
	    <div class="desc">Change Password</div>
	  </a>
	</div>
	
</div>
