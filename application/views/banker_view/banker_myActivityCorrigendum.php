<!--<link rel="stylesheet" href="/css/colorbox.css" />-->
<!--<script src="/js/jquery.colorbox.js"></script>-->
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/jquery.dataTables.css" type="text/css" media="screen"/>	
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery.dataTables.min.js"></script>

<script type="text/javascript">

        $(document).ready(function() {			
			var oTable = $('#big_table').dataTable( {
				"bProcessing": true,
				
				"bAutoWidth": false,
				<!--"aoColumns": [{"sWidth":"8%"},{"sWidth":"10%"},{"sWidth":"20%"},{"sWidth":"14%"},{"sWidth":"10%"},{"sWidth":"10%"},{"sWidth":"10%"},{"sWidth":"10%"},{"sWidth":"8%"}],-->
				
				"bServerSide": true,
				"sAjaxSource": '<?php echo base_url(); ?><?php echo $controller?>/corrigendumdatatable',
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
						$(".corrigendum_detail_iframe").colorbox({iframe:true, width:"65%", height:"70%"});	
						
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
						//alert("dfd");
						setTimeout(function(){
						$(".corrigendum_detail_iframe").colorbox({iframe:true, width:"65%", height:"70%"});	
						
						$(".corrigendum_detail_iframe").addClass("cboxElement");
					},1000);
						//return nRow;
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
                <?php //echo $leftPanel?>
                <div class="secttion-right">
                  <div class="table-wrapper btmrg20">
                    <div class="table-heading btmrg">
                      <div class="box-head"><?php echo $heading?></div>
					  
					  <!--<a class='corrigendum_detail_iframe' href="/banker/emdDetailPopup/9">EMD</a>-->
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
						
						$this->table->set_heading( 'S.No.', 'Property ID', 'Property Address', 'Offer Submission Date', 'Opening Date', 'Auction Start Date','Auction End Date', 'Amendment Date','Action');	
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
