        <footer class="footer_box">
            <div class="container">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="footer_about">
                            <h4>About Us</h4>
                            <p>AuctionsOnClick.com is the only website in India that lists all the properties that are for sale through bank auctions. We list all the properties that are scheduled to be auctioned by various banks across India. Many people are interested in buying properties through bank auctions as they come at relatively cheaper prices compared to the market rates but are unable to do so for the lack of enough information on them. Foreclosureindia.com bridges this gap between the investors and the banks and financial institutions by providing an internet platform for them. AuctionsOnClick.com is committed to providing a win-win situation for both the buyers and the banks.</p>
                        </div><!--footer_about-->
                    </div>
                    <div class="col-sm-6">
                        <div class="row">
                            <div class="col-sm-6">
                                <div class="footer_about">
                                    <h4>Quick Links</h4>
                                    <ul>
                                        <li><a href="#">Permium Services</a></li>
                                        <li><a href="#">About Us</a></li>
                                        <li><a href="#">FAQ</a></li>
                                        <li><a href="#">Contact Us</a></li>
                                        <li><a href="#">Sitemap</a></li>
                                        <li><a href="#">Terms &amp; Conditions</a></li>
                                        <li><a href="#">Privacy-Policy</a></li>
                                    </ul>
                                </div>
                            </div>
                            <div class="col-sm-6">
                                <div class="footer_about">
                                    <h4>Network Sites</h4>
                                    <ul>
                                        <li><a href="#">Bankeauctions.com</a></li>
                                    </ul>
                                    <h4>Customer Service</h4>
                                    <ul>
                                        <li><a href="mailto:support@auctionsonclick.com"><span><i class="fa fa-envelope"></i></span>support@auctionsonclick.com</a></li>
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
                            <p>All trademarks, logos and names are properties of their respective owners. All Rights Reserved. © Copyright 2020 C1 India Private Limited.</p>
                        </div>
                    </div>
                </div>
                </div>
            </div>
        </footer><!--footer_box-->
    </div><!--auction-main-->

<!--    <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.3.1/jquery.min.js"></script>-->
    <!--<script src="<?php echo base_url(); ?>assets/auctiononclick/js/bootstrap.min.js?rand=<?php echo CACHE_RANDOM; ?>"></script>-->
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


function goForSearch(str)
{
	$("#error_txt").html('');
	//var searchBy = $("#searchby").val();
	$("#error_txt").hide();
	var searchText = $("#txt-search").val();
	
	if(searchText.trim() == '')
	{
		$("#error_txt").show();
		$("#error_txt").html('Please enter keyword for your search');
		return false;
	}
	else
	{
		var assetsTypeId = $('.dropdown-header input[name=parentCat]').val();

		var sub_id_str = '';
		$("input[name=s_sub_id]:checked").each(function(){
			var sub_id = $(this).val();
			sub_id_str += '&sc[]='+sub_id;
		});
		
		window.location='<?php echo base_url();?>propertylisting?search='+searchText+'&assetsTypeId='+assetsTypeId+sub_id_str;
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


</body>
</html>