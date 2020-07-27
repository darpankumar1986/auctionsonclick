<footer>
	  <section class="container">
	  <ul>
	   <li>ABOUT US</li>
	  <li></li>
	  </ul>
	  <ul class="half">
	   <li>USEFUL LINKS</li>
            <?php /* ?>
            <?php if($bankIdbyshortname > 0){  ?>                    
            <li><a href="<?=base_url();?>registration/signup?bi=<?php echo $bankIdbyshortname;?>">Registration</a></li>
            <?php } else { ?>
			<li><a href="<?=base_url();?>registration/signup">Registration</a></li>
		<?php } ?>
            <?php */ ?>
            <li><a href="<?php echo base_url(); ?>images/contact_us.pdf" target="_blank">Contact us</a></li>
            <li><a href="<?php echo base_url();?>home/faqs" target='_blank'>FAQs</a></li>
            <li><a href="<?php echo base_url(); ?>images/bidder_user_guide.pdf" target="_blank">Bidder Guide</a></li>
            <li><a href="http://service.jaipurjda.org/eAuction/images/BRD2014.pdf" target="_blank">Business Rule</a></li>
	  </ul>
	  <ul class="no-padding half">
	   <li>GET IN TOUCH</li>
	    <li class="icon phone"></li>
            <li class="icon mobile"></li>
            <li class="icon mail"><a href="mailto:support@jda.com?Subject=JDA" class="link" target="_top"></a></li>
	  </ul>
     </section>
	          <p><span>© aCopyright 2017 Jaipur Development Authority - All Rights Reserved</span> <br><!--<span><a href="<?php echo base_url();?>public/uploads/Bank_E-Auctions_User_Agreement_and_Privacy_Policy.pdf" target="_blank">Terms of Use</a></span> --></p>

	  </footer>
      <script>
         $(document).ready(function(){
         	$('#menu').slicknav();
         });
         $("#logo-slider").flexisel({
                 visibleItems: 6,
                 itemsToScroll: 1,         
                 autoPlay: {
                     enable: true,
                     interval: 5000,
                     pauseOnHover: true
                 }        
             });
      </script>
   </body>
</html>
