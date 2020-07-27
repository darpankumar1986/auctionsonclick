<script type="text/javascript"> 
	<?php 
	date_default_timezone_set("Asia/Calcutta");
	$current_timestamp = round(microtime(true) * 1000);?>
	var todayDate = new Date(<?php echo $current_timestamp;?>);
	var d = todayDate;
	d.setTime( d.getTime() + d.getTimezoneOffset()*60*1000 + 19800000);
	//var utcTime = new Date(d1.getUTCFullYear(), d1.getUTCMonth(), d1.getUTCDate(), d1.getUTCHours(), d1.getUTCMinutes(), d1.getUTCSeconds());
	//n = utcTime.getTime() + 19800000;
	n= d.getTime();
	//alert(d);

	//var countdown_td = -(parseInt(<?php echo $current_timestamp;?>) - parseInt(n));	 
	var countdown_td = d.getTime() - new Date().getTime() ;
	//alert(new Date().getTime());	
</script>

<link rel="stylesheet" href="<?= base_url(); ?>css/colorbox.css" />
<link rel="stylesheet" href="<?= base_url(); ?>bankeauc/css/tables.css" />
<script src="<?= base_url(); ?>js/jquery.colorbox.js"></script>

<script	src="/bankeauc/DSC_Browser_Plugin/js/resources/jquery.dataTables.min.js"></script>
<script	src="/js/dsc.js"></script>

<?php 

	$dsc_enabled =  false;
	if(count($auctionData) > 0)
	{
		foreach ($auctionData as $adata) {		

			if($adata->dsc_enabled == 1)
			{
				$dsc_enabled =  true;
			}
		}
	}
?>

<?php if($dsc_enabled == true){?>
	<script type="text/javascript">
	var certSerialNo = null;
	var SerialNo = null;
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

		//$('#certlist tbody').on( 'click', 'tr', function () {
		$(document).on( 'click', '#certlist tbody tr', function () {
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
		$(document).on( 'click', '.dscsecure_checkbox', function () {
		//$(".dscsecure_checkbox").click(function(){
			var auctionID = $(this).val();
			$("#check_dsc_auctionID").val(auctionID);
			//alert(auctionID);
			$(this).parent().find(".check_dsc").click();
		});
	});
	</script>
<?php } ?>
<style>
.form_bg{width:98%; float:left; background:#fff; padding:5px 1%; border-radius:5px; }
.datagrid table {width:100%; border:solid 1px #ccc;}
table.dataTable thead th {    border-right: solid 1px#ccc;  padding:10px 2%;   font-size: 12px;}
table.dataTable thead th:last-child {border-right: none;}
.datagrid table tbody td{border-right: solid 1px#ccc;}
.datagrid table tbody td:last-child{border-right: none;}
.datagrid table tbody td {font-size:9px; word-wrap:break-word; cursor:pointer;     word-break: break-all; }
.dataTables_info{float:left; font-size:10px;}
.btn{ margin:0 0; border-radius:0; font-size:12px; padding: 3px 10px!important; color:#fff;     background: #0c7e99;}
.selected{background:#cccccc !important;}
.row-custom{width:100%; float:left; background:#fff; padding:0 1%; text-align:center;}
</style>

<script type="text/javascript" src="/js/jquery.countdown.js"></script>
<!--<script src="<?= base_url(); ?>js/dsc.js"></script>-->
<?php 
$userid = $this->session->userdata['id'];
	$dsc_enabled =  false;
	if(count($auctionData) > 0)
	{
		foreach ($auctionData as $adata) {
			
			 $participate_status1 = GetTitleByField('tbl_auction_participate', "bidderID='" . $userid . "' AND auctionID='" . $adata->id . "'", 'is_accept_auct_training');
			if($adata->dsc_enabled == 1)
			{
				$dsc_enabled =  true;
			}
		}
	}
?>
<style>.grn-txt{text-decoration:none;}</style>
<script>
 
jQuery(document).ready(function($) {	
    $('[data-countdown]').each(function() {
	   var $this = $(this), finalDate = $(this).data('countdown');
	   var $this = $(this), finalDate = $(this).data('countdown');
				
				$this.countdown(finalDate, function (event) {
					days = event.strftime('%D');
					if(days > 0)
					{
						var daysCount = event.strftime('<span class="col"><span style="padding:5px 7px;background-color:#000;color:#fff;font-size:18px;font-weight:normal;">%D</span> <label style="padding:5px 7px;background-color:#000;color:#fff;font-size:18px;font-weight:normal;">Day</label> ');				
					}
					else
					{
						var daysCount = "";
					}
					
					$this.html(daysCount + event.strftime('<span class="col"><span style="padding:5px 7px;background-color:#000;color:#fff;font-size:18px;font-weight:normal;">%H</span></span> <span class="col"><span style="padding:5px 7px;background-color:#000;color:#fff;font-size:18px;font-weight:normal;">%M</span></span> <span class="col"><span style="padding:5px 7px;background-color:#000;color:#fff;font-size:18px;font-weight:normal;">%S</span></span>'));
				},100000).on('finish.countdown', function(){ //alert('tet');
				var rand = Math.random() * 100000000000;
				location.href = '?rand='+rand;
			});
	 });	 
});
//End of numToWords function
$(document).on('keyup','#bidder_autobid_value_<?php echo $adata->id; ?>',function(){
	var mtxtValue = $("#bidder_autobid_value_<?php echo $adata->id; ?>").val();
	var inputValue = $(this).val();
	var hold = numToWords(inputValue);
	$('#riw_<?php echo $adata->id; ?>').html(hold);
    //input.innerHTML = hold;
    var areaVal = $("#areaVal").val();                            
	var totalVal = areaVal*mtxtValue;
	$("#total_bid_val_<?php echo $adata->id; ?>").val(totalVal);
});

function showText(input) { 
	/*
    var inputValue = input.value; 
    var hold = numToWords(inputValue);
    input.innerHTML = hold;
    */
   }
   
</script>
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
				<input id="check_dsc_auctionID" type="hidden" value="" />
				<div class="row-custom"><button id="button" onclick="CheckvalidNewDSC();" class="btn">select certificate</button></div>
			</div>
		</div>
	</div>
</div>

<section class="container_12">						
    <div class="container_12"  id="live_auction_data1">
		<div>
	       <?php echo $buylive_bidding_auction_list_eauc_auto_bid_DSC;?>
	</div>
</section>

<script>

	$(document).ready(function(){
		  
		setInterval(function(){ 
			var rand = Math.random() * 1000000000000000;
			$("#live_auction_data").load('/owner/buyliveBiddingAuctionsdatatableDSC/<?php echo $getauctionID; ?>/?rand='+rand);
			var days =0;
			$('[data-countdown]').each(function () {
				var $this = $(this), finalDate = $(this).data('countdown');
				
				$this.countdown(finalDate, function (event) {
					days = event.strftime('%D');
					if(days > 0)
					{
						var daysCount = event.strftime('<span class="col"><span style="padding:5px 7px;background-color:#000;color:#fff;font-size:18px;font-weight:normal;">%D</span> <label style="padding:5px 7px;background-color:#000;color:#fff;font-size:18px;font-weight:normal;">Day</label> ');				
					}
					else
					{
						var daysCount = "";
					}
					
					$this.html(daysCount + event.strftime('<span class="col"><span style="padding:5px 7px;background-color:#000;color:#fff;font-size:18px;font-weight:normal;">%H</span></span> <span class="col"><span style="padding:5px 7px;background-color:#000;color:#fff;font-size:18px;font-weight:normal;">%M</span></span> <span class="col"><span style="padding:5px 7px;background-color:#000;color:#fff;font-size:18px;font-weight:normal;">%S</span></span>'));
				});
			}); 
	}, 10000); //10000
	
  setInterval(function(){ 
    var a = new Date();
    var b = new Date(<?=$str_auction_end_date*1000;?>);
    var difference = (b - a) / 1000;
    var rand = Math.random() * 1000000000000000;
    
    if(difference > '0' && (difference<='7'||difference<='5'||difference<='2')){              
      $("#live_auction_data").load('/owner/buyliveBiddingAuctionsdatatableDSC/<?php echo $getauctionID; ?>/?rand='+rand);
    }
    
 }, 1000);
        
        
});


</script>
<div class="bidderHolePopup" style="display:none;">
 <div class="popup" ><img src="/images/icon-close2.png" width="20" class="close">
	<div class="popupcontainer"></div>
 </div>
	<div id="popup-overlay"></div>
</div>
<!-- Time File : owner_view/buylive_bidding_auction_list_eauc_DSC-->

<style>
	.view_half a
	{
		background-color: #fff;
	}
	.nit_time_remaining
	{
		background-color: #fff;
	}
</style>
