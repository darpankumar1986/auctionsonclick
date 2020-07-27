<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/jquery.dataTables.css" type="text/css" media="screen"/>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery.dataTables.min.js"></script>
<style>
	.body_main{margin-top: 30px!important;}
    .dataTables_length {
        width: 283px; top:-32px; color:#000!important;   text-shadow:none!important;margin-right: 200px!important;margin-top: 3px!important;}
    .dataTables_wrapper .dataTables_filter, .dataTables_wrapper .dataTables_length {color: #000;text-shadow:none!important;font-size: 12px;}
    .dataTables_length{display:none!important;}
    /*.dataTables_filter{display:none!important;}*/
    .dataTables_filter label{font-size:14px; font-weight: bold;}
    .dataTables_filter{ margin: 0 auto; width: 100%; text-align:center;}
    /*#big_table_info{display: none;}*/
    .dataTables_wrapper .dataTables_filter input{background-color:#fff !important;}
    .dataTables_filter input{width:25% !important;}
    .dataTables_filter label{  font-size: 1em;color: #fff;font-weight:normal; }
    .dataTables_filter{ top: -26px;text-align:right;}
    table.dataTable thead th{color: #ca3111;padding: 3px 3px !important;}
    .dataTables_filter{right: 5px!important;top: -36px!important;}
    .table_bg table tbody td{font-size: 12px !important;}
    
</style>

 <link rel="stylesheet" href="<?php echo base_url(); ?>css/colorbox.css" />
<link rel="stylesheet" href="<?php echo base_url(); ?>bankeauc/css/tables.css" />
<script src="<?php echo base_url(); ?>js/jquery.colorbox.js"></script>

<script>
jQuery(document).ready(function () {

jQuery(".auction_detail_iframe").colorbox({iframe: true, width: "85%", height: "90%", onClosed: function () {
//jQuery(".inline_auctiondetail").click();
jQuery(".inline_auctiondetail");
}});
});

</script>

<style>
	.form_bg{width:98%; float:left; background:#fff; padding:5px 1%; border-radius:5px; }
	.datagrid table {width:100%; border:solid 1px #ccc;}
	table.dataTable thead th {font-weight: normal; border-right: solid 1px#ccc;  padding:10px 2%;   font-size: 12px;}
	table.dataTable thead th:last-child {border-right: none;}
	.datagrid table tbody td{border-right: solid 1px#ccc;}
	.datagrid table tbody td:last-child{border-right: none;}
	.datagrid table tbody td {font-size:9px; word-wrap:break-word; cursor:pointer;     word-break: break-all; }
	.dataTables_info{float:left; font-size:10px;}
	.btn{ margin:0 0; border-radius:0; font-size:12px; padding: 3px 10px!important; color:#fff;     background: #0c7e99;}
	.selected{background:#cccccc !important;}
	.row-custom{width:100%; float:left; background:#fff; padding:0 1%; text-align:center;}
	#big_table_processing img{width: 50px;}
	#big_table_processing{background-color: transparent;border: 0px;}
	
	#menu1  {	 padding: 0px 0% 0 8%;  }
#menu1 li {display:inline-block; padding: 0px 2%; line-height:35px;    border-left: solid 1px #ccc; }
#menu1 li:last-child{border-right: solid 1px #ccc;}
#menu1 li a{color:#fff; text-decoration:none; font-size:.9em; text-transform:uppercase; }
#menu1 li:hover{background:#a71a00;}
.active{background:#a71a00;}
.color1{color:#F00;}
header {
    background: #fff;
    border-top: solid 3px #bd2000;
    width: 85%;
    border-bottom: solid 1px #961a00;
    padding: 5px 7.5%;
} 
</style>

<!-- Controller : HOME -->
<script type="text/javascript">
    $("#big_table thead tr th").eq(5).addClass("hidetd");
    $("#big_table thead tr th").eq(6).addClass("hidetd");
    $("#big_table thead tr th").eq(7).addClass("hidetd");
    $("#big_table thead tr th").eq(8).addClass("hidetd");
    $(document).ready(function () {
        var oTable = $('#big_table').dataTable({
            "bAutoWidth": false,
            //"aoColumns": [{"sWidth": "3%"}, {"sWidth": "10%"}, {"sWidth": "5%"}, {"sWidth": "25%"}, {"sWidth": "3%"}, {"sWidth": "10%"}, {"sWidth": "10%"},{"sWidth": "5%","bSortable": false, "mData": null}],
            "aoColumnDefs":[
                            { "aTargets": [ 0 ], "sWidth": "5%" },
                            { "aTargets": [ 1 ], "sWidth": "10%" },
                            { "aTargets": [ 2 ], "sWidth": "5%" },
                            { "aTargets": [ 3 ], "sWidth": "20%" },
                            { "aTargets": [ 4 ], "sWidth": "5%" },
                            { "aTargets": [ 5 ], "sWidth": "10%" },
                            { "aTargets": [ 6 ], "sWidth": "15%" },
                            { "aTargets": [ 7 ], "sWidth": "5%", "bSortable": false, "mData": null }   
                        ],
            "bProcessing": true,
            "bServerSide": true,
            "sAjaxSource": '<?php echo base_url(); ?><?php echo $controller ?>/archiveAuctionDatatable',
            "sPaginationType": "full_numbers",
            "iDisplayStart ": 10,
            "order": [[ 2, "DESC" ]],
            "oLanguage": {
                "sProcessing": "<img src='<?php echo base_url(); ?>assets/images/ajax-loader_dark.gif'>"
            },      
            "fnInitComplete": function () {
                $('#big_table_paginate').addClass('oneTemp');
                $('#big_table_info').addClass('oneTemp');
                $('.oneTemp').wrapAll('<div class="tableFooter">');
                $('select[name="big_table_length"]').insertAfter('#big_table_length > label');
            },
            'fnServerData': function (sSource, aoData, fnCallback){
                $.ajax({    'dataType': 'json',
                            'type': 'POST',
                            'url': sSource,
                            'data': aoData,
                            'success': fnCallback
                        });
            },
            "fnRowCallback": function (nRow, aData, iDisplayIndex) {				
                 
                if(aData[2].length>200){
                  $('td:eq(3)', nRow).html(aData[2].substring(0, 200)+'...');
                }else{
                    $('td:eq(3)', nRow).html(aData[2]);
                }
                
                $('td:eq(0)', nRow).html(iDisplayIndex +1); //For Adding Serial Number(S.No.)
                
                $('td:eq(1)', nRow).html(aData[0]);
                $('td:eq(2)', nRow).html(aData[1]);
                $('td:eq(3)', nRow).attr('title',aData[2]);
                $('td:eq(4)', nRow).html(aData[3]);
                $('td:eq(5)', nRow).html(aData[4]);
                
                if(aData[7]==1)
                {
                    var txt = 'Awarded To '+aData[5]+' @ '+aData[8]+' per '+aData[6]
                    $('td:eq(6)', nRow).html(txt);
                
                }
                else  if(aData[7]==2)
                {
                   var txt = 'Bid has been rejected'
                   $('td:eq(6)', nRow).html(txt);
                }
                else if(aData[7]==null && aData[5]!=null)
                {
                    $('td:eq(6)', nRow).html('Not awarded yet!');  
                }
                else if(aData[7]==null && aData[5]==null)
                {
                    $('td:eq(6)', nRow).html('No bidder participated');  
                }
                
                //$('td:eq(6)', nRow).addClass("hidetd");	
               // $('td:eq(7)', nRow).addClass("hidetd");	
                /*
                if(aData[1] == 15){
                    $('td:eq(6)', nRow).html('Awarded To Ram Avtar Sharma @ 20,250.00 per Square Meter');
                }else{
                    $('td:eq(6)', nRow).html('No bidder participated');
                }*/
                $('td:eq(7)', nRow).html(aData[9]);
                
                   //$('td:eq(6)', nRow).addClass("hidetd");
                  //$('td:eq(5)', nRow).html(d[2]+" "+ months[parseInt(d[1]-1,10)]+" "+d[0]);
                  //console.log(aData);
                  //$(nRow).click(function () { checklocation(aData);  });
                return nRow;
                }
            });
        });        
</script>
<style>
.hidetd{display:none;}
</style>
				
<section id="body_wrapper" style="min-height: 400px;">
    <!--body main start-->
    <div class="body_main">
		<?php  ?>
        <?php if (isset($_GET['status']) && $_GET['status'] == '1') { ?>
            <div class="error1">Please Login to Participate Auction.</div>
        <?php } ?>
        <div style="clear:both"></div>
        
        <div class="heading_bg">          
				<div style="color: #fff;font-weight:bold;">Archived Auctions</div>
            </div>
        </div>
        
         <section class="table_bg">
          <!--table bg start-->
            <div class="container-outer">
                <div class="container-inner">
                    <?php
                    //set table id in table open tag
                    $tmpl = array('table_open' => '<table id="big_table" border="1" width="100%" cellpadding="2" cellspacing="1" class="myTable">');
                    $this->table->set_template($tmpl);
                    $this->table->set_heading('S.No.','Property ID', 'Auction No.', 'Auction Details ', 'Zone', 'Area', 'Status', 'View details');
                    echo $this->table->generate();
                    ?>
                </div>
            </div>
        </section>
        <?php  ?>
        <!--table bg end-->
		<?php /* ?>
		<?php if($bankIdbyshortname == ''){ ?>
        <div class="participating_bank">Participating Banks</div>
        <div class="table_bg"><!--bank icon start-->
            <ul class="bank_icon_bg">
                <?php
                foreach ($bankData as $bankImage) {
                    if ($bankImage->thumb_logopath!='') {
                        ?>
                        <li><a href="<?php echo base_url(); ?><?php echo $bankImage->shortName; ?>"><img src="<?php echo $bankImage->thumb_logopath; ?>" class="bank_image" width="30" height="30"></a></li>
                        <?php
                            }
                         }
                     ?>
            </ul>
        </div><!--bank icon end-->
        <?php } ?>
        <?php */ ?>
    </div><!--body_main end-->
</section><!--body_wrapper end-->


