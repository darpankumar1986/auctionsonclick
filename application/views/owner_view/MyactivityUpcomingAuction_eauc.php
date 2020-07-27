<link rel="stylesheet" href="<?php echo base_url();?>assets/css/jquery.dataTables.css" type="text/css" media="screen"/>	
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery.dataTables.min.js"></script>
<script type="text/javascript">
        $(document).ready(function() {

			$("#upcomming_auction_main thead tr th").eq(0).addClass("hidetd");
			$("#upcomming_auction_main thead tr th").eq(1).addClass("hidetd");
			
			var oTable = $('#upcomming_auction_main').dataTable({
            "bAutoWidth": false,
            "aoColumns": [{"sWidth": "0%"}, {"sWidth": "0%"}, {"sWidth": "5%"}, {"sWidth": "15%"}, {"sWidth": "10%"}, {"sWidth": "10%"}, {"sWidth": "10%"}, {"sWidth": "5%"}, {"sWidth": "10%"}, {"sWidth": "15%"}],
            "bProcessing": true,
            "bServerSide": true,
            "sAjaxSource": '<?php echo base_url(); ?><?php echo $controller ?>/liveupcomingAuctionDatatable',
            //"bJQueryUI": true,
            "sPaginationType": "full_numbers",
            "iDisplayStart ": 10,
          	//"aoColumnDefs":  [{ "bSortable": false, "aTargets": [7 ] }] ,
  
            "oLanguage": {
               
                "sProcessing": "<img src='<?php echo base_url(); ?>assets/images/ajax-loader_dark.gif'>"
            },
            "fnInitComplete": function () {
				//oTable.fnAdjustColumnSizing();
                $('#big_table_paginate').addClass('oneTemp');
                $('#big_table_info').addClass('oneTemp');
                $('.oneTemp').wrapAll('<div class="tableFooter">');
                $('select[name="big_table_length"]').insertAfter('#big_table_length > label');
               
            },
            'fnServerData': function (sSource, aoData, fnCallback)
            {
                $.ajax
                        ({
                            'dataType': 'json',
                            'type': 'POST',
                            'url': sSource,
                            'data': aoData,
                            'success': fnCallback
                        });
            },
            "fnRowCallback": function (nRow, aData, iDisplayIndex) {
				$('td:eq(0)', nRow).addClass("hidetd");
				$('td:eq(1)', nRow).addClass("hidetd");
				//$('td:eq(4)', nRow).addClass("hidetd");
                /*if(aData[0]!='null')
				{ 
					if(aData[7]=='0')
					{
						var imgTag = '<img src="<?= base_url(); ?>' + aData[0] + '" class="hoverImage" style="width:35px"/>';   
					}
					else
					{
						var imgTag = '<img src="<?= base_url(); ?>images/dsc.png" class="hoverImage" style="width:35px"/><img src="<?= base_url(); ?>' + aData[0] + '" class="hoverImage" style="width:35px"/>';
					}
				 }
				 else
				 {
					var imgTag ='';
				 }
				
                $('td:eq(0)', nRow).html(imgTag);*/
                $('td:eq(8)', nRow).addClass("hidetd");
                
                if(aData[0] == '1')
                {
					var actionData = '<a class="" href="<?= base_url(); ?>owner/eventTrack/'+aData[1]+'"><img src="/bankeauc/images/track.png" title="Track Auction" class="edit1"></a>';
				}else{

					var actionData = '<a class="" href="<?= base_url(); ?>owner/eventTrack/'+aData[1]+'"><img src="/bankeauc/images/track.png" title="Track Auction" class="edit1"></a> <a href="javascript:void(0);" onclick="addtoeventfavlist('+aData[1]+')"><img src="../images/addtoFav.jpg"  width="20" height="20" title="Add to favourite" class="imgfav"></a>';
				}
                $('td:eq(9)', nRow).html(actionData);
                
                $(nRow).click(function () {
                });

                var spantag = '<span id="auc_'+aData[1]+'"></span>';
                //$('td:eq(0)', nRow).html(imgTag);
                $('td:eq(4)', nRow).html(spantag);
                //$('td:eq(2)',nRow).addClass("hidetd");
                var deadline = aData[6];
                setTimeout(function(){ initializeClock('auc_'+aData[1], deadline); }, 500);
                return nRow;
            }
        });
		
		$("#upcomming_auction_main_fav thead tr th").eq(0).addClass("hidetd");
		var oTable = $('#upcomming_auction_main_fav').dataTable({
            "bAutoWidth": false,
            "aoColumns": [{"sWidth": "0%"}, {"sWidth": "7%"}, {"sWidth": "15%"}, {"sWidth": "10%"}, {"sWidth": "10%"}, {"sWidth": "10%"}, {"sWidth": "5%"}, {"sWidth": "8%"}, {"sWidth": "15%"}],
            "bProcessing": true,
            "bServerSide": true,
            //  "aoColumnDefs":  [{ "bSortable": false, "aTargets": [6 ] }] ,   
            "sAjaxSource": '<?php echo base_url(); ?><?php echo $controller ?>/liveupcomingAuctionDatatable_fav',
            //"bJQueryUI": true,
            "sPaginationType": "full_numbers",
            "iDisplayStart ": 10,
            "oLanguage": {
                "sProcessing": "<img src='<?php echo base_url(); ?>assets/images/ajax-loader_dark.gif'>"
            },
               
            "fnInitComplete": function () {
                $('#big_table_paginate').addClass('oneTemp');
                $('#big_table_info').addClass('oneTemp');
                $('.oneTemp').wrapAll('<div class="tableFooter">');
                $('select[name="big_table_length"]').insertAfter('#big_table_length > label');
               
            },
            'fnServerData': function (sSource, aoData, fnCallback)
            {
                $.ajax
                        ({
                            'dataType': 'json',
                            'type': 'POST',
                            'url': sSource,
                            'data': aoData,
                            'success': fnCallback
                        });
            },
            "fnRowCallback": function (nRow, aData, iDisplayIndex) {
				$('td:eq(0)', nRow).addClass("hidetd");
				$('td:eq(7)', nRow).addClass("hidetd");
				//$('td:eq(3)', nRow).addClass("hidetd");
                /*if(aData[0]!='null')
				{ 
					if(aData[6]=='0')
					{
						var imgTag = '<img src="<?= base_url(); ?>' + aData[0] + '" class="hoverImage" style="width:35px"/>';   
					}
					else
					{
						var imgTag = '<img src="<?= base_url(); ?>images/dsc.png" class="hoverImage" style="width:35px"/><img src="<?= base_url(); ?>' + aData[0] + '" class="hoverImage" style="width:35px"/>';
					}
				 }
				 else
				 {
					var imgTag ='';
				 }

                $('td:eq(0)', nRow).html(imgTag);*/
       
                $(nRow).click(function () {
					
                });
                var spantag = '<span id="fav_'+aData[0]+'"></span>';
                //$('td:eq(0)', nRow).html(imgTag);
                $('td:eq(3)', nRow).html(spantag);
                //$('td:eq(2)',nRow).addClass("hidetd");
                var deadline = aData[4];
                setTimeout(function(){ initializeClock('fav_'+aData[0], deadline); }, 500);
                return nRow;
            }
        });
        
});

function initializeClock(id, endtime){
    //console.log("Step1:"+endtime);
    var arr1 = endtime.split(' ');
    var arr2 = arr1[0].split('-');
    var endtime = arr2[2]+'-'+arr2[1]+'-'+arr2[0]+' '+arr1[1];
    //console.log("Step2:"+endtime);
    var clock = document.getElementById(id);
    var test = getTimeRemaining(endtime);
   // console.log("Step3:"+JSON.stringify(test));
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
    
   //console.log("Step4:"+t);
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

	<div class="box-head">Favourite Live & Upcoming Auctions</div>
		<div style="min-height: 0px; display: block;" class="box-content no-pad">
			<div class="container-outer">
				<div class="container-inner">
						<?php 
						//set table id in table open tag
						$tmpl = array ( 'table_open'  => '<table id="upcomming_auction_main_fav" border="1" cellpadding="2" cellspacing="1" class="mytable">' );
						$this->table->set_template($tmpl); 

						$this->table->set_heading('Auction No ','Department Name', 'Property Address','Remaining Time', 'Auction Start Date', 'Auction End Date','Status', 'Action' );	
						echo $this->table->generate(); 
					  ?>
				</div>
			 </div>
		</div>

    <!--<div class="box-head">Live Events</div>-->
    <div class="box-head">Live & Upcoming Auctions</div>
		<div style="min-height: 0px; display: block;" class="box-content no-pad">
        <div id="dt1_wrapper" class="dataTables_wrapper" role="grid">
		<div class="container-outer">
                        <div class="container-inner">
            <?php 
            //set table id in table open tag
            $tmpl = array ( 'table_open'  => '<table id="upcomming_auction_main" border="1" cellpadding="2" cellspacing="1" class="mytable">' );
            $this->table->set_template($tmpl); 
            $this->table->set_heading('','Auction No ','Department Name', 'Property Address', 'Remaining Time','Auction Start Date', 'Auction End Date','Status', 'Action' );	
            echo $this->table->generate(); 
          ?>
		  </div>
		  </div>
         </div>
		 </div>
</section>
