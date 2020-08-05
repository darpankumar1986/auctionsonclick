<!--<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/jquery.dataTables.css" type="text/css" media="screen"/>-->
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery.dataTables.min.js?rand=<?php echo CACHE_RANDOM; ?>"></script>
<link rel="stylesheet" href="<?php echo base_url(); ?>css/colorbox.css?rand=<?php echo CACHE_RANDOM; ?>" />
<!--<link rel="stylesheet" href="<?php echo base_url(); ?>bankeauc/css/tables.css" />-->
<script src="<?php echo base_url(); ?>js/jquery.colorbox.js?rand=<?php echo CACHE_RANDOM; ?>"></script>
<script>

jQuery(document).ready(function () {

	jQuery(".auction_detail_iframe").colorbox({iframe: true, width: "85%", height: "90%", onClosed: function () {
		//jQuery(".inline_auctiondetail").click();
		jQuery(".inline_auctiondetail");
	}});

	
});
</script>
<script type="text/javascript">
var oTable = null;
    $(document).ready(function () {
		//$("#big_table thead tr th").eq(0).addClass("hidetd");
	

			initHomeTable();
			<?php if($_GET['search'] != ''){ ?>
				oTable.columns(3).search('<?php echo $_GET['search']; ?>').draw();
			<?php } ?>
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
			var parent_id = $("input[name=parent_id]:checked").val();

			var sub_id_str = '';
			$("input[name=sub_id]:checked").each(function(){
				var sub_id = $(this).val();
				sub_id_str += '&sub_id[]='+sub_id;
			});


			var reservePriceMaxRange = $("#reservePriceMaxRange").val();
			var reservePriceMinRange = $("#reservePriceMinRange").val();
			var search_box = $("#search_ListID").val();
			oTable = $('#big_table').DataTable({
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

					  
					  $('td:eq(6)', nRow).html('<a class="corrigendum_iframe" href="<?php echo base_url(); ?>home/auctionDetailPopup/' + aData[6] + '"><img src="<?php echo base_url(); ?>assets/auctiononclick/images/view_button.png" title="View Auction" class="edit1"></a>');
					  
					  setTimeout(function(){
							$(".corrigendum_iframe").colorbox({iframe:true, width:"65%", height:"80%",onClosed:function(){ /* location.reload(true); */ }});							
							$(".corrigendum_iframe").addClass("cboxElement");
						},1000);
						
					return nRow;
					}
				});

				var search_box = $("#search_box").val();
				oTable.search(search_box).draw();

				var search_city = $("#search_city").closest(".custom-select").find('.select-selected').html();

				if(search_city == 'Select City')
				{
					oTable.columns(3).search("<?php echo $_GET['search']; ?>").draw();
				}
				else if(search_city != 'All Cities')
				{
					oTable.columns(3).search(search_city).draw();
				}


				var search_location = $("#search_location").closest(".custom-select").find('.select-selected').html();

				if(search_location != 'Select Location' && search_location != 'All Location')
				{
					oTable.columns(2).search(search_location).draw();
				}

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
            <div class="row">
                <div class="col-sm-3">
                    <div class="search_filter">
                        <div id="StickyNotes">
                                <div id="accordion" class="ui-accordion ui-widget ui-helper-reset">
                                    <h3 class="ui-accordion-header ui-helper-reset ui-state-default ui-accordion-icons ui-corner-top ui-accordion-header-active ui-state-active">
                                        <span class="ui-accordion-header-icon ui-icon ui-icon-triangle-1-s"></span>
                                        Search Text
                                    </h3>
                                    <div class="ui-accordion-content ui-helper-reset ui-widget-content ui-corner-bottom ui-accordion-content-active">
                                        <div class="search_filter_box">
                                            <input type="text" id="search_box" class="form-control" placeholder="" />
                                            <span><i class="fa fa-search"></i></span>
                                        </div>
                                    </div>
                                    <h3 class="ui-accordion-header ui-helper-reset ui-state-default ui-accordion-icons ui-corner-top ui-accordion-header-active ui-state-active">
                                        <span class="ui-accordion-header-icon ui-icon ui-icon-triangle-1-s"></span>
                                        Category
                                    </h3>
                                    <div class="ui-accordion-content ui-helper-reset ui-widget-content ui-corner-bottom ui-accordion-content-active">
                                        <div class="form-wrap-category">
                                            <ul>
												<?php $parentCat = $this->home_model->getAllCategory(0); ?>
													<?php foreach($parentCat as $key => $parCat){ ?>
														<li>
															<label class="radio_box">All <?php echo $parCat->name; ?>
															<input type="radio" class="parent_id" name="parent_id" data-parent-id="<?php echo $parCat->id;?>" <?php echo ($parCat->id == $_GET['assetsTypeId'])?'checked="checked"':''; ?> name="radio" value="<?php echo $parCat->id;?>">
															<span class="checkmark"></span>
															</label>
														</li>
														<?php $Cats = $this->home_model->getAllCategory($parCat->id); ?>
														<?php foreach($Cats as $cat){ ?>
															<li><label class="check_box"><?php echo $cat->name; ?>
																<input type="checkbox" data-parent="<?php echo $parCat->id;?>" name="sub_id" <?php echo (in_array($cat->id,$_GET['sc']))?'checked="checked"':''; ?> value="<?php echo $cat->id;?>">
																<span class="checkmark2"></span>
																</label>
															</li>
														<?php } ?>
												<?php } ?>                                                
                                            </ul>
                                        </div>
                                    </div>
                                    <h3 class="ui-accordion-header ui-helper-reset ui-state-default ui-accordion-icons ui-corner-top ui-accordion-header-active ui-state-active">
                                        <span class="ui-accordion-header-icon ui-icon ui-icon-triangle-1-s"></span>
                                        Listing ID
                                    </h3>
                                    <div class="ui-accordion-content ui-helper-reset ui-widget-content ui-corner-bottom ui-accordion-content-active">
                                        <div class="search_filter_box">
                                            <input type="text" class="form-control" placeholder="" id="search_ListID" onkeypress="return isNumberKey(event);"/>
                                            <span><i class="fa fa-search"></i></span>
                                        </div>
                                    </div>
                                    <h3 class="ui-accordion-header ui-helper-reset ui-state-default ui-accordion-icons ui-corner-top ui-accordion-header-active ui-state-active">
                                        <span class="ui-accordion-header-icon ui-icon ui-icon-triangle-1-s"></span>
                                        City
                                    </h3>
                                    <div class="ui-accordion-content ui-helper-reset ui-widget-content ui-corner-bottom ui-accordion-content-active ui-custom-dropdown">
                                        <div class="custom-dropdown-select">
                                            <div class="custom-select">
                                                <select id="search_city" class="search_city">
                                                    <option value="">Select City</option>
													<option value="">All Cities</option>
													<?php foreach($data['city'] as $key => $n){ ?>
														<option value="<?php echo $key; ?>"><?php echo $n; ?></option>
													<?php } ?>
                                                </select>
                                            </div>
                                        </div>
                                    </div>
                                    <h3 class="ui-accordion-header ui-helper-reset ui-state-default ui-accordion-icons ui-corner-top ui-accordion-header-active ui-state-active">
                                        <span class="ui-accordion-header-icon ui-icon ui-icon-triangle-1-s"></span>
                                        Location
                                    </h3>
                                    <div class="ui-accordion-content ui-helper-reset ui-widget-content ui-corner-bottom ui-accordion-content-active ui-custom-dropdown">
                                        <div class="custom-dropdown-select">
                                           <div class="custom-select">
                                            <select id="search_location">
                                                <option value="">Select Location</option>
                                                <option value="">All Location</option>
												<?php foreach($data['location'] as $key => $n){ ?>
													<option value="<?php echo $key; ?>"><?php echo $n; ?></option>
												<?php } ?>
                                            </select>
                                        </div>
                                        </div>
                                    </div>
                                    <h3 class="ui-accordion-header ui-helper-reset ui-state-default ui-accordion-icons ui-corner-top ui-accordion-header-active ui-state-active">
                                        <span class="ui-accordion-header-icon ui-icon ui-icon-triangle-1-s"></span>
                                        Minium Reserve Price
                                    </h3>
                                    <div class="ui-accordion-content ui-helper-reset ui-widget-content ui-corner-bottom ui-accordion-content-active">
                                        <div class="search_filter_box">
                                            <input type="text" class="form-control" placeholder="" id="reservePriceMinRange" onkeypress="return isNumberKey(event);"/>
                                        </div>
                                    </div>
                                    <h3 class="ui-accordion-header ui-helper-reset ui-state-default ui-accordion-icons ui-corner-top ui-accordion-header-active ui-state-active">
                                        <span class="ui-accordion-header-icon ui-icon ui-icon-triangle-1-s"></span>
                                        Maximum Reserve Price
                                    </h3>
                                    <div class="ui-accordion-content ui-helper-reset ui-widget-content ui-corner-bottom ui-accordion-content-active">
                                        <div class="search_filter_box">
                                            <input type="text" class="form-control" placeholder="" id="reservePriceMaxRange" onkeypress="return isNumberKey(event);"/>
                                        </div>
                                    </div>
                                </div>
                        </div>


                    </div><!--search_filter-->
                </div>
                <div class="col-sm-9">
                    <div class="auction_table table-responsive">
						<?php
								//set table id in table open tag
									$tmpl = array('table_open' => '<table id="big_table" border="1" width="100%" cellpadding="2" cellspacing="1" class="myTable auction_table_box">');
									$this->table->set_template($tmpl);
									$this->table->set_heading('List ID', 'Property Type','Location','City','EMD Submission Last Date','Reserve Price','View Details');
									echo $this->table->generate();
								?>
                        
                    </div>
                    
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