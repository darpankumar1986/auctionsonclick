 <?php 
 //echo "<pre>";
// print_r($top_banks);die;
 ?>
 <div class="container-fluid container_margin">
            <div class="row row_bg">
               <div class="container">
                <div class="col-sm-12">
                    <div class="breadcrumb_main">
                        <ol class="breadcrumb">
                            <li><a href="<?php echo base_url();?>">Home</a></li>
                            <li class="active">Top Banks</li>
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
			  <h3 class="premium_service">Top Banks</h3>
			  <ul class="top_cities_list">
				  <?php 
				  if(is_array($top_banks) && count($top_banks)>0)
				  {
					foreach ($top_banks as $bank)
					  {
				  ?>
						<li><a href="<?php echo base_url();?>propertylisting?bank=<?php echo $bank->id; ?>"><?php echo $bank->name; ?></a></li>
				  <?php 
					  }
				  }
				  ?>
			  </ul>
		  </div>
	   </div>
   </div>
</div>