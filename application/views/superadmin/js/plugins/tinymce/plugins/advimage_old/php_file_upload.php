<?php
$targetDir = '/data/httpd_data/candid/htdocs/admin/detail';
if(is_array($_FILES)) {
if(is_uploaded_file($_FILES['imageData']['tmp_name'])) {
if(move_uploaded_file($_FILES['imageData']['tmp_name'],"$targetDir/".$_FILES['imageData']['name'])) {
echo "File uploaded successfully";
}
}
}
?>
