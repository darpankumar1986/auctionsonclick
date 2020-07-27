<link rel="stylesheet" href="/css/colorbox.css" />
<script src="/js/jquery.colorbox.js"></script>
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/jquery.dataTables.css" type="text/css" media="screen"/>	
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery.dataTables.min.js"></script>
<script type="text/javascript">
        $(document).ready(function() {
			
			var oTable4 = $('#big_table4').dataTable( {
				"bProcessing": true,
				
				"bAutoWidth": false,
				//"aoColumns": [{"sWidth":"10%"},{"sWidth":"10%"},{"sWidth":"15%"},{"sWidth":"20%"},{"sWidth":"15%"},{"sWidth":"15%"},{"sWidth":"15%"}],
				"aoColumns": [{"sWidth":"7%"},{"sWidth":"10%"},{"sWidth":"10%"},{"sWidth":"15%"},{"sWidth":"10%"},{"sWidth":"5%"},{"sWidth":"10%"},{"sWidth":"5%"},{"sWidth":"15%"}],
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
				
                </div>
              </div>
            </div>
            
            
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
