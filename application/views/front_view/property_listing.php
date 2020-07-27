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
<div class="preloader_hide">
	<!-- PAGE -->
	<div id="page">
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
								   <input type="text" id="txt-search" class="form-control searchres" name="x" onKeyPress="enterpressalert(event)" placeholder="Property Address" value="<?php echo $_GET['search'];?>">
								   <span class="input-group-btn reflt">
								   <button class="btn btn-default btn_green btn_focus btnres searhcbtn" type="button" onclick="goForSearch()"><i class="fa fa-search" aria-hidden="true"></i></button>
								   </span>
								</div>
								<div class="error" id="error_txt"></div>
							</div>
				</div>
			</div>
			<!-- //TOP SLIDER -->
		</section>	
		
		
		<!-- ABOUT -->
		<section id="about">
			
			<!-- SERVICES -->
			<!-- //SERVICES -->
			
			
			
			
				<!-- PROJECTS -->
		<section id="projects" class="padbot20">
		
			<!-- CONTAINER -->
			<div class="container">
				<h2 class="pull-left"><strong>NEWLY ADDED</strong> FORECLOSURE PROPERTIES</h2>
				<div class="btn-group pull-right">
            <a href="#" id="list" class="btn btn-default btn-sm"><i class="fa fa-list" aria-hidden="true"></i> List</a> 
			<a href="#" id="grid" class="btn btn-default btn-sm"><i class="fa fa-th" aria-hidden="true"></i> Grid</a>
        </div>
			</div><!-- //CONTAINER -->
			
	<?php
	if(count($property) > 0)
	{			
		?>
	<div class="container">   
		<div id="products" class="row list-group no-mrgn"> 
			<?php
					//echo '<pre>';
					//print_r($products);die;
					foreach($property as $p)
					{
				?>	
			
						<div class="item  col-xs-12 col-lg-4">
							<div class="thumbnail">
								<img class="group list-group-image" src="<?php echo base_url();?>assets/front_view/images/works/8.jpg" />
								<div class="caption">
									<h4 class="group inner list-group-item-heading">
										<?php echo $p->reference_no;?></h4>
									<p class="group inner list-group-item-text"><?php echo $p->PropertyDescription;?></p>
									<div class="row">
										<!--
										<div class="col-xs-12 col-md-6">
											<p class="lead">
												$21.000</p>
										</div>
										-->
										<div class="col-xs-12 col-md-6">
											<a class="btn btn-success view-details-btn grn-txt float-right b_showevent inline_auctiondetail auction_detail_iframe" href="<?php echo base_url(); ?>home/auctionDetailPopup/<?php echo $p->id;?>">View Details</a>
										</div>
									</div>
								</div>
							</div>
						</div>
				<?php }?>
				<?php /*?>
				<div class="item  col-xs-12 col-lg-4">
					<div class="thumbnail">
						<img class="group list-group-image" src="<?php echo base_url();?>assets/front_view/images/works/6.jpg" />
						<div class="caption">
							<h4 class="group inner list-group-item-heading">
								Auction Title</h4>
							<p class="group inner list-group-item-text">
								Product description... Lorem ipsum dolor sit amet, consectetuer adipiscing elit,
								sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.</p>
							<div class="row">
								<div class="col-xs-12 col-md-6">
									<p class="lead">
										$21.000</p>
								</div>
								<div class="col-xs-12 col-md-6">
									<a class="btn btn-success" href="#">View Details</a>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="item  col-xs-12 col-lg-4">
					<div class="thumbnail">
						<img class="group list-group-image" src="<?php echo base_url();?>assets/front_view/images/works/7.jpg" />
						<div class="caption">
							<h4 class="group inner list-group-item-heading">
								Auction Title</h4>
							<p class="group inner list-group-item-text">
								Product description... Lorem ipsum dolor sit amet, consectetuer adipiscing elit,
								sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.</p>
							<div class="row">
								<div class="col-xs-12 col-md-6">
									<p class="lead">
										$21.000</p>
								</div>
								<div class="col-xs-12 col-md-6">
									<a class="btn btn-success" href="#">View Details</a>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="item  col-xs-12 col-lg-4">
					<div class="thumbnail">
						<img class="group list-group-image" src="<?php echo base_url();?>assets/front_view/images/works/8.jpg"/>
						<div class="caption">
							<h4 class="group inner list-group-item-heading">
								Auction Title</h4>
							<p class="group inner list-group-item-text">
								Product description... Lorem ipsum dolor sit amet, consectetuer adipiscing elit,
								sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.</p>
							<div class="row">
								<div class="col-xs-12 col-md-6">
									<p class="lead">
										$21.000</p>
								</div>
								<div class="col-xs-12 col-md-6">
									<a class="btn btn-success" href="#">View Details</a>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="item  col-xs-12 col-lg-4">
					<div class="thumbnail">
						<img class="group list-group-image" src="<?php echo base_url();?>assets/front_view/images/works/5.jpg" />
						<div class="caption">
							<h4 class="group inner list-group-item-heading">
								Auction Title</h4>
							<p class="group inner list-group-item-text">
								Product description... Lorem ipsum dolor sit amet, consectetuer adipiscing elit,
								sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.</p>
							<div class="row">
								<div class="col-xs-12 col-md-6">
									<p class="lead">
										$21.000</p>
								</div>
								<div class="col-xs-12 col-md-6">
									<a class="btn btn-success" href="#">View Details</a>
								</div>
							</div>
						</div>
					</div>
				</div>
				<div class="item  col-xs-12 col-lg-4">
					<div class="thumbnail">
						<img class="group list-group-image" src="<?php echo base_url();?>assets/front_view/images/works/6.jpg" />
						<div class="caption">
							<h4 class="group inner list-group-item-heading">
								Auction Title</h4>
							<p class="group inner list-group-item-text">
								Product description... Lorem ipsum dolor sit amet, consectetuer adipiscing elit,
								sed diam nonummy nibh euismod tincidunt ut laoreet dolore magna aliquam erat volutpat.</p>
							<div class="row">
								<div class="col-xs-12 col-md-6">
									<p class="lead">
										$21.000</p>
								</div>
								<div class="col-xs-12 col-md-6">
									<a class="btn btn-success" href="#">View Details</a>
								</div>
							</div>
						</div>
					</div>
				</div>
				<?php */?>
			</div>
		</div>
		
			
		
		</section><!-- //PROJECTS -->
	<?php }
	?>	
		</section><!-- //ABOUT -->
		
	</div><!-- //PAGE -->

</div>

<script>

$(document).ready(function(){
	
	if(<?php echo $_GET['assetsTypeId'];?> !='')
	{
		<?php 
		if(count($assetsType)>0)
		{
			foreach($assetsType as $at)
			{
				if($at->id == $_GET['assetsTypeId'])
				{
					?>
					$('#search_concept').html("<?php echo $at->name;?>");
					<?php
				}
			}
		}
		?>
		$('#assetsTypeId').val(<?php echo $_GET['assetsTypeId'];?>);
	}
	
	
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
	
	var assetsTypeId = $(this).attr('data-id');
	if(assetsTypeId != '' && typeof(assetsTypeId) !== 'undefined')
	{
		$('#assetsTypeId').val(assetsTypeId);
	}
	
});
</script>
