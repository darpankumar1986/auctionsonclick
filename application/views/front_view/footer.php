<?php if(!MOBILE_VIEW){ ?>
<!-- FOOTER -->
	<footer>
		<!-- CONTAINER -->
		<div class="container">
			<!-- ROW -->
			<div class="row">
				<div class="col-lg-4 col-md-4 col-sm-6 padbot30">
					<h4><b>Important </b> Links</h4>
					
					<div class="recent_posts_small clearfix">
						<div class="post_item_content_small">
							<a class="title" href="<?php echo base_url();?>assets/front_view/images/bidder_manual.pdf" target="_blank">Bidder Manual</a>
						</div>
					</div>
					<!--<div class="recent_posts_small clearfix">
						<div class="post_item_content_small">
							<a class="title" href="<?php echo base_url();?>bankeauc/DSC_Browser_Plugin/c1-browser-plugin-setup.exe">Download DSC Plugin</a>
						</div>
					</div>					-->
					<div class="recent_posts_small clearfix">
						<div class="post_item_content_small">
							<a class="title" href="<?php echo base_url();?>registration/signup" >Registration</a>
						</div>
					</div>
					
					<!--<div class="recent_posts_small clearfix">
						<div class="post_item_content_small">
							<a class="title" href="<?php echo base_url();?>home/faqs" >FAQs</a>
						</div>
					</div>-->
					<div class="recent_posts_small clearfix">
						<div class="post_item_content_small">
							<a class="title" href="<?php echo base_url();?>home/contactus" >Contact us</a>
						</div>
					</div>
				</div>
				
				<div class="col-lg-4 col-md-4 col-sm-6 padbot30 foot_about_block">
					<h4><b>About</b> us</h4>
					<p>We value people over profits, quality over quantity, and keeping it real. As such, we deliver an unmatched working relationship with our clients.</p>
					<!--<p>Our team is intentionally small, eclectic, and skilled; with our in-house expertise, we provide sharp and</p>-->
					<ul class="social">
						<li><a href="javascript:void(0);" ><i class="fa fa-twitter"></i></a></li>
						<li><a href="javascript:void(0);" ><i class="fa fa-facebook"></i></a></li>
						<li><a href="javascript:void(0);" ><i class="fa fa-google-plus"></i></a></li>
						<li><a href="javascript:void(0);" ><i class="fa fa-pinterest-square"></i></a></li>
						<li><a href="javascript:void(0);" ><i class="map_show fa fa-map-marker"></i></a></li>
					</ul>
				</div>
				
				<div class="respond_clear"></div>
				<?php /* ?>
				<div class="col-lg-4 col-md-4 padbot30">
					<h4><b>Contacts</b> Us</h4>
					
					<!-- CONTACT FORM -->
					<div class="span9 contact_form">
						<div id="note"></div>
						<div id="fields">
							<form id="contact-form-face" class="clearfix" action="#">
								<input type="text" name="name" value="Name" onFocus="if (this.value == 'Name') this.value = '';" onBlur="if (this.value == '') this.value = 'Name';" />
								<textarea name="message" onFocus="if (this.value == 'Message') this.value = '';" onBlur="if (this.value == '') this.value = 'Message';">Message</textarea>
								<input class="contact_btn" type="submit" value="Send message" />
							</form>
						</div>
					</div><!-- //CONTACT FORM -->
				</div>
				<?php */ ?>
			</div><!-- //ROW -->
		</div><!-- //CONTAINER -->
	</footer><!-- //FOOTER -->
	
<?php } ?>	
	

</div>
 <script type="text/javascript">
                  $(document).ready(function(){
                      $("select").change(function(){
                          $(this).find("option:selected").each(function(){
                              if($(this).attr("value")=="banker"){
                                  $(".box").not(".banker").hide();
                                  $(".banker").show();
                              }           
                              else{
                                  $(".box").hide();
                              }
                          });
                      }).change();
                  });
                  $(document).ready(function(e){
                  $('.search-panel .dropdown-menu').find('a').click(function(e) {
                  e.preventDefault();
                  var param = $(this).attr("href").replace("#","");
                  var concept = $(this).text();
                  $('.search-panel span#search_concept').text(concept);
                  $('.input-group #search_param').val(param);
                  });
                  });
               </script>
</body>
</html>
