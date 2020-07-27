<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title><?php echo $page_title; ?></title>
<style>
body {
	font-family:'Open Sans', Arial;
	font-size:14px; font-weight:normal!important;
	color:#000;
}
h1 {
	font-size:22px;
	color:#000;
	/*text-transform:uppercase;*/
	font-weight:normal;
	margin:0;
	/*border-bottom:1px solid #333;*/
	padding-bottom:5px;
}
h2 {
	font-size:16px;
	text-align:center;
	/*text-transform:uppercase;*/
	color:#000;
	font-weight:normal;
	margin:0;
}

h3 {
	font-size:16px;
	/*text-transform:uppercase;*/
	color:#000;
	font-weight:normal;
	margin:0;
}

td {
	padding:4px 2px;
	border-top:0px solid #dfdfdf;
	border-bottom:0px solid #dfdfdf;
	border-collapse:collapse;
	font-weight:normal;
}
.table-bor td {
	border:1px solid #ddd;
	border-collapse:collapse;
	
}

.table-bor th{ padding:4px 0px;}
thead {
	font-size:14px;
	color:#000;
	
	background-color:#ccc;
}
thead th {
	height:auto;
	padding:5px 0px;
	font-size:14px;
	font-weight:bold;
	color:#000;
	background-color:#ccc;
}
table thead tr.odd td{font-size:12px;}
table tr.odd td {
	background-color: #f3f3f3;
	border-bottom: 1px solid #ddd; 	
	padding: 8px 2px;
}
table tr.even td {
	background-color: #ffffff;
	border-bottom: 1px solid #ddd;
	padding: 8px 2px;
}
.grey_bg {
	background-color:#ccc;
}
.grey_bg2 {
	background-color:#f9f9f9;
	border:1px solid #ddd;
}
.pd-tp{ padding:4px 0px;}
.pd-tp2{ padding:10px 0px;}
</style>
<?php /* ?>
<style>
 @font-face {
    font-family: kruti;
    src: url(http://bankeauction.com/bankeauc/fonts/k010.TTF);
}
 .hindi{font-family:'kruti'; font-size:18px; color:#000;}
 
  @font-face {
    font-family: AnjaliOldLipi;
    src: url(http://bankeauction.com/bankeauc/fonts/AnjaliOldLipi.ttf);
}
 .hindi_new{font-family:'AnjaliOldLipi'; font-size:18px; color:#000;}
</style>
<?php */ ?>
</head>

<body>
<pre>
<?php //print_r($auctionData);
// print_r($BidderRankData);
?>
</pre>
    <!--<table width="980" border="0" align="center" cellpadding="0" cellspacing="0" style="background:#fff;">
        <tr>
            <td align="left" valign="top" scope="col">&nbsp;</td>
            <td align="center" valign="top" scope="col"><img width="266" src="<?php echo base_url(); ?>images/jda_logo.jpg"></td>
        </tr>
            <tr><td colspan="2"></td></tr>	
    </table>

    <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" style="background:#fff;">
        <tr class="odd">
            <td align="center" valign="top" scope="col"><h2> &nbsp;Cheque for bank</h2></td>    
        </tr>
    </table>-->
    
    <table  width="100%" border="0" align="left" cellpadding="5px" cellspacing="0" style="margin-top: 40px;">
        <tbody role="alert" aria-live="polite" aria-relevant="all">
            <tr class="">
                <td width="10%" align="left" valign="top" class="">&nbsp;</td>
                <td width="20%" align="left" valign="top" class="" style="padding-left: 10%;"><strong>A/c Payee </strong></td>
                <td width="30%" align="left" valign="top" class=""><strong><?php echo date('d-m-Y',strtotime($cRefundData->cheque_date)); ?><strong></td>
            </tr>								
            <tr class="">
                <td width="10%" align="left" valign="top" class="">&nbsp;</td>
                <td width="20%" align="left" valign="top" class=""><strong>Your Self Transfer Through RTGS/NEFT As Per List</strong></td>
                <td width="30%" align="left" valign="top" class=""><strong>XXXXXXXX<strong></td>
            </tr>
            <tr class="">
                <td width="10%" align="left" valign="top" class="" >&nbsp;</td>
                <td width="20%" align="left" valign="top" class="" style="padding-left: 5%;">
                    
                        <?php 
                            $dpart = explode('.', number_format($cRefundData->total_amt, 2))[1];
                            if($dpart > 0)
                            {
                                $paise = ' AND '.strtoupper(getAmountInWords($dpart))." PAISE";
                            }
                            else
                            {
                                $paise = '';
                            }
                        ?>
                    <strong>
                        <?php echo "RUPEES ". strtoupper(getAmountInWords($cRefundData->total_amt)).$paise.' ONLY'; ?>
                    </strong>
                </td>
                <td width="30%" align="left" valign="top" class="">&nbsp;</td>
            </tr>
            <tr class="">
                <td width="10%" align="left" valign="top" class="" >&nbsp;</td>
                <td width="20%" align="left" valign="top" class="">&nbsp;</td>
                <td width="30%" align="left" valign="top" class=""><strong>##<?php echo $cRefundData->total_amt; ?>##</strong></td>
            </tr>
        </tbody>
    </table>
   
   <!-- <table width="100%" border="0" align="center" cellpadding="0" cellspacing="0" style="background:#fff; margin-top:50px;">
        <tr>
            <td align="right" width="70%" valign="top" ><strong>AO(Payments)</strong></td>
            <td align="left" width="30%" valign="top" >&nbsp;</td>
        </tr>
        <tr>
            <td align="right" width="70%" valign="top" ><strong>JDA JAIPUR</strong></td>
            <td align="left" width="30%" valign="top" >&nbsp;</td>
        </tr>
    </table> -->
	
<!--
<br/><br/><br/><br/>
<div style="text-align:center;">
*************************Report Ended*************************
</div>
<br/><br/>
<div style="text-align:center;">
Disclaimer: This is a system generated report hence does not need any signature.
</div>
<div style="text-align:center;font-size:11px;position:absolute;bottom:20px; left: 0px;">
	<i>jda.com © Copyright <?php //echo date('Y');?> Jaipur Development Authority - All Rights Reserved</i>
	<hr/>
	<span>
		<i>Plot No. 301, First Floor, Udyog Vihar, Phase - 2, Gurgaon (HR)-122015, Tel: +91-124-4302020 Fax: +91-124-4302010 www.c1india.com</i>
	</span>
</div>
-->
</body>
</html>
<script>
    
    var words = toWords(num);
</script>