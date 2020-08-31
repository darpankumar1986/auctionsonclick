<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery.dataTables.min.js?rand=<?php echo CACHE_RANDOM; ?>"></script>
<script src="<?php echo base_url();?>js/jquery-ui-1.12.1.js?rand=<?php echo CACHE_RANDOM; ?>" type="text/javascript"></script>
<script type="text/javascript" src="<?php echo base_url()?>js/calender/jquery-ui-timepicker-addon.min.js?rand=<?php echo CACHE_RANDOM; ?>"></script>
<link rel="stylesheet" href="<?php echo base_url()?>js/calender/jquery-ui-timepicker-addon.css?rand=<?php echo CACHE_RANDOM; ?>">
<script src="<?php echo base_url(); ?>assets/auctiononclick/js/bootstrap.min.js?rand=<?php echo CACHE_RANDOM; ?>"></script>

<script type="text/javascript">

var oTable = null;
    $(document).ready(function () {
        //$("#big_table thead tr th").eq(0).addClass("hidetd");
		  $("#big_table thead tr th").eq(4).css('text-align','right');	

            initHomeTable();

            $(document).on("click",".sort-data .select-items",function(){
                initHomeTable();
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


            //var dataSort = $("#dataSort").val();
            var dataSortValue = '';
            var isDataSort = $('.sort-data').find('select').hasClass('dataSort');
            if(isDataSort)
            {
                var selected_text_sort = $('.sort-data').find('.same-as-selected').html();

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

                if(dataSortValue !='')
                {
                    dataSortValue = "&dataSortValue="+dataSortValue;
                }

            }


            var bank_text = "&bank=<?php echo $_GET['bank'];?>";
            var search_city = "&search_city=<?php echo $_GET['search_city'];?>";
            var parent_id = "&parent_id=<?php echo $_GET['parent_id'];?>";
            var sub_id_str = '';
            <?php
                if(is_array($_GET['sc'])){
                foreach($_GET['sc'] as $sub_cat)
                {?>
                    sub_id_str += '&sc[]='+<?php echo $sub_cat; ?>;
            <?php
                    } }
            ?>


            oTable = $('#big_table').DataTable({
                dom: "<'row'<'col-sm-6 top-pagination pagination_main'p>>" +
                    "<'row'<'col-sm-12'tr>>" +
                    "<'row'<'col-sm-5'i><'col-sm-7 pagination_main'p>>",
                "bAutoWidth": false,
                //"aoColumns": [{"sWidth": "5%"}, {"sWidth": "10%"}, {"sWidth": "20%"}, {"sWidth": "30%"}, {"sWidth": "15%"}, {"sWidth": "15%"}, {"sWidth": "15%"}, {"sWidth": "10%"}, {"sWidth": "10%"}],
                "aoColumnDefs": [ { "bSortable": false, "aTargets": [ 5] } ],
                "bProcessing": true,
                "bServerSide": true,
                "sAjaxSource": '<?php echo base_url(); ?>home/advancedSearchDatatable/?parent_id='+parent_id+sub_id_str+search_city+bank_text+dataSortValue,
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
                      $('td:eq(4)', nRow).html('₹'+aData[4]).css('text-align','right');



                      $('td:eq(5)', nRow).html('<a class="corrigendum_iframe" href="<?php echo base_url(); ?>home/auctionDetail/' + aData[5] + '"><img src="<?php echo base_url(); ?>assets/auctiononclick/images/view_button.png" title="View Auction" class="edit1"></a>'); /* auctionDetailPopup */

                    return nRow;
                    }
                });



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
					<div class="row">
					<div class="col-sm-12">
                    <div class="breadcrumb_main">
                        <ol class="breadcrumb">
                            <li><a href="<?php echo base_url();?>">Home</a></li>
                            <li class="active"><?php echo ucwords($_GET['search_city']); ?> Auctions</li>
                        </ol>
                        <!-- <h3>Bank Auctions in <?php echo ucwords($_GET['search_city']); ?></h3> -->
                    </div><!--breadcrumb_main-->
                </div>
					</div>
				</div>
            </div><!--row-->
        </div><!--container-->
<div class="container">
    <div class="row">
        <div class="col-sm-12">
            <div class="form_wrap_anction_search form-wrap form_dropdown_border">
                <form class="form_desc">
                                <div class="dropdown">
                                    <button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown" id="category_text_button">Category
                                        <span class="caret"></span></button>
                                    <ul class="dropdown-menu assetsType">
                                        <?php $parentCat = $this->home_model->getAllCategory(0); ?>
                                            <?php foreach($parentCat as $key => $parCat){ ?>
                                            <li class="dropdown-header">
                                            <input type="radio" id="test<?php echo $key; ?>" class="s_parent_id" s-data-parent-id="<?php echo $parCat->id;?>" name="parentCat" value="<?php echo $parCat->id;?>">
                                                <label for="test<?php echo $key; ?>"><?php echo ($parCat->id != 3)?'All ':'';?><?php echo $parCat->name; ?></label></li>
                                                <?php $Cats = $this->home_model->getAllCategory($parCat->id); ?>
                                                <?php foreach($Cats as $cat){ ?>
                                                    <li><label class="checkbox-inline"><input type="checkbox" s-data-parent="<?php echo $parCat->id;?>" name="s_sub_id" value="<?php echo $cat->id;?>" data-text="<?php echo $cat->name; ?>"><?php echo $cat->name; ?></label></li>
                                                <?php } ?>

                                            <?php } ?>
                                    </ul>
                                    <input type="hidden" name="assetsTypeId" id="assetsTypeId" value="0"/>
                                </div>
                                <div class="custom-dropdown-select1">
                                   <div class="custom-select1">
                                        <input type="text" id="txt-search" class="form-control item-suggest btn-default dropdown-toggle select-selected" name="x" placeholder="Type City" value="">
                                   </div>
                               </div>
                               <?php $allbank = $this->home_model->getAllBank(); ?>
                               <div class="custom-dropdown-select">
                                   <div class="custom-select">
                                       <select name="bank" id="bank">
                                           <option value="">Select Bank</option>
                                           <?php foreach($allbank as $bank){ ?>
                                               <option value="<?php echo $bank->id; ?>"><?php echo $bank->name; ?></option>
                                           <?php } ?>
                                       </select>
                                   </div>
                               </div>
                               <div class="search_btn_section">
                                   <button class="btn btn-default btn-search searhcbtn" type="button" onclick="goForSearch(this)">
                                        <i class="fa fa-search"></i> Search
                                   </button>
                               </div>
                            </form>
                            <div class="error" id="error_txt" style="margin-top:0;display: none;height: 20px;padding-right: 30px;color: #e41b1b;margin-left:0;"></div>
            </div>
        </div>
    </div>
</div>
            <div class="container-fluid container-padding">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="adblock">
                            <img src="<?php echo base_url(); ?>assets/auctiononclick/images/ad_space_insurance.png">
                        </div><!--adblock-->
                    </div>
                </div><!--row-->
        </div><!--container-fluid-->
        <div class="container">
            <div class="row bank_auction_row">
                <div class="col-sm-10">
                    <div class="desc_wrapper">
                        <div class="row">
                            <div class="col-sm-9">
                                <div class="desc_wrapper_inner">
                                    <h3><?php echo (int)$totalAuction; ?> Bank Auction in <?php echo ucwords($_GET['search_city']); ?> </h3>
                                </div>
                            </div>
                            <div class="col-sm-3">
                                <div class="social_platform">
								<?php 
									$currentURL = current_url(); //http://myhost/main
									$params   = $_SERVER['QUERY_STRING']; //my_id=1,3
									$fullURL = $currentURL . '?' . $params;
								?>
                                    <ul>
                                        <li><a href="https://wa.me/?text=<?php echo $fullURL; ?>" class="whatsapp" target="_blank"><i class="fa fa-whatsapp"></i></a></li>
                                        <li><a href="https://www.facebook.com/sharer.php?u=<?php echo $fullURL; ?>" target="_blank" class="facebook"><i class="fa fa-facebook"></i></a></li>
                                        <li><a href="https://twitter.com/share?url=<?php echo $fullURL; ?>" target="_blank" class="twitter"><i class="fa fa-twitter"></i></a></li>
                                        <li><a href="mailto:?subject=&amp;body=<?php echo $fullURL; ?>" target="_blank" class="envelope"><i class="fa fa-envelope"></i></a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="auction_table auction_table_border bank_auction_table shortlisted_table table-responsive">
                        <div class="get-alerts">
                        <button class="btn btn-default" type="button" <?php if($this->session->userdata('id')>0){ ?> onclick="addtoalert('<?php echo $_GET['search_city']; ?>')" <?php } else {?> onclick="window.location='<?php echo base_url(); ?>home/login'" <?php } ?>>
                            <i class="fa fa-bell"></i> Get Alerts
                        </button>
                        </div>
                        <div class="property_dropdown_listing">
                        <div class="custom-dropdown-select">
                           <div class="custom-select sort-data">
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
                                    $this->table->set_heading('Bank Name', 'Description','City','EMD Submission Last Date','Reserve Price','View Details');
                                    echo $this->table->generate();
                                ?>

                    </div>

                </div>
                <div class="col-sm-2  border_left">
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
                        <img src="<?php echo base_url(); ?>assets/auctiononclick/images/ad_space_insurance_bottom.png">
                    </div><!--adblock-->
                </div>
            </div><!--row-->
        </div><!--container-fluid-->
<script>

 function addtoalert(city)
{
	//alert(city);
	if (city) 
	{

		jQuery.ajax({
			url: '/home/addtoalert',
			type: 'POST',
			data: {
				city: city
			},
			success: function (response) {
				//console.log(response);
				if(response=='1')
				{
					//alert('Thank you for subscribing email alert for the '+city);
					swal('', 'Thank you for subscribing email alert for the '+city, 'success');
				}
				if(response=='2')
				{
					//alert('You have already subscribed email alert for the '+city);
					//var msg = 'You have already subscribed email alert for the '+city;
					swal('', 'You have already subscribed email alert for the '+city, 'warning');
				}
				if(response=='0')
				{
					//alert('Invaild City');
					swal('Oops!', 'Invaild City', 'error');
				}
				//var rand = Math.random() * 10000000000000000;
				//location.href = "?rand=" + rand;
			}
		});
	}

}
</script>