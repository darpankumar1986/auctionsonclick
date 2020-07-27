<link rel="stylesheet" href="/css/colorbox.css" />
<script src="/js/jquery.colorbox.js"></script>
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/jquery.dataTables.css" type="text/css" media="screen"/>	
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery.dataTables.min.js"></script>
<script type="text/javascript">
        $(document).ready(function() {
			var oTable = $('#big_table').dataTable( {
				"bProcessing": true,
				"bServerSide": true,
				"sAjaxSource": '<?php echo base_url(); ?><?php echo $controller?>/favLiveUpcomingAuctionsdatatable',
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
				}
			});
			
			var oTable1 = $('#big_table1').dataTable( {
				"bProcessing": true,
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
				}
			});
			
			var oTable1 = $('#big_table2').dataTable( {
				"bProcessing": true,
				"bServerSide": true,
				"sAjaxSource": '<?php echo base_url(); ?><?php echo $controller?>/concludedAuctionsdatatable',
						//"bJQueryUI": true,
						"sPaginationType": "full_numbers",
						"iDisplayStart ":10,
						"oLanguage": {
							"sProcessing": "<img src='<?php echo base_url(); ?>assets/images/ajax-loader_dark.gif'>"
						},  
				"fnInitComplete": function() {
						//oTable.fnAdjustColumnSizing();
						
						$('#big_table2_paginate').addClass('oneTemp2');
						$('#big_table2_info').addClass('oneTemp2');
						$('.oneTemp2').wrapAll('<div class="tableFooter">');
						$('select[name="big_table2_length"]').insertAfter('#big_table2_length > label');
						
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
				}
			});
			
				
		});
</script>
<section>
  <?php echo $breadcrumb;?>
  <div class="row">
    <div class="wrapper-full">
      <div class="dashboard-wrapper">
        <div class="container">
          <?php echo $leftPanel?>
          <div class="secttion-right">
            <div id="tab-pannel4" class="btmrgn">
              <ul class="tabs4">
                <li class="active" rel="tab5">Favorite Live & Upcoming Auction</li>
                <li rel="tab6">Live & Upcoming Auction</li>
                <li rel="tab7">Concluded Events</li>
              </ul>
              <div class="tab_container4">
                <div id="tab5" class="tab_content4">
                  <div class="container">
                    <div class="table-wrapper btmrg20">
                      <div class="table-heading btmrg">
                        <!--<div class="srch_wrp2">
                          <input type="text" value="Search" id="search" name="search">
                          <span class="ser_icon"></span> </div>-->
                      </div>
                      <div class="table-section"> 
						<?php 
						//set table id in table open tag
						$tmpl = array ( 'table_open'  => '<table id="big_table" border="1" cellpadding="2" cellspacing="1" class="mytable">' );
						$this->table->set_template($tmpl); 
						
						$this->table->set_heading(' ','Organization Name', 'Property Address', 'Start Date', 'End Date', 'Status', 'Action' );	
						echo $this->table->generate(); 
					?>
					</div>
                    </div>
                  </div>
                </div>
                
                <!-- #tab1 -->
                <div id="tab6" class="tab_content4">
                  <div class="container">
				  <div class="table-wrapper btmrg20">
                      <div class="table-heading btmrg">
                        <!--<div class="srch_wrp2">
                          <input type="text" value="Search" id="search" name="search">
                          <span class="ser_icon"></span> </div>-->
                      </div>
                      <div class="table-section"> 
						<?php 
						//set table id in table open tag
						$tmpl = array ( 'table_open'  => '<table id="big_table1" border="1" cellpadding="2" cellspacing="1" class="mytable">' );
						$this->table->set_template($tmpl); 
						
						$this->table->set_heading(' ','Organization Name', 'Property Address', 'Start Date', 'End Date', 'Status', 'Action' );	
						echo $this->table->generate(); 
					?>
					</div>
                    </div>
				  </div>
                </div>
                
                <!-- #tab2 -->
                
                <div id="tab7" class="tab_content4">
                  <div class="container">
				  <div class="table-wrapper btmrg20">
                      <div class="table-heading btmrg">
                        <!--<div class="srch_wrp2">
                          <input type="text" value="Search" id="search" name="search">
                          <span class="ser_icon"></span> </div>-->
                      </div>
                      <div class="table-section"> 
						<?php 
						//set table id in table open tag
						$tmpl = array ( 'table_open'  => '<table id="big_table2" border="1" cellpadding="2" cellspacing="1" class="mytable">' );
						$this->table->set_template($tmpl); 
						
						$this->table->set_heading(' ','Organization Name', 'Property Address', 'Start Date', 'End Date', 'Status', 'Action' );	
						echo $this->table->generate(); 
					?>
					</div>
                    </div>
				  </div>
                </div>
                
                <!-- #tab3 -->
              </div>
            </div>
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
