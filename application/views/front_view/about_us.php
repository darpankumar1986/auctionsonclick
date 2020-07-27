<section>
<div class="breadcrum">
  <div class="wrapper"> <a href="/" class="Home">Home</a>&nbsp;»&nbsp;<span>About Us</span> </div>
</div>
<div class="wrapper">
<?php
$segment = $this->uri->segment(2, 0);
?>
<div class="left-static">
<ul>
<li><a href="/page/about-us" <?php if($segment=='about-us'){?>class="active"<?php }else{}?>>About Us</a></li>
<li><a href="/page/faq" <?php if($segment=='faq'){?>class="active"<?php }else{}?> >FAQS</a></li>
<!--<li><a href="#">Help Desk</a></li>-->
<li><a href="/page/contact-us" <?php if($segment=='contact-us'){?>class="active"<?php }else{}?>>Contact Us</a></li>
</ul>

</div>

<div class="right-static">

<h1 class="heading1 heading_bor btmrg20"><?php echo $staticData->title;?></h1>
<div class="row">
<?php echo $staticData->description;?>

</div>

</div>
</div>
</section>