<!--<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/jquery.dataTables.css" type="text/css" media="s-creen"/>-->
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery.dataTables.min.js?rand=<?php echo CACHE_RANDOM; ?>"></script>
<script src="<?php echo base_url();?>js/jquery-ui-1.12.1.js?rand=<?php echo CACHE_RANDOM; ?>" type="text/javascript"></script>
<script type="text/javascript" src="<?php echo base_url()?>js/calender/jquery-ui-timepicker-addon.min.js?rand=<?php echo CACHE_RANDOM; ?>"></script>
<link rel="stylesheet" href="<?php echo base_url()?>js/calender/jquery-ui-timepicker-addon.css?rand=<?php echo CACHE_RANDOM; ?>">
<script src="<?php echo base_url(); ?>assets/auctiononclick/js/bootstrap.min.js?rand=<?php echo CACHE_RANDOM; ?>"></script>
<script type="text/javascript">
    $(document).ready(function () {
        //$("#big_table thead tr th").eq(0).addClass("hidetd");
        $("#big_table thead tr th").eq(4).css('text-align','right');
        $('#big_table').DataTable({
                "bAutoWidth": false,
                //"aoColumns": [{"sWidth": "5%"}, {"sWidth": "10%"}, {"sWidth": "20%"}, {"sWidth": "30%"}, {"sWidth": "15%"}, {"sWidth": "15%"}, {"sWidth": "15%"}, {"sWidth": "10%"}, {"sWidth": "10%"}],
                "aoColumnDefs": [ { "bSortable": false, "aTargets": [ 6] } ],
                "bProcessing": true,
                "bServerSide": true,
                "sAjaxSource": '<?php echo base_url(); ?>owner/allShortlistedAuctionDatatable/',
                "sPaginationType": "full_numbers",
                "iDisplayStart ": 10,
                "oLanguage": {
                    "sProcessing": "<img src='<?php echo base_url(); ?>assets/images/ajax-loader_dark.gif'>"
                },
                "fnInitComplete": function () {
                   /* $('#big_table_paginate').addClass('oneTemp');
                    $('#big_table_info').addClass('oneTemp');
                    $('.oneTemp').wrapAll('<div class="tableFooter">');
                    $('select[name="big_table_length"]').insertAfter('#big_table_length > label');*/
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


                       $('td:eq(0)', nRow).addClass('hide');
                      $('td:eq(6)', nRow).addClass('button-img');
                      $('td:eq(5)', nRow).html('₹'+indian_money_format(aData[5])).css('text-align','right');


                      $('td:eq(6)', nRow).html('<a class="corrigendum_iframe" href="<?php echo base_url(); ?>home/auctionDetail/' + aData[6] + '"><img src="<?php echo base_url(); ?>assets/auctiononclick/images/view_button.png" title="View Auction" class="edit1"></a>'); /* auctionDetailPopup */

                      /*setTimeout(function(){
                            $(".corrigendum_iframe").colorbox({iframe:true, width:"65%", height:"80%",onClosed:function(){  }});
                            $(".corrigendum_iframe").addClass("cboxElement");
                        },1000);*/

                    return nRow;
                    }
            });


        $('#big_table2').DataTable({
                "bAutoWidth": false,
                //"aoColumns": [{"sWidth": "5%"}, {"sWidth": "10%"}, {"sWidth": "20%"}, {"sWidth": "30%"}, {"sWidth": "15%"}, {"sWidth": "15%"}, {"sWidth": "15%"}, {"sWidth": "10%"}, {"sWidth": "10%"}],
                "aoColumnDefs": [ { "bSortable": false, "aTargets": [ 6] } ],
                "bProcessing": true,
                "bServerSide": true,
                "sAjaxSource": '<?php echo base_url(); ?>owner/propertyShortlistedAuctionDatatable/',
                "sPaginationType": "full_numbers",
                "iDisplayStart ": 10,
                "oLanguage": {
                    "sProcessing": "<img src='<?php echo base_url(); ?>assets/images/ajax-loader_dark.gif'>"
                },
                "fnInitComplete": function () {
                   /* $('#big_table_paginate').addClass('oneTemp');
                    $('#big_table_info').addClass('oneTemp');
                    $('.oneTemp').wrapAll('<div class="tableFooter">');
                    $('select[name="big_table_length"]').insertAfter('#big_table_length > label');*/
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


                       $('td:eq(0)', nRow).addClass('hide');
                      $('td:eq(6)', nRow).addClass('button-img');
                      $('td:eq(5)', nRow).html('₹'+indian_money_format(aData[5])).css('text-align','right');


                      $('td:eq(6)', nRow).html('<a class="corrigendum_iframe" href="<?php echo base_url(); ?>home/auctionDetail/' + aData[6] + '"><img src="<?php echo base_url(); ?>assets/auctiononclick/images/view_button.png" title="View Auction" class="edit1"></a>'); /* auctionDetailPopup */

                      /*setTimeout(function(){
                            $(".corrigendum_iframe").colorbox({iframe:true, width:"65%", height:"80%",onClosed:function(){  }});
                            $(".corrigendum_iframe").addClass("cboxElement");
                        },1000);*/

                    return nRow;
                    }
            });

            $('#big_table3').DataTable({
                "bAutoWidth": false,
                //"aoColumns": [{"sWidth": "5%"}, {"sWidth": "10%"}, {"sWidth": "20%"}, {"sWidth": "30%"}, {"sWidth": "15%"}, {"sWidth": "15%"}, {"sWidth": "15%"}, {"sWidth": "10%"}, {"sWidth": "10%"}],
                "aoColumnDefs": [ { "bSortable": false, "aTargets": [ 6] } ],
                "bProcessing": true,
                "bServerSide": true,
                "sAjaxSource": '<?php echo base_url(); ?>owner/vehicleShortlistedAuctionDatatable/',
                "sPaginationType": "full_numbers",
                "iDisplayStart ": 10,
                "oLanguage": {
                    "sProcessing": "<img src='<?php echo base_url(); ?>assets/images/ajax-loader_dark.gif'>"
                },
                "fnInitComplete": function () {
                   /* $('#big_table_paginate').addClass('oneTemp');
                    $('#big_table_info').addClass('oneTemp');
                    $('.oneTemp').wrapAll('<div class="tableFooter">');
                    $('select[name="big_table_length"]').insertAfter('#big_table_length > label');*/
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


                       $('td:eq(0)', nRow).addClass('hide');
                      $('td:eq(6)', nRow).addClass('button-img');
                      $('td:eq(5)', nRow).html('₹'+indian_money_format(aData[5])).css('text-align','right');


                      $('td:eq(6)', nRow).html('<a class="corrigendum_iframe" href="<?php echo base_url(); ?>home/auctionDetail/' + aData[6] + '"><img src="<?php echo base_url(); ?>assets/auctiononclick/images/view_button.png" title="View Auction" class="edit1"></a>'); /* auctionDetailPopup */

                      /*setTimeout(function(){
                            $(".corrigendum_iframe").colorbox({iframe:true, width:"65%", height:"80%",onClosed:function(){  }});
                            $(".corrigendum_iframe").addClass("cboxElement");
                        },1000);*/

                    return nRow;
                    }
            });

            $('#big_table4').DataTable({
                "bAutoWidth": false,
                //"aoColumns": [{"sWidth": "5%"}, {"sWidth": "10%"}, {"sWidth": "20%"}, {"sWidth": "30%"}, {"sWidth": "15%"}, {"sWidth": "15%"}, {"sWidth": "15%"}, {"sWidth": "10%"}, {"sWidth": "10%"}],
                "aoColumnDefs": [ { "bSortable": false, "aTargets": [ 6] } ],
                "bProcessing": true,
                "bServerSide": true,
                "sAjaxSource": '<?php echo base_url(); ?>owner/otherShortlistedAuctionDatatable/',
                "sPaginationType": "full_numbers",
                "iDisplayStart ": 10,
                "oLanguage": {
                    "sProcessing": "<img src='<?php echo base_url(); ?>assets/images/ajax-loader_dark.gif'>"
                },
                "fnInitComplete": function () {
                   /* $('#big_table_paginate').addClass('oneTemp');
                    $('#big_table_info').addClass('oneTemp');
                    $('.oneTemp').wrapAll('<div class="tableFooter">');
                    $('select[name="big_table_length"]').insertAfter('#big_table_length > label');*/
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


                       $('td:eq(0)', nRow).addClass('hide');
                      $('td:eq(6)', nRow).addClass('button-img');
                      $('td:eq(5)', nRow).html('₹'+indian_money_format(aData[5])).css('text-align','right');


                      $('td:eq(6)', nRow).html('<a class="corrigendum_iframe" href="<?php echo base_url(); ?>home/auctionDetail/' + aData[6] + '"><img src="<?php echo base_url(); ?>assets/auctiononclick/images/view_button.png" title="View Auction" class="edit1"></a>'); /* auctionDetailPopup */

                      /*setTimeout(function(){
                            $(".corrigendum_iframe").colorbox({iframe:true, width:"65%", height:"80%",onClosed:function(){  }});
                            $(".corrigendum_iframe").addClass("cboxElement");
                        },1000);*/

                    return nRow;
                    }
            });

    });

</script>
<style>
.hide{dispaly:none;}
.dataTables_info{display: none;}
.table-responsive{overflow-x: hidden;}
#big_table_length,.dataTables_filter,#big_table_processing{display: none;}
#big_table2_length,.dataTables_filter,#big_table2_processing{display: none;}
#big_table3_length,.dataTables_filter,#big_table3_processing{display: none;}
#big_table4_length,.dataTables_filter,#big_table4_processing{display: none;}
/*
.dataTables_paginate{float: right;}
.dataTables_paginate .pagination{ border-radius: 0;}
.dataTables_paginate .pagination li{ border-radius: 0 !important;}
.dataTables_paginate .pagination li a{ border-radius: 0 !important; border: 0;
    color: #666666;
    font-size: 13px;padding: 6px 12px;}
.dataTables_paginate .pagination li.active a{ background-color: #5e23dc;
    color: #ffffff;
    border-radius: 4px !important;}
.dataTables_paginate .pagination li:hover a{cursor: pointer;}
.pagination>li a:focus{border: 0px !important;}
*/
</style>
<body>
    <div class="auction-main auction-main-wrapper">

        <div class="container-fluid container_margin">
               <div class="row ad_row_width">
                   <div class="col-sm-12">
                       <h3 class="premium_service shortlisted_head"><span><i class="fa fa-star"></i></span>Shortlisted Auctions - <?php echo $allShortlistedAuctionsCounts; ?></h3>
                   </div>
               </div>
           </div>

        <div class="container-fluid">
            <div class="row ad_row_width">
                <div class="col-sm-12">
                    <div class="login_page pan_subscription shortlisted_auctions">
                        <div class="login_inner_page">
                            <ul class="nav nav-tabs">
                                <li class="active"><a data-toggle="tab" href="#all"><?php echo $allShortlistedAuctionsCounts; ?> <span>All</span></a></li>
                                <li><a data-toggle="tab" href="#Properties"><?php echo $propertyShortlistedAuctionsCounts; ?> <span>Shortlisted Properties</span></a></li>
                                <li><a data-toggle="tab" href="#Vehicles"><?php echo $vehicleShortlistedAuctionsCounts; ?> <span>Shortlisted Vehicles</span></a></li>
                                <li><a data-toggle="tab" href="#Others"><?php echo $otherShortlistedAuctionsCounts; ?> <span>Others</span></a></li>
                            </ul>
                        </div>
                    </div>
                </div>
            </div><!--row-->
            <div class="row">
                <div class="container">
                    <div class="row">
                        <div class="col-sm-12">
                            <div class="tab-content pan_subscription_tab">
                                <div id="all" class="tab-pane fade in active">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="auction_table shortlisted_table table-responsive">
                                                <?php
                                                //set table id in table open tag
                                                    $tmpl = array('table_open' => '<table id="big_table" border="1" width="100%" cellpadding="2" cellspacing="1" class="myTable auction_table_box">');
                                                    $this->table->set_template($tmpl);
                                                    $this->table->set_heading('Bank Name', 'Description','City','EMD Submission Last Date','Reserve Price','View Details');
                                                    echo $this->table->generate();
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div id="Properties" class="tab-pane fade">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="auction_table shortlisted_table table-responsive">
                                                <?php
                                                //set table id in table open tag
                                                    $tmpl = array('table_open' => '<table id="big_table2" border="1" width="100%" cellpadding="2" cellspacing="1" class="myTable auction_table_box">');
                                                    $this->table->set_template($tmpl);
                                                    $this->table->set_heading('Bank Name', 'Description','City','EMD Submission Last Date','Reserve Price','View Details');
                                                    echo $this->table->generate();
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div id="Vehicles" class="tab-pane fade">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="auction_table shortlisted_table table-responsive">
                                                <?php
                                                //set table id in table open tag
                                                    $tmpl = array('table_open' => '<table id="big_table3" border="1" width="100%" cellpadding="2" cellspacing="1" class="myTable auction_table_box">');
                                                    $this->table->set_template($tmpl);
                                                    $this->table->set_heading('Bank Name', 'Description','City','EMD Submission Last Date','Reserve Price','View Details');
                                                    echo $this->table->generate();
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                                <div id="Others" class="tab-pane fade">
                                    <div class="row">
                                        <div class="col-sm-12">
                                            <div class="auction_table shortlisted_table table-responsive">
                                                <?php
                                                //set table id in table open tag
                                                    $tmpl = array('table_open' => '<table id="big_table4" border="1" width="100%" cellpadding="2" cellspacing="1" class="myTable auction_table_box">');
                                                    $this->table->set_template($tmpl);
                                                    $this->table->set_heading('Bank Name', 'Description','City','EMD Submission Last Date','Reserve Price','View Details');
                                                    echo $this->table->generate();
                                                ?>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                    </div>
            </div>
        </div><!--container-fluid-->

    </div><!--auction-main-->

</body>
