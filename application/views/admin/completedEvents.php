<link rel="stylesheet" href="<?php echo base_url()?>/css/colorbox.css" />
<script src="<?php echo base_url()?>/js/jquery.colorbox.js"></script>
<link rel="stylesheet" href="<?php echo base_url();?>assets/css/jquery.dataTables.css" type="text/css" media="screen"/>	
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery.dataTables.min.js"></script>

<script type="text/javascript">
 jQuery(".auctiondetail_iframe").colorbox({iframe:true, width:"70%", height:"70%"});	

        jQuery(document).ready(function() {
			var oTable = jQuery('#big_table').dataTable( {
				"bProcessing": true,
				
				"bAutoWidth": false,
				//"aoColumns": [{"sWidth":"10%"},{"sWidth":"10%"},{"sWidth":"15%"},{"sWidth":"15%"},{"sWidth":"15%"},{"sWidth":"15%"},{"sWidth":"10%"},{"sWidth":"10%"}],
				
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
						<?php  if($this->session->userdata('role_id') == 1) { ?> 
						
							//var actn = aData[7]+' <a href="javascript:void(0)" onclick="copyAuction('+aData[0]+')" class="cpyActn" id="cpyActn"><img style="padding-left:2px;width:17px;height:auto;" src="<?php echo base_url(); ?>images/copy.png" title="Copy Auction"></a>';
							
							var actn = aData[7]+'<a href="<?php echo base_url(); ?>buyer/copy_auction/'+aData[0]+'" class="cpyActn" id="cpyActn"><img style="width:50%;" src="<?php echo base_url(); ?>images/copy.png" title="Copy Auction"></a>';
						
						<?php } else { ?>						
							var actn = aData[7];
						<?php } ?>
						
						
						jQuery('td:eq(7)',nRow).html(actn);
						
						return nRow;
				}
			});
			
			jQuery('#big_table tbody').on( 'click', 'tr td .cpyActn', function (){
			   var cnf = confirm('Are you sure to copy this auction?');
				if(cnf == true)
				{
					return true;
				}
				else
				{
					return false;
				}
			});
			
			
			var oTable1 = jQuery('#big_table2').dataTable( {
				"bProcessing": true,
				
				"bAutoWidth": false,
				//"aoColumns": [{"sWidth":"15%"},{"sWidth":"15%"},{"sWidth":"15%"},{"sWidth":"25%"},{"sWidth":"15%"},{"sWidth":"15%"}],
				
				"bServerSide": true,
				"sAjaxSource": '<?php echo base_url(); ?><?php echo $controller?>/canceleddatatable',
						//"bJQueryUI": true,
						"sPaginationType": "full_numbers",
						"iDisplayStart ":10,
						"oLanguage": {
							"sProcessing": "<img src='<?php echo base_url(); ?>assets/images/ajax-loader_dark.gif'>"
						},  
				"fnInitComplete": function() {
						//oTable.fnAdjustColumnSizing();
						
						jQuery('#big_table2_paginate').addClass('oneTemp2');
						jQuery('#big_table2_info').addClass('oneTemp2');
						jQuery('.oneTemp2').wrapAll('<div class="tableFooter">');
						jQuery('select[name="big_table2_length"]').insertAfter('#big_table2_length > label');
						
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
						//alert("dfd");
						setTimeout(function(){
						jQuery(".auctiondetail_iframe").colorbox({iframe:true, width:"65%", height:"70%"});	
						
						jQuery(".auctiondetail_iframe").addClass("cboxElement");
					},1000);
						//return nRow;
					}              
			});
			
				
		});
		
function copyAuction(id)
{			  
  sweetAlert({
			  title: 'Alert !',
			  text: "Do you want to copy this auction?",
			  type: 'warning',
			  showCancelButton: true,
			  confirmButtonColor: '#3085d6',
			  cancelButtonColor: '#d33',
			  confirmButtonText: 'Yes',
			  cancelButtonText: 'No'
			}).then(function (result) {
				if (result.value !== true) {
					return false;
				}
				//console.log(result.value);
				//return false;
				jQuery.ajax({
					url: "<?php echo base_url(); ?>buyer/copy_auction/"+id,
					type: "post",
					//data: blid:blid,
					success: function(res){	
						//console.log(res);return false;						
						window.location.replace("<?php echo base_url();?>buyer/createEvent/"+res);				
					}
				});				
				//
				
			
		});
		
  
}		
	
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
                  <div class="table-wrapper btmrg20">
                    <div class="table-heading btmrg">
                      <div class="box-head">Complete Auctions</div>

                    </div>
                     <div style="min-height: 0px; display: block;" class="box-content no-pad table-tp-space"> 
					 

<div class="container-outer">
<div class="container-inner">
						<?php 
						//set table id in table open tag
						$tmpl = array ( 'table_open'  => '<table id="big_table" border="1" cellpadding="2" cellspacing="1" class="mytable">' );
						$this->table->set_template($tmpl); 
						
						$this->table->set_heading('Auction ID', 'Property ID', 'Department Name', 'Asset on Auction', 'Reserve Price','Opening Price', 'Last Bid', 'Action' );	
						echo $this->table->generate(); 
					?>
					</div></div>
					</div>
                  </div>
                  
				  
                  <div class="table-wrapper btmrg20">
                    <div class="table-heading btmrg">
                      <div class="box-head">Canceled Auctions</div>
                      <!--<div class="srch_wrp2">
                        <input type="text" value="Search" id="search" name="search">
                        <span class="ser_icon"></span> </div>
                  </div>-->
                    <div style="min-height: 0px; display: block;" class="box-content no-pad table-tp-space"> 
					

<div class="container-outer">
<div class="container-inner">
						<?php 
				//set table id in table open tag
						$tmpl = array ( 'table_open'  => '<table id="big_table2" border="1" cellpadding="2" cellspacing="1" class="mytable">' );
						$this->table->set_template($tmpl); 
						
						$this->table->set_heading( 'Auction ID', 'Property ID', 'Department Name', 'Description', 'Reserve Price', 'Action');	
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
