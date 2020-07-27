<?php
function getExtension($str) {$i=strrpos($str,".");if(!$i){return"";}$l=strlen($str)-$i;$ext=substr($str,$i+1,$l);return $ext;}
$formats = array("jpg", "png", "gif", "bmp", "jpeg", "PNG", "JPG", "JPEG", "GIF", "BMP");
if(isset($_POST) and $_SERVER['REQUEST_METHOD'] == "POST"){
 $name = $_FILES['img']['name'];
 $tmp  = $_FILES['img']['tmp_name'];
 if(strlen($name)){
  $ext = getExtension($name);
  if(in_array($ext,$formats)){
    $imgn = time().".".$ext;
	$tdate = @date('Y-m-d');
	$path = $_SERVER['DOCUMENT_ROOT']."/public/uploads/editor/".$tdate;
	$path1 = $_SERVER['HTTP_HOST']."/public/uploads/editor/".$tdate;
	if(!file_exists($path)) {
		mkdir($path, 0777);
	}
    if(move_uploaded_file($tmp, $path."/".$imgn)){
		echo "1~~"."http://".$path1."/".$imgn;
    }else{
		echo "0~~"."Uploading Failed.";
    }
   
  }else{
   echo "0~~"."Invalid Image file format.";
  }
 }else{
  echo "0~~"."Please select an image.";
  exit;
 }
}
?>
