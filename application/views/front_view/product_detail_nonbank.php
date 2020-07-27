<?php
$product_id=$id;
?>
<link rel="stylesheet" href="<?php echo base_url(); ?>css/lightbox.css">
<script type="text/javascript" src="<?php echo base_url(); ?>js/jquery.ui.map.js"></script> 
<script type="text/javascript" src="<?php echo base_url(); ?>js/lightbox.js"></script>

<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&signed_in=true"></script>
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
        //if (document.getElementById("propertySearch").value == "") {
        //alert("Please enter the search text");
        // document.getElementById("propertySearch").focus();
        //  return false;
        //} else {
        document.forms["property_search"].submit();
        //}
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
                    alert("Rating and reviews submitted succssfully");// do other stuff for a valid form
                    form.submit();
                },
	});
});
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
                        $("#emailSubscribe").hide();
                        $("#successfully_subscribed").show();
                    }
                }

            });
        }
    }
</script>
<script>
    function codeAddress(addr = null, div_id = null) {
        var id = div_id
        var address = addr;

        geocoder = new google.maps.Geocoder();
        var mapOptions = {
            zoom: 17,
        }

        geocoder.geocode({'address': address}, function (results, status) {
            if (status == google.maps.GeocoderStatus.OK) {
                map.setCenter(results[0].geometry.location);
                var marker = new google.maps.Marker({
                    map: map,
                    position: results[0].geometry.location
                });
            }
            var contentString = address;
            var infowindow = new google.maps.InfoWindow({
                content: contentString
            });
            //google.maps.event.addListener(marker, 'mouseover', function() {
            //infowindow.open(map,marker);
            //});
            google.maps.event.addListenerOnce(map, 'idle', function () {
                infowindow.open(map, marker);
            });
        });
        map = new google.maps.Map(document.getElementById(id), mapOptions);
    }
</script>
<section>
    <div class="breadcrum">
        <div class="wrapper"> <a href="<?php echo base_url() ?>" class="Home">Home</a>&nbsp;»&nbsp;<span>Buy</span>&nbsp;»&nbsp;<span>Residential Flats</span> </div>
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
                <div class="story-detail"> 
                    <span><?php if (!empty($city_name)) echo $city_name ?></span> 
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
                        <div itemscope="" itemtype="http://schema.org/ImageObject">
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

              
                <?php if(!empty($product_description)) { ?>
                <div class="box">
                    <h5>Property Address </h5>
                    <p> <span itemprop="description"><?php echo $product_description; ?></span></p>
                </div>
                <?php } ?>
     
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
							<div class="add" id="add1" style="width: 756px; height: 300px; float: left; margin: 20px;"><?php echo $fulladdress; ?></div>
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
							<video width="780" height="350" controls>
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
                    <div id="review-section" class="heading1 heading_bor btmrg20">Review & Ratings</div>
                    <div class="seprator btmrg20 tpmrg20"></div>
                    <div class="row btmrg20"><span itemprop="ratingValue"><?php echo $totalAvgRating ?>/5</span> from <?php echo $countUser; ?> users |  <?php echo $countUser; ?>  Reviews</div>
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

                                            <a href="javascript:void(0)"><img src="<?php echo base_url(); ?>images/green-star.png" class="<?php echo $neighborhood_active; ?>"></a> 
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

                                            <a href="javascript:void(0)"><img src="<?php echo base_url(); ?>images/green-star.png" class="<?php echo $safety_active; ?>"></a> 
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

                                            <a href="javascript:void(0)"><img src="<?php echo base_url(); ?>images/green-star.png" class="<?php echo $cleanliness_active; ?>"></a> 
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

                                            <a href="javascript:void(0)"><img src="<?php echo base_url(); ?>images/green-star.png" class="<?php echo $public_transport_active; ?>"></a> 
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

                                            <a href="javascript:void(0)"><img src="<?php echo base_url(); ?>images/green-star.png" class="<?php echo $parking_active; ?>"></a> 
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

                                            <a href="javascript:void(0)"><img src="<?php echo base_url(); ?>images/green-star.png" class="<?php echo $connectivity_active; ?>"></a> 
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

                                            <a href="javascript:void(0)"><img src="<?php echo base_url(); ?>images/green-star.png" class="<?php echo $traffic_active; ?>"></a> 
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
                    <div class="rating_form-wrapper" id="rating_form" itemprop="reviewRating" itemscope itemtype="http://schema.org/Rating">

                        <form action="/property/ratingReview/<?php echo $id ?>#review-section" method="post" name="review_rating" id="review_rating">
                            <div class="form">

                                <dl>
                                    <dt class="">
                                    <label>Neighbourhood:Roads</label>
                                    </dt>
                                    <dd class="rating"  itemprop="reviewRating" itemscope itemtype="http://schema.org/Rating">
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
                                    <img src="<?php echo base_url();?>images/review-user.jpg">
                                    <div class="row"><?php echo $userName;?></div>
                                </div>        
                                <div class="right-panel">
                                    <div class="row">
                                        <ul>
                                            <li>Reviewed on:<span><?php echo date("d/m/y H:i:s", strtotime($value->created_date)) ?></span></li>
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
                                <a href="/property/detail/<?php echo $value->id ?>"><img itemprop="contentURL" src="/public/uploads/property_images/<?php echo $value->name; ?>"></a> 
                            </div>
                            <div class="container">
                                <div class="left-section">
                                    <div class="heading1">
                                        <a href="/property/detail/<?php echo $value->id ?>"><?php echo ucfirst($value->title) ?></a> 
                                    </div>
                                    <div class="property-detail">
                                        <div class="block"><span>Property Type:</span><?php echo $value->product_type_val ?></div>
                                        <div class="block" itemscope itemtype="http://schema.org/Offer"><span>Reserved Price:</span><span  itemprop="price"> <?php echo $value->reserve_price ?></span></span></div>
                                        <div class="block"><span>Location:</span> <?php echo $value->city_name ?></div>
                                       <!-- <div class="block"><span>Time Remaining:</span> <div data-countdown="<?php echo $value->bid_last_date; ?>"></div></div>-->
                                    </div>
                                </div>
                                <div class="right-section"> <a href="/property/detail/<?php echo $value->id ?>" class="arrow"><img src="<?php echo base_url();?>images/similar-arrow.png"></a></div>
                            </div>
                        </div>
<?php } ?>

                </div>

             <?php } ?>  
            </section>
            <section id="right-section">
                
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
			<li><a href="/property/?location=<?php echo $value->city_name ?>&act=nonauction"><?php echo $value->city_name ?><span>(<?php echo $value->count ?>)</span></a></li>
		<?php } ?>
				</ul>
			</div>
			</div><?php } ?>
                <div class="recent-blog">
                    <div class="heading4 btmrg20">Recent Blogs</div>
                    <div class="row">
                        <ul>
                            <?php foreach ($blogs as $blogsData) { ?>
                                <li>
                                    <div class="date"><?php echo "By " . $blogsData->author . ", " . date("d F Y", strtotime($blogsData->publish_date)); ?></div>
                                    <div class="heading4"><a href="<?php echo base_url(); ?>blog/details/<?php echo $blogsData->id; ?>"><span class="chat-icon"></span>Recent Press: <?php echo $blogsData->title ?></a> </div>
                                    <div class="content"><?php echo $blogsData->short_desc; ?><a href="<?php echo base_url(); ?>blog/details/<?php echo $blogsData->id; ?>" class="green-more">[more...]</a></div>
                                </li>
<?php } ?>
                            <div class="row text-right"> <a href="<?php echo base_url() ?>blog" class="green-more">More Blogs...</a> </div>
                        </ul>
                    </div>
                </div>
                <form name="subscribe" id="Subscribe" method="post">
                    <div class="subscribe_wrapper">
                        <div class="row">
                            <div class="head-txt">Stay Updated With us</div>
                        </div>
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
</section>
