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
			<div class="heading4 btmrg20">Fee History</div>
			<?php if($emd[0]->bank_name != ""){ ?>
          <table border="1" align="left" cellpadding="2" cellspacing="1" class="mytable dataTable" id="big_table" aria-describedby="big_table_info">
              <tbody role="alert" aria-live="polite" aria-relevant="all">
                 
                <tr class="odd">
                  <td width="20%" align="left" valign="top" class=""><strong>Bank Name</strong></td>
                  <td width="35%" align="left" valign="top" class="" >
				  <?php echo $emd[0]->bank_name?></td>
                </tr>
                
                <tr class="even">
                 
                  <td align="left" valign="top" class=""><strong>Instrument type</strong></td>
                  <?php// $type='';?>
                   
                  <td align="left" valign="top" class=""><?php 
                  if($emd[0]->instrument_type==0){echo 'Instrument'; $type='Instrument';}
                  if($emd[0]->instrument_type==1){echo 'RTGS/NEFT RECIEPT'; $type='RTGS/NEFT RECIEPT';}
                  if($emd[0]->instrument_type==2){echo 'DD'; $type='DD';}
                  if($emd[0]->instrument_type==3){echo 'CHALAN RECIEPT'; $type='CHALAN RECIEPT';}
                  ?>
                </td>
				</tr>
                <tr class="even">
                 
                  <td align="left" valign="top" class=""><strong><?=$type;?> date</strong></td>
                  <td align="left" valign="top" class=""><?php echo $emd[0]->instrument_date;?></td>
				</tr>
				<?php  if($emd[0]->instrument_type==2){ ?>
					<tr class="even">
					 
					  <td align="left" valign="top" class=""><strong><?=$type;?> expiry date</strong></td>
					  <td align="left" valign="top" class=""><?php echo $emd[0]->instrument_expiry_date;?></td>
					</tr>
				<?php } ?>
                <tr class="even">
                 
                  <td align="left" valign="top" class=""><strong><?=$type;?> No.</strong></td>
                  <td align="left" valign="top" class=""><?php echo $emd[0]->instrument_no;?></td>
				</tr>
                <tr class="even">
                 
                  <td align="left" valign="top" class=""><strong>Amount</strong></td>
                  <td align="left" valign="top" class=""><?php echo $emd[0]->amount?></td>
				</tr>
                <tr class="even">                 
                  <td align="left" valign="top" class=""><strong>Uploaded document</strong></td>
                  <td align="left" valign="top" class="">
                       <?php if(isset($emd[0]->supporting_doc) && $emd[0]->supporting_doc!='0'){ ?>
                  
                    <a target="_blank" href="<?=base_url(); ?>public/uploads/document/<?php echo $auctionID?>/<?php echo $bidderID;?>/<?php echo  $emd[0]->supporting_doc?>" download>Download</a>
                    <?php }else{ ?>
                        <a>No Document available</a>
                    <?php } ?>
                      <?php /*if( $emd[0]->supporting_doc){?><a href="<?=  base_url();?>public/uploads/document/<?php echo $emd[0]->supporting_doc?>" download><?php echo $emd[0]->supporting_doc?></a><?php }else{?>No document available <?php } */ ?></td>
				</tr>               
              </tbody>             
            </table>  
            <?php }else{ ?>          
					N/A
            <?php } ?>
			</div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
</body>
</html>
