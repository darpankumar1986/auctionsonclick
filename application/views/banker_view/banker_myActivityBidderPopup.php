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
<section>
  <div class="row">
    <div class="wrapper-full">
      <div class="dashboard-wrapper">        
        <div class="container">          
          <div class="secttion-right" style="width:100%;">
			<div class="heading4 btmrg20">Bidder Details History</div>
          <table border="1" align="left" cellpadding="2" cellspacing="1" class="mytable dataTable" id="big_table" aria-describedby="big_table_info">
              <tbody role="alert" aria-live="polite" aria-relevant="all">
                <?php $register_As = GetTitleById('tbl_user_registration',$array_records['bidder_detail'][0]->id,'register_as'); ?>
				<tr class="odd">
                  <td width="20%" align="left" valign="top" class=""><strong>Name of Bidder</strong></td>
                  <td width="35%" align="left" valign="top" class="" >
                      <?php 
                    
                       if(GetTitleById('tbl_user_registration',$array_records['bidder_detail'][0]->id,'register_as')!='builder'){
                         echo $array_records['bidder_detail'][0]->first_name.' '.$array_records['bidder_detail'][0]->last_name;
                         }else{
                         echo  GetTitleById('tbl_user_registration',$array_records['bidder_detail'][0]->id,'organisation_name'); 
                        } 
                      ?> </td>
                </tr>
				<?php if($register_As == 'owner') { ?>
				<tr class="odd">
                  <td width="20%" align="left" valign="top" class=""><strong>Fathers/Husband Name</strong></td>
                  <td width="35%" align="left" valign="top" class="" >
				  <?php if($array_records['bidder_detail'][0]->father_name!='') {echo $array_records['bidder_detail'][0]->father_name;}else{echo 'N/A';}?></td>
                </tr>
                <?php } else{ ?>
					<tr class="odd">
						  <td width="20%" align="left" valign="top" class=""><strong>Authorized Person</strong></td>
						  <td width="35%" align="left" valign="top" class="" >
						  <?php if($array_records['bidder_detail'][0]->authorized_person!='') {echo $array_records['bidder_detail'][0]->authorized_person;}else{echo 'N/A';}?></td>
						</tr>
                <?php } ?>
                <?php 
               // echo $array_records['bidder_detail'][0]->city_id;
                $getCitname = $this->banker_model->GetCityBank($array_records['bidder_detail'][0]->city_id);
                //print_r($getCitname);
                $getCitname = $getCitname[0]->city_name;
                
                $GetStateBank = $this->banker_model->GetStateBank($array_records['bidder_detail'][0]->state_id);
                //print_r($getCitname);
                $GetStateBank = $GetStateBank[0]->state_name;
                 ?>
				<tr class="even">                 
                  <td align="left" valign="top" class=""><strong>Postal Address of Bidder(s):</strong></td>
                  <td align="left" valign="top" class=""><?php echo $array_records['bidder_detail'][0]->address1.' '.$array_records['bidder_detail'][0]->address2.' ,'.$getCitname.' ,'.$GetStateBank.' ,'.$array_records['bidder_detail'][0]->zip;?></td>
				</tr>
				
				<tr class="even">
                  <td align="left" valign="top" class=""><strong>Cell Number:</strong></td>
                  <td align="left" valign="top" class=""><?php echo $array_records['bidder_detail'][0]->mobile_no;?></td>
				</tr>
                
				<tr class="even">
                  <td align="left" valign="top" class=""><strong>Email ID:</strong></td>
                  <td align="left" valign="top" class=""><?php echo $array_records['bidder_detail'][0]->email_id;?></td>
				</tr>
				
                <tr class="odd">
                  <td align="left" valign="top" class="" colspan="2"><strong>Bank Account Details to which EMD amount to be returned</strong></td>
				</tr>
                
				<tr class="even">
					<td align="left" valign="top" class=""><strong>i) Bank A/c No.:</strong></td>
					<td align="left" valign="top" class=""><?php echo $array_records['emd_detail'][0]->account_no;?></td>
				</tr>
                
				<tr class="even">
					<td align="left" valign="top" class=""><strong>ii) IFSC Code No.:</strong></td>
					<td align="left" valign="top" class=""><?php echo $array_records['emd_detail'][0]->branch_ifsc_code;?></td>
				</tr>
                
				<tr class="even">
					<td align="left" valign="top" class=""><strong>iii) Branch Name:</strong></td>
					<td align="left" valign="top" class=""><?php echo $array_records['emd_detail'][0]->branch_add;?></td>
				</tr>
                <?php /* ?>
				<tr class="even">
					<td align="left" valign="top" class=""><strong>Date of submission of bid:</strong></td>
					<td align="left" valign="top" class="">
					<?php ?></td>
				</tr>
				<?php */ ?>
				<tr class="even">
					<td align="left" valign="top" class=""><strong>PAN Number:</strong></td>
					<td align="left" valign="top" class="">
                                        <?php if($array_records['bidder_detail'][0]->document_type=='pan_no'){ echo $array_records['bidder_detail'][0]->document_no; }?></td>
				</tr>
				<?php /* ?>
				<tr class="even">
					<td align="left" valign="top" class=""><strong>Whether EMD remitted:</strong></td>
					<td align="left" valign="top" class=""><?php ?></td>
				</tr>
				
                <tr class="odd">
                  <td align="left" valign="top" class="" colspan="2"><strong>EMD remittance details*</strong></td>
				</tr>
				
				<tr class="even">
					<td align="left" valign="top" class=""><strong>Date Of Remittance:</strong></td>
					<td align="left" valign="top" class="">
					<?php ?></td>
				</tr>
				
				<tr class="even">
					<td align="left" valign="top" class=""><strong>Name Of Bank:</strong></td>
					<td align="left" valign="top" class="">
					<?php ?></td>
				</tr>
			   
				<tr class="even">
					<td align="left" valign="top" class=""><strong>RTGS No.:</strong></td>
					<td align="left" valign="top" class="">
					<?php ?></td>
				</tr>
                
				<tr class="even">
					<td align="left" valign="top" class=""><strong>Bid Amount quoted:</strong></td>
					<td align="left" valign="top" class="">
					<?php ?></td>
				</tr>
               <?php */ ?>
                <tr class="odd">
                  <td align="left" valign="top" class="" colspan="2"><strong>*Note: Bidders are Advised to preserve the EMD Remittance Challan</strong></td>
				</tr>
				
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
