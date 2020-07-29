<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<meta name="viewport" content="width=device-width, initial-scale=1.0" />
<title>Admin :: <?php echo isset($heading)?$heading:"Dashboard"; ?></title>
<?php $this->load->helper('url');?>
<?php define('VIEWBASE',site_url().'application/views/admin/'); ?>
<link rel="stylesheet" href="<?php echo VIEWBASE; ?>css/style.default.css" type="text/css" />
<!--<script type="text/javascript" src="<?php echo VIEWBASE; ?>js/plugins/jquery-1.7.min.js"></script>-->
<script type="text/javascript" src="<?php echo VIEWBASE; ?>js/plugins/jquery-3.2.0.min"></script>
<script type="text/javascript" src="<?php echo VIEWBASE; ?>js/plugins/jquery-ui-1.8.16.custom.min.js"></script>
<script type="text/javascript" src="<?php echo VIEWBASE; ?>js/plugins/jquery.cookie.js"></script>
<script type="text/javascript" src="<?php echo VIEWBASE; ?>js/plugins/jquery.uniform.min.js"></script>
<script type="text/javascript" src="<?php echo VIEWBASE; ?>js/custom/general.js"></script>
<!--[if lte IE 8]><script language="javascript" type="text/javascript" src="<?php echo VIEWBASE; ?>js/plugins/excanvas.min.js"></script><![endif]-->
<!--[if IE 9]>
    <link rel="stylesheet" media="screen" href="<?php echo VIEWBASE; ?>css/style.ie9.css"/>
<![endif]-->
<!--[if IE 8]>
    <link rel="stylesheet" media="screen" href="<?php echo VIEWBASE; ?>css/style.ie8.css"/>
<![endif]-->
<!--[if lt IE 9]>
	<script src="http://css3-mediaqueries-js.googlecode.com/svn/trunk/css3-mediaqueries.js"></script>
<![endif]-->
<?php
header("Cache-Control: no-cache, no-store, must-revalidate"); // HTTP 1.1.
header("Pragma: no-cache"); // HTTP 1.0.
header("Expires: 0"); // Proxies.
?>
</head>
<body>
<div class="bodywrapper">   