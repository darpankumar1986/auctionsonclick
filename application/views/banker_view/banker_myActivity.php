<link rel="stylesheet" href="/css/colorbox.css" />
<script src="/js/jquery.colorbox.js"></script>
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/jquery.dataTables.css" type="text/css" media="screen"/>	
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery.dataTables.min.js"></script>
<script type="text/javascript">
        $(document).ready(function() {
			$('#big_table thead tr th').eq(7).addClass('hidetd');
			var oTable = $('#big_table').dataTable( {
				"bProcessing": true,
				
				"bAutoWidth": false,
				"aoColumns": [{"sWidth":"5%"},{"sWidth":"10%"},{"sWidth":"10%"},{"sWidth":"20%"},{"sWidth":"10%"},{"sWidth":"10%"},{"sWidth":"10%"},{"sWidth":"10%"},{"sWidth":"11%"},{"sWidth":"10%"}],
				"aoColumnDefs": [ { "bSortable": false, "aTargets": [ 7] } ], 
				"bServerSide": true,
				"sAjaxSource": '<?php echo base_url(); ?><?php echo $controller?>/liveUpcomingAuctionsdatatable',
						//"bJQueryUI": true,
						"sPaginationType": "full_numbers",
						"iDisplayStart ":10,
						"oLanguage": {
							"sProcessing": "<img src='<?php echo base_url(); ?>assets/images/ajax-loader_dark.gif'>"
						},  
				"fnInitComplete": function() {
						//oTable.fnAdjustColumnSizing();
						
						$('#big_table_paginate').addClass('oneTemp');
						$('#big_table_info').addClass('oneTemp');
						$('.oneTemp').wrapAll('<div class="tableFooter">');
						$('select[name="big_table_length"]').insertAfter('#big_table_length > label');
						
				 },
				'fnServerData': function(sSource, aoData, fnCallback)
				{
				  $.ajax
				  ({
					'dataType': 'json',
					'type'    : 'POST',
					'url'     : sSource,
					'data'    : aoData,
					'success' : fnCallback
				  });
				},
				"fnRowCallback": function (nRow, aData, iDisplayIndex) {
							$('td:eq(7)', nRow).addClass("hidetd");
							$('td:eq(8)', nRow).addClass("hidetd");
							
							/*if(aData[0]!='null')
							{ 
								if(aData[7]=='0')
								{
									var imgTag =  aData[0];   
								}
								else
								{
									var imgTag = '<img src="<?= base_url(); ?>images/dsc.png" class="hoverImage" style="width:35px"/>' + aData[0];
								}
							 }
							 else
							 {
								var imgTag ='';
							 }*/
                 
							if(aData[9]==6) //check stageid 
							{
								var actn = aData[10];
								//+' <a class="b_action" href="<?php echo base_url(); ?>buyer/add_bidder_live_auction/'+aData[0]+'">Add bidders</a>'
							}
							else
							{
								var actn = aData[10];
							}
							$('td:eq(9)',nRow).html(actn);
							var imgTag =aData[0];
							
                            $('td:eq(0)', nRow).html(imgTag);
							$(nRow).click(function () {
							
							});
							var spantag = '<span id="fav_'+aData[0]+'"></span>';
							$('td:eq(4)', nRow).html(spantag);
							
							var deadline = aData[5];
							setTimeout(function(){ initializeClock('fav_'+aData[0], deadline); }, 500);
							return nRow;
						},
			});
                    
                    
			var oTable1 = $('#big_table1').dataTable( {
				"bProcessing": true,
				
				"bAutoWidth": false,
				"aoColumns": [{"sWidth":"5%"},{"sWidth":"10%"},{"sWidth":"10%"},{"sWidth":"20%"},{"sWidth":"10%"},{"sWidth":"10%"},{"sWidth":"5%"},{"sWidth":"8%"},{"sWidth":"5%"},{"sWidth":"5%"}],
				"aoColumnDefs": [ { "bSortable": false, "aTargets": [ 6] } ], 
				"bServerSide": true,
				"sAjaxSource": '<?php echo base_url(); ?><?php echo $controller?>/liveEventsdatatable',
						//"bJQueryUI": true,
						"sPaginationType": "full_numbers",
						"iDisplayStart ":10,
						"oLanguage": {
							"sProcessing": "<img src='<?php echo base_url(); ?>assets/images/ajax-loader_dark.gif'>"
						},  
				"fnInitComplete": function() {
						//oTable.fnAdjustColumnSizing();
						
						$('#big_table1_paginate').addClass('oneTemp1');
						$('#big_table1_info').addClass('oneTemp1');
						$('.oneTemp1').wrapAll('<div class="tableFooter">');
						$('select[name="big_table1_length"]').insertAfter('#big_table1_length > label');
						
				 },
				'fnServerData': function(sSource, aoData, fnCallback)
				{
				  $.ajax
				  ({
					'dataType': 'json',
					'type'    : 'POST',
					'url'     : sSource,
					'data'    : aoData,
					'success' : fnCallback
				  });
				},
				"fnRowCallback": function (nRow, aData, iDisplayIndex) {
							$('td:eq(7)', nRow).addClass("hidetd");
							$('td:eq(8)', nRow).addClass("hidetd");
							/*if(aData[0]!='null')
							{ 
								if(aData[6]=='0')
								{
									var imgTag =  aData[0];   
								}
								else
								{
									var imgTag = '<img src="<?= base_url(); ?>images/dsc.png" class="hoverImage" style="width:35px"/>' + aData[0];
								}
							 }
							 else
							 {
								var imgTag ='';
							 }*/
							if(aData[8]==6) //check stageid 
							{
								var actn = aData[9];
								//+' <a class="b_action" href="<?php echo base_url(); ?>buyer/add_bidder_live_auction/'+aData[0]+'">Add bidders</a>'
							}
							else
							{
								var actn = aData[9];
							}
							var imgTag =aData[0]; 
							
                            $('td:eq(0)', nRow).html(imgTag);
                            $('td:eq(9)',nRow).html(actn);
							$(nRow).click(function () {
							
							});
							return nRow;
						},
			});
			
			
			var oTable2 = $('#big_table2').dataTable( {
				"bProcessing": true,
				
				"bAutoWidth": false,
				//"aoColumns": [{"sWidth":"10%"},{"sWidth":"10%"},{"sWidth":"15%"},{"sWidth":"20%"},{"sWidth":"15%"},{"sWidth":"15%"},{"sWidth":"15%"}],
				"aoColumns": [{"sWidth":"5%"},{"sWidth":"10%"},{"sWidth":"10%"},{"sWidth":"20%"},{"sWidth":"10%"},{"sWidth":"10%"},{"sWidth":"10%"},{"sWidth":"12%"}, {"sWidth":"8%"}, {"sWidth":"10%"}],
				"aoColumnDefs": [ { "bSortable": false, "aTargets": [ 5] } ], 
				"bServerSide": true,
				"sAjaxSource": '<?php echo base_url(); ?><?php echo $controller?>/saveEventsdatatable',
						//"bJQueryUI": true,
						"sPaginationType": "full_numbers",
						"iDisplayStart ":10,
						"oLanguage": {
							"sProcessing": "<img src='<?php echo base_url(); ?>assets/images/ajax-loader_dark.gif'>"
						},  
				"fnInitComplete": function() {
						//oTable.fnAdjustColumnSizing();
						
						$('#big_table_paginate').addClass('oneTemp');
						$('#big_table_info').addClass('oneTemp');
						$('.oneTemp').wrapAll('<div class="tableFooter">');
						$('select[name="big_table_length"]').insertAfter('#big_table_length > label');
						
				 },
				'fnServerData': function(sSource, aoData, fnCallback)
				{
				  $.ajax
				  ({
					'dataType': 'json',
					'type'    : 'POST',
					'url'     : sSource,
					'data'    : aoData,
					'success' : fnCallback
				  });
				},
				"fnRowCallback": function (nRow, aData, iDisplayIndex) {
							$('td:eq(6)', nRow).addClass("hidetd");
							
							/*if(aData[0]!='null')
							{ 
								if(aData[5]=='0')
								{
									var imgTag =  aData[0];   
								}
								else
								{
									var imgTag = '<img src="<?= base_url(); ?>images/dsc.png" class="hoverImage" style="width:35px"/>' + aData[0];
								}
							 }
							 else
							 {
								var imgTag ='';
							 }*/
							if(aData[7]==0)
							{
								var status = 'Saved';
							}
							else if(aData[7]==1)
							{
								var status = 'Pending For Approval';
							}
							else if(aData[7]==2)
							{
								var status = 'Approved';
							}
							else if(aData[7]==3)
							{
								var status = 'Review';
							}
							else if(aData[7]==4)
							{
								var status = 'Rejected';
							}
								
							var imgTag =  aData[0];   
							
                            $('td:eq(0)', nRow).html(imgTag);
                            $('td:eq(7)', nRow).html(status);
							$(nRow).click(function () {
							
							});
							return nRow;
						},
			});		
			
			var oTable2 = $('#big_table5').dataTable( {
				"bProcessing": true,
				
				"bAutoWidth": false,
				//"aoColumns": [{"sWidth":"10%"},{"sWidth":"10%"},{"sWidth":"15%"},{"sWidth":"20%"},{"sWidth":"15%"},{"sWidth":"15%"},{"sWidth":"15%"}],
				"aoColumns": [{"sWidth":"10%"},{"sWidth":"10%"},{"sWidth":"10%"},{"sWidth":"15%"},{"sWidth":"20%"},{"sWidth":"15%"},{"sWidth":"5%"},{"sWidth":"15%"}, {"sWidth":"15%"}],
				"aoColumnDefs": [ { "bSortable": false, "aTargets": [ 5] } ], 
				"bServerSide": true,
				"sAjaxSource": '<?php echo base_url(); ?><?php echo $controller?>/rejectedEventsdatatable',
						//"bJQueryUI": true,
						"sPaginationType": "full_numbers",
						"iDisplayStart ":10,
						"oLanguage": {
							"sProcessing": "<img src='<?php echo base_url(); ?>assets/images/ajax-loader_dark.gif'>"
						},  
				"fnInitComplete": function() {
						//oTable.fnAdjustColumnSizing();
						
						$('#big_table_paginate').addClass('oneTemp');
						$('#big_table_info').addClass('oneTemp');
						$('.oneTemp').wrapAll('<div class="tableFooter">');
						$('select[name="big_table_length"]').insertAfter('#big_table_length > label');
						
				 },
				'fnServerData': function(sSource, aoData, fnCallback)
				{
				  $.ajax
				  ({
					'dataType': 'json',
					'type'    : 'POST',
					'url'     : sSource,
					'data'    : aoData,
					'success' : fnCallback
				  });
				},
				"fnRowCallback": function (nRow, aData, iDisplayIndex) {
							$('td:eq(6)', nRow).addClass("hidetd");
							
							/*if(aData[0]!='null')
							{ 
								if(aData[5]=='0')
								{
									var imgTag =  aData[0];   
								}
								else
								{
									var imgTag = '<img src="<?= base_url(); ?>images/dsc.png" class="hoverImage" style="width:35px"/>' + aData[0];
								}
							 }
							 else
							 {
								var imgTag ='';
							 }*/
							if(aData[7]==0)
							{
								var status = 'Saved';
							}
							else if(aData[7]==1)
							{
								var status = 'Pending For Approval';
							}
							else if(aData[7]==2)
							{
								var status = 'Approved';
							}
							else if(aData[7]==3)
							{
								var status = 'Review';
							}
							else if(aData[7]==4)
							{
								var status = 'Rejected';
							}
								
							var imgTag =  aData[0];   
							
                            $('td:eq(0)', nRow).html(imgTag);
                            $('td:eq(7)', nRow).html(status);
							$(nRow).click(function () {
							
							});
							return nRow;
						},
			});	
		
			var oTable1 = $('#big_table3').dataTable( {
				"bProcessing": true,
				
				"bAutoWidth": false,
				"aoColumns": [{"sWidth":"10%"},{"sWidth":"10%"},{"sWidth":"15%"},{"sWidth":"20%"},{"sWidth":"13%"},{"sWidth":"14%"},{"sWidth":"13%"},{"sWidth":"5%"},{"sWidth":"15%"}],
				"aoColumnDefs": [ { "bSortable": false, "aTargets": [ 6] } ], 
				"bServerSide": true,
				"sAjaxSource": '<?php echo base_url(); ?><?php echo $controller?>/bids_to_be_openeddatatable',
						//"bJQueryUI": true,
						"sPaginationType": "full_numbers",
						"iDisplayStart ":10,
						"oLanguage": {
							"sProcessing": "<img src='<?php echo base_url(); ?>assets/images/ajax-loader_dark.gif'>"
						},  
				"fnInitComplete": function() {
						//oTable.fnAdjustColumnSizing();
						
						$('#big_table3_paginate').addClass('oneTemp2');
						$('#big_table3_info').addClass('oneTemp2');
						$('.oneTemp3').wrapAll('<div class="tableFooter">');
						$('select[name="big_table3_length"]').insertAfter('#big_table3_length > label');
						
				 },
				'fnServerData': function(sSource, aoData, fnCallback)
				{
				  $.ajax
				  ({
					'dataType': 'json',
					'type'    : 'POST',
					'url'     : sSource,
					'data'    : aoData,
					'success' : fnCallback
				  });
				},
				"fnRowCallback": function (nRow, aData, iDisplayIndex) {
							$('td:eq(7)', nRow).addClass("hidetd");
							
							/*if(aData[0]!='null')
							{ 
								if(aData[6]=='0')
								{
									var imgTag =  aData[0];   
								}
								else
								{
									var imgTag = '<img src="<?= base_url(); ?>images/dsc.png" class="hoverImage" style="width:35px"/>' + aData[0];
								}
							 }
							 else
							 {
								var imgTag ='';
							 }*/
                 
							
							var imgTag =  aData[0];   
                            $('td:eq(0)', nRow).html(imgTag);
							$(nRow).click(function () {
							
							});
							return nRow;
						},
			});
			
			
			var oTable4 = $('#big_table4').dataTable( {
				"bProcessing": true,
				
				"bAutoWidth": false,
				//"aoColumns": [{"sWidth":"10%"},{"sWidth":"10%"},{"sWidth":"15%"},{"sWidth":"20%"},{"sWidth":"15%"},{"sWidth":"15%"},{"sWidth":"15%"}],
				"aoColumns": [{"sWidth":"10%"},{"sWidth":"10%"},{"sWidth":"10%"},{"sWidth":"15%"},{"sWidth":"20%"},{"sWidth":"15%"},{"sWidth":"5%"},{"sWidth":"15%"},{"sWidth":"15%"}],
				"aoColumnDefs": [ { "bSortable": false, "aTargets": [ 5] } ], 
				"bServerSide": true,
				"sAjaxSource": '<?php echo base_url(); ?><?php echo $controller?>/approvelRejectionEventsdatatable',
						//"bJQueryUI": true,
						"sPaginationType": "full_numbers",
						"iDisplayStart ":10,
						"oLanguage": {
							"sProcessing": "<img src='<?php echo base_url(); ?>assets/images/ajax-loader_dark.gif'>"
						},  
				"fnInitComplete": function() {
						//oTable.fnAdjustColumnSizing();
						
						$('#big_table_paginate').addClass('oneTemp');
						$('#big_table_info').addClass('oneTemp');
						$('.oneTemp').wrapAll('<div class="tableFooter">');
						$('select[name="big_table_length"]').insertAfter('#big_table_length > label');
						
				 },
				'fnServerData': function(sSource, aoData, fnCallback)
				{
				  $.ajax
				  ({
					'dataType': 'json',
					'type'    : 'POST',
					'url'     : sSource,
					'data'    : aoData,
					'success' : fnCallback
				  });
				},
				"fnRowCallback": function (nRow, aData, iDisplayIndex) {
							$('td:eq(6)', nRow).addClass("hidetd");
							
							/*if(aData[0]!='null')
							{ 
								if(aData[5]=='0')
								{
									var imgTag =  aData[0];   
								}
								else
								{
									var imgTag = '<img src="<?= base_url(); ?>images/dsc.png" class="hoverImage" style="width:35px"/>' + aData[0];
								}
							 }
							 else
							 {
								var imgTag ='';
							 }*/
							
							if(aData[7]==0)
							{
								var status = 'Saved';
							}
							else if(aData[7]==1)
							{
								var status = 'Pending For Approval';
							}
							else if(aData[7]==2)
							{
								var status = 'Approved';
							}
							else if(aData[7]==3)
							{
								var status = 'Review';
							}
							else if(aData[7]==4)
							{
								var status = 'Rejected';
							}
							
							var imgTag =  aData[0];   
							
                            $('td:eq(0)', nRow).html(imgTag);
                            $('td:eq(7)', nRow).html(status);
							$(nRow).click(function () {
							
							});
							return nRow;
						},
			});
				
		});
                
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
  <?php //echo $breadcrumb;?>
  <div class="row">
    <div class="wrapper-full">
      <div class="dashboard-wrapper">
        <div id="tab-pannel3" class="btmrgn">
          <div class="tab_container3">
            <!-- #tab1 -->
            <div id="tab6" class="tab_content3">
              <div class="container">
                <?php //echo $leftPanel?>
                <div class="secttion-right">
                <div class="table-wrapper btmrg20">
                    <div class="table-heading btmrg">

                              <div class="box-head">Live & Upcoming Auctions</div>
                              <!--<div class="srch_wrp2">
                                    <input type="text" value="Search" id="search" name="search">
                                    <span class="ser_icon"></span> </div>-->
                    </div>
            <div style="min-height: 0px; display: block;" class="box-content no-pad table-tp-space ">  
						

<div class="container-outer">
<div class="container-inner">
        <?php 
        //set table id in table open tag
        $tmpl = array ( 'table_open'  => '<table id="big_table" border="1" cellpadding="2" cellspacing="1" class="mytable  display">' );
        $this->table->set_template($tmpl); 

        $this->table->set_heading('Auction ID','Property ID', 'Department Name', 'Property Address','Remaining Time', 'Auction Start Date', 'Reserve Price', 'Bidders', 'Action' );	
        echo $this->table->generate(); 
?>
</div></div>
</div>
</div>
                    
<!--Start: Upcomming Auction Added by Azizur -->   
 <?php /*  <div class="table-wrapper btmrg20">
        <div class="table-heading btmrg">
            <div class="box-head">Live & Upcoming Auctions</div>
            <!--<div class="srch_wrp2">
                  <input type="text" value="Search" id="search" name="search">
                  <span class="ser_icon"></span> </div>-->
        </div>
        <div style="min-height: 0px; display: block;" class="box-content no-pad table-tp-space ">
            <div class="container-outer">
                <div class="container-inner">
                <?php 
                    //set table id in table open tag
                    $tmpl = array ( 'table_open'  => '<table id="big_table" border="1" cellpadding="2" cellspacing="1" class="mytable  display">' );
                    $this->table->set_template($tmpl); 

                    $this->table->set_heading('Auction ID','Property ID', 'Account', 'Property Address','Remaining Time', 'Start Date', 'Opening Price', 'Bidders', 'Action' );	
                    echo $this->table->generate(); 
                ?>
                </div>
            </div>
        </div>
    </div> */?>
<!--End: Upcoming Auctions -->

   <?php  if($this->session->userdata('role_id')!='4') { ?>			  
    <div class="table-wrapper btmrg20">
      <div class="table-heading btmrg">
        <div class="box-head">Published Auctions</div>
        <!--<div class="srch_wrp2">
          <input type="text" value="Search" id="search" name="search">
          <span class="ser_icon"></span> </div>-->
      </div>
      <div style="min-height: 0px; display: block;" class="box-content no-pad table-tp-space">


                          <div class="container-outer">
                          <div class="container-inner">
                                  <?php 
                                  //set table id in table open tag
                                  $tmpl = array ( 'table_open'  => '<table id="big_table1" border="1" cellpadding="2" cellspacing="1" class="mytable">' );
                                  $this->table->set_template($tmpl); 

                                  $this->table->set_heading('Auction ID','Property ID', 'Department Name', 'Property Address', 'Apply And EMD End Date', 'Reserve Price', 'Bids Received', 'Action');	
                                  echo $this->table->generate(); 
                                  ?>
                          </div></div>
                          </div>
    </div>
    <?php } ?>
                  
				  <?php  if($this->session->userdata('role_id')=='1') { ?>
                  <div class="table-wrapper btmrg20">
                    <div class="table-heading btmrg">
                      <div class="box-head">Saved Auctions</div>
                      <!--<div class="srch_wrp2">
                        <input type="text" value="Search" id="search" name="search">
                        <span class="ser_icon"></span> </div>-->
                    </div>
                    <div style="min-height: 0px; display: block;" class="box-content no-pad table-tp-space">
					

<div class="container-outer">
<div class="container-inner">
						<?php 
				//set table id in table open tag
						$tmpl = array ( 'table_open'  => '<table id="big_table2" border="1" cellpadding="2" cellspacing="1" class="mytable">' );
						$this->table->set_template($tmpl); 
						
						//$this->table->set_heading('Property ID', 'Account', 'Property Address', 'Due Date', 'Reserve Price', '% Complete', 'Action');	
						$this->table->set_heading('Auction ID','Property ID', 'Department Name', 'Property Address', 'Category/ Property Type', 'Reserve Price', 'Status','Comments', 'Action');	
						
                        echo $this->table->generate(); 
					?>
					</div></div>
					</div>
                  </div>
				  <?php } ?>
				  
				  <?php  if($this->session->userdata('role_id')!='4') { ?>
                  <div class="table-wrapper btmrg20">
                    <div class="table-heading btmrg">
                      <div class="box-head">Rejected Auctions</div>
                      <!--<div class="srch_wrp2">
                        <input type="text" value="Search" id="search" name="search">
                        <span class="ser_icon"></span> </div>-->
                    </div>
                    <div style="min-height: 0px; display: block;" class="box-content no-pad table-tp-space">
					

<div class="container-outer">
<div class="container-inner">
						<?php 
				//set table id in table open tag
						$tmpl = array ( 'table_open'  => '<table id="big_table5" border="1" cellpadding="2" cellspacing="1" class="mytable">' );
						$this->table->set_template($tmpl); 
						
						//$this->table->set_heading('Property ID', 'Account', 'Property Address', 'Due Date', 'Reserve Price', '% Complete', 'Action');	
						$this->table->set_heading('Auction ID','Property ID', 'Department Name', 'Property Address', 'Category/ Property Type', 'Reserve Price', 'Status','Comments');	
						
                        echo $this->table->generate(); 
					?>
					</div></div>
					</div>
                  </div>
				  <?php } ?>
				  
				  <?php  if($this->session->userdata('role_id')=='2') {?>
                  <div class="table-wrapper btmrg20">
                    <div class="table-heading btmrg">
                      <div class="box-head">Auctions For Approval/Rejection</div>
                      <!--<div class="srch_wrp2">
                        <input type="text" value="Search" id="search" name="search">
                        <span class="ser_icon"></span> </div>-->
                    </div>
                    <div style="min-height: 0px; display: block;" class="box-content no-pad table-tp-space">
					

					<div class="container-outer">
					<div class="container-inner">
						<?php 
				//set table id in table open tag
						$tmpl = array ( 'table_open'  => '<table id="big_table4" border="1" cellpadding="2" cellspacing="1" class="mytable">' );
						$this->table->set_template($tmpl); 
						
						//$this->table->set_heading('Property ID', 'Account', 'Property Address', 'Due Date', 'Reserve Price', '% Complete', 'Action');	
						$this->table->set_heading('Auction ID','Property ID', 'Department Name', 'Property Address', 'Auction Start Date', 'Reserve Price', 'Status','Action');	
						
                         echo $this->table->generate(); 
					?>
					</div></div>
					</div>
                  </div>
				  <?php }?>
				  <?php  if($this->session->userdata('role_id')!='4' && false) { ?>
                  <div class="table-wrapper btmrg20">
                    <div class="table-heading btmrg">
                      <div class="box-head">Shortlisting For Bidding Room</div>
                      <!--<div class="srch_wrp2">
                        <input type="text" value="Search" id="search" name="search">
                        <span class="ser_icon"></span> </div>-->
                    </div>
                    <div style="min-height: 0px; display: block;" class="box-content no-pad table-tp-space">
					

<div class="container-outer">
<div class="container-inner">
						<?php 
				//set table id in table open tag
						$tmpl = array ( 'table_open'  => '<table id="big_table3" border="1" cellpadding="2" cellspacing="1" class="mytable">' );
						$this->table->set_template($tmpl); 
						
						$this->table->set_heading('Auction ID','Property ID', 'Department Name', 'Property Address', 'Opening Date', 'Reserve Price', 'Bids Received', 'Action');	
						echo $this->table->generate(); 
					?></div></div>					
					</div>
                  </div>
                  <?php } ?>
                </div>
              </div>
            </div>
            
            
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
