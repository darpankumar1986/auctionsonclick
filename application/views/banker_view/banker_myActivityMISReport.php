<link rel="stylesheet" href="<?php echo base_url();?>assets/css/jquery.dataTables.css" type="text/css" media="screen"/>	
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery.dataTables.min.js"></script>
<script type="text/javascript">
        $(document).ready(function() {
			var oTable = $('#big_table').dataTable( {
				"bProcessing": true,
				
				"bAutoWidth": false,
				"aoColumns": [{"sWidth":"10%"},{"sWidth":"10%"},{"sWidth":"15%"},{"sWidth":"15%"},{"sWidth":"15%"},{"sWidth":"15%"},{"sWidth":"10%"},{"sWidth":"10%"}],
				
				"bServerSide": true,
				"sAjaxSource": '<?php echo base_url(); ?><?php echo $controller?>/bankerEventMISReport',
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
				
				"bAutoWidth": false,
				"aoColumns": [{"sWidth":"10%"},{"sWidth":"10%"},{"sWidth":"15%"},{"sWidth":"15%"},{"sWidth":"10%"},{"sWidth":"10%"},{"sWidth":"10%"},{"sWidth":"10%"},{"sWidth":"10%"}],
				
				"bServerSide": true,
				"sAjaxSource": '<?php echo base_url(); ?><?php echo $controller?>/bankerDrtEventMISReport',
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
			
				
		});
</script>
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
                <?php echo $leftPanel?>
                <div class="secttion-right">
					
				<?php if($this->session->userdata('user_type') !='drt'){ ?>
                  <div class="table-wrapper btmrg20">
                    <div class="table-heading btmrg">
                      <div class="box-head">Buyer Auction MIS Report </div>
                      <!--<div class="srch_wrp2">
                        <input type="text" value="Search" id="search" name="search">
                        <span class="ser_icon"></span> </div>-->
                    </div>
                    <div style="min-height: 0px; display: block;" class="box-content no-pad table-tp-space"> 
					<div class="container-outer">
<div class="container-inner">
						<?php 
						//set table id in table open tag
						$tmpl = array ( 'table_open'  => '<table id="big_table" border="1" cellpadding="2" cellspacing="1" class="mytable">' );
						$this->table->set_template($tmpl); 
						
						$this->table->set_heading( 'Auction ID', 'Ref No','Auction Type','Invoice No','Amount', 'Date', 'Payment Collection Date', 'Collection Amount' );	
						echo $this->table->generate(); 
					?>
					</div></div>
					</div>
                  </div>
                  
                  <?php } ?>
                  <!--
                  <div class="table-wrapper btmrg20">
                    <div class="table-heading btmrg">
                      <div class="box-head">DRT Auction MIS Report </div>
                      <!--<div class="srch_wrp2">
                        <input type="text" value="Search" id="search" name="search">
                        <span class="ser_icon"></span> </div>-->
                   <!-- </div>
                    <div style="min-height: 0px; display: block;" class="box-content no-pad table-tp-space"> 
					<div class="container-outer">
<div class="container-inner">
						<?php 
						//set table id in table open tag
						$tmpl = array ( 'table_open'  => '<table id="big_table1" border="1" cellpadding="2" cellspacing="1" class="mytable">' );
						$this->table->set_template($tmpl); 
						
						$this->table->set_heading( 'Auction ID', 'Ref No','DRT Name ','Auction Type','Invoice No','Amount', 'Date', 'Payment Collection Date', 'Collection Amount');	
						echo $this->table->generate(); 
						?>
						</div></div>
					
					</div>
                  </div>-->
                  
                  
                </div>
              </div>
            </div>
            
            
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
