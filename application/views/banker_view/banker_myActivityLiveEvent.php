<link rel="stylesheet" href="<?php echo base_url();?>assets/css/jquery.dataTables.css" type="text/css" media="screen"/>	
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery.dataTables.min.js"></script>
<script type="text/javascript">
        $(document).ready(function() {
			
			var oTable1 = $('#big_table1').dataTable( {
				"bProcessing": true,
				
				"bAutoWidth": false,
				"aoColumns": [{"sWidth":"5%"},{"sWidth":"10%"},{"sWidth":"10%"},{"sWidth":"20%"},{"sWidth":"15%"},{"sWidth":"10%"},{"sWidth":"5%"},{"sWidth":"8%"},{"sWidth":"1%"},{"sWidth":"1%"}],
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
                      <div class="box-head"><?php echo "Published Auctions"?></div>
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
                  
                </div>
              </div>
            </div>
            
            
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
