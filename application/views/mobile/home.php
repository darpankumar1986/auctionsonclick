<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/jquery.dataTables.css" type="text/css" media="screen"/>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/front_view/js/jquery-ui.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery.dataTables.min.js"></script>
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
.flex-control-nav {position: relative;}
.ui-autocomplete{max-width:454px !important;}
    
</style>

<style>
	
	.dropdown-menu {max-height: 162px;overflow: scroll;}
	section {display: block;}
    .dataTables_length {width: 283px; top:-32px; color:#000!important;   text-shadow:none!important;}
    .dataTables_wrapper .dataTables_filter, .dataTables_wrapper .dataTables_length {color: #000;text-shadow:none!important;font-size: 12px;}
    .dataTables_length{display:none;}
    .dataTables_filter label{font-size:14px; font-weight: bold;}
    .dataTables_filter{ margin: 0 auto; width: 100%; text-align:center;}
    #big_table_info{display: none;}
    .dataTables_wrapper .dataTables_filter input{background-color:#fff !important; float:right; padding:3px 1%; margin:0;}     
    .dataTables_filter label{  font-size: 1em;color: #fff;font-weight:normal; }
    .dataTables_filter{ top: -40px !important;text-align:right;}
    table.dataTable thead th{color: #424242 !important;font-family:sans-serif !important;font-size:12px;}
    table.dataTable td{color:#000;font-family:Arial !important;}
    .body_main .heading_bg {width: 100%;float: left;background: #1776ae;padding: 9px 1% 5px 1%;}
    .body_main h2 {margin: 0 0 0px; font-size: 15px;font-weight: normal;float: left;color: #fff;text-transform: uppercase;}
    .table_bg table {border: 1px solid #bbb;border-spacing: 0;border-top: 0;word-wrap: break-word;table-layout: fixed;}
    .dataTables_wrapper .dataTables_filter input {width: 30% !important;padding: 10px 1%;}
    .dataTables_filter label{width: 328px;}
    .sorting, .sorting_disabled, .sorting_asc{background-color:#dcf0f9 !important;}
    table.dataTable tr.odd {background-color: #f1fbff !important;}
    table.dataTable tr.even {background-color: #fff !important;}
    table.dataTable tr th {width:33.4% !important;}
    
    @media only screen and (max-width: 768px) {
		.input-group-addon, .input-group-btn, .input-group .form-control{display:block;}
		.search-panel{margin-bottom:5px;}
		.flex-direction-nav.container{display:none;}
		.top_slider .flex_caption1{left: 5%;width: 90%;}
		.input-group.blockdisplay{width: 100%;}
		.searchres{width: 100% !important;margin-left: 0px !important;height: 54px;}
		.input-group-addon, .input-group-btn{width: 100%;}
		.filter_btn{width: 100%;padding: 15px 7px;}
		.dropdown-menu{min-width: 100%;top: 96%;}
		.searhcbtn{margin-top: 5px;padding: 15px 0;width: 100%;}
		#search_concept{text-align:left;float:left;}
		.search_caret{float:right;}
		.dataTables_filter label{width: 100% !important;}
		.dataTables_processing{background-color:transparent !important;border:none !important; }


	}
        
</style>


<!-- Controller : HOME -->
<script type="text/javascript">
    $(document).ready(function () {
		$("#big_table thead tr th").eq(2).addClass("hidetd");
		$("#big_table thead tr th").eq(3).addClass("hidetd");
		$("#big_table thead tr th").eq(4).addClass("hidetd");
		$("#big_table thead tr th").eq(5).addClass("hidetd");
		$("#big_table thead tr th").eq(6).addClass("hidetd");
		
		var oTable = $('#big_table').dataTable({
            "bAutoWidth": false,
            //"aoColumns": [{"sWidth": "0%"}, {"sWidth": "0%"}, {"sWidth": "0%"}, {"sWidth": "0%"}, {"sWidth": "0%"}, {"sWidth": "0%"}, {"sWidth": "0%"}, {"sWidth": "20%"}],
            "aoColumnDefs": [ { "bSortable": false, "aTargets": [ 7] } ], 
            "bProcessing": true,
            "bServerSide": true,
            "sAjaxSource": '<?php echo base_url(); ?><?php echo $controller ?>/liveAuctionDatatableHome/<?php echo $bankShortname; ?>',
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
            'fnServerData': function (sSource, aoData, fnCallback){
                $.ajax({    'dataType': 'json',
                            'type': 'POST',
                            'url': sSource,
                            'data': aoData,
                            'success': fnCallback
                        });
            },
            "fnRowCallback": function (nRow, aData, iDisplayIndex) {
							
                if(aData[0]!='null')
                { }
                 
                var d1 =  aData[5].split(' ');
                var d =   d1[0].split('-');
                var months = [ "January", "February", "March", "April", "May", "June","July", "August", "September", "October", "November", "December" ];
                 
                if(aData[3].length>200){
                  //$('td:eq(3)', nRow).html(aData[3].substring(0, 200)+'...');
                }else{
                  //$('td:eq(3)', nRow).html(aData[3]);
                    }
                  $('td:eq(3)', nRow).attr('title',aData[3]);
                  //$('td:eq(5)', nRow).html(d[2]+" "+ months[parseInt(d[1]-1,10)]+" "+d[0]);
                  //console.log(aData);
                 $('td:eq(2)', nRow).addClass("hidetd");
				 $('td:eq(3)', nRow).addClass("hidetd");
				 $('td:eq(4)', nRow).addClass("hidetd");
				 $('td:eq(5)', nRow).addClass("hidetd");
				 $('td:eq(6)', nRow).addClass("hidetd");
                  
                  $('td:eq(7)', nRow).html('<a class="corrigendum_iframe" href="<?php echo base_url(); ?>home/auctionDetailPopup/' + aData[7] + '"><img src="/bankeauc/images/view.png" title="View Auction" class="edit1"></a>');
                  
                  setTimeout(function(){
						$(".corrigendum_iframe").colorbox({iframe:true, width:"100%", height:"80%",onClosed:function(){ /* location.reload(true); */ }});							
						$(".corrigendum_iframe").addClass("cboxElement");
					},1000);
					
                return nRow;
                }
            });
            setTimeout(function(){ $("#big_table_info").text(''); }, 500);
        });
        
</script>

<style>
	.hidetd{display:none;}
</style>

<div class="preloader_hide">

	<!-- PAGE -->
	<div id="page">
		<!-- HOME -->
		<section id="home" class="padbot0">
				
			<!-- TOP SLIDER -->
			<div class="flexslider top_slider">
				<div class="flex_caption1">
							<p class="title1 captionDelay1 FromBottom">Find your <strong>Next</strong></p>
							<p class="title2 captionDelay2 FromBottom">INVESTMENT HOME NOW.</p>
							<div class="col-xs-12 pad0">
								<div class="input-group blockdisplay">
								   <div class="input-group-btn search-panel blockdisplay fullwid">
									  <button type="button" class="btn btn-default dropdown-toggle filter_btn fullwid" data-toggle="dropdown">
									  <span id="search_concept">All Assets Type</span> <i class="fa fa-angle-down fa-lg pd_lf_10 search_caret" aria-hidden="true"></i>
									  </button>
									  <ul class="dropdown-menu autoheight no_mrgn assetsType" role="menu">
										 <li data-id="0"><a href="javascript:void(0);">All Assets Type</a></li>
										 <li class="divider"></li>
										  <?php 
										 if(count($assetsType)>0)
										 {
											 foreach($assetsType as $assets)
											 {
											 ?>
												<li class="p_t_b_10" data-id="<?php echo $assets->id;?>"><a href="javascript:void(0);"><?php echo $assets->name;?></a></li>
											 <?php
											 }
										 }										 
										 ?>										
										 <!--
										 <li class="p_t_b_10"><a href="#bankownednew">Bank Owned &amp; Newly Foreclosed</a></li>
										 <li class="p_t_b_10"><a href="#bankowned">Bank Owned</a></li>
										 <li class="p_t_b_10"><a href="#Foreclosure">Foreclosure Sales </a></li>
										 -->
									  </ul>
									  <input type="hidden" name="assetsTypeId" id="assetsTypeId" value="0"/>
								   </div>
								   <!--<input type="hidden" name="search_param" value="all" id="search_param">  -->								   
								   <input type="hidden" id="txt-category">       
								   <input type="text" id="txt-search" class="form-control searchres" name="x" onKeyPress="enterpressalert(event)" placeholder="Property Address" value="<?php echo $_GET['search'];?>"> <!--State, County, City, Zip, Address or Property ID-->
								   <span class="input-group-btn reflt">
								   <button class="btn btn-default btn_green btn_focus btnres searhcbtn" type="button" onclick="goForSearch()">Search</button>
								   </span>
								</div>
								<div class="error" id="error_txt"></div>
							</div>
						</div>
				<ul class="slides mobile_fx_slider">
					<li class="slide1">						
						<!--<a class="slide_btn FromRight" href="javascript:void(0);" >Read More</a>-->
					<li class="slide2">
						
						<!--<a class="slide_btn FromRight" href="javascript:void(0);" >Read More</a>-->
					</li>
					<li class="slide3">						
						<!--<a class="slide_btn FromRight" href="javascript:void(0);" >Read More</a>-->
						
						<!-- VIDEO BACKGROUND -->
						<a id="P2" class="player" data-property="{videoURL:'tDvBwPzJ7dY',containment:'.top_slider .slide3',autoPlay:true, mute:true, startAt:0, opacity:1}" ></a>
						<!-- //VIDEO BACKGROUND -->
					</li>
					<li class="slide4">
						
						<!--<a class="slide_btn FromRight" href="javascript:void(0);" >Read More</a>-->
					</li>
				</ul>
			</div>			
		</section><!-- //HOME -->
		
		<section id="body_wrapper">
					 <div class="body_main">					
						<div style="clear:both"></div>
						<div class="heading_bg">
						   <h2><strong>LIVE Auctions</strong></h2>
						</div>
						<div style="clear:both"></div>
						<section class="table_bg">
						   <!--==========table bg start=========-->
						   <div class="container-outer">
							  <div class="container-inner">
								  <?php
								//set table id in table open tag
									$tmpl = array('table_open' => '<table id="big_table" border="1" width="100%" cellpadding="2" cellspacing="1" class="myTable">');
									$this->table->set_template($tmpl);
									$this->table->set_heading('Property ID', 'Property Desc.','EMD Fee','Apply EMD Start Date & Time','Apply EMD End Date & Time','Auction Start Date & Time','Auction End Date & Time','Auction Details');
									echo $this->table->generate();
								?>
							  </div>
						   </div>
						</section>
					 </div>
					 <!--==========body_main end=========-->
		</section>
		<div style="clear:both"></div>
		<?php /*?>	
		<!-- ABOUT -->
		<section id="about">
			
			<!-- SERVICES -->
			<div class="services_block" data-appear-top-offset="-200" data-animated="fadeInUp">
				
				<!-- CONTAINER -->
				<div class="container">
				
					<!-- ROW -->
					<div class="row">
						<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 col-ss-12 featured">
							<a class="services_item" href="javascript:void(0);" >
							
								<p><i class="fa fa-search-plus" aria-hidden="true"></i> Find Your Properties</p>
								<span>Search, track and research your properties</span>
							</a>
						</div>
						<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 col-ss-12 featured">
							<a class="services_item" href="javascript:void(0);" >
								<p><i class="fa fa-gavel" aria-hidden="true"></i> Start Bidding</p>
								<span>Bid at live and online auctions</span>
							</a>
						</div>
						<div class="col-lg-4 col-md-4 col-sm-4 col-xs-12 col-ss-12 featured">
							<a class="services_item" href="javascript:void(0);" >
								<p> <i class="fa fa-thumbs-o-up"></i> Win the Auction</p>
								<span>We're here to support you post-auction</span>
							</a>
						</div>
						
					</div><!-- //ROW -->
				</div><!-- //CONTAINER -->
			</div><!-- //SERVICES -->
			
			
		
			
				<!-- PROJECTS -->
		<section id="projects" class="padbot20">
		
			<!-- CONTAINER -->
			<div class="container">
				<h2><strong>NEWLY ADDED</strong> FORECLOSURE PROPERTIES</h2>
			</div><!-- //CONTAINER -->
			
				
			<div class="projects-wrapper" data-appear-top-offset="-200" data-animated="fadeInUp">
				<!-- PROJECTS SLIDER -->
				<div class="owl-demo owl-carousel projects_slider">
				<?php
				//echo "<pre>" ;print_r($aData);die;
					if(count($aData)>0)
					{
						foreach($aData as $ad)
						{
				?>	
					<!-- work4 -->
						<div class="item">
							<div class="work_item">
								<div class="work_img">
									<img src="<?php echo base_url();?>assets/front_view/images/works/4.jpg" alt="" />
									<a class="zoom view-details-btn grn-txt float-right b_showevent inline_auctiondetail auction_detail_iframe" href="<?php echo base_url(); ?>home/auctionDetailPopup/<?php echo $ad->id;?>"></a>
								</div>
								<div class="work_description">
									<div class="work_descr_cont">
										<!--<a href="" >Live Auction | Oct 03, 9:00am</a>-->
										<a href="" >Live Auction | <?php echo date('M d, Y h:i a',strtotime($ad->auction_start_date));?></a>
										<span><?php echo $ad->PropertyDescription;?></span>
									</div>
								</div>
							</div>
						</div><!-- //work4 -->
				<?php 
						}
					}
				?>
				
				
					<!-- work1 -->
					<div class="item">
						<div class="work_item">
							<div class="work_img">
								<img src="<?php echo base_url();?>assets/front_view/images/works/1.jpg" alt="" />
								<a class="zoom" href=""></a>
							</div>
							<div class="work_description">
								<div class="work_descr_cont">
									<a href="" >Live Auction | Oct 03, 9:00am</a>
									<span>1241 Plot No. 301 Lorium Iplsum Gurgaon, 63301</span>
								</div>
							</div>
						</div>
					</div><!-- //work1 -->
					
					<!-- work2 -->
					<div class="item">
						<div class="work_item">
							<div class="work_img">
								<img src="<?php echo base_url();?>assets/front_view/images/works/2.jpg" alt="" />
								<a class="zoom" href=""></a>
							</div>
							<div class="work_description">
								<div class="work_descr_cont">
									<a href="" >Live Auction | Oct 03, 9:00am</a>
									<span>1241 Plot No. 301 Lorium Iplsum Gurgaon, 63301</span>
								</div>
							</div>
						</div>
					</div><!-- //work2 -->
					
					<!-- work3 -->
					<div class="item">
						<div class="work_item">
							<div class="work_img">
								<img src="<?php echo base_url();?>assets/front_view/images/works/3.jpg" alt="" />
								<a class="zoom" href=""></a>
							</div>
							<div class="work_description">
								<div class="work_descr_cont">
									<a href="" >Live Auction | Oct 03, 9:00am</a>
									<span>1241 Plot No. 301 Lorium Iplsum Gurgaon, 63301</span>
								</div>
							</div>
						</div>
					</div><!-- //work3 -->
					
					<!-- work4 -->
					<div class="item">
						<div class="work_item">
							<div class="work_img">
								<img src="<?php echo base_url();?>assets/front_view/images/works/4.jpg" alt="" />
								<a class="zoom" href=""></a>
							</div>
							<div class="work_description">
								<div class="work_descr_cont">
									<a href="" >Live Auction | Oct 03, 9:00am</a>
									<span>1241 Plot No. 301 Lorium Iplsum Gurgaon, 63301</span>
								</div>
							</div>
						</div>
					</div><!-- //work4 -->
					
					<!-- work5 -->
					<div class="item">
						<div class="work_item">
							<div class="work_img">
								<img src="<?php echo base_url();?>assets/front_view/images/works/1.jpg" alt="" />
								<a class="zoom" href=""></a>
							</div>
							<div class="work_description">
								<div class="work_descr_cont">
									<a href="" >Live Auction | Oct 03, 9:00am</a>
									<span>1241 Plot No. 301 Lorium Iplsum Gurgaon, 63301</span>
								</div>
							</div>
						</div>
					</div><!-- //work5 -->
					
					<!-- work6 -->
					<div class="item">
						<div class="work_item">
							<div class="work_img">
								<img src="<?php echo base_url();?>assets/front_view/images/works/2.jpg" alt="" />
								<a class="zoom" href=""></a>
							</div>
							<div class="work_description">
								<div class="work_descr_cont">
									<a href="" >Live Auction | Oct 03, 9:00am</a>
									<span>1241 Plot No. 301 Lorium Iplsum Gurgaon, 63301</span>
								</div>
							</div>
						</div>
					</div><!-- //work6 -->
					
					<!-- work7 -->
					<div class="item">
						<div class="work_item">
							<div class="work_img">
								<img src="<?php echo base_url();?>assets/front_view/images/works/3.jpg" alt="" />
								<a class="zoom" href=""></a>
							</div>
							<div class="work_description">
								<div class="work_descr_cont">
									<a href="" >Live Auction | Oct 03, 9:00am</a>
									<span>1241 Plot No. 301 Lorium Iplsum Gurgaon, 63301</span>
								</div>
							</div>
						</div>
					</div><!-- //work7 -->
					<!-- work8 -->
					<div class="item">
						<div class="work_item">
							<div class="work_img">
								<img src="<?php echo base_url();?>assets/front_view/images/works/4.jpg" alt="" />
								<a class="zoom" href=""></a>
							</div>
							<div class="work_description">
								<div class="work_descr_cont">
									<a href="" >Live Auction | Oct 03, 9:00am</a>
									<span>1241 Plot No. 301 Lorium Iplsum Gurgaon, 63301</span>
								</div>
							</div>
						</div>
					</div><!-- //work8 -->
					
					
				</div><!-- //PROJECTS SLIDER -->
				 <div class="action_btn text-center sm-text-center p-top-20">
                              <a href="<?php echo base_url();?>propertylisting" class="btn goto_btn">View More Properties</a>
                           </div>
			</div>
		
		
		</section><!-- //PROJECTS -->
		
			
				<?php */?>
			
		<?php /*?>	
			<!-- new properties -->
		<section id="projects" class="padbot20">
		
			<!-- CONTAINER -->
			<div class="container">
				<h2>NEWLY ADDED <strong>BANK OWNED PROPERTIES</strong></h2>
			</div><!-- //CONTAINER -->
			
				
			<div class="projects-wrapper" data-appear-top-offset="-200" data-animated="fadeInUp">
				<!-- PROJECTS SLIDER -->
				<div class="owl-demo owl-carousel projects_slider1">
					
					<!-- work1 -->
					<div class="item">
						<div class="work_item">
							<div class="work_img">
								<img src="<?php echo base_url();?>assets/front_view/images/works/1.jpg" alt="" />
								<a class="zoom" href=""></a>
							</div>
							<div class="work_description">
								<div class="work_descr_cont">
									<a href="" >Live Auction | Oct 03, 9:00am</a>
									<span>1241 Plot No. 301 Lorium Iplsum Gurgaon, 63301</span>
								</div>
							</div>
						</div>
					</div><!-- //work1 -->
					
					<!-- work2 -->
					<div class="item">
						<div class="work_item">
							<div class="work_img">
								<img src="<?php echo base_url();?>assets/front_view/images/works/2.jpg" alt="" />
								<a class="zoom" href=""></a>
							</div>
							<div class="work_description">
								<div class="work_descr_cont">
									<a href="" >Live Auction | Oct 03, 9:00am</a>
									<span>1241 Plot No. 301 Lorium Iplsum Gurgaon, 63301</span>
								</div>
							</div>
						</div>
					</div><!-- //work2 -->
					
					<!-- work3 -->
					<div class="item">
						<div class="work_item">
							<div class="work_img">
								<img src="<?php echo base_url();?>assets/front_view/images/works/3.jpg" alt="" />
								<a class="zoom" href=""></a>
							</div>
							<div class="work_description">
								<div class="work_descr_cont">
									<a href="" >Live Auction | Oct 03, 9:00am</a>
									<span>1241 Plot No. 301 Lorium Iplsum Gurgaon, 63301</span>
								</div>
							</div>
						</div>
					</div><!-- //work3 -->
					
					<!-- work4 -->
					<div class="item">
						<div class="work_item">
							<div class="work_img">
								<img src="<?php echo base_url();?>assets/front_view/images/works/4.jpg" alt="" />
								<a class="zoom" href=""></a>
							</div>
							<div class="work_description">
								<div class="work_descr_cont">
									<a href="" >Live Auction | Oct 03, 9:00am</a>
									<span>1241 Plot No. 301 Lorium Ipsum Gurgaon, 63301</span>
								</div>
							</div>
						</div>
					</div><!-- //work4 -->
					
					<!-- work5 -->
					<div class="item">
						<div class="work_item">
							<div class="work_img">
								<img src="<?php echo base_url();?>assets/front_view/images/works/1.jpg" alt="" />
								<a class="zoom" href=""></a>
							</div>
							<div class="work_description">
								<div class="work_descr_cont">
									<a href="" >Live Auction | Oct 03, 9:00am</a>
									<span>1241 Plot No. 301 Lorium Iplsum Gurgaon, 63301</span>
								</div>
							</div>
						</div>
					</div><!-- //work5 -->
					
					<!-- work6 -->
					<div class="item">
						<div class="work_item">
							<div class="work_img">
								<img src="<?php echo base_url();?>assets/front_view/images/works/2.jpg" alt="" />
								<a class="zoom" href=""></a>
							</div>
							<div class="work_description">
								<div class="work_descr_cont">
									<a href="" >Live Auction | Oct 03, 9:00am</a>
									<span>1241 Plot No. 301 Lorium Iplsum Gurgaon, 63301</span>
								</div>
							</div>
						</div>
					</div><!-- //work6 -->
					
					<!-- work7 -->
					<div class="item">
						<div class="work_item">
							<div class="work_img">
								<img src="<?php echo base_url();?>assets/front_view/images/works/3.jpg" alt="" />
								<a class="zoom" href=""></a>
							</div>
							<div class="work_description">
								<div class="work_descr_cont">
									<a href="" >Live Auction | Oct 03, 9:00am</a>
									<span>1241 Plot No. 301 Lorium Ipsum Gurgaon, 63301</span>
								</div>
							</div>
						</div>
					</div><!-- //work7 -->
					<!-- work8 -->
					<div class="item">
						<div class="work_item">
							<div class="work_img">
								<img src="<?php echo base_url();?>assets/front_view/images/works/4.jpg" alt="" />
								<a class="zoom" href=""></a>
							</div>
							<div class="work_description">
								<div class="work_descr_cont">
									<a href="" >Live Auction | Oct 03, 9:00am</a>
									<span>1241 Plot No. 301 Lorium Iplsum Gurgaon, 63301</span>
								</div>
							</div>
						</div>
					</div><!-- //work8 -->
				</div><!-- //PROJECTS SLIDER -->
				 <div class="action_btn text-center sm-text-center p-top-20">
                              <a href="" class="btn goto_btn">View More Properties</a>
                           </div>
			</div>
			
		
		</section><!--  new properties -->
		<?php */?>
	
			
			
		</section><!-- //ABOUT -->
		
		
	<!--Call to  action section-->
	<?php /*?>
                  <section id="action" class="action bg_ad roomy-40">
                     <div class="container">
                        <div class="row">
                           <div class="maine_action">
                              <div class="col-md-12">
                                 <div class="action_item text-center">
                                    <h3 class="color_1">Looking for Commercial Properties?</h3>
                                 </div>
                                 <div class="action_btn text-center sm-text-center">
                                    <a href="" class="btn goto_btn">Go to C1 Prop Auctions</a>
                                 </div>
                              </div>
                           </div>
                        </div>
                     </div>
                  </section>
		
	<?php */?>	
		
		<?php /*?>
		<!-- NEWS -->
		<section id="news">
		
			<!-- CONTAINER -->
			<div class="container">
				<h2><b>Clients</b> say about us</h2>
				
				
				
				<!-- RECENT POSTS -->
				<div class="row recent_posts" data-appear-top-offset="-200" data-animated="fadeInUp">
					<div class="col-lg-4 col-md-4 col-sm-4 padbot30 post_item_block">
						<div class="post_item">
							<div class="post_item_img">
								<img src="<?php echo base_url();?>assets/front_view/images/blog/1.jpg" alt="" />
								<a class="link" href="" ></a>
							</div>
							<div class="post_item_content">
								<a class="title" href="" >Lorium Ipsum dummy text</a>
								<ul class="post_item_inf">
									<li><a href="javascript:void(0);" >Anna</a> |</li>
									<li><a href="javascript:void(0);" >Test</a> |</li>
									<li><a href="javascript:void(0);" >10 Comments</a></li>
								</ul>
							</div>
						</div>
					</div>
					<div class="col-lg-4 col-md-4 col-sm-4 padbot30 post_item_block">
						<div class="post_item">
							<div class="post_item_img">
								<img src="<?php echo base_url();?>assets/front_view/images/blog/2.jpg" alt="" />
								<a class="link" href=""></a>
							</div>
							<div class="post_item_content">
								<a class="title" href="" >Lorium Ipsum dummy text</a>
								<ul class="post_item_inf">
									<li><a href="javascript:void(0);" >Anna</a> |</li>
									<li><a href="javascript:void(0);" >Test</a> |</li>
									<li><a href="javascript:void(0);" >10 Comments</a></li>
								</ul>
							</div>
						</div>
					</div>
					<div class="col-lg-4 col-md-4 col-sm-4 padbot30 post_item_block">
						<div class="post_item">
							<div class="post_item_img">
								<img src="<?php echo base_url();?>assets/front_view/images/blog/3.jpg" alt="" />
								<a class="link" href=""></a>
							</div>
							<div class="post_item_content">
								<a class="title" href="" >Lorium Ipsum dummy text</a>
								<ul class="post_item_inf">
									<li><a href="javascript:void(0);" >Anna</a> |</li>
									<li><a href="javascript:void(0);" >Test</a> |</li>
									<li><a href="javascript:void(0);" >10 Comments</a></li>
								</ul>
							</div>
						</div>
					</div>
				</div><!-- RECENT POSTS -->
			</div><!-- //CONTAINER -->
		</section><!-- //NEWS -->
		<?php */?>
	</div><!-- //PAGE -->
 
<script>

 $(document).ready(function(){	
	
	$.ui.autocomplete.prototype._renderItem = function( ul, item){
	  var term = this.term.split(' ').join('|');
	  var re = new RegExp("(" + term + ")", "gi") ;
	  var t = item.label.replace(re,"<strong style='color:#ff6600;font-weight: normal;'>$1</strong>");
	  return $( "<li class='search-selected'></li>" )
		 .data( "item.autocomplete", item )
		 .append( "<a>" + t + "</a>" )
		 .appendTo( ul );
	};
	
	jQuery("#txt-search").autocomplete({
		source: function (request, response) {
			var assetsTypeId = $('#assetsTypeId').val();					
			$.ajax({
				dataType: "json",
				type : 'Get',
				url: '<?php echo base_url();?>home/search_product?q='+request.term+'&assetsTypeId='+assetsTypeId,
				success: function(data) {
					$('input.suggest-user').removeClass('ui-autocomplete-loading');  
					// hide loading image

					response(data);
				},
				error: function(data) {
					$('input.suggest-user').removeClass('ui-autocomplete-loading');  
				}
			});
		},
		minLength: 2,
		classes: {
		"ui-autocomplete": "autoclass"
		},
	  select: function(event, ui){
		console.log([ui.item.value]);
		goForSearch(ui.item.value);
	  }
	});
		
});	

function enterpressalert(e)
{
	var code = (e.keyCode ? e.keyCode : e.which);
	if(code == 13) 
	{
		goForSearch();
	}
}

function checkSearch()
{
		$('#srch-category').html('Products');
		var searchBy = $("#searchby").val(1);
	
	
}
checkSearch();

function goForSearch(str)
{
	$("#error_txt").html('');
	//var searchBy = $("#searchby").val();
	$("#error_txt").hide();
	var searchText = (typeof(str)==='undefined' ) ? $("#txt-search").val() : str;
	
	if(searchText.trim() == '')
	{
		$("#error_txt").show();
		$("#error_txt").html('Please enter keyword for your search');
		return false;
	}
	else
	{
		var assetsTypeId = $('#assetsTypeId').val();
		
		window.location='<?php echo base_url();?>propertylisting?search='+searchText+'&assetsTypeId='+assetsTypeId;
	}
	
	
	/*if(searchBy.trim() == '')
	{
		$("#error_txt").show();
		$("#error_txt").html('Please select category');
		return false;
	}
	else if(searchText.trim() == '')
	{
		$("#error_txt").html('Please enter search text');
		return false;
	}
	else
	{
		if(searchBy == 1)
		{
			window.location='<?php echo base_url();?>propertylisting?search='+searchText;
		}
		else if(searchBy == 2)
		{
			window.location='<?php echo base_url();?>supplierlist?search='+searchText;
		}
		else
		{
			window.location='<?php echo base_url();?>buying-request?search='+searchText;
		}
	}*/
}

/*
$(window).load(function(){   			
   		$('#login-modal1').modal({
			
			keyboard: false  // to prevent closing with Esc button (if you want this too)
		});
});
*/
$(document).on('keypress','#txt-search',function(){
	$("#error_txt").hide();
});

$(document).on('click','.assetsType li',function(){
	//alert();
	var assetsTypeId = $(this).attr('data-id');
	if(assetsTypeId != '' && typeof(assetsTypeId) !== 'undefined')
	{
		$('#assetsTypeId').val(assetsTypeId);
	}
	
});
</script>
