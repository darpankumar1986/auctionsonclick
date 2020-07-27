<link rel="stylesheet" href="<?php echo base_url(); ?>css/lightbox.css">
<script type="text/javascript" src="<?php echo base_url(); ?>js/jquery.ui.map.js"></script> 
<script type="text/javascript" src="<?php echo base_url(); ?>js/lightbox.js"></script>

<script src="https://maps.googleapis.com/maps/api/js?v=3.exp&signed_in=true"></script>
<script type="text/javascript">

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
        });
        map = new google.maps.Map(document.getElementById(id), mapOptions);
    }
</script>
<section>
    <div class="breadcrum">
        <div class="wrapper"> <a href="index.html" class="Home">Home</a>&nbsp;»&nbsp;<span>Buy</span>&nbsp;»&nbsp;<span>Residential Flats</span> </div>
    </div>
    <div class="row">
        <div class="wrapper">
            <div class="search-panel">
                <input name="" type="text" placeholder="Search auction properties in your area" class="input">
                <select name="Property Types" class="select">
                    <option>Property Types</option>
                    <option>Property Types1</option>
                    <option>Property Types2</option>
                    <option>Property Types3</option>
                    <option>Property Types4</option>
                </select>
                <select name="Property Types" class="select">
                    <option>Budget</option>
                    <option>Budget1</option>
                    <option>Budget2</option>
                    <option>Budget3</option>
                    <option>Budget4</option>
                </select>
                <input name="search" type="button" value="" class="b_search-icon">
            </div>
            <section id="left-section">
                <h1><?php echo $address; ?></h1>
                <div class="story-detail"> <span><?php echo $city_name ?></span> <span>Updated By: <?php echo $name; ?></span> <span>Updated on: <?php echo date("d/m/y", strtotime($updated_date)); ?></span> <span>0 Interested users</span> </div>
                <div class="img_wrapper">
                    <div id="default_img">
                    <img src="/public/uploads/property_images/<?php echo $productImage; ?>">
                    <div class="verifyed"></div>
                    <div class="pro-detail">
                        <div class="sqr-feet">759 sqft</div>
                        <div class="bed">3bhk</div>
                        <div class="bath">2</div>
                    </div>
                    <div class="view-map"><a href="#"><img src="../../../images/view-map.png"></a></div>
                    </div>
                    <div id="map_canvas"></div>
                </div>
                
                <!-- <div class="heading2 heading_bor btmrg20">Property Details</div>-->

                <div class="box">
                    <div class="row">
                        <div class="col_wrapper">
                            <dl>
                                <dt><span class="icons1"></span>Brower's Name:</dt>
                                <dd><?php echo $borrower_name; ?></dd>
                            </dl>
                            <dl>
                                <dt><span class="icons2"></span>Bank Name:</dt>
                                <dd><?php echo $nodal_bank; ?></dd>
                            </dl>
                            <dl>
                                <dt><span class="icons3"></span>Bank Account Number:</dt>
                                <dd><?php echo $nodal_bank_account; ?></dd>
                            </dl>
                            <dl>
                                <dt><span class="icons4"></span>Bank IFSC code:</dt>
                                <dd><?php echo $branch_ifsc_code; ?></dd>
                            </dl>
                        </div>
                        <div class="col_wrapper">
                            <dl>
                                <dt><span class="icons5"></span>Press Release Date:</dt>
                                <dd><?php echo date("d/m/y", strtotime($press_release_date)) ?></dd>
                            </dl>
                            <dl>
                                <dt><span class="icons6"></span>Date of Inspection of Assets:</dt>
                                <dd><?php echo date("d/m/y", strtotime($inspection_date_from)) ?></dd>
                            </dl>
                            <dl>
                                <dt><span class="icons6"></span>Date of Inspection of Assets (to):</dt>
                                <dd><?php echo date("d/m/y", strtotime($inspection_date_to)) ?></dd>
                            </dl>
                        </div>
                    </div>
                </div>
                <div class="box">
                    <h5>Property Address </h5>
                    <p><?php echo $product_description; ?></p>
                </div>
                <div class="download-doc">
                    <div class="down_box">
                        <div class="downicon-section"><img src="../../../images/download-img.png"></div>
                        <div class="content-section">
                            <h5>Documents to be Submitted</h5>
                            <ul>
                                <?php foreach ($docList as $key => $value) { ?>
                                    <li><?php echo $value->name; ?></li>

                                <?php } $related_doc = "313a1d2e9522404936e21534b672021b.jpg" ?>
                            </ul>
                            <a href="<?php echo "product_detail/downloadDoc/"; ?>" class="b_download float-right">Download</a> </div>
                    </div>
                    <!-- <div class="time_remain"><span>Time Remaining:</span> 10:20:35</div>--> 
                </div>
                <div id="tab-pannel" class="btmrgn">
                    <ul class="tabs">
                        <li class="active" rel="tab1">Location Map</li>
                        <li rel="tab2">View Notice</li>
                        <li rel="tab3">Photos</li>
                        <li rel="tab4">Videos</li>
                        <li rel="tab5">Contact to Know More </li>
                    </ul>
                    <div class="tab_container">
                        <div id="tab1" class="tab_content"> 
                            <script type="text/javascript">
                                google.maps.event.addDomListener(window, 'load', function () {
                                    codeAddress('<?php echo $address . "," . $city_name; ?>', 'map-canvas0')
                                });
                            </script>
                            <div id="map-canvas0" style="width:756px;height:300px">
                            </div> 
                        </div>

                        <!-- #tab1 -->
                        <div id="tab2" class="tab_content">
                            
Lorem ipsum dolor sit amet, consectetuer adipiscing elit. Aenean commodo ligula eget dolor. Aenean massa. Cum sociis natoque penatibus et magnis dis parturient montes, nascetur ridiculus mus. Donec quam felis, ultricies nec, pellentesque eu, pretium quis, sem. Nulla consequat massa quis enim. Donec pede justo, fringilla vel, aliquet nec, vulputate eget, arcu. In enim justo, rhoncus ut, imperdiet a, venenatis vitae, justo. Nullam dictum felis eu pede mollis pretium. Integer tincidunt. Cras dapibus. Vivamus elementum semper nisi. Aenean vulputate eleifend tellus. Aenean leo ligula, porttitor eu, consequat vitae, eleifend ac, enim. Aliquam lorem ante, dapibus in, viverra quis, feugiat a, tellus. Phasellus viverra nulla ut metus varius laoreet. Quisque rutrum. Aenean imperdiet. Etiam ultricies nisi vel augue. Curabitur ullamcorper ultricies nisi. Nam eget dui. Etiam rhoncus. Maecenas tempus, tellus eget condimentum rhoncus, sem quam semper libero, sit amet adipiscing sem neque sed ipsum. Nam quam nunc, blandit vel, luctus pulvinar, hendrerit id, lorem. Maecenas nec odio et ante tincidunt tempus. Donec vitae sapien ut libero venenatis faucibus. Nullam quis ante. Etiam sit amet orci eget eros faucibus tincidunt. Duis leo. Sed fringilla mauris sit amet nibh. Donec sodales sagittis magna. Sed consequat, leo eget bibendum sodales, augue velit cursus nunc. 
                        </div>

                        <!-- #tab2 -->
                        <div id="tab3" class="tab_content">
                        <div>
                            <?php foreach($product_image as $imageValue) { ?>
                            <a class="example-image-link" href="<?php echo "/public/uploads/property_images/".$imageValue->name ?>" data-lightbox="example-set">
          <img class="example-image" src="<?php echo "/public/uploads/property_images/".$imageValue->name ?>" alt="" width="100px" height="100px"/>
      </a>
                 <?php } ?>

                                    </div>
                        </div>

                        <!-- #tab2 -->
                        <div id="tab4" class="tab_content">
                             <object width="780" height="350">
                                        <param name="movie" value="http://www.youtube.com/v/jmJawKaci00" />
                                        <embed src="http://www.youtube.com/v/jmJawKaci00"
                                               type="application/x-shockwave-flash" width="780" height="350" />
                                    </object>
                        </div>

                        <!-- #tab2 -->
                        <div id="tab5" class="tab_content"> 
                            B3, 1st Floor, Sector 4, Noida - 201301, India
                        </div>
                    </div>
                    <!-- #tab2 --> 
                </div>
                <div class="similar-prop">
                    <div class="heading1 heading_bor btmrg20">Similar Properties</div>
                    <div class="similar_widget1">
                        <div class="image-wrapper"><img src="../../../images/property_img3.png"></div>
                        <div class="container">
                            <div class="left-section">
                                <div class="heading1">22, Akbar Road,</div>
                                <div class="property-detail">
                                    <div class="block"><span>Property Type:</span> Villa</div>
                                    <div class="block"><span>Reserved Price:</span> 50.5Cr.</div>
                                    <div class="block"><span>Location:</span> New Delhi</div>
                                    <div class="block"><span>Time Remaining:</span> 00:00:20</div>
                                </div>
                            </div>
                            <div class="right-section"> <a href="#" class="arrow"><img src="../../../images/similar-arrow.png"></a></div>
                        </div>
                    </div>
                    <div class="similar_widget1">
                        <div class="image-wrapper"><img src="../../images/property_img3.png"></div>
                        <div class="container">
                            <div class="left-section">
                                <div class="heading1">22, Akbar Road,</div>
                                <div class="property-detail">
                                    <div class="block"><span>Property Type:</span> Villa</div>
                                    <div class="block"><span>Reserved Price:</span> 50.5Cr.</div>
                                    <div class="block"><span>Location:</span> New Delhi</div>
                                    <div class="block"><span>Time Remaining:</span> 00:00:20</div>
                                </div>
                            </div>
                            <div class="right-section"> <a href="#" class="arrow"><img src="../../images/similar-arrow.png"></a></div>
                        </div>
                    </div>
                    <div class="similar_widget1">
                        <div class="image-wrapper"><img src="../../images/property_img3.png"></div>
                        <div class="container">
                            <div class="left-section">
                                <div class="heading1">22, Akbar Road,</div>
                                <div class="property-detail">
                                    <div class="block"><span>Property Type:</span> Villa</div>
                                    <div class="block"><span>Reserved Price:</span> 50.5Cr.</div>
                                    <div class="block"><span>Location:</span> New Delhi</div>
                                    <div class="block"><span>Time Remaining:</span> 00:00:20</div>
                                </div>
                            </div>
                            <div class="right-section"> <a href="#" class="arrow"><img src="../../images/similar-arrow.png"></a></div>
                        </div>
                    </div>
                </div>


                <div class="review-rating">
                    <div class="heading1 heading_bor btmrg20">Review & Ratings of Vandana Villa</div>
                    <div class="seprator btmrg20 tpmrg20"></div>
                    <div class="row btmrg20">Rating 4.5/5 from 61 users |  <a href="#">65 Reviews</a></div>
                    <div class="row">
                        <div class="col"> 
                            <h6>Environment</h6>
                            <div class="row">
                                <dl>
                                    <dt>Neighborhood:Roads</dt>
                                    <dd>
                                        <a href="#"><img src="../../images/green-star.png" class="active"></a> <a href="#"><img src="../../images/green-star.png" class="active"></a> <a href="#"><img src="../../images/green-star.png" class="active"></a> <a href="#"><img src="../../images/green-star.png"></a> <a href="#"><img src="../../images/green-star.png"></a>
                                    </dd>
                                </dl>
                                <dl>
                                    <dt>Safety</dt>
                                    <dd>
                                        <a href="#"><img src="../../images/green-star.png" class="active"></a> <a href="#"><img src="../../images/green-star.png" class="active"></a> <a href="#"><img src="../../images/green-star.png" class="active"></a> <a href="#"><img src="../../images/green-star.png"></a> <a href="#"><img src="../../images/green-star.png"></a>
                                    </dd>
                                </dl>
                                <dl>
                                    <dt>Cleanliness</dt>
                                    <dd>
                                        <a href="#"><img src="../../images/green-star.png" class="active"></a> <a href="#"><img src="../../images/green-star.png" class="active"></a> <a href="#"><img src="../../images/green-star.png" class="active"></a> <a href="#"><img src="../../images/green-star.png"></a> <a href="#"><img src="../../images/green-star.png"></a>
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
                                        <a href="#"><img src="../../images/green-star.png" class="active"></a> <a href="#"><img src="../../images/green-star.png" class="active"></a> <a href="#"><img src="../../images/green-star.png" class="active"></a> <a href="#"><img src="../../images/green-star.png"></a> <a href="#"><img src="../../images/green-star.png"></a>
                                    </dd>
                                </dl>
                                <dl>
                                    <dt>Parking</dt>
                                    <dd>
                                        <a href="#"><img src="../../images/green-star.png" class="active"></a> <a href="#"><img src="../../images/green-star.png" class="active"></a> <a href="#"><img src="../../images/green-star.png" class="active"></a> <a href="#"><img src="../../images/green-star.png"></a> <a href="#"><img src="../../images/green-star.png"></a>
                                    </dd>
                                </dl>
                                <dl>
                                    <dt>Connectivity</dt>
                                    <dd>
                                        <a href="#"><img src="../../images/green-star.png" class="active"></a> <a href="#"><img src="../../images/green-star.png" class="active"></a> <a href="#"><img src="../../images/green-star.png" class="active"></a> <a href="#"><img src="../../images/green-star.png"></a> <a href="#"><img src="../../images/green-star.png"></a>
                                    </dd>
                                </dl>
                                <dl>
                                    <dt>Traffic</dt>
                                    <dd>
                                        <a href="#"><img src="../../images/green-star.png" class="active"></a> <a href="#"><img src="../../images/green-star.png" class="active"></a> <a href="#"><img src="../../images/green-star.png" class="active"></a> <a href="#"><img src="../../images/green-star.png"></a> <a href="#"><img src="../../images/green-star.png"></a>
                                    </dd>
                                </dl>


                            </div>
                        </div>
                        <div class="rating-txt"> 
                            <h6>Overall Rating</h6>
                            <div class="row">
                                <dl>
                                    <dt>Excellent:</dt>
                                    <dd>35 User</dd>
                                </dl>
                                <dl>
                                    <dt>Very Good:</dt>
                                    <dd>24 User</dd>
                                </dl>
                                <dl>
                                    <dt>Good :</dt>
                                    <dd>15 User</dd>
                                </dl>


                            </div>
                        </div>
                        <div class="rating-bg">4.5</div>

                    </div>
                    <div class="seprator btmrg20 tpmrg20"></div>
                </div>
                <div id="rating_review"><a href="/product_detail/ratingReview">Add Review and Rating</a></div>

                <div class="review-wrapper">
                    <h4>65 Reviews</h4>

                    <div class="button-section">
                        <select name="Sort by" class="select">
                            <option>Sort by</option>
                            <option>Sort by1</option>
                            <option>Sort by2</option>
                            <option>Sort by3</option>
                            <option>Sort by4</option>
                        </select>

                        <select name="All" class="select">
                            <option>All</option>
                            <option>All1</option>
                            <option>All2</option>
                            <option>All3</option>
                            <option>All4</option>
                        </select>
                    </div>

                    <ul>
                        <li>
                            <div class="left-panel"> 
                                <img src="../../images/review-user.jpg">
                                <div class="row">Sanskar</div>
                            </div>        
                            <div class="right-panel">
                                <h5>Good investment opportunity.</h5>
                                <div class="row">
                                    <ul>
                                        <li>Overall Rating:<span>4/5</span></li>
                                        <li>Reviewed on:<span>28/05/2015</span></li>
                                    </ul></div>
                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed sed consectetur orci, vulputate dapibus augue. Fusce mollis tincidunt nisi, eget volutpat sem porttitor et. Maecenas non risus at sapien tincidunt mollis quis gravida enim. Pellentesque habitant morbi tristique senectus et netus et male</p>
                            </div>
                        </li>
                        <li>
                            <div class="left-panel"> 
                                <img src="../../images/review-user.jpg">
                                <div class="row">Sanskar</div>
                            </div>        
                            <div class="right-panel">
                                <h5>Good investment opportunity.</h5>
                                <div class="row">
                                    <ul>
                                        <li>Overall Rating:<span>4/5</span></li>
                                        <li>Reviewed on:<span>28/05/2015</span></li>
                                    </ul></div>
                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed sed consectetur orci, vulputate dapibus augue. Fusce mollis tincidunt nisi, eget volutpat sem porttitor et. Maecenas non risus at sapien tincidunt mollis quis gravida enim. Pellentesque habitant morbi tristique senectus et netus et male</p>
                            </div>
                        </li>
                        <li>
                            <div class="left-panel"> 
                                <img src="../../images/review-user.jpg">
                                <div class="row">Sanskar</div>
                            </div>        
                            <div class="right-panel">
                                <h5>Good investment opportunity.</h5>
                                <div class="row">
                                    <ul>
                                        <li>Overall Rating:<span>4/5</span></li>
                                        <li>Reviewed on:<span>28/05/2015</span></li>
                                    </ul></div>
                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed sed consectetur orci, vulputate dapibus augue. Fusce mollis tincidunt nisi, eget volutpat sem porttitor et. Maecenas non risus at sapien tincidunt mollis quis gravida enim. Pellentesque habitant morbi tristique senectus et netus et male</p>
                            </div>
                        </li>
                        <li>
                            <div class="left-panel"> 
                                <img src="../../images/review-user.jpg">
                                <div class="row">Sanskar</div>
                            </div>        
                            <div class="right-panel">
                                <h5>Good investment opportunity.</h5>
                                <div class="row">
                                    <ul>
                                        <li>Overall Rating:<span>4/5</span></li>
                                        <li>Reviewed on:<span>28/05/2015</span></li>
                                    </ul></div>
                                <p>Lorem ipsum dolor sit amet, consectetur adipiscing elit. Sed sed consectetur orci, vulputate dapibus augue. Fusce mollis tincidunt nisi, eget volutpat sem porttitor et. Maecenas non risus at sapien tincidunt mollis quis gravida enim. Pellentesque habitant morbi tristique senectus et netus et male</p>
                            </div>
                        </li>
                    </ul>

                    <div class="pagination float-right">
                        <a href="#" class="active">1</a> <a href="#">2</a> <a href="#">3</a> <a href="#">4</a> <a href="#">Next</a>
                    </div>

                </div>


                <div class="quick-links">
                    <h4>Quick Links</h4>
                    <div class="row">
                        <ul>
                            <li><a href="#">Lorem ipsum dolor </a></li>
                            <li><a href="#">Phasellus nulla lorem </a></li>
                            <li><a href="#">Donec tempus aliquam eros </a></li>
                            <li><a href="#">Donec velit ligula, bibendum </a></li>
                            <li><a href="#">Tristique sagittis purus. </a></li>
                        </ul>
                        <ul>
                            <li><a href="#">Lorem ipsum dolor </a></li>
                            <li><a href="#">Phasellus nulla lorem </a></li>
                            <li><a href="#">Donec tempus aliquam eros </a></li>
                            <li><a href="#">Donec velit ligula, bibendum </a></li>
                            <li><a href="#">Tristique sagittis purus. </a></li>
                        </ul>
                        <ul>
                            <li><a href="#">Lorem ipsum dolor </a></li>
                            <li><a href="#">Phasellus nulla lorem </a></li>
                            <li><a href="#">Donec tempus aliquam eros </a></li>
                            <li><a href="#">Donec velit ligula, bibendum </a></li>
                            <li><a href="#">Tristique sagittis purus. </a></li>
                        </ul>
                        <ul>
                            <li><a href="#">Lorem ipsum dolor </a></li>
                            <li><a href="#">Phasellus nulla lorem </a></li>
                            <li><a href="#">Donec tempus aliquam eros </a></li>
                            <li><a href="#">Donec velit ligula, bibendum </a></li>
                            <li><a href="#">Tristique sagittis purus. </a></li>
                        </ul>
                    </div>
                </div>
            </section>
            <section id="right-section">
                <div class="online_event">
                    <div class="heading4 btmrg20">Auction Details</div>
                    <div class="online-content">
                        <dl>
                            <dt>Bank</dt>
                            <dd><strong><?php echo $nodal_bank; ?></strong></dd>
                        </dl>
                        <dl>
                            <dt>Auction Type</dt>
                            <dd>Auction time frame</dd>
                        </dl>
                        <dl>
                            <dt>Auction No</dt>
                            <dd>SBI0192783723422</dd>
                        </dl>
                        <dl>
                            <dt>NIT Ref No</dt>
                            <dd><?php echo $reference_no; ?></dd>
                        </dl>
                        <dl>
                            <dt>Tender Title</dt>
                            <dd>Dhamaka offer</dd>
                        </dl>
                        <dl>
                            <dt>Tender Fee</dt>
                            <dd><strong><?php "Rs." . number_format($tender_fee, 2); ?></strong></dd>
                        </dl>
                        <dl>
                            <dt>Reserved Price</dt>
                            <dd><?php echo number_format($reserve_price, 2); ?></dd>
                        </dl>
                        <dl>
                            <dt>EMD</dt>
                            <dd><?php echo $event_type; ?></dd>
                        </dl>
                        <dl>
                            <dt>First Round Quote</dt>
                            <dd>Rs. 20 lacs</dd>
                        </dl>
                        <dl>
                            <dt>Auction Start/End Date</dt>
                            <dd><strong><?php echo date("d/m/y", strtotime($auction_pause_time)) . " to " . date("d/m/y", strtotime($auction_resume_time)) ?></strong></dd>
                        </dl>
                        <dl>
                            <dt>Bid Increment Value</dt>
                            <dd><?php "Rs." . number_format($bid_inc, 2); ?></dd>
                        </dl>
                        <dl>
                            <dt>Auto Extension Time</dt>
                            <dd><?php echo $auto_extension_time . " days" ?> </dd>
                        </dl>
                        <dl>
                            <dt>No. of Auto Extension</dt>
                            <dd><?php echo $no_of_auto_extn; ?></dd>
                        </dl>
                    </div>
                    <div class="bt_login-wrapper">
                        <input name="bid now" value="Bid Now" type="button" class="b_bidnow">
                    </div>
                </div>
                <div class="cust_support">
                    <div class="heading4 btmrg20">Customer Support</div>
                    <div class="row">
                        <ul>
                            <li class="phone">Call us on: <a>011-2345678</a></li>
                            <li class="email">Email: <a href="#">info@back-eauctions.com</a></li>
                            <li class="fax">Fax: <a>011-2345678</a></li>
                        </ul>
                    </div>
                    <a href="#" class="b_live-help">Live Help</a> </div>
                <div class="view_recent-prop">
                    <div class="heading4 btmrg20"> View Recent Properties in Your Area</div>
                    <div class="row">
                        <ul>
                            <li><a href="#">Ahmedabad <span>(10)</span></a></li>
                            <li><a href="#">Bengaluru <span>(11)</span></a></li>
                            <li><a href="#">Bhubaneswar <span>(22)</span></a></li>
                            <li><a href="#">Chandigarh <span>(19)</span></a></li>
                            <li><a href="#">Chennai <span>(7)</span></a></li>
                            <li><a href="#">Coimbatore <span>(2)</span></a></li>
                            <li><a href="#">Gaya <span>(1)</span></a></li>
                            <li><a href="#">Goa <span>(9)</span></a></li>
                            <li><a href="#">Ahmedabad <span>(10)</span></a></li>
                            <li><a href="#">Bengaluru <span>(11)</span></a></li>
                            <li><a href="#">Bhubaneswar <span>(22)</span></a></li>
                            <li><a href="#">Chandigarh <span>(19)</span></a></li>
                            <li><a href="#">Chennai <span>(7)</span></a></li>
                            <li><a href="#">Coimbatore <span>(2)</span></a></li>
                            <li><a href="#">Gaya <span>(1)</span></a></li>
                            <li><a href="#">Goa <span>(9)</span></a></li>
                        </ul>
                    </div>
                </div>
                <div class="recent-blog">
                    <div class="heading4 btmrg20">Recent Blogs</div>
                    <div class="row">
                        <ul>
                            <?php foreach ($blogs as $blogsData) { ?>
                                <li>
                                    <div class="date"><?php echo "By " . $blogsData->author . ", " . date("d F Y", strtotime($blogsData->publish_date)); ?></div>
                                    <div class="heading4"><a href="#"><span class="chat-icon"></span>Recent Press: <?php echo $blogsData->title ?></a> </div>
                                    <div class="content"><?php echo $blogsData->short_desc; ?><a href="#" class="green-more">[more...]</a></div>
                                </li>
                            <?php } ?>
                            <div class="row text-right"> <a href="#" class="green-more">More Blogs...</a> </div>
                        </ul>
                    </div>
                </div>
                <div class="subscribe_wrapper">
                    <div class="row">
                        <div class="head-txt">Stay Updated With us</div>
                    </div>
                    <div class="row">
                        <input name="" value="Enter Your Email Address" type="text" class="input">
                    </div>
                    <div class="row">
                        <input name="" value="Subscribe" type="button" class="b_get">
                    </div>
                </div>
            </section>
        </div>
    </div>
</section>
 <script>
        $(document).ready(function () {
            $('#map_canvas').hide();
            $('.view-map').click(function () {
                $('#default_img').hide();
                $('#map_canvas').show();
                $('#map_canvas').height('510');
                $('#map_canvas').gmap({'center': '28.582619,77.325123', 'zoom': 17, 'disableDefaultUI': true, 'callback': function () {
                        var self = this;
                        self.addMarker({'position': this.get('map').getCenter()}).mouseover(function () {
                            self.openInfoWindow({'content': '<b><center>afaqs!</center></b> B3, 1st Floor, Sector 4, Noida - 201301'}, this);
                        });
                    }});

            });

        });

    </script>
