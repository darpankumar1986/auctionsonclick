<link rel="stylesheet" href="<?php echo base_url()?>/css/colorbox.css" />
<script src="<?php echo base_url()?>/js/jquery.colorbox.js"></script>
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/jquery.dataTables.css" type="text/css" media="screen"/>	
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery.dataTables.min.js"></script>

<script type="text/javascript">
$(".auctiondetail_iframe").colorbox({iframe:true, width:"65%", height:"70%"});	

 $(document).ready(function() {
			var oTable = $('#cancelled_auction').dataTable( {
				"bProcessing": true,
				
				"bAutoWidth": false,
				"aoColumns": [{"sWidth":"7%"},{"sWidth":"10%"},{"sWidth":"10%"},{"sWidth":"20%"},{"sWidth":"7%"},{"sWidth":"20%"},{"sWidth":"10%"}],
				
				"bServerSide": true,
				"sAjaxSource": '<?php echo base_url(); ?><?php echo $controller?>/cancelAuctionDatatable',
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
			
			
			
			$("#completed_auction_main thead tr th").eq(0).addClass("hidetd");
			$("#completed_auction_main thead tr th").eq(2).addClass("hidetd");
			$("#completed_auction_main thead tr th").eq(4).addClass("hidetd");
			$("#completed_auction_main thead tr th").eq(5).addClass("hidetd");
			$("#completed_auction_main thead tr th").eq(6).addClass("hidetd");
			var oTable = $('#completed_auction_main').dataTable( {
				"bProcessing": true,
				
				"bAutoWidth": false,
				<!--"aoColumns": [{"sWidth":"5%"},{"sWidth":"10%"},{"sWidth":"20%"},{"sWidth":"20%"},{"sWidth":"20%"},{"sWidth":"20%"},{"sWidth":"10%"}],-->
				//	"aoColumns": [{"sWidth": "5%"}, {"sWidth": "10%"}, {"sWidth": "15%"}, {"sWidth": "5%"}, {"sWidth": "25%"}, {"sWidth": "8%"},{"sWidth": "8%"}, {"sWidth": "8%"}, {"sWidth": "5%"}],
				"bServerSide": true,
				"sAjaxSource": '<?php echo base_url(); ?><?php echo $controller?>/completeAuctionDatatable',
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
					$('td:eq(0)', nRow).addClass("hidetd");
					$('td:eq(2)', nRow).addClass("hidetd");
					$('td:eq(4)', nRow).addClass("hidetd");
					$('td:eq(5)', nRow).addClass("hidetd");
					$('td:eq(6)', nRow).addClass("hidetd");
					
					return nRow;
						  }
			});
			
				
		});

 



        $(document).ready(function() {
			var oTable = $('#concludeEvents').dataTable( {
				"bProcessing": true,
				"bAutoWidth": false,
				<!--"aoColumns": [{"sWidth":"10%"},{"sWidth":"10%"},{"sWidth":"15%"},{"sWidth":"15%"},{"sWidth":"15%"},{"sWidth":"15%"},{"sWidth":"10%"},{"sWidth":"10%"}],-->
				
				"bServerSide": true,
				"sAjaxSource": '<?php echo base_url(); ?><?php echo $controller?>/completedAuctionsdatatable',
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
		
			
			
			
				
		});
		
		
		
		
		
	
</script>
<style>
	.hidetd{display:none;}
	@media only screen and (max-width: 768px) {
		table {border-spacing: 0;border-top: 0;word-wrap: break-word;table-layout: fixed;}
		table tr th {width:33.4% !important;}
	}
</style>
<section class="container_12">

    <!--=================Auctions=====================-->

    <!--<div class="box-head">Auctions</div>-->
    <div class="box-head">Completed Auctions</div>
   <div style="min-height: 0px; display: block;" class="box-content no-pad">	
    <?php 
	//set table id in table open tag
        $tmpl = array ( 'table_open'  => '<table id="completed_auction_main" border="1" cellpadding="2" cellspacing="1" class="mytable">' );
        $this->table->set_template($tmpl); 
        $this->table->set_heading( 'Auction No.', 'Reference', 'Department Name', 'Property Address', 'Reserve Price', 'Opening Price', 'Your Last Bid', 'Action');
        echo $this->table->generate(); 
	?>
    </div>
    <!--=================Events=====================-->
    
    
					
					
<!--<div class="box-head">Auctions</div>-->
<?php /* ?>
<div class="box-head">Concluded Auctions</div>
    <div style="min-height: 0px; display: block;" class="box-content no-pad">
	<div class="container-outer">
<div class="container-inner">
        <?php 
        //set table id in table open tag
        $tmpl = array ( 'table_open'  => '<table id="concludeEvents" border="1" cellpadding="2" cellspacing="1" class="mytable">' );
        $this->table->set_template($tmpl); 

      //  $this->table->set_heading('Auction No ','Organization Name', 'Property Address', 'Start Date', 'End Date', 'Action' );	
        $this->table->set_heading('Auction No.','Reference','Department Name', 'Property Address', 'Reserve Price', 'Your&#39;FRQ' );	
        echo $this->table->generate(); 
	?>
	</div></div>
       </div>


    <!--=================Canceled / Stayed=====================-->
   <div class="box-head">Cancelled / Stayed</div>
    <div style="min-height: 0px; display: block;" class="box-content no-pad">
       <div class="container-outer">
			<div class="container-inner">
       <?php 
						//set table id in table open tag
						$tmpl = array ( 'table_open'  => '<table id="cancelled_auction" border="1" cellpadding="2" cellspacing="1" class="mytable">' );
						$this->table->set_template($tmpl); 
						$this->table->set_heading('Auction No.' , 'Reference', 'Department Name', 'Property Address', 'Reserve Price');	
						//$this->table->set_heading('Auction No ','Organization Name', 'Property Address', 'Start Date', 'End Date', 'Action' );	
						echo $this->table->generate(); 
					?>
					<?php */ ?>
       <?php 

//set table id in table open tag
              /*  $tmpl = array ( 'table_open'  => '<table id="cancelled_auction" border="1" cellpadding="2" cellspacing="1" class="mytable">' );
                $this->table->set_template($tmpl); 

                $this->table->set_heading( 'Organization Name', 'Reference', 'Account', 'Property Address', 'Reserve Price', 'Action');	
                echo $this->table->generate(); 
               * */
             
        ?>
		</div></div></div>
   </div>
</section>
