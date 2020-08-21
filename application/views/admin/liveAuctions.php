<link rel="stylesheet" href="/css/colorbox.css" />
<script src="/js/jquery.colorbox.js"></script>
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/jquery.dataTables.css" type="text/css" media="screen"/>	
<script type="text/javascript" src="<?php echo VIEWBASE?>js/plugins/jquery.dataTables.min.js"></script>
<script type="text/javascript">
	jQuery(".auctiondetail_iframe").colorbox({iframe:true, width:"70%", height:"70%"});	
        jQuery(document).ready(function() {
			jQuery('#big_table thead tr th').eq(6).addClass('hidetd');
			jQuery('#big_table thead tr th').eq(7).addClass('hidetd');	
			var oTable = jQuery('#big_table').dataTable( {
				"bProcessing": true,
				
				"bAutoWidth": false,
				"aoColumns": [{"sWidth":"5%"},{"sWidth":"10%"},{"sWidth":"10%"},{"sWidth":"20%"},{"sWidth":"10%"},{"sWidth":"10%"},{"sWidth":"10%"},{"sWidth":"5%"},{"sWidth":"12%"},{"sWidth":"1%"}],
				
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
					jQuery('td:eq(7)', nRow).addClass("hidetd");
							
					setTimeout(function(){
						jQuery(".auctiondetail_iframe").colorbox({iframe:true, width:"70%", height:"70%"});	
						
						jQuery(".auctiondetail_iframe").addClass("cboxElement");
					},1000);
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
                      <div class="box-head"><?php echo "Live & Upcoming Auctions";?></div>
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
						
						//$this->table->set_heading('Auction Id','Location', 'Bank Name', 'Description', 'Start Date', 'Opening Price', 'Bidders ', 'Action');	
						 $this->table->set_heading('Auction ID','Bank Name','Assets Category','Location', 'Description','Emd Submission Last Date','Auction Start Date', 'Sales Person','Reserve Price','Action' );	
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
