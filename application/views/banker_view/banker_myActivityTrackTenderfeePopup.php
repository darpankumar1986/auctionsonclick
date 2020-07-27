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
<?php //print_r($tenderfee);?>
<section>
  <div class="row">
    <div class="wrapper-full">
      <div class="dashboard-wrapper">
        <!--
		Array ( [0] => stdClass Object ( [id] => 74 [bidderID] => 41 [auctionID] => 19370 [bank_name] => punjab national bank [instrument_type] => 2 [instrument_date] => 2015-11-08 00:00:00 [amount] => 1000.00 [instrument_expiry_date] => 2015-11-09 00:00:00 [supporting_doc] => Desert.jpg [instrument_no] => 21 [beneficiary] => [refund_bank_name] => [branch_add] => [city] => [account_no] => [branch_ifsc_code] => [addby] => 41 [indate] => 2015-11-23 18:04:19 [updatedate] => 0000-00-00 00:00:00 ) )

-->
		
		
        <div class="container">
          
          <div class="secttion-right" style="width:100%;">
			<div class="heading4 btmrg20">Tender Fee Detail</div>
          <table border="1" align="left" cellpadding="2" cellspacing="1" class="mytable dataTable" id="big_table" aria-describedby="big_table_info">
              <tbody role="alert" aria-live="polite" aria-relevant="all">
                  <?php if(!empty($tenderfee)){ ?>
			  <?php if($tenderfee->bank_name){ ?>
                <tr class="odd">
                  <td width="20%" align="left" valign="top" class=""><strong>Bank Name</strong></td>
                  <td width="35%" align="left" valign="top" class="" ><?php echo $tenderfee->bank_name?></td>
                </tr>
			  <?php } ?>
                <?php if($tenderfee->instrument_type){ ?>
                <tr class="even">
                 
                  <td align="left" valign="top" class=""><strong>Instrument type</strong></td>
                  <td align="left" valign="top" class="">
				  <?php /* if($tenderfee->instrument_type==1)
						{ 
							 $sel="RTGS/NEFT RECIEPT";
						}elseif($tenderfee->instrument_type==2){
							$sel='DD';
						}elseif($tenderfee->instrument_type==3){
								$sel='CHALAN RECIEPT';
						}*/
							?>
				  <?php 
                  if($tenderfee->instrument_type==0){echo 'Instrument'; $type='Instrument';}
                  if($tenderfee->instrument_type==1){echo 'RTGS/NEFT RECIEPT'; $type='RTGS/NEFT RECIEPT';}
                  if($tenderfee->instrument_type==2){echo 'DD'; $type='DD';}
                  if($tenderfee->instrument_type==3){echo 'CHALAN RECIEPT'; $type='CHALAN RECIEPT';}
                  ?>
			
				  
				  <?php echo $sel?></td>
				</tr>
				 <?php } ?>
                <?php if($tenderfee->instrument_date){ ?>
                <tr class="even">
                  <td align="left" valign="top" class=""><strong><?=$type;?> date</strong></td>
                  <td align="left" valign="top" class=""><?php echo $tenderfee->instrument_date?></td>
				</tr>
				 <?php } ?>
                <?php if( $tenderfee->instrument_type==2 && $tenderfee->instrument_expiry_date){ ?>
                <tr class="even">
				<td align="left" valign="top" class=""><strong><?=$type;?> expiry date</strong></td>
                  <td align="left" valign="top" class=""><?php echo $tenderfee->instrument_expiry_date?></td>
				</tr>
				 <?php } ?>
                <?php if($tenderfee->instrument_no){ ?>
				
                <tr class="even">
				<td align="left" valign="top" class=""><strong><?=$type;?> No.</strong></td>
                  <td align="left" valign="top" class=""><?php echo $tenderfee->instrument_no?></td>
				</tr>
				 <?php } ?>
                <?php if($tenderfee->amount){ ?>
                <tr class="even">
				<td align="left" valign="top" class=""><strong>Amount</strong></td>
                  <td align="left" valign="top" class=""><?php echo $tenderfee->amount?></td>
				</tr>
				 <?php } ?>
                <?php if($tenderfee->supporting_doc){ ?>
                <tr class="even">
                 
                  <td align="left" valign="top" class=""><strong>Uploaded document</strong></td>
                  <td align="left" valign="top" class="">
		  <a target="_blank" href="<?php echo $base_url; ?>public/uploads/document/<?php echo $tenderfee->auctionID; ?>/<?php echo $tenderfee->bidderID ?>/tender_supporting_doc/<?php echo $tenderfee->supporting_doc;?>" download><?php echo $tenderfee->supporting_doc;?></a>
		 </td>
		 </tr>
		<?php } ?>
                <?php if($tenderfee->beneficiary){ ?>
                <tr class="even">
                 
                  <td align="left" valign="top" class=""><strong>Name of the beneficiary</strong></td>
                  <td align="left" valign="top" class=""><?php echo $tenderfee->beneficiary?></td>
				</tr>
				 <?php } ?>
                <?php if($tenderfee->refund_bank_name){ ?>
                <tr class="even">
                 
                  <td align="left" valign="top" class=""><strong>Refund Bank Name</strong></td>
                  <td align="left" valign="top" class=""><?php echo $tenderfee->refund_bank_name?></td>
				</tr>
				 <?php } ?>
                <?php if($tenderfee->branch_add){ ?>
                <tr class="even">
                 
                  <td align="left" valign="top" class=""><strong>Branch Address</strong></td>
                  <td align="left" valign="top" class=""><?php echo $tenderfee->branch_add?></td>
				</tr>
				 <?php } ?>
                <?php if($tenderfee->city){ ?>
                <tr class="even">
                 
                  <td align="left" valign="top" class=""><strong>City</strong></td>
                  <td align="left" valign="top" class=""><?php echo $tenderfee->city?></td>
				</tr>
				 <?php } ?>
                <?php if($tenderfee->account_no){ ?>
                <tr class="even">
                 
                  <td align="left" valign="top" class=""><strong>Account No</strong></td>
                  <td align="left" valign="top" class=""><?php echo $tenderfee->account_no?></td>
				</tr>
				 <?php } ?>
                <?php if($tenderfee->branch_ifsc_code){ ?>
                <tr class="even">
                 
                  <td align="left" valign="top" class=""><strong>Branch IFSC Code</strong></td>
                  <td align="left" valign="top" class=""><?php echo $tenderfee->branch_ifsc_code?></td>
				</tr>
                <?php } ?>
                  <?php }else{ ?>
                   <tr class="even">
                 
                  <td align="left" valign="top" class="">No Tender Fee Available</td>
                  <td align="left" valign="top" class=""> </td>
				</tr>   
                      
                <?php  }?>
               
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
