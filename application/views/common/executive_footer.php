<footer>
  <div class="wrapper">
    <ul>
      <div>Search by Bank</div>
      <li><a target="_blank"  href="/property/?bankname[]=30">SBI</a></li>
      <li><a target="_blank"  href="/property/?bankname[]=14">BOM</a></li>
      <li><a target="_blank"  href="/property/?bankname[]=12">PNB</a></li>
      <li><a target="_blank"  href="/property/?bankname[]=17">Andhra</a></li>
      <li><a target="_blank"  href="/property/?bankname[]=14">BOB</a></li>
      <li><a target="_blank"  href="/property/?bankname[]=18">Cannara</a></li>
    </ul>
    <ul>
      <div>Search by Location</div>
      <li><a target="_blank"  href="/property/?location=NCR">NCR</a></li>
      <li><a target="_blank"  href="/property/?location=Mumbai City">Mumbai</a></li>
      <li><a target="_blank"  href="/property/?location=Chennai">Chennai</a></li>
      <li><a target="_blank"  href="/property/?location=Pune">Pune</a></li>
      <li><a target="_blank"  href="/property/?location=Banglore">Banglore</a></li>
     
    </ul>
    <ul>
      <div>Search by Categories</div>
      <li><a target="_blank"  href="/property?categorySearch=Residential">Residential</a></li>
      <li><a target="_blank"  href="/property?categorySearch=Flat">Flat</a></li>
      <li><a target="_blank"  href="/property?categorySearch=Commercial">Commercial</a></li>
      <li><a target="_blank"  href="/property?categorySearch=Factory">Factory</a></li>
      <li><a target="_blank"  href="/property?categorySearch=Shop-Showroom">Shop/Showroom</a></li>
    </ul>
    <ul>
      <div>Help </div>
      <li><a target="_blank"  href="/news_listing">In the News</a></li>
      <li><a target="_blank"  href="/blog">Blog</a></li>
    </ul>
    <ul>
      <div>General</div>
	  
	  <?php 
	  $pagesArr=getStaticContentsList();
	  if($pagesArr!=0){
		  foreach($pagesArr as $page){
			  $title=str_replace("_",'-',$page->title);
			  if($page->slug!='how-it-work'){
	  ?>
	  <li><a target="_blank"  href="<?php echo base_url('page/'.$page->slug)?>"><?php echo $page->title;?></a></li>
      <?php }}} ?>
      
    </ul>
  </div>
  <div class="copyright">
    <div class="wrapper">
      <div class="float-left">Copyright 2008-2015. All Rights Reserved. | <a target="_blank"  href="/about-us">About Us</a> | <a target="_blank"  href="/terms-of-use">Terms of use</a> | <a target="_blank"  href="/privacy-policy">Privacy Policy</a></div>
      <div class="footer-social"> <span>Follow us on</span> <a target="_blank"  href="facebook.com"><img src="/images/icon_fb.png" title="facebook icon" alt="facebook icon" /></a> <a target="_blank"  href="twitter.com"><img src="/images/icon_twitter.png" title="twitter icon" alt="twitter icon" /></a> <a target="_blank"  href="linkedin.com"><img src="/images/icon_in.png" title="linkedin icon" alt="linkedin icon" /></a> <a target="_blank"  href="javascript"><img src="/images/icon_blog.png" title="blog icon" alt="blog icon" /></a> </div>
    </div>
  </div>
</footer>
</body>
</html>