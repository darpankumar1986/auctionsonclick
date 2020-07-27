<style>
        .body_main{margin-top: 20px!important;}
        .datagrid{width:100%; float:left; padding:5px 0 15px 0;}
        .datagrid table{width:100%; float:left; border:solid 1px #ccc; border-collapse: collapse; }
        .datagrid th{border:solid 1px #ccc; padding:3px 5px; font-size:12px;}
        .datagrid td{ border:solid 1px #ccc; padding:3px 5px; font-size:12px!important;     vertical-align: middle;}
        .body_main ul li{ font-size: 12px!important; line-height:20px;     list-style-position: inside;}
        .body_main ul{width:90%; float:left; margin-bottom:20px;}
	 
	.slicknav_menu {display:none;}
	#menu1  {	 padding: 0px 0% 0 8%;  }
	#menu1 li {display:inline-block; padding: 0px 2%; line-height:35px;    border-left: solid 1px #ccc; }
	#menu1 li:last-child{border-right: solid 1px #ccc;}
	#menu1 li a{color:#fff; text-decoration:none; font-size:.9em; text-transform:uppercase; }
	#menu1 li:hover{background:#a71a00;}
	.active{background:#a71a00;}
	.color1{color:#F00;}
	header {
		background: #fff;
		border-top: solid 3px #bd2000;
		width: 85%;
		border-bottom: solid 1px #961a00;
		padding: 5px 7.5%;
	}
        /*Added by Azizur*/
	.logo-img {
            margin-left: 15%;
            padding: 1% 0;
        }
</style>

<link rel="stylesheet" href="<?php echo base_url()?>/css/bace.css">
<script src="<?php echo base_url()?>/js/jquery.min.js"></script>

<style>
	.box-head {
    width: 98%;
    float: left;
    padding-top: 7px;
    padding-left: 2%;
    cursor: pointer;
    margin: 15px 0 0 0;
    border-radius: 3px;
    border: 1px solid #bbb;
    color: #fff;
    font-size: .9em;
    font-weight: 600;
    text-shadow: 0 1px 0 #222;
    background: #d33919;
    height: 27px;
}
</style>
<script>
	function printDiv(divName) {
     var printContents = document.getElementById(divName).innerHTML;
     var originalContents = document.body.innerHTML;

     document.body.innerHTML = printContents;

     window.print();

     document.body.innerHTML = originalContents;
}

</script>

          <!--Start: Azizur -->
          <section>
	<!-- <img width="25" src="<?php echo base_url(); ?>images/print.png" onclick="printDiv('printableArea')" title="Print" style="cursor:pointer;padding-left: 9px;"> -->
  <div class="row">
    <div class="wrapper-full">
		<div id="printableArea">
      <div class="dashboard-wrapper">
        
        <div class="container">
          
          <div class="secttion-right" style="width:100%;">
			<div class="box-head">Auction Details</div>
<table border="1" align="left" cellpadding="2" cellspacing="1" class="mytable dataTable" id="big_table" aria-describedby="big_table_info">
<tbody role="alert" aria-live="polite" aria-relevant="all">
         
    <tr class="even">                  
            <td align="left" valign="top" class=""><strong>Auction No. </strong></td>
            <td align="left" valign="top" class=""><?php echo $auction_data[0]->id?></td>
            <td align="left" valign="top" class=""><strong>Institution</strong></td>
            <td align="left" valign="top" class="">
            <?php
                echo GetTitleByField('tblmst_account_type', "account_id='".$auction_data[0]->account_type_id."'" ,'account_name');
            ?>  
            </td>
        </tr>
        
        <tr class="odd">
            <td align="left" valign="top" class=""><strong>Property ID </strong></td>
            <td align="left" valign="top" class=""><?php echo $auction_data[0]->reference_no?></td>
            <td align="left" valign="top" class=""><strong>Auction Reference Dispatch Date</strong></td>
            <td align="left" valign="top" class=""><?php echo (($auction_data[0]->dispatch_date != '1970-01-01') && ($auction_data[0]->dispatch_date != '0000-00-00')) ? date('d-m-Y', strtotime($auction_data[0]->dispatch_date)) : 'N/A'; ?></td>
        </tr>
        
        <tr class="even">
            <td width="20%" align="left" valign="top" class=""><strong>Property Address</strong></td>
            <td width="30%" align="left" valign="top" class=""><?php echo strtoupper($auction_data[0]->PropertyDescription);?></td>
            <td width="20%" align="left" valign="top" class=""><strong>Carpet Area</strong></td>
            <td width="20%" align="left" valign="top" class=""><?php echo ($auction_data[0]->area != '')?$auction_data[0]->area:'N/A';?></td>
        </tr>

        <tr class="odd">
            <td align="left" valign="top" class=""><strong>Carpet Area Unit</strong></td>
            <td align="left" valign="top" class="">
            <?php
                $cauom = GetTitleByField('tblmst_uom_type', "uom_id='".$auction_data[0]->area_unit_id."'" ,'uom_name');
                echo ($cauom !='')?$cauom:'N/A';
            ?>
            </td>
            <td align="left" valign="top" class=""><strong>Category/ Property Type</strong></td>
            <td align="left" valign="top" class="">
            <?php
            echo GetTitleByField('tbl_category', "id='".$auction_data[0]->category_id."'" ,'name');
            ?>
            </td>
        </tr>
        
        <tr class="even">
            
            <td align="left" valign="top" class=""><strong>Corner</strong></td>
            <td align="left" valign="top" class=""><?php echo ($auction_data[0]->is_corner_property == 1) ? 'Yes' : 'No'; ?>
            </td>
            <td align="left" valign="top" class=""><strong>Scheme Id</strong></td>
            <td align="left" valign="top" class=""><?php echo ($auction_data[0]->scheme_id)? $auction_data[0]->scheme_id: 'N/A';?></td>
        </tr>
        
        <tr class="odd">
            
            <td align="left" valign="top" class=""><strong>Scheme Name</strong></td>
            <td align="left" valign="top" class=""><?php echo ($auction_data[0]->scheme_name)? $auction_data[0]->scheme_name: 'N/A';?></td> 
            <td align="left" valign="top" class=""><strong>Name of Owner/ Occupier as per MCG record</strong></td>
            <td align="left" valign="top" class=""><?php echo ($auction_data[0]->service_no)? $auction_data[0]->service_no: 'N/A';?></td>
        </tr>
        
        <tr class="even">
            
            <td align="left" valign="top" class=""><strong>Concerned Zone</strong></td>
            <td align="left" valign="top" class="">
            <?php
            echo GetTitleByField('tbl_zone', "zone_id='".$auction_data[0]->zone_id."'" ,'zone_name');
            ?>
            </td> 
            <td align="left" valign="top" class=""><strong>Applicable FAR</strong></td>
            <td align="left" valign="top" class=""><?php echo ($auction_data[0]->far)? $auction_data[0]->far: 'N/A';?></td>
        </tr>
        
        <tr class="odd">
            
            <td align="left" valign="top" class=""><strong>Plot Area</strong></td>
            <td align="left" valign="top" class=""><?php echo ($auction_data[0]->property_height)? $auction_data[0]->property_height: 'N/A';?></td>  
            <td align="left" valign="top" class=""><strong>Plot Area Unit</strong></td>
            <td align="left" valign="top" class="">
            <?php
                $height_unit = GetTitleByField('tblmst_height_uom_type', "height_uom_id='".$auction_data[0]->height_unit_id."'" ,'height_uom_name');
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
            <td align="left" valign="top" class=""><?php echo ($auction_data[0]->max_coverage_area)? $auction_data[0]->max_coverage_area: 'N/A';?></td> 
            <td align="left" valign="top" class=""><strong>Reserve Price</strong></td>
            <td align="left" valign="top" class="">
                <?php echo number_format($auction_data[0]->reserve_price, 2); ?>&nbsp;&nbsp;&nbsp;( <?php echo getAmountInWords((int)$auction_data[0]->reserve_price); ?> )
            </td>
        </tr>
        
        <tr class="odd">
            
            <td align="left" valign="top" class=""><strong>Reserve Price (Unit)</strong></td>
            <td align="left" valign="top" class=""><?php
                echo GetTitleByField('tblmst_uom_type', "uom_id='".$auction_data[0]->unit_id_of_price."'" ,'uom_name');
            ?> 
            </td>  
            <td align="left" valign="top" class=""><strong>EMD Amount</strong></td>
            <td align="left" valign="top" class="">
                <?php echo number_format($auction_data[0]->emd_amt, 2); ?>  (<?php echo getAmountInWords($auction_data[0]->emd_amt); ?> )
            </td>
        </tr>
        
       <?php /* ?> <tr class="odd">
            
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
            <td align="left" valign="top" class=""><?php echo $auction_data[0]->tender_fee;?>
            </td>
            <td align="left" valign="top" class=""><strong>Press Release Date</strong></td>
            <td align="left" valign="top" class="">
            <?php echo date("d-m-Y",strtotime($auction_data[0]->press_release_date));?>
            </td>
        </tr>
        
        
        <tr class="odd">
            
            <td align="left" valign="top" class=""><strong>Site Visit Start Date</strong></td>
            <td align="left" valign="top" class="">                
                <?php echo (($auction_data[0]->inspection_date_from != '1970-01-01') && ($auction_data[0]->inspection_date_from != '0000-00-00 00:00:00')) ? date('d-m-Y', strtotime($auction_data[0]->inspection_date_from)) : 'N/A'; ?>
            </td> 
            <td align="left" valign="top" class=""><strong>Site Visit End Date</strong></td>
            <td align="left" valign="top" class="">
		<?php echo (($auction_data[0]->inspection_date_to != '1970-01-01') && ($auction_data[0]->inspection_date_to != '0000-00-00 00:00:00')) ? date('d-m-Y', strtotime($auction_data[0]->inspection_date_to)) : 'N/A'; ?>
            </td>
        </tr>
        <tr class="even">
            
            <td align="left" valign="top" class=""><strong>Apply And EMD Start Date</strong></td>
            <td align="left" valign="top" class="">
                <?php echo date("d-m-Y H:i",strtotime($auction_data[0]->registration_start_date));?>
            </td> 
            <td align="left" valign="top" class=""><strong>Apply And EMD End Date</strong></td>
            <td align="left" valign="top" class="">
                <?php echo date("d-m-Y H:i",strtotime($auction_data[0]->bid_last_date));?>
            </td>
        </tr>
        <tr class="odd">
            
            <td align="left" valign="top" class=""><strong>Auction Start date</strong></td>
            <td align="left" valign="top" class="">
                <?php echo date("d-m-Y H:i",strtotime($auction_data[0]->auction_start_date));?>
            </td> 
            <td align="left" valign="top" class=""><strong>Auction End date</strong></td>
            <td align="left" valign="top" class="">
                <?php echo date("d-m-Y H:i",strtotime($auction_data[0]->auction_end_date));?>
            </td> 
        </tr>
        
        <tr class="even">
            
             
            <td align="left" valign="top" class=""><strong>Mode of Bid</strong></td>
            <td align="left" valign="top" class="">
               <?php echo ($auction_data[0]->mode_of_bid == 'online') ? 'Online' : 'Offline'; ?>
            </td>
             
            <td align="left" valign="top" class=""><strong>Is DSC Enabled </strong></td>
            <td align="left" valign="top" class="">
                <?php echo ($auction_data[0]->dsc_enabled == 1) ? "Yes" : "No" ?>
            </td> 
        </tr>
        
        
         <tr class="odd">
           
            <td align="left" valign="top" class=""><strong>Auto Bid Allow</strong></td>
            <td align="left" valign="top" class="">
                <?php echo ($auction_data[0]->allow_auto_bid == 1) ? "Yes" : "No" ?>
            </td>
            
            <td align="left" valign="top" class=""><strong>Bid Increment value</strong></td>
            <td align="left" valign="top" class="">
                <?php echo $auction_data[0]->bid_inc;?>
            </td>  
        </tr>
        
        <tr class="even">
            
             <td align="left" valign="top" class=""><strong>Auto Extension time </strong>(In Minutes.)</td>
            <td align="left" valign="top" class=""><?php echo ($auction_data[0]->auto_extension_time != '0') ? $auction_data[0]->auto_extension_time : "0"; ?>
            </td>
            
            <td align="left" valign="top" class=""><strong>Auto Extension(s)</strong></td>
            <td align="left" valign="top" class="">                
                <?php echo ($auction_data[0]->auto_extension_time >0 && $auction_data[0]->no_of_auto_extn == '0') ? "Unlimited": $auction_data[0]->no_of_auto_extn; ?>
            </td> 
        </tr>
        <tr class="odd">
        
             <td align="left" valign="top" class=""><strong>How to Reach</strong></td>
            <td td align="left" valign="top" class=""><a target="_blank" href="<?php echo base_url().'home/viewGoogleMap/'. $auction_data[0]->id;?>">View</a></td>
             
             <td align="left" valign="top" class=""><strong>1st Contact Person Details</strong></td>
            <td align="left" valign="top" class=""><?php echo $auction_data[0]->contact_person_details_1;?></td>
            
      </tr>
        </tr>
        
        <tr class="even">
           
            <td align="left" valign="top" class=""><strong>2nd Contact Person Details</strong></td>
            <td align="left" valign="top" class=""><?php echo ($auction_data[0]->contact_person_details_2)? $auction_data[0]->contact_person_details_2: 'N/A';?></td>  
            <td align="left" valign="top" class=""><strong>Any Documents Pertinent To The Auction</strong></td>
                 <td align="left" valign="top" class="">

             <?php
             if ($auction_data[0]->doc_to_be_submitted) {
                 $docArr = explode(",", $auction_data[0]->doc_to_be_submitted);
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
		echo '<a target="_blank" href="'.base_url().'home/viewEventDocuments/' . $uploadedDocs[0]->auction_id . '"  >View</a>';
		} else {
		echo "N/A";
		}
		?>
            </td>
            <td align="left" valign="top" class=""><strong>Remark</strong></td>
            <td align="left" valign="top" class="">
                <?php echo ($auction_data[0]->remark)? $auction_data[0]->remark: 'N/A';?>
                
            </td>
        </tr>
        
        <tr class="even">
         
            <td align="left" valign="top" class=""><strong>Auction Created by</strong></td>
        <td align="left" valign="top" class="">
            <?php
                  /*$sales_executive_id=GetTitleByField('tbl_event_log_sales', "id='".$auction_data[0]->eventID."'" ,'sales_executive_id');				
                  echo  GetTitleByField('tbl_user_registration', "id='".$sales_executive_id."'" ,'first_name');
                  echo " ";
                  echo  GetTitleByField('tbl_user_registration', "id='".$sales_executive_id."'" ,'last_name');*/

                  $sales_executive_id=GetTitleByField('tbl_auction', "id='".$auction_data[0]->id."'" ,'first_opener');				
                  echo  ucfirst(GetTitleByField('tbl_user', "id='".$sales_executive_id."'" ,'first_name'));
                  echo " ";
                  echo ucfirst(GetTitleByField('tbl_user', "id='".$sales_executive_id."'" ,'last_name'));
            ?>
          </td>	
          <td align="left" valign="top" class=""><strong>Auction Approved by</strong></td>
          <td align="left" valign="top" class="">
            <?php
                  /*$sales_executive_id=GetTitleByField('tbl_event_log_sales', "id='".$auction_data[0]->eventID."'" ,'sales_executive_id');				
                  echo  GetTitleByField('tbl_user_registration', "id='".$sales_executive_id."'" ,'first_name');
                  echo " ";
                  echo  GetTitleByField('tbl_user_registration', "id='".$sales_executive_id."'" ,'last_name');*/

                  $approver_id = GetTitleByField('tbl_auction', "id='".$auction_data[0]->id."'" ,'second_opener');				
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
        </div>
        </div>
      </div>
    </div>
  </div>
</section>
