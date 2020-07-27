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
<?php 
//echo "<pre>"; //print_r($emd);
//print_r($jdaPayLog);

$jdaRes = json_decode($jdaPayLog[0]->payment_response);
//echo "<pre>";print_r($jdaRes);die;
?>
<section>
  <div class="row">
    <div class="wrapper-full">
      <div class="dashboard-wrapper">        
        <div class="container">          
          <div class="secttion-right" style="width:100%;">
			<div class="heading4 btmrg20">Fee Breakdown</div>
          <table border="1" align="left" cellpadding="2" cellspacing="1" class="mytable dataTable" id="big_table" aria-describedby="big_table_info">
              <tbody role="alert" aria-live="polite" aria-relevant="all">               
				  <tr>
					<td align="left" valign="top" class=""><strong>Reference No. / UTR No.</strong></td>
					<td align="left" valign="top" class=""><strong>Fee Type</strong></td>
					<td align="left" valign="top" class=""><strong>Fee Payable</strong></td>  
					<td align="left" valign="top" class=""><strong>Fee Paid</strong></td>  
					<td align="left" valign="top" class=""><strong>Transaction Date</strong></td>
					<td align="left" valign="top" class=""><strong>Status</strong></td>
				  </tr>
				<tr class="even">
                    <td align="left" valign="top" class=""><?php echo $jdaPayLog[0]->control_number; ?></td>
                    <td align="left" valign="top" class=""><?php echo 'Bank Processing Fee'; ?></td>
                    <td align="left" valign="top" class=""><?php echo $jdaRes->mer_amount; ?></td>		                    
                    <td align="left" valign="top" class=""><?php if($jdaRes !='' && $jdaRes != NULL) { echo $jdaRes->mer_amount; } ?></td>
                    <td align="left" valign="top" class="">
						<?php 
							if($jdaRes !='' && $jdaRes != NULL) 
							{ 
								echo $resDate = str_replace('/','-',$jdaRes->trans_date);
								//echo date('d-m-Y H:i:s',strtotime($jdaRes->trans_date)); 
							} 
						?>
					</td>	                                                      
                    <td align="left" valign="top" class=""><?php if($jdaRes !='' && $jdaRes != NULL) { echo ucfirst(strtolower($jdaRes->order_status));}  ?></td>													
				</tr>		
				<?php 
				//echo "<pre>tet ";print_r($utrDetails);die;
				foreach($utrDetails as $utr)
				{									
					$emd_fee = $auction_participateFRQID = GetTitleByField('tbl_auction', "id='" . $utr->auctionID . "'", 'emd_amt');
				?>
					<tr class="even">
                    <td align="left" valign="top" class=""><?php echo $utr->utr_no; ?></td>
                    <td align="left" valign="top" class=""><?php echo ($utr->utr_type==2) ? 'EMD Fee':'Administrative Fee'; ?></td>
                    <td align="left" valign="top" class=""><?php echo ($utr->utr_type==2) ? $emd_fee:ADMINISTRATIVE_FEE; ?></td>
                    <td align="left" valign="top" class=""><?php echo ($utr->utr_type==2) ? $emd_fee:ADMINISTRATIVE_FEE; ?></td>
                    <td align="left" valign="top" class=""><?php echo date('d-m-Y H:i:s',strtotime($utr->indate)); ?></td>
                    <td align="left" valign="top" class=""><?php echo 'Entered'; ?></td>	
                    
                    												
				</tr>
				<?php
				}
				?>	
		         
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
