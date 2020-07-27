<link rel="stylesheet" href="<?php echo base_url();?>assets/css/jquery.dataTables.css" type="text/css" media="screen"/>	
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery.dataTables.min.js"></script>
<script type="text/javascript">
        $(document).ready(function() {
			var oTable = $('#big_table').dataTable( {
				"bProcessing": true,
				"bServerSide": true,
				"sAjaxSource": '<?php echo base_url(); ?><?php echo $controller?>/matchingRequirementDatatable',
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
<section>
  
    <?php echo $breadcrumb;?>
  
  <div class="row">
    <div class="wrapper-full">
      <div class="dashboard-wrapper">
          
        <div class="search-row">
          <div class="srch_wrp">
            <input type="text" value="Search" id="search" name="search">
            <span class="ser_icon"></span> </div>
          <a href="#">Advance Search+</a> 
        </div>
          
        <div id="tab-pannel6" class="btmrgn">
            
          <ul class="tabs6">
            <a href="/owner"><li class="active" rel="tab1">Buy</li></a>
            <a href="/owner/sell"><li rel="tab2">Sell</li></a>
          </ul>
            
          <div class="tab_container6"> 
              
            <!---- buy tab container start ---->
            <div id="tab1" class="tab_content6" style="display:block">
              <div id="tab-pannel3" class="btmrgn">
                  <ul class="tabs3">
                    <a href="/owner/sell"><li class="active" rel="tab9">My Summary</li></a>
                  <a href="/owner/liveAuction"><li rel="tab10">My Activity</li></a>
                  <a href="/owner/myMessage?type=sell"><li rel="tab11">My Message</li></a>
                  <a href="/owner/myProfile?type=sell"><li rel="tab12">My Profile</li></a>
                </ul>
                <div class="tab_container7 whitebg"> 
                 
                  
                  <!-- Sell > My Activity start -->
                  
                  <div id="tab10" class="tab_content7">
                    <div class="container">
                      <div class="secttion-left">
                        <div class="left-widget">
                          <div id="cssmenu">
                            <ul>
                              <li class="has-sub "><a href="#"><span>My Auction</span></a>
                                <ul >
                                  <li><a href="/owner/liveAuction">Live Auction</a> </li>
                                  <li><a href="/owner/upcomingAuction">Upcoming Auction</a> </li>
                                  <li><a href="/owner/completedAuction">Completed Auction</a> </li>
                                  <li><a href="/owner/CancelAuction">Cancel Auction</a> </li>
                                  <!--<li><a href="/owner/postRequirement">Report Generated</a> </li>-->
                                </ul>
                              </li>
                              <li class="has-sub active"><a href="#"><span>My Requirement</span></a>
                                <ul style="display: block;">
                                  <li><a href="/owner/postRequirement" >Post Requirement</a> </li>
                                  <li><a href="/owner/manageRequirement">Manage Requirement</a> </li>
                                  <li><a href="/owner/matchingRequirement">Matching Requirement</a> </li>
                                </ul>
                              </li>
                              <li><a href="/owner/followBank" class="no-drop"><span>Bank you follow</span></a></li>
                              <li><a href="/owner/allFavorites" class="no-drop"><span>All Favorites</span></a></li>
                              <li><a href="/owner/lastSearch" class="no-drop"><span>View Last Search</span></a></li>
                            </ul>
                          </div>
                        </div>
                      </div>
                      <div class="secttion-right">
						<div class="table-wrapper btmrg20">
                    <div class="table-heading btmrg">
                      <div class="heading4"><?php echo $heading?></div>
                      <!--<div class="srch_wrp2">
                        <input type="text" value="Search" id="search" name="search">
                        <span class="ser_icon"></span> </div>-->
                    </div>
                    <div class="table-section"> 
						<?php 
						//set table id in table open tag
						$tmpl = array ( 'table_open'  => '<table id="big_table" border="1" cellpadding="2" cellspacing="1" class="mytable">' );
						$this->table->set_template($tmpl); 
						
						$this->table->set_heading('Sl No.','Property Type', 'City', 'Budget', 'Post Date', 'Action');	
						echo $this->table->generate(); 
					?>
					</div>
                  </div>
                     </div>
                    </div>
                  </div>
                  <!-- Sell > My Activity end --> 
                  
                  
                 
                  
                </div>
              </div>
            </div>
            <!---- Sell tab container end ----> 
            
          </div>
        </div>
      </div>
    </div>
  </div>
</section>
