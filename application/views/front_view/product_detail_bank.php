<?php 
$user_id=$this->session->userdata('id');
$product_id=$id;
//echo "auction type-->".$auction_type;
?>
<link rel="stylesheet" href="<?php echo base_url(); ?>css/lightbox.css">
<script type="text/javascript" src="<?php echo base_url(); ?>js/jquery.ui.map.js"></script> 
<script type="text/javascript" src="<?php echo base_url(); ?>js/lightbox.js"></script>
<script type="text/javascript" src="http://maps.google.com/maps/api/js?sensor=false"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/bootstrap-3.3.2.min.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/bootstrap-multiselect.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>js/jquery.countdown.js"></script>
<script type="text/javascript" src="/application/views/admin/js/plugins/jquery.validate.min.js"></script>
<style>
    .error {
    float: left;
}
</style>

<script>
    $(document).ready(function () {
        $('#multiple-selected-mobile-screen').multiselect({
            nonSelectedText: 'Property Types'
        });
        $('#multiple-selected-budget').multiselect({
            nonSelectedText: 'Budget Types'
        });
        
        $("#propertySearch").autocomplete({
            source:"/property/searchcity",      
           select: function( event, ui ) {
               $("#propertySearch").val(ui.item.value); 
               fillme(ui.item.value);
           }
      });
    });
    function fillme(value)
    {
        var div_id = $('#fbresult').parents('div').attr('id');
        if (div_id == 'resultpropertySearch') {
            $("#propertySearch").val(value);
            $("#resultpropertySearch").show();
            $("#resultpropertySearch").html('');

        } else if (div_id == 'resultpropertySearchRent') {
            $("#propertySearchRent").val(value);
            $("#resultpropertySearchRent").show();
            $("#resultpropertySearchRent").html('');
        }
        processform();
    }

    function validate_search() {
   
        document.forms["property_search"].submit();
       
    }
    $(document).ready(function () {
        $('[data-countdown]').each(function () {
            var $this = $(this), finalDate = $(this).data('countdown');
            $this.countdown(finalDate, function (event) {
                $this.html(event.strftime('<div class=""><div>%D : %H: %M : %S</div></div>'));
            });
        });
    });
    //rating_form
    $(document).ready(function () {
        $("#rating_form").hide();
        $("#rating_review_id").click(function () {
            $("#rating_form").slideToggle('slow');
        });
    });

    function addRating(rating, name) {
        //alert(rating + name);
        var i;
        for (i = 1; i <= 5; i++) {
            if (i <= rating) {
                $("#" + name + i + " " + "img").addClass("active");
            } else {
                $("#" + name + i + " " + "img").removeClass("active");
            }
        }
      
  switch (name) {
    case "traffic":
      document.getElementById("traffic").value = rating;
      break;
    case "connectivity":
      document.getElementById("connectivity").value = rating;
      break;
    case "parking":
      document.getElementById("parking").value = rating;
      break;
    case "public_transport":
      document.getElementById("public_transport").value = rating;
      break;
    case "cleanliness":
    document.getElementById("cleanliness").value = rating;
    break;
    case "safety":
      document.getElementById("safety").value = rating;
      break;
       case "neighborhood":
      document.getElementById("neighborhood").value = rating;
      break;
   
}
    }
$(document).ready(function () {
$("#review_rating").validate({
		rules: {
			review:{
				required:true
				}
		},
                 submitHandler: function(form) {
                    alert("Rating and reviews submitted successfully!");// do other stuff for a valid form
                    form.submit();
                },
	});
});
</script>
<script>
    $(document).ready(function () {
        $("#emailSubscribe").hide();
        $("#successfully_subscribed").hide();
        $("#valid_email_error").hide();
    });
    function emailSubscribe() {

        var email = $('#email').val();
        // var email = document.getElementById('email');
        var filter = /^([a-zA-Z0-9_\.\-])+\@(([a-zA-Z0-9\-])+\.)+([a-zA-Z0-9]{2,4})+$/;
        if (!filter.test(email)) {
            $("#valid_email_error").show();
            $("#successfully_subscribed").hide();
            return false;
        } else {
            $.ajax({
                type: "post",
                url: "/property/subscribe",
                data: "email=" + email,
                success: function (return_data) {
                    $("#valid_email_error").hide();
                    if (return_data == 1) {
                        
                        $("#emailSubscribe").show();
                        $("#successfully_subscribed").hide();
                    } else {
                        $("#email").val('');
                        $("#emailSubscribe").hide();
                        $("#successfully_subscribed").show();
                    }
                }

            });
        }
    }
</script>
<script type="text/javascript">
    
    function viewMap(){
        $("ul.tabs li").removeClass("active");
        $('ul.tabs li:first-child').addClass('active');
        $(".tab_content").hide();
        $("#tab1").fadeIn();
    }
    jQuery(document).ready(function ($) {

        $("#login").click(function () {
            $(".login_dropdown").show();
        });

        $("#forget").click(function () {
            $(".login_ dropdown").show();
        });

        /*------- tab pannel --------------- */

        $(".tab_content").hide();
        $(".tab_content:first").show();

        $("ul.tabs li").click(function () { 
            $("ul.tabs li").removeClass("active");
            $(this).addClass("active");
            $(".tab_content").hide();
            var activeTab = $(this).attr("rel");
            $("#" + activeTab).fadeIn();
        });

        /*------- tab pannel --------------- */
        $(".tab_content1").hide();
        $(".tab_content1:first").show();

        $("ul.tabs1 li").click(function () {
            $("ul.tabs1 li").removeClass("active");
            $(this).addClass("active");
            $(".tab_content1").hide();
            var activeTab = $(this).attr("rel");
            $("#" + activeTab).fadeIn();
        });


        /*------- tab pannel --------------- */
        $(".tab_content2").hide();
        $(".tab_content2:first").show();

        $("ul.tabs2 li").click(function () {
            $("ul.tabs2 li").removeClass("active");
            $(this).addClass("active");
            $(".tab_content2").hide();
            var activeTab = $(this).attr("rel");
            $("#" + activeTab).fadeIn();
        });


        /*------- header menu --------------- */
        jQuery(document).ready(function () {
            jQuery('.toggle-nav').click(function (e) {
                jQuery(this).toggleClass('active');
                jQuery('.menu ul').toggleClass('active');

                e.preventDefault();
            });
        });

    });
</script>
 
<script>
    
function findmapbyaddress(address, divID)
{
var geocoder = new google.maps.Geocoder();
geocoder.geocode({ 'address': address }, function (results, status) {
    if (status == google.maps.GeocoderStatus.OK) {
        var map = new google.maps.Map($("#"+divID));
        map.setCenter(results[0].geometry.location);
        var marker = new google.maps.Marker({
            map: map,
            position: results[0].geometry.location
        });
    } else {
       // alert("Geocode was not successful for the following reason: " + status);
    }
});
    
}
</script>
<script >
    $(document).ready(function(){
	$('.add').each(function(){
	    var attrId = $(this).attr('id');
	    var attrAddress = $(this).text();
	    
	    var geocoder = new google.maps.Geocoder();
	    geocoder.geocode({ 'address': attrAddress }, function (results, status) {
		if (status == google.maps.GeocoderStatus.OK) {
		    var mapOptions = { zoom: 9, mapTypeId: google.maps.MapTypeId.ROADMAP };
		    var map = new google.maps.Map(document.getElementById(attrId), mapOptions);
		    map.setCenter(results[0].geometry.location);
		    var marker = new google.maps.Marker({
			map: map,
			position: results[0].geometry.location
		    });
		} else {
		    alert("Geocode was not successful for the following reason: " + status);
		}
	    });
	    console.log($(this).attr('id')+' '+$(this).text());
	})
    })
</script>
<style>

</style>
<section>
    <div class="breadcrum">
        <div class="wrapper"> <a href="<?php echo base_url() ?>" class="Home">Home</a>&nbsp;»&nbsp;<span><?php echo ucfirst($title); ?></span></div>
    </div>
    <div class="row">
        <div class="wrapper">
            <form name="property_search" id="property_search" method="get" action="<?php echo base_url(); ?>property">
                <div class="search-panel">
                    <div class="searchresult_wrapper">
                        <input name="location" id="propertySearch" type="text" placeholder="Search property Keyword." autocomplete="off" class="input">
                        <div id="resultpropertySearch" style="display:none;"></div>
                    </div>
                    <select  onchange="processform()" name="category[]" id="multiple-selected-mobile-screen" multiple="multiple">
                        <?php
                        if ($categoryList != 0) {
                            foreach ($categoryList as $category) {
                                if (count($categoryArr) > 0) {
                                    if (in_array($category->id, $categoryArr)) {
                                        $selec = "selected";
                                    } else {
                                        $selec = "";
                                    }
                                }
                                ?>
                                <option <?php echo $selec; ?> value="<?php echo $category->name ?>"> <?php echo ucfirst($category->name); ?></option>
                                <?php
                            }
                        }
                        ?>

                    </select>

                    <select onchange="processform()" id="multiple-selected-budget" name="budget[]" multiple="multiple">

                        <?php
                        if (count($budgetArr)) {
                            foreach ($budgetArr as $key => $budget) {

                                if (count($budgetPostArr) > 0) {
                                    if (in_array($budget, $budgetPostArr)) {
                                        $seleb = "selected";
                                    } else {
                                        $seleb = "";
                                    }
                                }
                                ?>
                                <option <?php echo $seleb; ?> value="<?php echo $budget; ?>" ><?php echo $key; ?> Lacs</option>	
                                <?php
                            }
                        }
                        ?>
                    </select>
                    <input type="button" onclick="validate_search();" class="b_search-icon" name="search">

                </div>
            </form>
            <section id="left-section">
                <h1><?php echo ucfirst($title); ?></h1>
				<span class="tender-no">
				<?php
				if(!empty($tender_no)) 
					echo $tender_no;?>
				</span>
                <div class="story-detail"> 
                    <span itemprop="addressLocality" ><?php if (!empty($city_name)) echo $city_name ?></span> 
                    <span><?php if (!empty($updated_by)) echo "Updated By: " . $updated_by; ?></span> 
                    <span><?php if (!empty($updated_date)) echo "Updated on: " . date("d/m/y", strtotime($updated_date)); ?></span> 
                    <span><?php if (!empty($interested_users)) echo $interested_users."Interested users";  ?> </span> 
                </div>
			<div class="socialicon2">
						<div id="favmsg<?php echo $product_id;?>"></div>
								<?php 
						echo $this->property_model->socialmediaIcon($product_id);
						
							?>       
                        </div>
                <div class="img_wrapper">
                    <div id="default_img">
                        <div itemscope = "" itemtype="http://schema.org/ImageObject">
                        <?php if(!empty($productImage)){ ?>
                        <img src="/public/uploads/property_images/<?php echo $productImage; ?>">
                        <?php } else { ?>
                        <img src="<?php echo base_url() ?>images/product-details-image.jpg">
                        <?php } ?>
                        </div>
                        <?php if($verified === "Yes" || $verified === "yes") {?>
                        <div class="verifyed"></div>
                        <?php } ?>
                        <div class="pro-detail">
                            <?php if(!empty($area)) { ?><div class="sqr-feet"><?php echo $area." sqft"; ?></div><?php } ?>
                            <?php if(!empty($room)) { ?><div class="bed"><?php echo $room; ?></div><?php } ?>
                            <?php if(!empty($bathroom)) { ?><div class="bath"><?php echo $bathroom; ?></div><?php } ?>
                        </div>
					   	
                        <div class="view-map"><a href="#tab-pannel" onclick="return viewMap()"><img src="<?php echo base_url() ?>images/view-map.png"></a></div>
						
						
                    </div>
                    
                </div>

                <!-- <div class="heading2 heading_bor btmrg20">Property Details</div>-->

                <div class="box">
                    <div class="row">
					
					
                        <div class="col_wrapper">
                            <?php if(!empty($borrower_name)){ ?>
                            <dl>
                                <dt><span class="icons1"></span>Borrower's Name:</dt>
                                <dd><?php echo $borrower_name; ?></dd>
                            </dl>
                            <?php } if(!empty($bank_name)) { ?>
                            <dl>
                                <dt><span class="icons2"></span>Bank Name:</dt>
                                <dd><?php echo $bank_name; ?></dd>
                            </dl>
							
							
							 <?php } 
							 if(!empty($branchname)) { ?>
							 <dl>
                                <dt><span class="icons2"></span>Branch Name:</dt>
                                <dd><?php echo $branchname; ?></dd>
                            </dl>
					
                            <?php } if(!empty($branch_ifsc_code)) {?>
                            <dl>
                                <dt><span class="icons4"></span>Bank IFSC code:</dt>
                                <dd><?php echo $branch_ifsc_code; ?></dd>
                            </dl>
                            <?php } if($catename){ ?>
							<dl>
                                <dt><span class="icons3"></span>Category Name :</dt>
                                <dd><?php echo $catename; ?></dd>
                            </dl>
							<?php } if($subcategory){ ?>
							<dl>
                                <dt><span class="icons3"></span>Subcategory name :</dt>
                                <dd><?php echo $subcategory; ?></dd>
                            </dl>
							<?php } ?>							
                        </div>
                        <div class="col_wrapper">
						
							<?php
							if(!empty($nodelbranchname)) {?>
							
						    <dl>
                                <dt><span class="icons2"></span>Nodal Bank Name :</dt>
                                <dd><?php echo $nodelbranchname; ?></dd>
                            </dl>
						
                            <?php }
							if(!empty($nodal_bank_account)) {?>
							<dl>
                                <dt><span class="icons3"></span>Nodal Bank Account Number:</dt>
                                <dd><?php echo $nodal_bank_account; ?></dd>
                            </dl>
                            <?php }
							if(!empty($press_release_date)) {?>
							
                            <dl>
                                <dt><span class="icons6"></span>Press Release Date:</dt>
                                <dd><?php echo date("d/m/y", strtotime($press_release_date)) ?></dd>
                            </dl>
                            <?php }
							if(($inspection_date_from != '0000-00-00 00:00:00') || $inspection_date_from == "") {?>
                            <dl>
                                <dt><span class="icons6"></span>Date of Inspection of Assets:</dt>
                                <dd><?php echo date("d/m/y", strtotime($inspection_date_from)) ?></dd>
                            </dl>
							
                            <?php } if($inspection_date_to != '0000-00-00 00:00:00' || $inspection_date_to == "") {
								//echo $inspection_date_to;
								?>
                            <dl>
                                <dt><span class="icons6"></span>Date of Inspection of Assets (to):</dt>
                                <dd><?php echo date("d/m/y", strtotime($inspection_date_to)) ?></dd>
                            </dl>
                            <?php } ?>
							
							<?php if($bid_last_date) { ?>
							<dl>
                                <dt><span class="icons6"></span>FRQ - last date of submission :</dt>
                                <dd><?php echo $bid_last_date; ?></dd>
                            </dl>
							<?php } ?>
							<?php if($bid_opening_date) { ?>
							<dl>
                                <dt><span class="icons6"></span>FRQ- Date of opening :</dt>
                                <dd><?php echo $bid_opening_date; ?></dd>
                            </dl>
							<?php } ?>
							<?php 
						if($auction_start_date == ""  || $auction_start_date != '0000-00-00 00:00:00'){ ?>
							<dl>
                                <dt><span class="icons6"></span>Auction Start Date :</dt>
                                <dd><?php echo $auction_start_date; ?></dd>
                            </dl>
							<?php } ?>
							<?php if( $auction_end_date == "" || $auction_end_date != '0000-00-00 00:00:00'){ ?>
							<dl>
                                <dt><span class="icons6"></span>Auction End Date :</dt>
                                <dd><?php echo $auction_end_date; ?></dd>
                            </dl>
							<?php } ?>
                        </div>
                    </div>
                </div>
                <?php if(!empty($product_description)) { ?>
                <div class="box">
                    <h5>Property Address </h5>
                    <p><span  itemprop="description"><?php echo $product_description; ?></span></p>
                </div>
                <?php } ?>
                <div class="download-doc">
                    <div class="down_box">
                        <div class="downicon-section"><img src="<?php echo base_url() ?>images/download-img.png"></div>
                        <div class="content-section">
                            <h5>Documents to be Submitted</h5>
                            <ul>
                                <?php foreach ($docList as $key => $value) { ?>
                                    <li><?php echo $value->name; ?></li>

                                <?php } ?>
                            </ul>
							<div class="nit_document">
                                                            <?php if(!empty($docName)){ ?>
							 <span class="down-txt"> NIT Documents</span>
                            <a class="b_download float-right" download="" href="/public/uploads/event_auction/<?php echo $docName ?>">Download</a>
                            <?php } ?>

							</div>
							
							
                           
                        </div>
                            
                    </div>
                    <!-- <div class="time_remain"><span>Time Remaining:</span> 10:20:35</div>--> 
                </div>
                <div id="tab-pannel" class="btmrgn">
                    <ul class="tabs">
                        <li class="active" rel="tab1">Location Map</li>
                        <!--<li rel="tab2">View Notice</li>-->
                        <li rel="tab3">Photos</li>
                        <li rel="tab4">Videos</li>
                        <!--<li rel="tab5">Contact to Know More </li>-->
                    </ul>
                    <div class="tab_container">
                        <div id="tab1" class="tab_content"> 
						
                            <?php
							//echo $fulladdress;;
							if(!empty($address)) { ?>
							<div itemtype="http://schema.org/PostalAddress" itemscope=""
 class="add" id="add1" style="width: 756px; height: 300px; float: left; margin: 20px;"><?php echo $fulladdress; ?></div>
                            <?php } else echo "No Address Available";?>
                         
                        </div>

                        <!-- #tab1 -->
                      

                        <!-- #tab2 -->
                        <div id="tab3" class="tab_content">
                            <div class="photos-wrapper">
                                <?php if(!empty($product_image)) { foreach ($product_image as $imageValue) { ?>
                                    <a class="example-image-link" href="<?php echo "/public/uploads/property_images/" . $imageValue->name ?>" data-lightbox="example-set">
                                        <img class="example-image" src="<?php echo "/public/uploads/property_images/" . $imageValue->name ?>" alt="" />
                                    </a>
                                <?php } } else echo "No Photo Available";?>

                            </div>
                        </div>

                        <!-- #tab2 -->
                        <div id="tab4" class="tab_content">
						<?php
					if($video->name)
					{
						if($video->type=='url')
						{  ?>
							<?php if(!empty($video->name)){
							
								$vi=explode("?v=",$video->name);
							?>
							
							
							<iframe width="780" height="350" src="https://www.youtube.com/embed/<?php echo $vi[1];?>" frameborder="0" allowfullscreen></iframe>
							
					
							<?php } else { echo "No video Available"; } ?>
					<?php } elseif($video->type=='video'){ 
							$videoname=base_url().'public/uploads/videos/'.$video->name;
						?>	
							<video width="780" height="350">
							<source src="<?php echo $videoname;?>" type="video/mp4">
							<!--<source src="movie.ogg" type="video/ogg">
							Your browser does not support the video tag.-->
							</video>
							
						
					<?php }
					}else{ ?>
					No Video Available
					<?php } ?>
						
						
						
						
						
                        </div>

                        <!-- #tab2 -->
                        <!--<div id="tab5" class="tab_content"> 
                            B3, 1st Floor, Sector 4, Noida - 201301, India
                        </div>-->
                    </div>
                    <!-- #tab2 --> 
                </div>
               


                <div class="review-rating">
                    <div id="review-section" class="heading1 heading_bor btmrg20">Review & Ratings </div>
                    <div class="seprator btmrg20 tpmrg20"></div>
                    <div class="row btmrg20">Rating<span itemprop="ratingValue"> <?php echo $totalAvgRating ?>/5</span> from <?php echo $countUser; ?> users |  <a href="#"><?php echo $countUser; ?> Reviews</a></div>
                    <div class="row">
                        <div class="col"> 
                            <h6>Environment</h6>
                            <div class="row">
                                <dl>
                                    <dt>Neighbourhood:Roads</dt>
                                    <dd>
                                        <?php
                                        for ($i = 1; $i <= 5; $i++) {
                                            if ($i <= $neighborhood) {
                                                $neighborhood_active = "active";
                                            } else {
                                                $neighborhood_active = "";
                                            }
                                            ?>

                                            <a href="javascript:void(0)"><img src="/images/green-star.png" class="<?php echo $neighborhood_active; ?>"></a> 
                                        <?php } ?>
                                    </dd>
                                </dl>
                                <dl>
                                    <dt>Safety</dt>
                                    <dd>
                                        <?php
                                        for ($i = 1; $i <= 5; $i++) {
                                            if ($i <= $safety) {
                                                $safety_active = "active";
                                            } else {
                                                $safety_active = "";
                                            }
                                            ?>

                                            <a href="javascript:void(0)"><img src="/images/green-star.png" class="<?php echo $safety_active; ?>"></a> 
                                        <?php } ?>
                                    </dd>
                                </dl>
                                <dl>
                                    <dt>Cleanliness</dt>
                                    <dd>
                                        <?php
                                        for ($i = 1; $i <= 5; $i++) {
                                            if ($i <= $cleanliness) {
                                                $cleanliness_active = "active";
                                            } else {
                                                $cleanliness_active = "";
                                            }
                                            ?>

                                            <a href="javascript:void(0)"><img src="/images/green-star.png" class="<?php echo $cleanliness_active; ?>"></a> 
                                        <?php } ?>
                                    </dd>
                                </dl>


                            </div>
                        </div>
                        <div class="col"> 
                            <h6>Commuting</h6>
                            <div class="row">
                                <dl>
                                    <dt>Public Transport</dt>
                                    <dd>
                                        <?php
                                        for ($i = 1; $i <= 5; $i++) {
                                            if ($i <= $public_transport) {
                                                $public_transport_active = "active";
                                            } else {
                                                $public_transport_active = "";
                                            }
                                            ?>

                                            <a href="javascript:void(0)"><img src="/images/green-star.png" class="<?php echo $public_transport_active; ?>"></a> 
                                        <?php } ?>
                                    </dd>
                                </dl>
                                <dl>
                                    <dt>Parking</dt>
                                    <dd>
                                        <?php
                                        for ($i = 1; $i <= 5; $i++) {
                                            if ($i <= $parking) {
                                                $parking_active = "active";
                                            } else {
                                                $parking_active = "";
                                            }
                                            ?>

                                            <a href="javascript:void(0)"><img src="/images/green-star.png" class="<?php echo $parking_active; ?>"></a> 
                                        <?php } ?>
                                    </dd>
                                </dl>
                                <dl>
                                    <dt>Connectivity</dt>
                                    <dd>
                                        <?php
                                        for ($i = 1; $i <= 5; $i++) {
                                            if ($i <= $connectivity) {
                                                $connectivity_active = "active";
                                            } else {
                                                $connectivity_active = "";
                                            }
                                            ?>

                                            <a href="javascript:void(0)"><img src="/images/green-star.png" class="<?php echo $connectivity_active; ?>"></a> 
                                        <?php } ?>
                                    </dd>
                                </dl>
                                <dl>
                                    <dt>Traffic</dt>
                                    <dd>
                                        <?php
                                        for ($i = 1; $i <= 5; $i++) {
                                            if ($i <= $traffic) {
                                                $traffic_active = "active";
                                            } else {
                                                $traffic_active = "";
                                            }
                                            ?>

                                            <a href="javascript:void(0)"><img src="/images/green-star.png" class="<?php echo $traffic_active; ?>"></a> 
                                        <?php } ?>
                                    </dd>
                                </dl>


                            </div>
                        </div>
                        <div class="rating-txt"> 
                            <h6>Overall Rating</h6>
                            <div class="row">
                                <dl>
                                    <dt>Excellent: <?php echo $excellent; ?></dt>
                                    <dd></dd>
                                </dl>
                                <dl>
                                    <dt>Very Good: <?php echo $veryGood; ?></dt>
                                    <dd></dd>
                                </dl>
                                <dl>
                                    <dt>Good : <?php echo $good; ?></dt>
                                    <dd></dd>
                                </dl>


                            </div>
                        </div>
                        <div class="rating-bg"><span itemprop="ratingValue"><?php echo $totalAvgRating ?></span></div>

                    </div>

                    <div class="seprator btmrg20 tpmrg20"></div>
                    <div id="rating_review">
                        <?php if (!empty($userId)) { ?>
                            <input type="button" value="Add Review and Rating" name="rating_review" id="rating_review_id" class="b_default">
                        <?php } else { ?>
                             <a class="b_default" href="/registration/login?review=1">Add Review and Rating</a>
                        <?php } ?>
                    </div>
                    <div class="rating_form-wrapper" id="rating_form">

                        <form action="/property/ratingReview/<?php echo $id ?>#review-section" method="post" name="review_rating" id="review_rating">
                            <div class="form">
							<dl>
                                    <dt class="">
                                    <label>Neighborhood:Roads</label>
                                    </dt>
                                    <dd class="rating" >
                                        <a href="javascript:void(0)" id="neighborhood1" onclick="addRating('1', 'neighborhood')"><img src="<?php echo base_url();?>images/green-star.png"></a> 
                                        <a href="javascript:void(0)" id="neighborhood2" onclick="addRating('2', 'neighborhood')"><img src="<?php echo base_url();?>images/green-star.png"></a> 
                                        <a href="javascript:void(0)" id="neighborhood3" onclick="addRating('3', 'neighborhood')"><img src="<?php echo base_url();?>images/green-star.png"></a> 
                                        <a href="javascript:void(0)" id="neighborhood4" onclick="addRating('4', 'neighborhood')"><img src="<?php echo base_url();?>images/green-star.png"></a> 
                                        <a href="javascript:void(0)" id="neighborhood5" onclick="addRating('5', 'neighborhood')"><img src="<?php echo base_url();?>images/green-star.png"></a>
                                    </dd>
                                </dl>
                                <dl>
                                    <dt class="">
                                    <label>Safety</label>
                                    </dt>
                                    <dd class="rating">
                                        <a href="javascript:void(0)" id="safety1" onclick="addRating('1', 'safety')"><img src="<?php echo base_url();?>images/green-star.png"></a> 
                                        <a href="javascript:void(0)" id="safety2" onclick="addRating('2', 'safety')"><img src="<?php echo base_url();?>images/green-star.png"></a> 
                                        <a href="javascript:void(0)" id="safety3" onclick="addRating('3', 'safety')"><img src="<?php echo base_url();?>images/green-star.png"></a> 
                                        <a href="javascript:void(0)" id="safety4" onclick="addRating('4', 'safety')"><img src="<?php echo base_url();?>images/green-star.png"></a> 
                                        <a href="javascript:void(0)" id="safety5" onclick="addRating('5', 'safety')"><img src="<?php echo base_url();?>images/green-star.png"></a>
                                    </dd>
                                </dl>
                                <dl>
                                    <dt class="">
                                    <label>Cleanliness</label>
                                    </dt>
                                    <dd class="rating">
                                        <a href="javascript:void(0)" id="cleanliness1" onclick="addRating('1', 'cleanliness')"><img src="<?php echo base_url();?>images/green-star.png"></a> 
                                        <a href="javascript:void(0)" id="cleanliness2" onclick="addRating('2', 'cleanliness')"><img src="<?php echo base_url();?>images/green-star.png"></a> 
                                        <a href="javascript:void(0)" id="cleanliness3" onclick="addRating('3', 'cleanliness')"><img src="<?php echo base_url();?>images/green-star.png"></a> 
                                        <a href="javascript:void(0)" id="cleanliness4" onclick="addRating('4', 'cleanliness')"><img src="<?php echo base_url();?>images/green-star.png"></a> 
                                        <a href="javascript:void(0)" id="cleanliness5" onclick="addRating('5', 'cleanliness')"><img src="<?php echo base_url();?>images/green-star.png"></a>
                                    </dd>
                                </dl>
                                <dl>
                                    <dt class="">
                                    <label>Public Transport</label>
                                    </dt>
                                    <dd class="rating">
                                        <a href="javascript:void(0)" id="public_transport1" onclick="addRating('1', 'public_transport')"><img src="<?php echo base_url();?>images/green-star.png"></a> 
                                        <a href="javascript:void(0)" id="public_transport2" onclick="addRating('2', 'public_transport')"><img src="<?php echo base_url();?>images/green-star.png"></a> 
                                        <a href="javascript:void(0)" id="public_transport3" onclick="addRating('3', 'public_transport')"><img src="<?php echo base_url();?>images/green-star.png"></a> 
                                        <a href="javascript:void(0)" id="public_transport4" onclick="addRating('4', 'public_transport')"><img src="<?php echo base_url();?>images/green-star.png"></a> 
                                        <a href="javascript:void(0)" id="public_transport5" onclick="addRating('5', 'public_transport')"><img src="<?php echo base_url();?>images/green-star.png"></a>
                                    </dd>
                                </dl>
                                <dl>
                                    <dt class="">
                                    <label>Parking</label>
                                    </dt>
                                    <dd class="rating">
                                        <a href="javascript:void(0)" id="parking1" onclick="addRating('1', 'parking')"><img src="<?php echo base_url();?>images/green-star.png"></a>
                                        <a href="javascript:void(0)" id="parking2" onclick="addRating('2', 'parking')"><img src="<?php echo base_url();?>images/green-star.png"></a> 
                                        <a href="javascript:void(0)" id="parking3" onclick="addRating('3', 'parking')"><img src="<?php echo base_url();?>images/green-star.png"></a> 
                                        <a href="javascript:void(0)" id="parking4" onclick="addRating('4', 'parking')"><img src="<?php echo base_url();?>images/green-star.png"></a> 
                                        <a href="javascript:void(0)" id="parking5" onclick="addRating('5', 'parking')"><img src="<?php echo base_url();?>images/green-star.png"></a>
                                    </dd>
                                </dl>
                                <dl>
                                    <dt class="">
                                    <label>Connectivity</label>
                                    </dt>
                                    <dd class="rating">
                                        <a href="javascript:void(0)" id="connectivity1" onclick="addRating('1', 'connectivity')"><img src="<?php echo base_url();?>images/green-star.png"></a> 
                                        <a href="javascript:void(0)" id="connectivity2" onclick="addRating('2', 'connectivity')"><img src="<?php echo base_url();?>images/green-star.png"></a> 
                                        <a href="javascript:void(0)" id="connectivity3" onclick="addRating('3', 'connectivity')"><img src="<?php echo base_url();?>images/green-star.png"></a> 
                                        <a href="javascript:void(0)" id="connectivity4" onclick="addRating('4', 'connectivity')"><img src="<?php echo base_url();?>images/green-star.png"></a> 
                                        <a href="javascript:void(0)" id="connectivity5" onclick="addRating('5', 'connectivity')"><img src="<?php echo base_url();?>images/green-star.png"></a>
                                    </dd>
                                </dl>
                                <dl>
                                    <dt class="">
                                    <label>Traffic</label>
                                    </dt>
                                    <dd class="rating">
                                        <a href="javascript:void(0)" id="traffic1" onclick="addRating('1', 'traffic')"><img src="<?php echo base_url();?>images/green-star.png"></a> 
                                        <a href="javascript:void(0)" id="traffic2" onclick="addRating('2', 'traffic')"><img src="<?php echo base_url();?>images/green-star.png"></a> 
                                        <a href="javascript:void(0)" id="traffic3" onclick="addRating('3', 'traffic')"><img src="<?php echo base_url();?>images/green-star.png"></a> 
                                        <a href="javascript:void(0)" id="traffic4" onclick="addRating('4', 'traffic')"><img src="<?php echo base_url();?>images/green-star.png"></a> 
                                        <a href="javascript:void(0)" id="traffic5" onclick="addRating('5', 'traffic')"><img src="<?php echo base_url();?>images/green-star.png"></a>
                                    </dd>
                                </dl>
                               
                                <dl class="row">
                                    <dt>Write Review</dt>
                                    <dd><textarea rows="5" cols="25" name="review" id="reviewtext"></textarea></dd>
                                </dl>
                                <dl>
                                    <dt>&nbsp;                                                
                                    </dt><dd>
                                        <input type="submit" name="submit" value="submit" class="b_default">
                                        <input type="hidden" name="id" value="<?php echo $id ?>">
                                        <input type="hidden" name="rating_review_id" value="<?php echo $rating_review_id[0]->id ?>">
                                        
                                        <input type="hidden" name="traffic" id="traffic" value="<?php echo $reviewAll[0]->traffic ?>">
                                        <input type="hidden" name="connectivity" id="connectivity" value="<?php echo $reviewAll[0]->connectivity ?>">
                                        <input type="hidden" name="parking" id="parking" value="<?php echo $reviewAll[0]->parking ?>">
                                        <input type="hidden" name="public_transport" id="public_transport" value="<?php echo $reviewAll[0]->public_transport ?>">
                                        <input type="hidden" name="cleanliness" id="cleanliness" value="<?php echo $reviewAll[0]->cleanliness ?>">
                                        <input type="hidden" name="safety" id="safety" value="<?php echo $reviewAll[0]->safety ?>">
                                        <input type="hidden" name="neighborhood" id="neighborhood" value="<?php echo $reviewAll[0]->neighborhood ?>">
                                    </dd></dl>

                            </div>
                        </form>

                    </div>
                </div>

<?php if($countUser>0){ ?>
                <div class="review-wrapper">
				
                    <h4><?php echo $countUser; ?>  Reviews</h4>

                    <ul id="reviewsList">
                        <?php foreach ($reviewAll as $value) {
						
									if($value->user_type=='branch'){
										$userName= GetTitleByField('tbl_user',"id=".$value->user_id,'first_name');
									}else{
										$userName= GetTitleByField('tbl_user_registration',"id=".$value->user_id,'first_name');	
									}
									
									
						?>
                            <li>
                                <div class="left-panel"> 
                                    <img src="/images/review-user.jpg">
                                    <div class="row">
									
									<?php echo $userName;?>
									</div>
                                </div>        
                                <div class="right-panel">
                                    <div class="row">
                                        <ul><li>Reviewed on:<span><?php echo date("d/m/y H:i:s", strtotime($value->created_date)) ?></span></li>
                                        </ul></div>
                                    <p><?php echo $value->reviews ?></p>
                                </div>
                            </li>
                        <?php } ?>
                    </ul>
			
                  <?php if($countUser>3){ ?>
				<div style="float:right;"><a href="javascript:" onclick="loadAllReviewsData(<?php echo $id ?>);">View More</a></div>
					<?php } ?> 

                </div>
					<?php } 
					if($property_type!=0){
					?>
                     <div class="similar-prop">
                    <div class="heading1 heading_bor btmrg20">Similar Properties</div>
                    <?php foreach ($property_type as $value) { ?>                      

                        <div class="similar_widget1">
                            <div class="image-wrapper" itemscope itemtype="http://schema.org/ImageObject">
                                <a href="/property/detail/<?php echo $value->id ?>"><img src="/public/uploads/property_images/<?php echo $value->name; ?>" itemprop="contentURL"></a> 
                            </div>
                            <div class="container">
                                <div class="left-section">
                                    <div class="heading1">
                                        <a href="/property/detail/<?php echo $value->id ?>"><?php echo ucfirst($value->title) ?></a> 
                                    </div>
                                    <div class="property-detail">
                                        <div class="block"><span>Property Type:</span><?php echo $value->product_type_val ?></div>
                                        <div class="block"  itemscope itemtype="http://schema.org/Offer"><span>Reserved Price:</span><span  itemprop="price"> <?php echo $value->reserve_price ?></span></span></div>
                                        <div class="block"><span>Location:</span> <?php echo $value->city_name ?></div>
                                        <!--<div class="block"><span>Time Remaining:</span> <div data-countdown="<?php echo $value->bid_last_date; ?>"></div></div>-->
                                    </div>
                                </div>
                                <div class="right-section"> <a href="/property/detail/<?php echo $value->id ?>" class="arrow"><img src="/images/similar-arrow.png"></a></div>
                            </div>
                        </div>
                    <?php } ?>

                </div>
					<?php } ?>
            </section>
            <section id="right-section">
                <div class="online_event">
                    <div class="heading4 btmrg20">Auction Details</div>
                    <div class="online-content">
                        <?php if(!empty($bank_name)){ ?>
                        <dl>
                            <dt>Bank</dt>
                            <dd><strong><?php echo $bank_name; ?></strong></dd>
                        </dl>
                        <?php } ?>
                        <?php if(!empty($event_type)){ ?>
                        <dl>
                            <dt>Auction Type</dt>
                            <dd><?php echo $event_type ?></dd>
                        </dl>
                        <?php } ?>
                        <?php //if(!empty($tender_no)){ ?>
                        <dl>
                            <dt>Auction No</dt>
                            <dd><?php echo $auctionID ?></dd>
                        </dl>
                        <?php //} ?>
                        <?php if(!empty($reference_no)){ ?>
                        <dl>
                            <dt>NIT Ref No</dt>
                            <dd><?php echo $reference_no; ?></dd>
                        </dl>
                        <?php } ?>
						
					
                        
						 <?php if(!empty($event_title)){ ?>
                        <dl>
                            <dt>Tender Title</dt>
                            <dd><?php echo $event_title ?></dd>
                        </dl>
                        <?php } ?>
                       <?php if(!empty($tender_fee) && $auction_type!='1'){
	
					   ?>
						 <dl>
                            <dt>Tender Fee</dt>
                            <dd><span  itemprop="price"><strong><?php if(!empty($tender_fee)){ echo "Rs." . number_format($tender_fee, 2); }?></strong></dd></span>
                        </dl>
						<?php } ?>
                        <?php if(!empty($reserve_price)){ ?>
                        <dl>
                            <dt>Reserved Price</dt>
                            <dd><span  itemprop="price"><?php echo number_format($reserve_price, 2); ?></span></dd>
                        </dl>
                        <?php } ?>
                        <?php if(!empty($emd_amt) && $auction_type!='1'){ ?>
                        <dl>
                            <dt>EMD</dt>
                            <dd><span  itemprop="price"><?php echo $emd_amt; ?></span></dd>
                        </dl>
                      <?php } ?>
					    <?php if(!empty($price_bid_applicable)){ ?>
                        <dl>
                            <dt> Price Bid</dt>
                            <dd><?php 
							if($price_bid_applicable=='not_applicable')
							{
								echo 'Not Applicable';	
							}
							else{
								echo "Application";	
							}
							 ?></dd>
                        </dl>
                      <?php } ?>
                       
                        <?php if(!empty($bid_inc)){ ?>
                        <dl>
                            <dt>Bid Increment Value</dt>
                            <dd><span  itemprop="price"><?php echo "Rs." . number_format($bid_inc, 2); ?></span></dd>
                        </dl>
                        <?php } ?>
                        <?php if(!empty($auto_extension_time)){ ?>
                        <dl>
                            <dt>Auto Extension Time</dt>
                            <dd><?php echo $auto_extension_time . " min" ?> </dd>
                        </dl>
                        <?php } ?>
                        <?php if(!empty($no_of_auto_extn)){ ?>
                        <dl>
                            <dt>No. of Auto Extension</dt>
                            <dd><?php 
							if($no_of_auto_extn==100)
							{
								echo "Unlimited";
							}else{
								echo $no_of_auto_extn; 
							}
							
							?></dd>
                        </dl>
                        <?php } ?>
			<?php if($totalCirrigendum>0){ ?>
						<dl>
                                                <dt>Corrigendum</dt>
                                                 <dd>
                                <?php 
								if($totalCirrigendum>0)
								{
									echo "Yes";
								}
							?></dd>
                        </dl>
						<?php } ?>						
                    </div>
                    <div class="bt_login-wrapper">
                        <?php
						//echo $bid_last_date
                        //print_r($this->session->userdata);
						 $bid_last_date;
						 $bid_last_date=strtotime($bid_last_date);
						 $auction_end_date=strtotime($auction_end_date);
						 //$currenttime=time();
						 $currenttime=strtotime(date('Y-m-d H:i:s'));
						
						$currenttime	= (int)$currenttime;
						$bid_last_date	= (int)$bid_last_date;
						
					if($bid_last_date >= $currenttime){
                        $userdID = $this->session->userdata('id');
                        $user_type = $this->session->userdata('user_type');

						 if ($userdID >0) {
                            if ($user_type == 'owner' || $user_type == 'builder' || $user_type == 'broker') { 
							if($userdID != $created_by && $userdID != $first_opener){
							?>
                                <a href="/owner/auctionParticipage/<?php echo $auctionID; ?>">
								<input name="bid now" value="Bid Now" type="button" class="b_bidnow"></a>
                            <?php
							}else{ ?>
							<a href="javascript:">
							<input name="bid now" value="Bid Now" type="button" class="b_bidnow"></a>	
						<?php }
							}else{ ?>
								
							<a href="javascript:"><input name="bid now" value="Bid Now" type="button" class="b_bidnow"></a>
							
						<?php	} ?>

                        <?php } else { ?>	
                            <a href="/registration/login?track=bidder&auctionID=<?php echo $auctionID; ?>"><input name="bid now" value="Bid Now" type="button" class="b_bidnow">
						<?php }
						
							}else{
						  
							
							if($auction_end_date < $currenttime){
							?>
							<input name="bid now" value="Auctioned" type="button" class="b_bidnow">
						<?php 
							}else{?>
							<input name="bid now" value="Auction Is Live" type="button" class="b_bidnow">
						<?php } }?>

                            </div>
                            </div>
                            <div class="cust_support">
                                <div class="heading4 btmrg20">Customer Support</div>
                                <div class="row">
                                    <ul>
                                        <!--<li class="phone">Call us on: <a>+91-120-4888888</a></li>-->
                                        <li class="email">Email: <a href="#">info@back-eauctions.com</a></li>
                                        <li class="fax">Fax: <a>011-2345678</a></li>
                                    </ul>
                                </div>
                                <!--<a href="#" class="b_live-help">Live Help</a>--> </div>
						<?php
			if($recent_properties !=0){
			?>		
                            <div class="view_recent-prop">
                                <div class="heading4 btmrg20"> View Recent Properties in Your Area</div>
                                <div class="row">
                                    <ul>
                                        <?php foreach ($recent_properties as $value) { ?>
                                            <li><a href="/property/?location=<?php echo $value->city_name ?>&act=auction"><?php echo $value->city_name ?><span>(<?php echo $value->count ?>)</span></a></li>
                                        <?php } ?>
                                    </ul>
                                </div>
                            </div>
			<?php } ?>	
                            <div class="recent-blog">
                                <div class="heading4 btmrg20">Recent Blogs</div>
                                <div class="row">
                                    <ul>
                                        <?php foreach ($blogs as $blogsData) { ?>
                                            <li>
                                                <div class="date"><?php echo "By " . $blogsData->author . ", " . date("d F Y", strtotime($blogsData->publish_date)); ?></div>
                                                <div class="heading4"><a href="<?php echo base_url(); ?>blog/details/<?php echo $blogsData->id; ?>"><span class="chat-icon"></span>Recent Press: <?php echo $blogsData->title ?></a> </div>
                                                <div class="content"><?php echo $blogsData->short_desc; ?>
                                                    <a href="<?php echo base_url(); ?>blog/details/<?php echo $blogsData->id; ?>" class="green-more">[more...]</a>
                                                </div>
                                            </li>
                                        <?php } ?>
                                        <div class="row text-right"> <a href="<?php echo base_url() ?>blog" class="green-more">More Blogs...</a> </div>
                                    </ul>
                                </div>
                            </div>

                            <div class="subscribe_wrapper">
                                <div class="row">
                                    <div class="head-txt">Stay Updated With us</div>
                                </div>
                                <form name="subscribe" id="Subscribe" method="post">
                                    <div class="row">
                                        <input name="email" id="email" type="text" class="input">
                                    </div>
                                    <div class="row">
                                        <input value="Subscribe" type="button" class="b_get" onclick="emailSubscribe();">
                                    </div>
                            </div>
                            <div id="emailSubscribe" style="color: red">email already exist</div>
                            <div id="valid_email_error" style="color: red">Please provide a valid email address</div>
                            <div id="successfully_subscribed" style="color: green;">Successfully Subscribed</div>
                            </form>
                            </section>
                    </div>
                </div>

