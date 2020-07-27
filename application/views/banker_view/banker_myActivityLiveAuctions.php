<link rel="stylesheet" href="<?php echo base_url();?>assets/css/jquery.dataTables.css" type="text/css" media="screen"/>	
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery.dataTables.min.js"></script>
<script type="text/javascript">
        $(document).ready(function() {
			var oTable = $('#big_table').dataTable( {
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
                                                         if(aData[9]==6) //check stageid 
							{
								var actn = aData[10];
								//+' <a class="b_action" href="<?php echo base_url(); ?>buyer/add_bidder_live_auction/'+aData[0]+'">Add bidders</a>'
							}
							else
							{
								var actn = aData[10];
							}
							$('td:eq(9)',nRow).html(actn);
							var imgTag =aData[0];
						
                            $('td:eq(0)', nRow).html(imgTag);
							$(nRow).click(function () {
							
							});
							var spantag = '<span id="fav_'+aData[0]+'"></span>';
							$('td:eq(4)', nRow).html(spantag);
							
							var deadline = aData[5];
							setTimeout(function(){ initializeClock('fav_'+aData[0], deadline); }, 500);
							return nRow;
							return nRow;
						},
			});			
			
				
		});
function initializeClock(id, endtime){	
	var arr1 = endtime.split(' ');
	var arr2 = arr1[0].split('-');
	var endtime = arr2[2]+'-'+arr2[1]+'-'+arr2[0]+' '+arr1[1];
	//console.log(newDate);
	
  var clock = document.getElementById(id);
  var timeinterval = setInterval(function(){
    var t = getTimeRemaining(endtime);
    clock.innerHTML = ('0' + t.days).slice(-3) + ' D : ' +
                      ('0' + t.hours).slice(-2) + ' H : ' +
                      ('0' + t.minutes).slice(-2) + ' M : ' +
                      ('0' + t.seconds).slice(-2) +' S ';
    if(t.total<=0){
      //clearInterval(timeinterval);
      $('#'+id).html('Live');
    }
  },1000);
}

function getTimeRemaining(endtime){
  var arr = endtime.split(' ');
  var dateArr = arr[0];
  var timeArr = arr[1];
 //5H:30M = 5*1000*60*60 + 30*1000*60; as this expression gives UTC time.
  var t = Date.parse(new Date(dateArr+"T"+timeArr+"Z")) - Date.parse(new Date()) - 5*1000*60*60 - 30*1000*60;
  var seconds = Math.floor( (t/1000) % 60 );
  var minutes = Math.floor( (t/1000/60) % 60 );
  var hours = Math.floor( (t/(1000*60*60)) % 24 );
  var days = Math.floor( t/(1000*60*60*24) );
  return {
    'total': t,
    'days': days,
    'hours': hours,
    'minutes': minutes,
    'seconds': seconds
  };
}  
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
						
						//$this->table->set_heading('Auction Id','Property ID', 'Institution Name', 'Property Address', 'Start Date', 'Opening Price', 'Bidders ', 'Action');	
						 $this->table->set_heading('Auction ID','Property ID', 'Department Name', 'Property Address','Remaining Time', 'Start Date', 'Reserve Price', 'Bidders', 'Action' );	
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
