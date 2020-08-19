<div class="container-fluid container_margin">
            <div class="row row_bg">
               <div class="container">
                <div class="col-sm-12">
                    <div class="breadcrumb_main">
                        <ol class="breadcrumb">
                            <li><a href="<?php echo base_url();?>">Home</a></li>
                            <li class="active">Top Cities</li>
                        </ol>
<!--                        <h3>Bank Auctions in Amritsar</h3>-->
                    </div><!--breadcrumb_main-->
                </div>
            </div>
            </div><!--row-->
        </div><!--container-fluid-->
           <div class="container">
               <div class="row">
                   <div class="col-sm-12">
                      <div class="top_cities_wrap_list">
                          <h3 class="premium_service">Top Cities</h3>
                          <ul class="top_cities_list">
						  	  <?php 
							  //echo "<pre>";print_r($top_cities);die;
							  if(is_array($top_cities) && count($top_cities)>0)
							  {
								foreach ($top_cities as $key =>$city)
								  {
							  ?>
									<li><a href="<?php echo base_url();?>propertylisting?search_city=<?php echo $key; ?>"><?php echo $key.' ('.$city.')'; ?></a></li>
							  <?php 
								  }
							  }
							  ?>
						  </ul>
                      </div>
                   </div>
               </div>
           </div>