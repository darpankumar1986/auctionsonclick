<?php

    if(isset($_GET['search']) and !empty($_GET['search']))
    {
        $search_box=$_GET['search'];
    }
    if(isset($_GET['search_city']) and !empty($_GET['search_city']))
    {
        $search_city=$_GET['search_city'];
    }
    if(isset($_GET['bank']) and !empty($_GET['bank']))
    {
        $bank_ID=$_GET['bank'];
    }
    if(isset($_GET['parent_id']) and !empty($_GET['parent_id']))
    {
        $parent_id=$_GET['parent_id'];
    }

    /*if(isset($_GET['sc']) and !empty($_GET['sc']))
    {
        $subCatArray = array();
        foreach($_GET['sc'] as $sub_cat)
        {
            $subCatArray[] = $sub_cat;
        }
    }
    
    echo 'etst';
    print_r($subCatArray);die;
    */
    if(isset($_GET['borrower_name']) and !empty($_GET['borrower_name']))
    {
        $borrower_name=$_GET['borrower_name'];
    }
    if(isset($_GET['search_location']) and !empty($_GET['search_location']))
    {
        $search_location=$_GET['search_location'];
    }
    if(isset($_GET['auction_start_date']) and !empty($_GET['auction_start_date']))
    {
        $auction_start_date=$_GET['auction_start_date'];
    }
    if(isset($_GET['auction_end_date']) and !empty($_GET['auction_end_date']))
    {
        $auction_end_date=$_GET['auction_end_date'];
    }
    if(isset($_GET['reservePriceMinRange']) and !empty($_GET['reservePriceMinRange']))
    {
        $reservePriceMinRange=$_GET['reservePriceMinRange'];
    }
    if(isset($_GET['reservePriceMaxRange']) and !empty($_GET['reservePriceMaxRange']))
    {
        $reservePriceMaxRange=$_GET['reservePriceMaxRange'];
    }


?>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery.dataTables.min.js?rand=<?php echo CACHE_RANDOM; ?>"></script>
<script src="<?php echo base_url();?>js/jquery-ui-1.12.1.js?rand=<?php echo CACHE_RANDOM; ?>" type="text/javascript"></script>
<script type="text/javascript" src="<?php echo base_url()?>js/calender/jquery-ui-timepicker-addon.min.js?rand=<?php echo CACHE_RANDOM; ?>"></script>
<link rel="stylesheet" href="<?php echo base_url()?>js/calender/jquery-ui-timepicker-addon.css?rand=<?php echo CACHE_RANDOM; ?>">
<script src="<?php echo base_url(); ?>assets/auctiononclick/js/bootstrap.min.js?rand=<?php echo CACHE_RANDOM; ?>"></script>
<script type="text/javascript">

var oTable = null;
    $(document).ready(function () {
        //$("#big_table thead tr th").eq(0).addClass("hidetd");


            initHomeTable();

            $(document).on("click",".select-items",function(){
                var dataSortValue = '';
                var isDataSort = $(this).closest('.custom-select').find('select').hasClass('dataSort');
                if(isDataSort)
                {
                    var selected_text_sort = $(this).find('.same-as-selected').html();

                    if(selected_text_sort == 'Newest (Default Sort)')
                    {
                        dataSortValue = 1;
                    }
                    if(selected_text_sort == 'Price (High to Low)')
                    {
                        dataSortValue = 2;
                    }
                    if(selected_text_sort == 'Price (Low to High)')
                    {
                        dataSortValue = 3;
                    }
                    //alert(selected_text_sort);

                initHomeTable();
                //setTimeout(function(){ $("#big_table_info").text(''); }, 500);
                }
            });
            $(".dropdown-header input[name=parent_id]").change(function(){
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

                //initHomeTable();
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

                //initHomeTable();
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
            var parent_id = $('.dropdown-header input[name=parent_id]:checked').val();
            if(typeof(parent_id) == 'undefined')
            {
                parent_id ='';
            }
            var sub_id_str = '';
            $("input[name=sub_id]:checked").each(function(){
                var sub_id = $(this).val();
                sub_id_str += '&sc[]='+sub_id;
            });

            //var dataSort = $("#dataSort").val();
            var  dataSortValue = $(".select-items").closest('.custom-select').find('select option:selected').val();
            if(dataSortValue !='')
            {
                dataSortValue = "&dataSortValue="+dataSortValue;
            }

            var search_city = $("#search_city").val();
            if(search_city !='')
            {
                search_city = "&search_city="+search_city;
            }

            var borrower_name = $("#borrower_name").val();
            if(borrower_name !='')
            {
                borrower_name = "&borrower_name="+borrower_name;
            }

            var search_location = $("#search_location").val();
            if(search_location !='')
            {
                search_location = "&search_location="+search_location;
            }

            var bank = $("#bank option:selected").val();
            var bank_text = '';
            if(bank != '' && bank != 'Select Bank' && bank != 'All Cities')
            {
                bank_text = "&bank="+bank;
            }

            var reservePriceMaxRange = $("#reservePriceMaxRange").val();
            if(reservePriceMaxRange !='')
            {
                reservePriceMaxRange = "&reservePriceMaxRange="+reservePriceMaxRange;
            }

            var reservePriceMinRange = $("#reservePriceMinRange").val();
            if(reservePriceMinRange !='')
            {
                reservePriceMinRange = "&reservePriceMinRange="+reservePriceMinRange;
            }

            var auction_start_date = $("#auction_start_date").val();
            if(auction_start_date !='')
            {
                auction_start_date = "&auction_start_date="+auction_start_date;
            }

            var auction_end_date = $("#auction_end_date").val();
            if(auction_end_date !='')
            {
                auction_end_date = "&auction_end_date="+auction_end_date;
            }

            var search_box = $("#search_box").val();
            //alert(bank);
            oTable = $('#big_table').DataTable({
                dom: "<'row'<'col-sm-6 top-pagination pagination_main'p>>" +
                    "<'row'<'col-sm-12'tr>>" +
                    "<'row'<'col-sm-5'i><'col-sm-7 pagination_main'p>>",
                "bAutoWidth": false,
                //"aoColumns": [{"sWidth": "5%"}, {"sWidth": "10%"}, {"sWidth": "20%"}, {"sWidth": "30%"}, {"sWidth": "15%"}, {"sWidth": "15%"}, {"sWidth": "15%"}, {"sWidth": "10%"}, {"sWidth": "10%"}],
                "aoColumnDefs": [ { "bSortable": false, "aTargets": [ 5] } ],
                "bProcessing": true,
                "bServerSide": true,
                "sAjaxSource": '<?php echo base_url(); ?>home/advancedSearchDatatable/?search='+search_box+'&parent_id='+parent_id+sub_id_str+search_city+bank_text+borrower_name+search_location+auction_start_date+auction_end_date+reservePriceMinRange+reservePriceMaxRange+dataSortValue,
                "sPaginationType": "full_numbers",
                "iDisplayStart ": 1,
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



                      $('td:eq(5)', nRow).addClass('button-img');
                      $('td:eq(4)', nRow).html('₹'+aData[4]);


                      $('td:eq(5)', nRow).html('<a class="corrigendum_iframe" href="<?php echo base_url(); ?>home/auctionDetail/' + aData[5] + '"><img src="<?php echo base_url(); ?>assets/auctiononclick/images/view_button.png" title="View Auction" class="edit1"></a>'); /* auctionDetailPopup */

                    return nRow;
                    }
                });



        }
</script>
<style>
.dataTables_info{display: none;}
.table-responsive{overflow-x: hidden;}
#big_table_length,.dataTables_filter,#big_table_processing{display: none;}
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
<div class="container-fluid container_margin">
    <div class="row row_bg">
       <div class="container">
        <div class="col-sm-12">
            <div class="breadcrumb_main">
                <ol class="breadcrumb">
                    <li><a href="<?php echo base_url(); ?>">Home</a></li>
                    <li class="active">Advanced Search</li>
                </ol>
<!--                        <h3>Bank Auctions in Amritsar</h3>-->
            </div><!--breadcrumb_main-->
        </div>
    </div>
    </div><!--row-->
</div><!--container-fluid-->
   <div class="container-fluid">
       <div class="row ad_row_width">
           <div class="col-sm-12">
               <h3 class="premium_service">Advanced Search</h3>
           </div>
       </div>
   </div>
<div class="container">
    <div class="row advanced_search_row">
            <div class="col-sm-12">
                <div class="error" id="error_txt1" style="display: block;padding-right: 30px;margin-top: 5px;"></div>
            </div>
        </div>

    <div class="row advanced_search_row">
        <div class="col-sm-6">
            <form class="custom_form register_form custom_search_form">
                <div class="floating-form">
                    <div class="floating-label">
                        <input class="floating-input" name="search_box" id="search_box" type="text" placeholder=" " value="<?php echo $search_box ?>">
                        <label class="custom_label">Search By Keyword</label>
                    </div>
                    <div class="floating-label">
                       <div class="custom-dropdown-select custom-dropdown-select1">
                           <div class="custom-select1">
                                <input type="text" id="search_city" class="floating-input form-control item-suggest dropdown-toggle" name="x" placeholder=" " value="<?php echo $search_city;?>" />
                                <label class="custom_label">City</label>
                           </div>
                       </div>
                    </div>
                    <div class="floating-label">
                        <?php $allbank = $this->home_model->getAllBank(); ?>
                               <select name="bank" id="bank" class="floating-select" onclick="this.setAttribute('value', this.value);" value="">
                                   <option value=""></option>
                                   <?php foreach($allbank as $bank){ ?>
                                       <option value="<?php echo $bank->id; ?>" <?php echo ($bank->id==$bank_ID)?'selected="selected"':'';?> ><?php echo $bank->name; ?></option>
                                   <?php } ?>
                               </select>
                        <span class="highlight"></span>
                        <label class="custom_label">Bank Name</label>
                        <span class="eye_icon down_icon"><i class="fa fa-chevron-down"></i></span>
                    </div>
                    <div class="floating-label">
                        <input class="floating-input" name="auction_start_date" id="auction_start_date" type="text" placeholder=" " autocomplete="off" value="<?php echo $auction_start_date; ?>">
                        <label class="custom_label">Auction Start Date</label>
                    </div>
                    <div class="floating-label">
                        <input class="floating-input numericonly" name="reservePriceMinRange" id="reservePriceMinRange" type="text" placeholder=" " value="<?php echo $reservePriceMinRange; ?>">
                        <label class="custom_label">Minimum Reserve Price</label>
                    </div>
                </div>
            </form>
        </div>
        <div class="col-sm-6">
            <form class="custom_form register_form custom_search_form">
                <div class="floating-form">
                    <div class="floating-label">
                       <div class="dropdown">
                                   <button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown">Category
                                       <span class="caret"></span></button>
                                   <ul class="dropdown-menu">
                                       <?php $parentCat = $this->home_model->getAllCategory(0); ?>
                                        <?php foreach($parentCat as $key => $parCat){ ?>
                                        <li class="dropdown-header">
                                        <input type="radio" id="test<?php echo $key; ?>" class="parent_id" data-parent-id="<?php echo $parCat->id;?>" name="parent_id" value="<?php echo $parCat->id;?>" <?php echo ($parCat->id==$parent_id)?'checked="checked"':''; ?>>
                                            <label for="test<?php echo $key; ?>">All <?php echo $parCat->name; ?></label></li>
                                            <?php $Cats = $this->home_model->getAllCategory($parCat->id); ?>
                                            <?php foreach($Cats as $cat){ ?>
                                                <li><label class="checkbox-inline"><input type="checkbox" data-parent="<?php echo $parCat->id;?>" name="sub_id" value="<?php echo $cat->id;?>" <?php if(in_array($cat->id,$_GET['sc'])){ echo 'checked="checked"'; } ?>><?php echo $cat->name; ?></label></li>
                                            <?php } ?>

                                        <?php } ?>
                                   </ul>
                               </div>
                    </div>
                    <div class="floating-label">
                        <input class="floating-input" name="search_location" id="search_location" type="text" placeholder=" " value="<?php echo $search_location; ?>">
                        <label class="custom_label">Location</label>
                    </div>
                    <div class="floating-label">
                        <input class="floating-input" name="borrower_name" id="borrower_name" type="text" placeholder=" " value="<?php echo $borrower_name; ?>">
                        <label class="custom_label">Borrower Name</label>
                    </div>
                    <div class="floating-label">
                        <input class="floating-input" name="auction_end_date" id="auction_end_date" type="text" placeholder=" " autocomplete="off" value="<?php echo $auction_end_date; ?>">
                        <label class="custom_label">Auction End Date</label>
                    </div>
                    <div class="floating-label">
                        <input class="floating-input numericonly" name="reservePriceMaxRange" id="reservePriceMaxRange" type="text" placeholder=" " value="<?php echo $reservePriceMaxRange; ?>">
                        <label class="custom_label">Maximum Reserve Price</label>
                    </div>
                </div>
            </form>
        </div>
    </div><!--row-->
    <div class="row">
        <div class="col-sm-12">
            <div class="advanced_search_btn advanced_search_result_btn">
                <button type="button" class="btn search_btn_new" onclick="goAdvancedSearch(this)">Search</button>
                <button type="button" class="btn clear_btn_new" onclick="window.location='<?php echo base_url(); ?>home/advanced_search'">Clear</button>
            </div>
        </div>
    </div><!--row-->
<?php
    //print_r($subCatArray);
    if($_GET['search']=='' && $_GET['parent_id']=='' && $_GET['borrower_name']=='' && $_GET['search_location']=='' && $_GET['auction_start_date']=='' && $_GET['auction_end_date']=='' && $_GET['reservePriceMinRange']=='' && $_GET['reservePriceMaxRange']=='' && $_GET['bank']=='' && $_GET['search_city']=='') {} else {?>
    <div class="row bank_auction_row">
        <div class="col-sm-9 border_right">
            <div class="desc_wrapper">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="desc_wrapper_inner">
                            <h3><?php echo (int)$totalAuction; ?> Bank Auction </h3>
                        </div>
                    </div>
                </div>
            </div>
            <div class="auction_table bank_auction_table shortlisted_table table-responsive">
                <div class="property_dropdown_listing">
                    <div class="custom-dropdown-select">
                        <div class="custom-select">
                            <select name="dataSort" id="dataSort" class="dataSort">
                                <option value="">Sort</option>
                                <option value="1">Newest (Default Sort)</option>
                                <option value="2">Price (High to Low)</option>
                                <option value="3">Price (Low to High)</option>
                            </select>
                        </div>
                    </div>
                </div>
                <?php
                    //set table id in table open tag
                    $tmpl = array('table_open' => '<table id="big_table" border="1" width="100%" cellpadding="2" cellspacing="1" class="myTable auction_table_box">');
                    $this->table->set_template($tmpl);
                    $this->table->set_heading('Bank Name', 'Asset Details','City','EMD Submission Last Date','Reserve Price','View Details');
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
<?php } ?>
<script>
    $(document).ready(function(){
          $('#auction_start_date').datepicker({
            controlType: 'select',
            oneLine: true,
            changeMonth: true,
            changeYear: true,
            dateFormat: 'yy-mm-dd',
            yearRange: '2018:<?php echo date('Y');?>',
            //timeFormat: 'HH:mm:00'
        });
        $('#auction_end_date').datepicker({
            controlType: 'select',
            oneLine: true,
            changeMonth: true,
            changeYear: true,
            dateFormat: 'yy-mm-dd',
            yearRange: '2018:<?php echo date('Y');?>',
            //timeFormat: 'HH:mm:00'
        });


    });
	jQuery('.numericonly').keypress(function(event) {
		  if ((event.which != 46 || jQuery(this).val().indexOf('.') != -1) &&
			((event.which < 48 || event.which > 57) &&
			  (event.which != 0 && event.which != 8))) {
			event.preventDefault();
		  }

		  var text = jQuery(this).val();

		  if ((text.indexOf('.') != -1) &&
			(text.substring(text.indexOf('.')).length > 2) &&
			(event.which != 0 && event.which != 8) &&
			(jQuery(this)[0].selectionStart >= text.length - 2)) {
			event.preventDefault();
		  }
	});
</script>
</div>
