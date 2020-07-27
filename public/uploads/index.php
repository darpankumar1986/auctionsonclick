<?php

$urlArr = explode("Include",$_GET['url']);

$url = $_SERVER['DOCUMENT_ROOT']."/public/Include".$urlArr[1];

//$url=$_SERVER['DOCUMENT_ROOT']."public/uploads/images/1452488975.7235.jpg";
if(!file_exists($url))
{ //echo 'file not exist'; die();
    header('Location: ' . $_SERVER['HTTP_REFERER']);
    die;   
}else{
    //echo 'file exist'; die();
}
$extArr = explode(".",$urlArr[1]);
$folderArr = explode("/",$urlArr[1]);

if(strtolower($extArr[1]) == 'png')
{
	header('Content-type: image/png');
	header('Content-Disposition: attachment; filename="'.$folderArr[count($folderArr) - 1].'"');
	readfile($url);
	//echo file_get_contents($url);
}
else if(strtolower($extArr[1]) == 'jpeg')
{
	header('Content-type: image/jpeg');
	header('Content-Disposition: attachment; filename="'.$folderArr[count($folderArr) - 1].'"');
	readfile($url);
	//echo file_get_contents($url);
}
else if(strtolower($extArr[1]) == 'jpg')
{
	header('Content-type: image/jpg');
	header('Content-Disposition: attachment; filename="'.$folderArr[count($folderArr) - 1].'"');
	readfile($url);
	//echo file_get_contents($url);
}
else if(strtolower($extArr[1]) == 'pdf')
{
	header("Content-type:application/pdf");
	header('Content-Disposition: attachment; filename="'.$folderArr[count($folderArr) - 1].'"');
	readfile($url);
	//echo file_get_contents($url);
}
else if(strtolower($extArr[1]) == 'gif')
{
	header('Content-Description: File Transfer');
	header('Content-Type: application/octet-stream');
	header('Content-Disposition: attachment; filename="'.$folderArr[count($folderArr) - 1].'"');
	readfile($url);
	//echo file_get_contents($url);
}
else if(strtolower($extArr[1]) == 'zip')
{
	header("Content-Type: application/zip");
	header("Content-Transfer-Encoding: Binary");
	header('Content-Disposition: attachment; filename="'.$folderArr[count($folderArr) - 1].'"');
	readfile($url);
	//echo file_get_contents($url);
}
else
{
	echo '<!DOCTYPE html>
<html>
   <head>
      <meta charset="utf-8">
      <title>C1india Auctions</title>
      <meta http-equiv="X-UA-Compatible" content="IE=edge">
      <meta name="viewport" content="width=device-width, initial-scale=1">
 <link href="/bankeauc/css/style.css" rel="stylesheet" type="text/css">
<link href="/bankeauc/css/responsive1.css" rel="stylesheet" type="text/css">
      <!--[if lt IE 9]>
      <script type="text/javascript" 
         src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
      <![endif]-->
      <style>
         .error_wrapper{width:100%; margin:0 auto;}
         .error_bg{width:96%; float:left; background:#fff; padding:50px 2%;}
         .error1{text-align:center; font-size:45px; color:#2f4689;}
         .error2{text-align:center; font-size:25px; color:#2f4689;}
         .error3{text-align:center; font-size:14px; color:#2f4689; line-height:30px;}
         .bpxPadd{padding:50px 0; float:left; width:100%;}
         .btn{border:solid 1px #F44336; border-radius:0; font-size:14px; cursor:pointer; width:auto; padding:3px 10px; background:#F44336; color:#fff; }
      </style>
   </head>
   <body>
      <header>
         <section class="container_12">
            <div class="header_top">
               <div class="logo"><img src="/images/logo_new.png" width="192" height="60" alt="Bank eauctions"></div>
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
                  <div class="error3">Go Back to <a class="btn" href="/">Homepage</a> </div>
               </div>
            </div>
         </div>
      </section>
   </body>
</html>';

	die;
	header('Content-Description: File Transfer');
	header('Content-Type: application/octet-stream');
	header('Content-Disposition: attachment; filename="'.$folderArr[count($folderArr) - 1].'"');
	readfile($url);
	//echo file_get_contents($url);
}
?>
