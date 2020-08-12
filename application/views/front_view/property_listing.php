<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery.dataTables.min.js?rand=<?php echo CACHE_RANDOM; ?>"></script>
<link rel="stylesheet" href="<?php echo base_url(); ?>css/colorbox.css?rand=<?php echo CACHE_RANDOM; ?>" />
<script src="<?php echo base_url(); ?>js/jquery.colorbox.js?rand=<?php echo CACHE_RANDOM; ?>"></script>
<script type="text/javascript">
var oTable = null;
    $(document).ready(function () {
        //$("#big_table thead tr th").eq(0).addClass("hidetd");


            initHomeTable();
  
            setTimeout(function(){ $("#big_table_info").text(''); }, 500);

             $("#reservePriceMaxRange,#reservePriceMinRange").keyup(function(){
                    initHomeTable();
                    setTimeout(function(){ $("#big_table_info").text(''); }, 500);
            });

            $("#search_box").on('keyup change', function () {
                var search_box = $(this).val();

                oTable.search(search_box).draw();
            });

             $("#search_ListID").on('keyup change', function () {
                //var search_box = $(this).val();
                //oTable.columns(0).search(search_box).draw();

                initHomeTable();
                setTimeout(function(){ $("#big_table_info").text(''); }, 500);
            });
            $(document).on("click",".select-items",function(){
                var isCity = $(this).closest('.custom-select').find('select').hasClass('search_city');
                if(isCity)
                {
                    var selected_text = $(this).find('.same-as-selected').html();

                    if(selected_text == 'All Cities')
                    {
                        oTable.columns(3).search('').draw();
                    }
                    else
                    {
                        oTable.columns(3).search(selected_text).draw();
                    }
                }
                else
                {
                    var selected_text = $(this).find('.same-as-selected').html();
                    if(selected_text == 'All Location')
                    {
                        oTable.columns(2).search('').draw();
                    }
                    else
                    {
                        oTable.columns(2).search(selected_text).draw();
                    }
                }
            });

            $("input[name=parent_id]").change(function(){
                var parent = $(this).val();

                $(".parent_id").each(function(){
                    var parent_id = $(this).val();
                    if(parent != parent_id)
                    {
                        $("input[data-parent="+parent_id+"]").prop('checked',false);
                    }
                });
                $("input[data-parent-id]").prop('checked',false);
                $("input[data-parent-id="+parent+"]").prop('checked',true);

                initHomeTable();
                setTimeout(function(){ $("#big_table_info").text(''); }, 500);


            });

            $("input[name=sub_id]").change(function(){
                var parent_id = $(this).attr('data-parent');

                $(".parent_id").each(function(){
                    var parent = $(this).val();

                    if(parent != parent_id)
                    {
                        $("input[data-parent="+parent+"]").prop('checked',false);
                        $("input[data-parent-id="+parent+"]").prop('checked',false);
                    }
                });

                $("input[data-parent-id="+parent_id+"]").prop('checked',true);

                initHomeTable();
                setTimeout(function(){ $("#big_table_info").text(''); }, 500);
            });
        });

        function initHomeTable()
        {
            if(oTable)
            {
                oTable.destroy();
                //oTable = null
            }
			
            var sub_id_str = '';
			<?php foreach($_GET['sc'] as $sc){ ?>
				sub_id_str += "&sub_id[]=<?php echo $sc; ?>";
			<?php } ?>
			var parent_id = "<?php echo $_GET['assetsTypeId']; ?>";
            var reservePriceMaxRange = '';
            var reservePriceMinRange = '';
            var search_box = '';
            oTable = $('#big_table').DataTable({
				dom: "<'row'<'col-sm-3'l><'col-sm-2'f><'col-sm-7'p>>" +
					"<'row'<'col-sm-12'tr>>" +
					"<'row'<'col-sm-5'i><'col-sm-7'p>>",
                "bAutoWidth": false,
                //"aoColumns": [{"sWidth": "5%"}, {"sWidth": "10%"}, {"sWidth": "20%"}, {"sWidth": "30%"}, {"sWidth": "15%"}, {"sWidth": "15%"}, {"sWidth": "15%"}, {"sWidth": "10%"}, {"sWidth": "10%"}],
                "aoColumnDefs": [ { "bSortable": false, "aTargets": [ 6] } ],
                "bProcessing": true,
                "bServerSide": true,
                "sAjaxSource": '<?php echo base_url(); ?>home/liveAuctionDatatableHome/?reservePriceMaxRange='+reservePriceMaxRange+"&reservePriceMinRange="+reservePriceMinRange+"&search_box="+search_box+"&parent_id="+parent_id+sub_id_str,
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



                      $('td:eq(6)', nRow).addClass('button-img');
                      $('td:eq(5)', nRow).html('₹'+aData[5]);


                      $('td:eq(6)', nRow).html('<a class="corrigendum_iframe" href="<?php echo base_url(); ?>home/auctionDetail/' + aData[6] + '"><img src="<?php echo base_url(); ?>assets/auctiononclick/images/view_button.png" title="View Auction" class="edit1"></a>'); /* auctionDetailPopup */

                      /*setTimeout(function(){
                            $(".corrigendum_iframe").colorbox({iframe:true, width:"65%", height:"80%",onClosed:function(){  }});
                            $(".corrigendum_iframe").addClass("cboxElement");
                        },1000);*/

                    return nRow;
                    }
                });

			  <?php if($_GET['search'] != ''){ ?>
				oTable.columns(3).search('<?php echo $_GET['search']; ?>').draw();
			  <?php } ?>
        }

        function isNumberKey(evt)
        {
            var charCode = (evt.which) ? evt.which : event.keyCode;
            console.log(charCode);
            if (charCode != 46 && charCode != 45 && charCode > 31
                    && (charCode < 48 || charCode > 57))
                return false;

            return true;
        }

</script>
<style>
.dataTables_info{display: none;}
.table-responsive{overflow-x: hidden;}
#big_table_length,.dataTables_filter,#big_table_processing{display: none;}
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
</style>
<div class="container container_margin">
            <div class="row">
                <div class="col-sm-12">
                    <div class="breadcrumb_main">
                        <ol class="breadcrumb">
                            <li><a href="#">Home</a></li>
                            <li class="active"><?php echo ucwords($_GET['search']); ?> Auctions</li>
                        </ol>
                        <h3>Bank Auctions in <?php echo ucwords($_GET['search']); ?></h3>
                    </div><!--breadcrumb_main-->
                </div>
            </div><!--row-->
        </div><!--container-->
<div class="container">
    <div class="row">
        <div class="col-sm-12">
            <div class="form_wrap_anction_search form-wrap">
                <form class="form_desc">
                    <div class="dropdown">
                        <button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown">Category
                            <span class="caret"></span></button>
                        <ul class="dropdown-menu">
                            <li class="dropdown-header"><input type="radio" id="test1" name="radio-group" checked>
                                <label for="test1">All Properties</label></li>
                            <li><label class="checkbox-inline"><input type="checkbox" value="">Land</label></li>
                            <li><label class="checkbox-inline"><input type="checkbox" value="">Residential</label></li>
                            <li><label class="checkbox-inline"><input type="checkbox" value="">Commercial</label></li>
                            <li class="dropdown-header"><input type="radio" id="test2" name="radio-group">
                                <label for="test2">All Vehicles</label></li>
                            <li><label class="checkbox-inline"><input type="checkbox" value="">Personal</label></li>
                            <li><label class="checkbox-inline"><input type="checkbox" value="">Commercial</label></li>
                            <li class="dropdown-header"><input type="radio" id="test3" name="radio-group">
                                <label for="test3">Others</label></li>
                        </ul>
                    </div>
                    <div class="custom-dropdown-select">
                        <div class="custom-select">
                            <select>
                                <option value="0">Select City</option>
                                <option value="1">All Cities</option>
                                <option value="2">Agra</option>
                                <option value="3">Ahmedabad</option>
                                <option value="4">Delhi</option>
                                <option value="5">UP</option>
                                <option value="6">Goa</option>
                                <option value="7">Kerla</option>
                                <option value="8">Ahmedabad</option>
                                <option value="9">Delhi</option>
                                <option value="10">UP</option>
                                <option value="11">Goa</option>
                                <option value="12">Kerla</option>
                            </select>
                        </div>
                    </div>
                    <div class="custom-dropdown-select">
                        <div class="custom-select">
                            <select>
                                <option value="0">Select Bank</option>
                                <option value="1">All Cities</option>
                                <option value="2">Agra</option>
                                <option value="3">Ahmedabad</option>
                                <option value="4">Delhi</option>
                                <option value="5">UP</option>
                                <option value="6">Goa</option>
                                <option value="7">Kerla</option>
                                <option value="8">Ahmedabad</option>
                                <option value="9">Delhi</option>
                                <option value="10">UP</option>
                                <option value="11">Goa</option>
                                <option value="12">Kerla</option>
                            </select>
                        </div>
                    </div>
                    <div class="search_btn_section">
                        <button class="btn btn-default btn-search" type="Search">
                            <i class="fa fa-search"></i> Search
                        </button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>
            <div class="container-fluid">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="adblock">
                            <img src="<?php echo base_url(); ?>assets/auctiononclick/images/ad_space.png">
                        </div><!--adblock-->
                    </div>
                </div><!--row-->
        </div><!--container-fluid-->
        <div class="container">
            <div class="row bank_auction_row">
                <div class="col-sm-9 border_right">
                    <div class="desc_wrapper">
                        <div class="row">
                            <div class="col-sm-9">
                                <div class="desc_wrapper_inner">
                                    <h3><?php echo (int)$totalAuction; ?> Bank Auction in <?php echo ucwords($_GET['search']); ?> </h3>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="social_platform">
                                    <ul>
                                        <li><a href="#" class="whatsapp"><i class="fa fa-whatsapp"></i></a></li>
                                        <li><a href="#" class="facebook"><i class="fa fa-facebook"></i></a></li>
                                        <li><a href="#" class="twitter"><i class="fa fa-twitter"></i></a></li>
                                        <li><a href="#" class="envelope"><i class="fa fa-envelope"></i></a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="auction_table bank_auction_table shortlisted_table table-responsive">
                        <?php
                                //set table id in table open tag
                                    $tmpl = array('table_open' => '<table id="big_table" border="1" width="100%" cellpadding="2" cellspacing="1" class="myTable auction_table_box">');
                                    $this->table->set_template($tmpl);
                                    $this->table->set_heading('List ID', 'Property Type','Location','City','EMD Submission Last Date','Reserve Price','View Details');
                                    echo $this->table->generate();
                                ?>

                    </div>

                </div>
                <div class="col-sm-3">
                    <div class="adblock_right">
                    <img src="<?php echo base_url(); ?>assets/auctiononclick/images/ad_space_other.png">
                    </div><!--adblock-->
                </div>
            </div><!--row-->
        </div><!--container-->
        <div class="container-fluid">
            <div class="row">
                <div class="col-sm-12">
                    <div class="adblock">
                        <img src="<?php echo base_url(); ?>assets/auctiononclick/images/ad_space.png">
                    </div><!--adblock-->
                </div>
            </div><!--row-->
        </div><!--container-fluid-->
