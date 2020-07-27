<?php header('HTTP/1.0 404 Not Found');?>
<!DOCTYPE html>
<html>
   <head>
      <meta charset="utf-8">
      <title><?php echo JDA_TITLE; ?></title>
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1">
	  <link href="<?= base_url(); ?>bankeauc/css/style.css" rel="stylesheet" type="text/css">
	  <link href="<?= base_url(); ?>bankeauc/css/responsive1.css" rel="stylesheet" type="text/css">
      <!--[if lt IE 9]>
      <script type="text/javascript" 
         src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
      <![endif]-->
      <style>
         .error_wrapper{width:100%; margin:0 auto;}
         .error_bg{width:96%; float:left; background:#fff; padding:50px 2%;}
         .error1{text-align:center; font-size:45px; color:#D01210;}
         .error2{text-align:center; font-size:22px; color:#000; line-height:40px;}
         .error3{text-align:center; font-size:14px; color:#fff; line-height:30px;}
         .bpxPadd{padding:50px 0; float:left; width:100%;}
         .btn{border:solid 1px #D01210; text-decoration:none; border-radius:0; font-size:14px; cursor:pointer; width:auto; padding:3px 10px; background:#D01210; color:#fff; }
         .logo-img {width: 82px; float: left;}
         .logo-text {font-size: 25px;  color: #c92809;   float: left;   padding: 25px 0 0 15px;}
         .logo {width: 50%;}
      </style>
   </head>
   <body>
      <header>
         <section class="container_12">
            <div class="header_top">
               <div class="logo"><img src="<?php echo base_url(); ?>bankeauc/assets/img/logo.png" class="logo-img"></a>
								<div class="logo-text"><?php echo BRAND_NAME; ?></div></div>
            </div>
         </section>
      </header>
      <section class="container_12">
         <div class="bpxPadd">
            <div class="error_wrapper">
               <div class="error_bg">
                  <div class="error1">404 error !</div>
                  <div class="error2">Sorry, this page isn’t available</div>
                  <div class="error3">The Link you followed may be broken, or the page may have been removed</div>
                  <div class="error3">Go Back to <a class="btn" href="<?php echo base_url(); ?>">Homepage</a> </div>
               </div>
            </div>
         </div>
      </section>
   </body>
</html>
