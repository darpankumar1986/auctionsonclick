<!--Start: Added by Aziz For Popup -->
 <script src="<?php echo base_url(); ?>js/banker.js"></script> 
<!--End: Added by Aziz For Popup -->
<link rel="stylesheet" href="<?php echo base_url(); ?>css/colorbox.css" />
<link rel="stylesheet" href="<?php echo base_url(); ?>bankeauc/css/tables.css" />
<script src="<?php echo base_url(); ?>js/jquery.colorbox.js"></script>

<script	src="<?php echo base_url()?>bankeauc/DSC_Browser_Plugin/js/resources/jquery.dataTables.min.js"></script>
<script	src="<?php echo base_url()?>js/dsc.js"></script>

<?php //echo '<pre>'; print_r($auction_data->dsc_enabled);die; 
$action  = (isset($_GET['action'])) ? $_GET['action'] : 0;

?>

<?php if($auction_data->dsc_enabled == 1){ ?>
<script type="text/javascript">
var certSerialNo = null;
jQuery( document ).ready(function($) {	
var certtype = 'DS';
var table =$('#certlist').dataTable( {
"ajax": {
"url": pluginURL+"/certificate/list?certtype="+certtype,
"type": "POST",
},
"columns": [
{ "data": "AliasName" },
{ "data": "IssuedBy" },
{ "data": "SerialNo" },
{ "data": "ExpDate" },
{ "data": "IssuerDetail" }
],
"bFilter": false,
"paging": false,
"autoWidth": true
} );
$('#certlist tbody').on( 'click', 'tr', function () {
if ( $(this).hasClass('selected') ) {
$(this).removeClass('selected');
}
else {
table.$('tr.selected').removeClass('selected');
var row =  $(this).addClass('selected');

// alert(table.api().cell( row, 0 ).data());
if(document.getElementById("selectedCertificate")!=null){
window.document.getElementById("selectedCertificate").value=table.api().cell( row, 0 ).data(); 
window.document.getElementById("SerialNo").value=table.api().cell( row, 2 ).data(); 
}
else{
certSerialNo=table.api().cell( row, 0 ).data();
SerialNo=table.api().cell( row, 2 ).data();
}          
}
} );
});
</script>
<?php } ?>
<style>
.form_bg{width:98%; float:left; background:#fff; padding:5px 1%; border-radius:5px; }
.datagrid table {width:100%; border:solid 1px #ccc;}
table.dataTable thead th {border-right: solid 1px#ccc;  padding:10px 2%;   font-size: 12px;}
table.dataTable thead th:last-child {border-right: none;}
.datagrid table tbody td{border-right: solid 1px#ccc;}
.datagrid table tbody td:last-child{border-right: none;}
.datagrid table tbody td {font-size:9px; word-wrap:break-word; cursor:pointer;     word-break: break-all; }
.dataTables_info{float:left; font-size:10px;}
.btn{ margin:0 0; border-radius:0; font-size:12px; padding: 3px 10px!important; color:#fff;     background: #0c7e99;}
.selected{background:#cccccc !important;}
.row-custom{width:100%; float:left; background:#fff; padding:0 1%; text-align:center;}
</style>
<script>
jQuery(document).ready(function ($) {
$(".check_dsc").colorbox({inline:true, width:"50%"});

$(".upload_doc_iframe").colorbox({iframe: true, width: "50%", height: "70%", onClosed: function () {
location.reload(true);
}});
$(".iframe").colorbox({iframe: true, width: "70%", height: "100%", onClosed: function () {
location.reload(true);
}});
$(".iframe_paytenderfee").colorbox({iframe: true, width: "56%", height: "70%", onClosed: function () {
location.reload(true);
}});
$(".inline_auctiondetail").colorbox({inline: true, width: "65%", onClosed: function () {
location.reload(true);
}});

});
/*
jQuery(function() {
jQuery('.help-icon').tooltip();
});*/
</script>
<style>
table td {
padding: 5px;
border-right: 1px solid #A5A5A5;
vertical-align: middle;
}
table{border-collapse:collapse;}
</style>
<div style='display:none'>
<div id="form_bg" class="form_bg">
<div class="grid_border">
<div class="datagrid">
<table id="certlist" class="display" class="cell-border wid_60">
<thead >
<tr>
<th style="max-width:30%">AliasName</th>
<th style="max-width:30%">IssuedBy</th>
<th style="max-width:10%">SerialNo</th>
<th style="max-width:5%">ExpDate</th>
<th style="max-width:25%">IssuerDetail</th>
</tr>
</thead>
</table>
<div class="row-custom"><button id="button" onclick="checkDSC(<?php echo $auction_id; ?>);" class="btn">select certificate</button></div>
</div>
</div>
</div>
</div>
<section class="container_12">
<?php //echo $breadcrumb;?>
<div class="container_12">
<div class="wrapper-full">
<div class="dashboard-wrapper">
<div id="tab-pannel6" class="btmrgn">
<div class="tab_container6"> 

<!---- buy tab container start ---->
<div id="tab1" class="tab_content6" style="display:block">
<div id="tab-pannel3" class="btmrgn">
<div class="tab_container3 whitebg"> 


<!-- Sell > My Activity start -->

<div id="tab6" class="tab_content3">
<div class="container">
<?php //echo $leftsidebar; ?>
	<div class="secttion-right">
		<div class="show_details"><?php //echo $heading;  ?> <a class='inline_auctiondetail green-more float-right show_details' href="#inline_content" >Show Auction Details</a></div>
		<div class="table-wrapper btmrg20">
		<div class="table-heading btmrg">
		<div class="box-head"><?php echo $heading ?></div>
		<!--<div class="srch_wrp2">
		<input type="text" value="Search" id="search" name="search">
		<span class="ser_icon"></span> </div>-->
	</div>

<div class="row"  style="display:none;">
	<div id="inline_content">
	<div class="heading4 btmrg20">Auction Detail</div>	
<table border="1" align="left" cellpadding="2" cellspacing="1" class="mytable dataTable" id="big_table" aria-describedby="big_table_info">
<tbody role="alert" aria-live="polite" aria-relevant="all">
         
    <tr class="even">                  
            <td align="left" valign="top" class="" width="25%"><strong>Auction No. </strong></td>
            <td align="left" valign="top" class="" width="25%"><?php echo $auction_data->id?></td>
            <td align="left" valign="top" class="" width="25%"><strong>Institution</strong></td>
            <td align="left" valign="top" class="" width="25%">
            <?php
                echo GetTitleByField('tblmst_account_type', "account_id='".$auction_data->account_type_id."'" ,'account_name');
            ?>  
            </td>
        </tr>
        
        <tr class="odd">
            <td align="left" valign="top" class=""><strong>Property ID</strong></td>
            <td align="left" valign="top" class=""><?php echo $auction_data->reference_no?></td>
            <td align="left" valign="top" class=""><strong>Auction Reference Dispatch Date</strong></td>
            <td align="left" valign="top" class=""><?php echo (($auction_data->dispatch_date != '1970-01-01') && ($auction_data->dispatch_date != '0000-00-00')) ? date('d-m-Y', strtotime($auction_data->dispatch_date)) : 'N/A'; ?></td>
        </tr>
        
        <tr class="even">
            <td align="left" valign="top" class=""><strong>Property Address</strong></td>
            <td align="left" valign="top" class=""><?php echo strtoupper($auction_data->PropertyDescription);?></td>
            <td align="left" valign="top" class=""><strong>Carpet Area</strong></td>
            <td align="left" valign="top" class=""><?php echo ($auction_data->area != '')?$auction_data->area:'N/A';?></td>
        </tr>

        <tr class="odd">
            <td align="left" valign="top" class=""><strong>Carpet Area Unit</strong></td>
            <td align="left" valign="top" class="">
            <?php
				$cauom = GetTitleByField('tblmst_uom_type', "uom_id='".$auction_data->area_unit_id."'" ,'uom_name');
                echo ($cauom !='')?$cauom:'N/A';
            ?>  
            </td>
            <td align="left" valign="top" class=""><strong>Category/ Property Type</strong></td>
            <td align="left" valign="top" class="">
            <?php
            echo GetTitleByField('tbl_category', "id='".$auction_data->category_id."'" ,'name');
            ?>
            </td>
        </tr>
         <tr class="even">
            <td align="left" valign="top" class=""><strong>Plot Area</strong></td>
            <td align="left" valign="top" class=""><?php echo ($auction_data->property_height != '')?$auction_data->property_height:'N/A';?></td>
            <td align="left" valign="top" class=""><strong>Plot Area Unit</strong></td>
            <td align="left" valign="top" class="">
            <?php
				$cauom = GetTitleByField('tblmst_uom_type', "uom_id='".$auction_data->height_unit_id."'" ,'uom_name');
                echo ($cauom !='')?$cauom:'N/A';
            ?>  
            </td>
        </tr>
        <tr class="even">
            
            <td align="left" valign="top" class=""><strong>Corner</strong></td>
            <td align="left" valign="top" class=""><?php echo ($auction_data->is_corner_property == 1) ? 'Yes' : 'No'; ?>
            </td>
            <td align="left" valign="top" class=""><strong>Scheme Id</strong></td>
            <td align="left" valign="top" class=""><?php echo ($auction_data->scheme_id)? $auction_data->scheme_id: 'N/A';?></td>
        </tr>
        
        <tr class="odd">
            
            <td align="left" valign="top" class=""><strong>Scheme Name</strong></td>
            <td align="left" valign="top" class=""><?php echo ($auction_data->scheme_name)? $auction_data->scheme_name: 'N/A';?></td> 
            <td align="left" valign="top" class=""><strong>Name of Owner/ Occupier as per MCG record</strong></td>
            <td align="left" valign="top" class=""><?php echo ($auction_data->service_no)? $auction_data->service_no: 'N/A';?></td>
        </tr>
        
        <tr class="even">
            
            <td align="left" valign="top" class=""><strong>Concerned Zone</strong></td>
            <td align="left" valign="top" class="">
            <?php
            echo GetTitleByField('tbl_zone', "zone_id='".$auction_data->zone_id."'" ,'zone_name');
            ?>
            </td> 
            <td align="left" valign="top" class=""><strong>Applicable FAR</strong></td>
            <td align="left" valign="top" class=""><?php echo ($auction_data->far)? $auction_data->far: 'N/A';?></td>
        </tr>
        
        <tr class="odd">
            
            <td align="left" valign="top" class=""><strong>Plot Area</strong></td>
            <td align="left" valign="top" class=""><?php echo ($auction_data->property_height)? $auction_data->property_height: 'N/A';?></td>  
            <td align="left" valign="top" class=""><strong>Plot Area Unit</strong></td>
            <td align="left" valign="top" class="">
            <?php
                $height_unit = GetTitleByField('tblmst_height_uom_type', "height_uom_id='".$auction_data->height_unit_id."'" ,'height_uom_name');
                if($height_unit != ''){
                    echo $height_unit;
                }else{
                    echo "N/A";
                }
            ?>
            </td>
        </tr>
        
        <tr class="even">
            
            <td align="left" valign="top" class=""><strong>Max Coverage Area</strong></td>
            <td align="left" valign="top" class=""><?php echo ($auction_data->max_coverage_area)? $auction_data->max_coverage_area: 'N/A';?></td> 
            <td align="left" valign="top" class=""><strong>Reserve Price</strong></td>
            <td align="left" valign="top" class="">
                <?php echo number_format($auction_data->reserve_price, 2); ?>&nbsp;&nbsp;&nbsp;( <?php echo getAmountInWords((int)$auction_data->reserve_price); ?> )
            </td>
        </tr>
        
        <tr class="odd">
            
            <td align="left" valign="top" class=""><strong>Reserve Price (Unit)</strong></td>
            <td align="left" valign="top" class=""><?php
                echo GetTitleByField('tblmst_uom_type', "uom_id='".$auction_data->unit_id_of_price."'" ,'uom_name');
            ?> 
            </td>  
            <td align="left" valign="top" class=""><strong>EMD Amount</strong></td>
            <td align="left" valign="top" class="">
                <?php echo number_format($auction_data->emd_amt, 2); ?>  (<?php echo getAmountInWords($auction_data->emd_amt); ?> )
            </td>
        </tr>
        
         <?php /* ?><tr class="odd">
            
            <td align="left" valign="top" class=""><strong>Administrative Fee</strong></td>
            <td align="left" valign="top" class=""><?php
                echo ADMINISTRATIVE_FEE;
            ?> 
            </td>  
            <td align="left" valign="top" class="">-</td>
            <td align="left" valign="top" class="">-</td>
        </tr><?php */ ?>
        
        <tr class="even">
            
            <td align="left" valign="top" class=""><strong>Bank Processing Fee</strong></td>
            <td align="left" valign="top" class=""><?php echo $auction_data->tender_fee;?>
            </td>
            <td align="left" valign="top" class=""><strong>Press Release Date</strong></td>
            <td align="left" valign="top" class="">
            <?php echo date("d-m-Y",strtotime($auction_data->press_release_date));?>
            </td>
        </tr>
        
        
        <tr class="odd">
            
            <td align="left" valign="top" class=""><strong>Site Visit Start Date</strong></td>
            <td align="left" valign="top" class="">
                <?php echo (($auction_data->inspection_date_from != '1970-01-01') && ($auction_data->inspection_date_from != '0000-00-00 00:00:00')) ? date('d-m-Y', strtotime($auction_data->inspection_date_from)) : 'N/A'; ?>
            </td> 
            <td align="left" valign="top" class=""><strong>Site Visit End Date</strong></td>
            <td align="left" valign="top" class="">
                <?php echo (($auction_data->inspection_date_to != '1970-01-01') && ($auction_data->inspection_date_to != '0000-00-00 00:00:00')) ? date('d-m-Y', strtotime($auction_data->inspection_date_to)) : 'N/A'; ?>
            </td>
        </tr>
        <tr class="even">
            
            <td align="left" valign="top" class=""><strong>Apply And EMD Start Date</strong></td>
            <td align="left" valign="top" class="">
                <?php echo date("d-m-Y H:i",strtotime($auction_data->registration_start_date));?>
            </td> 
            <td align="left" valign="top" class=""><strong>Apply And EMD End Date</strong></td>
            <td align="left" valign="top" class="">
                <?php echo date("d-m-Y H:i",strtotime($auction_data->bid_last_date));?>
            </td>
        </tr>
        <tr class="odd">
            
            <td align="left" valign="top" class=""><strong>Auction Start date</strong></td>
            <td align="left" valign="top" class="">
                <?php echo date("d-m-Y H:i",strtotime($auction_data->auction_start_date));?>
            </td> 
            <td align="left" valign="top" class=""><strong>Auction End date</strong></td>
            <td align="left" valign="top" class="">
                <?php echo date("d-m-Y H:i",strtotime($auction_data->auction_end_date));?>
            </td> 
        </tr>
        
        <tr class="even">
            
             
            <td align="left" valign="top" class=""><strong>Mode of Bid</strong></td>
            <td align="left" valign="top" class="">
               <?php echo ($auction_data->mode_of_bid == 'online') ? 'Online' : 'Offline'; ?>
            </td>
             
            <td align="left" valign="top" class=""><strong>Is DSC Enabled </strong></td>
            <td align="left" valign="top" class="">
                <?php echo ($auction_data->dsc_enabled == 1) ? "Yes" : "No" ?>
            </td> 
        </tr>
        
        
         <tr class="odd">
           
            <td align="left" valign="top" class=""><strong>Auto Bid Allow</strong></td>
            <td align="left" valign="top" class="">
                <?php echo ($auction_data->allow_auto_bid == 1) ? "Yes" : "No" ?>
            </td>
            
            <td align="left" valign="top" class=""><strong>Bid Increment value</strong></td>
            <td align="left" valign="top" class="">
                <?php echo $auction_data->bid_inc;?>
            </td>  
        </tr>
        
        <tr class="even">
            
             <td align="left" valign="top" class=""><strong>Auto Extension time </strong>(In Minutes.)</td>
            <td align="left" valign="top" class=""><?php echo ($auction_data->auto_extension_time != '0') ? $auction_data->auto_extension_time : "0"; ?>
            </td>
            
            <td align="left" valign="top" class=""><strong>Auto Extension(s)</strong></td>
            <td align="left" valign="top" class="">                
                <?php echo ($auction_data->auto_extension_time >0 && $auction_data->no_of_auto_extn == '0') ? "Unlimited": $auction_data->no_of_auto_extn; ?>
            </td> 
        </tr>
        <tr class="odd">
        
             <td align="left" valign="top" class=""><strong>How to Reach</strong></td>
            <td td align="left" valign="top" class=""><a target="_blank" href="<?php echo base_url().'owner/viewGoogleMap/'. $auction_data->id;?>">View</a></td>
             
             <td align="left" valign="top" class=""><strong>1st Contact Person Details</strong></td>
            <td align="left" valign="top" class=""><?php echo $auction_data->contact_person_details_1;?></td>
            
      </tr>
        </tr>
        
        <tr class="even">
           
            <td align="left" valign="top" class=""><strong>2nd Contact Person Details</strong></td>
            <td align="left" valign="top" class=""><?php echo ($auction_data->contact_person_details_2)? $auction_data->contact_person_details_2: 'N/A';?></td>  
            <td align="left" valign="top" class=""><strong>Any Documents Pertinent To The Auction</strong></td>
                 <td align="left" valign="top" class="">

             <?php
             if ($auction_data->doc_to_be_submitted) {
                 $docArr = explode(",", $auction_data->doc_to_be_submitted);
                 if (count($docArr)) {
                 $docnameArr = array();
                 foreach ($docArr as $docID) {
                 $docnameArr[] = GetTitleById('tbl_doc_master', $docID);
                 }
                 }
                 }else{
                     echo "None";
                 }
                 if (count($docnameArr)) {
                 echo implode(', ', $docnameArr);
             }

             ?>

            </td>
        </tr>
        
        <tr class="odd">
           
            
            <td align="left" valign="top" class=""><strong>View Documents</strong></td>
            <td align="left" valign="top" class="">
                <?php if(is_array($uploadedDocs) && count($uploadedDocs)>0){	
		echo '<a target="_blank" href="'.base_url().'owner/viewEventDocuments/' . $uploadedDocs[0]->auction_id . '"  >View</a>';
		} else {
		echo "N/A";
		}
		?>
            </td>
            <td align="left" valign="top" class=""><strong>Remark</strong></td>
            <td align="left" valign="top" class="">
                <?php echo ($auction_data->remark)? $auction_data->remark: 'N/A';?>
                
            </td>
        </tr>
        
        <tr class="even">
         
            <td align="left" valign="top" class=""><strong>Auction Created by</strong></td>
        <td align="left" valign="top" class="">
            <?php
                  /*$sales_executive_id=GetTitleByField('tbl_event_log_sales', "id='".$auction_data->eventID."'" ,'sales_executive_id');				
                  echo  GetTitleByField('tbl_user_registration', "id='".$sales_executive_id."'" ,'first_name');
                  echo " ";
                  echo  GetTitleByField('tbl_user_registration', "id='".$sales_executive_id."'" ,'last_name');*/

                  $sales_executive_id=GetTitleByField('tbl_auction', "id='".$auction_data->id."'" ,'first_opener');				
                  echo  ucfirst(GetTitleByField('tbl_user', "id='".$sales_executive_id."'" ,'first_name'));
                  echo " ";
                  echo ucfirst(GetTitleByField('tbl_user', "id='".$sales_executive_id."'" ,'last_name'));
            ?>
          </td>	
          <td align="left" valign="top" class=""><strong>Auction Approved by</strong></td>
          <td align="left" valign="top" class="">
            <?php
                  /*$sales_executive_id=GetTitleByField('tbl_event_log_sales', "id='".$auction_data->eventID."'" ,'sales_executive_id');				
                  echo  GetTitleByField('tbl_user_registration', "id='".$sales_executive_id."'" ,'first_name');
                  echo " ";
                  echo  GetTitleByField('tbl_user_registration', "id='".$sales_executive_id."'" ,'last_name');*/

                  $approver_id = GetTitleByField('tbl_auction', "id='".$auction_data->id."'" ,'second_opener');				
                  echo  ucfirst(GetTitleByField('tbl_user', "id='".$approver_id."'" ,'first_name'));
                  echo " ";
                  echo  ucfirst(GetTitleByField('tbl_user', "id='".$approver_id."'" ,'last_name'));
            ?>
          </td>
        </tr>
     
</tbody>

</table>
</div>
</div>

<div class="seprator btmrg20"></div>

<div style="text-align:center;" id="spMsg"></div>
<?php if (isset($this->session->userdata['flash:old:message'])) { ?>
<div class="success_msg"> <?php echo @$this->session->userdata['flash:old:message']; ?></div>
<?php } ?>
<?php if (isset($this->session->userdata['flash:old:message_new'])) { ?>
<div class="fail_msg"> <?php echo @$this->session->userdata['flash:old:message_new']; ?></div>
<?php } ?>


<div style="min-height: 0px; display: block;" class="box-content no-pad">
<form name="quote_price_submit" id="quote_price_submit" action="<?php echo base_url(); ?>owner/saveFrqParticipate/" method="post">
<input type="hidden" name="<?php echo $this->security->get_csrf_token_name(); ?>" value="<?php echo $this->security->get_csrf_hash();?>" />
<div id="dt1_wrapper" class="dataTables_wrapper" role="grid">
	<div class="fg-toolbar ui-toolbar ui-corner-tl ui-corner-tr ui-helper-clearfix">
		<div class="box-content no-pad">
			<div class="container-outer">
				<div class="container-inner">
					<table id="big_table" width="100%" border="1" cellpadding="2" cellspacing="1" class="display mytable dataTable" aria-describedby="big_table_info">					
						<tbody>
						<?php
							$fs = GetTitleByField('tbl_auction_participate', "auctionID='" . $auction_id . "' AND bidderID='" . $bidderid . "'", 'final_submit');
							$jda_payment_status = GetTitleByField('tbl_jda_payment_log', "auction_id='" . $auction_id . "' AND bidder_id='" . $bidderid . "' order by payment_log_id DESC", 'payment_status');
							//echo $jda_payment_status;
						?>
							<tr class="even">
								<td align="left" valign="top" class=" sorting_1">1</td>
								<td align="left" valign="top" class="participate_heading">Bank Processing Fee </td>
								<td align="left" valign="top" class="">
									<?php		
									//echo $emd_paid.' | '.$jda_payment_status;die;
									if ($emd_paid != 'success' && $jda_payment_status != 'success') {
										 ?>
									<a class='green_link' href="<?php echo base_url(); ?>owner/payAmt/<?php echo $bidderid; ?>/<?php echo $auction_id; ?>/emd">Pay Now</a><!--  <input type="button" class="b_submit float-right button_grey" name="" value="Pay Now" />  target="_blank"-->
									<?php }
									else
									{
										echo '--';
									}
									 ?>
								</td>
								<td align="left" valign="top" class="bold_txt">
								<?php 
									if($jda_payment_status =='pending' && $jdaRes->ChallanPaymentRequest[0]->PaymentMode == 'UTR')
									{ ?>
										<a class='emd_detail_iframe' href="<?php echo base_url(); ?>owner/emdDetailPopupData/<?php echo $bidderid;?>/<?php echo $auction_id;?>"><?php echo ucwords($jda_payment_status); ?></a>                
								 <?php   }else{
										if ($emd_paid == 'success' || $jda_payment_status == 'success') { 
											$emd_paid_status=1;
											?>
											<a class='emd_detail_iframe' href="<?php echo base_url(); ?>owner/emdDetailPopupData/<?php echo $bidderid;?>/<?php echo $auction_id;?>"><?php echo ucfirst(strtolower($jda_payment_status)); ?></a>                
									  <?php  } else {
											echo "Not Paid";
											$emd_paid_status=0;
										}
									}
								?> 
								<input type="hidden" id="emd_amount_paid" value="<?php echo $emd_paid_status;?>">
								</td>
								 <?php if($jda_payment_status =='pending' && $jdaRes->ChallanPaymentRequest[0]->PaymentMode == 'UTR' && $fs !=1) { ?>
								<td align="left" valign="top" class="bold_txt">			
										<a href="<?php echo base_url();?>owner/voidLastPayment/<?php echo $bidderid;?>/<?php echo $auction_id;?>" onclick="return confirm('Are you sure you wish to void your previously registered payment & Initiate Payment again?');" ><input type="button" class="b_submit float-right button_grey" name="" value="Void Previous Payment" /></a>                
								</td>
								<?php }?>								
							</tr>
						<?php /* ?>
						<tr class="">
							<td align="left" valign="top" class=" sorting_1">2</td>
							<td align="left" valign="top" class="participate_heading">Administrative Fee</td>
							<td align="left" valign="top" class="">
								<?php if($fs !=1) {?>
								<a class='upload_doc_iframe green_link' href="<?php echo base_url();?>owner/owner_submit_administrative_fee/<?php echo $bidderid; ?>/<?php echo $auction_id; ?>"><input type="button" class="b_submit float-right button_grey" name="" value="Submit" /></a>
								<?php } else { echo '--';}?>
								</td>
							<td align="left" valign="top" class="bold_txt">	
								<?php
									if ($administrative_utr_paid) {
										echo "Submitted";
									} else {
										echo "Not Submitted";
									}
								?>	
							</td>
						</tr>
						<?php */ ?>
						<tr class="">
							<td align="left" valign="top" class=" sorting_1">2</td>
							<td align="left" valign="top" class="participate_heading">EMD Fee</td>
							<td align="left" valign="top" class="">
								<?php if($fs !=1) {?>
								<a class='upload_doc_iframe green_link' href="<?php echo base_url();?>owner/owner_submit_emd_fee/<?php echo $bidderid; ?>/<?php echo $auction_id; ?>"><input type="button" class="b_submit float-right button_grey" name="" value="Submit" /></a>
								<?php } else { echo '--';}?>
								</td>
							<td align="left" valign="top" class="bold_txt">	
								<?php
									if ($emd_utr_paid) {
										echo "Submitted";
									} else {
										echo "Not Submitted";
									}
								?>	
							</td>
						</tr>						
						
						<?php if($doc_to_be_submitted != 0){ ?>

						<tr class="odd">
							<td align="left" valign="top" class=" sorting_1">3</td>
							<td align="left" valign="top" class="participate_heading">Documents</td>
							<td align="left" valign="top" class="">
								<?php if($fs !=1) {?>
								<a class='upload_doc_iframe green_link' href="<?php echo base_url();?>owner/submitDocument/<?php echo $bidderid; ?>/<?php echo $auction_id; ?>"><input type="button" class="b_submit float-right button_grey" name="" value="Upload Doc" /></a></td>
								<?php } else { echo '--';}?>
							<td align="left" valign="top" class="bold_txt">	
								<?php
									if ($documents_paid) {
										echo "Uploaded";
									} else {
										echo "Not Uploaded";
									}
								?>	
							</td>
						</tr>
						<?php	} ?>
						<?php
							if ($documents_paid || $doc_to_be_submitted == 0) {
								$doc_uploaded_status=1;
							} else {
								$doc_uploaded_status=0;
							}
						?>
						
						
						<input type="hidden" id="document_uploaded" value="<?php echo $doc_uploaded_status; ?>">						
						<input type='hidden' maxlength="30" name="quote_price" value="not_application" id="quote_price">
						</tbody>
					<tfoot>
					<tr>
					<th colspan="4"></th>
					</tr>
					</tfoot>
					</table>
					
				<div class="button-row tpmrg20">
					<input name="documents_paid" id="documents_paid"  value="<?php
					if ($documents_paid > 0 || $doc_to_be_submitted == 0) {
					echo $saveval = 1;
					} else {
					echo $saveval = '';
					}
					?>" type="hidden">
					
					<input name="emd_utr_paid" id="emd_utr_paid"  value="<?php	if ($emd_utr_paid > 0) {echo $saveval = 1;} else {echo $saveval = '';}	?>" type="hidden">					
					<input name="administrative_utr_paid" id="administrative_utr_paid"  value="<?php	if ($administrative_utr_paid > 0) {echo $saveval = 1;} else {echo $saveval = '';}	?>" type="hidden">	
					<?php
					$alaise_name = GetTitleByField('tbl_auction_participate', "auctionID='" . $auction_id . "' AND bidderID='" . $bidderid . "'", 'alaise_name');
					?>
					<input type="hidden" value="<?php echo $alaise_name; ?>" name="alaise_name" id="alaise_name">

					<input type="hidden" value="<?php echo $auction_participateID; ?>" name="auction_participateID" id="auction_participateID">

					<input type="hidden" value="<?php echo $auction_participateFRQID; ?>" name="auction_participateFRQID" id="auction_participateFRQID">

					<input name="emd_paid" id="emd_paid" value="1" type="hidden"> <?php //if ($emd_paid == 'success') {echo $saveval = 1;} else {echo $saveval = '';} ?>

					<input name="auction_id" id="auction_id" type="hidden" value="<?php echo $auction_id; ?>">

					<input name="reserve_price" id="reserve_price" type="hidden" value="<?php echo $auction_data->reserve_price; ?>">

					<div class="row" align="center">
					<?php
					/* $tk=GetTitleByField('tbl_auction_participate', 'bidderID='.$bidderid.' and auctionID='.$auction_id.'', 'final_submit');*/
					$tk=GetTitleByField("tbl_auction_participate_frq", "bidderID='".$bidderid."' and auctionID='".$auction_id."'", "id");

					if( $tk > 0 || $auction_data->price_bid_applicable == 'not_applicable'){
					$finalsubmit='1';
					}else{
					$finalsubmit='0';  
					}
					?>
					<input type="hidden" value="<?=(int)$finalsubmit;?>" id="final_submit" name="final_submit">
					<a href="/owner/eventTrack/<?php echo $auction_id; ?>"><input name="back" onclick="window.location.href='<?php echo base_url(); ?>owner'" value="Back" type="button" class="b_submit float-left button_grey"></a>
					<?php 
					$fs = GetTitleByField('tbl_auction_participate', "auctionID='" . $auction_id . "' AND bidderID='" . $bidderid . "'", 'final_submit');

					if($fs != 1)
					{
					?>
					<input name="fSave" value="Final Submit" onclick="return validateParticipate('final_save');" type="submit" class="b_submit float-right button_grey" >
					<?php 
					}
					//}
					?>
			</div>
		</div>  
	</div>
</div>
</div>
</div>
</div>
</form>                                                            
</div>
</div>
</div>
</div>
<!-- Sell > My Activity end --> 
</div>
</div>
</div>
<!---- Sell tab container end ----> 
</div>
</div>
</div>
</div>
</div>
</section>
<script>



function isNumberKey(evt)
{
	var charCode = (evt.which) ? evt.which : event.keyCode;
	console.log(charCode);
	if (charCode != 46 && charCode != 45 && charCode > 31
	&& (charCode < 48 || charCode > 57))
	return false;

	return true;
}
jQuery(document).ready(function($){

	<?php  if ($emd_paid != 'success') { ?>
		//setInterval(function(){ location.reload(); }, 20000);
	<?php } ?>
	$(".numericonly_1").keydown(function (e) { 
		// Allow: backspace, delete, tab, escape, enter and .
		if ($.inArray(e.keyCode, [46, 8, 9, 27, 13]) !== -1 ||
			// Allow: Ctrl+A, Command+A
			(e.keyCode == 65 && ( e.ctrlKey === true || e.metaKey === true ) ) || 
			// Allow: home, end, left, right, down, up
			(e.keyCode >= 35 && e.keyCode <= 40)) {
			// let it happen, don't do anything
			return;
		}
		// Ensure that it is a number and stop the keypress
		if ((e.shiftKey || (e.keyCode < 48 || e.keyCode > 57)) && (e.keyCode < 96 || e.keyCode > 105)) {
		e.preventDefault();
		}
	});

	$('.numericonly').keypress(function(event) {
		if ((event.which != 46 || $(this).val().indexOf('.') != -1) &&
		((event.which < 48 || event.which > 57) &&
		(event.which != 0 && event.which != 8))) {
		event.preventDefault();
		}

		var text = $(this).val();

		if ((text.indexOf('.') != -1) &&
		(text.substring(text.indexOf('.')).length > 2) &&
		(event.which != 0 && event.which != 8) &&
		($(this)[0].selectionStart >= text.length - 2)) {
			event.preventDefault();
		}
	});
	jQuery(".onlynumber").on("keypress",function(evt){
		var keycode = evt.charCode || evt.keyCode;			
		if (keycode  == 46) {
			return false;
		}
	});

	jQuery(".onlynumber").on("keyup",function(evt){	
		var val = jQuery(this).val();
		if(val.indexOf(".") > -1)
		{
			val = val.split(".");			  
			jQuery(this).val(val[0]);		  
		}

	}); 
});
</script>
