<!DOCTYPE HTML>
<html>
<head>
<meta charset="utf-8">
<title>bankEauction</title>
<meta name="description" content="bankEauction" />
<meta name="keywords" content="bankEauction" />
<!-- Mobile Specific Metas -->
<meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1" />
<meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
<link rel="stylesheet" href="<?php echo base_url()?>/css/bace.css">
<link rel="stylesheet" href="<?php echo base_url()?>/css/admin-style.css">
<link rel="stylesheet" href="<?php echo base_url()?>/css/nav.css">
<link rel="stylesheet" href="<?php echo base_url()?>/css/banner.css">
<script src="<?php echo base_url()?>/js/jquery.min.js"></script>
<link rel="stylesheet" href="<?php echo base_url()?>js/calender/jquery-ui.css">
<script src="<?php echo base_url(); ?>js/calender/jquery-ui.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>js/calender/jquery-ui-timepicker-addon.min.js"></script>
<link rel="stylesheet" href="<?php echo base_url()?>js/calender/jquery-ui-timepicker-addon.css">
<script type="text/javascript" src="<?php echo base_url(); ?>js/calender/i18n/jquery-ui-timepicker-addon-i18n.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/calender/jquery-ui-sliderAccess.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>/application/views/admin/js/plugins/jquery.validate.min.js"></script>
<script type="text/javascript" src="<?php echo base_url()?>/js/common.js"></script>

<!--[if IE]>
<script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
<![endif]-->
<!--[if IE]>
<script type="text/javascript" src="/js/respond.js"></script>
<![endif]-->
</head>
<body>
<?php //print_r($emdrow);?>
<section>
  <div class="row">
    <div class="wrapper-full">
      <div class="dashboard-wrapper">
        
        <div class="container">
          
          <div class="secttion-right" style="width:100%;">
			<div class="heading4 btmrg20">Uploaded Docs History</div>
          <table border="1" align="left" cellpadding="2" cellspacing="1" class="mytable dataTable" id="big_table" aria-describedby="big_table_info">
              <tbody role="alert" aria-live="polite" aria-relevant="all">
                <tr class="odd">
                  <td width="20%" align="left" valign="top" class=""><strong>SNo.</strong></td>
                  <td width="20%" align="left" valign="top" class=""><strong>File Type</strong></td>
                  <td width="20%" align="left" valign="top" class=""><strong>Description</strong></td>
                  <td width="20%" align="left" valign="top" class=""><strong>Action</strong></td>
                </tr>
                <?php $i=0;foreach($doc as $doc_detail ){?>
                <tr class="even">
                 
                  <td align="left" valign="top" class=""><?php echo ++$i?></td>
                  <td align="left" valign="top" class=""><?php  
				  echo GetTitleById('tbl_doc_master',$doc_detail->documentID,'name');?></td>
                  <td align="left" valign="top" class=""><img src="<?=base_url(); ?>public/uploads/document/<?php echo $auctionID?>/<?php echo $bidderID?>/<?php echo $doc_detail->document_name?>" ></td>
                  <td align="left" valign="top" class="">
                    <?php if($doc_detail->document_name!=''){?>
                    <a target="_blank" href="<?=base_url(); ?>public/uploads/document/<?php echo $auctionID?>/<?php echo $bidderID?>/<?php echo $doc_detail->document_name?>" download>Download</a>
                    <?php } ?>
                    </td>
                    </tr>
               <?php }?>
               
              </tbody>
             
            </table>
            
			</div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>

</body>

</html>
