<link rel="stylesheet" href="<?php echo base_url();?>assets/css/jquery.dataTables.css" type="text/css" media="screen"/>	
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery.dataTables.min.js"></script>
<style>
.container_12 .dataTables_wrapper .dataTables_filter, .dataTables_wrapper .dataTables_length{padding-top: 0px !important;}
.dataTables_wrapper .dataTables_filter input{width:250px;} 
</style>
<script type="text/javascript">
        $(document).ready(function() {
			var oTable = $('#big_table').dataTable( {
				"bProcessing": true,
				"pageLength": 50,
				"bAutoWidth": false,
				//"aoColumns": [{"sWidth":"10%"},{"sWidth":"11%"},{"sWidth":"17%"},{"sWidth":"17%"},{"sWidth":"15%"},{"sWidth":"15%"},{"sWidth":"15%"}],
				
				"bServerSide": true,
				"sAjaxSource": '<?php echo base_url(); ?>superadmin/pass/getBankerPasswordList',
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
			
			//oTable.fnSort( [ [0,'DESC'] ] );	
		});
</script>


					
 <section class="container_12">
      <div class="row">
    <div class="wrapper-full">
          <div class="dashboard-wrapper">
        <div class="container tab_content3">
              <div class="secttion-left"></div>
              <div class="secttion-right">
              
							
                <div style="color:green;"><br/>	
					    <?php if( $this->session->flashdata('message')) {?>
								<span class="success_msg"><img src="<?php echo VIEWBASE; ?>images/icon_checkmark_small.png" class="success_tick">
								<?php echo $this->session->flashdata('message'); ?></span>		
						<?php } ?>
				</div>
                
                <div class="table-wrapper btmrg20 tpmrg20">
                              <div class="table-heading btmrg">
                            <div class="box-head"><?php echo $heading;?></div>
                            
                          </div>
                           <div style="min-height: 0px; display: block;" class="box-content no-pad table-tp-space"> 
                            <?php 
									//set table id in table open tag
									$tmpl = array ( 'table_open'  => '<table id="big_table" border="1" cellpadding="2" cellspacing="1" class="mytable">' );
									$this->table->set_template($tmpl); 
									
									$this->table->set_heading('id', 'First Name', 'Email', 'User ID', 'Indate','Status','Register As','Action');	
									echo $this->table->generate(); 
								?> 	
                          </div>
                            </div>
          </div>
            </div>
      </div>
        </div>
  </div>
    </section>
   
