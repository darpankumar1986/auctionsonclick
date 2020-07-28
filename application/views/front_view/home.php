<link rel="stylesheet" href="<?php echo base_url(); ?>assets/css/jquery.dataTables.css" type="text/css" media="screen"/>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/front_view/js/jquery-ui.js"></script>
<script type="text/javascript" src="<?php echo base_url(); ?>assets/js/jquery.dataTables.min.js"></script>
<link rel="stylesheet" href="<?php echo base_url(); ?>css/colorbox.css" />
<link rel="stylesheet" href="<?php echo base_url(); ?>bankeauc/css/tables.css" />
<script src="<?php echo base_url(); ?>js/jquery.colorbox.js"></script>

<div class="container-fluid">
	<div class="row">
		<div class="banner-section">
			<div class="banner-img">
				<div class="banner-text">
						<div class="form-wrap">
							<h3>Find your best property &amp; Vehicles here</h3>
							<p>Buy properties &amp; Vehicles at more than 25% discount</p>
							<form class="form_desc">
								<div class="dropdown">
									<button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown">Select
										<span class="caret"></span></button>
									<ul class="dropdown-menu">
										<?php $parentCat = $this->home_model->getAllCategory(0); ?>
											<?php foreach($parentCat as $key => $parCat){ ?>
                                            <li class="dropdown-header">
											<input type="radio" id="test<?php echo $key; ?>" name="parentCat" value="<?php echo $parCat->id;?>">
                                                <label for="test<?php echo $key; ?>">All <?php echo $parCat->name; ?></label></li>
												<?php $Cats = $this->home_model->getAllCategory($parCat->id); ?>
												<?php foreach($Cats as $cat){ ?>
		                                            <li><label class="checkbox-inline"><input type="checkbox" value="<?php echo $cat->id;?>"><?php echo $cat->name; ?></label></li>
												<?php } ?>
                                           
											<?php } ?>                                            
									</ul>
								</div>
								<div class="input-group">
									<input type="text" class="form-control" placeholder="Type City" name="city_name" value="">
									<div class="input-group-btn search_btn">
										<button class="btn btn-default" type="submit">
											<i class="fa fa-search"></i> Auctions
										</button>
									</div>
								</div>
							</form>
						</div>
				</div><!--banner-text-->
			</div><!--banner-img-->
		</div><!--banner-section-->
	</div><!--row-->
	<div class="row benefits_section">
		<div class="container">
			<div class="row">
				<div class="col-sm-12">
					<h3 class="auction_heading">Benefits of buying through Bank Auction</h3>
				</div>
			</div><!--row-->
			<div class="row">
				<div class="col-sm-2">
					<div class="benefit_box">
						<div class="benefit_img">
							<img src="<?php echo base_url(); ?>assets/auctiononclick/images/benefits_icon/price_icon.png">
						</div><!--benefit_img-->
						<div class="box_desc">
							<h4>Price Advantage</h4>
							<p>Bank Auction properties are approximately 25% cheaper than market price.</p>
						</div><!--box_desc-->
					</div><!--benefit_box-->
				</div>
				<div class="col-sm-2">
					<div class="benefit_box">
						<div class="benefit_img">
							<img src="<?php echo base_url(); ?>assets/auctiononclick/images/benefits_icon/legally_icon.png">
						</div><!--benefit_img-->
						<div class="box_desc">
							<h4>Legally Safe</h4>
							<p>Banks / Financial Institutions apprve loans after verification of all the legal aspects only, Bank Auction auctions are legally safe and fall user the SARFAESI Act and DRT Act.</p>
						</div><!--box_desc-->
					</div><!--benefit_box-->
				</div>
				<div class="col-sm-2">
					<div class="benefit_box">
						<div class="benefit_img">
							<img src="<?php echo base_url(); ?>assets/auctiononclick/images/benefits_icon/credibility_icon.png">
						</div><!--benefit_img-->
						<div class="box_desc">
							<h4>Credibility</h4>
							<p>You are buying from a Bank / Financial institution, which is authorized by Govt of India to sell such properties.</p>
						</div><!--box_desc-->
					</div><!--benefit_box-->
				</div>
				<div class="col-sm-2">
					<div class="benefit_box">
						<div class="benefit_img">
							<img src="<?php echo base_url(); ?>assets/auctiononclick/images/benefits_icon/time_icon.png">
						</div><!--benefit_img-->
						<div class="box_desc">
							<h4>Time</h4>
							<p>Entire transaction will be over in less than two months period. Ownership will be transferred in one month.</p>
						</div><!--box_desc-->
					</div><!--benefit_box-->
				</div>
				<div class="col-sm-2">
					<div class="benefit_box">
						<div class="benefit_img">
							<img src="<?php echo base_url(); ?>assets/auctiononclick/images/benefits_icon/transparency_icon.png">
						</div><!--benefit_img-->
						<div class="box_desc">
							<h4>Transparency</h4>
							<p>100 % transparent transaction.</p>
						</div><!--box_desc-->
					</div><!--benefit_box-->
				</div>
			</div><!--row-->
		</div><!--container-->
	</div><!--row-->
</div><!--container-fluid-->