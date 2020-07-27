<link rel="stylesheet" href="<?php echo base_url();?>assets/css/jquery.dataTables.css" type="text/css" media="screen"/>	
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery.dataTables.min.js"></script>
<script type="text/javascript">
        $(document).ready(function() {
			// START :: PARTICIPATION STAGE
			
			$("#live_event_table thead tr th").eq(0).addClass("hidetd");
			$("#live_event_table thead tr th").eq(1).addClass("hidetd");
			$("#live_event_table thead tr th").eq(2).addClass("hidetd");			
			$("#live_event_table thead tr th").eq(5).addClass("hidetd");
			$("#live_event_table thead tr th").eq(6).addClass("hidetd");
			$("#live_event_table thead tr th").eq(7).addClass("hidetd");
			$("#live_event_table thead tr th").eq(8).addClass("hidetd");
			$("#live_event_table thead tr th").eq(9).addClass("hidetd");
			
			var rdrlink = 0;
			var oTable = $('#live_event_table').dataTable({
						"bAutoWidth": false,
						//"aoColumns": [{"sWidth": "5%"}, {"sWidth": "8%"}, {"sWidth": "8%"}, {"sWidth": "20%"}, {"sWidth": "15%"}, {"sWidth": "10%"}, {"sWidth": "10%"},{"sWidth": "10%"}, {"sWidth": "10%"}, {"sWidth": "5%"}, {"sWidth": "30%"}],
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
							$('td:eq(0)', nRow).addClass("hidetd");							
							$('td:eq(1)', nRow).addClass("hidetd");							
							$('td:eq(2)', nRow).addClass("hidetd");							
							$('td:eq(5)', nRow).addClass("hidetd");
							$('td:eq(6)', nRow).addClass("hidetd");
							$('td:eq(7)', nRow).addClass("hidetd");							
							$('td:eq(8)', nRow).addClass("hidetd");							
							$('td:eq(9)', nRow).addClass("hidetd");
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
						
			// START :: FAVOURITE PARTICIPATION STAGE
			
					$("#live_event_table_fav thead tr th").eq(0).addClass("hidetd");
					$("#live_event_table_fav thead tr th").eq(1).addClass("hidetd");
					$("#live_event_table_fav thead tr th").eq(4).addClass("hidetd");			
					$("#live_event_table_fav thead tr th").eq(5).addClass("hidetd");
					$("#live_event_table_fav thead tr th").eq(6).addClass("hidetd");
					$("#live_event_table_fav thead tr th").eq(7).addClass("hidetd");					
					$("#live_event_table_fav thead tr th").eq(9).addClass("hidetd");
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
							$('td:eq(1)', nRow).addClass("hidetd");							
							$('td:eq(4)', nRow).addClass("hidetd");							
							$('td:eq(5)', nRow).addClass("hidetd");
							$('td:eq(6)', nRow).addClass("hidetd");
							$('td:eq(7)', nRow).addClass("hidetd");		
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
								
								var actionData = '<a class="" href="<?php echo base_url(); ?>owner/auctionParticipage/'+aData[0]+'"><img src="/bankeauc/images/track.png" title="Track Auction" class="edit1"></a> <a class="" href="<?php echo base_url(); ?>owner/pro_detail/'+aData[9]+'" ><img src="/bankeauc/images/view.png" title="View Auction" class="edit1"></a> <a class="" href="javascript:void(0);" onclick="removefromlivefavEventlist('+aData[0]+')"><img src="../images/addtoFav.jpg"  width="20" height="20" title="Remove from favourite" class="imgfav"></a>'+imgTag;
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
			
				
		});
</script>
<section class="container_12">
	
	<div class="box-head">Favorite Participation Stage</div>
    <div style="min-height: 0px; display: block;" class="box-content no-pad">
        <div id="dt1_wrapper" class="dataTables_wrapper" role="grid">
				<div class="fg-toolbar ui-toolbar ui-corner-tl ui-corner-tr ui-helper-clearfix">
                <div class="dataTables_length" id="dt1_length">
				</div>
                <div class="box-content no-pad">
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
    </div>
    
    <div class="box-head">Participation Stage</div>
    <div style="min-height: 0px; display: block;" class="box-content no-pad">
        <div id="dt1_wrapper" class="dataTables_wrapper" role="grid">
				<div class="fg-toolbar ui-toolbar ui-corner-tl ui-corner-tr ui-helper-clearfix">
                <div class="dataTables_length" id="dt1_length">
				</div>
                <div class="box-content no-pad">
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
    </div>
</section>
<style>
	.hidetd{display:none;}
	@media only screen and (max-width: 768px) {
		table {border-spacing: 0;border-top: 0;word-wrap: break-word;table-layout: fixed;}
		table tr th {width:33.4% !important;}
	}
</style>
