        <footer class="footer_box">
            <div class="container">
                <div class="row">
                    <div class="col-sm-6">
                       <!-- <div class="footer_about">
                            <h4>About Us</h4>
                            <p>AuctionsOnClick.com is the only website in India that lists all the properties that are for sale through bank auctions. We list all the properties that are scheduled to be auctioned by various banks across India. Many people are interested in buying properties through bank auctions as they come at relatively cheaper prices compared to the market rates but are unable to do so for the lack of enough information on them. Foreclosureindia.com bridges this gap between the investors and the banks and financial institutions by providing an internet platform for them. AuctionsOnClick.com is committed to providing a win-win situation for both the buyers and the banks.</p>
                        </div> --><!--footer_about-->
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="footer_about">
                                    <h4>Top 10 Cities</h4>
                                    <ul>
                                       <?php 
									   	  $top_cities = $this->home_model->getTopCities();	
										  $cnt = 1; 	
										  //echo "<pre>";print_r($top_cities);die;

										  if(is_array($top_cities) && count($top_cities)>0)
										  {
											if($cnt<=10)
											{
												foreach ($top_cities as $key =>$city)
												  {
										  ?>
													<li><a href="<?php echo base_url();?>propertylisting?search_city=<?php echo $key; ?>"><?php echo ucwords(strtolower($key)).' ('.$city.')'; ?></a></li>
										  <?php 
												  }
											}
										  }
										  ?>
                                        <li class="view_cities"><a href="<?php echo base_url()?>home/top_cities">View all Cities <span class="cities_icon"><i class="fa fa-angle-right"></i></span></a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="footer_about">
                                    <h4>Top 10 Banks</h4>
                                    <ul>
										<?php 
										  $top_banks = $this->home_model->getAllBank();	
										  $cnt = 1;
										  if(is_array($top_banks) && count($top_banks)>0)
										  {
											foreach ($top_banks as $bank)
											  {
												if($cnt<=10)
												  {
										  ?>
												<li><a href="<?php echo base_url();?>propertylisting?bank=<?php echo $bank->id; ?>"><?php echo ucwords(strtolower($bank->name)); ?></a></li>
										  <?php 
												  }
											  }
										  }
										  ?>
                                        <li class="view_cities"><a href="<?php echo base_url()?>home/top_banks">View all Banks <span class="cities_icon"><i class="fa fa-angle-right"></i></span></a></li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="footer_about">
                                    <h4>Quick Links</h4>
                                    <ul>
                                        <li><a href="<?php echo base_url();?>home/premiumServices">Permium Services</a></li>
                                        <li><a href="<?php echo base_url();?>about-us">About Us</a></li>
                                        <li><a href="<?php echo base_url();?>faq">FAQ</a></li>
                                        <li><a href="<?php echo base_url();?>contact-us">Contact Us</a></li>
                                        <li><a href="<?php echo base_url();?>sitemap">Sitemap</a></li>
                                        <li><a href="<?php echo base_url();?>terms-conditions">Terms &amp; Conditions</a></li>
                                        <li><a href="<?php echo base_url();?>privacy-policy">Privacy Policy</a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="footer_about">
                                    <h4>Network Sites</h4>
                                    <ul>
                                        <li><a href="https://bankeauctions.com/" target="_blank">Bankeauctions.com</a></li>
                                    </ul>
                                    <h4>Customer Service</h4>
                                    <ul>
                                        <li><a href="mailto:support@auctiononclick.com"><span><i class="fa fa-envelope"></i></span>support@auctiononclick.com</a></li>
                                        <li class="phone"><span><i class="fa fa-mobile big"></i></span>+91- 7291981124 / 1125 / 1126</li>
                                        <li class="phone"><span><i class="fa fa-phone big"></i></span>+91-124-4302020 / 21 / 22 / 23</li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="footer_copyright_main">
            <div class="container">
                <div class="row">
                    <div class="col-sm-12">
                        <div class="footer_copyright">
                            <p>All trademarks, logos and names are properties of their respective owners. All Rights Reserved. &copy Copyright <?php echo date('Y');?> C1 India Private Limited.</p>
                        </div>
                    </div>
                </div>
                </div>
            </div>
        </footer><!--footer_box-->
    </div><!--auction-main-->

<!--    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>-->
    <!--<script src="<?php echo base_url(); ?>assets/auctiononclick/js/bootstrap.min.js?rand=<?php echo CACHE_RANDOM; ?>"></script>-->

    <!--<script src="<?php echo base_url(); ?>assets/js/jquery-ui.min.js"></script>-->
    <script src="<?php echo base_url(); ?>assets/auctiononclick/js/chosen.jquery.min.js?rand=<?php echo CACHE_RANDOM; ?>"></script>
    <script src="<?php echo base_url(); ?>assets/auctiononclick/js/myscript.js?rand=<?php echo CACHE_RANDOM; ?>"></script>

    <script>

checkSearch();
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


function goAdvancedSearch(str)
{
    $("#error_txt1").html('');

    $("#error_txt1").hide();
    var search_box = $("#search_box").val().trim();
	var search_city = $("#search_city").val().trim();
	var search_location = $("#search_location").val().trim();
	var borrower_name = $("#borrower_name").val().trim();
	var bank = $("#bank option:selected").val().trim();
	var auction_start_date = $("#auction_start_date").val().trim();
	var auction_end_date = $("#auction_end_date").val().trim();
	var reservePriceMaxRange = $("#reservePriceMaxRange").val().trim();
	var reservePriceMinRange = $("#reservePriceMinRange").val().trim();
	var parent_id = $('.dropdown-header input[name=parent_id]:checked').val();
	if(typeof(parent_id) == 'undefined')
	{
		parent_id ='';
	}

    //alert(bank);
    
    if(search_box == '' && search_city == '' && search_location == '' && borrower_name == '' && bank == '' && auction_start_date == '' && auction_end_date == '' && reservePriceMaxRange == '' && reservePriceMinRange == '' && parent_id == '')
    {
        $("#error_txt1").show();
        $("#error_txt1").html('Please select any one filter for your search');
        return false;
    }
    else
    {
        
        var sub_id_str = '';
        $("input[name=sub_id]:checked").each(function(){
            var sub_id = $(this).val();
            sub_id_str += '&sc[]='+sub_id;
        });

        if(search_city !='')
        {
            search_city = "&search_city="+search_city;
        }

        if(borrower_name !='')
        {
            borrower_name = "&borrower_name="+borrower_name;
        }

        if(search_location !='')
        {
            search_location = "&search_location="+search_location;
        }

        var bank_text = '';
        if(bank != '' && bank != 'Select Bank' && bank != 'All Cities')
        {
            bank_text = "&bank="+bank;
        }

        if(auction_start_date !='')
        {
            auction_start_date = "&auction_start_date="+auction_start_date;
        }

        if(auction_end_date !='')
        {
            auction_end_date = "&auction_end_date="+auction_end_date;
        }
      
        if(reservePriceMaxRange !='')
        {
            reservePriceMaxRange = "&reservePriceMaxRange="+reservePriceMaxRange;
        }
        
        if(reservePriceMinRange !='')
        {
            reservePriceMinRange = "&reservePriceMinRange="+reservePriceMinRange;
        }

        window.location='<?php echo base_url();?>home/advanced_search?search='+search_box+'&parent_id='+parent_id+sub_id_str+search_city+bank_text+borrower_name+search_location+auction_start_date+auction_end_date+reservePriceMinRange+reservePriceMaxRange;
    }
}

function goForSearch(str)
{
    $("#error_txt").html('');
    //var searchBy = $("#searchby").val();
    $("#error_txt").hide();
    var searchText = $("#txt-search").val();
	var bank = $("#bank option:selected").val();
    if(searchText.trim() == '')
    {
        $("#error_txt").show();
        $("#error_txt").html('Please enter keyword for your search');
        return false;
    }
    else
    {
        var assetsTypeId = $('.dropdown-header input[name=parentCat]:checked').val();
		if(typeof(assetsTypeId) == 'undefined')
		{
			assetsTypeId ='';
		}
        var sub_id_str = '';
        $("input[name=s_sub_id]:checked").each(function(){
            var sub_id = $(this).val();
            sub_id_str += '&sc[]='+sub_id;
        });

		var bank_text = '';
		if(bank != '' && bank != 'Select Bank')
		{
			bank_text = "&bank="+bank;
		}

        window.location='<?php echo base_url();?>propertylisting?search_city='+searchText+'&parent_id='+assetsTypeId+sub_id_str+bank_text;
    }
}


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
$(document).ready(function(){
    $("input[name=parentCat]").change(function(){
        var parent = $(this).val();

        $(".s_parent_id").each(function(){
            var parent_id = $(this).val();
            if(parent != parent_id)
            {
                $("input[s-data-parent="+parent_id+"]").prop('checked',false);
            }
        });
        $("input[s-data-parent-id]").prop('checked',false);
        $("input[s-data-parent-id="+parent+"]").prop('checked',true);
    });

    $("input[name=s_sub_id]").change(function(){
        var parent_id = $(this).attr('s-data-parent');

        $(".s_parent_id").each(function(){
            var parent = $(this).val();

            if(parent != parent_id)
            {
                $("input[s-data-parent="+parent+"]").prop('checked',false);
                $("input[s-data-parent-id="+parent+"]").prop('checked',false);
            }
        });

        $("input[s-data-parent-id="+parent_id+"]").prop('checked',true);
    });
});
</script>
<script>
	$(document).ready(function(){
		$( ".item-suggest" ).autocomplete({
		  minLength: 0,
		  source: function (request, response) {			
				$.ajax({
					dataType: "json",
					type : 'Get',
					url: '<?php echo base_url();?>home/getCity?q='+request.term,
					success: function(data) { 
						
						response(data);
					},
					error: function(data) {
						$('input.suggest-user').removeClass('ui-autocomplete-loading');  
					}
				});
			},
			select: function(event, ui){
				console.log([ui.item.value]);
			}
		});
	});
</script>

</body>
</html>
