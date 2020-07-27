<?php echo '<?xml version="1.0" encoding="UTF-8" ?>' ?>
<urlset xmlns="http://www.sitemaps.org/schemas/sitemap/0.9">
    <url>
        <loc><?php echo base_url();?></loc> 
        <changefreq>weekly</changefreq>
        <priority>1.0</priority>
    </url>
    <?php if(is_array($eventList)){?>
		<?php foreach($eventList as $event) { ?>
		<url>
			<loc><?php echo base_url().str_replace(" ","-",strtolower($event[10]))."-".str_replace(" ","-",strtolower($event[11]))."-".str_replace(" ","-",strtolower($event[4]))."-".str_replace(" ","-",strtolower($event[8]));?></loc>
			<priority>0.8</priority>
		</url>
		<?php } ?>
	<?php } ?>
    <?php if(is_array($bankList)){?>
		<?php foreach ($bankList as $bankImage) {?>
			<?php if ($bankImage->thumb_logopath!='') {?>
					<url>
						<loc><?php echo base_url().strtolower($bankImage->shortName); ?></loc>
						<priority>0.8</priority>
					</url>
			<?php } ?>
		<?php } ?>
	<?php } ?>
    <url>
        <loc><?php echo base_url();?>faq.html</loc>
        <priority>0.8</priority>
    </url>
    <url>
        <loc><?php echo base_url();?>contactus.html</loc>
        <priority>0.8</priority>
    </url>
    <url>
        <loc><?php echo base_url();?>registration/forgetpassword</loc>
        <priority>0.8</priority>
    </url>
     <url>
        <loc><?php echo base_url();?>privacy.html</loc>
        <priority>0.8</priority>
    </url>
    <url>
        <loc><?php echo base_url();?>public/uploads/Bank_E-Auctions_User_Agreement_and_Privacy_Policy.pdf</loc>
        <priority>0.8</priority>
    </url>
</urlset> 
