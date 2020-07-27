<link rel="stylesheet" href="<?php echo base_url();?>assets/css/jquery.dataTables.css" type="text/css" media="screen"/>	
<!--<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery.dataTables.min.js"></script>-->
<script	src="/bankeauc/DSC_Browser_Plugin/js/resources/jquery.dataTables.min.js"></script>
<link rel="stylesheet" href="<?php echo base_url(); ?>css/colorbox.css" />
<script src="<?php echo base_url(); ?>js/jquery.colorbox.js"></script>
<script	src="<?php echo base_url(); ?>js/dsc.js"></script>
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
                <input type="hidden" id="aId" value=""/>
                <div class="row-custom"><button id="button" onclick="sendValue();" class="btn">select certificate</button></div>
            </div>
        </div>
    </div>
</div>

<div style='display:none'>
    <div id="rjct" class="rjct">
        <div class="grid_border">
            <div class="datagrid">
				<div class="heading4 btmrg20">Rejection History</div>
                <table id="certlist1" class="display" class="cell-border wid_60 dataTable">                    
                    <tbody>
                        <tr>
                            <td style="max-width:30%">Rejection Comment:</td>
                            <td style="max-width:30%" id="rjctCmt"><strong>Dummy Comment</strong></td>
                        </tr>
                        <tr>
                            <td style="max-width:30%">Rejection Date & Time</td>
                            <td style="max-width:30%" id="rjctDt"><strong>01-01-1970 12:40:27</strong></td>
                        </tr>
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>

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

function setVal(setVal)
{
    $('#aId').val(setVal);
    
}
function sendValue()
{
    var auctionId = $('#aId').val();
    checkDSC(auctionId);
}

function sendReject(cmt,cmtDt)
{
	$('#rjctCmt').html('<strong>'+cmt+'</strong>');
	$('#rjctDt').html('<strong>'+cmtDt+'</strong>');
}
</script>
<style>
    .form_bg{width:98%; float:left; background:#fff; padding:5px 1%; border-radius:5px; }
    .form_bg .datagrid table {width:100%; border:solid 1px #ccc;}
    /*.form_bg table.dataTable thead th {border-right: solid 1px#ccc;  padding:10px 1%; font-size: 12px; }*/    
    .form_bg table.dataTable thead th:last-child {border-right: none;}
    .form_bg .datagrid table tbody td{border-right: solid 1px#ccc;}
    .form_bg .datagrid table tbody td:last-child{border-right: none;}
    .form_bg .datagrid table tbody td {font-size:9px; cursor:pointer; word-wrap:break-word;word-break: break-all; }
    .form_bg .dataTables_info{float:left; font-size:10px;}
    .form_bg .btn{ margin:0 0; border-radius:0; font-size:12px; padding: 3px 10px!important; color:#fff;     background: #0c7e99;}
    .form_bg .selected{background:#cccccc !important;}
    .form_bg .row-custom{width:100%; float:left; background:#fff; padding:0 1%; text-align:center;}
    
    
    .rjct{width:98%; float:left; background:#fff; padding:5px 1%; border-radius:5px; }
    .rjct .datagrid table {width:100%; border:solid 1px #ccc;}
    .rjct .datagrid table tr.even {background-color: white;border-bottom: 1px solid #ddd;}    
    .rjct .datagrid table tbody td{padding: 12px 8px;color: #333;border: 1px solid #ccc;word-wrap: break-word;word-break: break-all;}
    .rjct .datagrid table tbody td:last-child{border-right: none;}
    .rjct .heading4 {
    background: url(../images/grad-overlay-s.png) #393939;
    border-radius: 2px;
    padding: 5px 1%;
    color: #ddd;
    font-size: 14px;
    font-weight: 600;
    text-align: left;
    text-shadow: 0 1px 0 #222;
    width: 98%;
    float: left;
}

.hoverImage{margin: 0 0 0 5px;}
</style>
<script type="text/javascript">
        $(document).ready(function() 
        {
         
         
			// START :: PARTICIPATION STAGE
			$("#live_event_table thead tr th").eq(9).addClass("hidetd");
			$("#live_event_table thead tr th").eq(0).addClass("hidetd");
			$("#live_event_table thead tr th").eq(1).addClass("hidetd");	
			var rdrlink = 0;
			var oTable = $('#live_event_table').dataTable({
						"bAutoWidth": false,
						"aoColumns": [{"sWidth": "5%"}, {"sWidth": "8%"}, {"sWidth": "8%"}, {"sWidth": "20%"}, {"sWidth": "15%"}, {"sWidth": "10%"}, {"sWidth": "10%"},{"sWidth": "10%"}, {"sWidth": "10%"}, {"sWidth": "5%"}, {"sWidth": "30%"}],
						"bProcessing": true,
						"bServerSide": true,
						"sAjaxSource": '<?php echo base_url(); ?><?php echo $controller ?>/liveEventDatatable_main',
						//"bJQueryUI": true,
						"sPaginationType": "full_numbers",
						"iDisplayStart ": 10,
						"oLanguage": {
							"sProcessing": "<img src='<?php echo base_url(); ?>assets/images/ajax-loader_dark.gif'>"
						},
						"fnInitComplete": function () {
							//oTable.fnAdjustColumnSizing();
							$('#big_table_paginate').addClass('oneTemp');
							$('#big_table_info').addClass('oneTemp');
							$('.oneTemp').wrapAll('<div class="tableFooter">');
							$('select[name="big_table_length"]').insertAfter('#big_table_length > label');
						   
						},
						'fnServerData': function (sSource, aoData, fnCallback)
						{
							$.ajax
									({
										'dataType': 'json',
										'type': 'POST',
										'url': sSource,
										'data': aoData,
										'success': fnCallback
									});
						},
						"fnRowCallback": function (nRow, aData, iDisplayIndex) {
                                                   
							$('td:eq(1)', nRow).addClass("hidetd");
							/*
							if(aData[0]!='null')
							{ 
								if(aData[9]=='0')
								{
									var imgTag = '<img src="<?php echo base_url(); ?>' + aData[0] + '" class="hoverImage" style="width:35px"/>';   
								}
								else
								{
									if(aData[10]==1)
									{
										var imgTag = '<img src="<?php echo base_url(); ?>images/dsc.png" class="hoverImage" style="width:35px"/><img src="<?php echo base_url(); ?>' + aData[0] + '" class="hoverImage" style="width:35px"/>';
									}
									else
									{
										var imgTag = '<img src="<?php echo base_url(); ?>' + aData[0] + '" class="hoverImage" style="width:35px"/>';
									}
								}
							 }
							 else
							 {
								var imgTag ='';
							 }
                                                        */
							//$('td:eq(0)', nRow).html(imgTag);
							$('td:eq(9)', nRow).addClass("hidetd");
							$('td:eq(0)', nRow).addClass("hidetd");
							/*
							 if(aData[0] == '1')
							{
								if(aData[10]=='1')
								{
									if(aData[11] == null)
									{
									var dscLnk = '<a href="#form_bg" class="check_dsc cboxElement b_action" onclick="setVal('+aData[1]+')">Check DSC</a>';
									}
									else{
									var dscLnk ='<a class="b_action" href="<?php echo base_url(); ?>owner/auctionParticipage/'+aData[1]+'">Track</a>';
									}
								}
								else
								{
									var dscLnk ='<a class="b_action" href="<?php echo base_url(); ?>owner/auctionParticipage/'+aData[1]+'">Track</a>';
								}
								var actionData = dscLnk+' <a class="b_action" href="<?php echo base_url(); ?>owner/pro_detail/'+aData[9]+'" >View</a>';

							}else{
								if(aData[10]=='1')
								{
									if(aData[11] == null)
									{
									var dscLnk = '<a href="#form_bg" class="check_dsc cboxElement b_action" onclick="setVal('+aData[1]+')">Check DSC</a>';
									}
									else{
									var dscLnk ='<a class="b_action" href="<?php echo base_url(); ?>owner/auctionParticipage/'+aData[1]+'">Track</a>';
									}
								}
								else
								{
									var dscLnk ='<a class="b_action" href="<?php echo base_url(); ?>owner/auctionParticipage/'+aData[1]+'">Track</a>';
								}
								var actionData = dscLnk+' <a class="b_action" href="<?php echo base_url(); ?>owner/pro_detail/'+aData[9]+'" >View</a> <a href="javascript:void(0);" onclick="addtoeventfavlist('+aData[1]+')"><img src="../images/addtoFav.jpg"  width="20" height="20" title="Add to favourite" class="imgfav"></a>';
							}
							*/
							
							
							if(aData[10]==1)
							{
								var imgTag = '<img src="<?php echo base_url(); ?>images/dsc.png" class="hoverImage" title="DSC Auction" style="width:35px"/>';
							}
							else
							{
								var imgTag = '';
							}	
							
							var actionData = '<a class="" href="<?php echo base_url(); ?>owner/auctionParticipage/'+aData[1]+'"><img src="/bankeauc/images/track.png" title="Track Auction" class="edit1"></a> <a class="" href="<?php echo base_url(); ?>owner/pro_detail/'+aData[9]+'" ><img src="/bankeauc/images/view.png" title="View Auction" class="edit1"></a> <a href="javascript:void(0);" onclick="addtoeventfavlist('+aData[1]+')"><img src="../images/addtoFav.jpg"  width="20" height="20" title="Add to favourite" class="imgfav"></a>'+imgTag;
							if(aData[12] !='' && aData[12] !=null)
							{
								actionData =actionData+'<a href="#rjct" class="rejct_cmt cboxElement" onclick="sendReject(\''+aData[13]+'\',\''+aData[14]+'\')">Rejection History</a>';
							}
							$('td:eq(10)', nRow).html(actionData);
							 setTimeout(function(){
								//$(".check_dsc").colorbox({inline:true, width:"50%"});
								$(".rejct_cmt").colorbox({inline:true, width:"50%"});
								
							 },1000); 
							$(nRow).click(function () {
							
							});
							return nRow;
						},
						"aoColumnDefs": [ { "bSortable": false, "aTargets": [ 6] } ],      
			});
			// END :: PARTICIPATION STAGE
			
			
			// START :: FAVOURITE PARTICIPATION STAGE
					$("#live_event_table_fav thead tr th").eq(0).addClass("hidetd"); 
					// $("#live_event_table_fav thead tr th").eq(8).addClass("hidetd"); 
						
					var rdrlink = 0;
					var oTable = $('#live_event_table_fav').dataTable({
						"bAutoWidth": false,
						"aoColumns": [{"sWidth": "10%"}, {"sWidth": "8%"}, {"sWidth": "20%"}, {"sWidth": "15%"}, {"sWidth": "10%"}, {"sWidth": "10%"}, {"sWidth": "10%"},{"sWidth": "10%"}, {"sWidth": "0%"}, {"sWidth": "0%"}, {"sWidth": "10%"}],
						"bProcessing": true,
						"bServerSide": true,
						"sAjaxSource": '<?php echo base_url(); ?><?php echo $controller ?>/liveEventDatatable_main_fav',
						//"bJQueryUI": true,
						"sPaginationType": "full_numbers",
						"iDisplayStart ": 10,
						   
						"oLanguage": {
							"sProcessing": "<img src='<?php echo base_url(); ?>assets/images/ajax-loader_dark.gif'>"
						},
						"fnInitComplete": function () {
							//oTable.fnAdjustColumnSizing();
							$('#big_table_paginate').addClass('oneTemp');
							$('#big_table_info').addClass('oneTemp');
							$('.oneTemp').wrapAll('<div class="tableFooter">');
							$('select[name="big_table_length"]').insertAfter('#big_table_length > label');
						   
						},
						'fnServerData': function (sSource, aoData, fnCallback)
						{
							$.ajax
									({
										'dataType': 'json',
										'type': 'POST',
										'url': sSource,
										'data': aoData,
										'success': fnCallback
									});
						},
						"fnRowCallback": function (nRow, aData, iDisplayIndex) {
							$('td:eq(0)', nRow).addClass("hidetd");
							//$('td:eq(7)', nRow).addClass("hidetd");
							$('td:eq(8)', nRow).addClass("hidetd");
							$('td:eq(9)', nRow).addClass("hidetd");
                               
                               /* 
								if(aData[9]=='1')
								{
									if(aData[10] == null)
									{
									var dscLnk = '<a href="#form_bg" class="check_dsc cboxElement b_action" onclick="setVal('+aData[0]+')">Check DSC</a>';
									}
									else{
									var dscLnk ='<a class="b_action" href="<?php echo base_url(); ?>owner/auctionParticipage/'+aData[0]+'">Track</a>';
									}
								}
								else
								{
									var dscLnk ='<a class="b_action" href="<?php echo base_url(); ?>owner/auctionParticipage/'+aData[0]+'">Track</a>';
								}
								*/
								if(aData[9]==1)
								{
									var imgTag = '<img src="<?php echo base_url(); ?>images/dsc.png" class="hoverImage" title="DSC Auction" style="width:35px"/>';
								}
								else
								{
									var imgTag = '';
								}
								
								var actionData = '<a class="" href="<?php echo base_url(); ?>owner/auctionParticipage/'+aData[0]+'"><img src="/bankeauc/images/track.png" title="Track Auction" class="edit1"></a> <a class="" href="<?php echo base_url(); ?>owner/pro_detail/'+aData[8]+'" ><img src="/bankeauc/images/view.png" title="View Auction" class="edit1"></a> <a class="" href="javascript:void(0);" onclick="removefromlivefavEventlist('+aData[0]+')"><img src="../images/addtoFav.jpg"  width="20" height="20" title="Remove from favourite" class="imgfav"></a>'+imgTag;
								if(aData[11] !='' && aData[11] !=null)
								{
									actionData =actionData+'<a href="#rjct" class="rejct_cmt cboxElement" onclick="sendReject(\''+aData[12]+'\',\''+aData[13]+'\')">Rejection History</a>';
								}
                                                        
							$('td:eq(10)', nRow).html(actionData);
							/*
							setTimeout(function(){
							   $(".check_dsc").colorbox({inline:true, width:"50%"});
							},1000); 
							*/
							$(nRow).click(function () {
							
							});
							
							return nRow;
						}
					});
			// END :: FAVOURITE PARTICIPATION STAGE
			
			
			
			// START :: LIVE AND UPCOMING AUCTION STAGE

				$("#upcomming_auction_main thead tr th").eq(0).addClass("hidetd");
				$("#upcomming_auction_main thead tr th").eq(1).addClass("hidetd");
				
				var oTable = $('#upcomming_auction_main').dataTable({
						"bAutoWidth": false,
						"aoColumns": [{"sWidth": "0%"}, {"sWidth": "0%"}, {"sWidth": "5%"}, {"sWidth": "15%"}, {"sWidth": "10%"}, {"sWidth": "10%"}, {"sWidth": "10%"}, {"sWidth": "5%"}, {"sWidth": "10%"}, {"sWidth": "15%"}],
						"bProcessing": true,
						"bServerSide": true,
						"sAjaxSource": '<?php echo base_url(); ?><?php echo $controller ?>/liveupcomingAuctionDatatable',
						//"bJQueryUI": true,
						"aoColumnDefs": [ { "bSortable": false, "aTargets": [ 8] } ],      
						"sPaginationType": "full_numbers",
						"iDisplayStart ": 10,
						"oLanguage": {
							"sProcessing": "<img src='<?php echo base_url(); ?>assets/images/ajax-loader_dark.gif'>"
						},
						"fnInitComplete": function () {
						//oTable.fnAdjustColumnSizing();
							$('#big_table_paginate').addClass('oneTemp');
							$('#big_table_info').addClass('oneTemp');
							$('.oneTemp').wrapAll('<div class="tableFooter">');
							$('select[name="big_table_length"]').insertAfter('#big_table_length > label');
						   
						},
						'fnServerData': function (sSource, aoData, fnCallback)
						{
							$.ajax
									({
										'dataType': 'json',
										'type': 'POST',
										'url': sSource,
										'data': aoData,
										'success': fnCallback
									});
						},
						"fnRowCallback": function (nRow, aData, iDisplayIndex) {
							$('td:eq(1)', nRow).addClass("hidetd");
							$('td:eq(0)', nRow).addClass("hidetd");
							
							/*if(aData[0]!='null')
							{ 
								if(aData[7]=='0')
								{
									var imgTag = '<img src="<?php echo base_url(); ?>' + aData[0] + '" class="hoverImage" style="width:35px"/>';   
								}
								else
								{
									var imgTag = '<img src="<?php echo base_url(); ?>images/dsc.png" class="hoverImage" style="width:35px"/><img src="<?php echo base_url(); ?>' + aData[0] + '" class="hoverImage" style="width:35px"/>';
								}
							 }
							 else
							 {
								var imgTag ='';
							 }*/
							
							//$('td:eq(0)', nRow).html(imgTag);
							//$('td:eq(8)', nRow).addClass("hidetd");
							
							if(aData[9]==1)
							{
								var imgTag = '<img src="<?php echo base_url(); ?>images/dsc.png" class="hoverImage" title="DSC Auction" style="width:35px"/>';
							}
							else
							{
								var imgTag = '';
							}	
							
							if(aData[0] == '1')
							{      
								var actionData = '<a class="" href="<?php echo base_url(); ?>owner/eventTrack/'+aData[1]+'"><img src="/bankeauc/images/track.png" title="Track Auction" class="edit1"></a> ';
							}
							else
							{
								var actionData = '<a class="" href="<?php echo base_url(); ?>owner/eventTrack/'+aData[1]+'"><img src="/bankeauc/images/track.png" title="Track Auction" class="edit1"></a> <a href="javascript:void(0);" onclick="addtoeventfavlist('+aData[1]+')"><img src="../images/addtoFav.jpg"  width="20" height="20" title="Add to favourite" class="imgfav"></a> ';
							}
							
							$('td:eq(9)', nRow).html(actionData+imgTag);
							var spantag = '<span id="auc_'+aData[1]+'"></span>';
							//$('td:eq(0)', nRow).html(imgTag);
							$('td:eq(5)', nRow).html(spantag);
							//$('td:eq(2)',nRow).addClass("hidetd");
							var deadline = aData[6];
							setTimeout(function(){ initializeClock('auc_'+aData[1], deadline); }, 500);
							return nRow;
								  }
								});
										  
					
			// END :: LIVE AND UPCOMING AUCTION STAGE
        
        
        
			// START :: LIVE AND UPCOMING FAVOURITE AUCTION STAGE
       
        $("#upcomming_auction_main_fav thead tr th").eq(0).addClass("hidetd");
				var oTable = $('#upcomming_auction_main_fav').dataTable({
					"bAutoWidth": false,
					"aoColumns": [{"sWidth": "0%"}, {"sWidth": "7%"}, {"sWidth": "15%"}, {"sWidth": "10%"}, {"sWidth": "10%"}, {"sWidth": "10%"}, {"sWidth": "5%"}, {"sWidth": "8%"}, {"sWidth": "15%"}],
					"bProcessing": true,
					"bServerSide": true,
					"sAjaxSource": '<?php echo base_url(); ?><?php echo $controller ?>/liveupcomingAuctionDatatable_fav',
					//"bJQueryUI": true,
					"sPaginationType": "full_numbers",
					"iDisplayStart ": 10,
					"oLanguage": {
						"sProcessing": "<img src='<?php echo base_url(); ?>assets/images/ajax-loader_dark.gif'>"
					},
                                        "aoColumnDefs": [ { "bSortable": false, "aTargets": [ 7] } ],             
					
					'fnServerData': function (sSource, aoData, fnCallback)
					{
						$.ajax
								({
									'dataType': 'json',
									'type': 'POST',
									'url': sSource,
									'data': aoData,
									'success': fnCallback
								});
					},
					"fnRowCallback": function (nRow, aData, iDisplayIndex) {
						$('td:eq(0)', nRow).addClass("hidetd");
						$('td:eq(7)', nRow).addClass("hidetd");
						
						if(aData[7]==1)
						{
							var imgTag = ' <img src="<?php echo base_url(); ?>images/dsc.png" class="hoverImage" title="DSC Auction" style="width:35px"/>';
						}
						else
						{
							var imgTag = '';
						}	
						
						
							
						var spantag = '<span id="fav_'+aData[0]+'"></span>';
						//$('td:eq(0)', nRow).html(imgTag);
						$('td:eq(3)', nRow).html(spantag);
                        //$('td:eq(2)',nRow).addClass("hidetd");
                        $('td:eq(8)', nRow).html(aData[8]+imgTag);
                        var deadline = aData[4];
						setTimeout(function(){ initializeClock('fav_'+aData[0], deadline); }, 500);
						return nRow;
					}
				});
                                
			// END :: LIVE AND UPCOMING FAVOURITE AUCTION STAGE
			
			
			
			$("#concludedata_main thead tr th").eq(0).addClass("hidetd");
				var oTable = $('#concludedata_main').dataTable({
					"bAutoWidth": false,
					"aoColumns": [{"sWidth": "10%"}, {"sWidth": "15%"}, {"sWidth": "20%"}, {"sWidth": "15%"}, {"sWidth": "15%"}, {"sWidth": "15%"}, {"sWidth": "5%"}, {"sWidth": "10%"}],
					"bProcessing": true,
					"bServerSide": true,
					"sAjaxSource": '<?php echo base_url(); ?><?php echo $controller ?>/concludeCompletedAuctionsdatatable1',
					//"bJQueryUI": true,
					"sPaginationType": "full_numbers",
					"iDisplayStart ": 10,
					"oLanguage": {
						"sProcessing": "<img src='<?php echo base_url(); ?>assets/images/ajax-loader_dark.gif'>"
					},
					"fnInitComplete": function () {
						$('#big_table_paginate').addClass('oneTemp');
						$('#big_table_info').addClass('oneTemp');
						$('.oneTemp').wrapAll('<div class="tableFooter">');
						$('select[name="big_table_length"]').insertAfter('#big_table_length > label');
					   
					},
					'fnServerData': function (sSource, aoData, fnCallback)
					{
						$.ajax
								({
									'dataType': 'json',
									'type': 'POST',
									'url': sSource,
									'data': aoData,
									'success': fnCallback
								});
					},
					//"aoColumnDefs": [ { "bSortable": false, "aTargets": [ 6] } ],         
					"fnRowCallback": function (nRow, aData, iDisplayIndex) {
							$('td:eq(0)', nRow).addClass("hidetd");
							// $('td:eq(2)', nRow).addClass("hidetd");
									
						/*if(aData[0]!='null')
						{
							if(aData[7]=='1')
							{
								  var imgTag = '<img src="<?php echo base_url(); ?>images/dsc.png" class="hoverImage" style="width:35px"/><img src="<?php echo base_url(); ?>' + aData[0] + '" class="hoverImage" style="width:35px"/>';
							}
							else
							{
							  var imgTag = '<img src="<?php echo base_url(); ?>' + aData[0] + '" class="hoverImage" style="width:35px"/>';    
							}
					  
						}
						else
						{
							var imgTag ='';
						}
						
						$('td:eq(0)', nRow).html(imgTag);*/
						$('td:eq(6)', nRow).addClass("hidetd");
					   
						return nRow;
					}
				});
        
        // START ::  AUCTION INProgress

				$("#auction_inprogress thead tr th").eq(0).addClass("hidetd");
				$("#auction_inprogress thead tr th").eq(1).addClass("hidetd");
				//$("#auction_inprogress thead tr th").eq(7).addClass("hidetd");
				var oTable = $('#auction_inprogress').dataTable({
						"bAutoWidth": false,
						"aoColumns": [{"sWidth": "20%"}, {"sWidth": "20%"}, {"sWidth": "15%"}, {"sWidth": "25%"}, {"sWidth": "15%"}, {"sWidth": "15%"},{"sWidth": "12%"},{"sWidth": "5%"}],
						"bProcessing": true,
						"bServerSide": true,
						"sAjaxSource": '<?php echo base_url(); ?><?php echo $controller ?>/inprogressAuctionDatatable',
						//"bJQueryUI": true,
												"aoColumnDefs": [ { "bSortable": false, "aTargets": [ 7] } ],      
						"sPaginationType": "full_numbers",
						"iDisplayStart ": 10,
						"oLanguage": {
							"sProcessing": "<img src='<?php echo base_url(); ?>assets/images/ajax-loader_dark.gif'>"
						},
						"fnInitComplete": function () {
						//oTable.fnAdjustColumnSizing();
							$('#big_table_paginate').addClass('oneTemp');
							$('#big_table_info').addClass('oneTemp');
							$('.oneTemp').wrapAll('<div class="tableFooter">');
							$('select[name="big_table_length"]').insertAfter('#big_table_length > label');
						   
						},
						'fnServerData': function (sSource, aoData, fnCallback)
						{
							$.ajax
									({
										'dataType': 'json',
										'type': 'POST',
										'url': sSource,
										'data': aoData,
										'success': fnCallback
									});
						},
						"fnRowCallback": function (nRow, aData, iDisplayIndex) {
							$('td:eq(1)', nRow).addClass("hidetd");
							$('td:eq(0)', nRow).addClass("hidetd");
							
							/*if(aData[0]!='null')
							{ 
								if(aData[7]=='0')
								{
									var imgTag = '<img src="<?php echo base_url(); ?>' + aData[0] + '" class="hoverImage" style="width:35px"/>';   
								}
								else
								{
									var imgTag = '<img src="<?php echo base_url(); ?>images/dsc.png" class="hoverImage" style="width:35px"/><img src="<?php echo base_url(); ?>' + aData[0] + '" class="hoverImage" style="width:35px"/>';
								}
							 }
							 else
							 {
								var imgTag ='';
							 }*/
							
							//$('td:eq(0)', nRow).html(imgTag);
							//$('td:eq(7)', nRow).addClass("hidetd"); //Aziz
							
							if(aData[0] == '1')
							{      
								var actionData = '<a class="" href="<?php echo base_url(); ?>owner/eventTrack/'+aData[1]+'"><img src="/bankeauc/images/track.png" title="Track Auction" class="edit1"></a>';
							}
							else
							{
								var actionData = '<a class="" href="<?php echo base_url(); ?>owner/eventTrack/'+aData[1]+'"><img src="/bankeauc/images/track.png" title="Track Auction" class="edit1"></a> <a href="javascript:void(0);" onclick="addtoeventfavlist('+aData[1]+')"><img src="../images/addtoFav.jpg"  width="20" height="20" title="Add to favourite" class="imgfav"></a>';
							}
                                                        
							//Start: Added by aziz
							var actionDataView = '<a class="" href="<?php echo base_url(); ?>owner/pro_detail/'+aData[9]+'" ><img src="/bankeauc/images/view.png" title="View Auction" class="edit1"></a>';
							$('td:eq(7)', nRow).html(actionDataView);
							//End:Added by aziz
                             
                            //$('td:eq(8)', nRow).html(actionData);
							$('td:eq(8)', nRow).addClass("hidetd");
							                            
							return nRow;
                                                }
                                            });
										  
					
			// END ::  AUCTION INProgress
				
		});


/*
function initializeClock(id, endtime){
    var arr1 = endtime.split(' ');
    var arr2 = arr1[0].split('-');
    var endtime = arr2[2]+'-'+arr2[1]+'-'+arr2[0]+' '+arr1[1];
    //console.log(newDate);

    var clock = document.getElementById(id);
    var timeinterval = setInterval(function(){
    var t = getTimeRemaining(endtime);
    clock.innerHTML = ('0' + t.days).slice(-3) + ' D : ' +
                      ('0' + t.hours).slice(-2) + ' H : ' +
                      ('0' + t.minutes).slice(-2) + ' M : ' +
                      ('0' + t.seconds).slice(-2) +' S ';
    if(t.total<=0){
      //clearInterval(timeinterval);
      $('#'+id).html('Live');
    }
  },1000);
}
*/

function initializeClock(id, endtime){
//console.log("Step1:"+endtime);
    var arr1 = endtime.split(' ');
    var arr2 = arr1[0].split('-');
    var endtime = arr2[2]+'-'+arr2[1]+'-'+arr2[0]+' '+arr1[1];
    //console.log("Step2:"+endtime);
    var clock = document.getElementById(id);
    var test = getTimeRemaining(endtime);
   // console.log("Step3:"+JSON.stringify(test));
    var timeinterval = setInterval(function(){
    var t = getTimeRemaining(endtime);
    clock.innerHTML = ('0' + t.days).slice(-3) + ' D : ' +
                      ('0' + t.hours).slice(-2) + ' H : ' +
                      ('0' + t.minutes).slice(-2) + ' M : ' +
                      ('0' + t.seconds).slice(-2) +' S ';
    if(t.total<=0){
      //clearInterval(timeinterval);
      $('#'+id).html('Live');
    }
  },1000);
}

function getTimeRemaining(endtime){
    var arr = endtime.split(' ');
    var dateArr = arr[0];
    var timeArr = arr[1];
 //5H:30M = 5*1000*60*60 + 30*1000*60; as this expression gives UTC time.
    var t = Date.parse(new Date(dateArr+"T"+timeArr+"Z")) - Date.parse(new Date()) - 5*1000*60*60 - 30*1000*60;
    var seconds = Math.floor( (t/1000) % 60 );
    var minutes = Math.floor( (t/1000/60) % 60 );
    var hours = Math.floor( (t/(1000*60*60)) % 24 );
    var days = Math.floor( t/(1000*60*60*24) );
    
   //console.log("Step4:"+t);
  return {
    'total': t,
    'days': days,
    'hours': hours,
    'minutes': minutes,
    'seconds': seconds
  };
}  
</script>
<style>
	.hidetd{display:none;}
</style>

<section class="container_12">
                <?php // if (isset($this->session->flashdata('msg'))) { ?>
                <div style="color:red;"> <?php echo $this->session->flashdata('msg'); ?></div>
                <?php // } ?> 
		<div class="box-head">Favourite Live & Upcoming Auctions</div>
		<div style="min-height: 0px; display: block;" class="box-content no-pad">
			<div class="container-outer">
				<div class="container-inner">
						<?php 
						//set table id in table open tag
						$tmpl = array ( 'table_open'  => '<table id="upcomming_auction_main_fav" border="1" cellpadding="2" cellspacing="1" class="mytable">' );
						$this->table->set_template($tmpl); 

						$this->table->set_heading('Auction No ','Department Name', 'Property Address','Remaining Time', 'Auction Start Date', 'Auction End Date','Status', 'Action' );	
						echo $this->table->generate(); 
					  ?>
				</div>
			 </div>
		</div>

		<div class="box-head">Live & Upcoming Auctions</div>
		<div style="min-height: 0px; display: block;" class="box-content no-pad">
			<div class="container-outer">
				<div class="container-inner">
						<?php 
						//set table id in table open tag
						$tmpl = array ( 'table_open'  => '<table id="upcomming_auction_main" border="1" cellpadding="2" cellspacing="1" class="mytable">' );
						$this->table->set_template($tmpl); 

						$this->table->set_heading('','Auction No ','Department Name', 'Property Address','Property ID','Remaining Time', 'Auction Start Date', 'Auction End Date','Status', 'Action' );	
						echo $this->table->generate(); 
					  ?>
				</div>
			 </div>
		</div>
		
		<div class="box-head">Auctions In-Progress</div>
		<div style="min-height: 0px; display: block;" class="box-content no-pad">
			<div class="container-outer">
				<div class="container-inner">
						<?php 
						//set table id in table open tag
						$tmpl = array ( 'table_open'  => '<table id="auction_inprogress" border="1" cellpadding="2" cellspacing="1" class="mytable">' );
						$this->table->set_template($tmpl); 

						$this->table->set_heading('','Auction No ','Department Name', 'Property Address', 'Property ID', 'Auction Start Date', 'Auction End Date', 'Action' );	
						echo $this->table->generate(); 
					  ?>
				</div>
			 </div>
		</div>
			
		<div class="box-head">Favourite Participation Stage</div>
		<div style="min-height: 0px; display: block;" class="box-content no-pad">
			<div class="container-outer">
				<div class="container-inner">
					<?php 
						//set table id in table open tag
						$tmpl = array ( 'table_open'  => '<table id="live_event_table_fav" border="1" cellpadding="2" cellspacing="1" class="myTable">' );
						$this->table->set_template($tmpl); 

						$this->table->set_heading('Auction No ','Department Name', 'Property Address','Property ID','Apply And EMD Start Date', 'Apply And EMD End Date', 'Reserve Price','EMD', 'Action');	
						echo $this->table->generate(); 
					?>
				</div>
			</div>
		</div>		
		
				
		<div class="box-head">Participation Stage</div>
		<div style="min-height: 0px; display: block;" class="box-content no-pad">
			<div class="container-outer">
				<div class="container-inner">
					<?php 
						//set table id in table open tag
						$tmpl = array ( 'table_open'  => '<table id="live_event_table" border="1" cellpadding="2" cellspacing="1" class="myTable">' );
						$this->table->set_template($tmpl); 
						
						$this->table->set_heading('','Auction No ','Department Name', 'Property Address','Property ID','Apply And EMD Start Date', 'Apply And EMD End Date', 'Reserve Price','EMD','', 'Action' );	
						echo $this->table->generate(); 
					?>
				</div>
			</div>
		</div>
		<?php /*
		<div class="box-head">Concluded Auctions</div>
			<div style="min-height: 0px; display: block;" class="box-content no-pad">
				<div class="container-outer">
					<div class="container-inner">
					<?php 
						//set table id in table open tag
						$tmpl = array ( 'table_open'  => '<table id="concludedata_main" border="1" cellpadding="2" cellspacing="1" class="mytable">' );
						$this->table->set_template($tmpl); 

						$this->table->set_heading('Auction No ','Department Name', 'Property Address', 'Auction Start Date', 'Auction End Date','Status', 'Action' );
					
						echo $this->table->generate(); 
					?>
				</div> 
			</div>
		</div>
		*/ ?>
		
		



</section>
