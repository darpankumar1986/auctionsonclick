<link rel="stylesheet" href="<?php echo base_url();?>assets/css/jquery.dataTables.css" type="text/css" media="screen"/>	
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery.dataTables.min.js"></script>
<script type="text/javascript">
        jQuery(document).ready(function() {
			var oTable = jQuery('#big_table').dataTable( {
				"bProcessing": true,
				
				"bAutoWidth": false,
				//"aoColumns": [{"sWidth":"10%"},{"sWidth":"10%"},{"sWidth":"15%"},{"sWidth":"20%"},{"sWidth":"15%"},{"sWidth":"15%"},{"sWidth":"15%"}],
				"aoColumns": [{"sWidth":"10%"},{"sWidth":"10%"},{"sWidth":"10%"},{"sWidth":"15%"},{"sWidth":"20%"},{"sWidth":"15%"},{"sWidth":"5%"},{"sWidth":"15%"}, {"sWidth":"15%"}, {"sWidth":"15%"}],
				"aoColumnDefs": [ { "bSortable": false, "aTargets": [ 5 ] } ], 
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
						
						jQuery('#big_table_paginate').addClass('oneTemp');
						jQuery('#big_table_info').addClass('oneTemp');
						jQuery('.oneTemp').wrapAll('<div class="tableFooter">');
						jQuery('select[name="big_table_length"]').insertAfter('#big_table_length > label');
						
				 },
				'fnServerData': function(sSource, aoData, fnCallback)
				{
				  jQuery.ajax
				  ({
					'dataType': 'json',
					'type'    : 'POST',
					'url'     : sSource,
					'data'    : aoData,
					'success' : fnCallback
				  });
				},
				"fnRowCallback": function (nRow, aData, iDisplayIndex) {
							jQuery('td:eq(6)', nRow).addClass("hidetd");
							
							if(aData[0]!='null')
							{ 
								if(aData[4]=='1970-01-01 05:30:00')
								{
									var dueDate =  '';   
								}
								else
								{
									var dueDate = aData[4];
								}
							 }
							 else
							 {
								var imgTag ='';
							 }
                 
							var imgTag =  aData[0]; 
							
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
							
                            jQuery('td:eq(0)', nRow).html(imgTag);
                            jQuery('td:eq(4)', nRow).html(dueDate);
                            jQuery('td:eq(7)', nRow).html(status);
							jQuery(nRow).click(function () {
							
							});
							return nRow;
						},
			});			
			
				
		});
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
					 <?php if(isset($this->session->userdata['flash:old:message'])){?>
						<div class="success_msg"> <?php echo @$this->session->userdata['flash:old:message']; ?></div>
					<?php } ?>
						<div class="box-head"><?php echo $heading;?></div>
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
						
						//$this->table->set_heading('Property ID', 'Account', 'Description', 'Due Date', 'Reserve Price', '% Complete ', 'Action');	
						$this->table->set_heading('Auction ID','Property ID', 'Department Name', 'Description', 'Property description', 'Reserve Price', 'Status','Comments','Action');	
						
                                                echo $this->table->generate(); 
					?>
					</div></div>
</div>
                  </div>
                  
                </div>
              </div>
            </div>
            
            
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
